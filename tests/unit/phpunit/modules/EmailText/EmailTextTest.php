<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class EmailTextTest extends SuitePHPUnitFrameworkTestCase
{
    public function testEmailText()
    {
        // Execute the constructor and check for the Object type and  attributes
        $emailText = BeanFactory::newBean('EmailText');

        $this->assertInstanceOf('EmailText', $emailText);
        $this->assertInstanceOf('SugarBean', $emailText);

        $this->assertAttributeEquals('EmailText', 'module_dir', $emailText);
        $this->assertAttributeEquals('EmailText', 'module_name', $emailText);
        $this->assertAttributeEquals('EmailText', 'object_name', $emailText);
        $this->assertAttributeEquals('emails_text', 'table_name', $emailText);

        $this->assertAttributeEquals(true, 'disable_row_level_security', $emailText);
        $this->assertAttributeEquals(true, 'disable_custom_fields', $emailText);
    }
}
