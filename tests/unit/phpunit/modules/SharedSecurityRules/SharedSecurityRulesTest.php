<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */


/**
 * SharedSecurityRulesTest
 *
 * @author gyula
 */
class SharedSecurityRulesTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract {
    
    public function testBeanImplementsIfNotImplemented() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $result = $ssr->bean_implements('should_not_implemented_for_test');
        $this->assertFalse($result);
    }
    
    public function testSave() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $id = $ssr->save();
        $this->assertTrue(isValidId($id));
    }
    
    public function testCheckRules() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
    }
    
    public function testGetParenthesisConditions() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $ret = $ssr->getPrimaryFieldDefinition();
        $this->assertEquals([
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'id',
            'required' => true,
            'reportable' => true,
            'comment' => 'Unique identifier',
            'inline_edit' => false,
                ], $ret);
    }

    public function testBuildRuleWhere() {
        $acc = BeanFactory::getBean('Accounts');
        $ret = SharedSecurityRules::buildRuleWhere($acc);
        $this->assertEquals([
            'resWhere' => '',
            'addWhere' => '',
                ], $ret);
    }

    public function testCheckHistory() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $ret = $ssr->checkHistory($acc, 'name', 'test');
        $this->assertEquals(null, $ret);
    }
    
    public function testChangeOperator() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $ret = $ssr->checkHistory($acc, 'incorrect_value', 'incorrect_reverse');
        $this->assertEquals(null, $ret);
    }
    
    public function testGetFieldDefs() {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $ret = $ssr->getFieldDefs(array(), 'module_not_exists');
        $this->assertEquals(['' => ''], $ret);
    }
    
}
