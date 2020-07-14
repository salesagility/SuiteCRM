<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AM_TaskTemplatesTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAM_TaskTemplates()
    {
        // Execute the constructor and check for the Object type and type attribute
        $am_taskTemplates = BeanFactory::newBean('AM_TaskTemplates');
        $this->assertInstanceOf('AM_TaskTemplates', $am_taskTemplates);
        $this->assertInstanceOf('Basic', $am_taskTemplates);
        $this->assertInstanceOf('SugarBean', $am_taskTemplates);

        $this->assertAttributeEquals('AM_TaskTemplates', 'module_dir', $am_taskTemplates);
        $this->assertAttributeEquals('AM_TaskTemplates', 'object_name', $am_taskTemplates);
        $this->assertAttributeEquals('am_tasktemplates', 'table_name', $am_taskTemplates);
        $this->assertAttributeEquals(true, 'new_schema', $am_taskTemplates);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $am_taskTemplates);
        $this->assertAttributeEquals(false, 'importable', $am_taskTemplates);
    }
}
