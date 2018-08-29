<?php

class EmailTemplateTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testEmailTemplate()
    {

        //execute the contructor and check for the Object type and  attributes
        $emailTemplate = new EmailTemplate();

        $this->assertInstanceOf('EmailTemplate', $emailTemplate);
        $this->assertInstanceOf('SugarBean', $emailTemplate);

        $this->assertAttributeEquals('EmailTemplates', 'module_dir', $emailTemplate);
        $this->assertAttributeEquals('EmailTemplate', 'object_name', $emailTemplate);
        $this->assertAttributeEquals('email_templates', 'table_name', $emailTemplate);

        $this->assertAttributeEquals(true, 'new_schema', $emailTemplate);
    }

    public function testgenerateFieldDefsJS()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $emailTemplate = new EmailTemplate();

        //execute the method and verify that it retunrs expected results
        $expected = 'var field_defs = {"Contacts":[{"name":"contact_name","value":"Name"},{"name":"contact_description","value":"Description"},{"name":"contact_salutation","value":"Salutation"},{"name":"contact_first_name","value":"First Name"},{"name":"contact_last_name","value":"Last Name"},{"name":"contact_full_name","value":"Name"},{"name":"contact_title","value":"Title"},{"name":"contact_photo","value":"Photo"},{"name":"contact_department","value":"Department"},{"name":"contact_phone_home","value":"Home"},{"name":"contact_email","value":"Any Email"},{"name":"contact_phone_mobile","value":"Mobile"},{"name":"contact_phone_work","value":"Office Phone"},{"name":"contact_phone_other","value":"Other Phone"},{"name":"contact_phone_fax","value":"Fax"},{"name":"contact_email1","value":"Email Address"},{"name":"contact_email2","value":"Other Email"},{"name":"contact_primary_address_street","value":"Primary Address Street"},{"name":"contact_primary_address_street_2","value":"Primary Address Street 2"},{"name":"contact_primary_address_street_3","value":"Primary Address Street 3"},{"name":"contact_primary_address_city","value":"Primary Address City"},{"name":"contact_primary_address_state","value":"Primary Address State"},{"name":"contact_primary_address_postalcode","value":"Primary Address Postal Code"},{"name":"contact_primary_address_country","value":"Primary Address Country"},{"name":"contact_alt_address_street","value":"Alternate Address Street"},{"name":"contact_alt_address_street_2","value":"Alternate Address Street 2"},{"name":"contact_alt_address_street_3","value":"Alternate Address Street 3"},{"name":"contact_alt_address_city","value":"Alternate Address City"},{"name":"contact_alt_address_state","value":"Alternate Address State"},{"name":"contact_alt_address_postalcode","value":"Alternate Address Postal Code"},{"name":"contact_alt_address_country","value":"Alternate Address Country"},{"name":"contact_assistant","value":"Assistant"},{"name":"contact_assistant_phone","value":"Assistant Phone"},{"name":"contact_email_addresses_non_primary","value":"Non Primary E-mails"},{"name":"contact_email_and_name1","value":"Name"},{"name":"contact_lead_source","value":"Lead Source"},{"name":"contact_birthdate","value":"Birthdate"},{"name":"contact_joomla_account_id","value":"LBL_JOOMLA_ACCOUNT_ID"},{"name":"contact_joomla_account_access","value":"LBL_JOOMLA_ACCOUNT_ACCESS"},{"name":"contact_portal_user_type","value":"Portal User Type"},{"name":"contact_event_status_name","value":"LBL_LIST_INVITE_STATUS_EVENT"},{"name":"contact_event_invite_id","value":"LBL_LIST_INVITE_STATUS"},{"name":"contact_event_accept_status","value":"LBL_LIST_ACCEPT_STATUS_EVENT"},{"name":"contact_event_status_id","value":"Accept Status"},{"name":"contact_jjwg_maps_address_c","value":""},{"name":"contact_jjwg_maps_geocode_status_c","value":""},{"name":"contact_jjwg_maps_lat_c","value":""},{"name":"contact_jjwg_maps_lng_c","value":""},{"name":"contact_refered_by","value":"Referred By"},{"name":"contact_lead_source_description","value":"Lead Source Description"},{"name":"contact_status","value":"Status"},{"name":"contact_status_description","value":"Status Description"},{"name":"contact_account_name","value":"Account Name"},{"name":"contact_account_id","value":"Account ID"},{"name":"contact_webtolead_email1","value":"Email Address"},{"name":"contact_webtolead_email2","value":"Other Email"},{"name":"contact_portal_name","value":"Portal Name"},{"name":"contact_portal_app","value":"Portal Application"},{"name":"contact_website","value":"Website"},{"name":"contact_tracker_key","value":"Tracker Key"}],"Accounts":[{"name":"account_name","value":"Name"},{"name":"account_description","value":"Description"},{"name":"account_account_type","value":"Type"},{"name":"account_industry","value":"Industry"},{"name":"account_annual_revenue","value":"Annual Revenue"},{"name":"account_phone_fax","value":"Fax"},{"name":"account_billing_address_street","value":"Billing Street"},{"name":"account_billing_address_street_2","value":"Billing Street 2"},{"name":"account_billing_address_street_3","value":"Billing Street 3"},{"name":"account_billing_address_street_4","value":"Billing Street 4"},{"name":"account_billing_address_city","value":"Billing City"},{"name":"account_billing_address_state","value":"Billing State"},{"name":"account_billing_address_postalcode","value":"Billing Postal Code"},{"name":"account_billing_address_country","value":"Billing Country"},{"name":"account_rating","value":"Rating"},{"name":"account_phone_office","value":"Office Phone"},{"name":"account_phone_alternate","value":"Alternate Phone"},{"name":"account_website","value":"Website"},{"name":"account_ownership","value":"Ownership"},{"name":"account_employees","value":"Employees"},{"name":"account_ticker_symbol","value":"Ticker Symbol"},{"name":"account_shipping_address_street","value":"Shipping Street"},{"name":"account_shipping_address_street_2","value":"Shipping Street 2"},{"name":"account_shipping_address_street_3","value":"Shipping Street 3"},{"name":"account_shipping_address_street_4","value":"Shipping Street 4"},{"name":"account_shipping_address_city","value":"Shipping City"},{"name":"account_shipping_address_state","value":"Shipping State"},{"name":"account_shipping_address_postalcode","value":"Shipping Postal Code"},{"name":"account_shipping_address_country","value":"Shipping Country"},{"name":"account_email1","value":"Email Address"},{"name":"account_email_addresses_non_primary","value":"Non Primary E-mails"},{"name":"account_parent_id","value":"Parent Account ID"},{"name":"account_sic_code","value":"SIC Code"},{"name":"account_email","value":"Any Email"},{"name":"account_jjwg_maps_address_c","value":""},{"name":"account_jjwg_maps_geocode_status_c","value":""},{"name":"account_jjwg_maps_lat_c","value":""},{"name":"account_jjwg_maps_lng_c","value":""}],"Users":[{"name":"contact_user_user_name","value":"User Name"},{"name":"contact_user_pwd_last_changed","value":"Password Last Changed"},{"name":"contact_user_first_name","value":"First Name"},{"name":"contact_user_last_name","value":"Last Name"},{"name":"contact_user_full_name","value":"Full Name"},{"name":"contact_user_name","value":"Full Name"},{"name":"contact_user_description","value":"Description"},{"name":"contact_user_title","value":"Title"},{"name":"contact_user_photo","value":"Photo"},{"name":"contact_user_department","value":"Department"},{"name":"contact_user_phone_home","value":"Home Phone"},{"name":"contact_user_phone_mobile","value":"Mobile"},{"name":"contact_user_phone_work","value":"Work Phone"},{"name":"contact_user_phone_other","value":"Other Phone"},{"name":"contact_user_phone_fax","value":"Fax"},{"name":"contact_user_status","value":"Status"},{"name":"contact_user_address_street","value":"Address Street"},{"name":"contact_user_address_city","value":"Address City"},{"name":"contact_user_address_state","value":"Address State"},{"name":"contact_user_address_country","value":"Address Country"},{"name":"contact_user_address_postalcode","value":"Address Postal Code"},{"name":"contact_user_usertype","value":"User Type"},{"name":"contact_user_employee_status","value":"Employee Status"},{"name":"contact_user_messenger_id","value":"IM Name"},{"name":"contact_user_messenger_type","value":"IM Type"},{"name":"contact_user_email1","value":"Email Address"},{"name":"contact_user_email_link_type","value":"Email Client"},{"name":"contact_user_securitygroup_noninherit_id","value":"LBL_securitygroup_noninherit_id"}]};';
        $actual = $emailTemplate->generateFieldDefsJS();
        //$this->assertSame($expected,$actual);

        $this->assertGreaterThan(0, strlen($actual));
        
        // clean up
        
        
    }

    public function testget_summary_text()
    {
        $emailTemplate = new EmailTemplate();

        //test without setting name
        $this->assertEquals(null, $emailTemplate->get_summary_text());

        //test with name set
        $emailTemplate->name = 'test';
        $this->assertEquals('test', $emailTemplate->get_summary_text());
    }

    public function testcreate_export_query()
    {


	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

	// test
        
        
        $emailTemplate = new EmailTemplate();

        //test with empty string params
        $expected = " SELECT  email_templates.*  , jt0.user_name assigned_user_name , jt0.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM email_templates   LEFT JOIN  users jt0 ON email_templates.assigned_user_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0 where email_templates.deleted=0";
        $actual = $emailTemplate->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = " SELECT  email_templates.*  , jt0.user_name assigned_user_name , jt0.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM email_templates   LEFT JOIN  users jt0 ON email_templates.assigned_user_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0 where (email_templates.name=\"\") AND email_templates.deleted=0";
        $actual = $emailTemplate->create_export_query('email_templates.id', 'email_templates.name=""');
        $this->assertSame($expected, $actual);
        
        
        // clean up
        
        $state->popGlobals();
    }

    public function testfill_in_additional_list_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $emailTemplate = new EmailTemplate();

        //execute the method and test if it works and does not throws an exception.
        try {
            $emailTemplate->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testfill_in_additional_detail_fields()
    {
        $emailTemplate = new EmailTemplate();

        //test with attributes preset and verify template variables are set accordingly

        $emailTemplate->created_by = 1;
        $emailTemplate->modified_user_id = 1;
        $emailTemplate->assigned_user_id = 1;
        $emailTemplate->body_html = '<b>some html text</b>';

        $emailTemplate->fill_in_additional_detail_fields();

        $this->assertEquals('Administrator', $emailTemplate->created_by_name);
        $this->assertEquals('Administrator', $emailTemplate->modified_by_name);
        $this->assertEquals('Administrator', $emailTemplate->assigned_user_name);
        $this->assertEquals('some html text', $emailTemplate->body);
    }

    public function testfill_in_additional_parent_fields()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $emailTemplate = new EmailTemplate();

        //execute the method and test if it works and does not throws an exception.
        try {
            $emailTemplate->fill_in_additional_parent_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testget_list_view_data()
    {
        $emailTemplate = new EmailTemplate();

        //execute the method and verify that it retunrs expected results
        $expected = array(
                'DELETED' => 0,
        );

        $actual = $emailTemplate->get_list_view_data();
        $this->assertSame($expected, $actual);
    }

    public function testparse_email_templateAndParse_tracker_urls()
    {
        $emailTemplate = new EmailTemplate();

        //test parse_email_template
        $account = new Account();
        $macro_nv = array();

        $expected = array(
                    'subject' => 'test subject', 'body_html' => 'test html', 'body' => 'test body text',
                    );
        $actual = $emailTemplate->parse_email_template(array('subject' => 'test subject', 'body_html' => 'test html', 'body' => 'test body text'), 'Accounts', $account, $macro_nv);
        $this->assertSame($expected, $actual);

        //test Parse_tracker_urls
        $tracker_url_template = 'localhost/index.php?entryPoint=campaign_trackerv2&track=%s&identifier=tracker_key';
        $removeme_url_template = 'localhost/index.php?entryPoint=removeme&identifier=tracker_key';
        $tracker_urls = array();

        $result = $emailTemplate->parse_tracker_urls($actual, $tracker_url_template, $tracker_urls, $removeme_url_template);
        $this->assertSame($expected, $result);
    }

    public function test_convertToType()
    {
        $emailTemplate = new EmailTemplate();

        $this->assertEquals(10, $emailTemplate->_convertToType('float', 10));
        $this->assertEquals('test text', $emailTemplate->_convertToType('text', 'test text'));
        $this->assertEquals('$10.00', $emailTemplate->_convertToType('currency', 10));
    }

    /**
     * @todo: NEEDS REVISION: _parseUserValues returns different values in php5 and php7
     * for keys:
     *  contact_user_sugar_login, contact_user_is_admin, contact_user_external_auth_only,
     *  contact_user_receive_notifications, contact_user_modified_by_name, contact_user_created_by_name,
     *  contact_user_deleted, contact_user_portal_only, contact_user_show_on_employees
     *
     */
    public function test_parseUserValues()
    {
        /*
        $emailTemplate = new EmailTemplate();
        $user = new User(1);
        $repl_arr = array('contact_user_name' => '');

        //execute the method and verify that it retunrs expected results

        $expected = array(
            'contact_user_name' => '',
                'contact_user_id' => '',
                'contact_user_user_name' => '',
                'contact_user_user_hash' => '',
                'contact_user_system_generated_password' => '',
                'contact_user_pwd_last_changed' => '',
                'contact_user_authenticate_id' => '',
                'contact_user_sugar_login' => '1',
                'contact_user_first_name' => '',
                'contact_user_last_name' => '',
                'contact_user_full_name' => '',
                'contact_user_is_admin' => '0',
                'contact_user_external_auth_only' => '0',
                'contact_user_receive_notifications' => '1',
                'contact_user_description' => '',
                'contact_user_date_entered' => '',
                'contact_user_date_modified' => '',
                'contact_user_title' => '',
                'contact_user_photo' => '',
                'contact_user_department' => '',
                'contact_user_phone_home' => '',
                'contact_user_phone_mobile' => '',
                'contact_user_phone_work' => '',
                'contact_user_phone_other' => '',
                'contact_user_phone_fax' => '',
                'contact_user_status' => '',
                'contact_user_address_street' => '',
                'contact_user_address_city' => '',
                'contact_user_address_state' => '',
                'contact_user_address_country' => '',
                'contact_user_address_postalcode' => '',
                'contact_user_UserType' => '',
                'contact_user_deleted' => 0,
                'contact_user_portal_only' => '0',
                'contact_user_show_on_employees' => '1',
                'contact_user_employee_status' => '',
                'contact_user_messenger_id' => '',
                'contact_user_messenger_type' => '',
                'contact_user_calls' => '',
                'contact_user_meetings' => '',
                'contact_user_contacts_sync' => '',
                'contact_user_reports_to_id' => '',
                'contact_user_reports_to_link' => '',
                'contact_user_reportees' => '',
                'contact_user_email1' => '',
                'contact_user_email_addresses' => '',
                'contact_user_email_addresses_primary' => '',
                'contact_user_email_link_type' => '',
                'contact_user_aclroles' => '',
                'contact_user_is_group' => '',
                'contact_user_accept_status_id' => '',
                'contact_user_accept_status_name' => '',
                'contact_user_prospect_lists' => '',
                'contact_user_emails_users' => '',
                'contact_user_holidays' => '',
                'contact_user_eapm' => '',
                'contact_user_oauth_tokens' => '',
                'contact_user_project_resource' => '',
                'contact_user_project_users_1' => '',
                'contact_user_SecurityGroups' => '',
                'contact_user_securitygroup_noninherit_id' => '',
                'contact_user_securitygroup_noninheritable' => '',
                'contact_user_securitygroup_primary_group' => '',
            );

        $actual = $emailTemplate->_parseUserValues($repl_arr, $user);
        $this->assertSame($expected, $actual);
        */
        $this->markTestIncomplete("Different values for php5 and php7");
    }

    public function testparse_template_bean()
    {
        $emailTemplate = new EmailTemplate();
        $contact = new Contact();
        $user = new User(1);
        $account = new Account();

        $contact->name = 'test';
        $account->name = 'test';

        //test with empty string
        $actual = $emailTemplate->parse_template_bean('', 'Contacts', $contact);
        $this->assertEquals('', $actual);

        //test with valid string
        $actual = $emailTemplate->parse_template_bean('test', 'Users', $user);
        $this->assertEquals('test', $actual);

        //test with empty string and different module
        $actual = $emailTemplate->parse_template_bean('', 'Accounts', $account);
        $this->assertEquals('', $actual);
    }

    public function testparse_template()
    {
        $emailTemplate = new EmailTemplate();
        $bean_arr = array('Users' => 1, 'Leads' => 1);

        //test with empty string
        $result = $emailTemplate->parse_template('', $bean_arr);
        $this->assertEquals('', $result);

        //test with valid string
        $result = $emailTemplate->parse_template('some value', $bean_arr);
        $this->assertEquals('some value', $result);
    }

    public function testbean_implements()
    {
        $emailTemplate = new EmailTemplate();

        $this->assertEquals(false, $emailTemplate->bean_implements('')); //test with blank value
        $this->assertEquals(false, $emailTemplate->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $emailTemplate->bean_implements('ACL')); //test with valid value
    }

    public function testgetTypeOptionsForSearch()
    {
        //execute the method and verify that it retunrs expected results
        $expected = array(
                '' => '',
                'campaign' => 'Campaign',
                'email' => 'Email',
        );
        $actual = EmailTemplate::getTypeOptionsForSearch();
        $this->assertSame($expected, $actual);
    }

    public function testis_used_by_email_marketing()
    {
        $emailTemplate = new EmailTemplate();

        //test without id attribute
        $this->assertEquals(false, $emailTemplate->is_used_by_email_marketing());

        //test with id attribute
        $emailTemplate->id = 1;
        $this->assertEquals(false, $emailTemplate->is_used_by_email_marketing());
    }

    public function testcleanBean()
    {
        $emailTemplate = new EmailTemplate();

        //test without body_html attribute
        $emailTemplate->cleanBean();
        $this->assertEquals('', $emailTemplate->body_html);

        //test with body_html attribute
        $emailTemplate->body_html = '<h1>text</h1>';
        $emailTemplate->cleanBean();
        $this->assertEquals('&lt;h1&gt;text&lt;/h1&gt;', $emailTemplate->body_html);
    }
}
