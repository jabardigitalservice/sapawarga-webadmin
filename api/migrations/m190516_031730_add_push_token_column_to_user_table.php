<?php

use yii\db\Migration;

/**
 * Handles adding push_token to table `{{%user}}`.
 */
class m190516_031730_add_push_token_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'push_token', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'push_token');
    }
}
