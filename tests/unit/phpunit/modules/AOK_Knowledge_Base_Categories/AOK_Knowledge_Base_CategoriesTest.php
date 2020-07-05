<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOK_Knowledge_Base_CategoriesTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOK_Knowledge_Base_Categories()
    {
        // Execute the constructor and check for the Object type and type attribute
        $aok_KBCategories = BeanFactory::newBean('AOK_Knowledge_Base_Categories');
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
