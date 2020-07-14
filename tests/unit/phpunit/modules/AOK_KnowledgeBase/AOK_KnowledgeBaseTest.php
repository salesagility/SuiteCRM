<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOK_KnowledgeBaseTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOK_KnowledgeBase()
    {
        // Execute the constructor and check for the Object type and type attribute
        $aok_KnowledgeBase = BeanFactory::newBean('AOK_KnowledgeBase');
        $this->assertInstanceOf('AOK_KnowledgeBase', $aok_KnowledgeBase);
        $this->assertInstanceOf('Basic', $aok_KnowledgeBase);
        $this->assertInstanceOf('SugarBean', $aok_KnowledgeBase);

        $this->assertAttributeEquals('AOK_KnowledgeBase', 'module_dir', $aok_KnowledgeBase);
        $this->assertAttributeEquals('AOK_KnowledgeBase', 'object_name', $aok_KnowledgeBase);
        $this->assertAttributeEquals('aok_knowledgebase', 'table_name', $aok_KnowledgeBase);
        $this->assertAttributeEquals(true, 'new_schema', $aok_KnowledgeBase);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aok_KnowledgeBase);
        $this->assertAttributeEquals(false, 'importable', $aok_KnowledgeBase);
    }
}
