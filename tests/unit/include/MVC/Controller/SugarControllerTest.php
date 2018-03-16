<?php

use SuiteCRM\Test\TestLogger;

class SugarControllerTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
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
        $SugarController = new SugarController();

        // replace and use a temporary logger


        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarController->execute();
        } catch (Exception $e) {
            $this->fail();
        }

        // change back to original logger

        $testLogger = $GLOBALS['log'];
        $GLOBALS['log'] = $logger;

        // exam log

        $this->assertEquals(count($testLogger->calls), 3);
        $this->assertEquals(count($testLogger->calls['debug']), 2);
        //$this->assertEquals(count($testLogger->calls['warn']), 5);
        $this->assertEquals(count($testLogger->calls['fatal']), 3);

        $this->assertTrue(true);
    }

    public function testprocess()
    {
        $SugarController = new SugarController();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarController->process();
        } catch (Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function testpre_save()
    {
        $SugarController = new SugarController();
        $SugarController->setModule('Users');
        $SugarController->record = "1";
        $SugarController->loadBean();

        //execute the method and check if it either works or throws an mysql exception.
        //Fail if it throws any other exception.
        try {
            $SugarController->pre_save();
        } catch (Exception $e) {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage());
        }

        $this->assertTrue(true);
    }

    public function testaction_save()
    {
        $SugarController = new SugarController();
        $SugarController->setModule('Users');
        $SugarController->record = "1";
        $SugarController->loadBean();

        //execute the method and check if it either works or throws an mysql exception.
        //Fail if it throws any other exception.
        try {
            $SugarController->action_save();
        } catch (Exception $e) {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage());
        }

        $this->assertTrue(true);
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
    }
}
