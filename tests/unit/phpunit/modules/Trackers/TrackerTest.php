<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class TrackerTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testTracker()
    {
        // Execute the constructor and check for the Object type and  attributes
        $tracker = BeanFactory::newBean('Trackers');

        self::assertInstanceOf('Tracker', $tracker);
        self::assertInstanceOf('SugarBean', $tracker);

        self::assertAttributeEquals('tracker', 'table_name', $tracker);
        self::assertAttributeEquals('Trackers', 'module_dir', $tracker);
        self::assertAttributeEquals('Tracker', 'object_name', $tracker);

        self::assertAttributeEquals(true, 'disable_var_defs', $tracker);

        self::assertAttributeEquals('Tracker', 'acltype', $tracker);
        self::assertAttributeEquals('Trackers', 'acl_category', $tracker);
        self::assertAttributeEquals(true, 'disable_custom_fields', $tracker);
    }

    public function testget_recently_viewed()
    {
        $tracker = BeanFactory::newBean('Trackers');

        $result = $tracker->get_recently_viewed(1);

        self::assertInstanceOf('BreadCrumbStack', $_SESSION['breadCrumbs']);
        self::assertTrue(is_array($result));
    }

    public function testmakeInvisibleForAll()
    {
        $tracker = BeanFactory::newBean('Trackers');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $tracker->makeInvisibleForAll(1);
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testbean_implements()
    {
        $tracker = BeanFactory::newBean('Trackers');

        self::assertEquals(false, $tracker->bean_implements('')); //test with blank value
        self::assertEquals(false, $tracker->bean_implements('test')); //test with invalid value
        self::assertEquals(false, $tracker->bean_implements('ACL')); //test with valid value
    }

    public function testlogPage()
    {
        self::markTestIncomplete('Test parameters and local variables are not set');

        //test without setting headerDisplayed
        Tracker::logPage();
        self::assertEquals(null, $_SESSION['lpage']);

        //test with headerDisplayed set
        $GLOBALS['app']->headerDisplayed = 1;
        Tracker::logPage();
        self::assertEquals(time(), $_SESSION['lpage']);

        //$this->assertEquals(time(), null);
    }
}
