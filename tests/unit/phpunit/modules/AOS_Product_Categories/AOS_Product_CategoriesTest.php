<?php

class AOS_Product_CategoriesTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOS_Product_Categories()
    {

        //execute the contructor and check for the Object type and  attributes
        $aosProductCategories = new AOS_Product_Categories();
        $this->assertInstanceOf('AOS_Product_Categories', $aosProductCategories);
        $this->assertInstanceOf('Basic', $aosProductCategories);
        $this->assertInstanceOf('SugarBean', $aosProductCategories);

        $this->assertAttributeEquals('AOS_Product_Categories', 'module_dir', $aosProductCategories);
        $this->assertAttributeEquals('AOS_Product_Categories', 'object_name', $aosProductCategories);
        $this->assertAttributeEquals('aos_product_categories', 'table_name', $aosProductCategories);
        $this->assertAttributeEquals(true, 'new_schema', $aosProductCategories);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosProductCategories);
        $this->assertAttributeEquals(true, 'importable', $aosProductCategories);
    }

    public function testsave()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('aod_indexevent');
        $state->pushTable('aos_product_categories');
        $state->pushTable('tracker');
        $state->pushGlobals();
        
        

        $aosProductCategories = new AOS_Product_Categories();
        $aosProductCategories->name = 'test';
        $aosProductCategories->parent_category_id = 1;

        $aosProductCategories->save();

        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aosProductCategories->id));
        $this->assertEquals(36, strlen($aosProductCategories->id));

        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosProductCategories->mark_deleted($aosProductCategories->id);
        $result = $aosProductCategories->retrieve($aosProductCategories->id);
        $this->assertEquals(null, $result);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('tracker');
        $state->popTable('aos_product_categories');
        $state->popTable('aod_indexevent');
        $state->popTable('aod_index');
    }
}
