<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "areas".
 *
 * @property int $id
 * @property string $brand
 * @property string $model
 */
class Area extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 64],
            [['name', 'code_bps', 'code_kemendagri', 'latitude', 'longitude', 'meta'], 'trim'],
            [['parent_id', 'depth', 'name', 'code_bps', 'code_kemendagri', 'status'], 'required'],
        ];
    }

    public function fields()
    {
        $fields = [
            'id',
            'parent_id',
            'depth',
            'name',
            'code_bps',
            'code_kemendagri',
            'latitude',
            'longitude',
            'meta',
            'status',
            'status_label' => function () {
                $statusLabel = '';
                switch ($this->status) {
                    case self::STATUS_ACTIVE:
                        $statusLabel = Yii::t('app', 'Active');
                        break;
                    case self::STATUS_INACTIVE:
                        $statusLabel = Yii::t('app', 'Not Active');
                        break;
                }
                return $statusLabel;
            },
            'created_at',
            'updated_at',
        ];

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Nama',
        ];
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time()
            ]
        ];
    }
}
