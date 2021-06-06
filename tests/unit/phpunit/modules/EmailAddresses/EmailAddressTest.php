<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class EmailAddressTest extends SuitePHPUnitFrameworkTestCase
{
    public function testEmailAddress(): void
    {
        // Execute the constructor and check for the Object type and  attributes
        $email = BeanFactory::newBean('EmailAddresses');
        self::assertInstanceOf('EmailAddress', $email);
        self::assertInstanceOf('SugarEmailAddress', $email);
        self::assertInstanceOf('SugarBean', $email);

        self::assertAttributeEquals('EmailAddresses', 'module_dir', $email);
        self::assertAttributeEquals('EmailAddresses', 'module_name', $email);
        self::assertAttributeEquals('EmailAddress', 'object_name', $email);
        self::assertAttributeEquals('email_addresses', 'table_name', $email);

        self::assertAttributeEquals(true, 'disable_row_level_security', $email);
    }

    public function testsave(): void
    {
        $email = BeanFactory::newBean('EmailAddresses');

        $email->email_address = 'test@test.com';
        $email->invaid_email = 0;

        $email->save();

        //test for record ID to verify that record is saved
        self::assertTrue(isset($email->id));
        self::assertEquals(36, strlen($email->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $email->mark_deleted($email->id);
        $result = $email->retrieve($email->id);
        self::assertEquals(null, $result);
    }
}
