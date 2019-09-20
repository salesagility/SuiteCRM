<?php

class TrackerTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

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
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

        // test
        $tracker = new Tracker();

        $result = $tracker->get_recently_viewed(1);

        $this->assertInstanceOf('BreadCrumbStack', $_SESSION['breadCrumbs']);
        $this->assertTrue(is_array($result));
        
        // clean up
        $state->popGlobals();
    }

    public function testmakeInvisibleForAll()
    {
        $tracker = new Tracker();

        //execute the method and test if it works and does not throws an exception.
        try {
            $tracker->makeInvisibleForAll(1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
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
        self::markTestIncomplete('Test parameters and local variables are not set');
                
        $state = new SuiteCRM\StateSaver();
        
        $state->pushGlobals();

        //test without setting headerDisplayed
        Tracker::logPage();
        $this->assertEquals(null, $_SESSION['lpage']);

        //test with headerDisplayed set
        $GLOBALS['app']->headerDisplayed = 1;
        Tracker::logPage();
        $this->assertEquals(time(), $_SESSION['lpage']);
        
        //$this->assertEquals(time(), null);
        
        // clean up
        $state->popGlobals();
    }
}
