<?php

class LeadTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testLead()
    {
        //self::markTestIncomplete('Test changes error level');

        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('inbound_email');
        

        // test
        
        //execute the contructor and check for the Object type and  attributes
        $lead = new Lead();

        $this->assertInstanceOf('Lead', $lead);
        $this->assertInstanceOf('Person', $lead);
        $this->assertInstanceOf('SugarBean', $lead);

        $this->assertAttributeEquals('Leads', 'module_dir', $lead);
        $this->assertAttributeEquals('Lead', 'object_name', $lead);
        $this->assertAttributeEquals('Leads', 'object_names', $lead);
        $this->assertAttributeEquals('leads', 'table_name', $lead);

        $this->assertAttributeEquals(true, 'new_schema', $lead);
        $this->assertAttributeEquals(true, 'importable', $lead);
        
        // clean up
        
        
        $state->popTable('inbound_email');
    }

    public function testget_account()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $lead = new Lead();

        //test without pre settting attributes
        $result = $lead->get_account();
        $this->assertEquals(null, $result);


        //test with required attributes preset
        $lead->account_id = 1;
        $result = $lead->get_account();
        $this->assertEquals(null, $result);
        
        // clean up
    }

    public function testget_opportunity()
    {
        $lead = new Lead();

        //test without pre settting attributes
        $result = $lead->get_opportunity();
        $this->assertEquals(null, $result);


        //test with required attributes preset
        $lead->opportunity_id = 1;
        $result = $lead->get_opportunity();
        $this->assertEquals(null, $result);
    }

    public function testget_contact()
    {
        $lead = new Lead();

        //test without pre settting attributes
        $result = $lead->get_contact();
        $this->assertEquals(null, $result);


        //test with required attributes preset
        $lead->contact_id = 1;
        $result = $lead->get_contact();
        $this->assertEquals(null, $result);
    }

    public function testcreate_list_query()
    {
        $this->markTestIncomplete('Breaks on php 7.1');
        $lead = new Lead();

        //test with empty string params
        $expected = "SELECT leads.*, users.user_name assigned_user_name,leads_cstm.* FROM leads 			LEFT JOIN users\n                                ON leads.assigned_user_id=users.id LEFT JOIN email_addr_bean_rel eabl  ON eabl.bean_id = leads.id AND eabl.bean_module = 'Leads' and eabl.primary_address = 1 and eabl.deleted=0 LEFT JOIN email_addresses ea ON (ea.id = eabl.email_address_id)  LEFT JOIN leads_cstm ON leads.id = leads_cstm.id_c where  leads.deleted=0 ";
        $actual = $lead->create_list_query('', '');
        $this->assertSame($expected, $actual);


        //test with valid string params
        $expected = "SELECT leads.*, users.user_name assigned_user_name,leads_cstm.* FROM leads 			LEFT JOIN users\n                                ON leads.assigned_user_id=users.id LEFT JOIN email_addr_bean_rel eabl  ON eabl.bean_id = leads.id AND eabl.bean_module = 'Leads' and eabl.primary_address = 1 and eabl.deleted=0 LEFT JOIN email_addresses ea ON (ea.id = eabl.email_address_id)  LEFT JOIN leads_cstm ON leads.id = leads_cstm.id_c where (users.user_name=\"\") AND  leads.deleted=0  ORDER BY leads.id";
        $actual = $lead->create_list_query('leads.id', 'users.user_name=""');
        $this->assertSame($expected, $actual);
    }

    /**
     * @todo: NEEDS FIXING!
     */
    public function testcreate_new_list_query()
    {
        /*
        $lead = new Lead();

        //test with empty string params
        $expected = " SELECT  leads.* , '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' e_invite_status_fields , '                                    '  fp_events_leads_1fp_events_ida , '                                                                                                                                                                                                                                                              ' e_accept_status_fields , LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),' ',IFNULL(leads.last_name,'')))) as name , jt3.user_name modified_by_name , jt3.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt4.user_name created_by_name , jt4.created_by created_by_name_owner  , 'Users' created_by_name_mod , jt5.user_name assigned_user_name , jt5.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod, LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),' ',IFNULL(leads.last_name,'')))) as full_name , jt6.name campaign_name , jt6.assigned_user_id campaign_name_owner  , 'Campaigns' campaign_name_mod, '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id  FROM leads   LEFT JOIN  users jt3 ON leads.modified_user_id=jt3.id AND jt3.deleted=0\n\n AND jt3.deleted=0  LEFT JOIN  users jt4 ON leads.created_by=jt4.id AND jt4.deleted=0\n\n AND jt4.deleted=0  LEFT JOIN  users jt5 ON leads.assigned_user_id=jt5.id AND jt5.deleted=0\n\n AND jt5.deleted=0  LEFT JOIN  campaigns jt6 ON leads.campaign_id=jt6.id AND jt6.deleted=0\n\n AND jt6.deleted=0 where leads.deleted=0";
        $actual = $lead->create_new_list_query('','');
        $this->assertSame($expected,$actual);


        //test with valid string params
        $expected = " SELECT  leads.* , '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' e_invite_status_fields , '                                    '  fp_events_leads_1fp_events_ida , '                                                                                                                                                                                                                                                              ' e_accept_status_fields , LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),' ',IFNULL(leads.last_name,'')))) as name , jt3.user_name modified_by_name , jt3.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt4.user_name created_by_name , jt4.created_by created_by_name_owner  , 'Users' created_by_name_mod , jt5.user_name assigned_user_name , jt5.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod, LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),' ',IFNULL(leads.last_name,'')))) as full_name , jt6.name campaign_name , jt6.assigned_user_id campaign_name_owner  , 'Campaigns' campaign_name_mod, '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id  FROM leads   LEFT JOIN  users jt3 ON leads.modified_user_id=jt3.id AND jt3.deleted=0\n\n AND jt3.deleted=0  LEFT JOIN  users jt4 ON leads.created_by=jt4.id AND jt4.deleted=0\n\n AND jt4.deleted=0  LEFT JOIN  users jt5 ON leads.assigned_user_id=jt5.id AND jt5.deleted=0\n\n AND jt5.deleted=0  LEFT JOIN  campaigns jt6 ON leads.campaign_id=jt6.id AND jt6.deleted=0\n\n AND jt6.deleted=0 where (users.user_name=\"\") AND leads.deleted=0";
        $actual = $lead->create_new_list_query('leads.id','users.user_name=""');
        $this->assertSame($expected,$actual);
        */
        $this->assertTrue(true, "NEEDS FIXING!");
    }

    public function testSaveAndConverted_lead()
    {
        $this->markTestSkipped("converted_lead: Error in query, id's not properly escaped ");
        
        $lead = new Lead();

        $lead->first_name = "firstn";
        $lead->last_name = "lastnn";
        $lead->lead_source = "test";

        $result = $lead->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($lead->id));
        $this->assertEquals(36, strlen($lead->id));
        $this->assertEquals("New", $lead->status);


        //test converted_lead method after saving
        /*$lead->converted_lead("'" . $lead->id . "'" , "'1'", "'1'", "'1'");

        //retrieve back to test if attributes are updated in db
        $lead = $lead->retrieve($lead->id);
        $this->assertEquals("Converted", $lead->status);
        $this->assertEquals("1", $lead->converted);
        $this->assertEquals("1", $lead->contact_id);
        $this->assertEquals("1", $lead->account_id);
        $this->assertEquals("1", $lead->opportunity_id);
        */



        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $lead->mark_deleted($lead->id);
        $result = $lead->retrieve($lead->id);
        $this->assertEquals(null, $result);
    }


    public function testfill_in_additional_list_fields()
    {

    // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('leads');
        $state->pushTable('leads_cstm');
        $state->pushTable('sugarfeed');
        $state->pushTable('tracker');

        // test
        $lead = new Lead();

        $lead->first_name = "firstn";
        $lead->last_name = "lastn";

        $lead->fill_in_additional_list_fields();

        $this->assertEquals("firstn lastn", $lead->name);

        
        // clean up
        
        $state->popTable('tracker');
        $state->popTable('sugarfeed');
        $state->popTable('leads_cstm');
        $state->popTable('leads');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }


    public function testfill_in_additional_detail_fields()
    {
        $lead = new Lead();

        $lead->first_name = "firstn";
        $lead->last_name = "lastn";

        $lead->fill_in_additional_detail_fields();

        $this->assertEquals("firstn lastn", $lead->name);
    }

    public function testget_list_view_data()
    {

    // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('email_addresses');
        $state->pushTable('tracker');

        // test
        
        $lead = new Lead();

        $expected = array(
            'NAME' => ' ',
            'DELETED' => 0,
            'FULL_NAME' => ' ',
            'DO_NOT_CALL' => '0',
            'CONVERTED' => '0',
            'ENCODED_NAME' => ' ',
            'EMAIL1' => '',
            'EMAIL1_LINK' =>
                '<a class="email-link"'
                . ' onclick="$(document).openComposeViewModal(this);" data-module="Leads"'
                . ' data-record-id="" data-module-name=" " data-email-address=""></a>',
            'ACC_NAME_FROM_ACCOUNTS' => null,
        );

        $actual = $lead->get_list_view_data();

        //$this->assertSame($expected, $actual);
        $this->assertEquals($expected['NAME'], $actual['NAME']);
        $this->assertEquals($expected['DELETED'], $actual['DELETED']);
        $this->assertEquals($expected['FULL_NAME'], $actual['FULL_NAME']);
        $this->assertEquals($expected['DO_NOT_CALL'], $actual['DO_NOT_CALL']);
        $this->assertEquals($expected['EMAIL1_LINK'], $actual['EMAIL1_LINK']);
        
        // clean up
        
        $state->popTable('tracker');
        $state->popTable('email_addresses');
    }


    public function testget_linked_fields()
    {
        $lead = new Lead();

        $expected = array(
            'created_by_link',
            'modified_user_link',
            'assigned_user_link',
            'email_addresses_primary',
            'email_addresses',
            'reports_to_link',
            'reportees',
            'contacts',
            'accounts',
            'contact',
            'opportunity',
            'campaign_leads',
            'tasks',
            'notes',
            'meetings',
            'calls',
            'emails',
            'campaigns',
            'prospect_lists',
            'fp_events_leads_1',
            'SecurityGroups',
        );
        $actual = $lead->get_linked_fields();
        $this->assertTrue(is_array($actual));
        sort($expected);
        $actualKeys = array_keys($actual);
        sort($actualKeys);
        $this->assertSame($expected, $actualKeys);
    }

    public function testbuild_generic_where_clause()
    {
        self::markTestSkipped('State dependecy');
        
        $lead = new Lead();

        //test with empty string params
        $expected = "leads.last_name like '%' or leads.account_name like '%' or leads.first_name like '%' or ea.email_address like '%'";
        $actual = $lead->build_generic_where_clause("");
        $this->assertSame($expected, $actual);


        //test with valid string params
        $expected = "leads.last_name like '%' or leads.account_name like '%' or leads.first_name like '%' or ea.email_address like '%'";
        $actual = $lead->build_generic_where_clause("123");
        $this->assertSame($expected, $actual);
    }

    public function testset_notification_body()
    {
        $lead = new Lead();

        //test with attributes preset and verify template variables are set accordingly

        $lead->first_name = "firstn";
        $lead->last_name = "lastn";
        $lead->salutation = "Mr";
        $lead->lead_source = "Email";
        $lead->status = "New";
        $lead->description = "tes description";

        $result = $lead->set_notification_body(new Sugar_Smarty(), $lead);

        $this->assertEquals("Mr firstn lastn", $result->_tpl_vars['LEAD_NAME']);
        $this->assertEquals($lead->lead_source, $result->_tpl_vars['LEAD_SOURCE']);
        $this->assertEquals($lead->status, $result->_tpl_vars['LEAD_STATUS']);
        $this->assertEquals($lead->description, $result->_tpl_vars['LEAD_DESCRIPTION']);
    }

    public function testbean_implements()
    {
        $lead = new Lead();

        $this->assertEquals(false, $lead->bean_implements('')); //test with blank value
        $this->assertEquals(false, $lead->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $lead->bean_implements('ACL')); //test with valid value
    }

    public function testlistviewACLHelper()
    {
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

        // test
        
        $lead = new Lead();

        $expected = array("MAIN" => "a", "ACCOUNT" => "a", "OPPORTUNITY" => "a", "CONTACT" => "a");
        $actual = $lead->listviewACLHelper();
        $this->assertSame($expected, $actual);

        // clean up
        
        $state->popGlobals();
    }


    public function testconvertCustomFieldsForm()
    {
        $lead = new Lead();

        $form = "";
        $prefix = "";
        $tempBean = new Contact();

        $result = $lead->convertCustomFieldsForm($form, $tempBean, $prefix);

        $this->assertEquals(true, $result);
        $this->assertgreaterThanOrEqual("", $form); //no filed with source = custom_fields
    }


    public function testget_unlinked_email_query()
    {
        $lead = new Lead();

        $expected = "SELECT emails.id FROM emails  JOIN (select DISTINCT email_id from emails_email_addr_rel eear

	join email_addr_bean_rel eabr on eabr.bean_id ='' and eabr.bean_module = 'Leads' and
	eabr.email_address_id = eear.email_address_id and eabr.deleted=0
	where eear.deleted=0 and eear.email_id not in
	(select eb.email_id from emails_beans eb where eb.bean_module ='Leads' and eb.bean_id = '')
	) derivedemails on derivedemails.email_id = emails.id";
        $actual = $lead->get_unlinked_email_query();
        $this->assertSame($expected, $actual);
    }


    public function testget_old_related_calls()
    {
        $lead = new Lead();

        $expected = array();
        $expected['select'] = 'SELECT calls.id ';
        $expected['from'] = 'FROM calls ';
        $expected['where'] = " WHERE calls.parent_id = '$lead->id'
            AND calls.parent_type = 'Leads' AND calls.id NOT IN ( SELECT call_id FROM calls_leads ) ";
        $expected['join'] = "";
        $expected['join_tables'][0] = '';

        $actual = $lead->get_old_related_calls();
        $this->assertSame($expected, $actual);
    }


    public function testgetActivitiesOptions()
    {
        $lead = new Lead();

        $expected = array("copy" => "Copy", "move" => "Move", "donothing" => "Do Nothing");
        $actual = $lead->getActivitiesOptions();
        $this->assertSame($expected, $actual);
    }


    public function testget_old_related_meetings()
    {
        $lead = new Lead();

        $expected = array();
        $expected['select'] = 'SELECT meetings.id ';
        $expected['from'] = 'FROM meetings ';
        $expected['where'] = " WHERE meetings.parent_id = ''
            AND meetings.parent_type = 'Leads' AND meetings.id NOT IN ( SELECT meeting_id FROM meetings_leads ) ";
        $expected['join'] = "";
        $expected['join_tables'][0] = '';

        $actual = $lead->get_old_related_meetings();
        $this->assertSame($expected, $actual);
    }
}
