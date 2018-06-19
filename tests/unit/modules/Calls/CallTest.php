<?php


class CallTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testCall()
    {
        
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

        
        $this->assertTrue($call->ACLAccess(''));
        

        
        $call->recurring_source = 'test';
        $this->assertFalse($call->ACLAccess('edit'));
        
        
        
        $state->popGlobals();
    }

    public function testSaveAndMarkDeleted()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('calls');
        $state->pushTable('tracker');
        $state->pushTable('vcals');
        $state->pushGlobals();

	
        
        $call = new Call();

        $call->name = 'test';
        $call->id = $call->save();

        
        $this->assertTrue(isset($call->id));
        $this->assertEquals(36, strlen($call->id));

        
        $call->mark_deleted($call->id);
        $result = $call->retrieve($call->id);
        $this->assertEquals(null, $result);
        
        
        
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

        
        $result = $call->get_contacts();
        $this->assertTrue(is_array($result));
    }

    public function testget_summary_text()
    {
        $call = new Call();

        
        $this->assertEquals(null, $call->get_summary_text());

        
        $call->name = 'test';
        $this->assertEquals('test', $call->get_summary_text());
    }

    public function testcreate_list_query()
    {
        self::markTestIncomplete('environment dependency');
        
        $call = new Call();

        
        $expected = "SELECT \n			calls.*,\n			users.user_name as assigned_user_name FROM calls \n			LEFT JOIN users\n			ON calls.assigned_user_id=users.id where  calls.deleted=0   ORDER BY calls.name";
        $actual = $call->create_list_query('', '');
        $this->assertSame($expected, $actual);

        
        $expected = "SELECT \n			calls.*,\n			users.user_name as assigned_user_name FROM calls \n			LEFT JOIN users\n			ON calls.assigned_user_id=users.id where users.user_name=\"\" AND  calls.deleted=0   ORDER BY calls.name";
        $actual = $call->create_list_query('name', 'users.user_name=""');
        $this->assertSame($expected, $actual);
    }

    public function testcreate_export_query()
    {
        $call = new Call();

        
        $expected = 'SELECT calls.*, users.user_name as assigned_user_name  FROM calls   LEFT JOIN users ON calls.assigned_user_id=users.id where calls.deleted=0 ORDER BY calls.name';
        $actual = $call->create_export_query('', '');
        $this->assertSame($expected, $actual);
        

        
        $expected = 'SELECT calls.*, users.user_name as assigned_user_name  FROM calls   LEFT JOIN users ON calls.assigned_user_id=users.id where users.user_name="" AND calls.deleted=0 ORDER BY calls.name';
        $actual = $call->create_export_query('name', 'users.user_name=""');
        $this->assertSame($expected, $actual);
        
    }

    public function testfill_in_additional_detail_fields()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

	
        
        $call = new Call();

        
        $call->fill_in_additional_detail_fields();

        $this->assertEquals('0', $call->duration_hours);
        $this->assertEquals('15', $call->duration_minutes);
        $this->assertEquals(-1, $call->reminder_time);
        $this->assertEquals(false, $call->reminder_checked);
        $this->assertEquals(-1, $call->email_reminder_time);
        $this->assertEquals(false, $call->email_reminder_checked);
        $this->assertEquals('Accounts', $call->parent_type);

        
        
        $state->popGlobals();
    }

    public function testget_list_view_data()
    {
        self::markTestIncomplete('environment dependency (php5/php7)');
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

	
        
        
                
        $call = new Call();

        $current_theme = SugarThemeRegistry::current();

        $call->assigned_user_id = 1;
        $call->created_by = 1;
        $call->modified_user_id = 1;

        
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

        
        
        $state->popGlobals();
    }

    public function testset_notification_body()
    {
        $call = new Call();

        

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

        
        $result = $call->get_call_users();
        $this->assertTrue(is_array($result));
    }

    public function testget_invite_calls()
    {
        $call = new Call();
        $user = new User(1);

        
        $result = $call->get_invite_calls($user);
        $this->assertTrue(is_array($result));
    }

    public function testset_accept_status()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('calls_users');
        $state->pushTable('tracker');
        $state->pushTable('vcals');
        $state->pushGlobals();

	
        
        $call = new Call();
        $call->id = 1;

        
        $user = new User();
        $user->id = '1';

        $call->set_accept_status($user, 'test');

        $call_users = $call->get_linked_beans('users', $call->object_name);
        $this->assertEquals(1, count($call_users));

        $call->delete_linked($call->id);
        
        
        
        $state->popGlobals();
        $state->popTable('vcals');
        $state->popTable('tracker');
        $state->popTable('calls_users');

    }

    public function testget_notification_recipients()
    {
        $call = new Call();

        
        $result = $call->get_notification_recipients();
        $this->assertTrue(is_array($result));

        
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
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

	
        
        $call = new Call();
        $expected = array('MAIN' => 'a', 'PARENT' => 'a', 'CONTACT' => 'a');
        $actual = $call->listviewACLHelper();
        $this->assertSame($expected, $actual);

        
        
        $state->popGlobals();
    }

    public function testsave_relationship_changes()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $call = new Call();

        
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
