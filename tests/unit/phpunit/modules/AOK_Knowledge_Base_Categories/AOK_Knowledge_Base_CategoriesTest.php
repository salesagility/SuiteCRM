<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOK_Knowledge_Base_CategoriesTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOK_Knowledge_Base_Categories()
    {
        // Execute the constructor and check for the Object type and type attribute
        $aok_KBCategories = BeanFactory::newBean('AOK_Knowledge_Base_Categories');
        self::assertInstanceOf('AOK_Knowledge_Base_Categories', $aok_KBCategories);
        self::assertInstanceOf('Basic', $aok_KBCategories);
        self::assertInstanceOf('SugarBean', $aok_KBCategories);

        self::assertAttributeEquals('AOK_Knowledge_Base_Categories', 'module_dir', $aok_KBCategories);
        self::assertAttributeEquals('AOK_Knowledge_Base_Categories', 'object_name', $aok_KBCategories);
        self::assertAttributeEquals('aok_knowledge_base_categories', 'table_name', $aok_KBCategories);
        self::assertAttributeEquals(true, 'new_schema', $aok_KBCategories);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aok_KBCategories);
        self::assertAttributeEquals(false, 'importable', $aok_KBCategories);
    }
}
