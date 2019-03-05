<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guitar".
 *
 * @property int $id
 * @property string $brand
 * @property string $model
 */
class Guitar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'guitar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand', 'model'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand' => 'Brand',
            'model' => 'Model',
        ];
    }
}
