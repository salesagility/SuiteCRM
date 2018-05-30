<?php


class SecurityGroupTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }
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
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        $securityGroup = new SecurityGroup();

        //test with securitygroups module
        $expected = " securitygroups.id in (
                select secg.id from securitygroups secg
                inner join securitygroups_users secu on secg.id = secu.securitygroup_id and secu.deleted = 0
                    and secu.user_id = '1'
                where secg.deleted = 0
            )";
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
                       WHERE   secr.record_id = ".$table_name.".id
                               AND secg.deleted = 0) ";
        $actual = $securityGroup->getGroupWhere($table_name, $module, $user_id);
        $this->assertSame($expected, $actual);
        
        // clean up
        
        
    }

    public function testgetGroupUsersWhere()
    {
        $securityGroup = new SecurityGroup();

        $expected = " users.id in (
            select sec.user_id from securitygroups_users sec
            inner join securitygroups_users secu on sec.securitygroup_id = secu.securitygroup_id and secu.deleted = 0
                and secu.user_id = '1'
            where sec.deleted = 0
        )";
        $actual = $securityGroup::getGroupUsersWhere(1);

        $this->assertSame($expected, $actual);
    }

    public function testgetGroupJoin()
    {
        $securityGroup = new SecurityGroup();

        //test with securitygroups module
        $expected = " LEFT JOIN (select distinct secg.id from securitygroups secg
    inner join securitygroups_users secu on secg.id = secu.securitygroup_id and secu.deleted = 0
            and secu.user_id = '1'
    where secg.deleted = 0
) securitygroup_join on securitygroup_join.id = securitygroups.id ";
        $actual = $securityGroup->getGroupJoin('securitygroups', 'SecurityGroups', 1);
        $this->assertSame($expected, $actual);

        //test with //test with securitygroups module
        $expected = " LEFT JOIN (select distinct secr.record_id as id from securitygroups secg
    inner join securitygroups_users secu on secg.id = secu.securitygroup_id and secu.deleted = 0
            and secu.user_id = '1'
    inner join securitygroups_records secr on secg.id = secr.securitygroup_id and secr.deleted = 0
             and secr.module = 'Users'
    where secg.deleted = 0
) securitygroup_join on securitygroup_join.id = users.id ";
        $actual = $securityGroup->getGroupJoin('users', 'Users', 1);
        $this->assertSame($expected, $actual);
    }

    public function testgetGroupUsersJoin()
    {
        $securityGroup = new SecurityGroup();

        $expected = " LEFT JOIN (
            select distinct sec.user_id as id from securitygroups_users sec
            inner join securitygroups_users secu on sec.securitygroup_id = secu.securitygroup_id and secu.deleted = 0
                and secu.user_id = '1'
            where sec.deleted = 0
        ) securitygroup_join on securitygroup_join.id = users.id ";
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

        $state = new SuiteCRM\StateSaver();
        
        $state->pushGlobals();
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $account = new Account();
        $account->id = 1;

        $_REQUEST['subpanel_field_name'] = 'id';

        //execute the method and test if it works and does not throws an exception.
        try {
            SecurityGroup::inherit($account, false);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popGlobals();
        
    }

    public function testassign_default_groups()
    {

        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $account = new Account();
        $account->id = 1;

        //execute the method and test if it works and does not throws an exception.
        try {
            SecurityGroup::assign_default_groups($account, false);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testinherit_creator()
    {

        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $account = new Account();
        $account->id = 1;

        //execute the method and test if it works and does not throws an exception.
        try {
            SecurityGroup::inherit_creator($account, false);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testinherit_assigned()
    {

        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $account = new Account();
        $account->id = 1;
        $account->assigned_user_id = 1;

        //execute the method and test if it works and does not throws an exception.
        try {
            SecurityGroup::inherit_assigned($account, false);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testinherit_parent()
    {

        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $account = new Account();
        $account->id = 1;

        //execute the method and test if it works and does not throws an exception.
        try {
            SecurityGroup::inherit_parent($account, false);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testinherit_parentQuery()
    {

        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        $account = new Account();
        $account->id = 1;

        //execute the method and test if it works and does not throws an exception.
        try {
            SecurityGroup::inherit_parentQuery($account, 'Accounts', 1, 1, $account->module_dir);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testinheritOne()
    {

        $securityGroup = new SecurityGroup();

        $result = $securityGroup->inheritOne(1, 1, 'Accounts');
        $this->assertEquals(false, $result);
    }

    public function testgetMembershipCount()
    {

	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();

	// test
        

        $securityGroup = new SecurityGroup();

        $result = $securityGroup->getMembershipCount('1');
        $this->assertEquals(0, $result);

        // clean up
        
        $state->popGlobals();

    }

    public function testSaveAndRetrieveAndRemoveDefaultGroups()
    {
	// save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('aod_index');
        $state->pushTable('securitygroups');
        $state->pushTable('tracker');

	// test
        

        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset ($db->database);
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
        foreach ($result as $key => $value) {
            $securityGroup->removeDefaultGroup($key);
        }

        //retrieve back and verify that default securith groups are deleted
        $result = $securityGroup->retrieveDefaultGroups();
        $this->assertEquals(0, count($result));

        //delete the security group as well for cleanup
        $securityGroup->mark_deleted($securityGroup->id);
        
        // clean up
        
        $state->popTable('tracker');
        $state->popTable('securitygroups');
        $state->popTable('aod_index');

    }

    public function testgetSecurityModules()
    {

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
            'SurveyQuestionOptions' => 'SurveyQuestionOptions',
            'SurveyQuestionResponses' => 'SurveyQuestionResponses',
            'SurveyQuestions' => 'SurveyQuestions',
            'SurveyResponses' => 'SurveyResponses',
            'Surveys' => 'Surveys',
        );

        $actual = $securityGroup->getSecurityModules();
        $actualKeys = array_keys($actual);
        sort($expected);
        sort($actualKeys);
        $this->assertSame($expected, $actualKeys);
    }

    public function testgetLinkName()
    {
        $state = new SuiteCRM\StateSaver();
        
        

        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        $db->disconnect();
        unset ($db->database);
        $db->checkConnection();

        $securityGroup = new SecurityGroup();

        $result = $securityGroup->getLinkName('Accounts', 'Contacts');
        $this->assertEquals('contacts', $result);

        $result = $securityGroup->getLinkName('SecurityGroups', 'ACLRoles');
        $this->assertEquals('aclroles', $result);

        //error_reporting(E_ALL);
        ////error_reporting(E_ERROR | E_PARSE);
        
        // clean up
        
        
    }

    public function testaddGroupToRecord()
    {
        $state = new SuiteCRM\StateSaver();
        
        $state->pushTable('securitygroups_records');
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        //$db->disconnect();
        unset ($db->database);
        $db->checkConnection();

        $securityGroup = new SecurityGroup();

        //execute the method and test if it works and does not throws an exception.
        try {
            $securityGroup->addGroupToRecord('Accounts', 1, 1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        $state->popTable('securitygroups_records');
        
    }

    public function testremoveGroupFromRecord()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);
        
        
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        //$db->disconnect();
        unset ($db->database);
        $db->checkConnection();

        $securityGroup = new SecurityGroup();

        //execute the method and test if it works and does not throws an exception.
        try {
            $securityGroup->removeGroupFromRecord('Accounts', 1, 1);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
        
        
    }

    public function testgetUserSecurityGroups()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        //$db->disconnect();
        unset ($db->database);
        $db->checkConnection();

        $securityGroup = new SecurityGroup();

        $result = $securityGroup->getUserSecurityGroups('1');

        $this->assertTrue(is_array($result));
    }

    public function testgetAllSecurityGroups()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        //$db->disconnect();
        unset ($db->database);
        $db->checkConnection();

        $securityGroup = new SecurityGroup();

        $result = $securityGroup->getAllSecurityGroups();

        $this->assertTrue(is_array($result));
    }

    public function testgetMembers()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        //$db->disconnect();
        unset ($db->database);
        $db->checkConnection();

        $securityGroup = new SecurityGroup();

        $result = $securityGroup->getMembers();

        $this->assertTrue(is_array($result));
    }

    public function testgetPrimaryGroupID()
    {
        //unset and reconnect Db to resolve mysqli fetch exeception
        $db = DBManagerFactory::getInstance();
        //$db->disconnect();
        unset ($db->database);
        $db->checkConnection();

        $securityGroup = new SecurityGroup();

        $result = $securityGroup->getPrimaryGroupID();

        $this->assertEquals(null, $result);
    }
}
