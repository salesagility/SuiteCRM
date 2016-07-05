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
 * Class AOS_Product_CategoriesTest
 */
class AOS_Product_CategoriesTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOS_Product_Categories()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $aosProductCategories = new AOS_Product_Categories();
        $this->assertInstanceOf('AOS_Product_Categories', $aosProductCategories);
        $this->assertInstanceOf('Basic', $aosProductCategories);
        $this->assertInstanceOf('SugarBean', $aosProductCategories);
    
        $this->assertAttributeEquals('AOS_Product_Categories', 'module_dir', $aosProductCategories);
        $this->assertAttributeEquals('AOS_Product_Categories', 'object_name', $aosProductCategories);
        $this->assertAttributeEquals('aos_product_categories', 'table_name', $aosProductCategories);
        $this->assertAttributeEquals(true, 'new_schema', $aosProductCategories);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosProductCategories);
        $this->assertAttributeEquals(true, 'importable', $aosProductCategories);
    }
    
    public function testsave()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aosProductCategories = new AOS_Product_Categories();
        $aosProductCategories->name = 'test';
        $aosProductCategories->parent_category_id = 1;
    
        $aosProductCategories->save();
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aosProductCategories->id));
        $this->assertEquals(36, strlen($aosProductCategories->id));
    
        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosProductCategories->mark_deleted($aosProductCategories->id);
        $result = $aosProductCategories->retrieve($aosProductCategories->id);
        $this->assertEquals(null, $result);
    }
}
