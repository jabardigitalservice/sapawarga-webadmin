<?php

class AspirasiUserCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function getListTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendGET('/v1/aspirasi');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getShowTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendGET('/v1/aspirasi/1');
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

        $data = [];

        $I->sendPOST('/v1/aspirasi', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function postUpdateTest(ApiTester $I)
    {
        $I->amUser('user');

        $data = [];

        $I->sendPOST('/v1/aspirasi/1', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function deleteTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendDELETE('/v1/aspirasi/1');
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    // My User
    public function getMyListTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendGET('/v1/aspirasi-me');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getMyShowTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendGET('/v1/aspirasi-me/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postMyCreateTest(ApiTester $I)
    {
        $I->amUser('user');

        $data = [];

        $I->sendPOST('/v1/aspirasi-me', $data);
        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);
    }

    public function postMyUpdateTest(ApiTester $I)
    {
        $I->amUser('user');

        $data = [];

        $I->sendPOST('/v1/aspirasi-me/1', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);
    }

    public function deleteMyTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendDELETE('/v1/aspirasi-me/1');
        $I->canSeeResponseCodeIs(204);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 204,
        ]);
    }
}
