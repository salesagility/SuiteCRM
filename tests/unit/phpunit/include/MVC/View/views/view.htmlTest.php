<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewHtmlTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testViewHtml()
    {
        // Execute the constructor and check for the Object type
        $view = new ViewHtml();
        self::assertInstanceOf('ViewHtml', $view);
        self::assertInstanceOf('SugarView', $view);
    }

    public function testdisplay()
    {
        $view = new ViewHtml();

        // Execute the method and test that it works and doesn't throw an exception.
        try {
            $view->display();
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }
}
