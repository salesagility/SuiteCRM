<?php

class FP_eventsTest extends SuiteCRM\Test\SuitePHPUnitFrameworkTestCase
{
    public function testFP_events()
    {
        // Execute the constructor and check for the Object type and  attributes
        $fpEvents = BeanFactory::newBean('FP_events');
        $this->assertInstanceOf('FP_events', $fpEvents);
        $this->assertInstanceOf('Basic', $fpEvents);
        $this->assertInstanceOf('SugarBean', $fpEvents);

        $this->assertAttributeEquals('FP_events', 'module_dir', $fpEvents);
        $this->assertAttributeEquals('FP_events', 'object_name', $fpEvents);
        $this->assertAttributeEquals('fp_events', 'table_name', $fpEvents);
        $this->assertAttributeEquals(true, 'new_schema', $fpEvents);
        $this->assertAttributeEquals(true, 'importable', $fpEvents);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $fpEvents);
    }

    public function testemail_templates()
    {
        global $app_list_strings;

        $fpEvents = BeanFactory::newBean('FP_events');

        $fpEvents->email_templates();
        $this->assertInternalType('array', $app_list_strings['emailTemplates_type_list']);
    }
}
