<?php

use app\components\CustomMigration;

/**
 * Class m190627_075651_insert_rbac_news */
class m190627_075651_insert_rbac_news extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $newsListPermission              = $auth->createPermission('newsList');
        $newsListPermission->description = 'Get News List';
        $auth->add($newsListPermission);

        $newsManagePermission              = $auth->createPermission('newsManage');
        $newsManagePermission->description = 'Manage News';
        $auth->add($newsManagePermission);

        $role = $auth->getRole('admin');
        $auth->addChild($role, $newsManagePermission);

        $role = $auth->getRole('staffProv');
        $auth->addChild($role, $newsManagePermission);

        $role = $auth->getRole('user');
        $auth->addChild($role, $newsListPermission);

        $role = $auth->getRole('staffRW');
        $auth->addChild($role, $newsListPermission);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190627_075651_insert_rbac_news cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190627_075651_insert_rbac_news cannot be reverted.\n";

        return false;
    }
    */
}
