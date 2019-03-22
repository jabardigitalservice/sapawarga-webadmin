<?php

namespace tests\models;

use app\models\Area;
use Codeception\Specify;

class AreaTest extends \Codeception\Test\Unit
{

    use Specify;

    public function testValidate()
    {
        // Validation requires method to be set
        //      The function validateUsername requires Yii::$app->request to determine mode - create or update.
        //      When request method is POST, then mode is creation.
        //      When request mode is PUT, the mode is update.
        $_POST['_method'] = 'post';

        $this->specify(
            'input is required',
            function () {
                // Initialise User model
                $model = new Area();

                // Verify validation fails as didn't provide any attributes
                $this->assertFalse($model->validate());

                // Verify that the username and password properties are required
                $this->assertTrue($model->hasErrors('name'));

                // Set temporary values data
                $model->parent_id       = 1;
                $model->depth           = 1;
                $model->name            = 'test';
                $model->code_bps        = 'test';
                $model->code_kemendagri = 'test';
                $model->status          = true;

                // Verify validation succeed
                $this->assertTrue($model->validate());
            }
        );
    }
}
