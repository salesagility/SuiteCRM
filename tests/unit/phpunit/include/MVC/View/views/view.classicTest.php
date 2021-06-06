<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewClassicTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function test__construct(): void
    {
        // Execute the constructor and check for the Object type and type attribute

        //test with no parameters
        $view = new ViewClassic();
        self::assertInstanceOf('ViewClassic', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertAttributeEquals('', 'type', $view);

        //test with bean parameter;
        $bean = BeanFactory::newBean('Users');
        $view = new ViewClassic($bean);
        self::assertInstanceOf('ViewClassic', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertAttributeEquals('', 'type', $view);
    }

    public function testdisplay(): void
    {
        if (isset($_SESSION)) {
            $session = $_SESSION;
        }

        //test with a valid module but invalid action. it should return false.
        $view = new ViewClassic();
        $view->module = 'Home';
        $view->action = '';
        $ret = $view->display();
        self::assertFalse($ret);

        //test with a valid module and uncustomized action. it should return true
        $view = new ViewClassic();
        $view->module = 'Home';
        $view->action = 'About';

        self::markTestIncomplete("Warning was: Test code or tested code did not (only) close its own output buffers");

        //test with a valid module and customized action. it should return true
        $view = new ViewClassic();
        $view->module = 'Home';
        $view->action = 'index';

        ob_start();
        $ret = $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent));
        self::assertTrue($ret);


        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }
}
