<?php

class UserPhotoUploadCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function postMePhotoUploadTest(ApiTester $I)
    {
        $I->amUser();

        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.jpg';

        $I->sendPOST('/v1/user/me/photo', [], [
            'image' => [
                'name'     => 'example.jpg',
                'type'     => 'image/jpeg',
                'error'    => UPLOAD_ERR_OK,
                'size'     => filesize($filePath),
                'tmp_name' => $filePath,
            ],
        ]);

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);
    }

    public function postMePhotoUploadNoFileTest(ApiTester $I)
    {
        $I->amUser();

        $I->deleteHeader('Content-Type');

        $I->sendPOST('/v1/user/me/photo');

        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function postMePhotoUploadInvalidFileTypeTest(ApiTester $I)
    {
        $I->amUser();

        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.txt';

        $I->sendPOST('/v1/user/me/photo', [], ['image' => [
                'name'     => 'example.txt',
                'type'     => 'text/plain',
                'error'    => UPLOAD_ERR_OK,
                'size'     => filesize($filePath),
                'tmp_name' => $filePath,
            ],
        ]);

        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function postMePhotoUploadInvalidHeaderMimeTest(ApiTester $I)
    {
        $I->amUser();

        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.txt';

        $I->sendPOST('/v1/user/me/photo', [], ['image' => [
            'name'     => 'example.jpg',
            'type'     => 'image/jpeg',
            'error'    => UPLOAD_ERR_OK,
            'size'     => filesize($filePath),
            'tmp_name' => $filePath,
        ],
        ]);

        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function postMePhotoUploadSetProfileTest(ApiTester $I)
    {
        $I->updateInDatabase('user', ['photo_url' => null], ['id' => 9]);

        $I->amUser();

        $I->sendGET('/v1/user/me');

        $photoUrl = $I->grabDataFromResponseByJsonPath('$.data.photo_url');
        $photoUrl = $photoUrl[0];

        $I->assertNull($photoUrl);


        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.jpg';

        $I->sendPOST('/v1/user/me/photo', [], [
            'image' => [
                'name'     => 'example.jpg',
                'type'     => 'image/jpeg',
                'error'    => UPLOAD_ERR_OK,
                'size'     => filesize($filePath),
                'tmp_name' => $filePath,
            ],
        ]);

        $I->canSeeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => true,
            'status'  => 200,
        ]);

        $I->sendGET('/v1/user/me');

        $photoUrl = $I->grabDataFromResponseByJsonPath('$.data.photo_url');
        $photoUrl = $photoUrl[0];

        $I->assertNotNull($photoUrl);
    }
}
