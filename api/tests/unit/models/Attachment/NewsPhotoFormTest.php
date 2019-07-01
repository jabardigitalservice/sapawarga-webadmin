<?php

namespace tests\models\Attachment;

use app\models\Attachment\NewsPhotoForm;
use Intervention\Image\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Mockery as m;
use yii\web\UploadedFile;

class NewsPhotoFormTest extends \Codeception\Test\Unit
{
    public function testValidateRequired()
    {
        $model = new NewsPhotoForm();

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('file'));
        $this->assertTrue($model->hasErrors('type'));
    }

    public function testValidateSuccess()
    {
        $_FILES = [
            'file' => [
                'tmp_name' => __DIR__ . '/../../../data/example.jpg',
                'name'     => 'example.jpg',
                'type'     => 'image/jpeg ',
                'size'     => 47152,
                'error'    => 0,
            ],
        ];

        $model           = new NewsPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'news_photo';

        $this->assertTrue($model->validate());
    }

    public function testValidateInvalidFileType()
    {
        $_FILES = [
            'file' => [
                'tmp_name' => __DIR__ . '/../../../data/example.txt',
                'name'     => 'example.txt',
                'type'     => 'text/plain',
                'size'     => 2605,
                'error'    => 0,
            ],
        ];

        $model           = new NewsPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'news_photo';

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('file'));
    }

    public function testValidatePngValidMime()
    {
        $_FILES = [
            'file' => [
                'tmp_name' => __DIR__ . '/../../../data/test-valid-mime.png',
                'name'     => 'test-valid-mime.png',
                'type'     => 'image/png',
                'size'     => 2605,
                'error'    => 0,
            ],
        ];

        $model           = new NewsPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'news_photo';

        $model->validate();

        $this->assertFalse($model->hasErrors('file'));
    }

    public function testValidatePngInvalidMime()
    {
        $_FILES = [
            'file' => [
                'tmp_name' => __DIR__ . '/../../../data/test-invalid-mime-jpeg.png',
                'name'     => 'test-invalid-mime-jpeg.png',
                'type'     => 'image/png',
                'size'     => 2605,
                'error'    => 0,
            ],
        ];

        $model           = new NewsPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'news_photo';

        $model->validate();

        $this->assertFalse($model->hasErrors('file'));
    }

    public function testValidateFileSizeValid()
    {
        $_FILES = [
            'file' => [
                'tmp_name' => __DIR__ . '/../../../data/example.jpg',
                'name'     => 'example.jpg',
                'type'     => 'image/jpeg ',
                'size'     => 1024 * 1024 * 2, // override
                'error'    => 0,
            ],
        ];

        $model           = new NewsPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'news_photo';

        $this->assertTrue($model->validate());
    }

    public function testValidateFileSizeBig()
    {
        $_FILES = [
            'file' => [
                'tmp_name' => __DIR__ . '/../../../data/example.jpg',
                'name'     => 'example.jpg',
                'type'     => 'image/jpeg ',
                'size'     => 1024 * 1024 * 3, // override
                'error'    => 0,
            ],
        ];

        $model           = new NewsPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'news_photo';

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('file'));
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

        $model = new NewsPhotoForm();
        $model->setImageProcessor($imageProcessor);

        $image = $model->cropAndResizePhoto($tempFilePath);

        $this->assertEquals($image->getWidth(), 1280);
        $this->assertEquals($image->getHeight(), 720);
    }
}
