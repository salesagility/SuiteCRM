<?php

/**
 * Class ModulesCest
 * Tests /api/v8/ for the correct response at the top level
 * @see https://tools.ietf.org/html/rfc7519
 */
class JsonApiCest
{
    const RESOURCE = '/api/v8/modules';
    /**
     * Retrieves a list of entries
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#content-negotiation
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules
     */
    public function TestScenarioContentNegotiation(apiTester $I) {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendJwtAuthorisation();
        $I->sendGET($I->getInstanceURL() . self::RESOURCE);
        $I->seeJsonApiContentNegotiation();

        $I->sendJwtContentNegotiation();
        $I->sendGET($I->getInstanceURL() . self::RESOURCE);
        $I->seeResponseCodeIs(415);

        $I->sendJsonApiContentNegotiation();
        $I->setHeader('Accept', 'application/vnd.api+json;charset=UTF');
        $I->sendGET($I->getInstanceURL() . self::RESOURCE);
        $I->seeResponseCodeIs(406);
    }

    /**
     * Retrieves a list of entries
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#errors
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/UnknownModule
     */
    public function TestScenarioErrorObject(apiTester $I) {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendGET($I->getInstanceURL() . self::RESOURCE . '/UnknownModule');
        $I->seeJsonApiContentNegotiation();

        $response = json_decode($I->grabResponse(), true);
        // error
        $I->assertArrayHasKey('errors', $response);
        $errors = $response['errors'];
        $I->assertTrue(is_array($errors));
        $I->assertNotEmpty($errors);
    }
}
