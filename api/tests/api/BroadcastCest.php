<?php

class BroadcastCest
{
    private $endpointBroadcast = '/v1/broadcasts';

    public function createNewBroadcastAuthorInvalid(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST($this->endpointBroadcast, [
            'author_id' => 0,
            'category_id' => 1,
            'title' => 'Broadcast Title',
            'description' => 'Broadcast Description',
            'kabkota_id' => null,
            'kec_id' => null,
            'kel_id' => null,
            'rw' => null,
            'status' => 10,
        ]);

        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function createNewBroadcastCategoryInvalid(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST($this->endpointBroadcast, [
            'author_id' => 1,
            'category_id' => 0,
            'title' => 'Broadcast Title',
            'description' => 'Broadcast Description',
            'kabkota_id' => null,
            'kec_id' => null,
            'kel_id' => null,
            'rw' => null,
            'status' => 10,
        ]);

        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function createNewBroadcast(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST($this->endpointBroadcast, [
            'author_id' => 1,
            'category_id' => 1,
            'title' => 'Broadcast Title',
            'description' => 'Broadcast Description',
            'kabkota_id' => null,
            'kec_id' => null,
            'kel_id' => null,
            'rw' => null,
            'status' => 10,
        ]);

        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);
    }

    public function getBroadcastListAll(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointBroadcast);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getBroadcastListFilterAuthor(ApiTester $I)
    {

    }

    public function getBroadcastListFilterCategory(ApiTester $I)
    {

    }

    public function getBroadcastListFilterStatus(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointBroadcast}?status=10");
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getBroadcastListSearchTitle(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointBroadcast}?search=Kegiatan");
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getBroadcastItemNotFound(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointBroadcast}/0");
        $I->canSeeResponseCodeIs(404);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 404,
        ]);
    }

    public function getBroadcastItem(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointBroadcast}/1");
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success'   => true,
            'status'    => 200,
            'data'      => [
                'id' => 1,
            ]
        ]);
    }

    public function updateBroadcast(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPUT("{$this->endpointBroadcast}/1", [
            'title' => 'Edited',
        ]);

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function deleteBroadcast(ApiTester $I)
    {
        $I->amStaff();

        $I->sendDELETE("{$this->endpointBroadcast}/1");
        $I->canSeeResponseCodeIs(204);
    }
}
