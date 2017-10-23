<?php

/**
 * Class ModulesCest
 * Tests /api/v8/modules API
 * @see https://tools.ietf.org/html/rfc7519
 */
class ModulesCest
{
    const RESOURCE = '/api/v8/modules/Accounts';
    private static $RECORD = '11111111-1111-1111-1111-111111111111';

    /**
     * Get list of modules
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-creating
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{id}/meta/language
     *
     */
    public function TestScenarioGetModuleMetaLanguages(apiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();

        $url = $I->getInstanceURL() . self::RESOURCE . '/meta/language';
        $I->sendGET($url);

        $I->seeResponseCodeIs(200);
        $I->seeJsonApiContentNegotiation();

        $response = $I->grabResponse();
        $decodedResponse = json_decode($response, true);

        $I->assertNotEmpty($decodedResponse);
        $I->assertArrayHasKey('meta', $decodedResponse);
        $I->assertArrayHasKey('Accounts', $decodedResponse['meta']);
        $I->assertArrayHasKey('mod_strings', $decodedResponse['meta']['Accounts']);

        $I->assertNotEmpty($decodedResponse['meta']['Accounts']['mod_strings']);
    }

    /**
     * Get list of modules
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-creating
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{id}/meta/attributes
     *
     */
    public function TestScenarioGetModuleMetaAttributes(apiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();

        $url = $I->getInstanceURL() . self::RESOURCE . '/meta/attributes';
        $I->sendGET($url);


        $I->seeResponseCodeIs(200);
        $I->seeJsonApiContentNegotiation();

        $response = $I->grabResponse();
        $decodedResponse = json_decode($response, true);

        $I->assertNotEmpty($decodedResponse);
        $I->assertArrayHasKey('meta', $decodedResponse);
        $I->assertArrayHasKey('Accounts', $decodedResponse['meta']);
        $I->assertArrayHasKey('field_defs', $decodedResponse['meta']['Accounts']);

        $I->assertNotEmpty($decodedResponse['meta']['Accounts']['field_defs']);
    }

}
