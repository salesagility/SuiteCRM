<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOS_QuotesTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAOS_Quotes(): void
    {
        // Execute the constructor and check for the Object type and  attributes
        $aosQuotes = BeanFactory::newBean('AOS_Quotes');
        self::assertInstanceOf('AOS_Quotes', $aosQuotes);
        self::assertInstanceOf('Basic', $aosQuotes);
        self::assertInstanceOf('SugarBean', $aosQuotes);

        self::assertAttributeEquals('AOS_Quotes', 'module_dir', $aosQuotes);
        self::assertAttributeEquals('AOS_Quotes', 'object_name', $aosQuotes);
        self::assertAttributeEquals('aos_quotes', 'table_name', $aosQuotes);
        self::assertAttributeEquals(true, 'new_schema', $aosQuotes);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aosQuotes);
        self::assertAttributeEquals(true, 'importable', $aosQuotes);
        self::assertAttributeEquals(true, 'lineItems', $aosQuotes);
    }

    public function testSaveAndMark_deleted(): void
    {
        $aosQuotes = BeanFactory::newBean('AOS_Quotes');

        $aosQuotes->name = 'test';
        $aosQuotes->total_amt = 100;
        $aosQuotes->total_amt_usdollar = 100;

        $aosQuotes->save();

        //test for record ID to verify that record is saved
        self::assertTrue(isset($aosQuotes->id));
        self::assertEquals(36, strlen($aosQuotes->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosQuotes->mark_deleted($aosQuotes->id);
        $result = $aosQuotes->retrieve($aosQuotes->id);
        self::assertEquals(null, $result);
    }
}
