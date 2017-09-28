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
class apiTester extends \Codeception\Actor
{
    use _generated\apiTesterActions;

    const CONTENT_TYPE = 'Content-Type';
    const CONTENT_TYPE_JSON_API = 'application/vnd.api+json';
    const CONTENT_TYPE_JSON = 'application/json';

    /**
     * @var $string $token - Bearer token
     */
    private static $token;

    /**
     * Logins into API
     * @param $username
     * @param $password
     */
    public function login($username, $password)
    {
        $I = $this;

        if(!empty(self::$token)) {
            return;
        }

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

         self::$token = $response['data'];
    }

    /**
     * Login as admin
     */
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
            $I->getInstanceURL() . '/api/v8/logout'
        );
        $I->canSeeResponseCodeIs(401);
    }


    /**
     * Set the Jwt Token
     */
    public function sendJwtAuthorisation()
    {
        $I = $this;
        $I->setHeader('Authorization', 'Bearer '. self::$token);
    }

    /**
     * Set the Required Headers for authentication
     */
    public function sendJwtContentNegotiation()
    {
        $I = $this;
        $I->setHeader(self::CONTENT_TYPE, self::CONTENT_TYPE_JSON);
        $I->setHeader('Accept', 'application/json');
    }

    /**
     * Test to ensure that the response is Jwt
     */
    public function seeJwtContent()
    {
        $I = $this;
        $I->seeHttpHeader(self::CONTENT_TYPE, self::CONTENT_TYPE_JSON);

    }

    /**
     * Set the Required Headers for the Json API content
     */
    public function sendJsonApiContentNegotiation()
    {
        $I = $this;
        $I->setHeader(self::CONTENT_TYPE, self::CONTENT_TYPE_JSON_API);
        $I->setHeader('Accept', 'application/vnd.api+json');
    }

    /**
     * Test to ensure that the response is JSON Api
     */
    public function seeJsonApiContentNegotiation()
    {
        $I = $this;
        $I->seeHttpHeader(self::CONTENT_TYPE, self::CONTENT_TYPE_JSON_API);
    }

    /**
     * Test to ensure that the response is successful
     */
    public function seeJsonAPISuccess()
    {
        $I = $this;
        $I->canSeeResponseIsJson();

        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayNotHasKey('errors', $response);
    }

    /**
     * Test to ensure that the response is successful
     */
    public function seeJsonApiFailure()
    {
        $I = $this;
        $I->canSeeResponseIsJson();

        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayHasKey('errors', $response);
    }
}
