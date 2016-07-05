<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**
 * Class CampaignTrackerTest
 */
class CampaignTrackerTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testCampaignTracker()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        //execute the contructor and check for the Object type and  attributes
        $campaignTracker = new CampaignTracker();
        $this->assertInstanceOf('CampaignTracker', $campaignTracker);
        $this->assertInstanceOf('SugarBean', $campaignTracker);
    
        $this->assertAttributeEquals('CampaignTrackers', 'module_dir', $campaignTracker);
        $this->assertAttributeEquals('CampaignTracker', 'object_name', $campaignTracker);
        $this->assertAttributeEquals('campaign_trkrs', 'table_name', $campaignTracker);
        $this->assertAttributeEquals(true, 'new_schema', $campaignTracker);
    }
    
    public function testsave()
    {
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
        $this->assertStringEndsWith('/index.php?entryPoint=removeme&identifier={MESSAGE_ID}',
                                    $campaignTracker->message_url);
    }
}
