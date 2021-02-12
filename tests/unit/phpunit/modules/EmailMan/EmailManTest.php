<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class EmailManTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testtoString()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

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
        // Execute the constructor and check for the Object type and  attributes
        $emailMan = BeanFactory::newBean('EmailMan');
        $this->assertInstanceOf('EmailMan', $emailMan);
        $this->assertInstanceOf('SugarBean', $emailMan);

        $this->assertAttributeEquals('EmailMan', 'module_dir', $emailMan);
        $this->assertAttributeEquals('EmailMan', 'object_name', $emailMan);
        $this->assertAttributeEquals('emailman', 'table_name', $emailMan);

        $this->assertAttributeEquals(false, 'test', $emailMan);
    }

    public function testcreate_new_list_query()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

        //test with empty string params
        $expected = 'SELECT emailman.* , campaigns.name as campaign_name, email_marketing.name as message_name, (CASE related_type WHEN \'Contacts\' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,\'\'),\' \',IFNULL(contacts.last_name,\'\')))) WHEN \'Leads\' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,\'\'),\' \',IFNULL(leads.last_name,\'\')))) WHEN \'Accounts\' THEN accounts.name WHEN \'Users\' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,\'\'),\' \',IFNULL(users.last_name,\'\')))) WHEN \'Prospects\' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,\'\'),\' \',IFNULL(prospects.last_name,\'\')))) END) recipient_name FROM emailman LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type =\'Users\' LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type =\'Contacts\' LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type =\'Leads\' LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type =\'Accounts\' LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type =\'Prospects\' LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0 LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id WHERE  emailman.deleted=0';
        $actual = $emailMan->create_new_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = 'SELECT emailman.* , campaigns.name as campaign_name, email_marketing.name as message_name, (CASE related_type WHEN \'Contacts\' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,\'\'),\' \',IFNULL(contacts.last_name,\'\')))) WHEN \'Leads\' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,\'\'),\' \',IFNULL(leads.last_name,\'\')))) WHEN \'Accounts\' THEN accounts.name WHEN \'Users\' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,\'\'),\' \',IFNULL(users.last_name,\'\')))) WHEN \'Prospects\' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,\'\'),\' \',IFNULL(prospects.last_name,\'\')))) END) recipient_name FROM emailman LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type =\'Users\' LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type =\'Contacts\' LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type =\'Leads\' LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type =\'Accounts\' LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type =\'Prospects\' LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0 LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id WHERE emailman.user_id="" AND  emailman.deleted=0';
        $actual = $emailMan->create_new_list_query('emailman.id', 'emailman.user_id=""');
        $this->assertSame($expected, $actual);
    }

    public function testcreate_queue_items_query()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

        //without parameters
        $expected = 'SELECT emailman.* , campaigns.name as campaign_name, email_marketing.name as message_name, (CASE related_type WHEN \'Contacts\' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,\'\'),\' \',IFNULL(contacts.last_name,\'\')))) WHEN \'Leads\' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,\'\'),\' \',IFNULL(leads.last_name,\'\')))) WHEN \'Accounts\' THEN accounts.name WHEN \'Users\' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,\'\'),\' \',IFNULL(users.last_name,\'\')))) WHEN \'Prospects\' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,\'\'),\' \',IFNULL(prospects.last_name,\'\')))) END) recipient_name FROM emailman LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type =\'Users\' LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type =\'Contacts\' LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type =\'Leads\' LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type =\'Accounts\' LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type =\'Prospects\' LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0 LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id WHERE  emailman.deleted=0';
        $actual = $emailMan->create_queue_items_query('', '');
        $this->assertSame($expected, $actual);

        //with parameters
        $expected = 'SELECT emailman.* , campaigns.name as campaign_name, email_marketing.name as message_name, (CASE related_type WHEN \'Contacts\' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,\'\'),\' \',IFNULL(contacts.last_name,\'\')))) WHEN \'Leads\' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,\'\'),\' \',IFNULL(leads.last_name,\'\')))) WHEN \'Accounts\' THEN accounts.name WHEN \'Users\' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,\'\'),\' \',IFNULL(users.last_name,\'\')))) WHEN \'Prospects\' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,\'\'),\' \',IFNULL(prospects.last_name,\'\')))) END) recipient_name FROM emailman LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type =\'Users\' LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type =\'Contacts\' LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type =\'Leads\' LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type =\'Accounts\' LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type =\'Prospects\' LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0 LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_id INNER JOIN (select min(id) as id from emailman  em GROUP BY em.user_id) secondary on emailman.id = secondary.id WHERE emailman.user_id="" AND  emailman.deleted=0';
        $actual = $emailMan->create_queue_items_query(
            'emailman.id',
            'emailman.user_id=""',
            array(),
            array('group_by' => 'emailman.user_id')
        );
        $this->assertSame($expected, $actual);
    }

    public function testcreate_list_query()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

        //test with empty string params
        $expected = 'SELECT emailman.* ,campaigns.name as campaign_name,email_marketing.name as message_name,(CASE related_type WHEN \'Contacts\' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,\'\'),\' \',IFNULL(contacts.last_name,\'\'))))WHEN \'Leads\' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,\'\'),\' \',IFNULL(leads.last_name,\'\'))))WHEN \'Accounts\' THEN accounts.name WHEN \'Users\' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,\'\'),\' \',IFNULL(users.last_name,\'\'))))WHEN \'Prospects\' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,\'\'),\' \',IFNULL(prospects.last_name,\'\'))))END) recipient_name    FROM emailman LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type =\'Users\' LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type =\'Contacts\' LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type =\'Leads\' LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type =\'Accounts\' LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type =\'Prospects\' LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0 LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_idwhere  emailman.deleted=0';
        $actual = $emailMan->create_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = 'SELECT emailman.* ,campaigns.name as campaign_name,email_marketing.name as message_name,(CASE related_type WHEN \'Contacts\' THEN LTRIM(RTRIM(CONCAT(IFNULL(contacts.first_name,\'\'),\' \',IFNULL(contacts.last_name,\'\'))))WHEN \'Leads\' THEN LTRIM(RTRIM(CONCAT(IFNULL(leads.first_name,\'\'),\' \',IFNULL(leads.last_name,\'\'))))WHEN \'Accounts\' THEN accounts.name WHEN \'Users\' THEN LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,\'\'),\' \',IFNULL(users.last_name,\'\'))))WHEN \'Prospects\' THEN LTRIM(RTRIM(CONCAT(IFNULL(prospects.first_name,\'\'),\' \',IFNULL(prospects.last_name,\'\'))))END) recipient_name    FROM emailman LEFT JOIN users ON users.id = emailman.related_id and emailman.related_type =\'Users\' LEFT JOIN contacts ON contacts.id = emailman.related_id and emailman.related_type =\'Contacts\' LEFT JOIN leads ON leads.id = emailman.related_id and emailman.related_type =\'Leads\' LEFT JOIN accounts ON accounts.id = emailman.related_id and emailman.related_type =\'Accounts\' LEFT JOIN prospects ON prospects.id = emailman.related_id and emailman.related_type =\'Prospects\' LEFT JOIN prospect_lists ON prospect_lists.id = emailman.list_id LEFT JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = emailman.related_id and emailman.related_type = email_addr_bean_rel.bean_module and email_addr_bean_rel.primary_address = 1 and email_addr_bean_rel.deleted=0 LEFT JOIN campaigns ON campaigns.id = emailman.campaign_id LEFT JOIN email_marketing ON email_marketing.id = emailman.marketing_idwhere emailman.user_id="" AND  emailman.deleted=0';
        $actual = $emailMan->create_list_query('emailman.id', 'emailman.user_id=""');
        $this->assertSame($expected, $actual);
    }

    public function testget_list_view_data()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

        $expected = array(
            'IN_QUEUE' => '0',
            'SEND_ATTEMPTS' => '0',
            'DELETED' => '0',
            'RELATED_CONFIRM_OPT_IN' => '0',
            'EMAIL1_LINK' => '            <a class="email-link" href="mailto:"
                    onclick="$(document).openComposeViewModal(this);"
                    data-module="EmailMan" data-record-id=""
                    data-module-name="" data-email-address=""
                ></a>'
        );

        $actual = $emailMan->get_list_view_data();
        $this->assertSame($expected, $actual);
    }

    public function testset_as_sent()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

        // Execute the method and test that it works and doesn't throw an exception.
        //test with delete true/default
        try {
            $emailMan->set_as_sent('test@test.com', true, null, null, 'send error');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        // Execute the method and test that it works and doesn't throw an exception.
        //test with delete false
        try {
            $emailMan->set_as_sent('test@test.com', false, null, null, 'send error');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testcreate_indiv_email()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

        $result = $emailMan->create_indiv_email(BeanFactory::newBean('Contacts'), BeanFactory::newBean('Emails'));

        //test for record ID to verify that record is saved
        $this->assertEquals(36, strlen($result));

        $email = BeanFactory::newBean('Emails');
        $email->mark_deleted($result);
    }

    public function testverify_campaign()
    {
        // test
        $emailMan = BeanFactory::newBean('EmailMan');
        $result = $emailMan->verify_campaign('');
        $this->assertEquals(false, $result);
    }

    public function testsendEmail()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

        //test without setting any attributes
        $result = $emailMan->sendEmail(new SugarPHPMailer(), 1, true);
        $this->assertEquals(false, $result);

        //test with related type attribute set
        $emailMan->related_type = 'Contacts';
        $emailMan->related_id = 1;
        $result = $emailMan->sendEmail(new SugarPHPMailer(), 1, true);
        $this->assertEquals(true, $result);
    }

    public function testvalid_email_address()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

        $this->assertEquals(false, $emailMan->valid_email_address(''));
        $this->assertEquals(false, $emailMan->valid_email_address('test'));
        $this->assertEquals(true, $emailMan->valid_email_address('test@test.com'));
    }

    public function testis_primary_email_address()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

        $bean = BeanFactory::newBean('Contacts');

        //test without setting any email
        $this->assertEquals(false, $emailMan->is_primary_email_address($bean));
    }

    public function testcreate_export_query()
    {
        $emailMan = BeanFactory::newBean('EmailMan');

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
        $emailMan = BeanFactory::newBean('EmailMan');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $emailMan->mark_deleted('');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testcreate_ref_email()
    {
        $emailMan = BeanFactory::newBean('EmailMan');
        $emailMan->test = true;

        $result = $emailMan->create_ref_email(
            0,
            'test',
            'test text',
            'test html',
            'test campaign',
            'from@test.com',
            '1',
            '',
            array(),
            true,
            'test from address'
        );

        //test for email id returned and mark delete for cleanup
        $this->assertEquals(36, strlen($result));
        $email = BeanFactory::newBean('Emails');
        $email->mark_deleted($result);
    }
}
