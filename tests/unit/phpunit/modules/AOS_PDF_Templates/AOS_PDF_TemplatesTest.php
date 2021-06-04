<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOS_PDF_TemplatesTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAOS_PDF_Templates()
    {
        // Execute the constructor and check for the Object type and  attributes
        $aosPdfTemplates = BeanFactory::newBean('AOS_PDF_Templates');
        self::assertInstanceOf('AOS_PDF_Templates', $aosPdfTemplates);
        self::assertInstanceOf('Basic', $aosPdfTemplates);
        self::assertInstanceOf('SugarBean', $aosPdfTemplates);

        self::assertAttributeEquals('AOS_PDF_Templates', 'module_dir', $aosPdfTemplates);
        self::assertAttributeEquals('AOS_PDF_Templates', 'object_name', $aosPdfTemplates);
        self::assertAttributeEquals('aos_pdf_templates', 'table_name', $aosPdfTemplates);
        self::assertAttributeEquals(true, 'new_schema', $aosPdfTemplates);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aosPdfTemplates);
        self::assertAttributeEquals(true, 'importable', $aosPdfTemplates);
    }
}
