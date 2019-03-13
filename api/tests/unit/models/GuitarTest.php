<?php

namespace tests\models;

use app\models\Guitar;
use Codeception\Specify;

class GuitarTest extends \Codeception\Test\Unit
{
    use Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testValidate()
    {
        $this->specify(
            'type of brand must be string',
            function () {
                // Initialise Guitar model
                $guitar = new Guitar();

                // Set value for brand
                $guitar->brand = 'Fender';

                // Verify type of brand
                $this->assertInternalType('string', $guitar->brand);

                // Verify validation succeed
                $this->assertTrue($guitar->validate());
            }
        );

        $this->specify(
            'type of model must be string',
            function () {
                // Initialise Guitar model
                $guitar = new Guitar();

                // Set value for brand
                $guitar->model = '0970822106';

                // Verify type of brand
                $this->assertInternalType('string', $guitar->model);

                // Verify validation succeed
                $this->assertTrue($guitar->validate());
            }
        );

        $this->specify(
            'brand maximum length must be 64 characters',
            function () {
                $guitar = new Guitar();

                // Null value for brand
                // Verify validation succeed
                $this->assertTrue($guitar->validate());

                $guitar->brand = '';
                $this->assertTrue($guitar->validate());

                $guitar->brand = 'fender';
                $this->assertTrue($guitar->validate());

                // Set username length as 65
                $guitar->brand = 'iikochepjtqmylfqukssidfnpzwxpzwomyzrexbxnwsrfgqdpgapvlqrhkbcpwcts';
                // Verify that validation must be failed
                $this->assertFalse($guitar->validate());
                // Verify that username validation contains error message
                $this->assertTrue($guitar->hasErrors('brand'));
            }
        );

        $this->specify(
            'model maximum length must be 64 characters',
            function () {
                $guitar = new Guitar();

                // Null value for brand
                // Verify validation succeed
                $this->assertTrue($guitar->validate());

                $guitar->model = '';
                $this->assertTrue($guitar->validate());

                $guitar->model = '0970822106';
                $this->assertTrue($guitar->validate());

                // Set username length as 65
                $guitar->model = '86342742093454017352287799413660443241012033687049443015660497983';
                // Verify that validation must be failed
                $this->assertFalse($guitar->validate());
                // Verify that username validation contains error message
                $this->assertTrue($guitar->hasErrors('model'));
            }
        );
    }
}
