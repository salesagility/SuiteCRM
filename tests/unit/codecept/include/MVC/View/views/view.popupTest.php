<?php

class ViewPopupTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testViewPopup()
    {

        //execute the contructor and check for the Object type and type attribute
        $view = new ViewPopup();
        $this->assertInstanceOf('ViewPopup', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('list', 'type', $view);

        unset($view);
    }

    public function testdisplay()
    {
        if (isset($_SESSION)) {
            $session = $_SESSION;
        }

        //error_reporting(E_ERROR | E_PARSE |E_ALL);

        //execute the method with required child objects preset. it should return some html.
        $view = new ViewPopup();
        $view->module = 'Accounts';

        try {
            $view->bean = BeanFactory::getBean('Accounts');
            self::assertTrue(false);
        } catch (Exception $e) {
            self::assertTrue(true);
        }

        // clean up

        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }
}
