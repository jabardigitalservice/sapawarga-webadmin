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

    public function getUserListOnlyActiveTest(ApiTester $I)
    {
        // ACTIVE
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DELETED
        $I->haveInDatabase('news', [
            'id'          => 2,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => -1,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DISABLED
        $I->haveInDatabase('news', [
            'id'          => 3,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 0,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/news');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeHttpHeader('X-Pagination-Total-Count', 1);

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getAdminListCanSeeAllTest(ApiTester $I)
    {
        // ACTIVE
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DELETED
        $I->haveInDatabase('news', [
            'id'          => 2,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => -1,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DISABLED
        $I->haveInDatabase('news', [
            'id'          => 3,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 0,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/news');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeHttpHeader('X-Pagination-Total-Count', 2);

        $data = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->assertEquals(1, $data[0][0]['id']);
        $I->assertEquals(3, $data[0][1]['id']);
    }

    public function getUserListFilterChannelTest(ApiTester $I)
    {
        $I->haveInDatabase('news_channels', [
            'id'         => 2,
            'name'       => 'Kompas',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('news', [
            'id'          => 2,
            'channel_id'  => 2,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/news?channel_id=1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeHttpHeader('X-Pagination-Total-Count', 1);

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListFilterChannelNotFoundTest(ApiTester $I)
    {
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/news?channel_id=2');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getUserListSearchTest(ApiTester $I)
    {
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('news', [
            'id'          => 2,
            'channel_id'  => 1,
            'title'       => 'Consectetur adipiscing elit.',
            'slug'        => 'consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/news?search=lorem');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeHttpHeader('X-Pagination-Total-Count', 1);

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListSearchNotFoundTest(ApiTester $I)
    {
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('news', [
            'id'          => 2,
            'channel_id'  => 1,
            'title'       => 'Consectetur adipiscing elit.',
            'slug'        => 'consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/news?search=jawa');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getUserCanShowTest(ApiTester $I)
    {
        // ACTIVE
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DELETED
        $I->haveInDatabase('news', [
            'id'          => 2,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => -1,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DISABLED
        $I->haveInDatabase('news', [
            'id'          => 3,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 0,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/news/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendGET('/v1/news/2');
        $I->canSeeResponseCodeIs(404);
        $I->seeResponseIsJson();

        $I->sendGET('/v1/news/3');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function getUserListFeaturedActiveTest(ApiTester $I)
    {
        // ACTIVE FEATURED
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => true,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // ACTIVE NOT FEATURED
        $I->haveInDatabase('news', [
            'id'          => 2,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DELETED
        $I->haveInDatabase('news', [
            'id'          => 3,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => true,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => -1,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DISABLED
        $I->haveInDatabase('news', [
            'id'          => 4,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => true,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 0,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/news/featured');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeHttpHeader('X-Pagination-Total-Count', 1);

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getAdminCanShowTest(ApiTester $I)
    {
        // ACTIVE
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DELETED
        $I->haveInDatabase('news', [
            'id'          => 2,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => -1,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        // DISABLED
        $I->haveInDatabase('news', [
            'id'          => 3,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 0,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/news/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendGET('/v1/news/2');
        $I->canSeeResponseCodeIs(404);
        $I->seeResponseIsJson();

        $I->sendGET('/v1/news/3');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function postUserCreateUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('staffrw');

        $data = [];

        $I->sendPOST('/v1/news', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();
    }

    public function postAdminCreateTest(ApiTester $I)
    {
        $I->amStaff();

        $data = [
            'title'       => 'Lorem ipsum',
            'channel_id'  => 1,
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 0,
        ];

        $I->sendPOST('/v1/news', $data);
        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);

        $I->seeInDatabase('news', [
            'title'       => 'Lorem ipsum',
            'channel_id'  => 1,
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 0,
        ]);
    }

    public function postUserUpdateUnauthorizedTest(ApiTester $I)
    {
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $data = [];

        $I->sendPUT('/v1/news/1', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();
    }

    public function postAdminUpdateTest(ApiTester $I)
    {
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $data = [
            'title'       => 'Lorem ipsum',
            'channel_id'  => 1,
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 0,
        ];

        $I->sendPUT('/v1/news/1', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeInDatabase('news', [
            'title'       => 'Lorem ipsum',
            'channel_id'  => 1,
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 0,
        ]);
    }

    public function deleteUserUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('staffrw');

        $I->sendDELETE('/v1/news/1');
        $I->canSeeResponseCodeIs(403);
    }

    public function deleteAdminTest(ApiTester $I)
    {
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendDELETE('/v1/news/1');
        $I->canSeeResponseCodeIs(204);

        $I->seeInDatabase('news', ['id' => 1, 'status' => -1]);
    }

    public function getUserIncrementReadCountTest(ApiTester $I)
    {
        $read_count = 0;
        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'meta'        => json_encode(['read_count' => $read_count]),
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/news/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $new_read_count = $I->grabDataFromResponseByJsonPath('$.data.meta.read_count');

        $I->assertEquals($read_count + 1, $new_read_count[0]);
    }

    public function getUserStatisticsUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('staffrw');

        $I->sendGET('/v1/news/statistics');
        $I->canSeeResponseCodeIs(403);
    }

    public function getAdminStatisticsTest(ApiTester $I)
    {
        $I->haveInDatabase('news_channels', [
            'id'         => 2,
            'name'       => 'Kompas',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);
        

        $I->haveInDatabase('news', [
            'id'          => 1,
            'channel_id'  => 1,
            'title'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'slug'        => 'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit',
            'content'     => 'Maecenas porttitor suscipit ex vitae hendrerit. Nunc sollicitudin quam et libero fringilla, eget varius nunc hendrerit.',
            'featured'    => false,
            'source_date' => '2019-06-20',
            'source_url'  => 'https://google.com',
            'cover_path'  => 'covers/test.jpg',
            'status'      => 10,
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/news/statistics');
        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeHttpHeader('X-Pagination-Total-Count', 2);

        $data = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->assertEquals(1, $data[0][0]['id']);
        $I->assertEquals(1, $data[0][0]['count']);
        $I->assertEquals(2, $data[0][1]['id']);
        $I->assertEquals(0, $data[0][1]['count']);
    }
}
