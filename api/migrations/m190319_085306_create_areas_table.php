<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `areas`.
 */
class m190319_085306_create_areas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('areas', [
            'id'         => $this->primaryKey(),
            'parent_id'  => $this->integer()->null(),
            'depth'      => $this->integer()->null(),
            'name'       => $this->string()->null(),
            'code_bps'   => $this->string()->null(),
            'code_kemendagri' => $this->string()->null(),
            'latitude'   => $this->string()->null(),
            'longitude'  => $this->string()->null(),
            'meta'       => $this->json()->null(),
            'status'     => $this->boolean(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);

        $sql = file_get_contents(__DIR__ . '/seeder/jawabarat_kabkota_20190320.sql');
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('areas');
    }
}
