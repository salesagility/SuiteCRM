<?php

include_once __DIR__ . '/../../../../../include/database/MysqliManager.php';

use SuiteCRM\Test\SuitePHPUnit_Framework_TestCase;

class MysqliManagerTest extends SuitePHPUnit_Framework_TestCase
{

    /**
     * issue #7616
     * Verify that repairTableParams() method creates a FOREIGN KEY
     */
    public function testAddForeignKey()
    {
        $campaign_id_fk = [
            'name' => 'campaign_id',
            'type' => 'foreign',
            'foreignTable' => 'campaigns',
            'foreignField' => 'id',
            'reference_option' => [
                'on' => 'DELETE',
                'option' => 'CASCADE',
            ],
            'fields' => ['campaign_id'],
        ];
        $bean = BeanFactory::getBean('Opportunities');
        $mysql = new MysqliManager();
        $indices = $bean->getIndices();
        $indices[] = $campaign_id_fk;
        $fielddefs = $bean->getFieldDefinitions();
        $tablename = $bean->getTableName();
        $sql = $mysql->repairTableParams($tablename, $fielddefs, $indices, false, null);
        $this->assertContains('ADD CONSTRAINT campaign_id FOREIGN KEY campaign_id', $sql);
    }
}
