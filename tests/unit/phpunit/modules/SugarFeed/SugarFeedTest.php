<?php

class SugarFeedTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testSugarFeed()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

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
        
        // clean up
    }

    public function testactivateAndDisableModuleFeed()
    {
        self::markTestIncomplete('environment dependency');

        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('config');

        // test
        
        $admin = new Administration();

        //test activateModuleFeed method
        SugarFeed::activateModuleFeed('Accounts');
        $admin->retrieveSettings('sugarfeed');
        $this->assertEquals(1, $admin->settings['sugarfeed_module_Accounts']);

        //test disableModuleFeed method
        SugarFeed::disableModuleFeed('Accounts');
        $admin->retrieveSettings('sugarfeed');
        $this->assertEquals(0, $admin->settings['sugarfeed_module_Accounts']);
        
        // clean up
        
        $state->popTable('config');
    }

    public function testflushBackendCache()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        //execute the method and test if it works and does not throws an exception.
        try {
            SugarFeed::flushBackendCache();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
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
                'UserFeed' => 'UserFeed',
                'Cases' => 'Cases',
                'Contacts' => 'Contacts',
                'Leads' => 'Leads',
                'Opportunities' => 'Opportunities',
        );

        $this->assertEquals($expected, $result);
    }

    public function testgetAllFeedModules()
    {
        $result = SugarFeed::getAllFeedModules();
        $expected = array(
                      'UserFeed' => 'UserFeed',
                      'Cases' => 'Cases',
                      'Contacts' => 'Contacts',
                      'Leads' => 'Leads',
                      'Opportunities' => 'Opportunities',
                    );

        $this->assertEquals($expected, $result);
    }

    public function testpushFeed2()
    {

    // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('sugarfeed');

        // test
        
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
        
        // clean up
        
        $state->popTable('sugarfeed');
        $state->popTable('aod_index');
    }

    public function testpushFeed()
    {
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('sugarfeed');

        // test
        
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
        
        // clean up
        
        $state->popTable('sugarfeed');
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
                'Image' => 'Image',
                'Link' => 'Link',
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
        $this->assertGreaterThanOrEqual(0, strlen($result));
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
