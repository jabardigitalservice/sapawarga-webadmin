<?php

namespace tests\unit\models;

use app\models\Survey;
use Codeception\Test\Unit;

class SurveyTest extends Unit
{
    public function testTitleRequired()
    {
        $model = new Survey();

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));

        $model->title = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));

        $model->title = 'Ini adalah judul';

        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
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

    public function testCategoryRequired()
    {
        $model = new Survey();

        $model->validate();

        $this->assertTrue($model->hasErrors('category_id'));

        $model->category_id = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('category_id'));

        $model->category_id = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('category_id'));
    }

    public function testCategoryInteger()
    {
        $model = new Survey();

        $model->category_id = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('category_id'));

        $model->category_id = 'xxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('category_id'));
    }

    public function testUrlRequired()
    {
        $model = new Survey();

        $model->validate();

        $this->assertTrue($model->hasErrors('external_url'));

        $model->external_url = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('external_url'));

        $model->external_url = 'http://google.com';

        $model->validate();

        $this->assertFalse($model->hasErrors('external_url'));
    }

    public function testUrlScheme()
    {
        $model = new Survey();

        $model->external_url = 'test';

        $model->validate();

        $this->assertTrue($model->hasErrors('external_url'));

        $model->external_url = 'test.com';

        $model->validate();

        $this->assertTrue($model->hasErrors('external_url'));

        $model->external_url = 'http://google.com';

        $model->validate();

        $this->assertFalse($model->hasErrors('external_url'));
    }
}
