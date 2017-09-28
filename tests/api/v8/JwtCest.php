<?php

/**
 * Class JwtCest
 * Tests Jwt Token Authentication
 * @see https://tools.ietf.org/html/rfc7519
 */
class JwtCest
{
    /**
     * As a Rest API Client, I want to ensure that I get the correct response when I send incorrect details
     * @param apiTester $I
     * @param \Helper\PhpBrowserDriverHelper $browserDriverHelper
     *
     * HTTP Verb: POST
     * URL: /api/v8/login
     */
    public function TestScenarioInvalidLogin(apiTester $I, \Helper\PhpBrowserDriverHelper $browserDriverHelper)
    {
        $I->sendPOST(
            $browserDriverHelper->getInstanceURL().'/api/v8/login',
            array(
                'username' => '',
                'password' => ''
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

        $I->assertEquals('401', $response['status']);
        $I->assertEquals('Unauthorised', $response['message']);
        $I->assertEmpty($response['data']);
    }

    /**
     * As a Rest API Client, I want to login so that I can get a JWT token
     * @param apiTester $I
     *
     * HTTP Verb: POST
     * URL: /api/v8/login
     */
    public function TestScenarioLogin(apiTester $I)
    {
       $I->loginAsAdmin();
    }

    /**
     * As a Rest API Client, I want to log so that I can clear my session
     * @param apiTester $I
     *
     * HTTP Verb: POST
     * URL: /api/v8/logout
     */
    public function TestScenarioLogout(apiTester $I)
    {
        $I->logout();
    }
}
