<?php

namespace tests\unit\models;

use app\models\Polling;

class PollingTest extends \Codeception\Test\Unit
{
    public function testValidateFillRequired()
    {
        $model = new Polling();

        $this->assertFalse($model->validate());

        $model->name        = 'test test test test';
        $model->description = 'test test';
        $model->excerpt     = 'test test ';
        $model->question    = 'test test test test';
        $model->status      = 10;
        $model->start_date  = '2019-06-01';
        $model->end_date    = '2019-12-01';
        $model->category_id = 1;

        $this->assertTrue($model->validate());
    }

    public function testValidateRequired()
    {
        $model = new Polling();

        $model->validate();

        // Mandatory
        $this->assertTrue($model->hasErrors('name'));
        $this->assertTrue($model->hasErrors('description'));
        $this->assertTrue($model->hasErrors('excerpt'));
        $this->assertTrue($model->hasErrors('question'));
        $this->assertTrue($model->hasErrors('status'));
        $this->assertTrue($model->hasErrors('start_date'));
        $this->assertTrue($model->hasErrors('end_date'));
        $this->assertTrue($model->hasErrors('category_id'));
    }

    public function testNameValid()
    {
        $model = new Polling();

        $model->name = 'Ini adalah judul';

        $model->validate();

        $this->assertFalse($model->hasErrors('name'));
    }

    public function testNameNotEmpty()
    {
        $model = new Polling();

        $model->name = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testNameTooLong()
    {
        $model = new Polling();

        $model->name = '9QDdyAqPd35eG06wTaaHilQIk2pEuoftrIBy5FNKdUUwMcyNMl1i3ObgeX9Qome73njU2iQtif8muLml
                2VMPfbkrf2OLsL4wBkvF692wZ7CrkfsaZ6kDswGtFC0Bp2Bb3kL1VnRsrJm7X9AKg8k3gMeLtdeQcqFSyb7q
                ydwBdmRUOSOYgwJLdDtheV7J4cSBYL8p7TmXhr57Vyg7zi2ewTEQ4XLVql3HJmHMXTqyQjWJKktycZNznK0uZ
                lG5FNqAfOZjnyvZW4fityhY9Wf0DPYFro4mapRcLVtWiAqXYIGX';

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testNameMinCharacters()
    {
        $model = new Polling();

        $model->name = 'Coba';

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testNameMaxCharacters()
    {
        $model = new Polling();

        // allow 255 chars
        $model->name = file_get_contents(__DIR__ . '/../../data/255chars.txt');

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testNameNotSafe()
    {
        $model = new Polling();

        $model->name = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('name'));
    }

    public function testDescriptionValid()
    {
        $model = new Polling();

        $model->description = 'Ini adalah deskripsi aspirasi';

        $model->validate();

        $this->assertFalse($model->hasErrors('description'));
    }

    public function testDescriptionNotEmpty()
    {
        $model = new Polling();

        $model->description = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('description'));
    }

    public function testDescriptionTooLong()
    {
        $model = new Polling();

        $model->description = file_get_contents(__DIR__ . '/../../data/1000chars.txt');

        $model->validate();

        $this->assertTrue($model->hasErrors('description'));
    }

    public function testDescriptionMinCharacters()
    {
        $model = new Polling();

        $model->description = 'Coba';

        $model->validate();

        $this->assertFalse($model->hasErrors('description'));
    }

    public function testDescriptionMaxCharacters()
    {
        $model = new Polling();

        // max 255 chars
        $model->description = file_get_contents(__DIR__ . '/../../data/1000chars.txt');

        $model->validate();

        $this->assertTrue($model->hasErrors('description'));
    }

    public function testDescriptionNotSafe()
    {
        $model = new Polling();

        $model->description = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('description'));
    }

    public function testExcerptValid()
    {
        $model = new Polling();

        $model->excerpt = 'Ini adalah deskripsi aspirasi';

        $model->validate();

        $this->assertFalse($model->hasErrors('excerpt'));
    }

    public function testExcerptNotEmpty()
    {
        $model = new Polling();

        $model->excerpt = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('excerpt'));
    }

    public function testExcerptTooLong()
    {
        $model = new Polling();

        $model->excerpt = file_get_contents(__DIR__ . '/../../data/1000chars.txt');

        $model->validate();

        $this->assertTrue($model->hasErrors('excerpt'));
    }

    public function testExcerptMinCharacters()
    {
        $model = new Polling();

        $model->excerpt = 'Coba';

        $model->validate();

        $this->assertFalse($model->hasErrors('excerpt'));
    }

    public function testExcerptMaxCharacters()
    {
        $model = new Polling();

        // allow 255 chars
        $model->excerpt = file_get_contents(__DIR__ . '/../../data/255chars.txt');

        $model->validate();

        $this->assertFalse($model->hasErrors('excerpt'));
    }

    public function testExcerptNotSafe()
    {
        $model = new Polling();

        $model->excerpt = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('excerpt'));
    }

    public function testQuestionValid()
    {
        $model = new Polling();

        $model->question = 'Ini adalah deskripsi aspirasi';

        $model->validate();

        $this->assertFalse($model->hasErrors('question'));
    }

    public function testQuestionNotEmpty()
    {
        $model = new Polling();

        $model->question = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('question'));
    }

    public function testQuestionTooLong()
    {
        $model = new Polling();

        $model->question = file_get_contents(__DIR__ . '/../../data/1000chars.txt');

        $model->validate();

        $this->assertTrue($model->hasErrors('question'));
    }

    public function testQuestionMinCharacters()
    {
        $model = new Polling();

        $model->question = 'Lorem ipsum';

        $model->validate();

        $this->assertFalse($model->hasErrors('question'));
    }

    public function testQuestionMaxCharacters()
    {
        $model = new Polling();

        // allow 100 chars
        $model->question = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean ma';

        $model->validate();

        $this->assertTrue($model->hasErrors('question'));
    }

    public function testQuestionNotSafe()
    {
        $model = new Polling();

        $model->question = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('question'));
    }

    public function testAreaMustInteger()
    {
        $model = new Polling();

        $model->kabkota_id = 'test';
        $model->kec_id     = 'test';
        $model->kel_id     = 'test';

        $model->validate();

        $this->assertTrue($model->hasErrors('kabkota_id'));
        $this->assertTrue($model->hasErrors('kec_id'));
        $this->assertTrue($model->hasErrors('kel_id'));

        $model->kabkota_id = 1;
        $model->kec_id     = 1;
        $model->kel_id     = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('kabkota_id'));
        $this->assertFalse($model->hasErrors('kec_id'));
        $this->assertFalse($model->hasErrors('kel_id'));
    }

    public function testCategoryIdMustInteger()
    {
        $model = new Polling();

        $model->category_id = 'test';

        $model->validate();

        $this->assertTrue($model->hasErrors('category_id'));

        $model->category_id = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('category_id'));
    }

    public function testStatusInputString()
    {
        $model = new Polling();

        $model->status = 'OK';

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
    }

    public function testStatusInputEmpty()
    {
        $model = new Polling();

        $model->status = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
    }

    public function testStatusInputInteger()
    {
        $model = new Polling();

        $model->status = 10;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
    }

    public function testStatusInputAllowedInteger()
    {
        $model = new Polling();

        // Status = DELETED
        $model->status = -1;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));

        // Status = INACTIVE
        $model->status = 0;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));

        // Status = ACTIVE
        $model->status = 10;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));

        // Status = RANDOM
        $model->status = 100;

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
    }

    public function testStartDateValidValue()
    {
        $model = new Polling();

        $model->start_date = '2019-06-01';
        $model->end_date   = '2019-09-01';

        $model->validate();

        $this->assertFalse($model->hasErrors('start_date'));
    }

    public function testStartDateInvalidStringValue()
    {
        $model = new Polling();

        $model->start_date = 'xxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('start_date'));
    }

    public function testStartDateInvalidIntegerValue()
    {
        $model = new Polling();

        $model->start_date = 100;

        $model->validate();

        $this->assertTrue($model->hasErrors('start_date'));
    }

    public function testStartDateInvalidBooleanValue()
    {
        $model = new Polling();

        $model->start_date = true;

        $model->validate();

        $this->assertTrue($model->hasErrors('start_date'));
    }

    public function testEndDateValidValue()
    {
        $model = new Polling();

        $model->start_date = '2019-06-01';
        $model->end_date   = '2019-09-01';

        $model->validate();

        $this->assertFalse($model->hasErrors('end_date'));
    }

    public function testEndDateInvalidStringValue()
    {
        $model = new Polling();

        $model->end_date = 'xxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('end_date'));
    }

    public function testEndDateInvalidIntegerValue()
    {
        $model = new Polling();

        $model->end_date = 100;

        $model->validate();

        $this->assertTrue($model->hasErrors('end_date'));
    }

    public function testEndDateInvalidBooleanValue()
    {
        $model = new Polling();

        $model->end_date = true;

        $model->validate();

        $this->assertTrue($model->hasErrors('end_date'));
    }

    public function testEndDateAfterStartDate()
    {
        $model = new Polling();

        $model->start_date = '2019-06-01';
        $model->end_date   = '2019-09-01';

        $model->validate();

        $this->assertFalse($model->hasErrors('end_date'));
    }

    public function testEndDateBeforeStartDate()
    {
        $model = new Polling();

        $model->start_date = '2019-09-01';
        $model->end_date   = '2019-06-01';

        $model->validate();

        $this->assertTrue($model->hasErrors('start_date'));
    }

    public function testCreate()
    {
        $model         = new Polling();
        $model->status = 10;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
    }
}
