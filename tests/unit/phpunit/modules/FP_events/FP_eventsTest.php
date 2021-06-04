<?php

class FP_eventsTest extends SuiteCRM\Test\SuitePHPUnitFrameworkTestCase
{
    public function testFP_events()
    {
        // Execute the constructor and check for the Object type and  attributes
        $fpEvents = BeanFactory::newBean('FP_events');
        self::assertInstanceOf('FP_events', $fpEvents);
        self::assertInstanceOf('Basic', $fpEvents);
        self::assertInstanceOf('SugarBean', $fpEvents);

        self::assertAttributeEquals('FP_events', 'module_dir', $fpEvents);
        self::assertAttributeEquals('FP_events', 'object_name', $fpEvents);
        self::assertAttributeEquals('fp_events', 'table_name', $fpEvents);
        self::assertAttributeEquals(true, 'new_schema', $fpEvents);
        self::assertAttributeEquals(true, 'importable', $fpEvents);
        self::assertAttributeEquals(true, 'disable_row_level_security', $fpEvents);
    }

    public function testemail_templates()
    {
        global $app_list_strings;

        $fpEvents = BeanFactory::newBean('FP_events');

        $fpEvents->email_templates();
        self::assertInternalType('array', $app_list_strings['emailTemplates_type_list']);
    }
}
