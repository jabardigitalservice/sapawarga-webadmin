<?php

use app\components\CustomMigration;

/**
 * Class m190326_040602_add_social_media_column_and_photo_url_to_user */
class m190326_040602_add_social_media_column_and_photo_url_to_user extends CustomMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'photo_url', $this->string());
        $this->addColumn('user', 'facebook', $this->string());
        $this->addColumn('user', 'twitter', $this->string());
        $this->addColumn('user', 'instagram', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'instagram');
        $this->dropColumn('user', 'twitter');
        $this->dropColumn('user', 'facebook');
        $this->dropColumn('user', 'photo_url');
    }
}
