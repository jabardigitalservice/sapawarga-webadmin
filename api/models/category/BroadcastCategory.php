<?php

namespace app\models\category;

use Yii;

/**
 * This is a child class of model Category, representing categories used by Broadcast model
 */
class BroadcastCategory extends Category
{
    const TYPE = 'broadcast';

    public function init()
    {
        $this->type = self::TYPE;
        parent::init();
    }

    public static function find()
    {
        return new CategoryQuery(get_called_class(), ['type' => self::TYPE, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        $this->type = self::TYPE;
        return parent::beforeSave($insert);
    }
}
