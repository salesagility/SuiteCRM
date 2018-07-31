<?PHP

class FP_eventsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testFP_events()
    {

        //execute the contructor and check for the Object type and  attributes
        $fpEvents = new FP_events();
        $this->assertInstanceOf('FP_events', $fpEvents);
        $this->assertInstanceOf('Basic', $fpEvents);
        $this->assertInstanceOf('SugarBean', $fpEvents);

        $this->assertAttributeEquals('FP_events', 'module_dir', $fpEvents);
        $this->assertAttributeEquals('FP_events', 'object_name', $fpEvents);
        $this->assertAttributeEquals('fp_events', 'table_name', $fpEvents);
        $this->assertAttributeEquals(true, 'new_schema', $fpEvents);
        $this->assertAttributeEquals(true, 'importable', $fpEvents);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $fpEvents);
    }

    public function testemail_templates()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushGlobals();
        
        //error_reporting(E_ERROR | E_PARSE);

        global $app_list_strings;

        $fpEvents = new FP_events();

        $fpEvents->email_templates();
        $this->assertTrue(is_array($app_list_strings['email_templet_list']));
        
        // clean up
        
        $state->popGlobals();
        
    }
}
