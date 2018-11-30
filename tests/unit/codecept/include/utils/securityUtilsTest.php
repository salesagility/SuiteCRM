<?php

require_once 'include/utils/security_utils.php';
class security_utilsTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testquery_module_access_list()
    {
        self::markTestIncomplete('Test fails only in travis and php 7, Test has environment specific issue.');
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('aod_indexevent');
        
        //execute the method and test it it returns expected contents

        $user = new User('1');
        $expected = array(
            'Home' => 'Home',
            'Accounts' => 'Accounts',
            'Contacts' => 'Contacts',
            'Opportunities' => 'Opportunities',
            'Leads' => 'Leads',
            'AOS_Quotes' => 'AOS_Quotes',
            'Documents' => 'Documents',
            'Emails' => 'Emails',
            'Spots' => 'Spots',
            'Campaigns' => 'Campaigns',
            'Calls' => 'Calls',
            'Meetings' => 'Meetings',
            'Tasks' => 'Tasks',
            'Notes' => 'Notes',
            'AOS_Invoices' => 'AOS_Invoices',
            'AOS_Contracts' => 'AOS_Contracts',
            'Cases' => 'Cases',
            'Prospects' => 'Prospects',
            'ProspectLists' => 'ProspectLists',
            'Project' => 'Project',
            'AM_ProjectTemplates' => 'AM_ProjectTemplates',
            'FP_events' => 'FP_events',
            'FP_Event_Locations' => 'FP_Event_Locations',
            'AOS_Products' => 'AOS_Products',
            'AOS_Product_Categories' => 'AOS_Product_Categories',
            'AOS_PDF_Templates' => 'AOS_PDF_Templates',
            'jjwg_Maps' => 'jjwg_Maps',
            'jjwg_Markers' => 'jjwg_Markers',
            'jjwg_Areas' => 'jjwg_Areas',
            'jjwg_Address_Cache' => 'jjwg_Address_Cache',
            'AOR_Reports' => 'AOR_Reports',
            'AOW_WorkFlow' => 'AOW_WorkFlow',
            'AOK_KnowledgeBase' => 'AOK_KnowledgeBase',
            'AOK_Knowledge_Base_Categories' => 'AOK_Knowledge_Base_Categories',
            'EmailTemplates' => 'EmailTemplates',
            'Surveys' => 'Surveys',

        );

        $actual = query_module_access_list($user);
        $this->assertSame($expected, $actual);
        
        // clean up
        
        $state->popTable('aod_indexevent');
        $state->popGlobals();
    }

    public function testquery_user_has_roles()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        //error_reporting(E_ERROR | E_PARSE);

        // execute the method and test it returns 1 role
        // if the test suite run runs RolesTest first.
        // otherwise it will be 0
        // TODO: TASK: UNDEFINED - Mock up user first

        $expected = '0';
        $actual = query_user_has_roles('1');
        $this->assertSame($expected, $actual);
        
        // clean up
    }

    public function testget_user_allowed_modules()
    {
        //execute the method and test it it returns expected contents

        $expected = array();
        $actual = get_user_allowed_modules('1');
        $this->assertSame($expected, $actual);
    }

    public function testget_user_disallowed_modules()
    {
        self::markTestIncomplete('Test fails only in travis and php7, Test has environment specific issue.');
        
        //execute the method and test it it returns expected contents

        $expected = array(
            'Calendar' => 'Calendar',
            'Bugs' => 'Bugs',
            'ResourceCalendar' => 'ResourceCalendar',
            'AOBH_BusinessHours' => 'AOBH_BusinessHours',
            'AOR_Scheduled_Reports' => 'AOR_Scheduled_Reports',
            'SecurityGroups' => 'SecurityGroups',
        );

        $allowed = query_module_access_list(new User('1'));
        $actual = get_user_disallowed_modules('1', $allowed);

        $this->assertSame($expected, $actual);
    }

    public function testquery_client_ip()
    {
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        //test without setting any server parameters
        $this->assertSame(null, query_client_ip());

        //test with server params set
        $_SERVER['REMOTE_ADDR'] = '1.1.1.3';
        $this->assertSame('1.1.1.3', query_client_ip());

        $_SERVER['HTTP_FROM'] = '1.1.1.2';
        $this->assertSame('1.1.1.2', query_client_ip());

        $_SERVER['HTTP_CLIENT_IP'] = '1.1.1.1';
        $this->assertSame('1.1.1.1', query_client_ip());
        
        // clean up
        
        $state->popGlobals();
    }

    public function testget_val_array()
    {
        //execute the method and test it it returns expected contents
        $tempArray = array('key1' => 'val1', 'key2' => 'val2', 'key3' => 'val3');
        $expected = array('key1' => 'key1', 'key2' => 'key2', 'key3' => 'key3');
        $actual = get_val_array($tempArray);
        $this->assertSame($expected, $actual);
    }
}
