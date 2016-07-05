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
 * Class AOP_Case_UpdatesTest
 */
class AOP_Case_UpdatesTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOP_Case_Updates()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $aopCaseUpdates = new AOP_Case_Updates();
        $this->assertInstanceOf('AOP_Case_Updates', $aopCaseUpdates);
        $this->assertInstanceOf('Basic', $aopCaseUpdates);
        $this->assertInstanceOf('SugarBean', $aopCaseUpdates);
    
        $this->assertAttributeEquals('AOP_Case_Updates', 'module_dir', $aopCaseUpdates);
        $this->assertAttributeEquals('AOP_Case_Updates', 'object_name', $aopCaseUpdates);
        $this->assertAttributeEquals('aop_case_updates', 'table_name', $aopCaseUpdates);
        $this->assertAttributeEquals(true, 'new_schema', $aopCaseUpdates);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aopCaseUpdates);
        $this->assertAttributeEquals(false, 'importable', $aopCaseUpdates);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aopCaseUpdates);
    }
    
    public function testsave()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aopCaseUpdates = new AOP_Case_Updates();
        $aopCaseUpdates->name = 'test name';
        $aopCaseUpdates->description = 'test description';
        $aopCaseUpdates->case_id = 'test case id';
        $aopCaseUpdates->contact_id = 'test id';
        $aopCaseUpdates->internal = 1;
        $aopCaseUpdates->save();
    
        //test for record ID to verify that record is saved
        $this->assertEquals(36, strlen($aopCaseUpdates->id));
    
        //mark the record as deleted for cleanup 
        $aopCaseUpdates->mark_deleted($aopCaseUpdates->id);
    }
    
    public function testgetCase()
    {
        $aopCaseUpdates = new AOP_Case_Updates();
    
        //execute the method and verify that it returns a Case object
        $result = $aopCaseUpdates->getCase();
    
        $this->assertInstanceOf('aCase', $result);
    }
    
    public function testgetContacts()
    {
        $aopCaseUpdates = new AOP_Case_Updates();
    
        //execute the method and verify that it returns an array
        $result = $aopCaseUpdates->getContacts();
        $this->assertTrue(is_array($result));
    }
    
    public function testgetUpdateContact()
    {
        $aopCaseUpdates = new AOP_Case_Updates();
    
        //execute the method without contact_id and verify that it returns null
        $result = $aopCaseUpdates->getUpdateContact();
        $this->assertEquals(null, $result);
    
        //execute the method without contact_id and verify that it returns false
        $aopCaseUpdates->contact_id = 1;
        $result = $aopCaseUpdates->getUpdateContact();
        $this->assertEquals(false, $result);
    }
    
    public function testgetUser()
    {
        $aopCaseUpdates = new AOP_Case_Updates();
    
        //execute the method and verify that it returns an instance of User
        $result = $aopCaseUpdates->getUser();
        $this->assertInstanceOf('User', $result);
    }
    
    public function testgetUpdateUser()
    {
        $aopCaseUpdates = new AOP_Case_Updates();
    
        //execute the method and verify that it returns an instance of User
        $result = $aopCaseUpdates->getUpdateUser();
        $this->assertInstanceOf('User', $result);
    }
}
