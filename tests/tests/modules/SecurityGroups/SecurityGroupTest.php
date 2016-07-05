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
 * Class SecurityGroupTest
 */
class SecurityGroupTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testSecurityGroup()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $securityGroup = new SecurityGroup();
    
        $this->assertInstanceOf('SecurityGroup', $securityGroup);
        $this->assertInstanceOf('Basic', $securityGroup);
        $this->assertInstanceOf('SugarBean', $securityGroup);
    
        $this->assertAttributeEquals('securitygroups', 'table_name', $securityGroup);
        $this->assertAttributeEquals('SecurityGroups', 'module_dir', $securityGroup);
        $this->assertAttributeEquals('SecurityGroup', 'object_name', $securityGroup);
    }
    
    public function testgetGroupWhere()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $securityGroup = new SecurityGroup();
    
        //test with securitygroups module
        $expected =
            " securitygroups.id in (\n                select secg.id from securitygroups secg\n                inner join securitygroups_users secu on secg.id = secu.securitygroup_id and secu.deleted = 0\n                    and secu.user_id = '1'\n                where secg.deleted = 0\n            )";
        $actual = $securityGroup->getGroupWhere('securitygroups', 'SecurityGroups', 1);
        $this->assertSame($expected, $actual);
    
        //test with //test with securitygroups module module
        $table_name = 'users';
        $module = 'Users';
        $user_id = 1;
        $expected = " EXISTS (SELECT  1
                  FROM    securitygroups secg
                          INNER JOIN securitygroups_users secu
                            ON secg.id = secu.securitygroup_id
                               AND secu.deleted = 0
                               AND secu.user_id = '$user_id'
                          INNER JOIN securitygroups_records secr
                            ON secg.id = secr.securitygroup_id
                               AND secr.deleted = 0
                               AND secr.module = '$module'
                       WHERE   secr.record_id = " . $table_name . ".id
                               AND secg.deleted = 0) ";
        $actual = $securityGroup->getGroupWhere($table_name, $module, $user_id);
        $this->assertSame($expected, $actual);
    }
    
    public function testgetGroupUsersWhere()
    {
        $securityGroup = new SecurityGroup();
    
        $expected =
            " users.id in (\n            select sec.user_id from securitygroups_users sec\n            inner join securitygroups_users secu on sec.securitygroup_id = secu.securitygroup_id and secu.deleted = 0\n                and secu.user_id = '1'\n            where sec.deleted = 0\n        )";
        $actual = $securityGroup::getGroupUsersWhere(1);
    
        $this->assertSame($expected, $actual);
    }
    
    public function testgetGroupJoin()
    {
        $securityGroup = new SecurityGroup();
    
        //test with securitygroups module
        $expected =
            " LEFT JOIN (select distinct secg.id from securitygroups secg\n    inner join securitygroups_users secu on secg.id = secu.securitygroup_id and secu.deleted = 0\n            and secu.user_id = '1'\n    where secg.deleted = 0\n) securitygroup_join on securitygroup_join.id = securitygroups.id ";
        $actual = $securityGroup->getGroupJoin('securitygroups', 'SecurityGroups', 1);
        $this->assertSame($expected, $actual);
    
        //test with //test with securitygroups module
        $expected =
            " LEFT JOIN (select distinct secr.record_id as id from securitygroups secg\n    inner join securitygroups_users secu on secg.id = secu.securitygroup_id and secu.deleted = 0\n            and secu.user_id = '1'\n    inner join securitygroups_records secr on secg.id = secr.securitygroup_id and secr.deleted = 0\n             and secr.module = 'Users'\n    where secg.deleted = 0\n) securitygroup_join on securitygroup_join.id = users.id ";
        $actual = $securityGroup->getGroupJoin('users', 'Users', 1);
        $this->assertSame($expected, $actual);
    }
    
    public function testgetGroupUsersJoin()
    {
        $securityGroup = new SecurityGroup();
    
        $expected =
            " LEFT JOIN (\n            select distinct sec.user_id as id from securitygroups_users sec\n            inner join securitygroups_users secu on sec.securitygroup_id = secu.securitygroup_id and secu.deleted = 0\n                and secu.user_id = '1'\n            where sec.deleted = 0\n        ) securitygroup_join on securitygroup_join.id = users.id ";
        $actual = $securityGroup->getGroupUsersJoin(1);
        $this->assertSame($expected, $actual);
    }
    
    public function testgroupHasAccess()
    {
    
        //test for listview
        $result = SecurityGroup::groupHasAccess('', '[SELECT_ID_LIST]');
        $this->assertEquals(true, $result);
    
        //test with invalid values
        $result = SecurityGroup::groupHasAccess('', '');
        $this->assertEquals(false, $result);
    
        //test with valid values
        $result = SecurityGroup::groupHasAccess('Users', '1');
        $this->assertEquals(false, $result);
    }
    
    public function testinherit()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $account = new Account();
        $account->id = 1;
    
        $_REQUEST['subpanel_field_name'] = 'id';
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            SecurityGroup::inherit($account, false);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testassign_default_groups()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $account = new Account();
        $account->id = 1;
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            SecurityGroup::assign_default_groups($account, false);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testinherit_creator()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $account = new Account();
        $account->id = 1;
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            SecurityGroup::inherit_creator($account, false);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testinherit_assigned()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $account = new Account();
        $account->id = 1;
        $account->assigned_user_id = 1;
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            SecurityGroup::inherit_assigned($account, false);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testinherit_parent()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $account = new Account();
        $account->id = 1;
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            SecurityGroup::inherit_parent($account, false);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testinherit_parentQuery()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $account = new Account();
        $account->id = 1;
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            SecurityGroup::inherit_parentQuery($account, 'Accounts', 1, 1, $account->module_dir);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testinheritOne()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        $result = $securityGroup->inheritOne(1, 1, 'Accounts');
        $this->assertEquals(false, $result);
    }
    
    public function testgetMembershipCount()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        $result = $securityGroup->getMembershipCount('1');
        $this->assertEquals(0, $result);
    }
    
    public function testSaveAndRetrieveAndRemoveDefaultGroups()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        //create a security group first
        $securityGroup->name = 'test';
        $securityGroup->save();
    
        //execute saveDefaultGroup method
        $securityGroup->saveDefaultGroup($securityGroup->id, 'test_module');
    
        //execute retrieveDefaultGroups method
        $result = $securityGroup->retrieveDefaultGroups();
    
        //verify that default group is created
        $this->assertTrue(is_array($result));
        $this->assertGreaterThan(0, count($result));
    
        //execute removeDefaultGroup method for each default group
        foreach ($result as $key => $value)
        {
            $securityGroup->removeDefaultGroup($key);
        }
    
        //retrieve back and verify that default securith groups are deleted
        $result = $securityGroup->retrieveDefaultGroups();
        $this->assertEquals(0, count($result));
    
        //delete the security group as well for cleanup
        $securityGroup->mark_deleted($securityGroup->id);
    }
    
    public function testgetSecurityModules()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        $expected = array(
            'Meetings',
            'Cases',
            'AOS_Products',
            'Opportunities',
            'FP_Event_Locations',
            'Tasks',
            'jjwg_Markers',
            'EmailTemplates',
            'Campaigns',
            'jjwg_Areas',
            'Contacts',
            'AOS_Contracts',
            'AOS_Quotes',
            'Bugs',
            'Users',
            'Documents',
            'AOS_Invoices',
            'Notes',
            'AOW_WorkFlow',
            'ProspectLists',
            'AOK_KnowledgeBase',
            'AOS_PDF_Templates',
            'Calls',
            'Accounts',
            'Leads',
            'Emails',
            'ProjectTask',
            'Project',
            'FP_events',
            'AOR_Reports',
            'Prospects',
            'ACLRoles',
            'jjwg_Maps',
            'AOS_Product_Categories',
            'Spots' => 'Spots',
        );
        
        $actual = $securityGroup->getSecurityModules();
        $actualKeys = array_keys($actual);
        sort($expected);
        sort($actualKeys);
        $this->assertSame($expected, $actualKeys);
    }
    
    public function testgetLinkName()
    {
    
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        $result = $securityGroup->getLinkName('Accounts', 'Contacts');
        $this->assertEquals('contacts', $result);
    
        $result = $securityGroup->getLinkName('SecurityGroups', 'ACLRoles');
        $this->assertEquals('aclroles', $result);
    
        error_reporting(E_ALL);
        //error_reporting(E_ERROR | E_PARSE);
    }
    
    public function testaddGroupToRecord()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $securityGroup->addGroupToRecord('Accounts', 1, 1);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testremoveGroupFromRecord()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $securityGroup->removeGroupFromRecord('Accounts', 1, 1);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testgetUserSecurityGroups()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        $result = $securityGroup->getUserSecurityGroups('1');
    
        $this->assertTrue(is_array($result));
    }
    
    public function testgetAllSecurityGroups()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        $result = $securityGroup->getAllSecurityGroups();
    
        $this->assertTrue(is_array($result));
    }
    
    public function testgetMembers()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        $result = $securityGroup->getMembers();
    
        $this->assertTrue(is_array($result));
    }
    
    public function testgetPrimaryGroupID()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        global $db;
        unset($db->database);
        $db->checkConnection();
    
        $securityGroup = new SecurityGroup();
    
        $result = $securityGroup->getPrimaryGroupID();
    
        $this->assertEquals(null, $result);
    }
}
