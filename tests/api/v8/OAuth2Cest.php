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
     * As a Rest API Client, I want to login so that I can get a JWT token
     * @param apiTester $I
     *
     * HTTP Verb: POST
     * URL: /api/oauth/access_token
     */
    public function TestScenarioLogin(apiTester $I)
    {
       $I->loginAsAdmin();
    }
}
