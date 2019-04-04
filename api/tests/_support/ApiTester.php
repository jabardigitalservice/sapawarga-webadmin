<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

    public function amUser($username = null)
    {
        if ($username === null) {
            $username = 'user';
        }

        $I = $this;

        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPOST('/v1/user/login', [
            'LoginForm' => [
                'username' => $username,
                'password' => '123456',
            ]
        ]);

        $accessToken = $I->grabDataFromResponseByJsonPath('$.data.access_token');
        $accessToken = $accessToken[0];

        $I->amBearerAuthenticated($accessToken);
    }

    public function amStaff()
    {
        $I = $this;

        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPOST('/v1/staff/login', '{"LoginForm":{"username": "admin","password": "123456"}}');

        $accessToken = $I->grabDataFromResponseByJsonPath('$.data.access_token');
        $accessToken = $accessToken[0];

        $I->amBearerAuthenticated($accessToken);
    }
}
