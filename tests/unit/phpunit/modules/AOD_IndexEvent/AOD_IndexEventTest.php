<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOD_IndexEventTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOD_IndexEvent()
    {
        // Execute the constructor and check for the Object type and type attribute
        $aod_indexEvent = BeanFactory::newBean('AOD_IndexEvent');
        self::assertInstanceOf('AOD_IndexEvent', $aod_indexEvent);
        self::assertInstanceOf('Basic', $aod_indexEvent);
        self::assertInstanceOf('SugarBean', $aod_indexEvent);

        self::assertAttributeEquals('AOD_IndexEvent', 'module_dir', $aod_indexEvent);
        self::assertAttributeEquals('AOD_IndexEvent', 'object_name', $aod_indexEvent);
        self::assertAttributeEquals('aod_indexevent', 'table_name', $aod_indexEvent);
        self::assertAttributeEquals(true, 'new_schema', $aod_indexEvent);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aod_indexEvent);
        self::assertAttributeEquals(false, 'importable', $aod_indexEvent);
        self::assertAttributeEquals(false, 'tracker_visibility', $aod_indexEvent);
    }
}
