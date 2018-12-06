<?php


class AM_ProjectTemplatesTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function testAM_ProjectTemplates()
    {

        //execute the contructor and check for the Object type and type attribute
        $am_projectTemplate = new AM_ProjectTemplates();
        $this->assertInstanceOf('AM_ProjectTemplates', $am_projectTemplate);
        $this->assertInstanceOf('Basic', $am_projectTemplate);
        $this->assertInstanceOf('SugarBean', $am_projectTemplate);

        $this->assertAttributeEquals('AM_ProjectTemplates', 'module_dir', $am_projectTemplate);
        $this->assertAttributeEquals('AM_ProjectTemplates', 'object_name', $am_projectTemplate);
        $this->assertAttributeEquals('am_projecttemplates', 'table_name', $am_projectTemplate);
        $this->assertAttributeEquals(true, 'new_schema', $am_projectTemplate);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $am_projectTemplate);
        $this->assertAttributeEquals(true, 'importable', $am_projectTemplate);
    }
}
