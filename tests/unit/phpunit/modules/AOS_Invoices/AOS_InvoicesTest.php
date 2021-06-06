<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOS_InvoicesTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAOS_Invoices(): void
    {
        // Execute the constructor and check for the Object type and  attributes
        $aosInvoices = BeanFactory::newBean('AOS_Invoices');
        self::assertInstanceOf('AOS_Invoices', $aosInvoices);
        self::assertInstanceOf('Basic', $aosInvoices);
        self::assertInstanceOf('SugarBean', $aosInvoices);

        self::assertAttributeEquals('AOS_Invoices', 'module_dir', $aosInvoices);
        self::assertAttributeEquals('AOS_Invoices', 'object_name', $aosInvoices);
        self::assertAttributeEquals('aos_invoices', 'table_name', $aosInvoices);
        self::assertAttributeEquals(true, 'new_schema', $aosInvoices);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aosInvoices);
        self::assertAttributeEquals(true, 'importable', $aosInvoices);
    }

    public function testSaveAndMark_deleted(): void
    {
        $aosInvoices = BeanFactory::newBean('AOS_Invoices');
        $aosInvoices->name = 'test';

        $aosInvoices->save();

        //test for record ID to verify that record is saved
        self::assertTrue(isset($aosInvoices->id));
        self::assertEquals(36, strlen($aosInvoices->id));
        self::assertGreaterThan(0, $aosInvoices->number);

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosInvoices->mark_deleted($aosInvoices->id);
        $result = $aosInvoices->retrieve($aosInvoices->id);
        self::assertEquals(null, $result);
    }
}
