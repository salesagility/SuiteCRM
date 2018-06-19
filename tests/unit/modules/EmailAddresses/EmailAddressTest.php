<?php


class EmailAddressTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testEmailAddress()
    {
        
        $email = new EmailAddress();
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
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('email_addresses');
        $state->pushTable('tracker');
        $state->pushTable('aod_index');
        
        
        
        $email = new EmailAddress();

        $email->email_address = 'test@test.com';
        $email->invaid_email = 0;

        $email->save();

        
        $this->assertTrue(isset($email->id));
        $this->assertEquals(36, strlen($email->id));

        
        $email->mark_deleted($email->id);
        $result = $email->retrieve($email->id);
        $this->assertEquals(null, $result);

        
        
        $state->popTable('aod_index');
        $state->popTable('tracker');
        $state->popTable('email_addresses');
    }
}
