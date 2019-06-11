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
        $I->amUser('user');

        $data = [
            'title'       => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'kabkota_id'  => 22,
            'kec_id'      => 446,
            'kel_id'      => 6082,
            'status'      => 0,
            'category_id' => 9,
            'attachments' => [],
        ];

        $I->sendPOST('/v1/polling', $data);
        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);
    }

    public function postUpdateTest(ApiTester $I)
    {
        $I->amUser('user');

        // @TODO find better way
        $createdIds = $I->grabColumnFromDatabase('aspirasi', 'id', ['author_id' => 36]);
        $latestId   = last($createdIds);

        $data = [
            'title'       => 'Lorem ipsum',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'kabkota_id'  => 22,
            'kec_id'      => 446,
            'kel_id'      => 6082,
            'status'      => 0,
            'category_id' => 9,
            'attachments' => [],
        ];

        $I->sendPUT('/v1/polling/' . $latestId, $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function userDeleteTest(ApiTester $I)
    {
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
        //
    }
}
