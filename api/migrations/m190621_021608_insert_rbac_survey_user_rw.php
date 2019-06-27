<?php

use app\components\CustomMigration;

/**
 * Class m190621_021608_insert_rbac_survey_user_rw */
class m190621_021608_insert_rbac_survey_user_rw extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole('staffRW');

        $pollingListPermission = $auth->getPermission('surveyList');
        $auth->addChild($role, $pollingListPermission);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190621_021608_insert_rbac_survey_user_rw cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190621_021608_insert_rbac_survey_user_rw cannot be reverted.\n";

        return false;
    }
    */
}
