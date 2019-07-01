<?php

namespace app\models;

use app\validator\InputCleanValidator;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $cover_path
 * @property string $source_url
 * @property string $source_date
 * @property string $content
 * @property string $featured
 * @property string $channel_id
 * @property array $meta
 * @property int $seq
 * @property int $status
 */
class News extends ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    const META_DEFAULT = [
        'read_count' => 0,
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'string', 'max' => 100],
            ['title', 'string', 'min' => 10],
            ['title', InputCleanValidator::class],

            [['title', 'cover_path', 'source_url', 'source_date', 'content'], 'trim'],
            [['title', 'content', 'cover_path', 'source_url'], 'safe'],

            [
                ['title', 'channel_id', 'cover_path', 'source_url', 'source_date', 'content', 'featured', 'status'],
                'required',
            ],

            ['content', 'string', 'max' => 5000],

            ['source_date', 'date', 'format' => 'php:Y-m-d'],
            ['source_url', 'url'],

            ['meta', 'default'],

            ['featured', 'boolean'],

            ['channel_id', 'integer'],
            ['status', 'integer'],
            ['seq', 'integer'],

            ['status', 'in', 'range' => [-1, 0, 10]],
        ];
    }

    public function fields()
    {
        $fields = [
            'id',
            'title',
            'meta',
            'status',
            'status_label' => function () {
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
            'id'          => 'ID',
            'title'       => 'Sumber',
            'channel_id'  => 'Website',
            'cover_path'  => 'Cover Path',
            'source_date' => 'Tanggal Berita',
            'source_url'  => 'URL Berita',
            'contet'      => 'Konten Berita',
            'featured'    => 'Berita Pilihan',
            'meta'        => 'Meta',
            'status'      => 'Status',
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
            [
                'class'     => SluggableBehavior::class,
                'attribute' => 'title',
            ],
            BlameableBehavior::class,
        ];
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) { // Model is created
            $this->meta = [
                'read_count' => 0
            ];
        }
        
        return parent::beforeSave($insert);
    }
}
