<?php

class ViewClassicTest extends SuiteCRM\StateCheckerUnitAbstract
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
        //execute the contructor and check for the Object type and type attribute

        //test with no paramerters
        $view = new ViewClassic();
        $this->assertInstanceOf('ViewClassic', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('', 'type', $view);

        //test with bean parameter;
        $bean = new User();
        $view = new ViewClassic($bean);
        $this->assertInstanceOf('ViewClassic', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('', 'type', $view);
    }

    public function testdisplay()
    {
        if (isset($_SESSION)) {
            $session = $_SESSION;
        }
        
        $state = new SuiteCRM\StateSaver();
        
        
        ////error_reporting(E_ERROR | E_PARSE);

        //test with a valid module but invalid action. it should return false.
        $view = new ViewClassic();
        $view->module = 'Home';
        $view->action = '';
        $ret = $view->display();
        $this->assertFalse($ret);

        //test with a valid module and uncustomized action. it should return true
        $view = new ViewClassic();
        $view->module = 'Home';
        $view->action = 'About';

        
        // folowing code says: "Test code or tested code did not (only) close its own output buffers"
//        ob_start();
//        $ret = $view->display();
//        $renderedContent = ob_get_contents();
//        ob_end_clean();
//        $this->assertEquals(0, strlen($renderedContent), 'Renderered Content was: ' . $renderedContent);
//        $this->assertTrue($ret);
        
        $this->markTestIncomplete("Warning was: Test code or tested code did not (only) close its own output buffers");

        //test with a valid module and customized action. it should return true
        $view = new ViewClassic();
        $view->module = 'Home';
        $view->action = 'index';

        ob_start();
        $ret = $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
        $this->assertTrue($ret);
        
        
        // clean up
        
        
        
        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }
}
