<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class OpportunityTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testOpportunity()
    {
        // Execute the constructor and check for the Object type and  attributes
        $opportunity = BeanFactory::newBean('Opportunities');

        $this->assertInstanceOf('Opportunity', $opportunity);
        $this->assertInstanceOf('SugarBean', $opportunity);

        $this->assertAttributeEquals('opportunities', 'table_name', $opportunity);
        $this->assertAttributeEquals('accounts_opportunities', 'rel_account_table', $opportunity);
        $this->assertAttributeEquals('opportunities_contacts', 'rel_contact_table', $opportunity);
        $this->assertAttributeEquals('Opportunities', 'module_dir', $opportunity);
        $this->assertAttributeEquals('Opportunity', 'object_name', $opportunity);

        $this->assertAttributeEquals(true, 'new_schema', $opportunity);
        $this->assertAttributeEquals(true, 'importable', $opportunity);
    }

    public function testget_summary_text()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        //test without setting name
        $this->assertEquals(null, $opportunity->get_summary_text());

        //test with name set
        $opportunity->name = 'test';
        $this->assertEquals('test', $opportunity->get_summary_text());
    }

    public function testcreate_list_query()
    {
        $this->markTestIncomplete('Breaks on php 7.1');
        $opportunity = BeanFactory::newBean('Opportunities');

        //test with empty string params
        $expected = "SELECT \n                            accounts.id as account_id,\n                            accounts.name as account_name,\n                            accounts.assigned_user_id account_id_owner,\n                            users.user_name as assigned_user_name ,opportunities_cstm.* ,opportunities.*\n                            FROM opportunities LEFT JOIN users\n                            ON opportunities.assigned_user_id=users.id LEFT JOIN accounts_opportunities\n                            ON opportunities.id=accounts_opportunities.opportunity_id\n                            LEFT JOIN accounts\n                            ON accounts_opportunities.account_id=accounts.id  LEFT JOIN opportunities_cstm ON opportunities.id = opportunities_cstm.id_c where \n			(accounts_opportunities.deleted is null OR accounts_opportunities.deleted=0)\n			AND (accounts.deleted is null OR accounts.deleted=0)\n			AND opportunities.deleted=0 ORDER BY opportunities.name";
        $actual = $opportunity->create_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = "SELECT \n                            accounts.id as account_id,\n                            accounts.name as account_name,\n                            accounts.assigned_user_id account_id_owner,\n                            users.user_name as assigned_user_name ,opportunities_cstm.* ,opportunities.*\n                            FROM opportunities LEFT JOIN users\n                            ON opportunities.assigned_user_id=users.id LEFT JOIN accounts_opportunities\n                            ON opportunities.id=accounts_opportunities.opportunity_id\n                            LEFT JOIN accounts\n                            ON accounts_opportunities.account_id=accounts.id  LEFT JOIN opportunities_cstm ON opportunities.id = opportunities_cstm.id_c where (accounts.name=\"\") AND \n			(accounts_opportunities.deleted is null OR accounts_opportunities.deleted=0)\n			AND (accounts.deleted is null OR accounts.deleted=0)\n			AND opportunities.deleted=0 ORDER BY accounts.id";
        $actual = $opportunity->create_list_query('accounts.id', 'accounts.name=""');
        $this->assertSame($expected, $actual);
    }

    public function testcreate_export_query()
    {
        $this->markTestIncomplete('Breaks on php 7.1');
        $opportunity = BeanFactory::newBean('Opportunities');

        //test with empty string params
        $expected = "SELECT \n                            accounts.id as account_id,\n                            accounts.name as account_name,\n                            accounts.assigned_user_id account_id_owner,\n                            users.user_name as assigned_user_name ,opportunities_cstm.* ,opportunities.*\n                            FROM opportunities LEFT JOIN users\n                            ON opportunities.assigned_user_id=users.id LEFT JOIN accounts_opportunities\n                            ON opportunities.id=accounts_opportunities.opportunity_id\n                            LEFT JOIN accounts\n                            ON accounts_opportunities.account_id=accounts.id  LEFT JOIN opportunities_cstm ON opportunities.id = opportunities_cstm.id_c where \n			(accounts_opportunities.deleted is null OR accounts_opportunities.deleted=0)\n			AND (accounts.deleted is null OR accounts.deleted=0)\n			AND opportunities.deleted=0 ORDER BY opportunities.name";
        $actual = $opportunity->create_list_query('', '');
        $this->assertSame($expected, $actual);

        //test with valid string params
        $expected = "SELECT \n                            accounts.id as account_id,\n                            accounts.name as account_name,\n                            accounts.assigned_user_id account_id_owner,\n                            users.user_name as assigned_user_name ,opportunities_cstm.* ,opportunities.*\n                            FROM opportunities LEFT JOIN users\n                            ON opportunities.assigned_user_id=users.id LEFT JOIN accounts_opportunities\n                            ON opportunities.id=accounts_opportunities.opportunity_id\n                            LEFT JOIN accounts\n                            ON accounts_opportunities.account_id=accounts.id  LEFT JOIN opportunities_cstm ON opportunities.id = opportunities_cstm.id_c where (accounts.name=\"\") AND \n			(accounts_opportunities.deleted is null OR accounts_opportunities.deleted=0)\n			AND (accounts.deleted is null OR accounts.deleted=0)\n			AND opportunities.deleted=0 ORDER BY accounts.id";
        $actual = $opportunity->create_list_query('accounts.id', 'accounts.name=""');
        $this->assertSame($expected, $actual);
    }

    public function testfill_in_additional_list_fields()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            //test without force_load_details
            $opportunity->fill_in_additional_list_fields();

            //test without force_load_details
            $opportunity->force_load_details = true;
            $opportunity->fill_in_additional_list_fields();

            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testfill_in_additional_detail_fields()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $opportunity->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testget_contacts()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        $result = $opportunity->get_contacts();
        $this->assertTrue(is_array($result));
    }

    public function testupdate_currency_id()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $opportunity->update_currency_id(array('GBP', 'EUR'), 'USD');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testget_list_view_data()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        $opportunity->name = 'test';

        $expected = array(
                'NAME' => 'test',
                'DELETED' => 0,
                'SALES_STAGE' => '',
                'ENCODED_NAME' => 'test',
                );

        $actual = $opportunity->get_list_view_data();
        //$this->assertSame($expected, $actual);
        $this->assertEquals($expected['NAME'], $actual['NAME']);
        $this->assertEquals($expected['DELETED'], $actual['DELETED']);
        $this->assertEquals($expected['SALES_STAGE'], $actual['SALES_STAGE']);
        $this->assertEquals($expected['ENCODED_NAME'], $actual['ENCODED_NAME']);
    }

    public function testget_currency_symbol()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        //te4st without currency id
        $this->assertEquals('', $opportunity->get_currency_symbol());

        //test with invalid currency id
        $opportunity->currency_id = 1;
        $this->assertEquals('', $opportunity->get_currency_symbol());
    }

    public function testbuild_generic_where_clause()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        //test with empty string params
        $expected = "opportunities.name like '%' or accounts.name like '%'";
        $actual = $opportunity->build_generic_where_clause('');
        $this->assertSame($expected, $actual);
    }

    public function testsave()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        $opportunity->name = 'test';
        $opportunity->description = 'test description';
        $opportunity->sales_stage = 'Value Proposition';

        $result = $opportunity->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($opportunity->id));
        $this->assertEquals(36, strlen($opportunity->id));
        $this->assertEquals(-99, $opportunity->currency_id);
        $this->assertEquals(30, $opportunity->probability);

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $opportunity->mark_deleted($opportunity->id);
        $result = $opportunity->retrieve($opportunity->id);
        $this->assertEquals(null, $result);
    }

    public function testsave_relationship_changes()
    {
        $opportunity = BeanFactory::newBean('Opportunities');
        $opportunity->account_id = 1;

        try {
            $opportunity->save_relationship_changes(true);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testset_opportunity_contact_relationship()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        try {
            $opportunity->set_opportunity_contact_relationship('1');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testset_notification_body()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        //test with attributes preset and verify template variables are set accordingly

        $opportunity->name = 'test';
        $opportunity->amount = '100';
        $opportunity->date_closed = '2015-02-11 17:30:00';
        $opportunity->description = 'tes description';
        $opportunity->sales_stage = 'Value Proposition';

        $result = $opportunity->set_notification_body(new Sugar_Smarty(), $opportunity);

        $this->assertEquals($opportunity->name, $result->_tpl_vars['OPPORTUNITY_NAME']);
        $this->assertEquals($opportunity->amount, $result->_tpl_vars['OPPORTUNITY_AMOUNT']);
        $this->assertEquals($opportunity->date_closed, $result->_tpl_vars['OPPORTUNITY_CLOSEDATE']);
        $this->assertEquals($opportunity->sales_stage, $result->_tpl_vars['OPPORTUNITY_STAGE']);
        $this->assertEquals($opportunity->description, $result->_tpl_vars['OPPORTUNITY_DESCRIPTION']);
    }

    public function testbean_implements()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        $this->assertEquals(false, $opportunity->bean_implements('')); //test with blank value
        $this->assertEquals(false, $opportunity->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $opportunity->bean_implements('ACL')); //test with valid value
    }

    public function testlistviewACLHelper()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        $expected = array('MAIN' => 'a', 'ACCOUNT' => 'a');
        $actual = $opportunity->listviewACLHelper();
        $this->assertSame($expected, $actual);
    }

    public function testget_account_detail()
    {
        $opportunity = BeanFactory::newBean('Opportunities');

        $result = $opportunity->get_account_detail('1');
        $this->assertTrue(is_array($result));
    }

    public function testgetCurrencyType()
    {
        // Execute the method and test that it works and doesn't throw an exception.
        try {
            getCurrencyType();
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->markTestIncomplete('This method has no implementation');
    }
}
