<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class FP_Event_LocationsTest extends SuitePHPUnitFrameworkTestCase
{
    public function testFP_Event_Locations(): void
    {
        // Execute the constructor and check for the Object type and  attributes
        $fpEventLoc = BeanFactory::newBean('FP_Event_Locations');
        self::assertInstanceOf('FP_Event_Locations', $fpEventLoc);
        self::assertInstanceOf('Basic', $fpEventLoc);
        self::assertInstanceOf('SugarBean', $fpEventLoc);

        self::assertAttributeEquals('FP_Event_Locations', 'module_dir', $fpEventLoc);
        self::assertAttributeEquals('FP_Event_Locations', 'object_name', $fpEventLoc);
        self::assertAttributeEquals('fp_event_locations', 'table_name', $fpEventLoc);
        self::assertAttributeEquals(true, 'new_schema', $fpEventLoc);
        self::assertAttributeEquals(false, 'importable', $fpEventLoc);
        self::assertAttributeEquals(true, 'disable_row_level_security', $fpEventLoc);
    }
}
