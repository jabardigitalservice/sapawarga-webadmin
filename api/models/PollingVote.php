<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "polling_votes".
 *
 * @property int $id
 * @property int $polling_id
 * @property int $answer_id
 * @property int $user_id
 */
class PollingVote extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polling_votes';
    }

    public function getPolling()
    {
        return $this->hasOne(Polling::class, ['id' => 'polling_id']);
    }

    public function getAnswer()
    {
        return $this->hasOne(PollingAnswer::class, ['id' => 'answer_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['polling_id', 'answer_id', 'user_id'], 'required',
            ],
        ];
    }

    public function fields()
    {
        $fields = [
            'id',
            'polling_id',
            'answer_id',
            'user_id',
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
