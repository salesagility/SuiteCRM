<?php

class AOW_ProcessedTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOW_Processed()
    {

        //execute the contructor and check for the Object type and  attributes
        $aowProcessed = new AOW_Processed();
        $this->assertInstanceOf('AOW_Processed', $aowProcessed);
        $this->assertInstanceOf('Basic', $aowProcessed);
        $this->assertInstanceOf('SugarBean', $aowProcessed);

        $this->assertAttributeEquals('AOW_Processed', 'module_dir', $aowProcessed);
        $this->assertAttributeEquals('AOW_Processed', 'object_name', $aowProcessed);
        $this->assertAttributeEquals('aow_processed', 'table_name', $aowProcessed);
        $this->assertAttributeEquals(true, 'new_schema', $aowProcessed);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aowProcessed);
        $this->assertAttributeEquals(false, 'importable', $aowProcessed);
    }

    public function testbean_implements()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        

        $aowProcessed = new AOW_Processed();
        $this->assertEquals(false, $aowProcessed->bean_implements('')); //test with blank value
        $this->assertEquals(false, $aowProcessed->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $aowProcessed->bean_implements('ACL')); //test with valid value
        
        // clean up
    }
}
