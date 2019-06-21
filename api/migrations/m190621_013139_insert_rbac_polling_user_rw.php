<?php

use app\components\CustomMigration;

/**
 * Class m190621_013139_insert_rbac_polling_user_rw */
class m190621_013139_insert_rbac_polling_user_rw extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole('staffRW');

        $pollingListPermission = $auth->getPermission('pollingList');
        $auth->addChild($role, $pollingListPermission);

        $pollingVotePermission = $auth->getPermission('pollingVote');
        $auth->addChild($role, $pollingVotePermission);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190621_013139_insert_rbac_polling_user_rw cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190621_013139_insert_rbac_polling_user_rw cannot be reverted.\n";

        return false;
    }
    */
}
