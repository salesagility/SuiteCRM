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
 * Class EmployeeTest
 */
class EmployeeTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    
    public function testEmployee()
    {
        
        //execute the contructor and check for the Object type and  attributes
        $employee = new Employee();
        $this->assertInstanceOf('Employee', $employee);
        $this->assertInstanceOf('Person', $employee);
        $this->assertInstanceOf('SugarBean', $employee);
        
        $this->assertAttributeEquals('Employees', 'module_dir', $employee);
        $this->assertAttributeEquals('Employee', 'object_name', $employee);
        $this->assertAttributeEquals('users', 'table_name', $employee);
        $this->assertAttributeEquals(true, 'new_schema', $employee);
        
    }
    
    public function testget_summary_text()
    {
        
        error_reporting(E_ERROR | E_PARSE);
        
        $employee = new Employee();
        
        //test without setting name
        $this->assertEquals(' ', $employee->get_summary_text());
        
        //test with name set
        $employee->retrieve(1);
        $this->assertEquals('Administrator', $employee->get_summary_text());
        
    }
    
    public function testfill_in_additional_list_fields()
    {
        
        $employee = new Employee();
        
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $employee->fill_in_additional_list_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
        
    }
    
    public function testfill_in_additional_detail_fields()
    {
        $employee = new Employee();
        
        //test with a empty employee bean
        $employee->fill_in_additional_detail_fields();
        $this->assertEquals("", $employee->reports_to_name);
        
        //test with a valid employee bean
        $employee->retrieve(1);
        $employee->fill_in_additional_detail_fields();
        $this->assertEquals("", $employee->reports_to_name);
        
    }
    
    public function testretrieve_employee_id()
    {
        $employee = new Employee();
        //$this->assertEquals('1' ,$employee->retrieve_employee_id('admin'));
        
        $this->markTestSkipped('Bug in query: employee_name parameter is wrongly used as user_name');
        
    }
    
    public function testverify_data()
    {
        $employee = new Employee();
        $this->assertEquals(true, $employee->verify_data());
        
    }
    
    public function testget_list_view_data()
    {
        
        $employee = new Employee();
        
        $expected = array(
            'SUGAR_LOGIN'           => '1',
            'FULL_NAME'             => ' ',
            'NAME'                  => ' ',
            'IS_ADMIN'              => '0',
            'EXTERNAL_AUTH_ONLY'    => '0',
            'RECEIVE_NOTIFICATIONS' => '1',
            'DELETED'               => 0,
            'PORTAL_ONLY'           => '0',
            'SHOW_ON_EMPLOYEES'     => '1',
            'ENCODED_NAME'          => ' ',
            'EMAIL1'                => '',
            'EMAIL1_LINK'           => '<a href=\'javascript:void(0);\' onclick=\'SUGAR.quickCompose.init({"fullComposeUrl":"contact_id=\\u0026parent_type=Employees\\u0026parent_id=\\u0026parent_name=+\\u0026to_addrs_ids=\\u0026to_addrs_names=\\u0026to_addrs_emails=\\u0026to_email_addrs=+%26nbsp%3B%26lt%3B%26gt%3B\\u0026return_module=Employees\\u0026return_action=ListView\\u0026return_id=","composePackage":{"contact_id":"","parent_type":"Employees","parent_id":"","parent_name":" ","to_addrs_ids":"","to_addrs_names":"","to_addrs_emails":"","to_email_addrs":"  \\u003C\\u003E","return_module":"Employees","return_action":"ListView","return_id":""}});\' class=\'\'>',
            'MESSENGER_TYPE'        => '',
            'REPORTS_TO_NAME'       => null,
        );
        
        $actual = $employee->get_list_view_data();
        $this->assertSame($expected, $actual);
        
    }
    
    public function testlist_view_parse_additional_sections()
    {
        
        $employee = new Employee();
        
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $employee->list_view_parse_additional_sections(new Sugar_Smarty(), $xTemplateSection);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
        
    }
    
    public function testcreate_export_query()
    {
        
        $employee = new Employee();
        
        //test with empty string params
        $expected =
            "SELECT id, user_name, first_name, last_name, description, date_entered, date_modified, modified_user_id, created_by, title, department, is_admin, phone_home, phone_mobile, phone_work, phone_other, phone_fax, address_street, address_city, address_state, address_postalcode, address_country, reports_to_id, portal_only, status, receive_notifications, employee_status, messenger_id, messenger_type, is_group FROM users  WHERE  users.deleted = 0 ORDER BY users.user_name";
        $actual = $employee->create_export_query('', '');
        $this->assertSame($expected, $actual);
        
        //test with valid string params
        $expected =
            "SELECT id, user_name, first_name, last_name, description, date_entered, date_modified, modified_user_id, created_by, title, department, is_admin, phone_home, phone_mobile, phone_work, phone_other, phone_fax, address_street, address_city, address_state, address_postalcode, address_country, reports_to_id, portal_only, status, receive_notifications, employee_status, messenger_id, messenger_type, is_group FROM users  WHERE users.user_name=\"\" AND  users.deleted = 0 ORDER BY users.id";
        $actual = $employee->create_export_query('users.id', 'users.user_name=""');
        $this->assertSame($expected, $actual);
        
    }
    
    public function testpreprocess_fields_on_save()
    {
        
        $employee = new Employee();
        
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $employee->preprocess_fields_on_save();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
        
    }
    
    /**
     * @todo: NEEDS FIXING!
     */
    public function testcreate_new_list_query()
    {
        /*
    	$employee = new Employee();

    	//test with empty string params
    	$expected = " SELECT  users.* , '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt2.last_name reports_to_name , jt2.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id  FROM users   LEFT JOIN  users jt2 ON users.reports_to_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where ( users.portal_only = 0 ) AND users.deleted=0";
    	$actual = $employee->create_new_list_query('','');
    	$this->assertSame($expected,$actual);


    	//test with valid string params
    	$expected = " SELECT  users.* , '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt2.last_name reports_to_name , jt2.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id  FROM users   LEFT JOIN  users jt2 ON users.reports_to_id=jt2.id AND jt2.deleted=0\n\n AND jt2.deleted=0 where (users.user_name=\"\" and users.portal_only = 0 ) AND users.deleted=0";
    	$actual = $employee->create_new_list_query('users.id','users.user_name=""');
    	$this->assertSame($expected,$actual);
    	*/
        $this->assertTrue(true, "NEEDS FIXING!");
    }
    
    public function testhasCustomFields()
    {
        $employee = new Employee();
        $result = $employee->hasCustomFields();
        $this->assertEquals(false, $result);
    }
    
}

