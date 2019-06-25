<?php

namespace tests\unit\models;

use app\models\Broadcast;

class BroadcastTest extends \Codeception\Test\Unit
{
    public function testValidateFillRequired()
    {
        $model = new Broadcast();

        $this->assertFalse($model->validate());

        $model->title       = 'test';
        $model->description = 'test';

        $model->kabkota_id  = 1;
        $model->kec_id      = 1;
        $model->kel_id      = 1;
        $model->rw          = '001';
        $model->status      = 10;

        $this->assertTrue($model->validate());
    }

    public function testValidateRequired()
    {
        $model = new Broadcast();

        $model->title       = null;
        $model->description = null;

        $model->kabkota_id  = null;
        $model->kec_id      = null;
        $model->kel_id      = null;
        $model->rw          = null;
        $model->status      = null;

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('title'));
        $this->assertTrue($model->hasErrors('status'));

        $this->assertFalse($model->hasErrors('description'));
        $this->assertFalse($model->hasErrors('kabkota_id'));
        $this->assertFalse($model->hasErrors('kec_id'));
        $this->assertFalse($model->hasErrors('kel_id'));
        $this->assertFalse($model->hasErrors('rw'));
    }

    public function testTitleTooLong()
    {
        $model        = new Broadcast();
        $model->title = 'l5WdQPtZ8J6pEf1vZl2eynOuFP4g8qHXXeyYvE4h0y72QCesFoSyQUGqmVKpbv3tqeqITczwX1DLIFKdX6CjrCoNbJiOGQXzaDhRB5Q45wtPl9OaZDa6dz4jzk58GsXQfAiihEGd9nKCudaoXSBqxf2AITfSlAJ0kH2KaikUBOLrMHniFBPbIs2byQTPVqQ8FbwfJoxjJyga4oSHxPQlDVdgb9DQ1LI3fIMklRHc4itLdlsmOWBxcEVw47nPoIQ6';

        $model->validate();

        $this->assertTrue($model->hasErrors('title'));
    }

    public function testTitleMaxCharactersValid()
    {
        $model        = new Broadcast();
        $model->title = 'Broadcast Title';
        $model->validate();

        $this->assertFalse($model->hasErrors('title'));

        $model->title = 'l5WdQPtZ8J6pEf1vZl2eynOuFP4g8qHXXeyYvE4h0y72QCesFoSyQUGqmVKpbv3tqeqITczwX1DLIFKdX6CjrCoNbJiOGQXzaDhRB5Q45wtPl9OaZDa6dz4jzk58GsXQfAiihEGd9nKCudaoXSBqxf2AITfSlAJ0kH2KaikUBOLrMHniFBPbIs2byQTPVqQ8FbwfJoxjJyga4oSHxPQlDVdgb9DQ1LI3fIMklRHc4itLdlsmOWBxcEVw47nPoIQ';
        $model->validate();

        $this->assertFalse($model->hasErrors('title'));
    }

    public function testRWValidation()
    {
        $model       = new Broadcast();
        $model->rw   = '1';
        $model->validate();
        $this->assertTrue($model->hasErrors('rw'));

        $model->rw   = '0001';
        $model->validate();
        $this->assertTrue($model->hasErrors('rw'));

        $model->rw   = '_a1A.';
        $model->validate();
        $this->assertTrue($model->hasErrors('rw'));

        $model->rw   = '001';
        $model->validate();
        $this->assertFalse($model->hasErrors('rw'));
    }

    public function testKecamatanShouldNull()
    {
        $model             = new Broadcast();
        $model->kabkota_id = null;
        $model->kec_id     = 431;
        $model->kel_id     = 6093;
        $model->rw         = '001';

        $model->save(false);

        $this->assertNull($model->kabkota_id);
        $this->assertNull($model->kec_id);
        $this->assertNull($model->kel_id);
        $this->assertNull($model->rw);
    }

    public function testKelurahanShouldNull()
    {
        $model             = new Broadcast();
        $model->kabkota_id = 22;
        $model->kec_id     = null;
        $model->kel_id     = 6093;
        $model->rw         = '001';

        $model->save(false);

        $this->assertNotNull($model->kabkota_id);
        $this->assertNull($model->kec_id);
        $this->assertNull($model->kel_id);
        $this->assertNull($model->rw);
    }

    public function testRwShouldNull()
    {
        $model             = new Broadcast();
        $model->kabkota_id = 22;
        $model->kec_id     = 431;
        $model->kel_id     = null;
        $model->rw         = '001';

        $model->save(false);

        $this->assertNotNull($model->kabkota_id);
        $this->assertNotNull($model->kec_id);
        $this->assertNull($model->kel_id);
        $this->assertNull($model->rw);
    }
}
