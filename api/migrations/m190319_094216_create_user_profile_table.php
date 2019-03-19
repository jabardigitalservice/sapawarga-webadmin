<?php

use yii\db\Migration;

/**
 * Class m190319_094216_add_user_profile_table
 */
class m190319_094216_create_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_profile', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
            'telepon' => $this->string(),
            'alamat' => $this->string(),
            'rw' => $this->string()->notNull(),
            'kel_id' => $this->string()->notNull(),
            'kec_id' => $this->string()->notNull(),
            'kab_id' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropTable('user_profile');
    }
}
