<?php

class StaffCest
{
    private $endpointStaff = '/v1/staff';
    private $endpointLogin = '/v1/staff/login';

    public function staffLoginInvalidFields(ApiTester $I)
    {
        $I->sendPOST($this->endpointLogin);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);

        $I->sendPOST($this->endpointLogin, [
            'LoginForm' => [
                'username' => 'admin',
            ]
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);

        $I->sendPOST($this->endpointLogin, [
            'LoginForm' => [
                'password' => '123456',
            ]
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function staffLoginInvalidCredentials(ApiTester $I)
    {
        $I->sendPOST($this->endpointLogin, [
            'LoginForm' => [
                'username' => 'admin',
                'password' => '1234567',
            ]
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function staffLogin(ApiTester $I)
    {
        $I->amStaff();

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
        $I->seeResponseMatchesJsonType([
            'id' => 'integer',
            'access_token' => 'string',
        ], '$.data');
    }

    public function staffCreateStaffInvalidFields(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST($this->endpointStaff);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success'=> false,
            'status'=> 422,
            'data'=> [
                'username' => [],
                'email' => [],
                'role_id' => [],
                'kabkota_id' => [],
                'kec_id' => [],
                'kel_id' => [],
                'rw' => []
            ]
        ]);

        $I->sendPOST($this->endpointStaff, [
            'username' => 'staff.kabkota.2',
            'email' => 'staff.kabkota.2@jabarprov.go.id',
            'password' => '123456',
            'role_id' => 'staffKabkota'
        ]);

        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success'=> false,
            'status'=> 422,
            'data'=> [
                'kabkota_id' => []
            ]
        ]);
    }

    public function staffCreateStaff(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPOST($this->endpointStaff, [
            'username' => 'staff.prov.1',
            'email' => 'staff.prov.1@jabarprov.go.id',
            'password' => '123456',
            'role_id' => 'staffProv'
        ]);

        $I->canSeeResponseCodeIs(201);
        $I->seeResponseIsJson();
    }

    public function getList(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointStaff);

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function getListInvalidSearch(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointStaff . '?search=MZG2gnGQkRZ5XOIYqJz94qHMuRM0P41zAKpdFNHVnDoE1fl2tlA');

        $I->canSeeResponseCodeIs(400);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 400,
            'data' => []
        ]);
    }

    public function getListByName(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointStaff . '?search=Staff');

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
            'data' => [
                'items' => [],
            ]
        ]);
    }

    public function getListByPhone(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointStaff . '?search=080989999');

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
            'data' => [
                'items' => [],
            ]
        ]);
    }

    public function getListByRole(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointStaff . '?role_id=staffRW');

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
            'data' => [
                'items' => [],
            ]
        ]);
    }

    public function getListByArea(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointStaff . '?kabkota_id=22&kec_id=431&kel_id=6093&rw=1');

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
            'data' => [
                'items' => [],
            ]
        ]);
    }

    public function getItemInvalidParam(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointStaff . '/xsA2#');
        $I->canSeeResponseCodeIs(400); // Bad Request
        $I->seeResponseIsJson();
    }

    public function getItemNotFound(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointStaff . '/' . PHP_INT_MAX);
        $I->canSeeResponseCodeIs(404); // Not Found
        $I->seeResponseIsJson();
    }

    public function getItem(ApiTester $I)
    {
        $I->amStaff();

        $I->sendGET($this->endpointStaff . '/1');
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
            'data' => [],
        ]);
    }

    public function staffUpdateInvalidFields(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPUT($this->endpointStaff . '/1', [
            'username' => '@D3',
            'email' => 'invalid email@example_.com',
            'status' => 1000,
            'role_id' => 'invalidRole'
        ]);
        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
            'data' => [
                'username' => [],
                'email' => [],
                'status' => [],
                'role_id' => []
            ],
        ]);
    }

    public function staffUpdate(ApiTester $I)
    {
        $I->amStaff();

        $I->sendPUT($this->endpointStaff . '/1', [
            'email' => 'admin@example.com',
        ]);
        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
            'data' => [],
        ]);
    }
}
