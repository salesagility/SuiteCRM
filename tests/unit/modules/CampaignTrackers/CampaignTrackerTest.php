<?php


class CampaignTrackerTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testCampaignTracker()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        
        //error_reporting(E_ERROR | E_PARSE);

        //execute the contructor and check for the Object type and  attributes
        $campaignTracker = new CampaignTracker();
        $this->assertInstanceOf('CampaignTracker', $campaignTracker);
        $this->assertInstanceOf('SugarBean', $campaignTracker);

        $this->assertAttributeEquals('CampaignTrackers', 'module_dir', $campaignTracker);
        $this->assertAttributeEquals('CampaignTracker', 'object_name', $campaignTracker);
        $this->assertAttributeEquals('campaign_trkrs', 'table_name', $campaignTracker);
        $this->assertAttributeEquals(true, 'new_schema', $campaignTracker);
        
        // clean up
        
        $state->popTable('aod_index');
    }

    public function testsave()
    {
	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('campaign_trkrs');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');

	// test
        
        $campaignTracker = new CampaignTracker();

        $campaignTracker->tracker_name = 'test';
        $campaignTracker->is_optout = 1;

        $campaignTracker->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($campaignTracker->id));
        $this->assertEquals(36, strlen($campaignTracker->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $campaignTracker->mark_deleted($campaignTracker->id);
        $result = $campaignTracker->retrieve($campaignTracker->id);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
        $state->popTable('campaign_trkrs');
    }

    public function testget_summary_text()
    {
        $campaignTracker = new CampaignTracker();

        //test without setting name
        $this->assertEquals(null, $campaignTracker->get_summary_text());

        //test with name set
        $campaignTracker->tracker_name = 'test';
        $this->assertEquals('test', $campaignTracker->get_summary_text());
    }

    public function testfill_in_additional_detail_fields()
    {
        $campaignTracker = new CampaignTracker();

        //test without is_optout set
        $campaignTracker->fill_in_additional_detail_fields();
        $this->assertStringEndsWith('/index.php?entryPoint=campaign_trackerv2&track=', $campaignTracker->message_url);

        //test with is_optout set
        $campaignTracker->is_optout = 1;
        $campaignTracker->fill_in_additional_detail_fields();
        $this->assertStringEndsWith('/index.php?entryPoint=removeme&identifier={MESSAGE_ID}', $campaignTracker->message_url);
    }
}
