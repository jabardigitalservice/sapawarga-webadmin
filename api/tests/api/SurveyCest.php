<?php

class SurveyCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function getListTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendGET('/v1/survey');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getShowTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 0,
            'category_id'  => 20,
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $I->sendGET('/v1/survey/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postCreateUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('user');

        $data = [];

        $I->sendPOST('/v1/survey', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function postCreateTest(ApiTester $I)
    {
        $I->amStaff();

        $data = [
            'title'        => 'Lorem ipsum',
            'external_url' => 'http://google.com',
            'category_id'  => 20,
            'status'       => 0,
        ];

        $I->sendPOST('/v1/survey', $data);
        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);

        $I->seeInDatabase('survey', [
            'title'        => 'Lorem ipsum',
            'external_url' => 'http://google.com',
            'category_id'  => 20,
        ]);
    }

    public function postUpdateUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('user');

        $data = [];

        $I->sendPUT('/v1/survey/1', $data);
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function postUpdateTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 0,
            'category_id'  => 20,
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $data = [
            'title'        => 'Lorem ipsum updated',
            'external_url' => 'http://google-updated.com',
            'category_id'  => 21,
            'status'       => 0,
        ];

        $I->sendPUT('/v1/survey/1', $data);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeInDatabase('survey', [
            'title'        => 'Lorem ipsum updated',
            'external_url' => 'http://google-updated.com',
            'category_id'  => 21,
        ]);
    }

    public function deleteUnauthorizedTest(ApiTester $I)
    {
        $I->amUser('user');

        $I->sendDELETE('/v1/survey/1');
        $I->canSeeResponseCodeIs(403);
    }

    public function deleteTest(ApiTester $I)
    {
        $I->haveInDatabase('survey', [
            'id'           => 1,
            'title'        => 'Lorem ipsum.',
            'status'       => 0,
            'category_id'  => 20,
            'external_url' => 'http://google.com',
            'created_at'   => '1554706345',
            'updated_at'   => '1554706345',
        ]);

        $I->amStaff();

        $I->sendDELETE('/v1/survey/1');
        $I->canSeeResponseCodeIs(204);

        $I->seeInDatabase('survey', ['id' => 1, 'status' => -1]);
    }
}
