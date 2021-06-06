<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOW_ProcessedTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAOW_Processed()
    {
        // Execute the constructor and check for the Object type and  attributes
        $aowProcessed = BeanFactory::newBean('AOW_Processed');
        self::assertInstanceOf('AOW_Processed', $aowProcessed);
        self::assertInstanceOf('Basic', $aowProcessed);
        self::assertInstanceOf('SugarBean', $aowProcessed);

        self::assertAttributeEquals('AOW_Processed', 'module_dir', $aowProcessed);
        self::assertAttributeEquals('AOW_Processed', 'object_name', $aowProcessed);
        self::assertAttributeEquals('aow_processed', 'table_name', $aowProcessed);
        self::assertAttributeEquals(true, 'new_schema', $aowProcessed);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aowProcessed);
        self::assertAttributeEquals(false, 'importable', $aowProcessed);
    }

    public function testbean_implements()
    {
        $aowProcessed = BeanFactory::newBean('AOW_Processed');
        self::assertEquals(false, $aowProcessed->bean_implements('')); //test with blank value
        self::assertEquals(false, $aowProcessed->bean_implements('test')); //test with invalid value
        self::assertEquals(true, $aowProcessed->bean_implements('ACL')); //test with valid value
    }
}
