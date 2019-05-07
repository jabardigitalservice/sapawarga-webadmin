<?php

use yii\db\Migration;

/**
 * Handles the creation of table `broadcasts`.
 */
class m190507_022903_create_broadcasts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('broadcasts', [
            'id'               => $this->primaryKey(),
            'author_id'        => $this->integer()->null(),
            'category_id'      => $this->integer()->null(),
            'title'            => $this->string()->null(),
            'description'      => $this->text()->null(),
            'kabkota_id'       => $this->integer()->null(),
            'kec_id'           => $this->integer()->null(),
            'kel_id'           => $this->integer()->null(),
            'rw'               => $this->string()->null(),
            'meta'             => $this->json()->null(),
            'status'           => $this->integer()->null(),
            'created_at'       => $this->integer()->null(),
            'updated_at'       => $this->integer()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('broadcasts');
    }
}
