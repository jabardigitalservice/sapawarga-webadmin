<?php

namespace app\models\category;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property array $meta
 * @property int $status
 */
class Category extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function instantiate($row)
    {
        switch ($row['type']) {
            case PhoneBookCategory::TYPE:
                return new PhoneBookCategory();
            case BroadcastCategory::TYPE:
                return new BroadcastCategory();
            default:
            return new self;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'string', 'max' => 64],
            [['type', 'name'], 'trim'],
            [['name', 'meta'], 'safe'],
            [['type', 'name', 'status'], 'required'],
            ['name', 'validateName'],
            ['status', 'integer'],
        ];
    }

    public function fields()
    {
        $fields = [
            'id',
            'type',
            'name',
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
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'meta' => 'Meta',
            'status' => 'Status',
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
        ];
    }

    /**
     * Checks if category name has been taken
     *
     * @param $attribute
     * @param $params
     */
    public function validateName($attribute, $params)
    {
        // get post type - POST or PUT
        $request = Yii::$app->request;

        if ($request->isPost || $request->isPut) {
            $existingName = Category::find()
                ->where(['name' => $this->$attribute])
                ->andWhere(['type' => $this->type]);
            if ($request->isPut) {
                $existingName->andWhere(['!=', 'id', $this->id]);
            }
            $existingName = $existingName->count();

            if ($existingName > 0) {
                $this->addError($attribute, Yii::t('app', 'error.category.taken'));
            }
        } else {
            // unknown request
            $this->addError($attribute, Yii::t('app', 'Unknown request'));
        }
    }
}
