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
        $model->address          = 'test';
        $model->description      = 'test';
        $model->phone_numbers    = [
            'name' => 'Rumah Sakit',
        ];

        $model->kabkota_id       = 1;
        $model->kec_id           = 1;
        $model->kel_id           = 1;
        $model->latitude         = '106.892555609561';
        $model->longitude        = '-6.4804452417756';
        $model->seq              = 1;
        $model->cover_image_path = 'test.jpg';
        $model->meta             = null;
        $model->status           = 10;

        $this->assertTrue($model->validate());
    }

    public function testValidateRequired()
    {
        $model = new PhoneBook();

        $model->name             = null;
        $model->address          = null;
        $model->description      = null;
        $model->phone_numbers    = null;
        $model->kabkota_id       = null;
        $model->kec_id           = null;
        $model->kel_id           = null;
        $model->latitude         = null;
        $model->longitude        = null;
        $model->seq              = null;
        $model->cover_image_path = null;
        $model->meta             = null;
        $model->status           = null;

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('name'));
        $this->assertTrue($model->hasErrors('address'));
        $this->assertTrue($model->hasErrors('phone_numbers'));
        $this->assertTrue($model->hasErrors('kabkota_id'));
        $this->assertTrue($model->hasErrors('seq'));
        $this->assertTrue($model->hasErrors('status'));

        $this->assertFalse($model->hasErrors('description'));
        $this->assertFalse($model->hasErrors('kec_id'));
        $this->assertFalse($model->hasErrors('kel_id'));
        $this->assertFalse($model->hasErrors('latitude'));
        $this->assertFalse($model->hasErrors('longitude'));
        $this->assertFalse($model->hasErrors('cover_image_path'));
        $this->assertFalse($model->hasErrors('meta'));
    }
}
