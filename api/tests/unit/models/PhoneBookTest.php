<?php

namespace tests\models;

use app\models\PhoneBook;

class PhoneBookTest extends \Codeception\Test\Unit
{
    public function testValidateFillRequired()
    {
        $model = new PhoneBook();

        $this->assertFalse($model->validate());

        $model->name             = 'test';
        $model->description      = 'test';
        $model->phone_numbers    = [];
        $model->kabkota_id       = 1;
        $model->kec_id           = 1;
        $model->kel_id           = 1;
        $model->seq              = 1;
        $model->cover_image_path = 'test.jpg';
        $model->meta             = null;
        $model->status           = true;

        $this->assertTrue($model->validate());
    }

    public function testValidateRequired()
    {
        $model = new PhoneBook();

        $model->name             = null;
        $model->description      = null;
        $model->phone_numbers    = null;
        $model->kabkota_id       = null;
        $model->kec_id           = null;
        $model->kel_id           = null;
        $model->seq              = null;
        $model->cover_image_path = 'test.jpg';
        $model->meta             = null;
        $model->status           = true;

        $this->assertFalse($model->validate());
    }
}
