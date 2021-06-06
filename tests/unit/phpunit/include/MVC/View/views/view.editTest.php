<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewEditTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testViewEdit()
    {
        // Execute the constructor and check for the Object type and attributes
        $view = new ViewEdit();
        self::assertInstanceOf('ViewEdit', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertAttributeEquals('edit', 'type', $view);

        self::assertAttributeEquals(false, 'useForSubpanel', $view);
        self::assertAttributeEquals(false, 'useModuleQuickCreateTemplate', $view);
        self::assertAttributeEquals(true, 'showTitle', $view);
    }

    public function testpreDisplay()
    {
        if (isset($_SESSION)) {
            $session = $_SESSION;
        }

        //execute the method with required attributes preset, it will initialize the ev(edit view) attribute.
        $view = new ViewEdit();
        $view->module = 'Users';
        $view->bean = BeanFactory::newBean('Users');
        $view->preDisplay();
        self::assertInstanceOf('EditView', $view->ev);

        //execute the method again for a different module with required attributes preset, it will initialize the ev(edit view) attribute.
        $view = new ViewEdit();
        $view->module = 'Meetings';
        $view->bean = BeanFactory::newBean('Meetings');
        $view->preDisplay();
        self::assertInstanceOf('EditView', $view->ev);


        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }

    public function testdisplay()
    {
        //execute the method with essential parameters set. it should return some html.
        $view = new ViewEdit();
        $view->module = 'Users';
        $view->bean = BeanFactory::newBean('Users');
        $view->preDisplay();
        $view->ev->ss = new Sugar_Smarty();

        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        self::assertGreaterThan(0, strlen($renderedContent));
    }
}
