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
 * Class AOS_ContractsTest
 */
class AOS_ContractsTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOS_Contracts()
    {
    
        //execute the contructor and check for the Object type and attributes
        $aosContracts = new AOS_Contracts();
        $this->assertInstanceOf('AOS_Contracts', $aosContracts);
        $this->assertInstanceOf('Basic', $aosContracts);
        $this->assertInstanceOf('SugarBean', $aosContracts);
    
        $this->assertAttributeEquals('AOS_Contracts', 'module_dir', $aosContracts);
        $this->assertAttributeEquals('AOS_Contracts', 'object_name', $aosContracts);
        $this->assertAttributeEquals('aos_contracts', 'table_name', $aosContracts);
        $this->assertAttributeEquals(true, 'new_schema', $aosContracts);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosContracts);
        $this->assertAttributeEquals(true, 'importable', $aosContracts);
    
        $this->assertTrue(isset($aosContracts->renewal_reminder_date));
    }
    
    public function testsaveAndDelete()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aosContracts = new AOS_Contracts();
        $aosContracts->name = 'test';
    
        $aosContracts->save();
    
        //test for record ID to verify that record is saved 
        $this->assertTrue(isset($aosContracts->id));
        $this->assertEquals(36, strlen($aosContracts->id));
    
        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosContracts->mark_deleted($aosContracts->id);
        $result = $aosContracts->retrieve($aosContracts->id);
        $this->assertEquals(null, $result);
    }
    
    public function testCreateReminderAndCreateLinkAndDeleteCall()
    {
        $call = new call();
    
        $aosContracts = new AOS_Contracts();
        $aosContracts->name = 'test';
    
        //test createReminder() 
        $aosContracts->createReminder();
    
        //verify record ID to check that record is saved
        $this->assertTrue(isset($aosContracts->call_id));
        $this->assertEquals(36, strlen($aosContracts->call_id));
    
        //verify the parent_type value set by createReminder()
        $call->retrieve($aosContracts->call_id);
        $this->assertAttributeEquals('AOS_Contracts', 'parent_type', $call);
    
        //test createLink() and verify the parent_type value
        $aosContracts->createLink();
        $call->retrieve($aosContracts->call_id);
        $this->assertAttributeEquals('Accounts', 'parent_type', $call);
    
        //delete the call and verify that this record cannot be retrieved anymore.		
        $aosContracts->deleteCall();
        $call->retrieve($aosContracts->call_id);
        $this->assertEquals(null, $result);
    }
}
