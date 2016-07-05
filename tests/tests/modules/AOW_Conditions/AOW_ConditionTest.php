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
 * Class AOW_ConditionTest
 */
class AOW_ConditionTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOW_Condition()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $aowCondition = new AOW_Condition();
        $this->assertInstanceOf('AOW_Condition', $aowCondition);
        $this->assertInstanceOf('Basic', $aowCondition);
        $this->assertInstanceOf('SugarBean', $aowCondition);
    
        $this->assertAttributeEquals('AOW_Conditions', 'module_dir', $aowCondition);
        $this->assertAttributeEquals('AOW_Condition', 'object_name', $aowCondition);
        $this->assertAttributeEquals('aow_conditions', 'table_name', $aowCondition);
        $this->assertAttributeEquals(true, 'new_schema', $aowCondition);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aowCondition);
        $this->assertAttributeEquals(false, 'importable', $aowCondition);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aowCondition);
    }
    
    public function testbean_implements()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aowCondition = new AOW_Condition();
        $this->assertEquals(false, $aowCondition->bean_implements('')); //test with blank value
        $this->assertEquals(false, $aowCondition->bean_implements('test')); //test with invalid value
        $this->assertEquals(false, $aowCondition->bean_implements('ACL')); //test with valid value
    }
    
    public function testsave_lines()
    {
        $aowCondition = new AOW_Condition();
    
        //populate required values
        $post_data = array();
        $post_data['name'] = array('test1', 'test2');
        $post_data['field'] = array('field1', 'field2');
        $post_data['operator'] = array('=', '!=');
        $post_data['value_type'] = array('int', 'string');
        $post_data['value'] = array('1', 'abc');
    
        //create parent bean
        $aowWorkFlow = new AOW_WorkFlow();
        $aowWorkFlow->id = 1;
    
        $aowCondition->save_lines($post_data, $aowWorkFlow);
    
        //get the linked beans and verify if records created
        $aow_conditions = $aowWorkFlow->get_linked_beans('aow_conditions', $aowWorkFlow->object_name);
        $this->assertEquals(count($post_data['field']), count($aow_conditions));
    
        //cleanup afterwards
        foreach ($aow_conditions as $lineItem)
        {
            $lineItem->mark_deleted($lineItem->id);
        }
    }
}
