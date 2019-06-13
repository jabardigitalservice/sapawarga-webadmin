<?php

class NotificationCest
{
    private $endpointNotification = '/v1/notifications';

    // Test cases for users
    public function getNotificationListBandung(ApiTester $I)
    {
        $I->amUser('user.bandung');

        $I->sendGET($this->endpointNotification);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getNotificationListBekasi(ApiTester $I)
    {
        $I->amUser('user.bekasi');

        $I->sendGET($this->endpointNotification);
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

        $I->sendPOST($this->endpointNotification);
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

        $I->sendPUT("{$this->endpointNotification}/0");
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

        $I->sendDELETE("{$this->endpointNotification}/0");
        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }


    // Test cases for admins

    public function createNewNotificationCategoryInvalid(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST($this->endpointNotification, [
            'author_id' => 1,
            'category_id' => 0,
            'title' => 'Notification Title',
            'description' => 'Notification Description',
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

    public function getNotificationListAll(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointNotification);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeResponseContainsJson([
            'kabkota_id' => 22,
        ]);

        $I->seeResponseContainsJson([
            'kabkota_id' => 23,
        ]);
    }

    public function getNotificationListFilterCategory(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointNotification}?category_id=14");
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeResponseContainsJson([
            'category_id' => 14,
        ]);

        $I->cantSeeResponseContainsJson([
            'category_id' => 15,
        ]);

        $I->cantSeeResponseContainsJson([
            'category_id' => 16,
        ]);
    }

    public function getNotificationListFilterStatus(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointNotification}?status=10");
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $accessToken = $I->grabDataFromResponseByJsonPath('$.data.items');

        $I->seeResponseContainsJson([
            'data' => [
                'items' => [
                    [
                        'status' => 10,
                    ],
                ],
            ],
        ]);

        $I->cantSeeResponseContainsJson([
            'data' => [
                'items' => [
                    [
                        'status' => 0,
                    ],
                ],
            ],
        ]);
    }

    public function getNotificationListSearchTitle(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointNotification}?search=Kegiatan");
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getNotificationItemNotFound(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointNotification}/0");
        $I->canSeeResponseCodeIs(404);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 404,
        ]);
    }

    public function getNotificationItem(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET("{$this->endpointNotification}/1");
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

    public function updateNotification(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPUT("{$this->endpointNotification}/1", [
            'title' => 'Edited',
        ]);

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function deleteNotification(ApiTester $I)
    {
        $I->amStaff();

        $I->sendDELETE("{$this->endpointNotification}/1");
        $I->canSeeResponseCodeIs(204);
    }
}
