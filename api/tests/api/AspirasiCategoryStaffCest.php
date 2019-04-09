<?php

class AspirasiCategoryStaffCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function getListTest(ApiTester $I)
    {
        $I->amStaff();

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
        $I->amStaff();

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
        $I->amStaff();

        $data = [];

        $I->sendPOST('/v1/aspirasi/categories', $data);
        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);
    }

    public function postUpdateTest(ApiTester $I)
    {
        $I->amStaff();

        $data = [];

        $I->sendPOST('/v1/aspirasi/categories/1', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function deleteTest(ApiTester $I)
    {
        $I->amStaff();

        $I->sendDELETE('/v1/aspirasi/categories/1');
        $I->canSeeResponseCodeIs(204);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 204,
        ]);
    }
}
