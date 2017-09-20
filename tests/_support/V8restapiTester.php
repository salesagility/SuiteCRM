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
class V8restapiTester extends \Codeception\Actor
{
    use _generated\V8restapiTesterActions;

    public function login($username, $password)
    {
        $I = $this;

        /**
         * @var \Helper\PhpBrowserDriverHelper $browserDriverHelper
         */
        $I->sendPOST(
            $I->getInstanceURL().'/api/v8/login',
            array(
                'username' => $username,
                'password' => $password
            )
        );

        $I->canSeeResponseIsJson();

        $response = json_decode($I->grabResponse(), true);
        // http status code
        $I->assertArrayHasKey('status', $response);
        // sesssion id
        $I->assertArrayHasKey('data', $response);
        // status code as a string
        $I->assertArrayHasKey('message', $response);

        $I->assertEquals('200', $response['status']);
        $I->assertEquals('Success', $response['message']);
        $I->assertNotEmpty($response['data']);
    }

    public function loginAsAdmin()
    {
        $I = $this;
        /**
         * @var \Helper\PhpBrowserDriverHelper $browserDriverHelper
         */
        $I->login(
            $I->getAdminUser(),
            $I->getAdminPassword()
        );
    }

    /**
     * Clicks the logout link in the users menu
     */
    public function logout()
    {
        $I = $this;
        /**
         * @var \Helper\PhpBrowserDriverHelper $browserDriverHelper
         */
        $I->sendPOST(
            $I->getInstanceURL().'/api/v8/logout'
        );
        $I->canSeeResponseCodeIs(401);
    }

}
