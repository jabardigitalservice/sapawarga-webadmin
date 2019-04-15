<?php

use yii\db\Migration;

/**
 * Handles the creation of table `phonebooks_categories`.
 */
class m190411_065809_create_phonebooks_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('phonebooks_categories', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string()->null(),
            'meta'       => $this->json()->null(),
            'status'     => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('phonebooks_categories');
    }
}
