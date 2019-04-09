<?php

namespace tests\unit\models;

use app\models\AspirasiCategory;

class AspirasiCategoryTest extends \Codeception\Test\Unit
{
    public function testValidateFillRequired()
    {
        $model = new AspirasiCategory();

        $this->assertFalse($model->validate());

        $model->name   = 'test';
        $model->status = 10;

        $this->assertTrue($model->validate());
    }

    public function testValidateRequired()
    {
        $model = new AspirasiCategory();

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
        $this->assertTrue($model->hasErrors('status'));
    }

    public function testNameValid()
    {
        $model = new AspirasiCategory();

        $model->name = 'Ini adalah judul';

        $model->validate();

        $this->assertFalse($model->hasErrors('name'));
    }

    public function testNameNotEmpty()
    {
        $model = new AspirasiCategory();

        $model->name = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testNameTooLong()
    {
        $model = new AspirasiCategory();

        $model->name = '9QDdyAqPd35eG06wTaaHilQIk2pEuoftrIBy5FNKdUUwMcyNMl1i3ObgeX9Qome73njU2iQtif8muLml
                2VMPfbkrf2OLsL4wBkvF692wZ7CrkfsaZ6kDswGtFC0Bp2Bb3kL1VnRsrJm7X9AKg8k3gMeLtdeQcqFSyb7q
                ydwBdmRUOSOYgwJLdDtheV7J4cSBYL8p7TmXhr57Vyg7zi2ewTEQ4XLVql3HJmHMXTqyQjWJKktycZNznK0uZ
                lG5FNqAfOZjnyvZW4fityhY9Wf0DPYFro4mapRcLVtWiAqXYIGX';

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testNameMinCharacters()
    {
        $model = new AspirasiCategory();

        $model->name = 'Coba';

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testNameNotSafe()
    {
        $model = new AspirasiCategory();

        $model->name = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testStatusInputString()
    {
        $model = new AspirasiCategory();

        $model->status = 'OK';

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
    }

    public function testStatusInputEmpty()
    {
        $model = new AspirasiCategory();

        $model->status = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
    }

    public function testStatusInputInteger()
    {
        $model = new AspirasiCategory();

        $model->status = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
    }
}
