<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewQuickTest extends SuitePHPUnitFrameworkTestCase
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testViewQuick()
    {
        //execute the constructor and check for the Object type and type attribute
        $view = new ViewQuick();

        $this->assertInstanceOf('ViewQuick', $view);
        $this->assertInstanceOf('ViewDetail', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
        $this->assertTrue(is_array($view->options));
    }

    public function testdisplay()
    {
        if (isset($_SESSION)) {
            $session = $_SESSION;
        }

        $view = new ViewQuick();

        //execute the method with required child objects preset. it will return some html.
        $view->dv = new DetailView2();
        $view->dv->ss = new Sugar_Smarty();
        $view->dv->module = 'Users';
        $view->bean = new User();
        $view->bean->id = 1;
        $view->dv->setup('Users', $view->bean);

        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }
}
