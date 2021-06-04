<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewMultieditTest extends SuitePHPUnitFrameworkTestCase
{
    public function testViewMultiedit()
    {
        // Execute the constructor and check for the Object type and type attribute
        $view = new ViewMultiedit();
        self::assertInstanceOf('ViewMultiedit', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertAttributeEquals('edit', 'type', $view);
    }

    public function testdisplay()
    {
        //test without action value and modules list in REQUEST object
        $view = new ViewMultiedit();
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        self::assertEquals(0, strlen($renderedContent));

        //test with valid action value to get link in return
        $view = new ViewMultiedit();
        $view->action = 'AjaxFormSave';
        $view->module = 'Users';
        $view->bean = BeanFactory::newBean('Users');
        $view->bean->id = 1;
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent));

        //Fails with a fatal error, method creates editview without properly setting it up causing fatal errors.
        /*
        //test only with modules list in REQUEST object
        $view = new ViewMultiedit();
        $GLOBALS['current_language']= 'en_us';
        $_REQUEST['modules']= Array('Calls','Accounts');
        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0,strlen($renderedContent));
        */
    }
}
