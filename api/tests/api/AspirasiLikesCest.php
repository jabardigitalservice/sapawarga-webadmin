<?php

class AspirasiLikesCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function postToggleLikeTest(ApiTester $I)
    {
        $I->amUser();

        $data = [];

        $I->sendPOST('/v1/aspirasi/likes/1', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }
}
