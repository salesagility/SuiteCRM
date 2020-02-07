<?php


class CallTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testCall()
    {
        //execute the contructor and check for the Object type and  attributes
        $call = new Call();
        $this->assertInstanceOf('Call', $call);
        $this->assertInstanceOf('SugarBean', $call);

        $this->assertAttributeEquals('Calls', 'module_dir', $call);
        $this->assertAttributeEquals('Call', 'object_name', $call);
        $this->assertAttributeEquals('calls', 'table_name', $call);
        $this->assertAttributeEquals('calls_users', 'rel_users_table', $call);
        $this->assertAttributeEquals('calls_contacts', 'rel_contacts_table', $call);
        $this->assertAttributeEquals('calls_leads', 'rel_leads_table', $call);
        $this->assertAttributeEquals(true, 'new_schema', $call);
        $this->assertAttributeEquals(true, 'importable', $call);
        $this->assertAttributeEquals(false, 'syncing', $call);
        $this->assertAttributeEquals(true, 'update_vcal', $call);
        $this->assertAttributeEquals(array(0 => '00', 15 => '15', 30 => '30', 45 => '45'), 'minutes_values', $call);
    }

    public function testACLAccess()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();

        $call = new Call();

        //test without setting recurring_source attribute
        $this->assertTrue($call->ACLAccess(''));
        //$this->assertTrue($call->ACLAccess('edit'));

        //test with recurring_source attribute set
        $call->recurring_source = 'test';
        $this->assertFalse($call->ACLAccess('edit'));
        
        // clean up
        $state->popGlobals();
    }

    public function testSaveAndMarkDeleted()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('calls');
        $state->pushTable('tracker');
        $state->pushTable('vcals');
        $state->pushGlobals();

        // test
        $call = new Call();

        $call->name = 'test';
        $call->id = $call->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($call->id));
        $this->assertEquals(36, strlen($call->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $call->mark_deleted($call->id);
        $result = $call->retrieve($call->id);
        $this->assertEquals(null, $result);
        
        // clean up
        $state->popGlobals();
        $state->popTable('vcals');
        $state->popTable('tracker');
        $state->popTable('calls');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }

    public function testget_contacts()
    {
        $call = new Call();
        $call->id = 1;

        //execute the method and verify if it returns an array
        $result = $call->get_contacts();
        $this->assertTrue(is_array($result));
    }

    public function testget_summary_text()
    {
        $call = new Call();

        //test without setting name
        $this->assertEquals(null, $call->get_summary_text());

        //test with name set
        $call->name = 'test';
        $this->assertEquals('test', $call->get_summary_text());
    }

    public function testcreate_list_query()
    {
        self::markTestIncomplete('environment dependency');
        
        $call = new Call();

        //test with empty string params
        $expected = "SELECT \n			calls.*,\n			users.user_name as assigned_user_name FROM calls \n			LEFT JOIN users\n			ON calls.assigned_user_id=users.id where  calls.deleted=0   ORDER BY calls.name";
        $actual = $call->create_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = "SELECT \n			calls.*,\n			users.user_name as assigned_user_name FROM calls \n			LEFT JOIN users\n			ON calls.assigned_user_id=users.id where users.user_name=\"\" AND  calls.deleted=0   ORDER BY calls.name";
        $actual = $call->create_list_query('name', 'users.user_name=""');
        $this->assertSame($expected, $actual);
    }

    public function testcreate_export_query()
    {
        $call = new Call();

        //test with empty string params
        $expected = 'SELECT calls.*, users.user_name as assigned_user_name  FROM calls   LEFT JOIN users ON calls.assigned_user_id=users.id where calls.deleted=0 ORDER BY calls.name';
        $actual = $call->create_export_query('', '');
        $this->assertSame($expected, $actual);
        

        //test with empty string params
        $expected = 'SELECT calls.*, users.user_name as assigned_user_name  FROM calls   LEFT JOIN users ON calls.assigned_user_id=users.id where users.user_name="" AND calls.deleted=0 ORDER BY calls.name';
        $actual = $call->create_export_query('name', 'users.user_name=""');
        $this->assertSame($expected, $actual);
    }

    public function testfill_in_additional_detail_fields()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

        // test
        $call = new Call();

        //execute the method and verify it sets up the intended fields
        $call->fill_in_additional_detail_fields();

        $this->assertEquals('0', $call->duration_hours);
        $this->assertEquals('15', $call->duration_minutes);
        $this->assertEquals(-1, $call->reminder_time);
        $this->assertEquals(false, $call->reminder_checked);
        $this->assertEquals(-1, $call->email_reminder_time);
        $this->assertEquals(false, $call->email_reminder_checked);
        $this->assertEquals('Accounts', $call->parent_type);

        // clean up
        $state->popGlobals();
    }

    public function testget_list_view_data()
    {
        self::markTestIncomplete('environment dependency (php5/php7)');
        
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

        // test
        //
        //self::markTestIncomplete('environment dependency');
                
        $call = new Call();

        $call->assigned_user_id = 1;
        $call->created_by = 1;
        $call->modified_user_id = 1;

        //execute the method and verify that it retunrs expected results
        $expected = array(
            'MODIFIED_USER_ID' => 1,
            'CREATED_BY' => 1,
            'DELETED' => 0,
            'ASSIGNED_USER_ID' => 1,
            'STATUS' => 'Planned',
            'REMINDER_TIME' => '-1',
            'EMAIL_REMINDER_TIME' => '-1',
            'EMAIL_REMINDER_SENT' => '0',
            'REPEAT_INTERVAL' => '1',
            'SET_COMPLETE' => '',
            'DATE_START' => '<font class=\'overdueTask\'></font>',
            'CONTACT_ID' => null,
            'CONTACT_NAME' => null,
            'PARENT_NAME' => '',
            'REMINDER_CHECKED' => false,
            'EMAIL_REMINDER_CHECKED' => false,
        );

        $actual = $call->get_list_view_data();
        $this->assertSame($expected, $actual);

        $this->assertEquals('Administrator', $call->assigned_user_name);
        $this->assertEquals('Administrator', $call->created_by_name);
        $this->assertEquals('Administrator', $call->modified_by_name);

        // clean up
        $state->popGlobals();
    }

    public function testset_notification_body()
    {
        $call = new Call();

        //test with attributes preset and verify template variables are set accordingly

        $call->name = 'test';
        $call->duration_hours = '1';
        $call->duration_minutes = '10';
        $call->status = 'Planned';
        $call->description = 'some text';
        $call->date_start = '2015-09-01 00:02:03';
        $call->current_notify_user = new User(1);
        $call->current_notify_user->new_assigned_user_name = 'Admin';

        $result = $call->set_notification_body(new Sugar_Smarty(), $call);

        $this->assertEquals($call->name, $result->_tpl_vars['CALL_SUBJECT']);
        $this->assertEquals($call->current_notify_user->new_assigned_user_name, $result->_tpl_vars['CALL_TO']);
        $this->assertEquals($call->duration_hours, $result->_tpl_vars['CALL_HOURS']);
        $this->assertEquals($call->duration_minutes, $result->_tpl_vars['CALL_MINUTES']);
        $this->assertEquals($call->status, $result->_tpl_vars['CALL_STATUS']);
        $this->assertEquals('09/01/2015 00:02 UTC(+00:00)', $result->_tpl_vars['CALL_STARTDATE']);
        $this->assertEquals($call->description, $result->_tpl_vars['CALL_DESCRIPTION']);
    }

    public function testget_call_users()
    {
        $call = new Call();
        $call->id = 1;

        //execute the method and verify it returns an array
        $result = $call->get_call_users();
        $this->assertTrue(is_array($result));
    }

    public function testget_invite_calls()
    {
        $call = new Call();
        $user = new User(1);

        //execute the method and verify it returns an array
        $result = $call->get_invite_calls($user);
        $this->assertTrue(is_array($result));
    }

    public function testset_accept_status()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('calls_users');
        $state->pushTable('tracker');
        $state->pushTable('vcals');
        $state->pushGlobals();

        // test
        $call = new Call();
        $call->id = 1;

        //test for calls Users and delete the created linked records afterwards
        $user = new User();
        $user->id = '1';

        $call->set_accept_status($user, 'test');

        $call_users = $call->get_linked_beans('users', $call->object_name);
        $this->assertEquals(1, count($call_users));

        $call->delete_linked($call->id);
        
        // clean up
        $state->popGlobals();
        $state->popTable('vcals');
        $state->popTable('tracker');
        $state->popTable('calls_users');
    }

    public function testget_notification_recipients()
    {
        $call = new Call();

        //test without setting any user list
        $result = $call->get_notification_recipients();
        $this->assertTrue(is_array($result));

        //test with a user in notofication list set
        $call->users_arr = array(1);
        $result = $call->get_notification_recipients();
        $this->assertTrue(is_array($result));
        $this->assertEquals(1, count($result));
    }

    public function testbean_implements()
    {
        $call = new Call();
        $this->assertEquals(false, $call->bean_implements('')); //test with blank value
        $this->assertEquals(false, $call->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $call->bean_implements('ACL')); //test with valid value
    }

    public function testlistviewACLHelper()
    {
        self::markTestIncomplete('environment dependency');
        
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

        // test
        $call = new Call();
        $expected = array('MAIN' => 'a', 'PARENT' => 'a', 'CONTACT' => 'a');
        $actual = $call->listviewACLHelper();
        $this->assertSame($expected, $actual);

        // clean up
        $state->popGlobals();
    }

    public function testsave_relationship_changes()
    {
        $call = new Call();

        //execute the method and test if it works and does not throws an exception.
        try {
            $call->save_relationship_changes(true);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testgetDefaultStatus()
    {
        $call = new Call();
        $result = $call->getDefaultStatus();
        $this->assertEquals('Planned', $result);
    }
}
