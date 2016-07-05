<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2016 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

/**
 * Class SugarControllerTest
 */
class SugarControllerTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
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
    
        //execute the method and check if it works and doesn't throws an exception
        try
        {
            $SugarController->execute();
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->assertTrue(true);
    }
    
    public function testprocess()
    {
        $SugarController = new SugarController();
    
        //execute the method and check if it works and doesn't throws an exception
        try
        {
            $SugarController->process();
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->assertTrue(true);
    }
    
    public function testpre_save()
    {
        $SugarController = new SugarController();
        $SugarController->setModule('Users');
        $SugarController->loadBean();
    
        //execute the method and check if it either works or throws an mysql exception.
        //Fail if it throws any other exception.
        try
        {
            $SugarController->pre_save();
        }
        catch(Exception $e)
        {
            $this->assertStringStartsWith('mysqli_query()', $e->getMessage());
        }
    
        $this->assertTrue(true);
    }
    
    public function testaction_save()
    {
        $SugarController = new SugarController();
        $SugarController->setModule('Users');
        $SugarController->loadBean();
    
        //execute the method and check if it either works or throws an mysql exception.
        //Fail if it throws any other exception.
        try
        {
            $SugarController->action_save();
        }
        catch(Exception $e)
        {
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
