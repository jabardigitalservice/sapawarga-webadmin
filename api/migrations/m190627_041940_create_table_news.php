<?php

use app\components\CustomMigration;

/**
 * Class m190627_041940_create_table_news */
class m190627_041940_create_table_news extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news_channels', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string()->null(),
            'website'    => $this->string()->null(),
            'icon_url'   => $this->string()->null(),
            'meta'       => $this->json()->null(),
            'status'     => $this->integer()->null(),
            'created_at' => $this->integer()->null(),
            'created_by' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
            'updated_by' => $this->integer()->null(),
        ]);

        $this->createTable('news', [
            'id'          => $this->primaryKey(),
            'channel_id' => $this->integer()->null(),
            'title'       => $this->string()->null(),
            'slug'        => $this->string()->null(),
            'cover_path'  => $this->string()->null(),
            'source_url'  => $this->string()->null(),
            'source_date' => $this->date()->null(),
            'content'     => $this->text()->null(),
            'featured'    => $this->boolean()->null(),
            'meta'        => $this->json()->null(),
            'status'      => $this->integer()->null(),
            'created_at'  => $this->integer()->null(),
            'created_by'  => $this->integer()->null(),
            'updated_at'  => $this->integer()->null(),
            'updated_by'  => $this->integer()->null(),
        ]);

        $this->addForeignKey(
            'fk-news-channel_id',
            'news',
            'channel_id',
            'news_channels',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news_channels');
        $this->dropTable('news');
    }
}
