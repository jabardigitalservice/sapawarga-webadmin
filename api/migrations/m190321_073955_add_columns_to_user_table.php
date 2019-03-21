<?php

use app\components\CustomMigration;

/**
 * Class m190321_073955_add_columns_to_user_table */
class m190321_073955_add_columns_to_user_table extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'name', $this->string()->notNull());
        $this->addColumn('user', 'phone', $this->string());
        $this->addColumn('user', 'address', $this->string());
        $this->addColumn('user', 'rw', $this->string()->notNull());
        $this->addColumn('user', 'kel_id', $this->string()->notNull());
        $this->addColumn('user', 'kec_id', $this->string()->notNull());
        $this->addColumn('user', 'kabkota_id', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'kabkota_id');
        $this->dropColumn('user', 'kec_id');
        $this->dropColumn('user', 'kel_id');
        $this->dropColumn('user', 'rw');
        $this->dropColumn('user', 'address');
        $this->dropColumn('user', 'phone');
        $this->dropColumn('user', 'name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190321_073955_add_columns_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
