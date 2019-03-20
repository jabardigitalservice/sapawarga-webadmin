<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cities`.
 */
class m190319_085306_create_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cities', [
            'id'        => $this->primaryKey(),
            'parent_id' => $this->integer()->null(),
            'lft'       => $this->integer()->null(),
            'rgt'       => $this->integer()->null(),
            'depth'     => $this->integer()->null(),
            'name'      => $this->string()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cities');
    }
}
