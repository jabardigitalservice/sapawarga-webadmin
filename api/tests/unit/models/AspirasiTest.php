<?php

namespace tests\unit\models;

use app\models\Aspirasi;

class AspirasiTest extends \Codeception\Test\Unit
{
    public function testValidateFillRequired()
    {
        $model = new Aspirasi();

        $this->assertFalse($model->validate());

        $model->title       = 'test';
        $model->description = 'test';
        $model->status      = 10;
        $model->kabkota_id  = 1;
        $model->kec_id      = 1;
        $model->kel_id      = 1;
        $model->author_id   = 1;
        $model->category_id = 1;

        $this->assertTrue($model->validate());
    }

    public function testValidateRequired()
    {
        $model = new Aspirasi();

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
        $this->assertTrue($model->hasErrors('description'));
        $this->assertTrue($model->hasErrors('status'));
        $this->assertTrue($model->hasErrors('kabkota_id'));
        $this->assertTrue($model->hasErrors('kec_id'));
        $this->assertTrue($model->hasErrors('kel_id'));
        $this->assertTrue($model->hasErrors('author_id'));
        $this->assertTrue($model->hasErrors('category_id'));
    }

    public function testTitleValid()
    {
        $model = new Aspirasi();

        $model->title = 'Ini adalah judul';

        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
    }

    public function testTitleNotEmpty()
    {
        $model = new Aspirasi();

        $model->title = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleTooLong()
    {
        $model = new Aspirasi();

        $model->title = '9QDdyAqPd35eG06wTaaHilQIk2pEuoftrIBy5FNKdUUwMcyNMl1i3ObgeX9Qome73njU2iQtif8muLml
                2VMPfbkrf2OLsL4wBkvF692wZ7CrkfsaZ6kDswGtFC0Bp2Bb3kL1VnRsrJm7X9AKg8k3gMeLtdeQcqFSyb7q
                ydwBdmRUOSOYgwJLdDtheV7J4cSBYL8p7TmXhr57Vyg7zi2ewTEQ4XLVql3HJmHMXTqyQjWJKktycZNznK0uZ
                lG5FNqAfOZjnyvZW4fityhY9Wf0DPYFro4mapRcLVtWiAqXYIGX';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleMinCharacters()
    {
        $model = new Aspirasi();

        $model->title = 'Coba';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleNotSafe()
    {
        $model = new Aspirasi();

        $model->title = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }
}
