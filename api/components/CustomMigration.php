<?php

namespace app\helpers;

use yii\db\Migration;

class CustomMigration extends Migration
{
    public function timestamps($tableName)
    {
        $this->addColumn(
            $tableName,
            'created_at',
            $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        );

        $this->addColumn(
            $tableName,
            'updated_at',
            $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP')
        );
    }
}
