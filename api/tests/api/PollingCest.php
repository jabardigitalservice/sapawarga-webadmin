<?php

use Carbon\Carbon;

class PollingCest
{
    public function _before(ApiTester $I)
    {
        //
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
            'title'       => 'Lorem ipsum.',
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
            'title'       => 'Lorem ipsum.',
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
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => -1,
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
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => -1,
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
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 1,
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
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 1,
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
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 0,
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
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 0,
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
            'title'       => 'Lorem ipsum.',
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
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
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
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
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
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
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
            'title'       => 'Lorem ipsum.',
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

        $I->haveInDatabase('polling', [
            'id'          => 2,
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
            'category_id' => 20,
            'start_date'  => (new Carbon())->subDays(7),
            'end_date'    => (new Carbon())->subDays(1)->toDateString(),
            'created_at'  => '1554706345',
            'updated_at'  => '1554706345',
        ]);

        $I->haveInDatabase('polling', [
            'id'          => 3,
            'title'       => 'Lorem ipsum.',
            'question'    => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'status'      => 10,
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

    public function getUserShowTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendGET('/v1/polling/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $data = $I->grabDataFromResponseByJsonPath('$.data')[0];

        $I->assertEquals('Siapakah Presiden pilihan Anda?', $data['name']);
        $I->assertEquals('Siapakah Presiden pilihan Anda?', $data['question']);
    }

    public function getStaffShowTest(ApiTester $I)
    {
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
            'id'          => 4,
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
            'polling_id' => 4,
            'body'       => 'Option A',
        ]);

        $I->seeInDatabase('polling_answers', [
            'polling_id' => 4,
            'body'       => 'Option B',
        ]);

        $I->seeInDatabase('polling_answers', [
            'polling_id' => 4,
            'body'       => 'Option C',
        ]);
    }

    public function postUpdateTest(ApiTester $I)
    {
        $I->amStaff();

        $latestId = 4;

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

        $I->sendPUT('/v1/polling/' . $latestId, $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeInDatabase('polling', [
            'id'          => 4,
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
        $I->amUser('user');

        $I->sendDELETE('/v1/polling/4');
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function staffDeleteTest(ApiTester $I)
    {
        $I->amStaff();

        $I->sendDELETE('/v1/polling/4');
        $I->canSeeResponseCodeIs(204);

        $I->seeInDatabase('polling', ['id' => 4, 'status' => -1]);
    }

    public function postVoteTest(ApiTester $I)
    {
        $I->amUser('user');

        $latestId = 4;

        $data = [
            'id' => 1,
        ];

        $I->sendPUT('/v1/polling/' . $latestId . '/vote', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postUserRwVoteTest(ApiTester $I)
    {
        $I->amUser('staffrw');

        $latestId = 4;

        $data = [
            'id' => 1,
        ];

        $I->sendPUT('/v1/polling/' . $latestId . '/vote', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postVoteAlreadyTest(ApiTester $I)
    {
        $I->amUser('user');

        $latestId = 4;

        $data = [
            'id' => 1,
        ];

        $I->sendPUT('/v1/polling/' . $latestId . '/vote', $data);
        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function createAnswerTest(ApiTester $I)
    {
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
        $I->amStaff();

        $data = [
            'body' => 'Answer 1 Updated',
        ];

        $I->sendPUT('/v1/polling/1/answers/10', $data);
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
        $I->amStaff();

        $I->sendDELETE('/v1/polling/1/answers/10');
        $I->canSeeResponseCodeIs(204);

        $I->dontSeeInDatabase('polling_answers', ['polling_id' => 1, 'body' => 'Answer 1 Updated']);
    }
}
