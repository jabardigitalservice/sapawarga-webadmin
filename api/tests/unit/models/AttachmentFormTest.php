<?php

namespace tests\models;

use app\models\AttachmentForm;
use yii\web\UploadedFile;

class AttachmentFormTest extends \Codeception\Test\Unit
{
    public function testValidateRequired()
    {
        $model = new AttachmentForm();

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('file'));
        $this->assertTrue($model->hasErrors('type'));
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

        $model       = new AttachmentForm();
        $model->file = UploadedFile::getInstanceByName('file');
        $model->type = 'phonebook';

        $this->assertTrue($model->validate());
    }
}
