<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\validator\InputCleanValidator;
use app\validator\IsArrayValidator;

/**
 * This is the model class for table "aspirasi".
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
 * @property mixed $attachments
 * @property mixed $meta
 * @property int $status
 */
class Aspirasi extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DRAFT = 0;
    const STATUS_APPROVAL_PENDING = 5;
    const STATUS_APPROVAL_REJECTED = 3;
    const STATUS_PUBLISHED = 10;

    const CATEGORY_TYPE = 'aspirasi';

    const SCENARIO_USER_CREATE = 'user-create';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aspirasi';
    }

    public function getLikes()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('aspirasi_likes', ['aspirasi_id' => 'id']);
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

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['title', 'description', 'kabkota_id', 'kec_id', 'kel_id', 'author_id', 'category_id', 'status'],
                'required',
            ],
            [['title', 'description', 'rw', 'meta'], 'trim'],
            ['title', 'string', 'max' => 255],
            ['title', 'string', 'min' => 5],
            ['title', InputCleanValidator::class],
            ['description', 'string', 'max' => 1024 * 3],
            ['description', 'string', 'min' => 5],
            ['description', InputCleanValidator::class],
            [
                'rw',
                'match',
                'pattern' => '/^[0-9]{3}$/',
                'message' => Yii::t('app', 'error.rw.pattern'),
            ],
            ['rw', 'default'],
            ['attachments', 'default'],
            ['attachments', IsArrayValidator::class],
            [['author_id', 'category_id', 'kabkota_id', 'kec_id', 'kel_id', 'status'], 'integer'],
            ['meta', 'default'],
        ];
    }

    public function fields()
    {
        $fields = [
            'id',
            'author_id',
            'author'       => function () {
                return [
                    'id'         => $this->author->id,
                    'name'       => $this->author->name,
                    'role_label' => $this->author->getRoleLabel(),
                ];
            },
            'category_id',
            'category'     => function () {
                return [
                    'id'   => $this->category->id,
                    'name' => $this->category->name,
                ];
            },
            'title',
            'description',
            'kabkota_id',
            'kabkota'      => function () {
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
            'kecamatan'    => function () {
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
            'kelurahan'    => function () {
                if ($this->kelurahan) {
                    return [
                        'id'   => $this->kelurahan->id,
                        'name' => $this->kelurahan->name,
                    ];
                } else {
                    return null;
                }
            },
            'likes_count' => function () {
                return (int) $this->getLikes()->count();
            },
            'likes_users' => function () {
                // @TODO too many callback function
                return array_map(function ($item) {
                    return [
                        'id'   => $item->id,
                        'name' => $item->name,
                    ];
                }, $this->likes);
            },
            'rw',
            'meta',
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
                    case self::STATUS_APPROVAL_PENDING:
                        $statusLabel = Yii::t('app', 'status.approval-pending');
                        break;
                    case self::STATUS_APPROVAL_REJECTED:
                        $statusLabel = Yii::t('app', 'status.approval-rejected');
                        break;
                }
                return $statusLabel;
            },
            'created_at',
            'updated_at',
        ];

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

        return parent::beforeSave($insert);
    }

    /**
     * Checks if category_id is current user's id
     *
     * @param $attribute
     * @param $params
     */
    public function validateCategoryID($attribute, $params)
    {
        $request = Yii::$app->request;

        if ($request->isPost || $request->isPut) {
            $category_id = Category::find()
                ->where(['id' => $this->$attribute])
                ->andWhere(['type' => self::CATEGORY_TYPE]);

            if ($category_id->count() <= 0) {
                $this->addError($attribute, Yii::t('app', 'error.id.invalid'));
            }
        }
    }
}
