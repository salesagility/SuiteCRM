<?php

class EmailTextTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function testEmailText()
    {

        //execute the contructor and check for the Object type and  attributes
        $emailText = new EmailText();

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
