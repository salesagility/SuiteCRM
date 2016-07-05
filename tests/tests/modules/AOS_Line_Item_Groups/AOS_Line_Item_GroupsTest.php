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
 * Class AOS_Line_Item_GroupsTest
 */
class AOS_Line_Item_GroupsTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOS_Line_Item_Groups()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $aosLineItemGroup = new AOS_Line_Item_Groups();
        $this->assertInstanceOf('AOS_Line_Item_Groups', $aosLineItemGroup);
        $this->assertInstanceOf('Basic', $aosLineItemGroup);
        $this->assertInstanceOf('SugarBean', $aosLineItemGroup);
    
        $this->assertAttributeEquals('AOS_Line_Item_Groups', 'module_dir', $aosLineItemGroup);
        $this->assertAttributeEquals('AOS_Line_Item_Groups', 'object_name', $aosLineItemGroup);
        $this->assertAttributeEquals('aos_line_item_groups', 'table_name', $aosLineItemGroup);
        $this->assertAttributeEquals(true, 'new_schema', $aosLineItemGroup);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aosLineItemGroup);
        $this->assertAttributeEquals(true, 'importable', $aosLineItemGroup);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aosLineItemGroup);
    }
    
    public function testsave_groups()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aosLineItemGroup = new AOS_Line_Item_Groups();
    
        //populate required values		
        $post_data = array();
        $post_data['group_number'] = array(0, 0);
        $post_data['name'] = array('test1', 'test2');
        $post_data['total_amount'] = array('100', '200');
        $post_data['total_amount_usdollar'] = array('100', '200');
    
        //create parent bean for line item groups
        $aosContract = new AOS_Contracts();
        $aosContract->id = 1;
    
        $aosLineItemGroup->save_groups($post_data, $aosContract);
    
        //get the linked beans and verify if records created
        $line_item_groups = $aosContract->get_linked_beans('aos_line_item_groups', $aosContract->object_name);
    
        $this->assertEquals(count($post_data['group_number']), count($line_item_groups));
    
        //cleanup afterwards
        foreach ($line_item_groups as $lineItem)
        {
            $lineItem->mark_deleted($lineItem->id);
        }
    }
    
    public function testsave()
    {
        $aosLineItemGroup = new AOS_Line_Item_Groups();
        $aosLineItemGroup->name = 'test';
        $aosLineItemGroup->total_amount = 100;
        $aosLineItemGroup->total_amount_usdollar = 100;
    
        $aosLineItemGroup->save();
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($aosLineItemGroup->id));
        $this->assertEquals(36, strlen($aosLineItemGroup->id));
    
        //mark the record as deleted and verify that this record cannot be retrieved anymore.
        $aosLineItemGroup->mark_deleted($aosLineItemGroup->id);
        $result = $aosLineItemGroup->retrieve($aosLineItemGroup->id);
        $this->assertEquals(null, $result);
    }
}
