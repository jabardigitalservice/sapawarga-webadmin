<?php

namespace tests\unit\models;

use app\models\Polling;

class PollingTest extends \Codeception\Test\Unit
{
    public function testValidateFillRequired()
    {
        $model = new Polling();

        $this->assertFalse($model->validate());

        $model->name        = 'test test';
        $model->description = 'test test';
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
        $model = new Polling();

        $model->validate();

        // Mandatory
        $this->assertTrue($model->hasErrors('name'));
        $this->assertTrue($model->hasErrors('description'));
        $this->assertTrue($model->hasErrors('status'));
        $this->assertTrue($model->hasErrors('kabkota_id'));
        $this->assertTrue($model->hasErrors('kec_id'));
        $this->assertTrue($model->hasErrors('kel_id'));
        $this->assertTrue($model->hasErrors('author_id'));
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

        // max 255 chars
        $model->name = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
            Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
            Donec quam felis, ultricies nec, pellentesque eu, pretium quis,';

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

        $this->assertTrue($model->hasErrors('description'));
    }

    public function testDescriptionMaxCharacters()
    {
        $model = new Polling();

        // max 255 chars
        $model->description = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
            Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
            Donec quam felis, ultricies nec, pellentesque eu, pretium quis,';

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

        $this->assertTrue($model->hasErrors('excerpt'));
    }

    public function testExcerptMaxCharacters()
    {
        $model = new Polling();

        // max 255 chars
        $model->excerpt = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. 
            Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. 
            Donec quam felis, ultricies nec, pellentesque eu, pretium quis,';

        $model->validate();

        $this->assertTrue($model->hasErrors('excerpt'));
    }

    public function testExcerptNotSafe()
    {
        $model = new Polling();

        $model->excerpt = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('excerpt'));
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

        $model->status = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
    }

    public function testStatusInputAllowedInteger()
    {
        $model = new Polling();

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

    public function testCreate()
    {
        $model         = new Polling();
        $model->status = 10;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
    }
}
