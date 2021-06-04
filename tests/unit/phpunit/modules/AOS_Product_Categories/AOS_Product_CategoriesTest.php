<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOS_Product_CategoriesTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testAOS_Product_Categories()
    {
        // Execute the constructor and check for the Object type and  attributes
        $aosProductCategories = BeanFactory::newBean('AOS_Product_Categories');
        self::assertInstanceOf('AOS_Product_Categories', $aosProductCategories);
        self::assertInstanceOf('Basic', $aosProductCategories);
        self::assertInstanceOf('SugarBean', $aosProductCategories);

        self::assertAttributeEquals('AOS_Product_Categories', 'module_dir', $aosProductCategories);
        self::assertAttributeEquals('AOS_Product_Categories', 'object_name', $aosProductCategories);
        self::assertAttributeEquals('aos_product_categories', 'table_name', $aosProductCategories);
        self::assertAttributeEquals(true, 'new_schema', $aosProductCategories);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aosProductCategories);
        self::assertAttributeEquals(true, 'importable', $aosProductCategories);
    }

    public function testsave()
    {
        $aosProductCategories = BeanFactory::newBean('AOS_Product_Categories');
        $aosProductCategories->name = 'test';
        $aosProductCategories->parent_category_id = 1;

        $aosProductCategories->save();

        //test for record ID to verify that record is saved
        self::assertTrue(isset($aosProductCategories->id));
        self::assertEquals(36, strlen($aosProductCategories->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosProductCategories->mark_deleted($aosProductCategories->id);
        $result = $aosProductCategories->retrieve($aosProductCategories->id);
        self::assertEquals(null, $result);
    }
}
