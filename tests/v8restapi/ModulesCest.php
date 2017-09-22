<?php

/**
 * Class ModulesCest
 * Tests /api/v8/modules API
 * @see https://tools.ietf.org/html/rfc7519
 */
class ModulesCest
{
    /**
     * Retrieves a list of entries
     * @param V8restapiTester $I
     * @see http://jsonapi.org/format/1.0/#fetching
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}
     */
    public function TestScenarioRetrieveList(V8restapiTester $I) {
        // Send Request
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();
        $I->sendGET($I->getInstanceURL() . '/api/v8/modules/Users');

        // Validate Response
        $I->seeJsonApiContentNegotiation();
        $I->seeJsonAPISuccess();
        $response = json_decode($I->grabResponse(), true);


        // validate links
        $I->assertArrayHasKey('links', $response);
        $I->assertArrayHasKey('self', $response['links']);
        $I->assertArrayHasKey('first', $response['links']);
        $I->assertArrayHasKey('last', $response['links']);
        $I->assertArrayHasKey('prev', $response['links']);
        $I->assertArrayHasKey('next', $response['links']);

        // validate data
        $I->assertArrayHasKey('data', $response);
    }

    /**
     * Paginate through a list of entries
     * @param V8restapiTester $I
     * @see http://jsonapi.org/format/1.0/#fetching-pagination
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}
     */
    public function TestScenarioPaginateList(V8restapiTester $I) {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendGET($I->getInstanceURL() . '/api/v8/modules/Users');
    }

    /**
     * Retrieves a list of entries using a filter
     * @param V8restapiTester $I
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}?filter[name]=admin
     */
    public function TestScenarioRetrieveFilteredList(V8restapiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendGET($I->getInstanceURL() . '/api/v8/modules/Users');
    }

    /**
     * Retrieves a list of entries in descending order
     * @param V8restapiTester $I
     * @see http://jsonapi.org/format/1.0/#fetching-sorting
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}?sort=-name,date_created
     *
     * ?sort=[-][field name} - sort ascending
     */
    public function TestScenarioRetrieveSortedList(V8restapiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendGET($I->getInstanceURL() . '/api/v8/modules/Users');
    }

    /**
     * Retrieves an entry
     * @param V8restapiTester $I
     * @see http://jsonapi.org/format/1.0/#fetching-sorting
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioRetrieveEntry(V8restapiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendGET($I->getInstanceURL() . '/api/v8/modules/Users/1');
    }

    /**
     * Create a new entry
     * @param V8restapiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-creating
     *
     * HTTP Verb: POST
     * URL: /api/v8/modules/{module_name} (with id in $_POST)
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioCreateNew(V8restapiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendPOST($I->getInstanceURL() . '/api/v8/modules/Users/seed_automated_tester');
    }

    /**
     * Update entry
     * @param V8restapiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-updating
     *
     * HTTP Verb: POST (update and replace) / PATCH (update and modify)
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioUpdateEntry(V8restapiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendPOST($I->getInstanceURL() . '/api/v8/modules/Users/seed_automated_tester');
        $I->sendPATCH($I->getInstanceURL() . '/api/v8/modules/Users/seed_automated_tester');
    }

    /**
     * Update entry
     * @param V8restapiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-deleting
     *
     * HTTP Verb: DELETE
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioDeleteEntry(V8restapiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJsonApiContentNegotiation();
        $I->sendDELETE($I->getInstanceURL() . '/api/v8/modules/Users/seed_automated_tester');
    }
}
