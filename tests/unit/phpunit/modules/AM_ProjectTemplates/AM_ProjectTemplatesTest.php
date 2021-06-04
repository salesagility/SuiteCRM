<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AM_ProjectTemplatesTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAM_ProjectTemplates()
    {
        // Execute the constructor and check for the Object type and type attribute
        $am_projectTemplate = BeanFactory::newBean('AM_ProjectTemplates');
        self::assertInstanceOf('AM_ProjectTemplates', $am_projectTemplate);
        self::assertInstanceOf('Basic', $am_projectTemplate);
        self::assertInstanceOf('SugarBean', $am_projectTemplate);

        self::assertAttributeEquals('AM_ProjectTemplates', 'module_dir', $am_projectTemplate);
        self::assertAttributeEquals('AM_ProjectTemplates', 'object_name', $am_projectTemplate);
        self::assertAttributeEquals('am_projecttemplates', 'table_name', $am_projectTemplate);
        self::assertAttributeEquals(true, 'new_schema', $am_projectTemplate);
        self::assertAttributeEquals(true, 'disable_row_level_security', $am_projectTemplate);
        self::assertAttributeEquals(true, 'importable', $am_projectTemplate);
    }
}
