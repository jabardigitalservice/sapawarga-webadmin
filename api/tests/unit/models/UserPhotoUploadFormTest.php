<?php

namespace tests\models;

use app\models\UserPhotoUploadForm;
use Spatie\Image\Image;
use yii\web\UploadedFile;

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
                'size'     => 1024 * 1024 * 5, // override
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
}
