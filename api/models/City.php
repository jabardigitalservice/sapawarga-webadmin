<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "guitar".
 *
 * @property int $id
 * @property string $brand
 * @property string $model
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 64],
            ['name', 'trim'],
            ['name', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nama',
        ];
    }
}
