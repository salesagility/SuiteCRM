<?php


class EmailMarketingTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function testEmailMarketing()
    {

        //execute the contructor and check for the Object type and  attributes
        $emailMarketing = new EmailMarketing();

        $this->assertInstanceOf('EmailMarketing', $emailMarketing);
        $this->assertInstanceOf('SugarBean', $emailMarketing);

        $this->assertAttributeEquals('EmailMarketing', 'module_dir', $emailMarketing);
        $this->assertAttributeEquals('EmailMarketing', 'object_name', $emailMarketing);
        $this->assertAttributeEquals('email_marketing', 'table_name', $emailMarketing);

        $this->assertAttributeEquals(true, 'new_schema', $emailMarketing);
    }

    public function testretrieve()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $emailMarketing = new EmailMarketing();

        $result = $emailMarketing->retrieve();
        $this->assertInstanceOf('EmailMarketing', $result);
        
        // clean up
    }

    public function testget_summary_text()
    {
        $emailMarketing = new EmailMarketing();

        //test without setting name
        $this->assertEquals(null, $emailMarketing->get_summary_text());

        //test with name set
        $emailMarketing->name = 'test';
        $this->assertEquals('test', $emailMarketing->get_summary_text());
    }

    public function testcreate_export_query()
    {
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        
        $emailMarketing = new EmailMarketing();

        //test with empty string params
        $expected = " SELECT  email_marketing.*  , jt0.name template_name , jt0.assigned_user_id template_name_owner  , 'EmailTemplates' template_name_mod FROM email_marketing   LEFT JOIN  email_templates jt0 ON email_marketing.template_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0 where email_marketing.deleted=0";
        $actual = $emailMarketing->create_export_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = " SELECT  email_marketing.*  , jt0.name template_name , jt0.assigned_user_id template_name_owner  , 'EmailTemplates' template_name_mod FROM email_marketing   LEFT JOIN  email_templates jt0 ON email_marketing.template_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0 where (email_marketing.name=\"\") AND email_marketing.deleted=0";
        $actual = $emailMarketing->create_export_query('email_marketing.id', 'email_marketing.name=""');
        $this->assertSame($expected, $actual);


        // clean up
        
        $state->popGlobals();
    }

    public function testget_list_view_data()
    {
        $emailMarketing = new EmailMarketing();

        //execute the method and verify that it retunrs expected results
        $expected = array(
                'ALL_PROSPECT_LISTS' => '0',
        );

        $actual = $emailMarketing->get_list_view_data();
        $this->assertSame($expected, $actual);
    }

    public function testbean_implements()
    {
        $emailMarketing = new EmailMarketing();
        $this->assertEquals(false, $emailMarketing->bean_implements('')); //test with blank value
        $this->assertEquals(false, $emailMarketing->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $emailMarketing->bean_implements('ACL')); //test with valid value
    }

    public function testget_all_prospect_lists()
    {
        $emailMarketing = new EmailMarketing();

        //execute the method and verify that it retunrs expected results
        $expected = "select prospect_lists.* from prospect_lists  left join prospect_list_campaigns on prospect_list_campaigns.prospect_list_id=prospect_lists.id where prospect_list_campaigns.deleted=0 and prospect_list_campaigns.campaign_id='' and prospect_lists.deleted=0 and prospect_lists.list_type not like 'exempt%'";
        $actual = $emailMarketing->get_all_prospect_lists();
        $this->assertSame($expected, $actual);
    }
}
