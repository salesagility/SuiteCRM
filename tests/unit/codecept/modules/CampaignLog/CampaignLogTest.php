<?php


class CampaignLogTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testCampaignLog()
    {

        //execute the contructor and check for the Object type and  attributes
        $campaignLog = new CampaignLog();
        $this->assertInstanceOf('CampaignLog', $campaignLog);
        $this->assertInstanceOf('SugarBean', $campaignLog);

        $this->assertAttributeEquals('CampaignLog', 'module_dir', $campaignLog);
        $this->assertAttributeEquals('CampaignLog', 'object_name', $campaignLog);
        $this->assertAttributeEquals('campaign_log', 'table_name', $campaignLog);
        $this->assertAttributeEquals(true, 'new_schema', $campaignLog);
    }

    public function testget_list_view_data()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $campaignLog = new CampaignLog();

        //execute the method and verify it returns an array
        $actual = $campaignLog->get_list_view_data();
        $this->assertTrue(is_array($actual));
        $this->assertSame(array(), $actual);
        
        // clean up
    }

    public function testretrieve_email_address()
    {
        $campaignLog = new CampaignLog();
        $actual = $campaignLog->retrieve_email_address();
        $this->assertGreaterThanOrEqual('', $actual);
    }

    public function testget_related_name()
    {
        $campaignLog = new CampaignLog();

        //execute the method and verify that it retunrs expected results for all type parameters

        $this->assertEquals('1Emails', $campaignLog->get_related_name(1, 'Emails'));
        $this->assertEquals('1Contacts', $campaignLog->get_related_name(1, 'Contacts'));
        $this->assertEquals('1Leads', $campaignLog->get_related_name(1, 'Leads'));
        $this->assertEquals('1Prospects', $campaignLog->get_related_name(1, 'Prospects'));
        $this->assertEquals('1CampaignTrackers', $campaignLog->get_related_name(1, 'CampaignTrackers'));
        $this->assertEquals('1Accounts', $campaignLog->get_related_name(1, 'Accounts'));
    }
}
