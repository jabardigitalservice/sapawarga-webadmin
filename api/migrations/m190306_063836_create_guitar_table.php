<?php

use yii\db\Migration;

/**
 * Handles the creation of table `guitar`.
 */
class m190306_063836_create_guitar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('guitar', [
            'id' => $this->primaryKey(),
            'brand' => $this->string()->notNull(),
            'model' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('guitar');
    }
}
