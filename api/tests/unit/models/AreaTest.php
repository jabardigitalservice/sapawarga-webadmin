<?php

namespace tests\models;

use app\models\Area;
use Codeception\Specify;

class AreaTest extends \Codeception\Test\Unit
{
    use Specify;

    public function testValidateAllRequired()
    {
        $model = new Area();

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('name'));

        $model->parent_id       = 1;
        $model->depth           = 1;
        $model->name            = 'test';
        $model->code_bps        = 'test';
        $model->code_kemendagri = 'test';
        $model->status          = true;

        $this->assertTrue($model->validate());
    }

    public function testValidateEmptyFields()
    {
        $model = new Area();

        $model->code_bps        = 'test';
        $model->code_kemendagri = 'test';
        $model->status          = true;

        $model->validate();

        $this->assertTrue($model->hasErrors('parent_id'));
        $this->assertTrue($model->hasErrors('depth'));
        $this->assertTrue($model->hasErrors('name'));
    }
}
