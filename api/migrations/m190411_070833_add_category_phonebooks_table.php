<?php

use app\components\CustomMigration;

/**
 * Class m190411_070833_add_category_phonebooks_table */
class m190411_070833_add_category_phonebooks_table extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('phonebooks', 'category_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('phonebooks', 'category_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190411_070833_add_category_phonebooks_table cannot be reverted.\n";

        return false;
    }
    */
}
