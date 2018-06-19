<?php

class ViewClassicTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function test__construct()
    {
        

        
        $view = new ViewClassic();
        $this->assertInstanceOf('ViewClassic', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('', 'type', $view);

        
        $bean = new User();
        $view = new ViewClassic($bean);
        $this->assertInstanceOf('ViewClassic', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('', 'type', $view);
    }

    public function testdisplay()
    {
        
        if(isset($_SESSION)) {
            $session = $_SESSION;
        }
        
        $state = new SuiteCRM\StateSaver();
        
        
        

        
        $view = new ViewClassic();
        $view->module = 'Home';
        $view->action = '';
        $ret = $view->display();
        $this->assertFalse($ret);

        
        $view = new ViewClassic();
        $view->module = 'Home';
        $view->action = 'About';

        
        






        
        $this->markTestIncomplete("Warning was: Test code or tested code did not (only) close its own output buffers");

        
        $view = new ViewClassic();
        $view->module = 'Home';
        $view->action = 'index';

        ob_start();
        $ret = $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
        $this->assertTrue($ret);
        
        
        
        
        
        
        if(isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }
}
