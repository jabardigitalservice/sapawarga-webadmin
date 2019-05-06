<?php

class StaffPhotoUploadCest
{
    public function _before(ApiTester $I)
    {
        //
    }

    public function postStaffPhotoUploadUnauthorizedTest(ApiTester $I)
    {
        $I->amUser();

        $I->deleteHeader('Content-Type');

        $I->sendPOST('/v1/staff/photo');

        $I->canSeeResponseCodeIs(403);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 403,
        ]);
    }

    public function postStaffPhotoUploadTest(ApiTester $I)
    {
        $I->amStaff();

        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.jpg';

        $I->sendPOST('/v1/staff/photo', [], [
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

    public function postStaffPhotoUploadNoFileTest(ApiTester $I)
    {
        $I->amStaff();

        $I->deleteHeader('Content-Type');

        $I->sendPOST('/v1/staff/photo');

        $I->canSeeResponseCodeIs(422);
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'success' => false,
            'status'  => 422,
        ]);
    }

    public function postStaffPhotoUploadInvalidFileTypeTest(ApiTester $I)
    {
        $I->amStaff();

        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.txt';

        $I->sendPOST('/v1/staff/photo', [], ['image' => [
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

    public function postStaffPhotoUploadInvalidHeaderMimeTest(ApiTester $I)
    {
        $I->amStaff();

        $I->deleteHeader('Content-Type');

        $filePath = __DIR__ . '/../data/example.txt';

        $I->sendPOST('/v1/staff/photo', [], ['image' => [
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
