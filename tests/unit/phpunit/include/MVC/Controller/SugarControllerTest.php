<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;
use SuiteCRM\Tests\SuiteCRM\Test\TestLogger;

class SugarControllerTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        global $current_user;
        $current_user = BeanFactory::newBean('Users');
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
        self::assertAttributeEquals($default_module, 'module', $SugarController);
        self::assertAttributeEquals(null, 'target_module', $SugarController);

        //secondly test with module name and check for correct assignment.
        $SugarController->setup('Users');
        self::assertAttributeEquals('Users', 'module', $SugarController);
        self::assertAttributeEquals(null, 'target_module', $SugarController);
    }

    public function testsetModule()
    {
        $SugarController = new SugarController();

        //first test with empty parameter
        $SugarController->setModule('');
        self::assertAttributeEquals('', 'module', $SugarController);

        //secondly test with module name and check for correct assignment.
        $SugarController->setModule('Users');
        self::assertAttributeEquals('Users', 'module', $SugarController);
    }

    public function testloadBean()
    {
        $SugarController = new SugarController();

        //first test with empty parameter and check for null. Default is Home but Home has no bean
        $SugarController->setModule('');
        $SugarController->loadBean();
        self::assertEquals(null, $SugarController->bean);

        //secondly test with module name and check for correct bean class loaded.
        $SugarController->setModule('Users');
        $SugarController->loadBean();
        self::assertInstanceOf('User', $SugarController->bean);
    }

    public function testexecute()
    {
        // suppress output during the test
        $this->setOutputCallback(function () {});

        // test
        $SugarController = new SugarController();

        // replace and use a temporary logger
        $logger = $GLOBALS['log'];
        $GLOBALS['log'] = new TestLogger();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarController->execute();
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        // change back to original logger
        $testLogger = $GLOBALS['log'];
        $GLOBALS['log'] = $logger;

        // exam log
        self::assertTrue(true);
    }

    public function testprocess()
    {
        $SugarController = new SugarController();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarController->process();
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        self::assertTrue(true);
    }

    public function testpre_save()
    {
        if (isset($_SESSION)) {
            $session = $_SESSION;
        }

        $testUserId = 1;
        $query = "SELECT date_modified FROM users WHERE id = '$testUserId' LIMIT 1";
        $row = DBManagerFactory::getInstance()->query($query)->fetch_assoc();
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
            self::assertStringStartsWith('mysqli_query()', $e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        self::assertTrue(true);

        // cleanup
        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }

        $query = "UPDATE users SET date_modified = '$testUserDateModified' WHERE id = '$testUserId' LIMIT 1";
        DBManagerFactory::getInstance()->query($query);
    }

    public function testaction_save()
    {
        if (isset($_SESSION)) {
            $session = $_SESSION;
        }

        $testUserId = 1;
        $query = "SELECT date_modified FROM users WHERE id = '$testUserId' LIMIT 1";
        $row = DBManagerFactory::getInstance()->query($query)->fetch_assoc();
        $testUserDateModified = $row['date_modified'];

        $SugarController = new SugarController();
        $SugarController->setModule('Users');
        $SugarController->record = "1";
        $SugarController->loadBean();

        //execute the method and check if it either works or throws an mysql exception.
        //Fail if it throws any other exception.
        try {
            $SugarController->action_save();
            self::assertTrue(false);
        } catch (Exception $e) {
            self::assertTrue(true);
        }

        self::assertTrue(true);

        // cleanup
        if (isset($session)) {
            $_SESSION = $session;
        } else {
            unset($_SESSION);
        }

        $query = "UPDATE users SET date_modified = '$testUserDateModified' WHERE id = '$testUserId' LIMIT 1";
        DBManagerFactory::getInstance()->query($query);
    }

    public function testaction_spot()
    {
        $SugarController = new SugarController();

        // check with default value of attribute
        self::assertAttributeEquals('classic', 'view', $SugarController);

        // check for attribute value change on method execution.
        $SugarController->action_spot();
        self::assertAttributeEquals('spot', 'view', $SugarController);
    }

    public function testgetActionFilename()
    {
        // check with an invalid value
        $action = SugarController::getActionFilename('');
        self::assertEquals('', $action);

        // check with a valid value
        $action = SugarController::getActionFilename('editview');
        self::assertEquals('EditView', $action);
    }

    public function testcheckEntryPointRequiresAuth()
    {
        $SugarController = new SugarController();

        // check with a invalid value
        $result = $SugarController->checkEntryPointRequiresAuth('');
        self::assertTrue($result);

        // check with a valid True value
        $result = $SugarController->checkEntryPointRequiresAuth('download');
        self::assertTrue($result);

        // check with a valid False value
        $result = $SugarController->checkEntryPointRequiresAuth('GeneratePassword');
        self::assertFalse($result);
    }
}
