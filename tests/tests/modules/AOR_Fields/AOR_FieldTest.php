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
 * Class AOR_FieldTest
 */
class AOR_FieldTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOR_Field()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $aor_Field = new AOR_Field();
        $this->assertInstanceOf('AOR_Field', $aor_Field);
        $this->assertInstanceOf('Basic', $aor_Field);
        $this->assertInstanceOf('SugarBean', $aor_Field);
    
        $this->assertAttributeEquals('AOR_Fields', 'module_dir', $aor_Field);
        $this->assertAttributeEquals('AOR_Field', 'object_name', $aor_Field);
        $this->assertAttributeEquals('aor_fields', 'table_name', $aor_Field);
        $this->assertAttributeEquals(true, 'new_schema', $aor_Field);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aor_Field);
        $this->assertAttributeEquals(true, 'importable', $aor_Field);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aor_Field);
    }
    
    public function testsave_lines()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aor_Field = new AOR_Field();
    
        //preset the required data 
        $post_data = array();
        $post_data['field'][] = 'test field';
        $post_data['name'][] = 'test';
        $post_data['module_path'][] = 'test path';
        $post_data['display'][] = '1';
        $post_data['link'][] = '1';
        $post_data['label'][] = 'test label';
        $post_data['field_function'][] = 'test function';
        $post_data['total'][] = 'total';
        $post_data['group_by'][] = '1';
        $post_data['group_order'][] = 'desc';
        $post_data['group_display'][] = '1';
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $aor_Field->save_lines($post_data, new AOR_Report());
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
}
