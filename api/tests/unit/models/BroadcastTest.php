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
        $model->category_id = 1;
        $model->author_id   = 1;

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
        $model->category_id = null;
        $model->author_id   = null;

        $model->kabkota_id  = null;
        $model->kec_id      = null;
        $model->kel_id      = null;
        $model->rw          = null;
        $model->status      = null;

        $this->assertFalse($model->validate());

        $this->assertTrue($model->hasErrors('title'));
        $this->assertTrue($model->hasErrors('description'));
        $this->assertTrue($model->hasErrors('category_id'));
        $this->assertTrue($model->hasErrors('author_id'));
        $this->assertTrue($model->hasErrors('status'));
    }
}
