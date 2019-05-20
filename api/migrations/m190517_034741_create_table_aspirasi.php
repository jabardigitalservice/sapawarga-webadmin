<?php

use app\components\CustomMigration;

/**
 * Class m190517_034741_create_table_aspirasi */
class m190517_034741_create_table_aspirasi extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('aspirasi', [
            'id'          => $this->primaryKey(),
            'author_id'   => $this->integer()->null(),
            'category_id' => $this->integer()->null(),
            'title'       => $this->string()->null(),
            'description' => $this->text()->null(),
            'kabkota_id'  => $this->integer()->null(),
            'kec_id'      => $this->integer()->null(),
            'kel_id'      => $this->integer()->null(),
            'rw'          => $this->string()->null(),
            'attachments' => $this->json()->null(),
            'meta'        => $this->json()->null(),
            'status'      => $this->integer()->null(),
            'created_at'  => $this->integer()->null(),
            'updated_at'  => $this->integer()->null(),
        ]);

        $this->createTable('aspirasi_likes', [
            'aspirasi_id' => $this->integer(),
            'user_id'     => $this->integer(),
        ]);

        $this->addPrimaryKey('aspirasi_likes-pk', 'aspirasi_likes', ['aspirasi_id', 'user_id']);

        $this->addForeignKey(
            'fk-aspirasi-author_id',
            'aspirasi',
            'author_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-aspirasi-category_id',
            'aspirasi',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-aspirasi_likes-aspirasi_id',
            'aspirasi_likes',
            'aspirasi_id',
            'aspirasi',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-aspirasi_likes-user_id',
            'aspirasi_likes',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('aspirasi_likes');
        $this->dropTable('aspirasi');
    }
}
