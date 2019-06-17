<?php

namespace app\models;

use app\validator\InputCleanValidator;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "polling".
 *
 * @property int $id
 * @property int $polling_id
 * @property string $body
 */
class PollingAnswer extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polling_answers';
    }

    public function getPolling()
    {
        return $this->hasOne(Polling::class, ['id' => 'polling_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['polling_id', 'body'], 'required',
            ],
        ];
    }

    public function fields()
    {
        $fields = [
            'id',
            'body',
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
}
