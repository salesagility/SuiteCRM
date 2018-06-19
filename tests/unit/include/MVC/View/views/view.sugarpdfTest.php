<?php


class ViewSugarpdfTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testViewSugarpdf()
    {
        
        if(isset($_REQUEST)) {
            $_request = $_REQUEST;
        }
        
        

         
         try {
             $view = new ViewSugarpdf();
             $this->assertEmpty("", $view);
         } catch (Exception $e) {
             $msg = $e->getMessage();
             $this->assertStringStartsWith('Cannot modify header information', $msg, 'Cannot modify header information? : ' . $msg . "\nTrace\n" . $e->getTraceAsString());
         }


         
         $_REQUEST['sugarpdf'] = 'someValue';
        $view = new ViewSugarpdf();
        $view->module = 'Users';
        $this->assertInstanceOf('ViewSugarpdf', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('sugarpdf', 'type', $view);
        $this->assertAttributeEquals('someValue', 'sugarpdf', $view);
        $this->assertAttributeEquals(null, 'sugarpdfBean', $view);

        
        
        if(isset($_request)) {
            $_REQUEST = $_request;
        } else {
            unset($_REQUEST);
        }
    }

    
    public function testpreDisplay()
    {
        $this->markTestIncomplete('Can Not be implemented');
    }

    
    public function testdisplay()
    {
        $this->markTestIncomplete('Can Not be implemented');
    }
}
