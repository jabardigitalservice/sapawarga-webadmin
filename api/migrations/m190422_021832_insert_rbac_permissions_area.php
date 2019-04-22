<?php

use app\components\CustomMigration;

/**
 * Class m190422_021832_insert_rbac_permissions_area */
class m190422_021832_insert_rbac_permissions_area extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $areaListPermission              = $auth->createPermission('areaList');
        $areaListPermission->description = 'Get Area List';
        $auth->add($areaListPermission);

        $areaManagePermission              = $auth->createPermission('areaManage');
        $areaManagePermission->description = 'Manage Area';
        $auth->add($areaManagePermission);

        $role = $auth->getRole('admin');
        $auth->addChild($role, $areaListPermission);
        $auth->addChild($role, $areaManagePermission);

        $role = $auth->getRole('staff');
        $auth->addChild($role, $areaListPermission);
        $auth->addChild($role, $areaManagePermission);

        $role = $auth->getRole('staffProv');
        $auth->addChild($role, $areaListPermission);

        $role = $auth->getRole('staffKabkota');
        $auth->addChild($role, $areaListPermission);

        $role = $auth->getRole('staffKec');
        $auth->addChild($role, $areaListPermission);

        $role = $auth->getRole('staffKel');
        $auth->addChild($role, $areaListPermission);

        $role = $auth->getRole('staffRW');
        $auth->addChild($role, $areaListPermission);

        $role = $auth->getRole('user');
        $auth->addChild($role, $areaListPermission);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190422_021832_insert_rbac_permissions_area cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190422_021832_insert_rbac_permissions_area cannot be reverted.\n";

        return false;
    }
    */
}
