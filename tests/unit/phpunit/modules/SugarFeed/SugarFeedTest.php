<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class SugarFeedTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testSugarFeed()
    {
        // Execute the constructor and check for the Object type and  attributes
        $sugarFeed = BeanFactory::newBean('SugarFeed');

        self::assertInstanceOf('SugarFeed', $sugarFeed);
        self::assertInstanceOf('Basic', $sugarFeed);
        self::assertInstanceOf('SugarBean', $sugarFeed);

        self::assertAttributeEquals('sugarfeed', 'table_name', $sugarFeed);
        self::assertAttributeEquals('SugarFeed', 'module_dir', $sugarFeed);
        self::assertAttributeEquals('SugarFeed', 'object_name', $sugarFeed);

        self::assertAttributeEquals(true, 'new_schema', $sugarFeed);
        self::assertAttributeEquals(false, 'importable', $sugarFeed);
    }

    public function testactivateAndDisableModuleFeed()
    {
        self::markTestIncomplete('environment dependency');

        $admin = BeanFactory::newBean('Administration');

        //test activateModuleFeed method
        SugarFeed::activateModuleFeed('Accounts');
        $admin->retrieveSettings('sugarfeed');
        self::assertEquals(1, $admin->settings['sugarfeed_module_Accounts']);

        //test disableModuleFeed method
        SugarFeed::disableModuleFeed('Accounts');
        $admin->retrieveSettings('sugarfeed');
        self::assertEquals(0, $admin->settings['sugarfeed_module_Accounts']);
    }

    public function testflushBackendCache()
    {
        // Execute the method and test that it works and doesn't throw an exception.
        try {
            SugarFeed::flushBackendCache();
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testgetModuleFeedFiles()
    {
        //test with invalid module
        $expected = array();
        $result = SugarFeed::getModuleFeedFiles('Accounts');
        self::assertEquals($expected, $result);

        //test with valid module
        $expected = array('CaseFeed.php' => 'modules/Cases/SugarFeeds/CaseFeed.php');
        $result = SugarFeed::getModuleFeedFiles('Cases');
        self::assertEquals($expected, $result);
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

        self::assertEquals($expected, $result);
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

        self::assertEquals($expected, $result);
    }

    public function testpushFeed2()
    {
        $lead = BeanFactory::newBean('Leads');
        $lead->id = 1;
        $lead->assigned_user_id = 1;

        SugarFeed::pushFeed2('some text 2', $lead, 'Link', 'some url');

        //retrieve newly created bean
        $sugarFeed = BeanFactory::newBean('SugarFeed');
        $result = $sugarFeed->retrieve_by_string_fields(array('related_id' => '1', 'related_module' => 'Leads'));

        //test for record ID to verify that record is saved
        self::assertTrue(isset($sugarFeed->id));
        self::assertEquals(36, strlen($sugarFeed->id));

        //mark the record as deleted
        $sugarFeed->mark_deleted($sugarFeed->id);
    }

    public function testpushFeed()
    {
        SugarFeed::pushFeed('some text', 'SugarFeed', 1, 1, 'Link', 'some url');

        //retrieve newly created bean
        $sugarFeed = BeanFactory::newBean('SugarFeed');
        $result = $sugarFeed->retrieve_by_string_fields(array('related_id' => '1', 'related_module' => 'SugarFeed'));

        //test for record ID to verify that record is saved
        self::assertTrue(isset($sugarFeed->id));
        self::assertEquals(36, strlen($sugarFeed->id));

        //test fetchReplies method
        $this->fetchReplies();

        //mark the record as deleted
        $sugarFeed->mark_deleted($sugarFeed->id);
    }

    public function fetchReplies()
    {
        $sugarFeed = BeanFactory::newBean('SugarFeed');

        $actual = $sugarFeed->fetchReplies(array('ID' => '1'));
        self::assertGreaterThan(0, strlen($actual));
    }

    public function testgetLinkTypes()
    {
        $result = SugarFeed::getLinkTypes();

        $expected = array(
                'Image' => 'Image',
                'Link' => 'Link',
                'YouTube' => 'YouTube',
        );
        self::assertEquals($expected, $result);
    }

    public function testgetLinkClass()
    {
        //test with invalid LinkType
        $result = SugarFeed::getLinkClass('test');
        self::assertEquals(false, $result);

        //test with LinkType Image
        $result = SugarFeed::getLinkClass('Image');
        self::assertInstanceOf('FeedLinkHandlerImage', $result);

        //test with LinkType Link
        $result = SugarFeed::getLinkClass('Link');
        self::assertInstanceOf('FeedLinkHandlerLink', $result);

        //test with LinkType YouTube
        $result = SugarFeed::getLinkClass('YouTube');
        self::assertInstanceOf('FeedLinkHandlerYoutube', $result);
    }

    public function testget_list_view_data()
    {
        $sugarFeed = BeanFactory::newBean('SugarFeed');

        $result = $sugarFeed->get_list_view_data();
        self::assertTrue(is_array($result));
    }

    public function testgetTimeLapse()
    {
        $result = SugarFeed::getTimeLapse('2016-01-15 11:16:02');
        self::assertTrue(isset($result));
        self::assertGreaterThanOrEqual(0, strlen($result));
    }

    public function testparseMessage()
    {
        // test with a string with no links
        $html = 'some text with no urls';
        $result = SugarFeed::parseMessage($html);
        self::assertEquals($html, $result);

        // test with a string with links
        $html = 'some text http://www.url.com with no urls';
        $expected = "some text <a href='http://www.url.com' target='_blank'>http://www.url.com</a> with no urls";
        $result = SugarFeed::parseMessage($html);
        self::assertEquals($expected, $result);
    }
}
