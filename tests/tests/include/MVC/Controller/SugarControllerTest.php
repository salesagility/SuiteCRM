<?php


class SugarControllerTest  extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testsetup()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        
        // test
        
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
        
        // clean up
        
        $state->popTable('users');
    }

    public function testsetModule()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        
        // test
        
        $SugarController = new SugarController();

        //first test with empty parameter
        $SugarController->setModule('');
        $this->assertAttributeEquals('', 'module', $SugarController);

        //secondly test with module name and check for correct assignment.
        $SugarController->setModule('Users');
        $this->assertAttributeEquals('Users', 'module', $SugarController);
        
        // clean up
        
        $state->popTable('users');
    }

    public function testloadBean()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        
        // test
        
        $SugarController = new SugarController();

        //first test with empty parameter and check for null. Default is Home but Home has no bean
        $SugarController->setModule('');
        $SugarController->loadBean();
        $this->assertEquals(null, $SugarController->bean);

        //secondly test with module name and check for correct bean class loaded.
        $SugarController->setModule('Users');
        $SugarController->loadBean();
        $this->assertInstanceOf('User', $SugarController->bean);
        
        // clean up
        
        $state->popTable('users');
    }

    public function testexecute()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        
        // test
        
        $SugarController = new SugarController();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarController->execute();
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }

        $this->assertTrue(true);
        
        // clean up
        
        $state->popTable('users');
    }

    public function testprocess()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        
        // test
        
        $SugarController = new SugarController();

        //execute the method and check if it works and doesn't throws an exception
        try {
            $SugarController->process();
        } catch (Exception $e) {
            $this->fail("\nException: " . get_class($e) . ": " . $e->getMessage() . "\nin " . $e->getFile() . ':' . $e->getLine() . "\nTrace:\n" . $e->getTraceAsString() . "\n");
        }

        $this->assertTrue(true);
        
        // clean up
        
        $state->popTable('users');
    }

    public function testpre_save()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushGlobals();
        
        // test
        
        $SugarController = new SugarController();
        $SugarController->setModule('Users');
        $SugarController->loadBean();

        //execute the method and check if it either works or throws an mysql exception.
        //Fail if it throws any other exception.
        try {
            $SugarController->pre_save();
        } catch (Exception $e) {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage());
        }

        $this->assertTrue(true);
        
        // clean up
        
        $state->popGlobals();
        $state->popTable('users');
    }

    public function testaction_save()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        
        // test
        
        $SugarController = new SugarController();
        $SugarController->setModule('Users');
        $SugarController->loadBean();

        //execute the method and check if it either works or throws an mysql exception.
        //Fail if it throws any other exception.
        try {
            $SugarController->action_save();
        } catch (Exception $e) {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage());
        }

        $this->assertTrue(true);
        
        // clean up
        
        $state->popTable('aod_index');
        $state->popTable('users');
    }

    public function testaction_spot()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        
        // test
        
        $SugarController = new SugarController();

        //first check with default value of attribute
        $this->assertAttributeEquals('classic', 'view', $SugarController);

        //secondly check for attribute value change on method execution.
        $SugarController->action_spot();
        $this->assertAttributeEquals('spot', 'view', $SugarController);
        
        // clean up
        
        $state->popTable('users');
    }

    public function testgetActionFilename()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        
        // test
        

        //first check with a invalid value
        $action = SugarController::getActionFilename('');
        $this->assertEquals('', $action);

        //secondly check with a valid value
        $action = SugarController::getActionFilename('editview');
        $this->assertEquals('EditView', $action);
        
        // clean up
        
        $state->popTable('users');
    }

    public function testcheckEntryPointRequiresAuth()
    {
        // store state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushTable('users');
        
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
        
        $state->popTable('users');
    }
}
