<?php

class UserCest
{
    protected function login(ApiTester $I)
    {
        $I->sendPOST('/v1/user/login', [
            'LoginForm' => [
                'username' => 'user',
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

    public function userLoginInvalidFields(ApiTester $I)
    {
        $I->sendPOST('/v1/user/login');

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status' => 422,
        ]);

        $I->sendPOST('/v1/user/login', [
            'LoginForm' => [
                'username' => 'user',
            ]
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status' => 422,
        ]);

        $I->sendPOST('/v1/user/login', [
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

    public function userLoginInvalidCredentials(ApiTester $I)
    {
        $I->sendPOST('/v1/user/login', [
            'LoginForm' => [
                'username' => 'user',
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

    /**
     * @before login
     */
    public function userLogin(ApiTester $I)
    {
        $I->sendGET('/v1/user/me');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    /**
     * @before login
     */
    public function userGetProfile(ApiTester $I)
    {
        $I->sendGET('/v1/user/me');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'username' => 'string|null',
            'email' => 'string|null',
            'photo_url' => 'string|null',
            'name' => 'string|null',
            'phone' => 'string|null',
            'address' => 'string|null',
            'rw' => 'string|null',
            'kelurahan' => 'array',
            'kecamatan' => 'array',
            'kabkota' => 'array',
            'facebook' => 'string|null',
            'twitter' => 'string|null',
            'instagram' => 'string|null',
        ], '$.data');
    }

    public function userUpdateProfile(ApiTester $I)
    {
    }
}
