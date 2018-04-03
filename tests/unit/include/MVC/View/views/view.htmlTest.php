<?php

class ViewHtmlTest extends SuiteCRM\StateChecker_PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testViewHtml()
    {

        //execute the contructor and check for the Object type
        $view = new ViewHtml();
        $this->assertInstanceOf('ViewHtml', $view);
        $this->assertInstanceOf('SugarView', $view);
    }

    public function testdisplay()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushErrorLevel();
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $view = new ViewHtml();

        //execute the method and test if it works and does not throws an exception.
        try {
            $view->display();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popErrorLevel();
    }
}
