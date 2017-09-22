<?php

/**
 * Class ModulesCest
 * Tests /api/v8/ for the correct response at the top level
 * @see https://tools.ietf.org/html/rfc7519
 */
class JsonApiCest
{
    /**
     * Retrieves a list of entries
     * @param V8restapiTester $I
     * @see http://jsonapi.org/format/1.0/#content-negotiation
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules
     */
    public function TestScenarioContentNegotiation(V8restapiTester $I) {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendJwtAuthorisation();
        $I->sendGET($I->getInstanceURL() . '/api/v8/modules');
        $response = $I->grabResponse();
        $I->seeJsonApiContentNegotiation();

        $I->sendJwtContentNegotiation();
        $I->sendGET($I->getInstanceURL() . '/api/v8/modules');
        $I->seeResponseCodeIs(415);

        $I->sendJsonApiContentNegotiation();
        $I->setHeader('Accept', 'application/vnd.api+json;charset=UTF');
        $I->sendGET($I->getInstanceURL() . '/api/v8/modules');
        $I->seeResponseCodeIs(406);
    }

    /**
     * Retrieves a list of entries
     * @param V8restapiTester $I
     * @see http://jsonapi.org/format/1.0/#errors
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/UnknownModule
     */
    public function TestScenarioErrorObject(V8restapiTester $I) {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendGET($I->getInstanceURL() . '/api/v8/modules/UnknownModule');
        $I->seeJsonApiContentNegotiation();

        $response = json_decode($I->grabResponse(), true);
        // error
        $I->assertArrayHasKey('errors', $response);
        $I->assertTrue(is_array($response['errors']));
        $I->assertNotEmpty($response['errors']);
    }
}
