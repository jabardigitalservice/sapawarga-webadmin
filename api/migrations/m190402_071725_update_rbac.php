<?php

use app\components\CustomMigration;

/**
 * Class m190402_071725_update_rbac */
class m190402_071725_update_rbac extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Delete "manageSettings" permission
        $manageSettings = $auth->remove($auth->getPermission('manageSettings'));

        // Add new roles
        $staffRW = $auth->createRole('staffRW');
        $staffRW->description = 'Ketua RW';
        $auth->add($staffRW);

        $staffKel = $auth->createRole('staffKel');
        $staffKel->description = 'Staff Kelurahan';
        $auth->add($staffKel);
        $auth->addChild($staffKel, $staffRW);

        $staffKec = $auth->createRole('staffKec');
        $staffKec->description = 'Staff Kecamatan';
        $auth->add($staffKec);
        $auth->addChild($staffKec, $staffKel);

        $staffKabkota = $auth->createRole('staffKabkota');
        $staffKabkota->description = 'Staff Kabupaten/Kota';
        $auth->add($staffKabkota);
        $auth->addChild($staffKabkota, $staffKec);

        $staffProv = $auth->createRole('staffProv');
        $staffProv->description = 'Staff Provinsi';
        $auth->add($staffProv);
        $auth->addChild($staffProv, $staffKabkota);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->remove($auth->getRole('staffProv'));
        $auth->remove($auth->getRole('staffKabkota'));
        $auth->remove($auth->getRole('staffKec'));
        $auth->remove($auth->getRole('staffKel'));
        $auth->remove($auth->getRole('staffRW'));

        $manageSettings = $auth->createPermission('manageSettings');
        $manageSettings->description = 'Manage settings';
        $auth->add($manageSettings);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190402_071725_update_rbac cannot be reverted.\n";

        return false;
    }
    */
}
