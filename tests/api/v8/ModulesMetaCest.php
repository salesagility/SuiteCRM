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
    public function TestScenarioListModuleLanguages(apiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();

        $url = $I->getInstanceURL() . self::RESOURCE . '/meta/language';
        $I->sendGET(
            $url
        );

        $I->seeResponseCodeIs(200);
        $I->seeJsonApiContentNegotiation();

        $response = json_decode($I->grabResponse(), true);
        $I->assertNotEmpty($response);
    }
}
