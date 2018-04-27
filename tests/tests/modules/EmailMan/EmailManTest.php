<?php


class EmailManTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testtoString()
    {
        error_reporting(E_ERROR | E_PARSE);

        $emailMan = new EmailMan();

        //execute the method without setting attributes and verify that it retunrs expected results
        $expected = "EmailMan:\nid =  ,user_id=  module =  , related_id =  , related_type =  ,list_id = , send_date_time= \n";
        $actual = $emailMan->toString();
        $this->assertSame($expected, $actual);

        //execute the method with attributes set and verify that it retunrs expected results
        $emailMan->id = 1;
        $emailMan->user_id = 1;
        $emailMan->module = 'test';
        $emailMan->related_id = 1;
        $emailMan->related_type = 'test';
        $emailMan->list_id = 1;
        $emailMan->send_date_time = '1/1/2015';

        $expected = "EmailMan:\nid = 1 ,user_id= 1 module = test , related_id = 1 , related_type = test ,list_id = 1, send_date_time= 1/1/2015\n";
        $actual = $emailMan->toString();
        $this->assertSame($expected, $actual);
    }

    public function testEmailMan()
    {

        //execute the contructor and check for the Object type and  attributes
        $emailMan = new EmailMan();
        $this->assertInstanceOf('EmailMan', $emailMan);
        $this->assertInstanceOf('SugarBean', $emailMan);

        $this->assertAttributeEquals('EmailMan', 'module_dir', $emailMan);
        $this->assertAttributeEquals('EmailMan', 'object_name', $emailMan);
        $this->assertAttributeEquals('emailman', 'table_name', $emailMan);

        $this->assertAttributeEquals(false, 'test', $emailMan);
    }

    public function testcreate_new_list_query()
    {
        $emailMan = new EmailMan();

        //test with empty string params
        $expected = "SELECT emailman.* ,\n					campaigns.name as campaign_name,\n					email_marketing.name as message_name,\n					(CASE related_type\n						WHEN 'Contacts' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,''),'&nbsp;',IFNULL(contacts.last_name,''))))\n						WHEN 'Leads' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),'&nbsp;',IFNULL(leads.last_name,''))))\n						WHEN 'Accounts' THEN accounts.name\n						WHEN 'Users' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),'&nbsp;',IFNULL(users.last_name,''))))\n						WHEN 'Prospects' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,''),'&nbsp;',IFNULL(prospects.last_name,''))))\n					END) recipient_name	FROM emailman\n					LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type ='Users'\n					LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type ='Contacts'\n					LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type ='Leads'\n					LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type ='Accounts'\n					LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type ='Prospects'\n					LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id\n                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0\n					LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id\n					LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id WHERE  emailman.deleted=0";
        $actual = $emailMan->create_new_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = "SELECT emailman.* ,\n					campaigns.name as campaign_name,\n					email_marketing.name as message_name,\n					(CASE related_type\n						WHEN 'Contacts' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,''),'&nbsp;',IFNULL(contacts.last_name,''))))\n						WHEN 'Leads' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),'&nbsp;',IFNULL(leads.last_name,''))))\n						WHEN 'Accounts' THEN accounts.name\n						WHEN 'Users' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),'&nbsp;',IFNULL(users.last_name,''))))\n						WHEN 'Prospects' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,''),'&nbsp;',IFNULL(prospects.last_name,''))))\n					END) recipient_name	FROM emailman\n					LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type ='Users'\n					LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type ='Contacts'\n					LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type ='Leads'\n					LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type ='Accounts'\n					LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type ='Prospects'\n					LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id\n                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0\n					LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id\n					LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id WHERE emailman.user_id=\"\" AND  emailman.deleted=0";
        $actual = $emailMan->create_new_list_query('emailman.id', 'emailman.user_id=""');
        $this->assertSame($expected, $actual);
    }

    public function testcreate_queue_items_query()
    {
        $emailMan = new EmailMan();

        //without parameters
        $expected = "SELECT emailman.* ,\n					campaigns.name as campaign_name,\n					email_marketing.name as message_name,\n					(CASE related_type\n						WHEN 'Contacts' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,''),'&nbsp;',IFNULL(contacts.last_name,''))))\n						WHEN 'Leads' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),'&nbsp;',IFNULL(leads.last_name,''))))\n						WHEN 'Accounts' THEN accounts.name\n						WHEN 'Users' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),'&nbsp;',IFNULL(users.last_name,''))))\n						WHEN 'Prospects' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,''),'&nbsp;',IFNULL(prospects.last_name,''))))\n					END) recipient_name FROM emailman\n		            LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type ='Users'\n					LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type ='Contacts'\n					LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type ='Leads'\n					LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type ='Accounts'\n					LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type ='Prospects'\n					LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id\n                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0\n					LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id\n					LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id WHERE  emailman.deleted=0";
        $actual = $emailMan->create_queue_items_query('', '');
        $this->assertSame($expected, $actual);

        //with parameters
        $expected = "SELECT emailman.* ,\n					campaigns.name as campaign_name,\n					email_marketing.name as message_name,\n					(CASE related_type\n						WHEN 'Contacts' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,''),'&nbsp;',IFNULL(contacts.last_name,''))))\n						WHEN 'Leads' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),'&nbsp;',IFNULL(leads.last_name,''))))\n						WHEN 'Accounts' THEN accounts.name\n						WHEN 'Users' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),'&nbsp;',IFNULL(users.last_name,''))))\n						WHEN 'Prospects' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,''),'&nbsp;',IFNULL(prospects.last_name,''))))\n					END) recipient_name FROM emailman\n		            LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type ='Users'\n					LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type ='Contacts'\n					LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type ='Leads'\n					LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type ='Accounts'\n					LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type ='Prospects'\n					LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id\n                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0\n					LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id\n					LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id INNER JOIN (select min(id) as id from emailman  em GROUP BY em.user_id  ) secondary\n			           on emailman.id = secondary.id	WHERE emailman.user_id=\"\" AND  emailman.deleted=0";
        $actual = $emailMan->create_queue_items_query('emailman.id', 'emailman.user_id=""', array(), array('group_by' => 'emailman.user_id'));
        $this->assertSame($expected, $actual);
    }

    public function testcreate_list_query()
    {
        $emailMan = new EmailMan();

        //test with empty string params
        $expected = "SELECT emailman.* ,\n					campaigns.name as campaign_name,\n					email_marketing.name as message_name,\n					(CASE related_type\n						WHEN 'Contacts' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,''),'&nbsp;',IFNULL(contacts.last_name,''))))\n						WHEN 'Leads' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),'&nbsp;',IFNULL(leads.last_name,''))))\n						WHEN 'Accounts' THEN accounts.name\n						WHEN 'Users' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),'&nbsp;',IFNULL(users.last_name,''))))\n						WHEN 'Prospects' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,''),'&nbsp;',IFNULL(prospects.last_name,''))))\n					END) recipient_name	FROM emailman\n					LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type ='Users'\n					LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type ='Contacts'\n					LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type ='Leads'\n					LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type ='Accounts'\n					LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type ='Prospects'\n					LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id\n                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0\n					LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id\n					LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id where  emailman.deleted=0";
        $actual = $emailMan->create_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = "SELECT emailman.* ,\n					campaigns.name as campaign_name,\n					email_marketing.name as message_name,\n					(CASE related_type\n						WHEN 'Contacts' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,''),'&nbsp;',IFNULL(contacts.last_name,''))))\n						WHEN 'Leads' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,''),'&nbsp;',IFNULL(leads.last_name,''))))\n						WHEN 'Accounts' THEN accounts.name\n						WHEN 'Users' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),'&nbsp;',IFNULL(users.last_name,''))))\n						WHEN 'Prospects' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,''),'&nbsp;',IFNULL(prospects.last_name,''))))\n					END) recipient_name	FROM emailman\n					LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type ='Users'\n					LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type ='Contacts'\n					LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type ='Leads'\n					LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type ='Accounts'\n					LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type ='Prospects'\n					LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id\n                    LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0\n					LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id\n					LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id where emailman.user_id=\"\" AND  emailman.deleted=0";
        $actual = $emailMan->create_list_query('emailman.id', 'emailman.user_id=""');
        $this->assertSame($expected, $actual);
    }

    public function testget_list_view_data()
    {
        $emailMan = new EmailMan();

        $expected = array(
                'IN_QUEUE' => '0',
                'SEND_ATTEMPTS' => '0',
                'DELETED' => '0',
                'EMAIL1_LINK' => '<a href=\'javascript:void(0);\' onclick=\'SUGAR.quickCompose.init({"fullComposeUrl":"contact_id=\\u0026parent_type=EmailMan\\u0026parent_id=\\u0026parent_name=\\u0026to_addrs_ids=\\u0026to_addrs_names=\\u0026to_addrs_emails=\\u0026to_email_addrs=%26nbsp%3B%26lt%3B%26gt%3B\\u0026return_module=EmailMan\\u0026return_action=ListView\\u0026return_id=","composePackage":{"contact_id":"","parent_type":"EmailMan","parent_id":"","parent_name":"","to_addrs_ids":"","to_addrs_names":"","to_addrs_emails":"","to_email_addrs":" \\u003C\\u003E","return_module":"EmailMan","return_action":"ListView","return_id":""}});\' class=\'\'>',
        );

        $actual = $emailMan->get_list_view_data();
        $this->assertSame($expected, $actual);
    }

    public function testset_as_sent()
    {
        $emailMan = new EmailMan();

        //execute the method and test if it works and does not throws an exception.
        //test with delete true/default
        try {
            $emailMan->set_as_sent('test@test.com', true, null, null, 'send error');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }

        //execute the method and test if it works and does not throws an exception.
        //test with delete false
        try {
            $emailMan->set_as_sent('test@test.com', false, null, null, 'send error');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testcreate_indiv_email()
    {
        $emailMan = new EmailMan();

        $result = $emailMan->create_indiv_email(new Contact(), new Email());

        //test for record ID to verify that record is saved
        $this->assertEquals(36, strlen($result));

        $email = new Email();
        $email->mark_deleted($result);
    }

    public function testverify_campaign()
    {
        $emailMan = new EmailMan();
        $result = $emailMan->verify_campaign('');
        $this->assertEquals(false, $result);
    }

    public function testsendEmail()
    {
        $emailMan = new EmailMan();

        //test without setting any attributes
        $result = $emailMan->sendEmail(new Email(), 1, true);
        $this->assertEquals(false, $result);

        //test with related type attribute set
        $emailMan->related_type = 'Contacts';
        $emailMan->related_id = 1;
        $result = $emailMan->sendEmail(new Email(), 1, true);
        $this->assertEquals(true, $result);
    }

    public function testvalid_email_address()
    {
        $emailMan = new EmailMan();

        $this->assertEquals(false, $emailMan->valid_email_address(''));
        $this->assertEquals(false, $emailMan->valid_email_address('test'));
        $this->assertEquals(true, $emailMan->valid_email_address('test@test.com'));
    }

    public function testis_primary_email_address()
    {
        $emailMan = new EmailMan();

        $bean = new Contact();

        //test without setting any email
        $this->assertEquals(false, $emailMan->is_primary_email_address($bean));

        //test with a dummy email set
        $bean->email1 = 'test@test.com';
        $this->assertEquals(false, $emailMan->is_primary_email_address($bean));
    }

    public function testcreate_export_query()
    {
        $emailMan = new EmailMan();

        //test with empty string params
        $expected = 'SELECT emailman.* FROM emailman where ( emailman.deleted IS NULL OR emailman.deleted=0 )';
        $actual = $emailMan->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = 'SELECT emailman.* FROM emailman where (emailman.user_id="") AND ( emailman.deleted IS NULL OR emailman.deleted=0 )';
        $actual = $emailMan->create_export_query('emailman.id', 'emailman.user_id=""');
        $this->assertSame($expected, $actual);
    }

    public function testmark_deleted()
    {
        $emailMan = new EmailMan();

        //execute the method and test if it works and does not throws an exception.
        try {
            $emailMan->mark_deleted('');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testcreate_ref_email()
    {
        $emailMan = new EmailMan();
        $emailMan->test = true;

        $result = $emailMan->create_ref_email(0, 'test', 'test text', 'test html', 'test campaign', 'from@test.com', '1', '', array(), true, 'test from address');

        //test for email id returned and mark delete for cleanup
        $this->assertEquals(36, strlen($result));
        $email = new Email();
        $email->mark_deleted($result);
    }
}
