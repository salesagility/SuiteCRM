<?php

class AOS_ProductsTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOS_Products()
    {

        //execute the contructor and check for the Object type and  attributes
        $aosProducts = new AOS_Products();
        $this->assertInstanceOf('AOS_Products', $aosProducts);
        $this->assertInstanceOf('Basic', $aosProducts);
        $this->assertInstanceOf('SugarBean', $aosProducts);

        $this->assertAttributeEquals('AOS_Products', 'module_dir', $aosProducts);
        $this->assertAttributeEquals('AOS_Products', 'object_name', $aosProducts);
        $this->assertAttributeEquals('aos_products', 'table_name', $aosProducts);
        $this->assertAttributeEquals(true, 'new_schema', $aosProducts);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosProducts);
        $this->assertAttributeEquals(true, 'importable', $aosProducts);
    }

    public function testsave()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aos_products');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        $state->pushGlobals();
        
        //error_reporting(E_ERROR | E_PARSE);

        $aosProducts = new AOS_Products();

        $aosProducts->name = 'test';
        $aosProducts->category = 1;
        $aosProducts->product_image = 'test img';
        $_POST['deleteAttachment'] = '1';

        $aosProducts->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aosProducts->id));
        $this->assertEquals(36, strlen($aosProducts->id));
        $this->assertEquals('', $aosProducts->product_image);

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosProducts->mark_deleted($aosProducts->id);
        $result = $aosProducts->retrieve($aosProducts->id);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('aod_index');
        $state->popTable('aos_products');
    }

    public function testgetCustomersPurchasedProductsQuery()
    {
        self::markTestIncomplete('environment dependency');
        
        $aosProducts = new AOS_Products();
        $aosProducts->id = 1;

        //execute the method and verify that it returns expected results
        $expected = "SELECT * FROM (
 				SELECT
					aos_quotes.*,
					accounts.id AS account_id,
					accounts.name AS billing_account,

					opportunity_id AS opportunity,
					billing_contact_id AS billing_contact,
					'' AS created_by_name,
					'' AS modified_by_name,
					'' AS assigned_user_name
				FROM
					aos_products

				JOIN aos_products_quotes ON aos_products_quotes.product_id = aos_products.id AND aos_products.id = '1' AND aos_products_quotes.deleted = 0 AND aos_products.deleted = 0
				JOIN aos_quotes ON aos_quotes.id = aos_products_quotes.parent_id AND aos_quotes.stage = 'Closed Accepted' AND aos_quotes.deleted = 0
				JOIN accounts ON accounts.id = aos_quotes.billing_account_id -- AND accounts.deleted = 0

				GROUP BY accounts.id
			) AS aos_quotes";
        $actual = $aosProducts->getCustomersPurchasedProductsQuery();
        $this->assertSame(trim($expected), trim($actual));
    }
}
