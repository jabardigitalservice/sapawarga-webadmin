<?php

namespace tests\unit\models;

use app\models\Aspirasi;

class AspirasiTest extends \Codeception\Test\Unit
{
    public function testValidateFillRequired()
    {
        $model = new Aspirasi();

        $this->assertFalse($model->validate());

        $model->title  = 'test';
        $model->status = 10;

        $this->assertTrue($model->validate());
    }
}
