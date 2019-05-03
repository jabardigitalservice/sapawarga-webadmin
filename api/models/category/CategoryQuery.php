<?php

namespace app\models\category;

use Yii;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    public $type;
    public $tableName;

    public function prepare($builder)
    {
        if ($this->type !== null) {
            $this->andWhere(["$this->tableName.type" => $this->type]);
        }
        return parent::prepare($builder);
    }
}
