<?php

class AOS_PDF_TemplatesTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOS_PDF_Templates()
    {

        //execute the contructor and check for the Object type and  attributes
        $aosPdfTemplates = new AOS_PDF_Templates();
        $this->assertInstanceOf('AOS_PDF_Templates', $aosPdfTemplates);
        $this->assertInstanceOf('Basic', $aosPdfTemplates);
        $this->assertInstanceOf('SugarBean', $aosPdfTemplates);

        $this->assertAttributeEquals('AOS_PDF_Templates', 'module_dir', $aosPdfTemplates);
        $this->assertAttributeEquals('AOS_PDF_Templates', 'object_name', $aosPdfTemplates);
        $this->assertAttributeEquals('aos_pdf_templates', 'table_name', $aosPdfTemplates);
        $this->assertAttributeEquals(true, 'new_schema', $aosPdfTemplates);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosPdfTemplates);
        $this->assertAttributeEquals(true, 'importable', $aosPdfTemplates);
    }
}
