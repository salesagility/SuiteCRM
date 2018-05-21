<?php

class TrackerTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }
    
    public function testTracker()
    {
        //execute the contructor and check for the Object type and  attributes
        $tracker = new Tracker();

        $this->assertInstanceOf('Tracker', $tracker);
        $this->assertInstanceOf('SugarBean', $tracker);

        $this->assertAttributeEquals('tracker', 'table_name', $tracker);
        $this->assertAttributeEquals('Trackers', 'module_dir', $tracker);
        $this->assertAttributeEquals('Tracker', 'object_name', $tracker);

        $this->assertAttributeEquals(true, 'disable_var_defs', $tracker);

        $this->assertAttributeEquals('Tracker', 'acltype', $tracker);
        $this->assertAttributeEquals('Trackers', 'acl_category', $tracker);
        $this->assertAttributeEquals(true, 'disable_custom_fields', $tracker);
    }

    public function testget_recently_viewed()
    {
        $tracker = new Tracker();

        $result = $tracker->get_recently_viewed(1);

        $this->assertInstanceOf('BreadCrumbStack', $_SESSION['breadCrumbs']);
        $this->assertTrue(is_array($result));
    }

    public function testmakeInvisibleForAll()
    {
        $tracker = new Tracker();

        //execute the method and test if it works and does not throws an exception.
        try {
            $tracker->makeInvisibleForAll(1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testbean_implements()
    {
        $tracker = new Tracker();

        $this->assertEquals(false, $tracker->bean_implements('')); //test with blank value
        $this->assertEquals(false, $tracker->bean_implements('test')); //test with invalid value
        $this->assertEquals(false, $tracker->bean_implements('ACL')); //test with valid value
    }

    public function testlogPage()
    {
        error_reporting(E_ERROR | E_PARSE);

        //test without setting headerDisplayed
        Tracker::logPage();
        $this->assertEquals(null, $_SESSION['lpage']);

        //test with headerDisplayed set
        $GLOBALS['app']->headerDisplayed = 1;
        Tracker::logPage();
        $this->assertEquals(time(), $_SESSION['lpage']);
    }
}
