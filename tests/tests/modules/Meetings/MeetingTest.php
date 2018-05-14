<?php

class MeetingTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    
    protected function storeStateAll() 
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('inbound_email_autoreply');
        $state->pushTable('aod_indexevent');
        $state->pushTable('meetings');
        $state->pushTable('meetings_contacts');
        $state->pushTable('meetings_cstm');
        $state->pushTable('meetings_leads');
        $state->pushTable('meetings_users');
        $state->pushTable('vcals');
        $state->pushTable('inbound_email');
        $state->pushTable('config');
        $state->pushGlobals();
        
        return $state;
    }
    
    protected function restoreStateAll($state) 
    {
        // clean up
        
        $state->popGlobals();
        $state->popTable('config');
        $state->popTable('inbound_email');
        $state->popTable('vcals');
        $state->popTable('meetings_users');
        $state->popTable('meetings_leads');
        $state->popTable('meetings_cstm');
        $state->popTable('meetings_contacts');
        $state->popTable('meetings');
        $state->popTable('aod_indexevent');
        $state->popTable('inbound_email_autoreply');
        
    }
    
    public function testMeeting()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        

        //execute the contructor and check for the Object type and  attributes
        $meeting = new Meeting();

        $this->assertInstanceOf('Meeting', $meeting);
        $this->assertInstanceOf('SugarBean', $meeting);

        $this->assertAttributeEquals('Meetings', 'module_dir', $meeting);
        $this->assertAttributeEquals('Meeting', 'object_name', $meeting);
        $this->assertAttributeEquals('meetings', 'table_name', $meeting);

        $this->assertAttributeEquals(true, 'new_schema', $meeting);
        $this->assertAttributeEquals(true, 'importable', $meeting);
        $this->assertAttributeEquals(false, 'syncing', $meeting);
        $this->assertAttributeEquals(true, 'update_vcal', $meeting);

        $this->assertAttributeEquals('meetings_users', 'rel_users_table', $meeting);
        $this->assertAttributeEquals('meetings_contacts', 'rel_contacts_table', $meeting);
        $this->assertAttributeEquals('meetings_leads', 'rel_leads_table', $meeting);

        $this->assertAttributeEquals(null, 'cached_get_users', $meeting);
        $this->assertAttributeEquals(false, 'date_changed', $meeting);
        
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testACLAccess()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();

        //test without recurring_source
        $this->assertEquals(true, $meeting->ACLAccess('edit'));
        $this->assertEquals(true, $meeting->ACLAccess('save'));
        $this->assertEquals(true, $meeting->ACLAccess('editview'));
        $this->assertEquals(true, $meeting->ACLAccess('delete'));

        //test with recurring_source
        $meeting->recurring_source = 'test';
        $this->assertEquals(false, $meeting->ACLAccess('edit'));
        $this->assertEquals(false, $meeting->ACLAccess('save'));
        $this->assertEquals(false, $meeting->ACLAccess('editview'));
        $this->assertEquals(false, $meeting->ACLAccess('delete'));
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testhasIntegratedMeeting()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        $meeting = new Meeting();
        $result = $meeting->hasIntegratedMeeting();
        $this->assertEquals(false, $result);
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testSaveAndMarkdeletedAndSetAcceptStatus()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        $meeting = new Meeting();

        $meeting->name = 'test';
        $meeting->status = 'Not Held';
        $meeting->type = 'Sugar';
        $meeting->description = 'test description';
        $meeting->duration_hours = 1;
        $meeting->duration_minutes = 1;
        $meeting->date_start = '2016-02-11 17:30:00';
        $meeting->date_end = '2016-02-11 17:30:00';

        $meeting->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($meeting->id));
        $this->assertEquals(36, strlen($meeting->id));

        /* Test set_accept_status method */

        //test set_accept_status with User object
        $user = new User();
        $meeting->set_accept_status($user, 'accept');

        //test set_accept_status with contact object
        $contact = new Contact();
        $meeting->set_accept_status($contact, 'accept');

        //test set_accept_status with Lead object
        $lead = new Lead();
        $meeting->set_accept_status($lead, 'accept');

        //mark all created relationships as deleted
        $meeting->mark_relationships_deleted($meeting->id);

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $meeting->mark_deleted($meeting->id);
        $result = $meeting->retrieve($meeting->id);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testget_summary_text()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        $meeting = new Meeting();

        //test without setting name
        $this->assertEquals(null, $meeting->get_summary_text());

        //test with name set
        $meeting->name = 'test';
        $this->assertEquals('test', $meeting->get_summary_text());
        
        // clean up
        
        $this->restoreStateAll($state);
        
    }

    public function testcreate_export_query()
    {
        $this->markTestIncomplete('environment dependecy');
//        
//        $meeting = new Meeting();
//
//        //test with empty string params
//        $expected = 'SELECT meetings.*, users.user_name as assigned_user_name  ,meetings_cstm.jjwg_maps_lat_c,meetings_cstm.jjwg_maps_address_c,meetings_cstm.jjwg_maps_geocode_status_c,meetings_cstm.jjwg_maps_lng_c FROM meetings   LEFT JOIN users ON meetings.assigned_user_id=users.id  LEFT JOIN meetings_cstm ON meetings.id = meetings_cstm.id_c  where meetings.deleted=0';
//        $actual = $meeting->create_export_query('', '');
//        $this->assertSame($expected, $actual);
//
//        //test with valid string params
//        $expected = 'SELECT meetings.*, users.user_name as assigned_user_name  ,meetings_cstm.jjwg_maps_address_c,meetings_cstm.jjwg_maps_geocode_status_c,meetings_cstm.jjwg_maps_lat_c,meetings_cstm.jjwg_maps_lng_c FROM meetings   LEFT JOIN users ON meetings.assigned_user_id=users.id  LEFT JOIN meetings_cstm ON meetings.id = meetings_cstm.id_c  where users.user_name="" AND meetings.deleted=0';
//        $actual = $meeting->create_export_query('meetings.id', 'users.user_name=""');
//        $this->assertSame($expected, $actual);
        
    }

    public function testfill_in_additional_detail_fields()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        $meeting = new Meeting();

        //preset required attributes
        $meeting->assigned_user_id = 1;
        $meeting->modified_user_id = 1;
        $meeting->created_by = 1;
        $meeting->contact_id = 1;

        $meeting->fill_in_additional_detail_fields();

        //verify effected atributes
        $this->assertEquals('Administrator', $meeting->assigned_user_name);
        $this->assertEquals('Administrator', $meeting->created_by_name);
        $this->assertEquals('Administrator', $meeting->modified_by_name);
        $this->assertTrue(isset($meeting->time_start_hour));
        $this->assertTrue(isset($meeting->date_start));
        $this->assertTrue(isset($meeting->time_start));
        $this->assertTrue(isset($meeting->duration_hours));
        $this->assertTrue(isset($meeting->duration_minutes));
        $this->assertEquals(-1, $meeting->reminder_time);
        $this->assertTrue(isset($meeting->reminder_time));
        $this->assertEquals(false, $meeting->reminder_checked);
        $this->assertEquals(-1, $meeting->email_reminder_time);
        $this->assertEquals(false, $meeting->email_reminder_checked);
        $this->assertEquals('Accounts', $meeting->parent_type);
        
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testget_list_view_data()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        $meeting = new Meeting();
        $current_theme = SugarThemeRegistry::current();

        //preset required attribute values
        $meeting->status == 'Planned';
        $meeting->parent_type = 'Accounts';
        $meeting->contact_id = 1;
        $meeting->contact_name = 'test';
        $meeting->parent_name = 'Account';

        $expected = array(
                      'DELETED' => 0,
                      'PARENT_TYPE' => 'Accounts',
                      'STATUS' => 'Planned',
                      'TYPE' => 'Sugar',
                      'REMINDER_TIME' => '-1',
                      'EMAIL_REMINDER_TIME' => '-1',
                      'EMAIL_REMINDER_SENT' => '0',
                      'SEQUENCE' => '0',
                      'CONTACT_NAME' => 'test',
                      'PARENT_NAME' => '',
                      'CONTACT_ID' => 1,
                      'REPEAT_INTERVAL' => '1',
                      'PARENT_MODULE' => 'Accounts',
                      'SET_COMPLETE' => '<a id=\'\' onclick=\'SUGAR.util.closeActivityPanel.show("Meetings","","Held","listview","1");\'><img src="themes/'.$current_theme.'/images/close_inline.png?v=fqXdFZ_r6FC1K7P_Fy3mVw"     border=\'0\' alt="Close" /></a>',
                      'DATE_START' => '<font class=\'overdueTask\'></font>',
                      'REMINDER_CHECKED' => false,
                      'EMAIL_REMINDER_CHECKED' => false,
                    );

        $actual = $meeting->get_list_view_data();

        //$this->assertSame($expected, $actual);
        $this->assertEquals($expected['PARENT_TYPE'], $actual['PARENT_TYPE']);
        $this->assertEquals($expected['STATUS'], $actual['STATUS']);
        $this->assertEquals($expected['TYPE'], $actual['TYPE']);
        $this->assertEquals($expected['REMINDER_TIME'], $actual['REMINDER_TIME']);
        $this->assertEquals($expected['EMAIL_REMINDER_TIME'], $actual['EMAIL_REMINDER_TIME']);
        $this->assertEquals($expected['EMAIL_REMINDER_SENT'], $actual['EMAIL_REMINDER_SENT']);
        $this->assertEquals($expected['CONTACT_NAME'], $actual['CONTACT_NAME']);
        $this->assertEquals($expected['CONTACT_ID'], $actual['CONTACT_ID']);
        $this->assertEquals($expected['REPEAT_INTERVAL'], $actual['REPEAT_INTERVAL']);
        $this->assertEquals($expected['PARENT_MODULE'], $actual['PARENT_MODULE']);
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testset_notification_body()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        global $current_user;
        $current_user = new User(1);

        $meeting = new Meeting();

        //test with attributes preset and verify template variables are set accordingly
        $meeting->name = 'test';
        $meeting->status = 'Not Held';
        $meeting->type = 'Sugar';
        $meeting->description = 'test description';
        $meeting->duration_hours = 1;
        $meeting->duration_minutes = 1;
        $meeting->date_start = '2016-02-11 17:30:00';
        $meeting->date_end = '2016-02-11 17:30:00';

        $result = $meeting->set_notification_body(new Sugar_Smarty(), $meeting);

        $this->assertEquals($meeting->name, $result->_tpl_vars['MEETING_SUBJECT']);
        $this->assertEquals($meeting->status, $result->_tpl_vars['MEETING_STATUS']);
        $this->assertEquals('SuiteCRM', $result->_tpl_vars['MEETING_TYPE']);
        $this->assertEquals($meeting->duration_hours, $result->_tpl_vars['MEETING_HOURS']);
        $this->assertEquals($meeting->duration_minutes, $result->_tpl_vars['MEETING_MINUTES']);
        $this->assertEquals($meeting->description, $result->_tpl_vars['MEETING_DESCRIPTION']);
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testcreate_notification_email()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();

        $meeting->date_start = '2016-02-11 17:30:00';
        $meeting->date_end = '2016-02-11 17:30:00';

        //test without setting user
        $result = $meeting->create_notification_email(new User());
        $this->assertInstanceOf('SugarPHPMailer', $result);

        //test with valid user
        $result = $meeting->create_notification_email(new User(1));
        $this->assertInstanceOf('SugarPHPMailer', $result);
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testsend_assignment_notifications()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();

        $meeting->date_start = '2016-02-11 17:30:00';
        $meeting->date_end = '2016-02-11 17:30:00';

        $admin = new Administration();
        $admin->retrieveSettings();
        $sendNotifications = false;

        $notify_user = new User(1);

        //execute the method and test if it works and does not throws an exception.
        try {
            $meeting->send_assignment_notifications($notify_user, $admin);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testget_meeting_users()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();

        $result = $meeting->get_meeting_users();
        $this->assertTrue(is_array($result));
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testget_invite_meetings()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();

        $user = new User();
        $result = $meeting->get_invite_meetings($user);
        $this->assertTrue(is_array($result));
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testget_notification_recipients()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();

        //test without special_notification
        $result = $meeting->get_notification_recipients();
        $this->assertTrue(is_array($result));

        //test with special_notification
        $meeting->special_notification = 1;
        $result = $meeting->get_notification_recipients();
        $this->assertTrue(is_array($result));
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testbean_implements()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();

        $this->assertEquals(false, $meeting->bean_implements('')); //test with blank value
        $this->assertEquals(false, $meeting->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $meeting->bean_implements('ACL')); //test with valid value
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testlistviewACLHelper()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();

        $expected = array('MAIN' => 'a', 'PARENT' => 'a', 'CONTACT' => 'a');
        $actual = $meeting->listviewACLHelper();
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testsave_relationship_changes()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();

        //execute the method and test if it works and does not throws an exception.
        try {
            $meeting->save_relationship_changes(false);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    /**
     * This will throw FATAL error on php7
     */
    public function testafterImportSave()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        require_once 'data/Link.php';

        //execute the method and test if it works and does not throws an exception.
        try {
            $meeting = new Meeting();
            //test without parent_type
            $meeting->afterImportSave();

            //test with parent_type Contacts
            $meeting->parent_type = 'Contacts';
            $meeting->afterImportSave();

            //test with parent_type Leads
            $meeting->parent_type = 'Leads';
            $meeting->afterImportSave();

            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testgetDefaultStatus()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        
        $meeting = new Meeting();
        $result = $meeting->getDefaultStatus();
        $this->assertEquals('Planned', $result);
        
        // clean up
        
        $this->restoreStateAll($state);
    }

    public function testgetMeetingsExternalApiDropDown()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        include_once __DIR__ . '/../../../../modules/Meetings/Meeting.php';
        $actual = getMeetingsExternalApiDropDown();
        $expected = array('Sugar' => 'SuiteCRM');
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $this->restoreStateAll($state);
        
    }

    public function testgetMeetingTypeOptions()
    {
        // save state
        
        $state = $this->storeStateAll();
        
        // test
        
        include_once __DIR__ . '/../../../../modules/Meetings/Meeting.php';
        global $dictionary, $app_list_strings;

        $result = getMeetingTypeOptions($dictionary, $app_list_strings);
        $this->assertTrue(is_array($result));
        
        // clean up
        
        $this->restoreStateAll($state);
        
    }
}
