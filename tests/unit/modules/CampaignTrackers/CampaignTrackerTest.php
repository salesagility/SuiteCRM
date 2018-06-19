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
        
        

        
        $campaignTracker = new CampaignTracker();
        $this->assertInstanceOf('CampaignTracker', $campaignTracker);
        $this->assertInstanceOf('SugarBean', $campaignTracker);

        $this->assertAttributeEquals('CampaignTrackers', 'module_dir', $campaignTracker);
        $this->assertAttributeEquals('CampaignTracker', 'object_name', $campaignTracker);
        $this->assertAttributeEquals('campaign_trkrs', 'table_name', $campaignTracker);
        $this->assertAttributeEquals(true, 'new_schema', $campaignTracker);
        
        
        
        $state->popTable('aod_index');
    }

    public function testsave()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('campaign_trkrs');
        $state->pushTable('aod_index');
        $state->pushTable('tracker');

	
        
        $campaignTracker = new CampaignTracker();

        $campaignTracker->tracker_name = 'test';
        $campaignTracker->is_optout = 1;

        $campaignTracker->save();

        
        $this->assertTrue(isset($campaignTracker->id));
        $this->assertEquals(36, strlen($campaignTracker->id));

        
        $campaignTracker->mark_deleted($campaignTracker->id);
        $result = $campaignTracker->retrieve($campaignTracker->id);
        $this->assertEquals(null, $result);
        
        
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
        $state->popTable('campaign_trkrs');
    }

    public function testget_summary_text()
    {
        $campaignTracker = new CampaignTracker();

        
        $this->assertEquals(null, $campaignTracker->get_summary_text());

        
        $campaignTracker->tracker_name = 'test';
        $this->assertEquals('test', $campaignTracker->get_summary_text());
    }

    public function testfill_in_additional_detail_fields()
    {
        $campaignTracker = new CampaignTracker();

        
        $campaignTracker->fill_in_additional_detail_fields();
        $this->assertStringEndsWith('/index.php?entryPoint=campaign_trackerv2&track=', $campaignTracker->message_url);

        
        $campaignTracker->is_optout = 1;
        $campaignTracker->fill_in_additional_detail_fields();
        $this->assertStringEndsWith('/index.php?entryPoint=removeme&identifier={MESSAGE_ID}', $campaignTracker->message_url);
    }
}
