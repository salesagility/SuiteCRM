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
 * Class SugarFeedTest
 */
class SugarFeedTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testSugarFeed()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        //execute the contructor and check for the Object type and  attributes
        $sugarFeed = new SugarFeed();
    
        $this->assertInstanceOf('SugarFeed', $sugarFeed);
        $this->assertInstanceOf('Basic', $sugarFeed);
        $this->assertInstanceOf('SugarBean', $sugarFeed);
    
        $this->assertAttributeEquals('sugarfeed', 'table_name', $sugarFeed);
        $this->assertAttributeEquals('SugarFeed', 'module_dir', $sugarFeed);
        $this->assertAttributeEquals('SugarFeed', 'object_name', $sugarFeed);
    
        $this->assertAttributeEquals(true, 'new_schema', $sugarFeed);
        $this->assertAttributeEquals(false, 'importable', $sugarFeed);
    }
    
    public function testactivateAndDisableModuleFeed()
    {
        $admin = new Administration();
    
        //test activateModuleFeed method
        SugarFeed::activateModuleFeed('Accounts');
        $admin->retrieveSettings('sugarfeed');
        $this->assertEquals(1, $admin->settings['sugarfeed_module_Accounts']);
    
        //test disableModuleFeed method
        SugarFeed::disableModuleFeed('Accounts');
        $admin->retrieveSettings('sugarfeed');
        $this->assertEquals(0, $admin->settings['sugarfeed_module_Accounts']);
    }
    
    public function testflushBackendCache()
    {
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            SugarFeed::flushBackendCache();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testgetModuleFeedFiles()
    {
    
        //test with invalid module
        $expected = array();
        $result = SugarFeed::getModuleFeedFiles('Accounts');
        $this->assertEquals($expected, $result);
    
        //test with valid module
        $expected = array('CaseFeed.php' => 'modules/Cases/SugarFeeds/CaseFeed.php');
        $result = SugarFeed::getModuleFeedFiles('Cases');
        $this->assertEquals($expected, $result);
    }
    
    public function testgetActiveFeedModules()
    {
        $result = SugarFeed::getActiveFeedModules();
    
        $expected = array(
            'UserFeed'      => 'UserFeed',
            'Cases'         => 'Cases',
            'Contacts'      => 'Contacts',
            'Leads'         => 'Leads',
            'Opportunities' => 'Opportunities',
        );
    
        $this->assertEquals($expected, $result);
    }
    
    public function testgetAllFeedModules()
    {
        $result = SugarFeed::getAllFeedModules();
        $expected = array(
            'UserFeed'      => 'UserFeed',
            'Cases'         => 'Cases',
            'Contacts'      => 'Contacts',
            'Leads'         => 'Leads',
            'Opportunities' => 'Opportunities',
        );
        
        $this->assertEquals($expected, $result);
    }
    
    public function testpushFeed2()
    {
        $lead = new Lead();
        $lead->id = 1;
        $lead->assigned_user_id = 1;
    
        SugarFeed::pushFeed2('some text 2', $lead, 'Link', 'some url');
    
        //retrieve newly created bean
        $sugarFeed = new SugarFeed();
        $result = $sugarFeed->retrieve_by_string_fields(array('related_id' => '1', 'related_module' => 'Leads'));
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($sugarFeed->id));
        $this->assertEquals(36, strlen($sugarFeed->id));
    
        //mark the record as deleted
        $sugarFeed->mark_deleted($sugarFeed->id);
    }
    
    public function testpushFeed()
    {
        SugarFeed::pushFeed('some text', 'SugarFeed', 1, 1, 'Link', 'some url');
    
        //retrieve newly created bean
        $sugarFeed = new SugarFeed();
        $result = $sugarFeed->retrieve_by_string_fields(array('related_id' => '1', 'related_module' => 'SugarFeed'));
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($sugarFeed->id));
        $this->assertEquals(36, strlen($sugarFeed->id));
    
        //test fetchReplies method
        $this->fetchReplies();
    
        //mark the record as deleted 
        $sugarFeed->mark_deleted($sugarFeed->id);
    }
    
    public function fetchReplies()
    {
        $sugarFeed = new SugarFeed();
    
        $actual = $sugarFeed->fetchReplies(array('ID' => '1'));
        $this->assertGreaterThan(0, strlen($actual));
    }
    
    public function testgetLinkTypes()
    {
        $result = SugarFeed::getLinkTypes();
    
        $expected = array(
            'Image'   => 'Image',
            'Link'    => 'Link',
            'YouTube' => 'YouTube',
        );
        $this->assertEquals($expected, $result);
    }
    
    public function testgetLinkClass()
    {
    
        //test with invalid LinkType
        $result = SugarFeed::getLinkClass('test');
        $this->assertEquals(false, $result);
    
        //test with LinkType Image
        $result = SugarFeed::getLinkClass('Image');
        $this->assertInstanceOf('FeedLinkHandlerImage', $result);
    
        //test with LinkType Link
        $result = SugarFeed::getLinkClass('Link');
        $this->assertInstanceOf('FeedLinkHandlerLink', $result);
    
        //test with LinkType YouTube
        $result = SugarFeed::getLinkClass('YouTube');
        $this->assertInstanceOf('FeedLinkHandlerYoutube', $result);
    }
    
    public function testget_list_view_data()
    {
        $sugarFeed = new SugarFeed();
    
        $result = $sugarFeed->get_list_view_data();
        $this->assertTrue(is_array($result));
    }
    
    public function testgetTimeLapse()
    {
        $result = SugarFeed::getTimeLapse('2016-01-15 11:16:02');
        $this->assertTrue(isset($result));
        $this->assertGreaterThan(0, strlen($result));
    }
    
    public function testparseMessage()
    {
    
        //test with a string with no links
        $html = 'some text with no urls';
        $result = SugarFeed::parseMessage($html);
        $this->assertEquals($html, $result);
    
        //test with a string with links
        $html = 'some text http://www.url.com with no urls';
        $expected = "some text <a href='http://www.url.com' target='_blank'>http://www.url.com</a> with no urls";
        $result = SugarFeed::parseMessage($html);
        $this->assertEquals($expected, $result);
    }
}
