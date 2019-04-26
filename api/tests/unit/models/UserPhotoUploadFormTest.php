<?php

namespace tests\models;

use app\models\User;
use app\models\UserPhotoUploadForm;
use yii\web\UploadedFile;
use Mockery as m;

class UserPhotoUploadFormTest extends \Codeception\Test\Unit
{
    public function testValidateRequired()
    {
        $model = new UserPhotoUploadForm();

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('image'));
    }

    public function testValidateSuccess()
    {
        $_FILES = [
            'image' => [
                'tmp_name' => __DIR__ . '/../../data/example.jpg',
                'name'     => 'example.jpg',
                'type'     => 'image/jpeg ',
                'size'     => 47152,
                'error'    => 0,
            ],
        ];

        $model        = new UserPhotoUploadForm();
        $model->image = UploadedFile::getInstanceByName('image');

        $this->assertTrue($model->validate());
    }

    public function testValidateInvalidFileType()
    {
        $_FILES = [
            'image' => [
                'tmp_name' => __DIR__ . '/../../data/example.txt',
                'name'     => 'example.txt',
                'type'     => 'text/plain',
                'size'     => 2605,
                'error'    => 0,
            ],
        ];

        $model        = new UserPhotoUploadForm();
        $model->image = UploadedFile::getInstanceByName('image');

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('image'));
    }

    public function testValidateFileTooBig()
    {
        $_FILES = [
            'image' => [
                'tmp_name' => __DIR__ . '/../../data/example.jpg',
                'name'     => 'example.jpg',
                'type'     => 'image/jpeg ',
                'size'     => 1024 * 1024 * 10, // override
                'error'    => 0,
            ],
        ];

        $model        = new UserPhotoUploadForm();
        $model->image = UploadedFile::getInstanceByName('image');

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('image'));
    }

    public function testCropAndResize()
    {
        $filePath = __DIR__ . '/../../data/hd1080.png';

        $model = new UserPhotoUploadForm();

        $image = $model->cropAndResizePhoto($filePath);

        $this->assertEquals($image->getHeight(), 640);
        $this->assertEquals($image->getWidth(), 640);
    }

    public function testCropAndResizeSmallImage()
    {
        $filePath = __DIR__ . '/../../data/qvga.png';

        $model = new UserPhotoUploadForm();

        $image = $model->cropAndResizePhoto($filePath);

        $this->assertEquals($image->getHeight(), 640);
        $this->assertEquals($image->getWidth(), 640);
    }

    public function testCreateRelativePath()
    {
        $model            = new UserPhotoUploadForm();
        $relativeFilePath = $model->createFilePath();

        $this->assertStringContainsString('avatars/', $relativeFilePath);
    }

    public function testUpload()
    {
        $tempFilePath = '/temp/test.jpg'; // random file path

        /**
         * @var \yii2tech\filestorage\BucketInterface $bucket
         */
        $bucket = m::mock(\Yii::$app->fileStorage->getBucket('imageFiles'));
        $bucket->shouldReceive('saveFileContent')->andReturnTrue()->once();

        $model  = new UserPhotoUploadForm();
        $result = $model->upload($tempFilePath, $bucket);

        $this->assertTrue($result);
    }

    public function testSetUserProfilePhoto()
    {
        $user = new User();

        $model            = new UserPhotoUploadForm();
        $relativeFilePath = $model->setUserProfilePhoto($user, 'avatars/my.jpg');

        $this->assertEquals('avatars/my.jpg', $relativeFilePath);
        $this->assertEquals('avatars/my.jpg', $user->photo_url);
    }
}
