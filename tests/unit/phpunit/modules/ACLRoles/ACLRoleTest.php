<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ACLRoleTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = BeanFactory::newBean('Users');
    }

    public function testACLRole()
    {
        // Execute the constructor and check for the Object type and type attribute
        $aclRole = BeanFactory::newBean('ACLRoles');
        $this->assertInstanceOf('ACLRole', $aclRole);
        $this->assertInstanceOf('SugarBean', $aclRole);

        $this->assertAttributeEquals('ACLRoles', 'module_dir', $aclRole);
        $this->assertAttributeEquals('ACLRole', 'object_name', $aclRole);
        $this->assertAttributeEquals('acl_roles', 'table_name', $aclRole);
        $this->assertAttributeEquals(true, 'new_schema', $aclRole);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aclRole);
        $this->assertAttributeEquals(true, 'disable_custom_fields', $aclRole);
        $this->assertAttributeEquals(array('user_id' => 'users'), 'relationship_fields', $aclRole);
    }

    public function testget_summary_text()
    {
        $aclRole = BeanFactory::newBean('ACLRoles');

        //test with name attribute set and verify it returns expected value.
        //it works only if name attribute is preset, throws exception otherwise
        $aclRole->name = 'test role';
        $name = $aclRole->get_summary_text();
        $this->assertEquals('test role', $name);
    }

    public function testsetAction()
    {
        $aclRole = BeanFactory::newBean('ACLRoles');

        //take count of relationship initially and then after method execution and test if relationship count increases
        $initial_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id' => '1', 'action_id' => '1', 'access_override' => '90'), 'role_id'));
        $aclRole->setAction('1', '1', '90');
        $final_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id' => '1', 'action_id' => '1', 'access_override' => '90'), 'role_id'));

        $this->assertGreaterThanOrEqual($initial_count, $final_count, "values were: [$initial_count], [$final_count]");
    }

    public function testmark_relationships_deleted()
    {
        $aclRole = BeanFactory::newBean('ACLRoles');

        //take count of relationship initially and then after method execution and test if relationship count decreases
        $initial_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id' => '1', 'action_id' => '1', 'access_override' => '90'), 'role_id'));
        $aclRole->mark_relationships_deleted('1');
        $final_count = count($aclRole->retrieve_relationships('acl_roles_actions', array('role_id' => '1', 'action_id' => '1', 'access_override' => '90'), 'role_id'));

        $this->assertLessThanOrEqual($initial_count, $final_count, "values were: [$initial_count], [$final_count]");
    }

    public function testgetUserRoles()
    {
        $aclRole = BeanFactory::newBean('ACLRoles');

        //test with default/true getAsNameArray param value
        $result = $aclRole->getUserRoles('1');
        $this->assertTrue(is_array($result));

        //test with flase getAsNameArray param value
        $result = $aclRole->getUserRoles('1', false);
        $this->assertTrue(is_array($result));
    }

    public function testgetUserRoleNames()
    {
        $aclRole = BeanFactory::newBean('ACLRoles');

        //test with empty value
        $result = $aclRole->getUserRoleNames('');
        $this->assertTrue(is_array($result));

        //test with non empty but non existing role id value
        $result = $aclRole->getUserRoleNames('1');
        $this->assertTrue(is_array($result));
    }

    public function testgetAllRoles()
    {
        $aclRole = BeanFactory::newBean('ACLRoles');

        //test with returnAsArray default/flase
        $result = $aclRole->getAllRoles();
        $this->assertTrue(is_array($result));

        //test with returnAsArray true
        $result = $aclRole->getAllRoles(true);
        $this->assertTrue(is_array($result));
    }

    public function testgetRoleActions()
    {
        $aclRole = BeanFactory::newBean('ACLRoles');

        //test with empty value
        $result = $aclRole->getRoleActions('');
        $this->assertInternalType('array', $result);
        $exp = [
          'Accounts',
          'Alerts',
          'Bugs',
          'Calls',
          'Calls_Reschedule',
          'Campaigns',
          'AOP_Case_Events',
          'AOP_Case_Updates',
          'Cases',
          'Contacts',
          'AOS_Contracts',
          'Documents',
          'EAPM',
          'EmailTemplates',
          'EmailMarketing',
          'Emails',
            'Employees',
          'FP_events',
          'AOD_Index',
          'AOD_IndexEvent',
          'AOS_Invoices',
          'AOK_Knowledge_Base_Categories',
          'AOK_KnowledgeBase',
          'Leads',
          'FP_Event_Locations',
          'jjwg_Maps',
          'jjwg_Address_Cache',
          'jjwg_Areas',
          'jjwg_Markers',
          'Meetings',
          'Notes',
          'Opportunities',
          'OutboundEmailAccounts',
          'AOS_PDF_Templates',
          'AOW_Processed',
          'AOS_Products',
          'AOS_Product_Categories',
          'AM_TaskTemplates',
          'ProjectTask',
          'Project',
          'AM_ProjectTemplates',
          'AOS_Quotes',
          'AOR_Reports',
          'AOR_Scheduled_Reports',
          'SecurityGroups',
          'Spots',
          'SurveyQuestionOptions',
          'SurveyQuestionResponses',
          'SurveyQuestions',
          'SurveyResponses',
          'Surveys',
          'Prospects',
          'ProspectLists',
          'Tasks',
          'TemplateSectionLine',
          'Users',
          'AOW_WorkFlow',
        ];
        $this->assertEquals($exp, array_keys($result));

        //test with non empty but non existing role id value, initially no roles exist.
        $result = $aclRole->getRoleActions('1');
        $this->assertInternalType('array', $result);
        $this->assertEquals($exp, array_keys($result));
    }

    public function testtoArray()
    {
        $aclRole = BeanFactory::newBean('ACLRoles');

        //wihout any fields set
        $expected = array('id' => '', 'name' => '',  'description' => '');
        $actual = $aclRole->toArray();
        $this->assertSame($expected, $actual);

        //with fileds pre populated
        $aclRole->id = '1';
        $aclRole->name = 'test';
        $aclRole->description = 'some description text';

        $expected = array('id' => '1', 'name' => 'test',  'description' => 'some description text');
        $actual = $aclRole->toArray();
        $this->assertSame($expected, $actual);
    }

    public function testfromArray()
    {
        $aclRole = BeanFactory::newBean('ACLRoles');

        $arr = array('id' => '1', 'name' => 'test',  'description' => 'some description text');
        $aclRole->fromArray($arr);

        //verify that it sets the object attributes correctly
        $this->assertSame($aclRole->id, '1');
        $this->assertSame($aclRole->name, 'test');
        $this->assertSame($aclRole->description, 'some description text');
    }
}
