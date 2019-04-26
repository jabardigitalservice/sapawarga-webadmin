<?php

namespace tests\models;

use app\models\User;
use app\models\UserPhotoUploadForm;
use Intervention\Image\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use yii\web\UploadedFile;
use Mockery as m;
use yii2tech\filestorage\local\Bucket;

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
        $tempFilePath = '/tmp/test.jpg'; // mock file path

        $imageProcessor = m::mock(ImageManager::class);
        $imageProcessor->shouldReceive('make')->once()->andReturnUsing(function () {
            $driver = new Driver();
            $core = imagecreatetruecolor(1024, 1024);

            $image = new Image($driver, $core);

            return $image;
        });

        $model = new UserPhotoUploadForm();
        $model->setImageProcessor($imageProcessor);

        $image = $model->cropAndResizePhoto($tempFilePath);

        $this->assertEquals($image->getHeight(), 640);
        $this->assertEquals($image->getWidth(), 640);
    }

    public function testCropAndResizeSmallImage()
    {
        $tempFilePath = '/tmp/test.jpg'; // mock file path

        $imageProcessor = m::mock(ImageManager::class);
        $imageProcessor->shouldReceive('make')->once()->andReturnUsing(function () {
            $driver = new Driver();
            $core = imagecreatetruecolor(128, 128);

            $image = new Image($driver, $core);

            return $image;
        });

        $model = new UserPhotoUploadForm();
        $model->setImageProcessor($imageProcessor);

        $image = $model->cropAndResizePhoto($tempFilePath);

        $this->assertEquals($image->getHeight(), 640);
        $this->assertEquals($image->getWidth(), 640);
    }

    public function testCreateRelativePath()
    {
        $model            = new UserPhotoUploadForm();
        $relativeFilePath = $model->createFilePath();

        $this->assertStringContainsString('avatars/', $relativeFilePath);
    }

    public function testUploadSuccess()
    {
        $tempFilePath = '/tmp/test.jpg'; // mock file path

        $imageProcessor = m::mock(ImageManager::class);
        $imageProcessor->shouldReceive('make->fit')->once()->andReturnUsing(function () {
            $driver = new Driver();
            $core = imagecreatetruecolor(600, 600);

            $image = new Image($driver, $core);

            return $image;
        });

        $bucket = m::mock(Bucket::class);
        $bucket->shouldReceive('saveFileContent')->andReturnTrue()->once();

        $model  = new UserPhotoUploadForm();
        $model->setImageProcessor($imageProcessor);

        $result = $model->upload($tempFilePath, $bucket);

        $this->assertTrue($result);
    }

    public function testUploadFailed()
    {
        $tempFilePath = '/tmp/test.jpg'; // mock file path

        $imageProcessor = m::mock(ImageManager::class);
        $imageProcessor->shouldReceive('make->fit')->andReturnFalse()->once();

        $bucket = m::mock(Bucket::class);

        $model  = new UserPhotoUploadForm();
        $model->setImageProcessor($imageProcessor);

        $result = $model->upload($tempFilePath, $bucket);

        $this->assertFalse($result);
    }

    public function testSetUserProfilePhoto()
    {
        $user = m::mock(User::class);
        $user->shouldReceive('hasAttribute')->andReturnTrue()->once();
        $user->shouldReceive('save')->andReturnTrue()->once();

        $model            = new UserPhotoUploadForm();
        $relativeFilePath = $model->setUserProfilePhoto($user, 'avatars/my.jpg');

        $this->assertEquals('avatars/my.jpg', $relativeFilePath);
        $this->assertEquals('avatars/my.jpg', $user->photo_url);
    }
}
