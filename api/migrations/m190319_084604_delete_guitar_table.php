<?php

use yii\db\Migration;

/**
 * Handles the deletion of boilerplate table `guitar`.
 */
class m190319_084604_delete_guitar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('guitar');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('guitar', [
            'id' => $this->primaryKey(),
            'brand' => $this->string()->notNull(),
            'model' => $this->string(),
        ]);
    }
}
