<?php

use Carbon\Carbon;

class SurveyCest
{
    public function _before(ApiTester $I)
    {
        Yii::$app->db->createCommand()->checkIntegrity(false)->execute();

        Yii::$app->db->createCommand('TRUNCATE survey')->execute();
    }

    public function getListTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendGET('/v1/survey');
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

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getUserListPublishedShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 10,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getAdminListPublishedShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 10,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }


    public function getUserListDeletedDontShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => -1,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getAdminListDeletedDontShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => -1,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getUserListDisabledDontShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 1,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getAdminListDisabledShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 1,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListDraftDontShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 0,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getAdminListDraftShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 0,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListActiveDateTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 10,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListActiveEndDateTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 10,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->subDays(7)->toDateString(),
            'end_date'     => (new Carbon())->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items[0]');

        $I->assertEquals(1, $data[0]['id']);
    }

    public function getUserListCannotSeePastDateTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 10,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->subDays(7)->toDateString(),
            'end_date'     => (new Carbon())->subDays(1)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getUserListCannotSeeFutureDateTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 10,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->addDays(7)->toDateString(),
            'end_date'     => (new Carbon())->addDays(14)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amUser('staffrw');

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);
    }

    public function getAdminListAllDateTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 10,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->toDateString(),
            'end_date'     => (new Carbon())->addDays(7)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->haveInDatabase('survey', [
            'id'           => 2,
            'title'        => 'Lorem ipsum.',
            'status'       => 10,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->subDays(7),
            'end_date'     => (new Carbon())->subDays(1)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->haveInDatabase('survey', [
            'id'           => 3,
            'title'        => 'Lorem ipsum.',
            'status'       => 10,
            'category_id'  => 20,
            'start_date'   => (new Carbon())->addDays(7),
            'end_date'     => (new Carbon())->addDays(14)->toDateString(),
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $data = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->assertEquals(1, $data[0][0]['id']);
        $I->assertEquals(2, $data[0][1]['id']);
        $I->assertEquals(3, $data[0][2]['id']);
    }

    public function getShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 0,
            'category_id'  => 20,
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/survey/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postCreateUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('user');

        $data = [];

        $I->sendPOST('/v1/survey', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function postCreateTest(ApiTester $I)
    {
        $I->amStaff();

        $data = [
            'title'        => 'Lorem ipsum',
            'external_url' => 'http://google.com',
            'category_id'  => 20,
            'status'       => 0,
        ];

        $I->sendPOST('/v1/survey', $data);
        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);

        $I->seeInDatabase('survey', [
            'title'        => 'Lorem ipsum',
            'external_url' => 'http://google.com',
            'category_id'  => 20,
        ]);
    }

    public function postUpdateUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('user');

        $data = [];

        $I->sendPUT('/v1/survey/1', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function postUpdateTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 0,
            'category_id'  => 20,
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $data = [
            'title'        => 'Lorem ipsum updated',
            'external_url' => 'http://google-updated.com',
            'category_id'  => 21,
            'status'       => 0,
        ];

        $I->sendPUT('/v1/survey/1', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeInDatabase('survey', [
            'title'        => 'Lorem ipsum updated',
            'external_url' => 'http://google-updated.com',
            'category_id'  => 21,
        ]);
    }

    public function deleteUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendDELETE('/v1/survey/1');
        $I->canSeeResponseCodeIs(403);
    }

    public function deleteTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 0,
            'category_id'  => 20,
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $I->sendDELETE('/v1/survey/1');
        $I->canSeeResponseCodeIs(204);

        $I->seeInDatabase('survey', ['id' => 1, 'status' => -1]);
    }
}
