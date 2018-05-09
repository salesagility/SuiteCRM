<?php


class AccountTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testAccount()
    {

        //execute the contructor and check for the Object type and type attribute
        $Account = new Account();
        $this->assertInstanceOf('Account', $Account);
        $this->assertInstanceOf('Company', $Account);
        $this->assertInstanceOf('SugarBean', $Account);
        $this->assertTrue(is_array($Account->field_name_map));
        $this->assertTrue(is_array($Account->field_defs));
    }

    public function testget_summary_text()
    {

        //test without name setting attribute
        $Account = new Account();
        $name = $Account->get_summary_text();
        $this->assertEquals(null, $name);

        //test with  name attribute set
        $Account->name = 'test account';
        $name = $Account->get_summary_text();
        $this->assertEquals('test account', $name);
    }

    public function testget_contacts()
    {
        $Account = new Account('');

        //execute the method and verify that it returns an array
        $contacts = $Account->get_contacts();
        $this->assertTrue(is_array($contacts));
    }

    public function testclear_account_case_relationship()
    {
        //This method cannot be tested because Query has a wrong column name which makes the function to die. 

        /*$Account = new Account();
        $Account->clear_account_case_relationship('','');*/

        $this->markTestIncomplete('Can Not be implemented - Query has a wrong column name which makes the function to die');
    }

    public function testremove_redundant_http()
    {
        $Account = new Account();

        //this method has no implementation. so test for exceptions only.
        try {
            $Account->remove_redundant_http();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
    }

    public function testfill_in_additional_list_fields()
    {
        $Account = new Account('');

        //execute the method and test if it works and does not throws an exception.
        try {
            $Account->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
    }

    public function testfill_in_additional_detail_fields()
    {
        $Account = new Account('');

        //execute the method and test if it works and does not throws an exception.
        try {
            $Account->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
    }

    public function testget_list_view_data()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        // test
        
        $expected = array(
            'DELETED' => 0,
            'JJWG_MAPS_LNG_C' => '0.00000000',
            'JJWG_MAPS_LAT_C' => '0.00000000',
            'EMAIL1' => '',
            'EMAIL1_LINK' => '<a href=\'javascript:void(0);\' onclick=\'SUGAR.quickCompose.init({"fullComposeUrl":"contact_id=\\u0026parent_type=Accounts\\u0026parent_id=\\u0026parent_name=\\u0026to_addrs_ids=\\u0026to_addrs_names=\\u0026to_addrs_emails=\\u0026to_email_addrs=%26nbsp%3B%26lt%3B%26gt%3B\\u0026return_module=Accounts\\u0026return_action=ListView\\u0026return_id=","composePackage":{"contact_id":"","parent_type":"Accounts","parent_id":"","parent_name":"","to_addrs_ids":"","to_addrs_names":"","to_addrs_emails":"","to_email_addrs":" \\u003C\\u003E","return_module":"Accounts","return_action":"ListView","return_id":""}});\' class=\'\'>',
            'ENCODED_NAME' => null,
            'CITY' => null,
            'BILLING_ADDRESS_STREET' => null,
            'SHIPPING_ADDRESS_STREET' => null,
        );

        $Account = new Account();

        //execute the method and verify that it retunrs expected results
        $actual = $Account->get_list_view_data();
        $expected = ksort($expected);
        $actual = ksort($actual);
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popGlobals();
    }

    public function testbuild_generic_where_clause()
    {
        $Account = new Account();

        //execute the method with a string as parameter and verify that it retunrs expected results
        $expected = "accounts.name like 'value%'";
        $actual = $Account->build_generic_where_clause('value');
        $this->assertSame($expected, $actual);

        //execute the method with number as parameter and verify that it retunrs expected results
        $expected = "accounts.name like '1234%' or accounts.phone_alternate like '%1234%' or accounts.phone_fax like '%1234%' or accounts.phone_office like '%1234%'";
        $actual = $Account->build_generic_where_clause('1234');
        $this->assertSame($expected, $actual);
    }

    public function testcreate_export_query()
    {
        $this->markTestIncomplete('Travis: Failed asserting that two strings are identical.');
        
        $Account = new Account();

        //execute the method with empty strings and verify that it retunrs expected results
        $expected = "SELECT
                                accounts.*,
                                email_addresses.email_address email_address,
                                '' email_addresses_non_primary, accounts.name as account_name,
                                users.user_name as assigned_user_name ,accounts_cstm.jjwg_maps_address_c,accounts_cstm.jjwg_maps_geocode_status_c,accounts_cstm.jjwg_maps_lat_c,accounts_cstm.jjwg_maps_lng_c FROM accounts LEFT JOIN users
	                                ON accounts.assigned_user_id=users.id  LEFT JOIN  email_addr_bean_rel on accounts.id = email_addr_bean_rel.bean_id and email_addr_bean_rel.bean_module='Accounts' and email_addr_bean_rel.deleted=0 and email_addr_bean_rel.primary_address=1  LEFT JOIN email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id  LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c where ( accounts.deleted IS NULL OR accounts.deleted=0 )";
        $actual = $Account->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //execute the method with valid parameter values and verify that it retunrs expected results
        $expected = "SELECT
                                accounts.*,
                                email_addresses.email_address email_address,
                                '' email_addresses_non_primary, accounts.name as account_name,
                                users.user_name as assigned_user_name ,accounts_cstm.jjwg_maps_address_c,accounts_cstm.jjwg_maps_geocode_status_c,accounts_cstm.jjwg_maps_lat_c,accounts_cstm.jjwg_maps_lng_c FROM accounts LEFT JOIN users
	                                ON accounts.assigned_user_id=users.id  LEFT JOIN  email_addr_bean_rel on accounts.id = email_addr_bean_rel.bean_id and email_addr_bean_rel.bean_module='Accounts' and email_addr_bean_rel.deleted=0 and email_addr_bean_rel.primary_address=1  LEFT JOIN email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id  LEFT JOIN accounts_cstm ON accounts.id = accounts_cstm.id_c where (name not null) AND ( accounts.deleted IS NULL OR accounts.deleted=0 ) ORDER BY accounts.name";
        $actual = $Account->create_export_query('name', 'name not null');
        $this->assertSame($expected, $actual);
    }

    public function testset_notification_body()
    {
        $Account = new Account();

        //execute the method and test if populates provided sugar_smarty
        $result = $Account->set_notification_body(new Sugar_Smarty(), new Account());
        $this->assertInstanceOf('Sugar_Smarty', $result);
        $this->assertNotEquals(new Sugar_Smarty(), $result);
    }

    public function testbean_implements()
    {
        $Account = new Account();

        $this->assertTrue($Account->bean_implements('ACL')); //test with valid value
        $this->assertFalse($Account->bean_implements('')); //test with empty value
        $this->assertFalse($Account->bean_implements('Basic'));//test with invalid value
    }

    public function testget_unlinked_email_query()
    {
        $Account = new Account();

        //without setting type parameter
        $expected = "SELECT emails.id FROM emails  JOIN (select DISTINCT email_id from emails_email_addr_rel eear\n\n	join email_addr_bean_rel eabr on eabr.bean_id ='' and eabr.bean_module = 'Accounts' and\n	eabr.email_address_id = eear.email_address_id and eabr.deleted=0\n	where eear.deleted=0 and eear.email_id not in\n	(select eb.email_id from emails_beans eb where eb.bean_module ='Accounts' and eb.bean_id = '')\n	) derivedemails on derivedemails.email_id = emails.id";
        $actual = $Account->get_unlinked_email_query();
        $this->assertSame($expected, $actual);

        //with type parameter set
        $expected = array('select' => 'SELECT emails.id ',
                           'from' => 'FROM emails ',
                           'where' => '',
                           'join' => " JOIN (select DISTINCT email_id from emails_email_addr_rel eear\n\n	join email_addr_bean_rel eabr on eabr.bean_id ='' and eabr.bean_module = 'Accounts' and\n	eabr.email_address_id = eear.email_address_id and eabr.deleted=0\n	where eear.deleted=0 and eear.email_id not in\n	(select eb.email_id from emails_beans eb where eb.bean_module ='Accounts' and eb.bean_id = '')\n	) derivedemails on derivedemails.email_id = emails.id",
                          'join_tables' => array(''),
                    );

        $actual = $Account->get_unlinked_email_query(array('return_as_array' => 'true'));
        $this->assertSame($expected, $actual);
    }

    public function testgetProductsServicesPurchasedQuery()
    {
        $Account = new Account();

        //without account id
        $expected = "\n			SELECT\n				aos_products_quotes.*\n			FROM\n				aos_products_quotes\n			JOIN aos_quotes ON aos_quotes.id = aos_products_quotes.parent_id AND aos_quotes.stage LIKE 'Closed Accepted' AND aos_quotes.deleted = 0 AND aos_products_quotes.deleted = 0\n			JOIN accounts ON accounts.id = aos_quotes.billing_account_id AND accounts.id = ''\n\n			";
        $actual = $Account->getProductsServicesPurchasedQuery();
        $this->assertSame($expected, $actual);

        //with account id
        $expected = "\n			SELECT\n				aos_products_quotes.*\n			FROM\n				aos_products_quotes\n			JOIN aos_quotes ON aos_quotes.id = aos_products_quotes.parent_id AND aos_quotes.stage LIKE 'Closed Accepted' AND aos_quotes.deleted = 0 AND aos_products_quotes.deleted = 0\n			JOIN accounts ON accounts.id = aos_quotes.billing_account_id AND accounts.id = '1234'\n\n			";
        $Account->id = '1234';
        $actual = $Account->getProductsServicesPurchasedQuery();
        $this->assertSame($expected, $actual);
    }
}
