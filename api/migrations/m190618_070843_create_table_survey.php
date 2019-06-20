<?php

use app\components\CustomMigration;

/**
 * Class m190618_070843_create_table_survey */
class m190618_070843_create_table_survey extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('survey', [
            'id'           => $this->primaryKey(),
            'category_id'  => $this->integer()->null(),
            'title'        => $this->string()->null(),
            'external_url' => $this->string()->null(),
            'kabkota_id'   => $this->integer()->null(),
            'kec_id'       => $this->integer()->null(),
            'kel_id'       => $this->integer()->null(),
            'rw'           => $this->string()->null(),
            'start_date'   => $this->date()->null(),
            'end_date'     => $this->date()->null(),
            'meta'         => $this->json()->null(),
            'status'       => $this->integer()->null(),
            'created_at'   => $this->integer()->null(),
            'updated_at'   => $this->integer()->null(),
        ]);

        $this->addForeignKey(
            'fk-survey-category_id',
            'survey',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('survey');
    }
}
