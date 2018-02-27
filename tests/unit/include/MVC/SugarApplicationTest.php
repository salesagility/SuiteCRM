<?php


class SugarApplicationTest extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testexecute()
    {
        $SugarApplication = new SugarApplication();

        //execute the method and test if it works and does not throws an exception other than headers output exception.
//        try {
//            $SugarApplication->execute();
//        } catch (Exception $e) {
//            print_r($e->getMessage());
//            $this->assertStringStartsWith('Cannot modify header information', $e->getMessage());
//        }
        $this->markTestIncomplete('Can Not be implemented');
    }

    public function testloadUser()
    {

        //cannot test this method as it uses die which stops execution of php unit as well
        /*  
        error_reporting(E_ERROR | E_PARSE);
        
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();
        
        try {
            $SugarApplication->loadUser();
        } 
        catch (Exception $e) {
            $this->fail();
        }
        
        $this->assertTrue(TRUE);
        */
        $this->markTestIncomplete('Can Not be implemented');
    }

    public function testACLFilter()
    {
        $SugarApplication = new SugarApplication();

        //execute the method and test if it works and does not throws an exception.
        try {
            $SugarApplication->ACLFilter();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testsetupResourceManagement()
    {
        $SugarApplication = new SugarApplication();

        //execute the method with invalid input and test if it works and does not throws an exception.
        try {
            $SugarApplication->setupResourceManagement('');
        } catch (Exception $e) {
            $this->fail();
        }

        //execute the method with valid input and test if it works and does not throws an exception.
        try {
            $SugarApplication->setupResourceManagement('Users');
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testsetupPrint()
    {
        $SugarApplication = new SugarApplication();

        //execute the method and test if it works and does not throws an exception.
        try {
            $SugarApplication->setupPrint();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testpreProcess()
    {
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        //execute the method and test if it works and does not throws an exception.
        try {
            $SugarApplication->preProcess();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testhandleOfflineClient()
    {
        $SugarApplication = new SugarApplication();

        //execute the method and test if it works and does not throws an exception.
        try {
            $SugarApplication->handleOfflineClient();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testhandleAccessControl()
    {
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        $result = $SugarApplication->handleAccessControl();

        //check that it returns Null
        $this->assertEquals(null, $result);

        //check that controller->hasAccess is true i-e default setting.
        $this->assertEquals(true, $SugarApplication->controller->hasAccess);
    }

    public function testpreLoadLanguages()
    {
        try {
            SugarApplication::preLoadLanguages();

            //check that method call got the current_language global variable set.
            $this->assertTrue(isset($GLOBALS['current_language']));

            //check that method call got the app_strings global variable set.
            $this->assertTrue(is_array($GLOBALS['app_strings']) && count($GLOBALS['app_strings']) > 0);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testloadLanguages()
    {
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        try {
            $SugarApplication->loadLanguages();

            //check that method call got the current_language global variable set.
            $this->assertTrue(isset($GLOBALS['current_language']));

            //check that method call got the app_strings global variable set.
            $this->assertTrue(is_array($GLOBALS['app_strings']) && count($GLOBALS['app_strings']) > 0);

            //check that method call got the app_list_strings global variable set.
            $this->assertTrue(is_array($GLOBALS['app_list_strings']) && count($GLOBALS['app_list_strings']) > 0);

            //check that method call got the mod_strings global variable set.
            $this->assertTrue(is_array($GLOBALS['mod_strings']) && count($GLOBALS['mod_strings']) > 0);
        } catch (Exception $e) {
            $this->fail();
        }
    }

    public function testcheckDatabaseVersion()
    {
        error_reporting(E_ERROR | E_PARSE);

        $SugarApplication = new SugarApplication();

        //execute the method with false parameter and check for false returned as it cannot connect to DB.
        //testing with true will allow it to use die() which stops phpunit execution as well.
        $result = $SugarApplication->checkDatabaseVersion(false);
        $this->assertFalse($result);
    }

    public function testloadDisplaySettings()
    {
        $SugarApplication = new SugarApplication();

        //execute the method and test if it works and does not throws an exception.
        try {
            $SugarApplication->loadDisplaySettings();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testloadLicense()
    {
        $SugarApplication = new SugarApplication();

        //execute the method and test if it works and does not throws an exception.
        try {
            $SugarApplication->loadLicense();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testloadGlobals()
    {
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        //execute the method and test if it works and does not throws an exception.
        try {
            $SugarApplication->loadGlobals();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function teststartSession()
    {
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        //execute the method and test if it works and does not throws an exception.
        try {
            $SugarApplication->startSession();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testendSession()
    {
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        //execute the method and test if it works and does not throws an exception.
        try {
            $SugarApplication->endSession();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testredirect()
    {
        //this method uses exit() which stops execution of phpunit as well so it cannot be tested without additional --process-isolation commandline parameter.
        /*
        $SugarApplication = new SugarApplication();

        //execute the method and check if it works and doesn't throws an exception
        try {
            ob_start();
        
            $SugarApplication->redirect();
        
            $renderedContent = ob_get_contents();
            ob_end_clean();
            $this->assertGreaterThan(0,strlen($renderedContent));
             
        } catch (Exception $e) {
            $this->fail();
        }
        */
        $this->markTestIncomplete('Can Not be implemented');
    }

    public function testappendErrorMessage()
    {
        //execute the method and check that the method adds the message to user_error_message array.
        //there should be one more array element after method execution.
        $user_error_message_count = count($_SESSION['user_error_message']);
        SugarApplication::appendErrorMessage('some error');
        $this->assertGreaterThan($user_error_message_count, count($_SESSION['user_error_message']));
    }

    public function testgetErrorMessages()
    {
        //execute the method and check if it returns a array. 
        $errorMessages = SugarApplication::getErrorMessages();
        $this->assertTrue(is_array($errorMessages));
    }

    public function testsetCookie()
    {
        //execute the method and check that the method adds the key value pair to cookies array.
        SugarApplication::setCookie('key', 'value');
        $this->assertEquals('value', $_COOKIE['key']);
    }

    public function testcreateLoginVars()
    {
        $SugarApplication = new SugarApplication();

        //execute the method and test if it works and does not throws an exception.
        try {
            $vars = $SugarApplication->createLoginVars();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testgetLoginVars()
    {
        $SugarApplication = new SugarApplication();

        //execute the method and test that it returns a array.
        $vars = $SugarApplication->getLoginVars();
        $this->assertTrue(is_array($vars));
    }

    public function testgetLoginRedirect()
    {
        $SugarApplication = new SugarApplication();

        //execute the method and test that it returns a plus length string
        $redirect = $SugarApplication->getLoginRedirect();
        $this->assertGreaterThan(0, strlen($redirect));
    }
}
