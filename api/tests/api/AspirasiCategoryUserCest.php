<?php

class AspirasiCategoryUserCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function getListTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/aspirasi/categories');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getShowTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/aspirasi/categories/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postCreateTest(ApiTester $I)
    {
        $I->amUser();

        $data = [];

        $I->sendPOST('/v1/aspirasi/categories', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function postUpdateTest(ApiTester $I)
    {
        $I->amUser();

        $data = [];

        $I->sendPOST('/v1/aspirasi/categories/1', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function deleteTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendDELETE('/v1/aspirasi/categories/1');
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }
}
