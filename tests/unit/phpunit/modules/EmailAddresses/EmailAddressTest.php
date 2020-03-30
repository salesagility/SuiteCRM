<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class EmailAddressTest extends SuitePHPUnitFrameworkTestCase
{
    public function testEmailAddress()
    {
        // Execute the constructor and check for the Object type and  attributes
        $email = BeanFactory::newBean('EmailAddresses');
        $this->assertInstanceOf('EmailAddress', $email);
        $this->assertInstanceOf('SugarEmailAddress', $email);
        $this->assertInstanceOf('SugarBean', $email);

        $this->assertAttributeEquals('EmailAddresses', 'module_dir', $email);
        $this->assertAttributeEquals('EmailAddresses', 'module_name', $email);
        $this->assertAttributeEquals('EmailAddress', 'object_name', $email);
        $this->assertAttributeEquals('email_addresses', 'table_name', $email);

        $this->assertAttributeEquals(true, 'disable_row_level_security', $email);
    }

    public function testsave()
    {
        $email = BeanFactory::newBean('EmailAddresses');

        $email->email_address = 'test@test.com';
        $email->invaid_email = 0;

        $email->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($email->id));
        $this->assertEquals(36, strlen($email->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $email->mark_deleted($email->id);
        $result = $email->retrieve($email->id);
        $this->assertEquals(null, $result);
    }
}
