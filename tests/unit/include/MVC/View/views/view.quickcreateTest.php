<?php

class ViewQuickcreateTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testpreDisplay()
    {
        
        if(isset($_REQUEST)) {
            $_request = $_REQUEST;
        }

        
        $view = new ViewQuickcreate();
        $view->preDisplay();
        $this->assertEquals(0, count($_REQUEST));

        
        $_REQUEST['source_module'] = 'Users';
        $_REQUEST['module'] = 'Users';
        $_REQUEST['record'] = '';
        $request = $_REQUEST;

        $view->preDisplay();
        $this->assertSame($request, $_REQUEST);

        
        $_REQUEST['record'] = 1;
        $view->preDisplay();
        $this->assertNotSame($request, $_REQUEST);
        
        
        
        if(isset($_request)) {
            $_REQUEST = $_request;
        } else {
            unset($_REQUEST);
        }
    }

    public function testdisplay()
    {
        
        if(isset($_SESSION)) {
            $_session = $_SESSION;
        }
        
        if(isset($_REQUEST)) {
            $_request = $_REQUEST;
        }
        
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        

        
        $view = new ViewQuickcreate();

        $_REQUEST['module'] = 'Accounts';
        $view->bean = new Account();

        ob_start();

        $view->display();

        $renderedContent = ob_get_contents();
        ob_end_clean();

        $this->assertGreaterThan(0, strlen($renderedContent));
        $this->assertEquals(false, json_decode($renderedContent)); //check that it doesn't return json. 
        
        
        
        
        
        if(isset($_session)) {
            $_SESSION = $_session;
        } else {
            unset($_SESSION);
        }
        
        if(isset($_request)) {
            $_REQUEST = $_request;
        } else {
            unset($_REQUEST);
        }
    }
}
