<?php

namespace tests\unit\models;

use app\models\Survey;
use Codeception\Test\Unit;

class SurveyTest extends Unit
{
    public function testTitleValid()
    {
        $model = new Survey();

        $model->title = 'Ini adalah judul';

        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
    }

    public function testTitleNotEmpty()
    {
        $model = new Survey();

        $model->title = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleTooLong()
    {
        $model = new Survey();

        $model->title = '9QDdyAqPd35eG06wTaaHilQIk2pEuoftrIBy5FNKdUUwMcyNMl1i3ObgeX9Qome73njU2iQtif8muLml
                2VMPfbkrf2OLsL4wBkvF692wZ7CrkfsaZ6kDswGtFC0Bp2Bb3kL1VnRsrJm7X9AKg8k3gMeLtdeQcqFSyb7q
                ydwBdmRUOSOYgwJLdDtheV7J4cSBYL8p7TmXhr57Vyg7zi2ewTEQ4XLVql3HJmHMXTqyQjWJKktycZNznK0uZ
                lG5FNqAfOZjnyvZW4fityhY9Wf0DPYFro4mapRcLVtWiAqXYIGX';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleMinCharacters()
    {
        $model = new Survey();

        $model->title = 'Coba';

        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
    }

    public function testTitleMaxCharacters()
    {
        $model = new Survey();

        // allow 255 chars
        $model->title = file_get_contents(__DIR__ . '/../../data/255chars.txt');

        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
    }

    public function testTitleNotSafe()
    {
        $model = new Survey();

        $model->title = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }
}
