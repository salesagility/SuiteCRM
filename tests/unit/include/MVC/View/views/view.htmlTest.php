<?php

class ViewHtmlTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
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

        
        $view = new ViewHtml();
        $this->assertInstanceOf('ViewHtml', $view);
        $this->assertInstanceOf('SugarView', $view);
    }

    public function testdisplay()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $view = new ViewHtml();

        
        try {
            $view->display();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }
}
