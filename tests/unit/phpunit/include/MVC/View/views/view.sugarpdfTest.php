<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewSugarpdfTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testViewSugarpdf(): void
    {
        if (isset($_REQUEST)) {
            $_request = $_REQUEST;
        }

        //execute the method without request parameters and test if it works. it should output some headers and throw headers output exception.
        try {
            $view = new ViewSugarpdf();
            self::assertEmpty("", $view);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            self::assertStringStartsWith('Cannot modify header information', $msg, 'Cannot modify header information? : ' . $msg . "\nTrace\n" . $e->getTraceAsString());
        }

        //execute the method with request parameters and test if it works.
        $_REQUEST['sugarpdf'] = 'someValue';
        $view = new ViewSugarpdf();
        $view->module = 'Users';
        self::assertInstanceOf('ViewSugarpdf', $view);
        self::assertInstanceOf('SugarView', $view);
        self::assertAttributeEquals('sugarpdf', 'type', $view);
        self::assertAttributeEquals('someValue', 'sugarpdf', $view);
        self::assertAttributeEquals(null, 'sugarpdfBean', $view);

        if (isset($_request)) {
            $_REQUEST = $_request;
        } else {
            unset($_REQUEST);
        }
    }

    //Incomplete test. SugarpdfFactory::loadSugarpdf throws fatal error. error needs to be resolved before testing.
    public function testpreDisplay(): void
    {
//        $this->markTestIncomplete('Can Not be implemented');
    }

    //Incomplete test.  SugarpdfFactory::loadSugarpdf throws fatal error. error needs to be resolved before testing.
    public function testdisplay(): void
    {
//        $this->markTestIncomplete('Can Not be implemented');
    }
}
