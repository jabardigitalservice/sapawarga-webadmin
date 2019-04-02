<?php

class PhoneBookCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function getListTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/phone-books');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getListAdminTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/phone-books');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }
}
