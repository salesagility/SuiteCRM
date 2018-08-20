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
        
        
        
        //error_reporting(E_ERROR | E_WARNING | E_PARSE);

        $SugarView = new SugarView();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarView->init();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        // clean up
        
        
    }

    public function testprocess()
    {
	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('tracker');
        $state->pushGlobals();

	// test
        
        //error_reporting(E_ERROR | E_PARSE);
        
        $SugarView = new SugarView();
        $SugarView->module = 'Users';
        $GLOBALS['app'] = new SugarApplication();

        //execute the method and check if it works and doesn't throws an exception
        //secondly check if it outputs any content to browser
        try {
            ob_start();

            $SugarView->process();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('tracker');
    }

    public function testdisplayErrors()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $SugarView = new SugarView();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $errors = $SugarView->displayErrors();
            $this->assertEmpty($errors, print_r($SugarView, true));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        // clean up
        
        
    }

    public function testpreDisplay()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $SugarView = new SugarView();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarView->preDisplay();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        // clean up
        
        
    }

    public function testdisplay()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $SugarView = new SugarView();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarView->display();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        // clean up
        
        
    }

    public function testdisplayHeader()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $SugarView = new SugarView();
        $SugarView->module = 'Users';
        $GLOBALS['app'] = new SugarApplication();

        //execute the method and check if it works and doesn't throws an exception
        //secondly check if it outputs any content to browser
        try {
            ob_start();

            $SugarView->displayHeader();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testgetModuleMenuHTML()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $SugarView = new SugarView();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarView->getModuleMenuHTML();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        // clean up
        
        
    }

    public function testincludeClassicFile()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $SugarView = new SugarView();

        //execute the method and check if it works and doesn't throws an exception
        //use any valid file path, we just need to avoid failing require_once
        try {
            $SugarView->includeClassicFile('config.php');
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        // clean up
        
        
    }

    public function testgetJavascriptValidation()
    {
        //check if it returns any text i-e JS code    	
        $js = SugarView::getJavascriptValidation();
        $this->assertGreaterThan(0, strlen($js));
    }

    public function testdisplayFooter()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        $SugarView = new SugarView();

        //execute the method and check if it works and doesn't throws an exception
        //secondly check if it outputs any content to browser
        try {
            ob_start();

            $SugarView->displayFooter();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testrenderJavascript()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $SugarView = new SugarView();

        //execute the method and check if it works and doesn't throws an exception
        //secondly check if it outputs any content to browser
        try {
            ob_start();

            $SugarView->renderJavascript();

            $renderedContent = ob_get_contents();
            ob_end_clean();

            $this->assertGreaterThan(0, strlen($renderedContent));
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testgetMenu()
    {

        ////error_reporting(E_ALL);

        $SugarView = new SugarView();

        //execute the method and check if it works and throws an exception if no module is provided
        //it creates memory Fatal errors which causes PHPunit to crash so we will skip this scenario
        /*
    	try {
    		//check first with invalid value and test if it throws an exception
    		$menu = $SugarView->getMenu();
    		//$this->assertTrue(is_array($menu));
    		 
    	} catch (Exception $e) {
    		$this->assertTrue(TRUE);
    		//$this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
    	} */

        //check with valid value and check if it returns an array.
        $menu = $SugarView->getMenu('Users');
        $this->assertTrue(is_array($menu));
    }

    public function testgetModuleTitle()
    {
        $SugarView = new SugarView();

        //first execute the method with default value
        $moduleTitle = $SugarView->getModuleTitle();
        $this->assertGreaterThan(0, strlen($moduleTitle));

        //second execute the method with true value
        $moduleTitle = $SugarView->getModuleTitle(true);
        $this->assertGreaterThan(0, strlen($moduleTitle));

        //third execute the method with false value
        $moduleTitle = $SugarView->getModuleTitle(false);
        $this->assertGreaterThan(0, strlen($moduleTitle));
    }

    public function testgetMetaDataFile()
    {
        $SugarView = new SugarView();

        //first execute the method with missing attributes. it should return Null.
        $metaDataFile = $SugarView->getMetaDataFile();
        $this->assertEquals(null, $metaDataFile);

        //second execute the method with valid attributes set. it should return a file path string.
        $SugarView->type = 'detail';
        $SugarView->module = 'Users';

        $metaDataFile = $SugarView->getMetaDataFile();
        $this->assertGreaterThan(0, strlen($metaDataFile));
    }

    public function testgetBrowserTitle()
    {
        $SugarView = new SugarView();

        //execute the method. it should return a title string.
        $browserTitle = $SugarView->getBrowserTitle();
        $this->assertGreaterThan(0, strlen($browserTitle));
    }

    public function testgetBreadCrumbSymbol()
    {
        $SugarView = new SugarView();

        //execute the method. it should return a string.
        $breadCrumbSymbol = $SugarView->getBreadCrumbSymbol();
        $this->assertGreaterThan(0, strlen($breadCrumbSymbol));
    }

    public function testcheckPostMaxSizeError()
    {
        $SugarView = new SugarView();

        //execute the method. it should return False because Request parameters are not available.
        $postMaxSizeError = $SugarView->checkPostMaxSizeError();
        $this->assertFalse($postMaxSizeError);
    }
}
