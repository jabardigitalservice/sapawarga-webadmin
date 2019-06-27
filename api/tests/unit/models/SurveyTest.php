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

    public function testTitleMinCharactersShouldFail()
    {
        $model = new Survey();

        // allow min 10 chars
        $model->title = '123';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleMinCharactersSuccess()
    {
        $model = new Survey();

        // allow min 10 chars
        $model->title = '1234567890';

        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
    }

    public function testTitleMaxCharactersShouldFail()
    {
        $model = new Survey();

        // max 100 chars
        // 101 chars should fail
        $model->title = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean ma';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleMaxCharactersSuccess()
    {
        $model = new Survey();

        // max 100 chars
        // 100 chars should success
        $model->title = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean m';

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

    public function testStartDateValidValue()
    {
        $model = new Survey();

        $model->start_date = '2019-06-01';
        $model->end_date   = '2019-09-01';

        $model->validate();

        $this->assertFalse($model->hasErrors('start_date'));
    }

    public function testStartDateInvalidStringValue()
    {
        $model = new Survey();

        $model->start_date = 'xxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('start_date'));
    }

    public function testStartDateInvalidIntegerValue()
    {
        $model = new Survey();

        $model->start_date = 100;

        $model->validate();

        $this->assertTrue($model->hasErrors('start_date'));
    }

    public function testStartDateInvalidBooleanValue()
    {
        $model = new Survey();

        $model->start_date = true;

        $model->validate();

        $this->assertTrue($model->hasErrors('start_date'));
    }

    public function testEndDateValidValue()
    {
        $model = new Survey();

        $model->start_date = '2019-06-01';
        $model->end_date   = '2019-09-01';

        $model->validate();

        $this->assertFalse($model->hasErrors('end_date'));
    }

    public function testEndDateInvalidStringValue()
    {
        $model = new Survey();

        $model->end_date = 'xxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('end_date'));
    }

    public function testEndDateInvalidIntegerValue()
    {
        $model = new Survey();

        $model->end_date = 100;

        $model->validate();

        $this->assertTrue($model->hasErrors('end_date'));
    }

    public function testEndDateInvalidBooleanValue()
    {
        $model = new Survey();

        $model->end_date = true;

        $model->validate();

        $this->assertTrue($model->hasErrors('end_date'));
    }

    public function testEndDateAfterStartDate()
    {
        $model = new Survey();

        $model->start_date = '2019-06-01';
        $model->end_date   = '2019-09-01';

        $model->validate();

        $this->assertFalse($model->hasErrors('end_date'));
    }

    public function testEndDateBeforeStartDate()
    {
        $model = new Survey();

        $model->start_date = '2019-09-01';
        $model->end_date   = '2019-06-01';

        $model->validate();

        $this->assertTrue($model->hasErrors('start_date'));
    }

    public function testErrorEndDateSameStartDate()
    {
        $model = new Survey();

        $model->start_date = '2019-09-01';
        $model->end_date   = '2019-09-01';

        $model->validate();

        $this->assertTrue($model->hasErrors('start_date'));
        $this->assertTrue($model->hasErrors('end_date'));
    }
}
