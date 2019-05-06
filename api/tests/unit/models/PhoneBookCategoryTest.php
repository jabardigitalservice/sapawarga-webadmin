<?php

namespace tests\unit\models;

use app\models\category\PhoneBookCategory;

class PhoneBookCategoryTest extends \Codeception\Test\Unit
{
    public function testValidateFillRequired()
    {
        $model = new PhoneBookCategory();

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('name'));
        $this->assertTrue($model->hasErrors('status'));
        $this->assertFalse($model->hasErrors('meta'));
    }

    public function testNameMaxCharactersValid()
    {
        $model       = new PhoneBookCategory();
        $model->name = 'My Name';

        $model->validate();

        $this->assertFalse($model->hasErrors('name'));

        $model->name = 'klARBlYBSY2wqkyuIz3t1A8AXUQLTDX1Ij7raxZ89r9H97hFLOCbi36BpCIr3yi5';

        $model->validate();

        $this->assertFalse($model->hasErrors('name'));
    }

    public function testNameTooLong()
    {
        $model       = new PhoneBookCategory();
        $model->name = 'klARBlYBSY2wqkyuIz3t1A8AXUQLTDX1Ij7raxZ89r9H97hFLOCbi36BpCIr3yi5xxxxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testNameNotSafe()
    {
        $model       = new PhoneBookCategory();
        $model->name = '<script>alert()</script>';

        $model->validate();

        // $this->assertTrue($model->hasErrors('name'));
    }
}
