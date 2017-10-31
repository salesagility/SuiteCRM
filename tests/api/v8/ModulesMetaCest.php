<?php

/**
 * Class ModulesMetaCest
 * Tests /api/v8/modules API
 * @see https://tools.ietf.org/html/rfc7519
 */
class ModulesMetaCest
{
    const RESOURCE = '/api/v8/modules/Accounts';
    private static $RECORD = '11111111-1111-1111-1111-111111111111';
    private static $RECORD_TYPE = 'Accounts';
    private static $FAVORITE_RESOURCE = '/api/v8/modules/Favorites';
    private static $ALL_FAVORITE_RESOURCE = '/api/v8/modules/favorites';
    /** @var Faker\Generator $fakeData */
    protected $fakeData;

    /** @var integer $fakeDataSeed */
    protected $fakeDataSeed;


    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        if(!$this->fakeData) {
            $this->fakeData = Faker\Factory::create();
            $this->fakeDataSeed = rand(0, 2048);
        }
        $this->fakeData->seed($this->fakeDataSeed);
    }

    /**
     * Get list of modules
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#document-meta
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/meta/language
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

        $response = $I->grabResponse();
        $decodedResponse = json_decode($response, true);

        $I->assertNotEmpty($decodedResponse);
        $I->assertArrayHasKey('meta', $decodedResponse);
        $I->assertArrayHasKey('Accounts', $decodedResponse['meta']);
        $I->assertArrayHasKey('mod_strings', $decodedResponse['meta']['Accounts']);

        $I->assertNotEmpty($decodedResponse['meta']['Accounts']['mod_strings']);
    }

    /**
     * Get list of fields/attributes of a given module
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#document-meta
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/meta/attributes
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


    /**
     * Get menu metadata of a given module
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#document-meta
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/meta/menu
     *
     */
    public function TestScenarioGetModuleMetaMenu(apiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();

        $url = $I->getInstanceURL() . self::RESOURCE . '/meta/menu';
        $I->sendGET($url);

        $I->seeResponseCodeIs(200);

        $response = $I->grabResponse();
        $decodedResponse = json_decode($response, true);

        $I->assertNotEmpty($decodedResponse);
        $I->assertArrayHasKey('meta', $decodedResponse);
        $I->assertArrayHasKey('Accounts', $decodedResponse['meta']);
        $I->assertArrayHasKey('menu', $decodedResponse['meta']['Accounts']);

        $I->assertNotEmpty($decodedResponse['meta']['Accounts']['menu']);

        $I->assertArrayHasKey(0, $decodedResponse['meta']['Accounts']['menu']);
        $I->assertArrayHasKey('href', $decodedResponse['meta']['Accounts']['menu'][0]);
        $I->assertArrayHasKey('label', $decodedResponse['meta']['Accounts']['menu'][0]);
        $I->assertArrayHasKey('action', $decodedResponse['meta']['Accounts']['menu'][0]);
        $I->assertArrayHasKey('module', $decodedResponse['meta']['Accounts']['menu'][0]);
        $I->assertArrayHasKey('query', $decodedResponse['meta']['Accounts']['menu'][0]);
        $I->assertArrayHasKey('module', $decodedResponse['meta']['Accounts']['menu'][0]['query']);
        $I->assertArrayHasKey('action', $decodedResponse['meta']['Accounts']['menu'][0]['query']);
        $I->assertArrayHasKey('return_module', $decodedResponse['meta']['Accounts']['menu'][0]['query']);
        $I->assertArrayHasKey('return_action', $decodedResponse['meta']['Accounts']['menu'][0]['query']);
    }

    /**
     * Get layout metadata of module view
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#document-meta
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/meta/view/{view}
     * @see \MBConstants for posible {view} values
     */
    public function TestScenarioGetMetaLayout(apiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();

        // Edit View
        $url = $I->getInstanceURL() . self::RESOURCE . '/meta/view/editview';
        $I->sendGET($url);
        $I->seeResponseCodeIs(200);
        $response = $I->grabResponse();
        $decodedResponse = json_decode($response, true);

        $I->assertNotEmpty($decodedResponse);
        $I->assertArrayHasKey('meta', $decodedResponse);
        $I->assertArrayHasKey('Accounts', $decodedResponse['meta']);
        $I->assertArrayHasKey('view', $decodedResponse['meta']['Accounts']);
        $I->assertArrayHasKey('editview', $decodedResponse['meta']['Accounts']['view']);
    }

    /**
     * Get favorites of the current user for a module
     * @param \apiTester $I
     * @see http://jsonapi.org/format/1.0/#document-meta
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module}/favorites
     * @see global $moduleList for posible {module} values
     */
    public function TestScenarioGetModuleFavorites(apiTester $I) {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();

        // Create account
        $I->comment('Create Account');
        $url = $I->getInstanceURL() . self::RESOURCE;
        $accountName = 'Test'. $this->fakeData->name();

        $I->sendPost(
            $url,
            array(
                'data' => array(
                    'id' => '',
                    'type' => 'Accounts',
                    'attributes' => array(
                        'name' => $accountName
                    )
                )
            )
        );

        $I->seeResponseCodeIs(201);
        $I->seeJsonApiContentNegotiation();
        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayHasKey('data', $response);
        $I->assertArrayHasKey('type', $response['data']);
        $I->assertArrayHasKey('id', $response['data']);
        self::$RECORD = $response['data']['id'];

        // Create Favorite
        $I->comment('Create Favorite');
        $url = $I->getInstanceURL() . self::$FAVORITE_RESOURCE;
        $I->sendPost(
            $url,
            array(
                'data' => array(
                    'id' => '',
                    'type' => 'Favorites',
                    'attributes' => array(
                        'name' => 'Accounts ' . self::$RECORD,
                        'assigned_user_id' => 1,
                        'assigned_user_name' => 'admin',
                        'parent_id' => self::$RECORD,
                        'parent_type'=> 'Accounts'
                    )
                )
            )
        );

        $I->seeResponseCodeIs(201);
        $I->seeJsonApiContentNegotiation();
        $response = $I->grabResponse();
        $decodedResponse = json_decode($response, true);

        $I->assertNotEmpty($decodedResponse);
        $I->assertArrayHasKey('data', $decodedResponse);
        $I->assertArrayHasKey('attributes', $decodedResponse['data']);
        $I->assertArrayHasKey('assigned_user_id', $decodedResponse['data']['attributes']);
        $I->assertEquals('1', (string)  $decodedResponse['data']['attributes']['assigned_user_id']);

        // Get Favorite
        $I->comment('Get Favorite');
        $url = $I->getInstanceURL() . self::RESOURCE . '/favorites';
        $I->sendGET($url);
        $I->seeResponseCodeIs(200);
        $response = $I->grabResponse();
        $decodedResponse = json_decode($response, true);

        $I->assertNotEmpty($decodedResponse);
        $I->assertArrayHasKey('data', $decodedResponse);

        if(isset($decodedResponse['data'][0])) {
            // response has many results
            $I->assertArrayHasKey('type', $decodedResponse['data'][0]);
            $I->assertEquals('Accounts', $decodedResponse['data'][0]['type']);
            $I->assertArrayHasKey('id', $decodedResponse['data'][0]);
        } else {
            $I->assertArrayHasKey('type', $decodedResponse['data']);
            $I->assertEquals('Accounts', $decodedResponse['data']['type']);
            $I->assertArrayHasKey('id', $decodedResponse['data']);
            $I->assertEquals(self::$RECORD, $decodedResponse['data']['id']);

        }
    }
    /**
     * Get favorites of the current user all module
     * @param \apiTester $I
     * @see http://jsonapi.org/format/1.0/#document-meta
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/favorites
     * @see global $moduleList for posible {module} values
     */
    public function TestScenarioGetAllModulesFavorites(apiTester $I) {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();

        // Create account
        $I->comment('Create Account');
        $url = $I->getInstanceURL() . self::RESOURCE;
        $accountName = 'Test'. $this->fakeData->name();

        $I->sendPost(
            $url,
            array(
                'data' => array(
                    'id' => '',
                    'type' => 'Accounts',
                    'attributes' => array(
                        'name' => $accountName
                    )
                )
            )
        );

        $I->seeResponseCodeIs(201);
        $I->seeJsonApiContentNegotiation();
        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayHasKey('data', $response);
        $I->assertArrayHasKey('type', $response['data']);
        $I->assertArrayHasKey('id', $response['data']);
        self::$RECORD = $response['data']['id'];

        // Create Favorite
        $I->comment('Create Favorite');
        $url = $I->getInstanceURL() . self::$FAVORITE_RESOURCE;
        $I->sendPost(
            $url,
            array(
                'data' => array(
                    'id' => '',
                    'type' => 'Favorites',
                    'attributes' => array(
                        'name' => 'Accounts ' . self::$RECORD,
                        'assigned_user_id' => 1,
                        'assigned_user_name' => 'admin',
                        'parent_id' => self::$RECORD,
                        'parent_type'=> 'Accounts'
                    )
                )
            )
        );

        $I->seeResponseCodeIs(201);
        $I->seeJsonApiContentNegotiation();
        $response = $I->grabResponse();
        $decodedResponse = json_decode($response, true);

        $I->assertNotEmpty($decodedResponse);
        $I->assertArrayHasKey('data', $decodedResponse);
        $I->assertArrayHasKey('attributes', $decodedResponse['data']);
        $I->assertArrayHasKey('assigned_user_id', $decodedResponse['data']['attributes']);
        $I->assertEquals('1', (string)  $decodedResponse['data']['attributes']['assigned_user_id']);

        // Get Favorite
        $I->comment('Get Favorite');
        $url = $I->getInstanceURL() . self::$ALL_FAVORITE_RESOURCE;
        $I->sendGET($url);
        $I->seeResponseCodeIs(200);
        $response = $I->grabResponse();
        $decodedResponse = json_decode($response, true);

        $I->assertNotEmpty($decodedResponse);
        $I->assertArrayHasKey('data', $decodedResponse);
        $I->assertArrayHasKey('included', $decodedResponse);

        if(isset($decodedResponse['included'][0])) {
            // response has many results
            $I->assertArrayHasKey('type', $decodedResponse['included'][0]);
            $I->assertArrayHasKey('id', $decodedResponse['included'][0]);
        } else {
            $I->assertArrayHasKey('type', $decodedResponse['included']);
            $I->assertArrayHasKey('id', $decodedResponse['included']);
        }
    }

}
