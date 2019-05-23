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
}
