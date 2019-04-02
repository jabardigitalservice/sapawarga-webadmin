<?php

class StaffCest
{
    protected function loginStaff(ApiTester $I)
    {
        $I->sendPOST('/v1/staff/login', [
            'LoginForm' => [
                'username' => 'admin',
                'password' => '123456',
            ]
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status' => 200,
        ]);

        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'access_token' => 'string',
        ], '$.data');

        $token = $I->grabDataFromResponseByJsonPath('$..data.access_token');
        $token = $token[0];

        $I->amBearerAuthenticated($token);
    }
}
