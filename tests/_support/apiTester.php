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
     * @var $string $accessToken
     */
    private static $accessToken;

    /**
     * @var $string $refreshToken
     */
    private static $refreshToken;

    /**
     * @var $string $tokenType - eg Bearer
     */
    private static $tokenType;

    /**
     * @var int $tokenExpiresIn - eg 3600
     */
    private static $tokenExpiresIn;

    /**
     * Logins into API
     * @param $username
     * @param $password
     */
    public function login($username, $password)
    {
        $I = $this;

        if(!empty(self::$accessToken)) {
            return;
        }

        /**
         * @var \Helper\PhpBrowserDriverHelper $browserDriverHelper
         */
        $I->sendPOST(
            $I->getInstanceURL().'/api/oauth/access_token',
            array(
                'username' => $username,
                'password' => $password,
                'grant_type' => 'password',
                'scope' => '',
                'client_id' => $I->getClientID(),
                'client_secret' => $I->getClientSecret()
            )
        );
        $I->canSeeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        self::$tokenType = $response['token_type'];
        self::$tokenExpiresIn =  (int)$response['expires_in'];
        self::$accessToken = $response['access_token'];
        self::$refreshToken = $response['refresh_token'];
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

    }


    /**
     * Set the Jwt Token
     */
    public function sendJwtAuthorisation()
    {
        $I = $this;
        $I->setHeader('Authorization', self::$tokenType.' '. self::$accessToken);
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
     * Test to ensure that the response isn't successful
     */
    public function seeJsonApiFailure()
    {
        $I = $this;
        $I->canSeeResponseIsJson();

        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayHasKey('errors', $response);
    }
}
