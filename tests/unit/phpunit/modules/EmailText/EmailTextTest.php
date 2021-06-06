<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class EmailTextTest extends SuitePHPUnitFrameworkTestCase
{
    public function testEmailText()
    {
        // Execute the constructor and check for the Object type and  attributes
        $emailText = BeanFactory::newBean('EmailText');

        self::assertInstanceOf('EmailText', $emailText);
        self::assertInstanceOf('SugarBean', $emailText);

        self::assertAttributeEquals('EmailText', 'module_dir', $emailText);
        self::assertAttributeEquals('EmailText', 'module_name', $emailText);
        self::assertAttributeEquals('EmailText', 'object_name', $emailText);
        self::assertAttributeEquals('emails_text', 'table_name', $emailText);

        self::assertAttributeEquals(true, 'disable_row_level_security', $emailText);
        self::assertAttributeEquals(true, 'disable_custom_fields', $emailText);
    }
}
