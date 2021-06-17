<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once __DIR__ . '/../../../../../modules/EmailTemplates/EmailTemplateParser.php';

class EmailTemplateTest extends SuitePHPUnitFrameworkTestCase
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testEmailTemplateParser()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');
        $emailTemplate->body_html = to_html('<h1>Hello $contact_name</h1>');
        $emailTemplate->body = 'Hello $contact_name';
        $emailTemplate->subject = 'Hello $contact_name';
        $campaign = BeanFactory::newBean('Campaigns');

        $related = [BeanFactory::newBean('Leads'), BeanFactory::newBean('Contacts'), BeanFactory::newBean('Prospects')];
        foreach ($related as $bean) {
            $bean->name = 'foobar';

            $parser = new EmailTemplateParser($emailTemplate, $campaign, $bean, "", "");
            $result = $parser->parseVariables();
            $this->assertEquals('<h1>Hello foobar</h1>', from_html($result['body_html']));
            $this->assertEquals('Hello foobar', $result['body']);
            $this->assertEquals('Hello foobar', $result['subject']);
        }
    }

    public function testEmailTemplateParserUser()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');
        $emailTemplate->body = 'Hello $contact_user_full_name';
        $campaign = BeanFactory::newBean('Campaigns');

        $bean = BeanFactory::newBean('Users');
        $bean->first_name = 'foo';
        $bean->last_name = 'bar';
        $bean->fill_in_additional_detail_fields();

        $parser = new EmailTemplateParser($emailTemplate, $campaign, $bean, "", "");
        $result = $parser->parseVariables();
        $this->assertEquals('Hello foo bar', $result['body']);
    }

    public function testcreateCopyTemplate()
    {
        global $current_user;

        $this->setOutputCallback(function ($msg) {
        });

        $current_user->id = create_guid();
        $_REQUEST['func'] = 'createCopy';
        $_POST['name'] = 'Name';
        $_POST['subject'] = 'Subject';
        $_POST['body_html'] = 'BodyHTML';
        require('modules/EmailTemplates/EmailTemplateData.php');

        $output = json_decode($this->getActualOutput(), true);
        $this->assertNotEmpty($output['data']);
        $this->assertNotEmpty($output['data']['id']);
        $template = BeanFactory::newBean('EmailTemplates');
        $this->assertNotNull($template->retrieve($output['data']['id']));

        $this->assertEquals($current_user->id, $template->assigned_user_id);
    }

    public function testaddDomainToRelativeImagesSrc()
    {
        global $sugar_config;

        $template = BeanFactory::newBean('EmailTemplates');
        $html = '<img style="font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:22.4px;color:#444444;padding:0px;margin:0px;" src="public/c1270a2d-a083-495e-7c61-5c8a9046ec0d.png" alt="c1270a2d-a083-495e-7c61-5c8a9046ec0d.png" width="267" height="200">';
        $template->body_html = to_html($html);
        $sugar_config['site_url'] = 'https://foobar.com';

        $template->addDomainToRelativeImagesSrc();

        $result = from_html($template->body_html);
        $this->assertContains('src="https://foobar.com/public/c1270a2d-a083-495e-7c61-5c8a9046ec0d.png" alt="c1270a2d-a083-495e-7c61-5c8a9046ec0d.png"', $result);
    }

    public function testrepairEntryPointImages()
    {
        global $sugar_config;

        $sugar_config['site_url'] = 'https://foobar.com';

        $ids = [create_guid(), create_guid()];
        $html = '<img src="https://foobar.com/index.php?entryPoint=download&type=Notes&id=' . $ids[0] . '&filename=test2.png" alt="" style="font-size:14px;" width="381" height="339">';
        $html .= '<img alt="test.png" src="https://foobar.com/index.php?entryPoint=download&type=Notes&id=' . $ids[1] . '&filename=test.png" width="118" height="105">';

        foreach ($ids as $id) {
            file_put_contents('upload/' . $id, 'IAmAnImage:' . $id);
        }

        $template = BeanFactory::newBean('EmailTemplates');
        $template->body_html = to_html($html);
        $template->new_with_id = true;
        $template->save();
        $this->assertNotNull($template->retrieve($template->id));

        foreach ($ids as $id) {
            $this->assertTrue(is_file('public/' . $id . '.png'));
            unlink('public/' . $id . '.png');
            unlink('upload/' . $id);
        }

        $expected = '<img src="https://foobar.com/public/' . $ids[0] . '.png" alt="" style="font-size:14px;" width="381" height="339" />';
        $expected .= '<img alt="test.png" src="https://foobar.com/public/' . $ids[1] . '.png" width="118" height="105" />';
        $this->assertEquals($expected, from_html($template->body_html));
    }

    public function testEmailTemplate()
    {
        // Execute the constructor and check for the Object type and attributes
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        $this->assertInstanceOf('EmailTemplate', $emailTemplate);
        $this->assertInstanceOf('SugarBean', $emailTemplate);

        $this->assertAttributeEquals('EmailTemplates', 'module_dir', $emailTemplate);
        $this->assertAttributeEquals('EmailTemplate', 'object_name', $emailTemplate);
        $this->assertAttributeEquals('email_templates', 'table_name', $emailTemplate);

        $this->assertAttributeEquals(true, 'new_schema', $emailTemplate);
    }

    public function testget_summary_text()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        // test without setting name
        $this->assertEquals(null, $emailTemplate->get_summary_text());

        // test with name set
        $emailTemplate->name = 'test';
        $this->assertEquals('test', $emailTemplate->get_summary_text());
    }

    public function testcreate_export_query()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        // test with empty string params
        $expected = " SELECT  email_templates.*  , jt0.user_name assigned_user_name , jt0.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM email_templates   LEFT JOIN  users jt0 ON email_templates.assigned_user_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0 where email_templates.deleted=0";
        $actual = $emailTemplate->create_export_query('', '');
        $this->assertSame($expected, $actual);

        // test with valid string params
        $expected = " SELECT  email_templates.*  , jt0.user_name assigned_user_name , jt0.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM email_templates   LEFT JOIN  users jt0 ON email_templates.assigned_user_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0 where (email_templates.name=\"\") AND email_templates.deleted=0";
        $actual = $emailTemplate->create_export_query('email_templates.id', 'email_templates.name=""');
        $this->assertSame($expected, $actual);
    }

    public function testfill_in_additional_list_fields()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $emailTemplate->fill_in_additional_list_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testfill_in_additional_detail_fields()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        // test with attributes preset and verify template variables are set accordingly
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

    public function testfill_in_additional_detail_fields_body_to_text()
    {
        // simple examples
        $emailTemplate = BeanFactory::newBean('EmailTemplates');
        $emailTemplate->body_html = htmlentities('<h1>Hello</h1><br><a href="https://suitecrm.com">text</b>');
        $emailTemplate->fill_in_additional_detail_fields();
        $this->assertEquals("Hello\n\n[text](https://suitecrm.com)", $emailTemplate->body);

        // entities and tags
        $emailTemplate = BeanFactory::newBean('EmailTemplates');
        $emailTemplate->body_html = htmlentities('&#60;a&#62;<b>');
        $emailTemplate->fill_in_additional_detail_fields();
        $this->assertEquals("<a>", $emailTemplate->body);

        // invalid html
        $emailTemplate = BeanFactory::newBean('EmailTemplates');
        $emailTemplate->body_html = htmlentities('foo<bar');
        $emailTemplate->fill_in_additional_detail_fields();
        $this->assertEquals("foo", $emailTemplate->body);

        // variables
        $emailTemplate = BeanFactory::newBean('EmailTemplates');
        $emailTemplate->body_html = htmlentities('Hello <b>$foo</b>bar');
        $emailTemplate->fill_in_additional_detail_fields();
        $this->assertEquals('Hello $foo bar', $emailTemplate->body);

        // variables in URLs (opt-in confirmation emails etc)
        $emailTemplate = BeanFactory::newBean('EmailTemplates');
        $emailTemplate->body_html = htmlentities('<a href="$url/index.php?foo=$bar&quux=$baz">text</a>');
        $emailTemplate->fill_in_additional_detail_fields();
        $this->assertEquals('[text]($url/index.php?foo=$bar&quux=$baz)', $emailTemplate->body);

        // decoding latin-1 html
        $emailTemplate = BeanFactory::newBean('EmailTemplates');
        $emailTemplate->body_html = htmlentities('<meta charset="ISO-8859-1">' . "\xe4", ENT_QUOTES, "ISO-8859-1");
        $emailTemplate->fill_in_additional_detail_fields();
        $this->assertEquals("\xc3\xa4", $emailTemplate->body);
    }

    public function testfill_in_additional_parent_fields()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $emailTemplate->fill_in_additional_parent_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testget_list_view_data()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        // execute the method and verify that it retunrs expected results
        $expected = array(
                'DELETED' => 0,
        );

        $actual = $emailTemplate->get_list_view_data();
        $this->assertSame($expected, $actual);
    }

    public function testparse_email_templateAndParse_tracker_urls()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        //test parse_email_template
        $account = BeanFactory::newBean('Accounts');
        $macro_nv = array();

        $expected = array(
                    'subject' => 'test subject', 'body_html' => 'test html', 'body' => 'test body text',
                    );
        $actual = $emailTemplate->parse_email_template(array('subject' => 'test subject', 'body_html' => 'test html', 'body' => 'test body text'), 'Accounts', $account, $macro_nv);
        $this->assertSame($expected, $actual);

        // test parse_tracker_urls
        $tracker_url_template = 'localhost/index.php?entryPoint=campaign_trackerv2&track=%s&identifier=tracker_key';
        $removeme_url_template = 'localhost/index.php?entryPoint=removeme&identifier=tracker_key';
        $tracker_urls = array();

        $result = $emailTemplate->parse_tracker_urls($actual, $tracker_url_template, $tracker_urls, $removeme_url_template);
        $this->assertSame($expected, $result);
    }

    public function test_convertToType()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

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
        $emailTemplate = BeanFactory::newBean('EmailTemplates');
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
        $contact = BeanFactory::newBean('Contacts');
        $user = new User(1);
        $account = BeanFactory::newBean('Accounts');

        $contact->name = 'test';
        $account->name = 'test';

        // test with empty string
        $actual = EmailTemplate::parse_template_bean('', 'Contacts', $contact);
        $this->assertEquals('', $actual);

        // test with valid string
        $actual = EmailTemplate::parse_template_bean('test', 'Users', $user);
        $this->assertEquals('test', $actual);

        // test with empty string and different module
        $actual = EmailTemplate::parse_template_bean('', 'Accounts', $account);
        $this->assertEquals('', $actual);
    }

    public function testparse_template()
    {
        $user = BeanFactory::newBean('Users');
        $user->save();
        
        $bean_arr = array('Users' => $user->id);

        // test with empty string
        $result = EmailTemplate::parse_template('', $bean_arr);
        $this->assertEquals('', $result);

        // test with valid string
        $result = EmailTemplate::parse_template('some value', $bean_arr);
        $this->assertEquals('some value', $result);
        
        // test with valid string
        $result = EmailTemplate::parse_template('$user_id', $bean_arr);
        $this->assertEquals($user->id, $result);
    }

    public function testbean_implements()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        // test with blank value
        $this->assertEquals(false, $emailTemplate->bean_implements(''));
        // test with invalid value
        $this->assertEquals(false, $emailTemplate->bean_implements('test'));
        // test with valid value
        $this->assertEquals(true, $emailTemplate->bean_implements('ACL'));
    }

    public function testgetTypeOptionsForSearch()
    {
        // execute the method and verify that it returns expected results
        $expected = [
            '' => '',
            'campaign' => 'Campaign',
            'email' => 'Email',
            'event' => 'Event'
        ];
        $actual = EmailTemplate::getTypeOptionsForSearch();
        $this->assertSame($expected, $actual);
    }

    public function testis_used_by_email_marketing()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        // test without id attribute
        $this->assertEquals(false, $emailTemplate->is_used_by_email_marketing());

        // test with id attribute
        $emailTemplate->id = 1;
        $this->assertEquals(false, $emailTemplate->is_used_by_email_marketing());
    }

    public function testcleanBean()
    {
        $emailTemplate = BeanFactory::newBean('EmailTemplates');

        // test without body_html attribute
        $emailTemplate->cleanBean();
        $this->assertEquals('', $emailTemplate->body_html);

        // test with body_html attribute
        $emailTemplate->body_html = '<h1>text</h1>';
        $emailTemplate->cleanBean();
        $this->assertEquals('&lt;h1&gt;text&lt;/h1&gt;', $emailTemplate->body_html);
    }
}
