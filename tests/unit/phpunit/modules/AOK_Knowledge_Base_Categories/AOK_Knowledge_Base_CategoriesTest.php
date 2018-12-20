<?php

class AOK_Knowledge_Base_CategoriesTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testAOK_Knowledge_Base_Categories()
    {

        //execute the contructor and check for the Object type and type attribute
        $aok_KBCategories = new AOK_Knowledge_Base_Categories();
        $this->assertInstanceOf('AOK_Knowledge_Base_Categories', $aok_KBCategories);
        $this->assertInstanceOf('Basic', $aok_KBCategories);
        $this->assertInstanceOf('SugarBean', $aok_KBCategories);

        $this->assertAttributeEquals('AOK_Knowledge_Base_Categories', 'module_dir', $aok_KBCategories);
        $this->assertAttributeEquals('AOK_Knowledge_Base_Categories', 'object_name', $aok_KBCategories);
        $this->assertAttributeEquals('aok_knowledge_base_categories', 'table_name', $aok_KBCategories);
        $this->assertAttributeEquals(true, 'new_schema', $aok_KBCategories);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aok_KBCategories);
        $this->assertAttributeEquals(false, 'importable', $aok_KBCategories);
    }
}
