<?php

namespace tests\models\Attachment;

use app\models\Attachment\PhoneBookPhotoForm;
use yii\web\UploadedFile;

class PhoneBookPhotoFormTest extends \Codeception\Test\Unit
{
    public function testValidateRequired()
    {
        $model = new PhoneBookPhotoForm();

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('file'));
        $this->assertTrue($model->hasErrors('type'));
    }

    public function testValidatePhoneBookPhotoSuccess()
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

        $model           = new PhoneBookPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'phonebook_photo';

        $this->assertTrue($model->validate());
    }

    public function testValidatePhoneBookPhotoInvalidFileType()
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

        $model           = new PhoneBookPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'phonebook_photo';

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

        $model           = new PhoneBookPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'phonebook_photo';

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

        $model           = new PhoneBookPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'phonebook_photo';

        $model->validate();

        $this->assertFalse($model->hasErrors('file'));
    }

    public function testValidatePhoneBookPhotoFileSizeValid()
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

        $model           = new PhoneBookPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'phonebook_photo';

        $this->assertTrue($model->validate());
    }

    public function testValidatePhoneBookPhotoFileSizeBig()
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

        $model           = new PhoneBookPhotoForm();
        $model->file     = UploadedFile::getInstanceByName('file');
        $model->type     = 'phonebook_photo';

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('file'));
    }
}
