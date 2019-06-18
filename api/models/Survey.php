<?php

namespace app\models;

use app\validator\InputCleanValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "survey".
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $external_url
 * @property int $kabkota_id
 * @property int $kec_id
 * @property int $kel_id
 * @property string $rw
 * @property mixed $meta
 * @property int $status
 */
class Survey extends ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 10;

    const CATEGORY_TYPE = 'survey';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'survey';
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
            [['title', 'status', 'external_url', 'category_id'], 'required'],

            ['status', 'in', 'range' => [-1, 0, 10]],
        ];
    }

    public function fields()
    {
        $fields = [
            'id',
            'category_id',
            'category'     => function () {
                return [
                    'id'   => $this->category->id,
                    'name' => $this->category->name,
                ];
            },
            'title',
            'external_url',
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
