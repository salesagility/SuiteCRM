<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewClassicTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function test__construct()
    {
        // Execute the constructor and check for the Object type and type attribute

        //test with no parameters
        $view = new ViewClassic();
        $this->assertInstanceOf('ViewClassic', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('', 'type', $view);

        //test with bean parameter;
        $bean = BeanFactory::newBean('Users');
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


        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }
}
