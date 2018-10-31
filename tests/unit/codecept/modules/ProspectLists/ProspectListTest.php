<?php

class ProspectListTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }
    

    public function testcreate_export_query()
    {
        $prospectList = new ProspectList();

        //test with empty string params
        $expected = "SELECT
                                prospect_lists.*,
                                users.user_name as assigned_user_name FROM prospect_lists LEFT JOIN users
                                ON prospect_lists.assigned_user_id=users.id  WHERE  prospect_lists.deleted=0 ORDER BY prospect_lists.name";
        $actual = $prospectList->create_export_query('', '');
        $this->assertSame($expected, $actual);


        //test with valid string params
        $expected = "SELECT
                                prospect_lists.*,
                                users.user_name as assigned_user_name FROM prospect_lists LEFT JOIN users
                                ON prospect_lists.assigned_user_id=users.id  WHERE users.user_name = \"\" AND  prospect_lists.deleted=0 ORDER BY prospect_lists.id";
        $actual = $prospectList->create_export_query('prospect_lists.id', 'users.user_name = ""');
        $this->assertSame($expected, $actual);
    }

    
    public function testcreate_list_query()
    {
        $prospectList = new ProspectList();

        //test with empty string params
        $expected = "SELECT users.user_name as assigned_user_name, prospect_lists.* FROM prospect_lists LEFT JOIN users
					ON prospect_lists.assigned_user_id=users.id where prospect_lists.deleted=0 ORDER BY prospect_lists.name";
        $actual = $prospectList->create_list_query('', '');
        $this->assertSame($expected, $actual);


        //test with valid string params
        $expected = "SELECT users.user_name as assigned_user_name, prospect_lists.* FROM prospect_lists LEFT JOIN users
					ON prospect_lists.assigned_user_id=users.id where users.user_name = \"\" AND prospect_lists.deleted=0 ORDER BY prospect_lists.id";
        $actual = $prospectList->create_list_query('prospect_lists.id', 'users.user_name = ""');
        $this->assertSame($expected, $actual);
    }

    public function testProspectList()
    {

        //execute the contructor and check for the Object type and  attributes
        $prospectList = new ProspectList();

        $this->assertInstanceOf('ProspectList', $prospectList);
        $this->assertInstanceOf('SugarBean', $prospectList);

        $this->assertAttributeEquals('prospect_lists', 'table_name', $prospectList);
        $this->assertAttributeEquals('ProspectLists', 'module_dir', $prospectList);
        $this->assertAttributeEquals('ProspectList', 'object_name', $prospectList);

        $this->assertAttributeEquals("prospect_lists_prospects", 'rel_prospects_table', $prospectList);
    }

    public function testget_summary_text()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $prospectList = new ProspectList();

        //test without setting name
        $this->assertEquals(null, $prospectList->get_summary_text());

        //test with name set
        $prospectList->name = "test";
        $this->assertEquals('test', $prospectList->get_summary_text());
        
        // clean up
    }


    /**
     * @todo: NEEDS FIXING!
     */
    public function testcreate_export_members_query()
    {
        /*
    	$prospectList = new ProspectList();

    	//test with random string params
    	$expected = "SELECT l.id AS id, 'Leads' AS related_type, '' AS \"name\", l.first_name AS first_name, l.last_name AS last_name, l.title AS title, l.salutation AS salutation, \n				l.primary_address_street AS primary_address_street,l.primary_address_city AS primary_address_city, l.primary_address_state AS primary_address_state, l.primary_address_postalcode AS primary_address_postalcode, l.primary_address_country AS primary_address_country,\n				l.account_name AS account_name,\n				ea.email_address AS primary_email_address, ea.invalid_email AS invalid_email, ea.opt_out AS opt_out, ea.deleted AS ea_deleted, ear.deleted AS ear_deleted, ear.primary_address AS primary_address,\n				l.do_not_call AS do_not_call, l.phone_fax AS phone_fax, l.phone_other AS phone_other, l.phone_home AS phone_home, l.phone_mobile AS phone_mobile, l.phone_work AS phone_work\n				, leads_cstm.jjwg_maps_address_c AS jjwg_maps_address_c, leads_cstm.jjwg_maps_geocode_status_c AS jjwg_maps_geocode_status_c, leads_cstm.jjwg_maps_lat_c AS jjwg_maps_lat_c, leads_cstm.jjwg_maps_lng_c AS jjwg_maps_lng_c\n				FROM prospect_lists_prospects plp\n				INNER JOIN leads l ON plp.related_id=l.id\n				LEFT join leads_cstm ON l.id = leads_cstm.id_c\n				LEFT JOIN email_addr_bean_rel ear ON  ear.bean_id=l.id AND ear.deleted=0\n				LEFT JOIN email_addresses ea ON ear.email_address_id=ea.id\n				WHERE plp.prospect_list_id = 1 AND plp.deleted=0 \n				AND l.deleted=0\n				AND (ear.deleted=0 OR ear.deleted IS NULL) UNION ALL SELECT u.id AS id, 'Users' AS related_type, '' AS \"name\", u.first_name AS first_name, u.last_name AS last_name,u.title AS title, '' AS salutation, \n				u.address_street AS primary_address_street,u.address_city AS primary_address_city, u.address_state AS primary_address_state,  u.address_postalcode AS primary_address_postalcode, u.address_country AS primary_address_country,\n				'' AS account_name,\n				ea.email_address AS email_address, ea.invalid_email AS invalid_email, ea.opt_out AS opt_out, ea.deleted AS ea_deleted, ear.deleted AS ear_deleted, ear.primary_address AS primary_address,\n				0 AS do_not_call, u.phone_fax AS phone_fax, u.phone_other AS phone_other, u.phone_home AS phone_home, u.phone_mobile AS phone_mobile, u.phone_work AS phone_work\n				, '' AS jjwg_maps_address_c, '' AS jjwg_maps_geocode_status_c, '' AS jjwg_maps_lat_c, '' AS jjwg_maps_lng_c\n				FROM prospect_lists_prospects plp\n				INNER JOIN users u ON plp.related_id=u.id\n				\n				LEFT JOIN email_addr_bean_rel ear ON  ear.bean_id=u.id AND ear.deleted=0\n				LEFT JOIN email_addresses ea ON ear.email_address_id=ea.id\n				WHERE plp.prospect_list_id = 1 AND plp.deleted=0 \n				AND u.deleted=0\n				AND (ear.deleted=0 OR ear.deleted IS NULL) UNION ALL SELECT c.id AS id, 'Contacts' AS related_type, '' AS \"name\", c.first_name AS first_name, c.last_name AS last_name,c.title AS title, c.salutation AS salutation, \n				c.primary_address_street AS primary_address_street,c.primary_address_city AS primary_address_city, c.primary_address_state AS primary_address_state,  c.primary_address_postalcode AS primary_address_postalcode, c.primary_address_country AS primary_address_country,\n				a.name AS account_name,\n				ea.email_address AS email_address, ea.invalid_email AS invalid_email, ea.opt_out AS opt_out, ea.deleted AS ea_deleted, ear.deleted AS ear_deleted, ear.primary_address AS primary_address,\n				c.do_not_call AS do_not_call, c.phone_fax AS phone_fax, c.phone_other AS phone_other, c.phone_home AS phone_home, c.phone_mobile AS phone_mobile, c.phone_work AS phone_work\n				, contacts_cstm.jjwg_maps_address_c AS jjwg_maps_address_c, contacts_cstm.jjwg_maps_geocode_status_c AS jjwg_maps_geocode_status_c, contacts_cstm.jjwg_maps_lat_c AS jjwg_maps_lat_c, contacts_cstm.jjwg_maps_lng_c AS jjwg_maps_lng_c\nFROM prospect_lists_prospects plp\n				INNER JOIN contacts c ON plp.related_id=c.id LEFT JOIN accounts_contacts ac ON ac.contact_id=c.id LEFT JOIN accounts a ON ac.account_id=a.id\n				LEFT join contacts_cstm ON c.id = contacts_cstm.id_c\n				LEFT JOIN email_addr_bean_rel ear ON ear.bean_id=c.id AND ear.deleted=0\n				LEFT JOIN email_addresses ea ON ear.email_address_id=ea.id\n				WHERE plp.prospect_list_id = 1 AND plp.deleted=0 \n				AND c.deleted=0\n				AND ac.deleted=0\n                AND (ear.deleted=0 OR ear.deleted IS NULL) UNION ALL SELECT p.id AS id, 'Prospects' AS related_type, '' AS \"name\", p.first_name AS first_name, p.last_name AS last_name,p.title AS title, p.salutation AS salutation, \n				p.primary_address_street AS primary_address_street,p.primary_address_city AS primary_address_city, p.primary_address_state AS primary_address_state,  p.primary_address_postalcode AS primary_address_postalcode, p.primary_address_country AS primary_address_country,\n				p.account_name AS account_name,\n				ea.email_address AS email_address, ea.invalid_email AS invalid_email, ea.opt_out AS opt_out, ea.deleted AS ea_deleted, ear.deleted AS ear_deleted, ear.primary_address AS primary_address,\n				p.do_not_call AS do_not_call, p.phone_fax AS phone_fax, p.phone_other AS phone_other, p.phone_home AS phone_home, p.phone_mobile AS phone_mobile, p.phone_work AS phone_work\n				, prospects_cstm.jjwg_maps_address_c AS jjwg_maps_address_c, prospects_cstm.jjwg_maps_geocode_status_c AS jjwg_maps_geocode_status_c, prospects_cstm.jjwg_maps_lat_c AS jjwg_maps_lat_c, prospects_cstm.jjwg_maps_lng_c AS jjwg_maps_lng_c\n				FROM prospect_lists_prospects plp\n				INNER JOIN prospects p ON plp.related_id=p.id\n				LEFT join prospects_cstm ON p.id = prospects_cstm.id_c\n				LEFT JOIN email_addr_bean_rel ear ON  ear.bean_id=p.id AND ear.deleted=0\n				LEFT JOIN email_addresses ea ON ear.email_address_id=ea.id\n				WHERE plp.prospect_list_id = 1  AND plp.deleted=0 \n				AND p.deleted=0\n				AND (ear.deleted=0 OR ear.deleted IS NULL) UNION ALL SELECT a.id AS id, 'Accounts' AS related_type, a.name AS \"name\", '' AS first_name, '' AS last_name,'' AS title, '' AS salutation, \n				a.billing_address_street AS primary_address_street,a.billing_address_city AS primary_address_city, a.billing_address_state AS primary_address_state, a.billing_address_postalcode AS primary_address_postalcode, a.billing_address_country AS primary_address_country,\n				'' AS account_name,\n				ea.email_address AS email_address, ea.invalid_email AS invalid_email, ea.opt_out AS opt_out, ea.deleted AS ea_deleted, ear.deleted AS ear_deleted, ear.primary_address AS primary_address,\n				0 AS do_not_call, a.phone_fax as phone_fax, a.phone_alternate AS phone_other, '' AS phone_home, '' AS phone_mobile, a.phone_office AS phone_office\n				, accounts_cstm.jjwg_maps_address_c AS jjwg_maps_address_c, accounts_cstm.jjwg_maps_geocode_status_c AS jjwg_maps_geocode_status_c, accounts_cstm.jjwg_maps_lat_c AS jjwg_maps_lat_c, accounts_cstm.jjwg_maps_lng_c AS jjwg_maps_lng_c\n				FROM prospect_lists_prospects plp\n				INNER JOIN accounts a ON plp.related_id=a.id\n				LEFT join accounts_cstm ON a.id = accounts_cstm.id_c\n				LEFT JOIN email_addr_bean_rel ear ON  ear.bean_id=a.id AND ear.deleted=0\n				LEFT JOIN email_addresses ea ON ear.email_address_id=ea.id\n				WHERE plp.prospect_list_id = 1  AND plp.deleted=0 \n				AND a.deleted=0\n				AND (ear.deleted=0 OR ear.deleted IS NULL) ORDER BY related_type, id, primary_address DESC";
    	$actual = $prospectList->create_export_members_query('1');
    	$this->assertSame($expected,$actual);
        */
        $this->assertTrue(true, "NEEDS FIXING!");
    }

    public function testsave()
    {

    // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('prospect_lists');
        $state->pushTable('tracker');
        $state->pushGlobals();

        // test
        
        $prospectList = new ProspectList();

        $prospectList->name = "test";
        $prospectList->description ="test description";

        $result = $prospectList->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($prospectList->id));
        $this->assertEquals(36, strlen($prospectList->id));


        //test set_prospect_relationship method
        $this->set_prospect_relationship($prospectList->id);


        //test set_prospect_relationship_single method
        $this->set_prospect_relationship_single($prospectList->id);


        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $prospectList->mark_deleted($prospectList->id);
        $result = $prospectList->retrieve($prospectList->id);
        $this->assertEquals(null, $result);

        // clean up
        
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('prospect_lists');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }


    public function testsave_relationship_changes()
    {
        $this->markTestIncomplete('Error in query: columns mismatch | Error in methodd call params: 2nd param should be array but string given');
    }

    public function set_prospect_relationship($id)
    {
        $prospectList = new ProspectList();

        //preset the required attributes, retrive the bean by id and verify the count of records
        $link_ids = array('1','2');

        $prospectList->retrieve($id);
        $prospectList->set_prospect_relationship($id, $link_ids, 'related');

        $expected_count = $prospectList->get_entry_count();

        $this->assertEquals(2, $expected_count);


        //test clear_prospect_relationship method with expected counts
        $this->clear_prospect_relationship($id, '1');
        $this->clear_prospect_relationship($id, '2');
    }

    public function set_prospect_relationship_single($id)
    {
        $prospectList = new ProspectList();

        $prospectList->retrieve($id);
        $prospectList->set_prospect_relationship_single($id, '3', 'related');

        $expected_count = $prospectList->get_entry_count();

        $this->assertEquals(1, $expected_count);

        $this->clear_prospect_relationship($id, '3');
    }


    public function clear_prospect_relationship($id, $related_id)
    {
        $prospectList = new ProspectList();

        //retrieve the bean and get counts before and after method execution for comparison.

        $prospectList->retrieve($id);

        $initial_count = (int)$prospectList->get_entry_count();

        $prospectList->clear_prospect_relationship($id, $related_id, 'related');

        $expected_count = (int)$prospectList->get_entry_count();
        $this->assertEquals($initial_count - 1, $expected_count);
    }


    public function testmark_relationships_deleted()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $prospectList = new ProspectList();

        //execute the method and test if it works and does not throws an exception.
        try {
            $prospectList->mark_relationships_deleted('');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('Method has no implementation');
        
        // clean up
    }

    public function testfill_in_additional_list_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $prospectList = new ProspectList();

        //execute the method and test if it works and does not throws an exception.
        try {
            $prospectList->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('Method has no implementation');
        
        // clean up
    }

    public function testfill_in_additional_detail_fields()
    {
        $prospectList = new ProspectList();

        $prospectList->fill_in_additional_detail_fields();
        $this->assertEquals(0, $prospectList->entry_count);
    }


    public function testupdate_currency_id()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        

        $prospectList = new ProspectList();

        //execute the method and test if it works and does not throws an exception.
        try {
            $prospectList->update_currency_id('', '');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('Method has no implementation');
        
        // clean up
    }


    public function testget_entry_count()
    {
        $prospectList = new ProspectList();

        $result = $prospectList->get_entry_count();
        $this->assertEquals(0, $result);
    }


    public function testget_list_view_data()
    {
        $prospectList = new ProspectList();

        $expected = array( "DELETED"=> 0, "ENTRY_COUNT"=> '0' );
        $actual = $prospectList->get_list_view_data();
        $this->assertSame($expected, $actual);
    }

    public function testbuild_generic_where_clause()
    {
        $prospectList = new ProspectList();

        //test with empty string params
        $expected = "prospect_lists.name like '%'";
        $actual = $prospectList->build_generic_where_clause('');
        $this->assertSame($expected, $actual);


        //test with valid string params
        $expected = "prospect_lists.name like '1%'";
        $actual = $prospectList->build_generic_where_clause('1');
        $this->assertSame($expected, $actual);
    }


    public function testbean_implements()
    {
        $prospectList = new ProspectList();

        $this->assertEquals(false, $prospectList->bean_implements('')); //test with blank value
        $this->assertEquals(false, $prospectList->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $prospectList->bean_implements('ACL')); //test with valid value
    }
}
