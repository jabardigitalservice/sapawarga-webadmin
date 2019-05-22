<?php

use app\components\CustomMigration;

/**
 * Class m190522_073402_aspirasi_add_approval_note */
class m190522_073402_aspirasi_add_approval_note extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('aspirasi', 'approval_note', $this->text()->null());
        $this->addColumn('aspirasi', 'approved_by', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('aspirasi', 'approval_note');
        $this->dropColumn('aspirasi', 'approved_by');
    }
}
