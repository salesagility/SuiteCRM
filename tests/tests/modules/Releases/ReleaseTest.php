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
 * Class ReleaseTest
 */
class ReleaseTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testRelease()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $release = new Release();
    
        $this->assertInstanceOf('Release', $release);
        $this->assertInstanceOf('SugarBean', $release);
    
        $this->assertAttributeEquals('releases', 'table_name', $release);
        $this->assertAttributeEquals('Releases', 'module_dir', $release);
        $this->assertAttributeEquals('Release', 'object_name', $release);
    
        $this->assertAttributeEquals(true, 'new_schema', $release);
    }
    
    public function testget_summary_text()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $release = new Release();
    
        //test without setting name
        $this->assertEquals(null, $release->get_summary_text());
    
        //test with name set
        $release->name = 'test';
        $this->assertEquals('test', $release->get_summary_text());
    }
    
    public function testget_releases()
    {
        $release = new Release();
    
        //test with default params
        $result = $release->get_releases();
        $this->assertTrue(is_array($result));
    
        //test with custom params
        $result = $release->get_releases(true, 'Hidden', 'name is not null');
        $this->assertTrue(is_array($result));
    }
    
    public function testfill_in_additional_list_fields()
    {
        $release = new Release();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $release->fill_in_additional_list_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testfill_in_additional_detail_fields()
    {
        $release = new Release();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $release->fill_in_additional_detail_fields();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testget_list_view_data()
    {
        $release = new Release();
    
        $release->name = 'test';
        $release->status = 'Hidden';
    
        $expected = array(
            'NAME'           => 'test',
            'STATUS'         => 'Hidden',
            'ENCODED_NAME'   => 'test',
            'ENCODED_STATUS' => null,
        );
    
        $actual = $release->get_list_view_data();
    
        $this->assertSame($expected, $actual);
    }
    
    public function testbuild_generic_where_clause()
    {
        $release = new Release();
    
        //test with empty string params
        $expected = "name like '%'";
        $actual = $release->build_generic_where_clause('');
        $this->assertSame($expected, $actual);
    
        //test with valid string params
        $expected = "name like '%'";
        $actual = $release->build_generic_where_clause('test');
        $this->assertSame($expected, $actual);
    }
}
