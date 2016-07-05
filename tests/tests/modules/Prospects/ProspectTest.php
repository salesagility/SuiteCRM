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
 * Class ProspectTest
 */
class ProspectTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testProspect()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $prospect = new Prospect();
    
        $this->assertInstanceOf('Prospect', $prospect);
        $this->assertInstanceOf('Person', $prospect);
        $this->assertInstanceOf('SugarBean', $prospect);
    
        $this->assertAttributeEquals('prospects', 'table_name', $prospect);
        $this->assertAttributeEquals('Prospects', 'module_dir', $prospect);
        $this->assertAttributeEquals('Prospect', 'object_name', $prospect);
    
        $this->assertAttributeEquals(true, 'new_schema', $prospect);
        $this->assertAttributeEquals(true, 'importable', $prospect);
    }
    
    public function testfill_in_additional_list_fields()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $prospect = new Prospect();
    
        $prospect->salutation = 'mr';
        $prospect->title = 'lastn firstn';
        $prospect->first_name = 'first';
        $prospect->first_name = 'last';
        $prospect->email1 = 'email1@test.com';
    
        $prospect->fill_in_additional_list_fields();
    
        $this->assertAttributeEquals('last', 'full_name', $prospect);
        $this->assertAttributeEquals('last &lt;email1@test.com&gt;', 'email_and_name1', $prospect);
    }
    
    public function testfill_in_additional_detail_fields()
    {
        $prospect = new Prospect();
    
        $prospect->salutation = 'mr';
        $prospect->title = 'lastn firstn';
        $prospect->first_name = 'first';
        $prospect->first_name = 'last';
        $prospect->email1 = 'email1@test.com';
    
        $prospect->fill_in_additional_detail_fields();
    
        $this->assertAttributeEquals('last', 'full_name', $prospect);
    }
    
    public function testbuild_generic_where_clause()
    {
        $prospect = new Prospect();
    
        //test with empty string params
        $expected = "prospects.last_name like '%' or prospects.first_name like '%' or prospects.assistant like '%'";
        $actual = $prospect->build_generic_where_clause('');
        $this->assertSame($expected, $actual);
    
        //test with valid string params
        $expected = "prospects.last_name like '%' or prospects.first_name like '%' or prospects.assistant like '%'";
        $actual = $prospect->build_generic_where_clause('1');
        $this->assertSame($expected, $actual);
    }
    
    public function testconverted_prospect()
    {
        $prospect = new Prospect();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            //$prospect->converted_prospect('1', '2', '3', '4');
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    
        $this->markTestIncomplete('Multiple errors in query');
    }
    
    public function testbean_implements()
    {
        $prospect = new Prospect();
    
        $this->assertEquals(false, $prospect->bean_implements('')); //test with blank value
        $this->assertEquals(false, $prospect->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $prospect->bean_implements('ACL')); //test with valid value
    }
    
    public function testretrieveTargetList()
    {
        $prospect = new Prospect();
    
        $result = $prospect->retrieveTargetList('', array('id', 'first_name'), 0, 1, 1, 0, 'Accounts');
        $this->assertTrue(is_array($result));
    }
    
    public function testretrieveTarget()
    {
        $prospect = new Prospect();
    
        $result = $prospect->retrieveTarget('');
        $this->assertEquals(null, $result);
    }
    
    public function testget_unlinked_email_query()
    {
        $prospect = new Prospect();
    
        $expected =
            "SELECT emails.id FROM emails  JOIN (select DISTINCT email_id from emails_email_addr_rel eear\n\n	join email_addr_bean_rel eabr on eabr.bean_id ='' and eabr.bean_module = 'Prospects' and\n	eabr.email_address_id = eear.email_address_id and eabr.deleted=0\n	where eear.deleted=0 and eear.email_id not in\n	(select eb.email_id from emails_beans eb where eb.bean_module ='Prospects' and eb.bean_id = '')\n	) derivedemails on derivedemails.email_id = emails.id";
        $actual = $prospect->get_unlinked_email_query();
        $this->assertSame($expected, $actual);
    }
}
