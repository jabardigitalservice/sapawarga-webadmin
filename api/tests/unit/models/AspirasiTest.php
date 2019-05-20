<?php

namespace tests\unit\models;

use app\models\Aspirasi;

class AspirasiTest extends \Codeception\Test\Unit
{
    public function testValidateFillRequired()
    {
        $model = new Aspirasi();

        $this->assertFalse($model->validate());

        $model->title       = 'test test';
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
        $model = new Aspirasi();

        $model->validate();

        // Mandatory
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

    public function testDescriptionValid()
    {
        $model = new Aspirasi();

        $model->description = 'Ini adalah deskripsi aspirasi';

        $model->validate();

        $this->assertFalse($model->hasErrors('description'));
    }

    public function testDescriptionNotEmpty()
    {
        $model = new Aspirasi();

        $model->description = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('description'));
    }

    public function testDescriptionTooLong()
    {
        $model = new Aspirasi();

        $model->description = file_get_contents(__DIR__ . '/../../data/1000chars.txt');

        $model->validate();

        $this->assertTrue($model->hasErrors('description'));
    }

    public function testDescriptionMinCharacters()
    {
        $model = new Aspirasi();

        $model->description = 'Coba';

        $model->validate();

        $this->assertTrue($model->hasErrors('description'));
    }

    public function testDescriptionNotSafe()
    {
        $model = new Aspirasi();

        $model->description = '<script>alert()</script>';

        $model->validate();

        $this->assertTrue($model->hasErrors('description'));
    }

    public function testAreaMustInteger()
    {
        $model = new Aspirasi();

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
        $model = new Aspirasi();

        $model->category_id = 'test';

        $model->validate();

        $this->assertTrue($model->hasErrors('category_id'));

        $model->category_id = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('category_id'));
    }

    public function testAuthorIdMustInteger()
    {
        $model = new Aspirasi();

        $model->author_id = 'test';

        $model->validate();

        $this->assertTrue($model->hasErrors('author_id'));

        $model->author_id = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('author_id'));
    }

    public function testAttachmentsInputString()
    {
        $model = new Aspirasi();

        $model->attachments = 'test';

        $model->validate();

        $this->assertTrue($model->hasErrors('attachments'));
    }

    public function testAttachmentsInputEmpty()
    {
        $model = new Aspirasi();

        $model->attachments = '';

        $model->validate();

        $this->assertFalse($model->hasErrors('attachments'));
    }

    public function testAttachmentsInputInteger()
    {
        $model = new Aspirasi();

        $model->attachments = 1;

        $model->validate();

        $this->assertTrue($model->hasErrors('attachments'));
    }

    public function testAttachmentsInputInvalidJson()
    {
        $model = new Aspirasi();

        $model->attachments = 'xxxxx';

        $model->validate();

        $this->assertTrue($model->hasErrors('attachments'));
    }

    public function testAttachmentsInputJson()
    {
        $model = new Aspirasi();

        $model->attachments = '{ "type": "photo" }';

        $model->validate();

        $this->assertFalse($model->hasErrors('attachments'));
    }

    public function testStatusInputString()
    {
        $model = new Aspirasi();

        $model->status = 'OK';

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
    }

    public function testStatusInputEmpty()
    {
        $model = new Aspirasi();

        $model->status = '';

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
    }

    public function testStatusInputInteger()
    {
        $model = new Aspirasi();

        $model->status = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
    }

    public function testStatusInputAllowedInteger()
    {
        $model = new Aspirasi();

        // Status = DRAFT
        $model->status = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));

        // Status = PENDING APPROVAL
        $model->status = 2;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));

        // Status = APPROVED
        $model->status = 10;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
    }

    /**
     * Make sure regular user cannot override certain protected attributes
     */
    public function testCreateScenarioUser()
    {
        $model           = new Aspirasi();
        $model->scenario = Aspirasi::SCENARIO_CREATE_USER;

        $model->status     = 10;
        $model->author_id  = 1;
        $model->created_at = 1;
        $model->updated_at = 1;

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
        $this->assertTrue($model->hasErrors('author_id'));
        $this->assertTrue($model->hasErrors('created_at'));
        $this->assertTrue($model->hasErrors('updated_at'));
    }

    public function testCreateScenarioStaff()
    {
        $model           = new Aspirasi();
        $model->scenario = Aspirasi::SCENARIO_CREATE_STAFF;

        $model->status     = 10;
        $model->author_id  = 1;
        $model->created_at = 1;
        $model->updated_at = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
        $this->assertFalse($model->hasErrors('author_id'));

        $this->assertTrue($model->hasErrors('created_at'));
        $this->assertTrue($model->hasErrors('updated_at'));
    }

    /**
     * Make sure regular user cannot override certain protected attributes
     */
    public function testUpdateScenarioUser()
    {
        $model           = new Aspirasi();
        $model->scenario = Aspirasi::SCENARIO_UPDATE_USER;

        $model->status     = 10;
        $model->author_id  = 1;
        $model->created_at = 1;
        $model->updated_at = 1;

        $model->validate();

        $this->assertTrue($model->hasErrors('status'));
        $this->assertTrue($model->hasErrors('author_id'));
        $this->assertTrue($model->hasErrors('created_at'));
        $this->assertTrue($model->hasErrors('updated_at'));
    }

    public function testUpdateScenarioStaff()
    {
        $model           = new Aspirasi();
        $model->scenario = Aspirasi::SCENARIO_UPDATE_STAFF;

        $model->status     = 10;
        $model->author_id  = 1;
        $model->created_at = 1;
        $model->updated_at = 1;

        $model->validate();

        $this->assertFalse($model->hasErrors('status'));
        $this->assertFalse($model->hasErrors('author_id'));

        $this->assertTrue($model->hasErrors('created_at'));
        $this->assertTrue($model->hasErrors('updated_at'));
    }
}
