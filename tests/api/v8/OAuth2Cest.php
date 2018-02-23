<?php

/**
 * Class JwtCest
 * Tests Jwt Token Authentication
 * @see https://tools.ietf.org/html/rfc7519
 */
class OAuth2Cest
{
    /**
     * As a Rest API Client, I want to ensure that I get the correct response when I send incorrect details
     * @param apiTester $I
     * @param \Helper\PhpBrowserDriverHelper $browserDriverHelper
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     */
    public function TestScenarioInvalidLogin(apiTester $I, \Helper\PhpBrowserDriverHelper $browserDriverHelper)
    {
        $I->sendPOST(
            $browserDriverHelper->getInstanceURL().'/api/oauth/access_token',
            array(
                'username' => '',
                'password' => ''
            )
        );
        $I->seeResponseCodeIs(400);
    }

    /**
     * I want to ensure that I get the correct response when I send incorrect client details
     * @param apiTester $I
     * @param \Helper\PhpBrowserDriverHelper $browserDriverHelper
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     */
    public function TestScenarioInvalidClient(apiTester $I, \Helper\PhpBrowserDriverHelper $browserDriverHelper)
    {
        $I->sendPOST(
            $I->getInstanceURL().'/api/oauth/access_token',
            array(
                'username' => $I->getAdminUser(),
                'password' => $I->getAdminPassword(),
                'grant_type' => 'password',
                'scope' => '',
                'client_id' => '',
                'client_secret' => ''
            )
        );
        $I->seeResponseCodeIs(401);
    }

    /**
     * I want to make sure only the allowed grant types can be requested for any client
     * @param apiTester $I
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     */
    public function TestScenarioGrantTypeNotAllowed(apiTester $I)
    {
        $client_id = 'API-ea74-c352-badd-c2be-5a8d9c9d4351';
        $client_secret = 'secret';

        $I->sendPOST(
            $I->getInstanceURL().'/api/oauth/access_token',
            array(
                'grant_type' => 'password',
                'client_id' => $client_id,
                'client_secret' => $client_secret
            )
        );

        $I->canSeeResponseIsJson();
        $I->seeResponseCodeIs(400);
    }

    /**
     * As a Rest API Client, I want to login so that I can get a JWT token
     * @param apiTester $I
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     */
    public function TestScenarioLoginWithPasswordGrant(apiTester $I)
    {
        $I->loginAsAdmin();
    }

    /**
     * I want to be able to login with Client Credentials grant type
     * @param apiTester $I
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     */
    public function TestScenarioLoginWithClientCredentialsGrant(apiTester $I)
    {
        $client_id = 'API-ea74-c352-badd-c2be-5a8d9c9d4351';
        $client_secret = 'secret';

        $I->sendPOST(
            $I->getInstanceURL().'/api/oauth/access_token',
            array(
                'grant_type' => 'client_credentials',
                'client_id' => $client_id,
                'client_secret' => $client_secret
            )
        );
        $I->canSeeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }
}
