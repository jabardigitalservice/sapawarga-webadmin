<?php

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

    public function getStaffListTest(ApiTester $I)
    {
        $I->amUser('staff');

        $I->sendGET('/v1/polling');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
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
    }

    public function getStaffShowTest(ApiTester $I)
    {
        $I->amUser('staff');

        $I->sendGET('/v1/polling/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postCreateTest(ApiTester $I)
    {
        $I->amUser('staff');

        $data = [
            'title'       => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => 446,
            'kel_id'      => 6082,
            'status'      => 0,
            'category_id' => 9,
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
            'title'       => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'excerpt'     => 'Lorem ipsum dolor sit amet',
            'kabkota_id'  => 22,
            'kec_id'      => 446,
            'kel_id'      => 6082,
            'status'      => 0,
            'category_id' => 9,
        ]);

        $I->seeInDatabase('polling_answers', [
            'id'   => 7,
            'body' => 'Option A',
        ]);

        $I->seeInDatabase('polling_answers', [
            'id'   => 8,
            'body' => 'Option B',
        ]);

        $I->seeInDatabase('polling_answers', [
            'id'   => 9,
            'body' => 'Option C',
        ]);
    }

    public function postUpdateTest(ApiTester $I)
    {
        $I->amUser('staff');

        $latestId = 4;

        $data = [
            'title'       => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. updated',
            'excerpt'     => 'Lorem ipsum dolor sit amet updated',
            'kabkota_id'  => 1,
            'kec_id'      => 2,
            'kel_id'      => 3,
            'status'      => 4,
            'category_id' => 5,
            'answers'     => [
                ['id' => 7, 'body' => 'Option A'],
                ['id' => 8, 'body' => 'Option B'],
                ['body' => 'Option D'],
            ],
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
            'title'       => 'Lorem ipsum updated',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. updated',
            'excerpt'     => 'Lorem ipsum dolor sit amet updated',
            'kabkota_id'  => 1,
            'kec_id'      => 2,
            'kel_id'      => 3,
            'status'      => 4,
            'category_id' => 5,
        ]);

        $I->seeInDatabase('polling_answers', [
            'id'   => 7,
            'body' => 'Option A',
        ]);

        $I->seeInDatabase('polling_answers', [
            'id'   => 8,
            'body' => 'Option B',
        ]);

        $I->seeInDatabase('polling_answers', [
            'id'   => 10,
            'body' => 'Option D',
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
        $I->amUser('staff');

        $I->sendDELETE('/v1/polling/4');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeInDatabase('polling', ['id' => 4, 'status' => -1]);
    }
}
