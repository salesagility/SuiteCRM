<?php

class ViewDetailTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    
    protected $stateSaver;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->stateSaver = new SuiteCRM\StateSaver();
        $this->stateSaver->pushTable('email_addresses');

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }
    
    public function tearDown()
    {   
        $this->stateSaver->popTable('email_addresses');
        
        parent::tearDown();
    }

    public function testViewDetail()
    {
        
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        
        
        
        $view = new ViewDetail();
        $this->assertInstanceOf('ViewDetail', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('detail', 'type', $view);
        
        
        
        $state->popTable('email_addresses');
        $state->popGlobals();

    }

    public function testpreDisplay()
    {
        
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        
        

        
        $view = new ViewDetail();
        $view->module = 'Users';
        $view->bean = new User();
        $view->ss = new Sugar_Smarty();
        $view->preDisplay();
        $this->assertInstanceOf('DetailView2', $view->dv);
        $this->asserttrue(is_array($view->dv->defs));

        
        $view = new ViewDetail();
        $view->module = 'Meetings';
        $view->bean = new Meeting();
        $view->ss = new Sugar_Smarty();
        $view->preDisplay();
        $this->assertInstanceOf('DetailView2', $view->dv);
        $this->asserttrue(is_array($view->dv->defs));
        
        
        
        $state->popTable('email_addresses');
        $state->popGlobals();

    }

    public function testdisplay()
    {
        
        
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('email_addresses');
        
        
        

        

        
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
        
        
        
        $state->popTable('email_addresses');
        $state->popGlobals();


    }
}
