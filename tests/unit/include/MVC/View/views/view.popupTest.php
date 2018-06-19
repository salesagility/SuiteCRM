<?php

class ViewPopupTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
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

        
        $view = new ViewPopup();
        $this->assertInstanceOf('ViewPopup', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('list', 'type', $view);

        unset($view);
    }

    public function testdisplay()
    {
        
        if(isset($_SESSION)) {
            $session = $_SESSION;
        }

        

        
        $view = new ViewPopup();
        $view->module = 'Accounts';

        try {
            $view->bean = BeanFactory::getBean('Accounts');
            self::assertTrue(false);
        } catch (Exception $e) {
            self::assertTrue(true);
        }

        

        if(isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }
}
