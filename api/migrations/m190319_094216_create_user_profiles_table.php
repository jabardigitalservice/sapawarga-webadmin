<?php

use app\helpers\MigrationHelper;

/**
 * Class m190319_094216_add_user_profile_table
 */
class m190319_094216_create_user_profiles_table extends MigrationHelper
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_profiles', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string(),
            'address' => $this->string(),
            'rw' => $this->string()->notNull(),
            'kel_id' => $this->integer()->notNull(),
            'kec_id' => $this->integer()->notNull(),
            'kokab_id' => $this->integer()->notNull(),
        ]);

        $this->timestamps('user_profiles');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_profiles');
    }
}
