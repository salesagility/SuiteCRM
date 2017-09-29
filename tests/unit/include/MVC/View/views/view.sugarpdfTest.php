<?php


class ViewSugarpdfTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testViewSugarpdf()
    {
        error_reporting(E_ERROR | E_PARSE);

         //execute the method without request parameters and test if it works. it should output some headers and throw headers output exception.
         try {
             $view = new ViewSugarpdf();
             $this->assertEmpty("", $view);
         } catch (Exception $e) {
             $this->assertStringStartsWith('Cannot modify header information', $e->getMessage());
         }


         //execute the method with request parameters and test if it works.
         $_REQUEST['sugarpdf'] = 'someValue';
        $view = new ViewSugarpdf();
        $view->module = 'Users';
        $this->assertInstanceOf('ViewSugarpdf', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('sugarpdf', 'type', $view);
        $this->assertAttributeEquals('someValue', 'sugarpdf', $view);
        $this->assertAttributeEquals(null, 'sugarpdfBean', $view);
    }

    //Incomplete test. SugarpdfFactory::loadSugarpdf throws fatal error. error needs to be resolved before testing.
    public function testpreDisplay()
    {
        $this->markTestIncomplete('Can Not be implemented');
    }

    //Incomplete test.  SugarpdfFactory::loadSugarpdf throws fatal error. error needs to be resolved before testing.
    public function testdisplay()
    {
        $this->markTestIncomplete('Can Not be implemented');
    }
}
