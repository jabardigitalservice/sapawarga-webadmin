<?php

class StaffCest
{
    private $endpoint = '/v1/staff/login';

    public function staffLoginInvalidFields(ApiTester $I)
    {
        $I->sendPOST($this->endpoint);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status' => 422,
        ]);

        $I->sendPOST($this->endpoint, [
            'LoginForm' => [
                'username' => 'admin',
            ]
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status' => 422,
        ]);

        $I->sendPOST($this->endpoint, [
            'LoginForm' => [
                'password' => '123456',
            ]
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status' => 422,
        ]);
    }

    public function staffLoginInvalidCredentials(ApiTester $I)
    {
        $I->sendPOST($this->endpoint, [
            'LoginForm' => [
                'username' => 'admin',
                'password' => '1234567',
            ]
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status' => 422,
        ]);
    }

    public function staffLogin(ApiTester $I)
    {
        $I->sendPOST($this->endpoint, [
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
