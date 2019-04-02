<?php

use yii\db\Migration;

class m190328_063005_create_phonebooks_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('phonebooks', [
            'id'               => $this->primaryKey(),
            'name'             => $this->string()->null(),
            'description'      => $this->string()->null(),
            'address'          => $this->string()->null(),
            'phone_numbers'    => $this->json()->null(),
            'kabkota_id'       => $this->integer()->null(),
            'kec_id'           => $this->integer()->null(),
            'kel_id'           => $this->integer()->null(),
            'latitude'         => $this->string()->null(),
            'longitude'        => $this->string()->null(),
            'seq'              => $this->integer()->null(),
            'cover_image_path' => $this->string()->null(),
            'meta'             => $this->json()->null(),
            'status'           => $this->integer()->null(),
            'created_at'       => $this->integer()->null(),
            'updated_at'       => $this->integer()->null(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('phonebooks');
    }
}
