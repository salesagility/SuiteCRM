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
 * Class CampaignLogTest
 */
class CampaignLogTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
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
        error_reporting(E_ERROR | E_PARSE);
    
        $campaignLog = new CampaignLog();
    
        //execute the method and verify it returns an array
        $actual = $campaignLog->get_list_view_data();
        $this->assertTrue(is_array($actual));
        $this->assertSame(array(), $actual);
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
