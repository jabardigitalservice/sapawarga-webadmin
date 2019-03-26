<?php

namespace tests\models;

use app\models\User;
use Codeception\Specify;

class UserTest extends \Codeception\Test\Unit
{

    use Specify;

    private $_username = 'username';
    private $_email = 'email';

    public function testValidateUserFields()
    {
        // Validation requires method to be set
        //      The function validateUsername requires Yii::$app->request to determine mode - create or update.
        //      When request method is POST, then mode is creation.
        //      When request mode is PUT, the mode is update.
        $_POST['_method'] = 'post';


        // Tests for 'username' field
        $this->specify(
            'username and email are required',
            function () {
                // Initialise User model
                $user = new User();

                // Verify validation fails as didn't provide any attributes
                $this->assertFalse($user->validate());

                // Verify that the username and email properties are required
                $this->assertTrue($user->hasErrors($this->_username));
                $this->assertTrue($user->hasErrors($this->_email));

                // Set temporary values for username and email
                $user->username = 'username';
                $user->email = 'test@example.com';

                // Verify validation succeed
                $this->assertTrue($user->validate());
            }
        );

        $this->specify(
            'username length must be between 5 and 14 characters',
            function () {
                // Initialise User model
                $user = new User();

                // Set username length as 2
                $user->username = 'ab';
                // Verify that validation must be failed
                $this->assertFalse($user->validate($this->_username));

                // Set username length as 5
                $user->username = 'abcde';
                // Verify that validation must be failed
                $this->assertTrue($user->validate($this->_username));

                // Set username length as 15
                $user->username = 'abcdefghijklmno';
                $this->assertFalse($user->validate($this->_username));
            }
        );

        $this->specify('username must be a combination of lowercase alphanumeric, underscores, and periods', function () {
            $user = new User();

            $user->username = 'user-name';
            $this->assertFalse($user->validate($this->_username));

            $user->username = 'user name';
            $this->assertFalse($user->validate($this->_username));

            $user->username = 'userName';
            $this->assertFalse($user->validate($this->_username));

            $user->username = 'my.user_name01';
            $this->assertTrue($user->validate($this->_username));
        });

        $this->specify('username is unique', function () {
        });


        // Tests for 'email' field
        $this->specify('email username must be less than 255 characters', function () {
            $user = new User();

            $user->email = 'test@example.com';
            $this->assertTrue($user->validate($this->_email));

            $user->email = 'user@4koz0713e0irdqhwlq9vo4osgh1dov14ywb6sxdresfu77zfeldz5ftq0w7o6dmerq2stcrqiwvg8ddzh2sjeot4vrqox9mc7px3k6uren0aqgqo3n63lbcn3mqb68a5fncp9xb51jhgqkmmuay0z6sfhrzgvtbeblvt565et7hqr4lqndfxllvprp02u3juljmdltae9vc2vrewrvvfiqmtnr3mdi2w9dghyzhsf5i585pxfjprk9.com';
            $this->assertFalse($user->validate($this->_email));
        });

        $this->specify('email must be valid', function () {
            $user = new User();

            $user->email = 'test.example.com';
            $this->assertFalse($user->validate($this->_email));

            $user->email = 'test user@example.com';
            $this->assertFalse($user->validate($this->_email));

            $user->email = 'test@example.com';
            $this->assertTrue($user->validate($this->_email));

            $user->email = 'test-user.name01@example.com';
            $this->assertTrue($user->validate($this->_email));
        });

        $this->specify('email is unique', function () {
        });

        $this->specify('password is required on POST method', function () {
        });

        $this->specify('status must be Active or Disabled', function () {
        });

        $this->specify('role must be User, Staff or Admin', function () {
        });


        $this->specify('permission must be valid', function () {
        });
    }
}
