<?php

class AreasCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPOST('/v1/user/login', '{"LoginForm":{"username": "user","password": "123456"}}');

        $accessToken = $I->grabDataFromResponseByJsonPath('$.data.access_token');
        $accessToken = $accessToken[0];

        $I->haveHttpHeader('Authorization', "Bearer $accessToken");
    }

    public function getListTest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/v1/areas');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status' => 200,
        ]);
    }
}
