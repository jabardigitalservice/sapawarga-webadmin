<?php

use yii\db\Migration;
use yii\db\Schema;

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
            'id'         => $this->primaryKey(),
            'parent_id'  => $this->integer()->null(),
            'depth'      => $this->integer()->null(),
            'name'       => $this->string()->null(),
            'code1'      => $this->string()->null(),
            'code2'      => $this->string()->null(),
            'latitude'   => $this->string()->null(),
            'longitude'  => $this->string()->null(),
            'meta'       => $this->json()->null(),
            'status'     => $this->boolean(),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $sql = file_get_contents(__DIR__ . '/seeder/jawabarat_kabkota_20190320.sql');
        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cities');
    }
}
