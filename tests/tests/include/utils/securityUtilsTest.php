<?php

require_once 'include/utils/security_utils.php';
class security_utilsTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testquery_module_access_list()
    {

        //execute the method and test it it returns expected contents

        $user = new User('1');
        $expected = array(
                'Home' => 'Home',
                'Accounts' => 'Accounts',
                'Contacts' => 'Contacts',
                'Opportunities' => 'Opportunities',
                'Leads' => 'Leads',
                'AOS_Quotes' => 'AOS_Quotes',
                'Calendar' => 'Calendar',
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
        );

        $actual = query_module_access_list($user);
        $this->assertSame($expected, $actual);
    }

    public function testquery_user_has_roles()
    {

        //execute the method and test it it returns expected contents

        $expected = '1';
        $actual = query_user_has_roles('1');
        $this->assertSame($expected, $actual);
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
        //execute the method and test it it returns expected contents

        $expected = array(
                'Bugs' => 'Bugs',
                'ResourceCalendar' => 'ResourceCalendar',
				'AOBH_BusinessHours' => 'AOBH_BusinessHours',
                'AOR_Scheduled_Reports' => 'AOR_Scheduled_Reports',
                'SecurityGroups' => 'SecurityGroups',
        );

        $usr = new User('1');
        $allowed = query_module_access_list($usr);
        $actual = get_user_disallowed_modules('1', $allowed);

        $this->assertSame($expected, $actual);
    }

    public function testquery_client_ip()
    {
        // save state
        
        $state = new SuiteCRM\StateSaver();
        $state->pushGlobals();
        
        // test
        
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
