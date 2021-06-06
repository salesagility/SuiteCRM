<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOP_Case_EventsTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOP_Case_Events(): void
    {
        // Execute the constructor and check for the Object type and type attribute
        $aopCaseEvents = BeanFactory::newBean('AOP_Case_Events');
        self::assertInstanceOf('AOP_Case_Events', $aopCaseEvents);
        self::assertInstanceOf('Basic', $aopCaseEvents);
        self::assertInstanceOf('SugarBean', $aopCaseEvents);

        self::assertAttributeEquals('AOP_Case_Events', 'module_dir', $aopCaseEvents);
        self::assertAttributeEquals('AOP_Case_Events', 'object_name', $aopCaseEvents);
        self::assertAttributeEquals('aop_case_events', 'table_name', $aopCaseEvents);
        self::assertAttributeEquals(true, 'new_schema', $aopCaseEvents);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aopCaseEvents);
        self::assertAttributeEquals(false, 'importable', $aopCaseEvents);
        self::assertAttributeEquals(false, 'tracker_visibility', $aopCaseEvents);
    }
}
