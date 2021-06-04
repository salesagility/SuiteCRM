<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class CampaignLogTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testCampaignLog()
    {
        // Execute the constructor and check for the Object type and  attributes
        $campaignLog = BeanFactory::newBean('CampaignLog');
        self::assertInstanceOf('CampaignLog', $campaignLog);
        self::assertInstanceOf('SugarBean', $campaignLog);

        self::assertAttributeEquals('CampaignLog', 'module_dir', $campaignLog);
        self::assertAttributeEquals('CampaignLog', 'object_name', $campaignLog);
        self::assertAttributeEquals('campaign_log', 'table_name', $campaignLog);
        self::assertAttributeEquals(true, 'new_schema', $campaignLog);
    }

    public function testget_list_view_data()
    {
        //execute the method and verify it returns an array
        $actual = BeanFactory::newBean('CampaignLog')->get_list_view_data();
        self::assertIsArray($actual);
        self::assertSame(array(), $actual);
    }

    public function testretrieve_email_address()
    {
        $actual = BeanFactory::newBean('CampaignLog')->retrieve_email_address();
        self::assertGreaterThanOrEqual('', $actual);
    }

    public function testGetRelatedName(): void
    {
        $campaignLog = BeanFactory::newBean('CampaignLog');

        // Execute the method and verify that it returns expected results for all type parameters
        self::assertEquals('1Emails', $campaignLog::get_related_name(1, 'Emails'));
        self::assertEquals('1Contacts', $campaignLog::get_related_name(1, 'Contacts'));
        self::assertEquals('1Leads', $campaignLog::get_related_name(1, 'Leads'));
        self::assertEquals('1Prospects', $campaignLog::get_related_name(1, 'Prospects'));
        self::assertEquals('1CampaignTrackers', $campaignLog::get_related_name(1, 'CampaignTrackers'));
        self::assertEquals('1Accounts', $campaignLog::get_related_name(1, 'Accounts'));
    }
}
