<?php

use app\components\CustomMigration;

/**
 * Class m190326_035359_update_user_default_area */
class m190326_035359_update_user_default_area extends CustomMigration
{
    public function up()
    {
        \Yii::$app->db->createCommand("UPDATE user SET kel_id=:column1, kec_id=:column2, kabkota_id=:column3 WHERE id=:id")
            ->bindValue(':id', 3)
            ->bindValue(':column1', 6082)
            ->bindValue(':column2', 428)
            ->bindValue(':column3', 22)
            ->execute();
    }
}
