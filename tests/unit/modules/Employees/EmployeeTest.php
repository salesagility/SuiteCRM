<?php

class EmployeeTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testEmployee()
    {

        //execute the contructor and check for the Object type and  attributes
        $employee = new Employee();
        $this->assertInstanceOf('Employee', $employee);
        $this->assertInstanceOf('Person', $employee);
        $this->assertInstanceOf('SugarBean', $employee);

        $this->assertAttributeEquals('Employees', 'module_dir', $employee);
        $this->assertAttributeEquals('Employee', 'object_name', $employee);
        $this->assertAttributeEquals('users', 'table_name', $employee);
        $this->assertAttributeEquals(true, 'new_schema', $employee);
    }


    public function testget_summary_text()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $employee = new Employee();

        //test without setting name
        $this->assertEquals(' ', $employee->get_summary_text());

        //test with name set
        $employee->retrieve(1);
        $this->assertEquals('Administrator', $employee->get_summary_text());
        
        // clean up
        
        
    }


    public function testfill_in_additional_list_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $employee = new Employee();

        //execute the method and test if it works and does not throws an exception.
        try {
            $employee->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testfill_in_additional_detail_fields()
    {
        $employee = new Employee();


        //test with a empty employee bean
        $employee->fill_in_additional_detail_fields();
        $this->assertEquals("", $employee->reports_to_name);


        //test with a valid employee bean
        $employee->retrieve(1);
        $employee->fill_in_additional_detail_fields();
        $this->assertEquals("", $employee->reports_to_name);
    }

    public function testretrieve_employee_id()
    {
        $employee = new Employee();
        //$this->assertEquals('1' ,$employee->retrieve_employee_id('admin'));

        $this->markTestSkipped('Bug in query: employee_name parameter is wrongly used as user_name');
    }


    public function testverify_data()
    {

	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('email_addresses');

	// test
        
        $employee = new Employee();
        $this->assertEquals(true, $employee->verify_data());

        
        // clean up
        
        $state->popTable('email_addresses');
    }

    public function testget_list_view_data()
    {

	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('email_addresses');
        $state->pushTable('tracker');
        
        
        $employee = new Employee();

        $expected = array(
            'SUGAR_LOGIN' => '1',
            'FULL_NAME' => ' ',
            'NAME' => ' ',
            'IS_ADMIN' => '0',
            'EXTERNAL_AUTH_ONLY' => '0',
            'RECEIVE_NOTIFICATIONS' => '1',
            'DELETED' => 0,
            'PORTAL_ONLY' => '0',
            'SHOW_ON_EMPLOYEES' => '1',
            'ENCODED_NAME' => ' ',
            'EMAIL1' => '',
            'EMAIL1_LINK' =>
                '<a class="email-link"'
                . ' onclick="$(document).openComposeViewModal(this);'
                . '" data-module="Employees" data-record-id="" data-module-name=" " data-email-address=""></a>',
            'MESSENGER_TYPE' => '',
            'REPORTS_TO_NAME' => null,
        );

        $actual = $employee->get_list_view_data();
        $this->assertSame($expected, $actual);

        // clean up
        
        $state->popTable('tracker');
        $state->popTable('email_addresses');
        $state->popTable('aod_index');
    }

    public function testlist_view_parse_additional_sections()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $employee = new Employee();

        //execute the method and test if it works and does not throws an exception.
        try {
            $ss = new Sugar_Smarty();
            $employee->list_view_parse_additional_sections($ss, null);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }


    public function testcreate_export_query()
    {
        $employee = new Employee();

        //test with empty string params
        $expected = "SELECT id, user_name, first_name, last_name, description, date_entered, date_modified, modified_user_id, created_by, title, department, is_admin, phone_home, phone_mobile, phone_work, phone_other, phone_fax, address_street, address_city, address_state, address_postalcode, address_country, reports_to_id, portal_only, status, receive_notifications, employee_status, messenger_id, messenger_type, is_group FROM users  WHERE  users.deleted = 0 ORDER BY users.user_name";
        $actual = $employee->create_export_query('', '');
        $this->assertSame($expected, $actual);


        //test with valid string params
        $expected = "SELECT id, user_name, first_name, last_name, description, date_entered, date_modified, modified_user_id, created_by, title, department, is_admin, phone_home, phone_mobile, phone_work, phone_other, phone_fax, address_street, address_city, address_state, address_postalcode, address_country, reports_to_id, portal_only, status, receive_notifications, employee_status, messenger_id, messenger_type, is_group FROM users  WHERE users.user_name=\"\" AND  users.deleted = 0 ORDER BY users.id";
        $actual = $employee->create_export_query('users.id', 'users.user_name=""');
        $this->assertSame($expected, $actual);
    }

    public function testpreprocess_fields_on_save()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $employee = new Employee();

        //execute the method and test if it works and does not throws an exception.
        try {
            $employee->preprocess_fields_on_save();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    /**
     * @todo: NEEDS FIXING!
     */
    public function testcreate_new_list_query()
    {
        /*
    	$employee = new Employee();

    	//test with empty string params
    	$expected = " SELECT  users.* , '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt2.last_name reports_to_name , jt2.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id  FROM users   LEFT JOIN  users jt2 ON users.reports_to_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where ( users.portal_only = 0 ) AND users.deleted=0";
    	$actual = $employee->create_new_list_query('','');
    	$this->assertSame($expected,$actual);


    	//test with valid string params
    	$expected = " SELECT  users.* , '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt2.last_name reports_to_name , jt2.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id  FROM users   LEFT JOIN  users jt2 ON users.reports_to_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where (users.user_name=\"\" and users.portal_only = 0 ) AND users.deleted=0";
    	$actual = $employee->create_new_list_query('users.id','users.user_name=""');
    	$this->assertSame($expected,$actual);
    	*/
        self::markTestIncomplete();
    }


    public function testhasCustomFields()
    {
	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('email_addresses');

	// test
        
        
        $employee = new Employee();
        $result = $employee->hasCustomFields();
        $this->assertEquals(false, $result);
        
        
        // clean up
        
        $state->popTable('email_addresses');
    }
}
