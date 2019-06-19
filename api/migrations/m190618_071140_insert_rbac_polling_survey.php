<?php

use app\components\CustomMigration;

/**
 * Class m190618_071140_insert_rbac_polling_survey */
class m190618_071140_insert_rbac_polling_survey extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $pollingListPermission              = $auth->createPermission('pollingList');
        $pollingListPermission->description = 'Get Polling List';
        $auth->add($pollingListPermission);

        $pollingVotePermission              = $auth->createPermission('pollingVote');
        $pollingVotePermission->description = 'Do Polling Vote';
        $auth->add($pollingVotePermission);

        $pollingManagePermission              = $auth->createPermission('pollingManage');
        $pollingManagePermission->description = 'Manage Polling';
        $auth->add($pollingManagePermission);


        $surveyListPermission              = $auth->createPermission('surveyList');
        $surveyListPermission->description = 'Get Survey List';
        $auth->add($surveyListPermission);

        $surveyManagePermission              = $auth->createPermission('surveyManage');
        $surveyManagePermission->description = 'Manage Survey';
        $auth->add($surveyManagePermission);

        $role = $auth->getRole('admin');
        $auth->addChild($role, $pollingManagePermission);
        $auth->addChild($role, $surveyManagePermission);

        $role = $auth->getRole('user');
        $auth->addChild($role, $pollingListPermission);
        $auth->addChild($role, $pollingVotePermission);
        $auth->addChild($role, $surveyListPermission);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190618_071140_insert_rbac_polling_survey cannot be reverted.\n";

        return false;
    }
}
