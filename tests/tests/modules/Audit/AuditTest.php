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

require_once 'modules/Audit/Audit.php';

/**
 * Class AuditTest
 */
class AuditTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAudit()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        //execute the contructor and check for the Object type and  attributes
        $audit = new Audit();
        $this->assertInstanceOf('Audit', $audit);
        $this->assertInstanceOf('SugarBean', $audit);
        $this->assertAttributeEquals('Audit', 'module_dir', $audit);
        $this->assertAttributeEquals('Audit', 'object_name', $audit);
    }
    
    public function testget_summary_text()
    {
        $audit = new Audit();
    
        //test without setting name
        $this->assertEquals(null, $audit->get_summary_text());
    
        //test with name set
        $audit->name = 'test';
        $this->assertEquals('test', $audit->get_summary_text());
    }
    
    public function testcreate_export_query()
    {
        $audit = new Audit();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $audit->create_export_query('', '');
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation');
    }
    
    public function testfill_in_additional_list_fields()
    {
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $audit->fill_in_additional_list_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation');
    }
    
    public function testfill_in_additional_detail_fields()
    {
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $audit->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation');
    }
    
    public function testfill_in_additional_parent_fields()
    {
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $audit->fill_in_additional_parent_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation');
    }
    
    public function testget_list_view_data()
    {
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $audit->get_list_view_data();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation');
    }
    
    public function testget_audit_link()
    {
        $audit = new Audit();
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $audit->get_audit_link();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('method has no implementation');
    }
    
    public function testget_audit_list()
    {
        global $focus;
        $focus = new Account(); //use audit enabbled module object
    
        $audit = new Audit();
    
        //execute the method and verify that it returns an array
        $result = $audit->get_audit_list();
        $this->assertTrue(is_array($result));
    }
    
    public function testgetAssociatedFieldName()
    {
        global $focus;
        $focus = new Account(); //use audit enabbled module object
    
        $audit = new Audit();
    
        //test with name field
        $result = $audit->getAssociatedFieldName('name', '1');
        $this->assertEquals('1', $result);
    
        //test with parent_id field
        $result = $audit->getAssociatedFieldName('parent_id', '1');
        $this->assertEquals(null, $result);
    }
}
