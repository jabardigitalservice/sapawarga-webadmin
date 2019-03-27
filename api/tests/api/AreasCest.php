<?php

class AreasCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function getListTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/areas');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getListByDepthTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/areas?depth=1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeHttpHeader('X-Pagination-Total-Count', 1);

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getListByDepthLevelTwoTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/areas?depth=2');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getListByDepthAllTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/areas?depth=2&all=true');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->dontSeeHttpHeader('X-Pagination-Total-Count');

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getListByDepthInvalidTest(ApiTester $I)
    {
        $I->amUser();

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

    public function getListByParentTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/areas?parent_id=2');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeResponseContainsJson([
            'parent_id' => 2,
            'depth'     => 3,
        ]);
    }

    public function getItemTest(ApiTester $I)
    {
        $I->amUser();

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

    public function getItemNotFoundTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/areas/99999');
        $I->canSeeResponseCodeIs(404); // Not Found
        $I->seeResponseIsJson();
    }

    public function getItemInvalidParamTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/areas/x');
        $I->canSeeResponseCodeIs(400); // Bad Request
        $I->seeResponseIsJson();
    }

    public function getItemInvalidParamRandomTest(ApiTester $I)
    {
        $I->amUser();

        $I->sendGET('/v1/areas/xsA2#');
        $I->canSeeResponseCodeIs(400); // Bad Request
        $I->seeResponseIsJson();
    }

    public function postCreateNew(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST('/v1/areas', [
            'parent_id'       => 1,
            'depth'           => 1,
            'name'            => 'TEST PROVINCE',
            'code_bps'        => 'TEST.CODE.BPS',
            'code_kemendagri' => 'TEST.CODE.KEMENDAGRI',
            'status'          => true,
        ]);

        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }
}
