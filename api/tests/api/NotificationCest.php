<?php

class NotificationCest
{
    private $endpointNotification = '/v1/notifications';

    // Test cases for users
    public function userCannotCreateNotification(ApiTester $I)
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

    // Test cases for admins
    public function createNewNotification(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST($this->endpointNotification, [
            'title'         => 'Title',
            'description'   => 'Description',
            'data'          => [
                'push_notification' => true,
            ],
        ]);

        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 201,
        ]);
    }
}
