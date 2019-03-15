<?php

namespace tests\models;

use app\models\Guitar;
use Codeception\Specify;
use app\tests\unit\fixtures\GuitarFixture;

class GuitarTest extends \Codeception\Test\Unit
{
    use Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;
    public function _fixtures()
    {
        return [
            'guitar' => [
                'class' => GuitarFixture::className()
            ]
        ];
    }

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

                // Set value for model
                $guitar->model = '0970822106';

                // Verify type of model
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

                // Set brand length to 65
                $guitar->brand = 'iikochepjtqmylfqukssidfnpzwxpzwomyzrexbxnwsrfgqdpgapvlqrhkbcpwcts';
                // Verify that validation must be failed
                $this->assertFalse($guitar->validate());
                // Verify that brand validation contains error message
                $this->assertTrue($guitar->hasErrors('brand'));
            }
        );

        $this->specify(
            'model maximum length must be 64 characters',
            function () {
                $guitar = new Guitar();

                // Null value for model
                // Verify validation succeed
                $this->assertTrue($guitar->validate());

                $guitar->model = '';
                $this->assertTrue($guitar->validate());

                $guitar->model = '0970822106';
                $this->assertTrue($guitar->validate());

                // Set model length to 65
                $guitar->model = '86342742093454017352287799413660443241012033687049443015660497983';
                // Verify that validation must be failed
                $this->assertFalse($guitar->validate());
                // Verify that model validation contains error message
                $this->assertTrue($guitar->hasErrors('model'));
            }
        );
    }

    public function testFindAllGuitar()
    {
        \expect_that(Guitar::find()->all());
    }

    public function testCreateNewGuitar()
    {
        $guitar_brand = 'Jackson';
        $guitar_model = 'ESP MII-NT';

        $guitar = new Guitar();
        $guitar->brand = $guitar_brand;
        $guitar->model = $guitar_model;
        $this->tester->assertEquals(true, $guitar->save());
        $this->tester->assertNotNull($guitar->brand);
        $this->tester->assertEquals($guitar_brand, $guitar->brand);
        $this->tester->assertNotNull($guitar->model);
        $this->tester->assertEquals($guitar_model, $guitar->model);
        $this->tester->assertNotNull($guitar->id);
    }
}
