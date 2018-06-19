<?php

class AOS_QuotesTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testAOS_Quotes()
    {

        
        $aosQuotes = new AOS_Quotes();
        $this->assertInstanceOf('AOS_Quotes', $aosQuotes);
        $this->assertInstanceOf('Basic', $aosQuotes);
        $this->assertInstanceOf('SugarBean', $aosQuotes);

        $this->assertAttributeEquals('AOS_Quotes', 'module_dir', $aosQuotes);
        $this->assertAttributeEquals('AOS_Quotes', 'object_name', $aosQuotes);
        $this->assertAttributeEquals('aos_quotes', 'table_name', $aosQuotes);
        $this->assertAttributeEquals(true, 'new_schema', $aosQuotes);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosQuotes);
        $this->assertAttributeEquals(true, 'importable', $aosQuotes);
        $this->assertAttributeEquals(true, 'lineItems', $aosQuotes);
    }

    public function testSaveAndMark_deleted()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('aos_quotes');
        
        

        $aosQuotes = new AOS_Quotes();

        $aosQuotes->name = 'test';
        $aosQuotes->total_amt = 100;
        $aosQuotes->total_amt_usdollar = 100;

        $aosQuotes->save();

        
        $this->assertTrue(isset($aosQuotes->id));
        $this->assertEquals(36, strlen($aosQuotes->id));

        
        $aosQuotes->mark_deleted($aosQuotes->id);
        $result = $aosQuotes->retrieve($aosQuotes->id);
        $this->assertEquals(null, $result);
        
        
        
        $state->popTable('aos_quotes');
        
    }
}
