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
            'status'  => 200,
        ]);
    }

    public function getListByDepth(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/v1/areas?depth=1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 1);

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getListByDepthInvalid(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/v1/areas?depth=10');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 0);

        $I->seeResponseContainsJson([
            'data'    => [],
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getItemTest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/v1/areas/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'data'    => [
                'id'        => 1,
                'depth'     => 1,
                'parent_id' => null,
                'name'      => 'JAWA BARAT',
            ],
            'success' => true,
            'status'  => 200,
        ]);
    }
}
