<?php

class UserPhotoUploadCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function postPhotoUploadTest(ApiTester $I)
    {
        $I->amUser();

        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.jpg';

        $I->sendPOST('/v1/user/photo', [], [
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

    public function postPhotoUploadNoFileTest(ApiTester $I)
    {
        $I->amUser();

        $I->deleteHeader('Content-Type');

        $I->sendPOST('/v1/user/photo');

        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function postPhotoUploadInvalidFileTypeTest(ApiTester $I)
    {
        $I->amUser();

        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.txt';

        $I->sendPOST('/v1/user/photo', [], ['image' => [
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

    public function postPhotoUploadInvalidHeaderMimeTest(ApiTester $I)
    {
        $I->amUser();

        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.txt';

        $I->sendPOST('/v1/user/photo', [], ['image' => [
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
}
