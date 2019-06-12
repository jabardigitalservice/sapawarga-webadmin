<?php

use app\components\CustomMigration;

/**
 * Class m190612_065226_create_table_polling */
class m190612_065226_create_table_polling extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('polling', [
            'id'          => $this->primaryKey(),
            'category_id' => $this->integer()->null(),
            'name'        => $this->string()->null(),
            'description' => $this->text()->null(),
            'excerpt'     => $this->string()->null(),
            'question'    => $this->string()->null(),
            'kabkota_id'  => $this->integer()->null(),
            'kec_id'      => $this->integer()->null(),
            'kel_id'      => $this->integer()->null(),
            'rw'          => $this->string()->null(),
            'start_date'  => $this->date()->null(),
            'end_date'    => $this->date()->null(),
            'meta'        => $this->json()->null(),
            'status'      => $this->integer()->null(),
            'created_at'  => $this->integer()->null(),
            'updated_at'  => $this->integer()->null(),
        ]);

        $this->createTable('polling_answers', [
            'id'         => $this->primaryKey(),
            'polling_id' => $this->integer(),
            'body'       => $this->string()->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);

        $this->createTable('polling_votes', [
            'id'          => $this->primaryKey(),
            'polling_id'  => $this->integer(),
            'answer_id'   => $this->integer(),
            'user_id'     => $this->integer(),
            'created_at'  => $this->integer()->null(),
            'updated_at'  => $this->integer()->null(),
        ]);

        $this->addForeignKey(
            'fk-polling_answers-polling_id',
            'polling_answers',
            'polling_id',
            'polling',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-polling_votes-polling_id',
            'polling_votes',
            'polling_id',
            'polling',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-polling_votes-answer_id',
            'polling_votes',
            'answer_id',
            'polling_answers',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-polling_votes-user_id',
            'polling_votes',
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
        $this->dropTable('polling_votes');
        $this->dropTable('polling_answers');
        $this->dropTable('polling');
    }
}
