<?php

class NewsCest
{
    public function _before(ApiTester $I)
    {
        Yii::$app->db->createCommand()->checkIntegrity(false)->execute();

        Yii::$app->db->createCommand('TRUNCATE news')->execute();
        Yii::$app->db->createCommand('TRUNCATE news_channels')->execute();

        $I->haveInDatabase('news_channels', [
            'id'         => 1,
            'name'       => 'Detik',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);
    }

    public function getListTest(ApiTester $I)
    {
        $I->haveInDatabase('news', [
            'id'         => 1,
            'channel_id' => 1,
            'title'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'content'    => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'   => false,
            'cover_path' => 'covers/test.jpg',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/news');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }
}
