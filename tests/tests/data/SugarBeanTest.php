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

include_once __DIR__ . '/../../../modules/ACLActions/ACLAction.php';
include_once __DIR__ . '/../../../modules/AM_ProjectTemplates/AM_ProjectTemplates_sugar.php';

class SugarBeanTest  extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract {
        
    
    public function testCreateNewListQueryWithCustomVarDefHandlerOverride() {
                
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
                
        // test
        $user = new User();
        $user->name = 'tester10';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
           
        // test
        $tmpUser = new User();
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        
        if (!file_exists('custom')) {
            mkdir('custom');
        }
        if (!file_exists('custom/include')) {
            mkdir('custom/include');
        }
        if (!file_exists('custom/include/VarDefHandler')) {
            mkdir('custom/include/VarDefHandler');
        }
        copy('include/VarDefHandler/listvardefoverride.php', 'custom/include/VarDefHandler/listvardefoverride.php');
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        
        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.* , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt0.last_name reports_to_name , jt0.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id  FROM users   LEFT JOIN  users jt0 ON users.reports_to_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0 where ( ( users.created_by ='{$current_user->id}'  or  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) ) AND users.deleted=0", $results);        
        
                
        // clean up
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
        
    }
          

    public function testCreateNewListQueryWithNoOwnerWhere() {
        
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
        
        // test
        $user = new User();
        $user->name = 'tester9';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
               
        
        // test
        
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        $tmpUser->field_defs['created_by'] = null;
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        $this->assertEmpty($tmpUser->getOwnerWhere($current_user->id));
        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.* , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt0.last_name reports_to_name , jt0.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id  FROM users   LEFT JOIN  users jt0 ON users.reports_to_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0 where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);        
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                               
        // clean up
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
                
    }
    
    public function testCreateNewListQuery() {
        
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
                
        // test
        $user = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $user->name = 'tester8';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        
        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.* , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt0.last_name reports_to_name , jt0.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id  FROM users   LEFT JOIN  users jt0 ON users.reports_to_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0 where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);        
        
                
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
        
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "foo='bar'";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        
        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.* , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt0.last_name reports_to_name , jt0.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id  FROM users   LEFT JOIN  users jt0 ON users.reports_to_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0 where (foo='bar' AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);        
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
 
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "foo='bar'";
        $sugar_config['securitysuite_filter_user_list'] = 1;
        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.* , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt0.last_name reports_to_name , jt0.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id  FROM users   LEFT JOIN  users jt0 ON users.reports_to_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0 where (foo='bar' AND ( users.id in (
            select sec.user_id from securitygroups_users sec
            inner join securitygroups_users secu on sec.securitygroup_id = secu.securitygroup_id and secu.deleted = 0
                and secu.user_id = '{$current_user->id}'
            where sec.deleted = 0
        )) ) AND users.deleted=0", $results);        
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
        
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = '';
        $sugar_config['securitysuite_filter_user_list'] = 1;
        $results = $tmpUser->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  users.* , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt0.last_name reports_to_name , jt0.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id  FROM users   LEFT JOIN  users jt0 ON users.reports_to_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0 where ( ( users.id in (
            select sec.user_id from securitygroups_users sec
            inner join securitygroups_users secu on sec.securitygroup_id = secu.securitygroup_id and secu.deleted = 0
                and secu.user_id = '{$current_user->id}'
            where sec.deleted = 0
        )) ) AND users.deleted=0", $results);
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
 
 
        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $results = $bean->create_new_list_query($order_by, $where);
        $this->assertEquals(' SELECT  .*  FROM   where .deleted=0', $results);
        
        
        
        // test
        $prjtpl = new AM_ProjectTemplates_sugar();        
        $order_by = '';
        $where = '';
        $results = $prjtpl->create_new_list_query($order_by, $where);
        $this->assertEquals(" SELECT  am_projecttemplates.*  , jt0.user_name modified_by_name , jt0.created_by modified_by_name_owner  , 'Users' modified_by_name_mod , jt1.user_name created_by_name , jt1.created_by created_by_name_owner  , 'Users' created_by_name_mod, LTRIM(RTRIM(CONCAT(IFNULL(jt2.first_name,''),' ',IFNULL(jt2.last_name,'')))) assigned_user_name  , jt3.user_name assigned_user_name , jt3.created_by assigned_user_name_owner  , 'Users' assigned_user_name_mod FROM am_projecttemplates   LEFT JOIN  users jt0 ON am_projecttemplates.modified_user_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0  LEFT JOIN  users jt1 ON am_projecttemplates.created_by=jt1.id AND jt1.deleted=0

 AND jt1.deleted=0 LEFT JOIN users jt2 ON am_projecttemplates.assigned_user_id = jt2.id AND jt2.deleted=0   LEFT JOIN  users jt3 ON am_projecttemplates.assigned_user_id=jt3.id AND jt3.deleted=0

 AND jt3.deleted=0 where ( am_projecttemplates.assigned_user_id ='{$current_user->id}' ) AND am_projecttemplates.deleted=0", $results);
        
        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $results = $bean->create_new_list_query($order_by, $where);
        $this->assertEquals(' SELECT  .*  FROM   where .deleted=0', $results);
        
        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $filter = ['a' => 'b'];
        $results = $bean->create_new_list_query($order_by, $where, $filter);
        $this->assertEquals(' SELECT  .id  FROM   where .deleted=0', $results);
        
        
        // test
        $bean = new AM_ProjectTemplates_sugar();
        $order_by = '';
        $where = "foo='bar'";
        $filter = ['a' => 'b'];
        $results = $bean->create_new_list_query($order_by, $where, $filter);
        $this->assertEquals(" SELECT  am_projecttemplates.id , am_projecttemplates.assigned_user_id  FROM am_projecttemplates  where (foo='bar' AND  am_projecttemplates.assigned_user_id ='{$current_user->id}' ) AND am_projecttemplates.deleted=0", $results);
        
        // clean up
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
    }
        
    
    public function testCreateNewListQueryWithJoinedTablesInParams() {
         
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
                
        // test
        $user = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $user->name = 'tester7';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        
        $filter = [];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.* , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt0.last_name reports_to_name , jt0.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id  FROM users   LEFT JOIN  users jt0 ON users.reports_to_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0 where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);        
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // clean up
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('users');
    }

    
    
    public function testCreateNewListQueryWithFiterKeys() {
        
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
                
        // test
        $user = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $user->name = 'tester6';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
              
        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $filter = ['1' => 'b', '2' => 'id', '3' => 'c'];
        $results = $bean->create_new_list_query($order_by, $where, $filter);
        $this->assertEquals(' SELECT  .id  FROM   where .deleted=0', $results);
        
          
        
        // test
        $bean = new SugarBean();
        $order_by = '';
        $where = '';
        $filter = ['1' => 'b', '2' => 'id', '3' => 'c'];
        $bean->field_defs['c'] = 'd';
        $results = $bean->create_new_list_query($order_by, $where, $filter);
        $this->assertEquals(' SELECT  .id , .c  FROM   where .deleted=0', $results);
        
        
                
        // clean up
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('users');
        
    }
    
    
    public function testCreateNewListQueryForAddRelateField() {
         
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
                
        // test
        $user = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $user->name = 'tester5';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        
        $filter = [];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $tmpUser->field_defs['id']['relationship_fields'] = ['full_name'];
        $tmpUser->field_defs['id']['link_type'] = 'test';
        
        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.* , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt0.last_name reports_to_name , jt0.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id  FROM users   LEFT JOIN  users jt0 ON users.reports_to_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0 where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);        
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // clean up
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
    }

    
    
    public function testCreateNewListQueryWithValueAlias() {
         
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
                
        // test
        $user = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $user->name = 'tester4';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        
        $filter = []; //['id' => ['force_default']];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $tmpUser->field_defs['id']['relationship_fields'] = ['full_name'];
        $tmpUser->field_defs['id']['link_type'] = 'test';
        $tmpUser->field_defs['id']['alias'] = 'test1';
        $tmpUser->field_defs['id']['force_blank'] = true;
        
        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.* , LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as full_name, LTRIM(RTRIM(CONCAT(IFNULL(users.first_name,''),' ',IFNULL(users.last_name,'')))) as name , jt0.last_name reports_to_name , jt0.created_by reports_to_name_owner  , 'Users' reports_to_name_mod, '                                                                                                                                                                                                                                                              ' c_accept_status_fields , '                                    '  call_id , '                                                                                                                                                                                                                                                              ' m_accept_status_fields , '                                    '  meeting_id , '                                                                                                                                                                                                                                                              ' securitygroup_noninher_fields , '                                    '  securitygroup_id  FROM users   LEFT JOIN  users jt0 ON users.reports_to_id=jt0.id AND jt0.deleted=0

 AND jt0.deleted=0 where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);        
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // clean up
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('users');
    }
    
    public function testCreateNewListQueryWithNoFilterFieldForceDefault() {
         
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
                
        // test
        $user = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $user->name = 'tester3';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        
        $filter = ['id' => ['force_blank' => true, 'force_exists' => true]];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $tmpUser->field_defs['id']['relationship_fields'] = ['full_name'];
        $tmpUser->field_defs['id']['link_type'] = 'test';
        $tmpUser->field_defs['id']['alias'] = 'test1';
        $tmpUser->field_defs['id']['force_blank'] = true;
        
        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.id , '                                                                                                                                                                                                                                                              ' id  FROM users  where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);        
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // clean up
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('aod_index');
    }
    
      
    public function testCreateNewListQueryWithFilterFieldForceDefault() {
         
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('users');
        $state->pushTable('user_preferences');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
                
        // test
        $user = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $user->name = 'tester2';
        $user->user_name = 'tester2';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        
        $filter = ['id' => ['force_blank' => true, 'force_exists' => true, 'force_default' => true]];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $tmpUser->field_defs['id']['relationship_fields'] = ['full_name'];
        $tmpUser->field_defs['id']['link_type'] = 'test';
        $tmpUser->field_defs['id']['alias'] = 'test1';
        $tmpUser->field_defs['id']['force_blank'] = true;
        
        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.id , 1 id  FROM users  where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);        
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // clean up
        $state->popGlobals();
        $state->popTable('user_preferences');
        $state->popTable('users');
        $state->popTable('aod_index');
    }
    
    public function testCreateNewListQueryWithDataSource() {
         
        // store states
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('users');
        $state->pushTable('aod_index');
        $state->pushGlobals();
        
        // test
        
        global $current_user, $sugar_config;
                
        // test
        $user = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $user->name = 'tester';
        $user->save();
        $current_user = $user;
        
        $this->assertNotEmpty($current_user->id);
        
        $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess'] = ACL_ALLOW_OWNER;
        $this->assertEquals(ACL_ALLOW_OWNER, $_SESSION['ACL'][$current_user->id]['AM_ProjectTemplates']['module']['list']['aclaccess']);
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // test
        $tmpUser = new User();
        $fieldDefs = $tmpUser->field_defs; // save field defs
        $tmpUser->name = 'tempuser';
        $tmpUser->save();
        $order_by = '';
        $where = "";
        $current_user->is_admin = false;
        $_SESSION['ACL'][$current_user->id]['Users']['module']['list']['aclaccess'] = ACL_ALLOW_GROUP;
        
        $this->assertTrue($tmpUser->bean_implements('ACL'));
        $this->assertFalse(is_admin($current_user));
        $this->assertTrue(ACLController::requireSecurityGroup($tmpUser->module_dir, 'list'));
        
        $filter = ['test']; //['id' => ['force_default']];
        $params = ['joined_tables' => ['foo', 'bar', 'bazz']];
        $tmpUser->field_defs['id']['relationship_fields'] = ['full_name'];
        $tmpUser->field_defs['id']['link_type'] = 'test';
        $tmpUser->field_defs['id']['alias'] = '';
        $tmpUser->field_defs['id']['force_blank'] = true;
        $tmpUser->field_defs['id']['source'] = 'custom_fields';
        $tmpUser->field_defs['modified_user_id']['source'] = 'custom_field';
        
        $results = $tmpUser->create_new_list_query($order_by, $where, $filter, $params);
        $this->assertEquals(" SELECT  users.id  FROM users  where ( AND  EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '{$current_user->id}'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = 'Users'
                       WHERE   secr.record_id = users.id
                               AND secg.deleted = 0) ) AND users.deleted=0", $results);        
        
        $tmpUser->field_defs = $fieldDefs; // restore field defs
                
        // clean up
        $state->popGlobals();
        $state->popTable('aod_index');
        $state->popTable('users');
    }
    
    
}
