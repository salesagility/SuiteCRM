<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AM_TaskTemplatesTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAM_TaskTemplates()
    {
        // Execute the constructor and check for the Object type and type attribute
        $am_taskTemplates = BeanFactory::newBean('AM_TaskTemplates');
        self::assertInstanceOf('AM_TaskTemplates', $am_taskTemplates);
        self::assertInstanceOf('Basic', $am_taskTemplates);
        self::assertInstanceOf('SugarBean', $am_taskTemplates);

        self::assertAttributeEquals('AM_TaskTemplates', 'module_dir', $am_taskTemplates);
        self::assertAttributeEquals('AM_TaskTemplates', 'object_name', $am_taskTemplates);
        self::assertAttributeEquals('am_tasktemplates', 'table_name', $am_taskTemplates);
        self::assertAttributeEquals(true, 'new_schema', $am_taskTemplates);
        self::assertAttributeEquals(true, 'disable_row_level_security', $am_taskTemplates);
        self::assertAttributeEquals(false, 'importable', $am_taskTemplates);
    }
}
