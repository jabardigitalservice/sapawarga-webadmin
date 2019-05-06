<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories` and deletion of table `phonebooks_categories`.
 */
class m190503_081749_create_categories_table_and_delete_phonebook_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id'         => $this->primaryKey(),
            'type'       => $this->string()->null(),
            'name'       => $this->string()->null(),
            'meta'       => $this->json()->null(),
            'status'     => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);

        $this->dropTable('phonebooks_categories');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('phonebooks_categories', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string()->null(),
            'meta'       => $this->json()->null(),
            'status'     => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);

        $this->dropTable('categories');
    }
}
