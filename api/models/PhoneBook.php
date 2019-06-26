<?php

namespace app\models;

use Jdsteam\Sapawarga\Behaviors\AreaBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "phonebooks".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $description
 * @property mixed $phone_numbers
 * @property int $category_id
 * @property int $kabkota_id
 * @property int $kec_id
 * @property int $kel_id
 * @property string $latitude
 * @property string $longitude
 * @property int $seq
 * @property string $cover_image_path
 * @property mixed $meta
 * @property int $status
 */
class PhoneBook extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phonebooks';
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
            ['name', 'string', 'max' => 64],

            [['name', 'address', 'description'], 'trim'],
            [['address', 'description', 'latitude', 'longitude', 'cover_image_path', 'meta'], 'default'],

            [['name', 'category_id', 'phone_numbers', 'seq', 'status'], 'required'],
            [['category_id', 'kabkota_id', 'kec_id', 'kel_id', 'seq'], 'integer'],
        ];
    }

    public function fields()
    {
        $bucket = Yii::$app->fileStorage->getBucket('imageFiles');

        $fields = [
            'id',
            'name',
            'category_id',
            'category',
            'address',
            'description',
            'phone_numbers',
            'kabkota_id',
            'kabkota' => function () {
                return [
                    'id'   => optional($this->kabkota)->id,
                    'name' => optional($this->kabkota)->name,
                ];
            },
            'kec_id',
            'kecamatan' => function () {
                return [
                    'id'   => optional($this->kecamatan)->id,
                    'name' => optional($this->kecamatan)->name,
                ];
            },
            'kel_id',
            'kelurahan' => function () {
                return [
                    'id'   => optional($this->kelurahan)->id,
                    'name' => optional($this->kelurahan)->name,
                ];
            },
            'latitude',
            'longitude',
            'seq',
            'cover_image_path',
            'cover_image_url' => function () use ($bucket) {
                return $this->cover_image_path ? $bucket->getFileUrl($this->cover_image_path) : null;
            },
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
            'id'   => 'ID',
            'name' => 'Nama',
        ];
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
            [
                'class'  => AreaBehavior::class,
                'withRw' => false,
            ],
        ];
    }
}
