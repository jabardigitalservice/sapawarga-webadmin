<?php

use app\components\CustomMigration;

/**
 * Handles adding rt_lat_lon to table `{{%user}}`.
 */
class m190418_080841_add_rt_lat_lon_column_to_user_table extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'rt', $this->string()->after('address'));
        $this->addColumn('user', 'lat', $this->string()->after('kabkota_id'));
        $this->addColumn('user', 'lon', $this->string()->after('lat'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'lon');
        $this->dropColumn('user', 'lat');
        $this->dropColumn('user', 'rt');
    }
}
