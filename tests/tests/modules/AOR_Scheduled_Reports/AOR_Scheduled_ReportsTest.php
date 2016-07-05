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
 * Class AOR_Scheduled_ReportsTest
 */
class AOR_Scheduled_ReportsTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    
    public function testAOR_Scheduled_Reports()
    {
        
        //execute the contructor and check for the Object type and  attributes
        $aorScheduledReports = new AOR_Scheduled_Reports();
        $this->assertInstanceOf('AOR_Scheduled_Reports', $aorScheduledReports);
        $this->assertInstanceOf('Basic', $aorScheduledReports);
        $this->assertInstanceOf('SugarBean', $aorScheduledReports);
        
        $this->assertAttributeEquals('AOR_Scheduled_Reports', 'module_dir', $aorScheduledReports);
        $this->assertAttributeEquals('AOR_Scheduled_Reports', 'object_name', $aorScheduledReports);
        $this->assertAttributeEquals('aor_scheduled_reports', 'table_name', $aorScheduledReports);
        $this->assertAttributeEquals(true, 'new_schema', $aorScheduledReports);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aorScheduledReports);
        $this->assertAttributeEquals(false, 'importable', $aorScheduledReports);
        
    }
    
    public function testbean_implements()
    {
        
        error_reporting(E_ERROR | E_PARSE);
        
        $aorScheduledReports = new AOR_Scheduled_Reports();
        $this->assertEquals(false, $aorScheduledReports->bean_implements('')); //test with blank value
        $this->assertEquals(false, $aorScheduledReports->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $aorScheduledReports->bean_implements('ACL')); //test with valid value
        
    }
    
    public function testSaveAndGet_email_recipients()
    {
        
        $aorScheduledReports = new AOR_Scheduled_Reports();
        $aorScheduledReports->name = "test";
        $aorScheduledReports->description = "test description";
        $_POST['email_recipients'] = Array('email_target_type' => array('Email Address', 'all', 'Specify User'),
                                           'email'             => array('test@test.com', '', '1'),
        );
        
        //test save and test for record ID to verify that record is saved
        $aorScheduledReports->save();
        $this->assertTrue(isset($aorScheduledReports->id));
        $this->assertEquals(36, strlen($aorScheduledReports->id));
        
        //test get_email_recipients
        $expected = array('test@test.com', '', '1');
        $aorScheduledReports->retrieve($aorScheduledReports->id);
        $emails = $aorScheduledReports->get_email_recipients();
        
        $this->assertTrue(is_array($emails));
        $this->assertEquals('test@test.com', $emails[0]);
        
        $aorScheduledReports->mark_deleted($aorScheduledReports->id);
        unset($aorScheduledReports);
        
    }
    
    public function testshouldRun()
    {
        
        $aorScheduledReports = new AOR_Scheduled_Reports();
        $aorScheduledReports->schedule = " 8 * * * *";
        
        //test without a last_run date
        //@todo: NEEDS FIXING - are we sure?
        //$this->assertFalse($aorScheduledReports->shouldRun(new DateTime()) );
        
        //test without a older last_run date
        $aorScheduledReports->last_run = date("d-m-y H:i:s", mktime(0, 0, 0, 10, 3, 2014));
        $this->assertTrue($aorScheduledReports->shouldRun(new DateTime()));
        
        //test without a current last_run date
        $aorScheduledReports->last_run = new DateTime();
        $this->assertFalse($aorScheduledReports->shouldRun(new DateTime()));
        
    }
    
}
