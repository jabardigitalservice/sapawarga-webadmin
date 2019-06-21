<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\components\ModelHelper;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $author_id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property int $kabkota_id
 * @property int $kec_id
 * @property int $kel_id
 * @property string $rw
 * @property mixed $meta
 * @property int $status
 */
class Notification extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 10;

    const CATEGORY_TYPE = 'notification';

    const CATEGORY_LABEL_SURVEY = 'Survey Terbaru';
    const CATEGORY_LABEL_POLLING = 'Polling Terbaru';
    const CATEGORY_LABEL_UPDATE = 'Update Aplikasi';
    

    // Memetakan category name dengan target name
    const TARGET_MAP = [
        self::CATEGORY_LABEL_SURVEY     => 'notifikasi',
        self::CATEGORY_LABEL_POLLING    => 'notifikasi',
        self::CATEGORY_LABEL_UPDATE     => 'url',
    ];

    const URL_STORE_ANDROID = 'https://play.google.com/store/apps/details?id=com.sapawarga.jds';

    /** @var  array push notification metadata */
    public $data;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getKelurahan()
    {
        return $this->hasOne(Area::className(), ['id' => 'kel_id']);
    }

    public function getKecamatan()
    {
        return $this->hasOne(Area::className(), ['id' => 'kec_id']);
    }

    public function getKabkota()
    {
        return $this->hasOne(Area::className(), ['id' => 'kabkota_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['title', 'description', 'rw', 'meta'], 'trim'],
            ['title', 'string', 'max' => 255],
            ['rw', 'string', 'length' => 3],
            [
                'rw',
                'match',
                'pattern' => '/^[0-9]{3}$/',
                'message' => Yii::t('app', 'error.rw.pattern')
            ],
            ['rw', 'default'],
            [['author_id', 'category_id', 'kabkota_id', 'kec_id', 'kel_id', 'status'], 'integer'],
            ['category_id', 'validateCategoryID'],
            ['meta', 'default'],
        ];
    }

    public function fields()
    {
        $fields = [];
        $user = User::findIdentity(Yii::$app->user->getId());
        
        if ($user->role <= User::ROLE_STAFF_RW) {
            $fields = [
                'id',
                'title',
                'target' => function () {
                    return self::TARGET_MAP[$this->category->name];
                },
                'meta',
                'push_notification' => function () {
                    return true;
                }
            ];
        } else {
            $fields = [
                'id',
                'author_id',
                'author' => function () {
                    return [
                        'id'            => $this->author->id,
                        'name'          => $this->author->name,
                        'role_label'    => $this->author->getRoleLabel(),
                    ];
                },
                'category_id',
                'category' => function () {
                    return [
                        'id'   => $this->category->id,
                        'name' => $this->category->name,
                    ];
                },
                'title',
                'description',
                'kabkota_id',
                'kabkota' => function () {
                    if ($this->kabkota) {
                        return [
                            'id'   => $this->kabkota->id,
                            'name' => $this->kabkota->name,
                        ];
                    } else {
                        return null;
                    }
                },
                'kec_id',
                'kecamatan' => function () {
                    if ($this->kecamatan) {
                        return [
                            'id'   => $this->kecamatan->id,
                            'name' => $this->kecamatan->name,
                        ];
                    } else {
                        return null;
                    }
                },
                'kel_id',
                'kelurahan' => function () {
                    if ($this->kelurahan) {
                        return [
                            'id'   => $this->kelurahan->id,
                            'name' => $this->kelurahan->name,
                        ];
                    } else {
                        return null;
                    }
                },
                'rw',
                'status',
                'status_label' => function () {
                    $statusLabel = '';
                    switch ($this->status) {
                        case self::STATUS_PUBLISHED:
                            $statusLabel = Yii::t('app', 'status.published');
                            break;
                        case self::STATUS_DRAFT:
                            $statusLabel = Yii::t('app', 'status.draft');
                            break;
                        case self::STATUS_DELETED:
                            $statusLabel = Yii::t('app', 'status.deleted');
                            break;
                    }
                    return $statusLabel;
                },
                'data' => function () {
                    return $this->data;
                },
                'created_at',
                'updated_at',
            ];
        }

        return $fields;
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => time(),
            ],
        ];
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        $this->author_id = Yii::$app->user->getId();

        // Add meta for 'Update Apikasi' Notification category
        if ($this->category->name == self::CATEGORY_LABEL_UPDATE) {
            $this->meta = [
                'target'    => 'url',
                'url'       => self::URL_STORE_ANDROID,
            ];
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!YII_ENV_TEST) {
            $isSendNotification = ModelHelper::isSendNotification($insert, $changedAttributes, $this);

            if ($isSendNotification) {
                $this->data = $this->generateData();
                // By default,  send notification to all users
                $topic = 'all';
                if ($this->kel_id && $this->rw) {
                    $topic = "{$this->kel_id}_{$this->rw}";
                } elseif ($this->kel_id) {
                    $topic = (string) $this->kel_id;
                } elseif ($this->kec_id) {
                    $topic = (string) $this->kec_id;
                } elseif ($this->kabkota_id) {
                    $topic = (string) $this->kabkota_id;
                }

                $notifModel = new Message();
                $notifModel->setAttributes([
                    'title'         => $this->title,
                    'description'   => $this->description,
                    'data'          => $this->data,
                    'topic'         => $topic,
                ]);
                $notifModel->send();
            }
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Checks if category type is notification
     *
     * @param $attribute
     * @param $params
     */
    public function validateCategoryID($attribute, $params)
    {
        ModelHelper::validateCategoryID($this, $attribute);
    }

    protected function generateData()
    {
        $notif_meta = null;
        if ($this->category->name == self::CATEGORY_LABEL_UPDATE) {
            $notif_meta = [
                'target'    => 'url',
                'url'       => self::URL_STORE_ANDROID,
            ];
        } else {
            $notif_meta = $this->meta;
        }

        $data = [
            'push_notification' => true,
            'title'             => $this->title,
            'target'            => self::TARGET_MAP[$this->category->name],
            'meta'              => $notif_meta,
        ];
        return $data;
    }
}
