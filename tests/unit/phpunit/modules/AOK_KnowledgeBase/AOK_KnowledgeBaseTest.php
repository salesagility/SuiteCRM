<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class AOK_KnowledgeBaseTest extends SuitePHPUnitFrameworkTestCase
{
    public function testAOK_KnowledgeBase(): void
    {
        // Execute the constructor and check for the Object type and type attribute
        $aok_KnowledgeBase = BeanFactory::newBean('AOK_KnowledgeBase');
        self::assertInstanceOf('AOK_KnowledgeBase', $aok_KnowledgeBase);
        self::assertInstanceOf('Basic', $aok_KnowledgeBase);
        self::assertInstanceOf('SugarBean', $aok_KnowledgeBase);

        self::assertAttributeEquals('AOK_KnowledgeBase', 'module_dir', $aok_KnowledgeBase);
        self::assertAttributeEquals('AOK_KnowledgeBase', 'object_name', $aok_KnowledgeBase);
        self::assertAttributeEquals('aok_knowledgebase', 'table_name', $aok_KnowledgeBase);
        self::assertAttributeEquals(true, 'new_schema', $aok_KnowledgeBase);
        self::assertAttributeEquals(true, 'disable_row_level_security', $aok_KnowledgeBase);
        self::assertAttributeEquals(false, 'importable', $aok_KnowledgeBase);
    }
}
