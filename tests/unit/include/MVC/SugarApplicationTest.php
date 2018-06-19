<?php


class SugarApplicationTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{

    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testexecute()
    {
        $SugarApplication = new SugarApplication();

        






        $this->markTestIncomplete('Can Not be implemented');
    }

    public function testloadUser()
    {

        
        /*  
        
        
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();
        
        try {
            $SugarApplication->loadUser();
        } 
        catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        $this->assertTrue(TRUE);
        */
        $this->markTestIncomplete('Can Not be implemented');
    }

    public function testACLFilter()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        
        if(isset($_SESSION)) {
            $session = $_SESSION;
        }
        
        $SugarApplication = new SugarApplication();

        
        try {
            $SugarApplication->ACLFilter();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
        
        
        
        if(isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }

    public function testsetupResourceManagement()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarApplication = new SugarApplication();

        
        try {
            $SugarApplication->setupResourceManagement('');
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        
        try {
            $SugarApplication->setupResourceManagement('Users');
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testsetupPrint()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarApplication = new SugarApplication();

        
        try {
            $SugarApplication->setupPrint();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testpreProcess()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        
        if(isset($_SESSION)) {
            $session = $_SESSION;
        }
        
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        
        try {
            $SugarApplication->preProcess();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
        
        
        
        if(isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }

    public function testhandleOfflineClient()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarApplication = new SugarApplication();

        
        try {
            $SugarApplication->handleOfflineClient();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testhandleAccessControl()
    {
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        $result = $SugarApplication->handleAccessControl();

        
        $this->assertEquals(null, $result);

        
        $this->assertEquals(true, $SugarApplication->controller->hasAccess);
    }

    public function testpreLoadLanguages()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        try {
            SugarApplication::preLoadLanguages();

            
            $this->assertTrue(isset($GLOBALS['current_language']));

            
            $this->assertTrue(is_array($GLOBALS['app_strings']) && count($GLOBALS['app_strings']) > 0);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testloadLanguages()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        try {
            $SugarApplication->loadLanguages();

            
            $this->assertTrue(isset($GLOBALS['current_language']));

            
            $this->assertTrue(is_array($GLOBALS['app_strings']) && count($GLOBALS['app_strings']) > 0);

            
            $this->assertTrue(is_array($GLOBALS['app_list_strings']) && count($GLOBALS['app_list_strings']) > 0);

            
            $this->assertTrue(is_array($GLOBALS['mod_strings']) && count($GLOBALS['mod_strings']) > 0);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        
        
        
    }

    public function testcheckDatabaseVersion()
    {
        self::markTestIncomplete('environment dependency');
        $state = new SuiteCRM\StateSaver();
        
        
        

        $SugarApplication = new SugarApplication();

        
        
        include __DIR__ . '/../../../../sugar_version.php';
        self::assertTrue(isset($sugar_db_version) && $sugar_db_version);
        
        $GLOBALS['sugar_db_version'] = $sugar_db_version;
        $result = $SugarApplication->checkDatabaseVersion(false);
        $this->assertTrue($result);
        
        
        
        
        
    }

    public function testloadDisplaySettings()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarApplication = new SugarApplication();

        
        try {
            $SugarApplication->loadDisplaySettings();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testloadLicense()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarApplication = new SugarApplication();

        
        try {
            $SugarApplication->loadLicense();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
    }

    public function testloadGlobals()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        
        if(isset($_REQUEST)) {
            $request = $_REQUEST;
        }
        
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        
        try {
            $SugarApplication->loadGlobals();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        
        
        
        
        
        
        if(isset($request)) {
            $_REQUEST = $request;
        } else {
            unset($_REQUEST);
        }
        
    }

    protected $sessionStartedOk = false;
    
    public function teststartSession()
    {
        
        if(isset($_SESSION)) {
            $session = $_SESSION;
        }
        
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        
        try {
            if(!headers_sent()) {
                $SugarApplication->startSession();
                $this->sessionStartedOk = true;
            }
        } catch (Exception $e) {
            $err = $e->getMessage() . ' ' . $e->getCode() . ' ' . $e->getFile() . ' ' . $e->getLine() . ' ' . $e->getTraceAsString();
            var_dump($err);
            $this->fail($err);
        }

        $this->assertTrue(true);
        
        
        
        if(isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
        
    }

    public function testendSession()
    {
        $SugarApplication = new SugarApplication();
        $SugarApplication->controller = new SugarController();

        
        try {
            if($this->sessionStartedOk) {
                $SugarApplication->endSession();
            }
        } catch (Exception $e) {
            $err = $e->getMessage() . ' ' . $e->getCode() . ' ' . $e->getFile() . ' ' . $e->getLine() . ' ' . $e->getTraceAsString();
            var_dump($err);
            $this->fail($err);
        }

        $this->assertTrue(true);
    }

    public function testredirect()
    {
        
        /*
        $SugarApplication = new SugarApplication();

        
        try {
            ob_start();
        
            $SugarApplication->redirect();
        
            $renderedContent = ob_get_contents();
            ob_end_clean();
            $this->assertGreaterThan(0,strlen($renderedContent));
             
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        */
        $this->markTestIncomplete('Can Not be implemented');
    }

    public function testappendErrorMessage()
    {
        
        if(isset($_SESSION)) {
            $session = $_SESSION;
        }
        
        
        
        $_SESSION['user_error_message'] = [];
        $user_error_message_count = count($_SESSION['user_error_message']);
        SugarApplication::appendErrorMessage('some error');
        $this->assertGreaterThan($user_error_message_count, count($_SESSION['user_error_message']));
        
        
        
        if(isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
    }

    public function testgetErrorMessages()
    {
        
        $errorMessages = SugarApplication::getErrorMessages();
        $this->assertTrue(is_array($errorMessages));
    }

    public function testsetCookie()
    {
        
        if(isset($_COOKIE)) {
            $cookie = $_COOKIE;
        }
        
        SugarApplication::setCookie('key', 'value');
        $this->assertEquals('value', $_COOKIE['key']);
        
        
        
        if(isset($cookie)) {
            $_COOKIE = $cookie;
        } else {
            unset($_COOKIE);
        }
    }

    public function testcreateLoginVars()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $SugarApplication = new SugarApplication();

        
        try {
            $vars = $SugarApplication->createLoginVars();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        // clean up
        
        
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
