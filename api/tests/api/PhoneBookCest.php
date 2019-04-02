<?php

class PhoneBookCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function getListBandungTest(ApiTester $I)
    {
        $I->amUser('user.bandung');

        $I->sendGET('/v1/phone-books');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeResponseContainsJson([
            'kabkota_id' => 22,
        ]);

        $I->cantSeeResponseContainsJson([
            'kabkota_id' => 23,
        ]);

        $I->cantSeeResponseContainsJson([
            'kabkota_id' => 26,
        ]);
    }

    public function getListBekasiTest(ApiTester $I)
    {
        $I->amUser('user.bekasi');

        $I->sendGET('/v1/phone-books');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeResponseContainsJson([
            'kabkota_id' => 23,
        ]);

        $I->cantSeeResponseContainsJson([
            'kabkota_id' => 22,
        ]);

        $I->cantSeeResponseContainsJson([
            'kabkota_id' => 26,
        ]);
    }

    public function getListTasikmalayaTest(ApiTester $I)
    {
        $I->amUser('user.tasikmalaya');

        $I->sendGET('/v1/phone-books');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeResponseContainsJson([
            'kabkota_id' => 26,
        ]);

        $I->cantSeeResponseContainsJson([
            'kabkota_id' => 22,
        ]);

        $I->cantSeeResponseContainsJson([
            'kabkota_id' => 23,
        ]);
    }

    public function getListAdminTest(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET('/v1/phone-books');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function userCannotCreateNewTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendPOST('/v1/phone-books');
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function userCannotUpdateTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendPUT('/v1/phone-books/1');
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function userCannotDeleteTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendDELETE('/v1/phone-books/1');
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function staffCreateNewTest(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST('/v1/phone-books');
        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);
    }
}
