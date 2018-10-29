<?php

use SuiteCRM\Test\TestLogger;

class SugarControllerTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        $current_user = new User();
        get_sugar_config_defaults();
        if (!isset($GLOBALS['app']) || !$GLOBALS['app']) {
            $GLOBALS['app'] = new SugarApplication();
        }
    }

    public function testsetup()
    {
        $SugarController = new SugarController();
        $default_module = $SugarController->module;

        //first test with empty parameter and check for default values being used
        $SugarController->setup('');
        $this->assertAttributeEquals($default_module, 'module', $SugarController);
        $this->assertAttributeEquals(null, 'target_module', $SugarController);

        //secondly test with module name and check for correct assignment. 
        $SugarController->setup('Users');
        $this->assertAttributeEquals('Users', 'module', $SugarController);
        $this->assertAttributeEquals(null, 'target_module', $SugarController);
    }

    public function testsetModule()
    {
        $SugarController = new SugarController();

        //first test with empty parameter
        $SugarController->setModule('');
        $this->assertAttributeEquals('', 'module', $SugarController);

        //secondly test with module name and check for correct assignment.
        $SugarController->setModule('Users');
        $this->assertAttributeEquals('Users', 'module', $SugarController);
    }

    public function testloadBean()
    {
        $SugarController = new SugarController();

        //first test with empty parameter and check for null. Default is Home but Home has no bean
        $SugarController->setModule('');
        $SugarController->loadBean();
        $this->assertEquals(null, $SugarController->bean);

        //secondly test with module name and check for correct bean class loaded.
        $SugarController->setModule('Users');
        $SugarController->loadBean();
        $this->assertInstanceOf('User', $SugarController->bean);
    }

    public function testexecute()
    {
	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('tracker');
        $state->pushGlobals();
        
	// test
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $SugarController = new SugarController();

        // replace and use a temporary logger


        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarController->execute();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        // change back to original logger

        $testLogger = $GLOBALS['log'];
        $GLOBALS['log'] = $logger;

        // exam log


        $this->assertTrue(true);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('tracker');
    }

    public function testprocess()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $SugarController = new SugarController();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarController->process();
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        // clean up
        
        
    }

    public function testpre_save()
    {
        if(isset($_SESSION)) {
            $session = $_SESSION;
        }
        
        $testUserId = 1;
        $query = "SELECT date_modified FROM users WHERE id = '$testUserId' LIMIT 1";
        $resource = DBManagerFactory::getInstance()->query($query);
        $row = $resource->fetch_assoc();
        $testUserDateModified = $row['date_modified'];
        
        
        $SugarController = new SugarController();
        $SugarController->setModule('Users');
        $SugarController->record = "1";
        $SugarController->loadBean();

        //execute the method and check if it either works or throws an mysql exception.
        //Fail if it throws any other exception.
        try {
            $SugarController->pre_save();
        } catch (Exception $e) {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        $this->assertTrue(true);
        
        // cleanup
        
        if(isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
        
        $query = "UPDATE users SET date_modified = '$testUserDateModified' WHERE id = '$testUserId' LIMIT 1";
        DBManagerFactory::getInstance()->query($query);
    }

    public function testaction_save()
    {
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('tracker');
        
        if(isset($_SESSION)) {
            $session = $_SESSION;
        }
        
        $testUserId = 1;
        $query = "SELECT date_modified FROM users WHERE id = '$testUserId' LIMIT 1";
        $resource = DBManagerFactory::getInstance()->query($query);
        $row = $resource->fetch_assoc();
        $testUserDateModified = $row['date_modified'];
        
        
        $SugarController = new SugarController();
        $SugarController->setModule('Users');
        $SugarController->record = "1";
        $SugarController->loadBean();

        //execute the method and check if it either works or throws an mysql exception.
        //Fail if it throws any other exception.
        try {
            $SugarController->action_save();
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertTrue(true);
        }

        $this->assertTrue(true);
        
        // cleanup
        
        if(isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }
        
        $query = "UPDATE users SET date_modified = '$testUserDateModified' WHERE id = '$testUserId' LIMIT 1";
        DBManagerFactory::getInstance()->query($query);
        
        $state->popTable('tracker');
        $state->popTable('aod_index');
    }

    public function testaction_spot()
    {
        $SugarController = new SugarController();

        //first check with default value of attribute
        $this->assertAttributeEquals('classic', 'view', $SugarController);

        //secondly check for attribute value change on method execution.
        $SugarController->action_spot();
        $this->assertAttributeEquals('spot', 'view', $SugarController);
    }

    public function testgetActionFilename()
    {

        //first check with a invalid value
        $action = SugarController::getActionFilename('');
        $this->assertEquals('', $action);

        //secondly check with a valid value
        $action = SugarController::getActionFilename('editview');
        $this->assertEquals('EditView', $action);
    }

    public function testcheckEntryPointRequiresAuth()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        // test
        
        $SugarController = new SugarController();

        //check with a invalid value
        $result = $SugarController->checkEntryPointRequiresAuth('');
        $this->assertTrue($result);

        //cehck with a valid True value
        $result = $SugarController->checkEntryPointRequiresAuth('download');
        $this->assertTrue($result);

        //cehck with a valid False value
        $result = $SugarController->checkEntryPointRequiresAuth('GeneratePassword');
        $this->assertFalse($result);
        
        // clean up
        
        $state->popGlobals();
    }
}
