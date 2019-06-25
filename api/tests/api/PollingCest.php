<?php

use Carbon\Carbon;

class PollingCest
{
    public function _before(ApiTester $I)
    {
        Yii::$app->db->createCommand()->checkIntegrity(false)->execute();

        Yii::$app->db->createCommand('TRUNCATE polling_votes')->execute();
        Yii::$app->db->createCommand('TRUNCATE polling_answers')->execute();
        Yii::$app->db->createCommand('TRUNCATE polling')->execute();
    }

    public function getUserListTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getUserRwListTest(ApiTester $I)
    {
        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getUserListPublishedShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getAdminListPublishedShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }


    public function getUserListDeletedDontShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => -1,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getAdminListDeletedDontShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => -1,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getUserListDisabledDontShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 1,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getAdminListDisabledShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 1,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListDraftDontShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 0,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getAdminListDraftShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 0,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListActiveDateTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListActiveEndDateTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->subDays(7)->toDateString(),
            'end_date'    => (new Carbon())->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListCannotSeePastDateTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->subDays(7)->toDateString(),
            'end_date'    => (new Carbon())->subDays(1)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getUserListCannotSeeFutureDateTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->addDays(7)->toDateString(),
            'end_date'    => (new Carbon())->addDays(14)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getAdminListAllDateTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling', [
            'id'          => 2,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->subDays(7),
            'end_date'    => (new Carbon())->subDays(1)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling', [
            'id'          => 3,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => null,
            'rw'          => null,
            'category_id' => 20,
            'start_date'  => (new Carbon())->addDays(7),
            'end_date'    => (new Carbon())->addDays(14)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->assertEquals(1, $data[0][0]['id']);
        $I->assertEquals(2, $data[0][1]['id']);
        $I->assertEquals(3, $data[0][2]['id']);
    }

    public function getListByUserAreaKabkota(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => null,
            'kel_id'      => null,
            'rw'          => null,
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->assertEquals(1, $data[0][0]['id']);
    }

    public function getListByUserCannotSeeOtherAreaKabkota(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 21,
            'kec_id'      => null,
            'kel_id'      => null,
            'rw'          => null,
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getListByUserAreaKecamatan(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => 446,
            'kel_id'      => null,
            'rw'          => null,
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->assertEquals(1, $data[0][0]['id']);
    }

    public function getListByUserCannotSeeOtherAreaKecamatan(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => 447,
            'kel_id'      => null,
            'rw'          => null,
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getListByUserAreaKelurahan(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => 446,
            'kel_id'      => 6178,
            'rw'          => null,
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->assertEquals(1, $data[0][0]['id']);
    }

    public function getListByUserCannotSeeOtherAreaKelurahan(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => 446,
            'kel_id'      => 6179,
            'rw'          => null,
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getListByUserAreaRw(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => 6093,
            'rw'          => '001',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->assertEquals(1, $data[0][0]['id']);
    }

    public function getListByUserCannotSeeOtherAreaRw(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => 431,
            'kel_id'      => 6093,
            'rw'          => '002',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getUserShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $data = $I->grabDataFromResponseByJsonPath('$.data')[0];

        $I->assertEquals('Lorem ipsum.', $data['name']);
        $I->assertEquals('Lorem ipsum updated', $data['question']);
    }

    public function getStaffShowTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/polling/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postUserCreateTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $data = [];

        $I->sendPOST('/v1/polling', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function postStaffCreateTest(ApiTester $I)
    {
        $I->amStaff();

        $data = [
            'name'        => 'Lorem ipsum',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'start_date'  => '2019-06-01',
            'end_date'    => '2019-09-01',
            'kabkota_id'  => 22,
            'kec_id'      => 446,
            'kel_id'      => 6082,
            'status'      => 0,
            'category_id' => 17,
            'answers'     => [
                ['body' => 'Option A'],
                ['body' => 'Option B'],
                ['body' => 'Option C'],
            ],
        ];

        $I->sendPOST('/v1/polling', $data);
        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);

        $I->seeInDatabase('polling', [
            'name'        => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'start_date'  => '2019-06-01',
            'end_date'    => '2019-09-01',
            'kabkota_id'  => 22,
            'kec_id'      => 446,
            'kel_id'      => 6082,
            'status'      => 0,
            'category_id' => 17,
        ]);

        $I->seeInDatabase('polling_answers', [
            'body' => 'Option A',
        ]);

        $I->seeInDatabase('polling_answers', [
            'body' => 'Option B',
        ]);

        $I->seeInDatabase('polling_answers', [
            'body' => 'Option C',
        ]);
    }

    public function postUpdateTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $data = [
            'name'        => 'Lorem ipsum updated',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. updated',
            'excerpt'     => 'Lorem ipsum dolor sit amet updated',
            'start_date'  => '2019-06-01',
            'end_date'    => '2019-09-01',
            'kabkota_id'  => 1,
            'kec_id'      => 2,
            'kel_id'      => 3,
            'status'      => 0,
            'category_id' => 18,
        ];

        $I->sendPUT('/v1/polling/1', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. updated',
            'excerpt'     => 'Lorem ipsum dolor sit amet updated',
            'kabkota_id'  => 1,
            'kec_id'      => 2,
            'kel_id'      => 3,
            'status'      => 0,
            'category_id' => 18,
        ]);
    }

    public function userDeleteTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendDELETE('/v1/polling/1');
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function staffDeleteTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $I->sendDELETE('/v1/polling/1');
        $I->canSeeResponseCodeIs(204);

        $I->seeInDatabase('polling', ['id' => 1, 'status' => -1]);
    }

    public function postVoteTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling_answers', [
            'id'         => 1,
            'polling_id' => 1,
            'body'       => 'Option A',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->amUser('user');

        $data = [
            'id' => 1,
        ];

        $I->sendPUT('/v1/polling/1/vote', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postUserRwVoteTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling_answers', [
            'id'         => 1,
            'polling_id' => 1,
            'body'       => 'Option A',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->amUser('staffrw');

        $data = [
            'id' => 1,
        ];

        $I->sendPUT('/v1/polling/1/vote', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postVoteAlreadyTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling_answers', [
            'id'         => 1,
            'polling_id' => 1,
            'body'       => 'Option A',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->haveInDatabase('polling_votes', [
            'id'         => 1,
            'polling_id' => 1,
            'answer_id'  => 1,
            'user_id'    => 36,
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->amUser('user');

        $data = [
            'id' => 1,
        ];

        $I->sendPUT('/v1/polling/1/vote', $data);
        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function getUserNoVoteTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling_answers', [
            'id'         => 1,
            'polling_id' => 1,
            'body'       => 'Option A',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling/1/vote');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
            'data'    => [
                'is_voted' => false,
            ],
        ]);
    }

    public function getUserAlreadyVoteTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling_answers', [
            'id'         => 1,
            'polling_id' => 1,
            'body'       => 'Option A',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->haveInDatabase('polling_votes', [
            'id'         => 1,
            'polling_id' => 1,
            'answer_id'  => 1,
            'user_id'    => 36,
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->amUser('user');

        $I->sendGET('/v1/polling/1/vote');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
            'data'    => [
                'is_voted' => true,
            ],
        ]);
    }

    public function createAnswerTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->amStaff();

        $data = [
            'body' => 'Answer 1',
        ];

        $I->sendPOST('/v1/polling/1/answers', $data);
        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);

        $I->seeInDatabase('polling_answers', [
            'polling_id' => 1,
            'body'       => 'Answer 1',
        ]);
    }

    public function updateAnswerTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling_answers', [
            'id'         => 1,
            'polling_id' => 1,
            'body'       => 'Option A',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->amStaff();

        $data = [
            'body' => 'Answer 1 Updated',
        ];

        $I->sendPUT('/v1/polling/1/answers/1', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeInDatabase('polling_answers', [
            'polling_id' => 1,
            'body'       => 'Answer 1 Updated',
        ]);
    }

    public function answerDeleteTest(ApiTester $I)
    {
        $I->haveInDatabase('polling', [
            'id'          => 1,
            'name'        => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->toDateString(),
            'end_date'    => (new Carbon())->addDays(7)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling_answers', [
            'id'         => 1,
            'polling_id' => 1,
            'body'       => 'Option A',
            'created_at' => '1554706345',
            'updated_at' => '1554706345',
        ]);

        $I->amStaff();

        $I->sendDELETE('/v1/polling/1/answers/1');
        $I->canSeeResponseCodeIs(204);

        $I->dontSeeInDatabase('polling_answers', ['polling_id' => 1, 'body' => 'Answer 1 Updated']);
    }
}
