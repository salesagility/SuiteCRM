<?php

class SugarViewTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testinit()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        

        $SugarView = new SugarView();

        
        try {
            $SugarView->init();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
        
    }

    public function testprocess()
    {
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('tracker');
        $state->pushGlobals();

	
        
        
        
        $SugarView = new SugarView();
        $SugarView->module = 'Users';
        $GLOBALS['app'] = new SugarApplication();

        
        
        try {
            ob_start();

            $SugarView->process();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        $state->popGlobals();
        $state->popTable('tracker');
    }

    public function testdisplayErrors()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarView = new SugarView();

        
        try {
            $errors = $SugarView->displayErrors();
            $this->assertEmpty($errors, print_r($SugarView, true));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testpreDisplay()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarView = new SugarView();

        
        try {
            $SugarView->preDisplay();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testdisplay()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarView = new SugarView();

        
        try {
            $SugarView->display();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testdisplayHeader()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarView = new SugarView();
        $SugarView->module = 'Users';
        $GLOBALS['app'] = new SugarApplication();

        
        
        try {
            ob_start();

            $SugarView->displayHeader();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testgetModuleMenuHTML()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarView = new SugarView();

        
        try {
            $SugarView->getModuleMenuHTML();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testincludeClassicFile()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarView = new SugarView();

        
        
        try {
            $SugarView->includeClassicFile('config.php');
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testgetJavascriptValidation()
    {
        
        $js = SugarView::getJavascriptValidation();
        $this->assertGreaterThan(0, strlen($js));
    }

    public function testdisplayFooter()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        $SugarView = new SugarView();

        
        
        try {
            ob_start();

            $SugarView->displayFooter();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testrenderJavascript()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarView = new SugarView();

        
        
        try {
            ob_start();

            $SugarView->renderJavascript();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testgetMenu()
    {

        

        $SugarView = new SugarView();

        
        
        /*
    	try {
    		
    		$menu = $SugarView->getMenu();
    		
    		 
    	} catch (Exception $e) {
    		$this->assertTrue(TRUE);
    		
    	} */

        
        $menu = $SugarView->getMenu('Users');
        $this->assertTrue(is_array($menu));
    }

    public function testgetModuleTitle()
    {
        $SugarView = new SugarView();

        
        $moduleTitle = $SugarView->getModuleTitle();
        $this->assertGreaterThan(0, strlen($moduleTitle));

        
        $moduleTitle = $SugarView->getModuleTitle(true);
        $this->assertGreaterThan(0, strlen($moduleTitle));

        
        $moduleTitle = $SugarView->getModuleTitle(false);
        $this->assertGreaterThan(0, strlen($moduleTitle));
    }

    public function testgetMetaDataFile()
    {
        $SugarView = new SugarView();

        
        $metaDataFile = $SugarView->getMetaDataFile();
        $this->assertEquals(null, $metaDataFile);

        
        $SugarView->type = 'detail';
        $SugarView->module = 'Users';

        $metaDataFile = $SugarView->getMetaDataFile();
        $this->assertGreaterThan(0, strlen($metaDataFile));
    }

    public function testgetBrowserTitle()
    {
        $SugarView = new SugarView();

        
        $browserTitle = $SugarView->getBrowserTitle();
        $this->assertGreaterThan(0, strlen($browserTitle));
    }

    public function testgetBreadCrumbSymbol()
    {
        $SugarView = new SugarView();

        
        $breadCrumbSymbol = $SugarView->getBreadCrumbSymbol();
        $this->assertGreaterThan(0, strlen($breadCrumbSymbol));
    }

    public function testcheckPostMaxSizeError()
    {
        $SugarView = new SugarView();

        
        $postMaxSizeError = $SugarView->checkPostMaxSizeError();
        $this->assertFalse($postMaxSizeError);
    }
}
