<?php

class ViewDetailTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected $stateSaver;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->stateSaver = new SuiteCRM\StateSaver();
        $this->stateSaver->pushTable('email_addresses');

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }
    
    protected function tearDown()
    {
        $this->stateSaver->popTable('email_addresses');
        
        parent::tearDown();
    }

    public function testViewDetail()
    {
        
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        
        //execute the contructor and check for the Object type and type attribute
        $view = new ViewDetail();
        $this->assertInstanceOf('ViewDetail', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
        
        // clean up
        
        $state->popTable('email_addresses');
        $state->popGlobals();
    }

    public function testpreDisplay()
    {
        // store state
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test
        //execute the method with required attributes preset, it will initialize the dv(detail view) attribute.
        $view = new ViewDetail();
        $view->module = 'Users';
        $view->bean = new User();
        $view->ss = new Sugar_Smarty();
        $view->preDisplay();
        $this->assertInstanceOf('DetailView2', $view->dv);
        $this->asserttrue(is_array($view->dv->defs));

        //execute the method again for a different module with required attributes preset, it will initialize the dv(detail view) attribute.
        $view = new ViewDetail();
        $view->module = 'Meetings';
        $view->bean = new Meeting();
        $view->ss = new Sugar_Smarty();
        $view->preDisplay();
        $this->assertInstanceOf('DetailView2', $view->dv);
        $this->asserttrue(is_array($view->dv->defs));
        
        // clean up
        
        $state->popTable('email_addresses');
        $state->popGlobals();
    }

    public function testdisplay()
    {
        
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        // test

        //execute the method with essential parameters set. it should return some html.
        $view = new ViewDetail();
        $view->module = 'Users';
        $view->bean = new User();
        $view->bean->id = 1;
        $view->ss = new Sugar_Smarty();
        $view->preDisplay();

        ob_start();
        $view->display();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
        
        // clean up
        
        $state->popTable('email_addresses');
        $state->popGlobals();
    }
}
