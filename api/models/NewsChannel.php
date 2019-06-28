<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "news_channels".
 *
 * @property int $id
 * @property string $name
 * @property string $website
 * @property string $icon_url
 * @property array $meta
 * @property int $status
 */
class NewsChannel extends ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_channels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
            [['name', 'website', 'icon_url'], 'trim'],
            [['name', 'website', 'icon_url'], 'safe'],

            [['name', 'status'], 'required'],

            ['status', 'integer'],
        ];
    }

    public function fields()
    {
        $fields = [
            'id',
            'name',
            'icon_url',
            'website',
            'meta',
            'status',
            'status_label' => $this->getStatusLabel(),
            'created_at',
            'updated_at',
        ];

        return $fields;
    }

    protected function getStatusLabel()
    {
        $statusLabel = '';

        switch ($this->status) {
            case self::STATUS_ACTIVE:
                $statusLabel = Yii::t('app', 'status.active');
                break;
            case self::STATUS_DISABLED:
                $statusLabel = Yii::t('app', 'status.inactive');
                break;
            case self::STATUS_DELETED:
                $statusLabel = Yii::t('app', 'status.deleted');
                break;
        }

        return $statusLabel;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'website'  => 'Website',
            'icon_url' => 'Icon URL',
            'name'     => 'Name',
            'meta'     => 'Meta',
            'status'   => 'Status',
        ];
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => time(),
            ],
            BlameableBehavior::class,
        ];
    }
}
