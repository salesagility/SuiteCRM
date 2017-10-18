<?php

/**
 * Class ModulesCest
 * Tests /api/v8/modules API
 * @see https://tools.ietf.org/html/rfc7519
 */
class ModulesCest
{
    private static $ACCOUNT_RESOURCE = '/api/v8/modules/Accounts';
    private static $RECORD = '11111111-1111-1111-1111-111111111111';
    private static $RECORD_TYPE = 'Accounts';
    private static $PRODUCT_RESOURCE = '/api/v8/modules/AOS_Products';
    private static $PRODUCT_RECORD_TYPE = 'AOS_Products';
    private static $PRODUCT_RECORD_ID = '11111111-1111-1111-1111-111111111111';
    private static $PRODUCT_CATEGORY_RESOURCE = '/api/v8/modules/AOS_Product_Categories';
    private static $PRODUCT_CATEGORY_RECORD_TYPE = 'AOS_Product_Categories';
    private static $PRODUCT_CATEGORY_RECORD_ID = '11111111-1111-1111-1111-111111111111';
    /**
     * @var Faker\Generator $fakeData
     */
    protected $fakeData;

    /**
     * @var integer $fakeDataSeed
     */
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
     * @see http://jsonapi.org/format/1.0/#crud-creating
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules
     *
     */
    public function TestScenarioListModules(apiTester $I)
    {
        $I->comment('Test list modules');
        $I->sendJsonApiContentNegotiation();
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendGET(
            $I->getInstanceURL() . '/api/v8/modules/meta/list'
        );
        $I->seeResponseCodeIs(200);
        $I->seeJsonApiContentNegotiation();
        $I->seeJsonAPISuccess();
        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayHasKey('meta', $response);
        $I->assertArrayHasKey('modules', $response['meta']);
        $I->assertNotEmpty($response['meta']['modules']);
        $I->assertArrayHasKey('list', $response['meta']['modules']);
        $I->assertNotEmpty($response['meta']['modules']['list']);
    }

    /**
     * Create a new entry with missing type
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-creating
     *
     * HTTP Verb: POST
     * URL: /api/v8/modules/{module_name} (with id in $_POST)
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioCreateWithMissingType(apiTester $I)
    {
        $I->comment('Test missing type');
        $I->sendJsonApiContentNegotiation();
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendPOST(
            $I->getInstanceURL() . self::$ACCOUNT_RESOURCE,
            json_encode(
                array(
                    'data' => array(
                    )
                )
            )
        );
        $I->seeResponseCodeIs(409);
        $I->seeJsonApiContentNegotiation();
        $I->seeJsonApiFailure();
    }

    /**
     * Create a new entry with missing attributes
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-creating
     *
     * HTTP Verb: POST
     * URL: /api/v8/modules/{module_name} (with id in $_POST)
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioCreateWithMissingAttributes(apiTester $I)
    {
        $I->comment('Test required attributes');
        $I->sendJsonApiContentNegotiation();
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendPOST(
            $I->getInstanceURL() . self::$ACCOUNT_RESOURCE,
            json_encode(
                array(
                    'data' => array(
                        'type' => 'Accounts',
                    )
                )
            )
        );
        $I->seeResponseCodeIs(400);
        $I->seeJsonApiContentNegotiation();
        $I->seeJsonApiFailure();
    }


    /**
     * Create a new entry with required fields
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-creating
     *
     * HTTP Verb: POST
     * URL: /api/v8/modules/{module_name} (with id in $_POST)
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioCreateWithMissingRequiredFields(apiTester $I)
    {
        $I->comment('Test required attributes');
        $I->sendJsonApiContentNegotiation();
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendPOST(
            $I->getInstanceURL() . self::$ACCOUNT_RESOURCE,
            json_encode(
                array(
                    'data' => array(
                        'type' => 'Accounts',
                        'attributes' => array()
                    )
                )
            )
        );
        $I->seeResponseCodeIs(400);
        $I->seeJsonApiContentNegotiation();
        $I->seeJsonApiFailure();
    }

    /**
     * Create a new entry
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-creating
     *
     * HTTP Verb: POST
     * URL: /api/v8/modules/{module_name} (with id in $_POST)
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioCreateNew(apiTester $I)
    {
        $faker = \Faker\Factory::create();
        $I->comment('Test create account');
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();
        $I->sendPOST(
            $I->getInstanceURL() . self::$ACCOUNT_RESOURCE,
            json_encode(
                array(
                    'data' => array(
                        'id' => '',
                        'type' => 'Accounts',
                        'attributes' => array(
                            'name' => $faker->name()
                        )
                    )
                )
            )
        );
        $I->seeResponseCodeIs(201);
        $I->seeJsonApiContentNegotiation();
        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayHasKey('data', $response);
        $I->assertArrayHasKey('links', $response);
        $I->assertArrayHasKey('self', $response['links']);
        $I->assertArrayHasKey('type', $response['data']);
        $I->assertArrayHasKey('id', $response['data']);
        $I->assertArrayHasKey('attributes', $response['data']);

        self::$RECORD = $response['data']['id'];
    }

     /**
      * Create a existing entry
      * @param apiTester $I
      * @see http://jsonapi.org/format/1.0/#crud-creating
      *
      * HTTP Verb: POST
      * URL: /api/v8/modules/{module_name} (with id in $_POST)
      * URL: /api/v8/modules/{module_name}/{id}
      *
      */
    public function TestScenarioCreateExisting(apiTester $I)
    {
        $faker = \Faker\Factory::create();

        $I->comment('Test already exists');
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();
        $I->sendPOST(
            $I->getInstanceURL() . self::$ACCOUNT_RESOURCE,
            json_encode(
                array(
                    'data' => array(
                        'id' => self::$RECORD,
                        'type' => 'Accounts',
                        'attributes' => array(
                            'name' => $faker->name()
                        )
                    )
                )
            )
        );
        $I->seeResponseCodeIs(403);
        $I->seeJsonApiContentNegotiation();
        $I->seeJsonApiFailure();
    }

    /**
     * Retrieves an entry
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#fetching
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioRetrieveEntry(apiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();
        $I->sendGET($I->getInstanceURL() . self::$ACCOUNT_RESOURCE .  '/' . self::$RECORD);
        $I->seeResponseCodeIs(200);
        $I->seeJsonAPISuccess();
        $response = json_decode($I->grabResponse(), true);

        $I->assertArrayHasKey('data', $response);
        $I->assertArrayHasKey('id', $response['data']);
        $I->assertArrayHasKey('type', $response['data']);
        $I->assertArrayHasKey('attributes', $response['data']);
        $I->assertArrayHasKey('relationships', $response['data']);
    }

    /**
     * Update entry
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-updating
     *
     * HTTP Verb: POST (update and replace) / PATCH (update and modify)
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioUpdateEntry(apiTester $I)
    {
        $faker = \Faker\Factory::create();

        $I->comment('Test update account');
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();

        $newName = $faker->name();

        $I->sendPATCH(
            $I->getInstanceURL() . self::$ACCOUNT_RESOURCE . '/' . self::$RECORD,
            json_encode(
                array(
                    'data' => array(
                        'id' => self::$RECORD,
                        'type' => 'Accounts',
                        'attributes' => array(
                            'name' => $newName
                        )
                    )
                )
            )
        );

        $I->seeResponseCodeIs(200);
        $I->seeJsonAPISuccess();
        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayHasKey('data', $response);
        $I->assertArrayHasKey('type', $response['data']);
        $I->assertArrayHasKey('id', $response['data']);
        $I->assertArrayHasKey('attributes', $response['data']);
        $I->assertEquals($newName, $response['data']['attributes']['name']);
    }

    /**
     * Update entry
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-deleting
     *
     * HTTP Verb: DELETE
     * URL: /api/v8/modules/{module_name}/{id}
     *
     */
    public function TestScenarioDeleteEntry(apiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();
        $I->sendDELETE($I->getInstanceURL() . self::$ACCOUNT_RESOURCE . '/' . self::$RECORD);
        $I->seeResponseCodeIs(200);
        $I->seeJsonAPISuccess();
    }


    /**
     * Retrieves a list of entries
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#fetching
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}
     */
    public function TestScenarioRetrieveList(apiTester $I)
    {
        // Send Request
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();
        $I->sendGET($I->getInstanceURL() . self::$ACCOUNT_RESOURCE);

        // Validate Response
        $I->seeResponseCodeIs(200);
        $I->seeJsonApiContentNegotiation();
        $I->seeJsonAPISuccess();

        $response = json_decode($I->grabResponse(), true);
        $I->assertArrayHasKey('data', $response);
        $I->assertTrue(is_array($response['data']));

        if(!empty($response['data'])) {
            $I->assertTrue(isset($response['data']['0']));
            $I->assertTrue(isset($response['data']['0']['id']));
            $I->assertTrue(isset($response['data']['0']['type']));
            $I->assertTrue(isset($response['data']['0']['attributes']));
            $I->assertTrue(is_array($response['data']['0']['attributes']));
        }

        $I->assertArrayHasKey('links', $response);
        $I->assertArrayHasKey('self', $response['links']);
    }

    /**
     * Create a relationship (One To Many)
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#fetching-resources-responses
     *
     * HTTP Verb: POST
     * URL: /api/v8/modules/{module_name}
     * URL: /api/v8/modules/{module_name}/relationships/{link}
     */
    public function TestScenarioCreateOneToManyRelationships (apiTester $I)
    {
        $I->loginAsAdmin();
        $I->sendJwtAuthorisation();
        $I->sendJsonApiContentNegotiation();
        // Create AOS_Product_Categories
        $payloadProductCategory = json_encode(
            array (
                'data' => array(
                    'id' => '',
                    'type' =>  self::$PRODUCT_CATEGORY_RECORD_TYPE,
                    'attributes' => array(
                        'name' => $this->fakeData->colorName()
                    ),
                )
            )
        );

        $I->sendPOST(
            $I->getInstanceURL() . self::$PRODUCT_CATEGORY_RESOURCE,
            $payloadProductCategory
        );

        $I->seeResponseCodeIs(201);
        $responseProductCategory = json_decode($I->grabResponse(), true);
        $responseProductCategory['data']['id'];
        self::$PRODUCT_CATEGORY_RECORD_ID = $responseProductCategory['data']['id'];

        // Create AOS_Products
        // Relate Modules Together
        // Send Request
        $payload = json_encode(
            array (
                'data' => array(
                    'id' => '',
                    'type' => self::$PRODUCT_RECORD_TYPE,
                    'attributes' => array(
                        'name' => $this->fakeData->name(),
                        'price' => $this->fakeData->randomDigit()
                    ),
                    'relationships' => array(
                        'aos_product_category' => array(
                            'data' => array(
                                'id' => self::$PRODUCT_CATEGORY_RECORD_ID,
                                'type' => self::$PRODUCT_CATEGORY_RECORD_TYPE
                            )
                        )
                    )
                )
            )
        );

        $I->sendPOST(
            $I->getInstanceURL() . self::$PRODUCT_RESOURCE,
            $payload
        );

        $I->seeResponseCodeIs(201);
        $respsonseProduct = json_decode($I->grabResponse(), true);
        self::$PRODUCT_RECORD_ID = $respsonseProduct['data']['id'];
    }

    /**
     * Retrieve a relationship (One To Many)
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-creating
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}
     * URL: /api/v8/modules/{module_name}/relationships/{link}
     */
    public function TestScenarioRetrieveOneToManyRelationships (apiTester $I)
    {
        // Create AOS_Product
        // Create 1 AOS_Product_Categories records
        // Relate Modules Together
        // Retrieve Product
        // Retrieve relationship
        // Delete objects created
    }

    /**
     * Update a relationship (One To Many)
     * @param apiTester $I
     * @see http://jsonapi.org/format/#crud-updating-relationships
     *
     * HTTP Verb: PATCH
     * URL: /api/v8/modules/{module_name}
     * URL: /api/v8/modules/{module_name}/relationships/{link}
     */
    public function TestScenarioUpdateOneToManyRelationships (apiTester $I)
    {
        // Create AOS_Product
        // Create 2 AOS_Product_Categories records
        // Relate Modules Together
        // Update AOS_Product->AOS_Product_Categories Together
        // Delete objects created
    }

    /**
     * Delete a relationship (One To Many)
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-deleting
     *
     * HTTP Verb: DELETE
     * URL: /api/v8/modules/{module_name}/relationships/{link}
     */
    public function TestScenarioDeleteOneToManyRelationships (apiTester $I)
    {

        // Create AOS_Product
        // Create 2 AOS_Product_Categories records
        // Relate Modules Together
        // Update AOS_Product->AOS_Product_Categories Together
        // Delete objects created
        // TODO: POST {"data": null}
    }


    /**
     * Retrieve a relationship (Many To Many)
     * @param apiTester $I
     * @see http://jsonapi.org/format/#fetching-relationships
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}
     * URL: /api/v8/modules/{module_name}/relationships/{link}
     */
    public function TestScenarioCreateManyToManyRelationships (apiTester $I)
    {
        // Create Subcategories of Product Categories
    }

    /**
     * Retrieve a relationship (Many To Many)
     * @param apiTester $I
     * @see http://jsonapi.org/format/#fetching-relationships
     *
     * HTTP Verb: GET
     * URL: /api/v8/modules/{module_name}
     * URL: /api/v8/modules/{module_name}/relationships/{link}
     */
    public function TestScenarioRetrieveManyToManyRelationships (apiTester $I)
    {
        // Get Subcategories of Product Categories
    }

    /**
     * Replaces a relationship
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-updating-relationships
     *
     * HTTP Verb: PATCH
     * URL: /api/v8/modules/{module_name}
     * URL: /api/v8/modules/{module_name}/relationships/{link}
     */
    public function TestScenarioUpdateManyToManyRelationships (apiTester $I)
    {
        // TODO: Replace the relationships
    }

    /**
     * Removes a relationship
     * @param apiTester $I
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-deleting
     *
     * HTTP Verb: DELETE
     * URL: /api/v8/modules/{module_name}/relationships/{link}
     */
    public function TestScenarioDeleteManyToManyRelationships (apiTester $I)
    {
        // TODO: POST single resource
    }

    /**
     * Clears all related items
     * @param apiTester $I
     * @param apiTester $I
     * @see http://jsonapi.org/format/1.0/#crud-deleting
     *
     * HTTP Verb: DELETE
     * URL: /api/v8/modules/{module_name}/relationships/{link}
     */
    public function TestScenarioDeleteAllManyToManyRelationships (apiTester $I)
    {
        // TODO: POST {"data": []} to clear all relationships
    }
}
