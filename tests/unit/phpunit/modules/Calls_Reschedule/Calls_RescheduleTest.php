<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class Calls_RescheduleTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testCalls_Reschedule()
    {
        // Execute the constructor and check for the Object type and  attributes
        $callsReschedule = BeanFactory::newBean('Calls_Reschedule');
        self::assertInstanceOf('Calls_Reschedule', $callsReschedule);
        self::assertInstanceOf('Basic', $callsReschedule);
        self::assertInstanceOf('SugarBean', $callsReschedule);

        self::assertAttributeEquals('Calls_Reschedule', 'module_dir', $callsReschedule);
        self::assertAttributeEquals('Calls_Reschedule', 'object_name', $callsReschedule);
        self::assertAttributeEquals('calls_reschedule', 'table_name', $callsReschedule);
        self::assertAttributeEquals(true, 'new_schema', $callsReschedule);
        self::assertAttributeEquals(true, 'disable_row_level_security', $callsReschedule);
        self::assertAttributeEquals(true, 'importable', $callsReschedule);
        self::assertAttributeEquals(false, 'tracker_visibility', $callsReschedule);
    }
}
