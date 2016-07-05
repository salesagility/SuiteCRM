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

require_once 'include/utils/security_utils.php';

/**
 * Class security_utilsTest
 */
class security_utilsTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testquery_module_access_list()
    {
    
        //execute the method and test it it returns expected contents
    
        $user = new User('1');
        $expected = array(
            'Home'                          => 'Home',
            'Accounts'                      => 'Accounts',
            'Contacts'                      => 'Contacts',
            'Opportunities'                 => 'Opportunities',
            'Leads'                         => 'Leads',
            'AOS_Quotes'                    => 'AOS_Quotes',
            'Calendar'                      => 'Calendar',
            'Documents'                     => 'Documents',
            'Emails'                        => 'Emails',
            'Spots'                         => 'Spots',
            'Campaigns'                     => 'Campaigns',
            'Calls'                         => 'Calls',
            'Meetings'                      => 'Meetings',
            'Tasks'                         => 'Tasks',
            'Notes'                         => 'Notes',
            'AOS_Invoices'                  => 'AOS_Invoices',
            'AOS_Contracts'                 => 'AOS_Contracts',
            'Cases'                         => 'Cases',
            'Prospects'                     => 'Prospects',
            'ProspectLists'                 => 'ProspectLists',
            'Project'                       => 'Project',
            'AM_ProjectTemplates'           => 'AM_ProjectTemplates',
            'FP_events'                     => 'FP_events',
            'FP_Event_Locations'            => 'FP_Event_Locations',
            'AOS_Products'                  => 'AOS_Products',
            'AOS_Product_Categories'        => 'AOS_Product_Categories',
            'AOS_PDF_Templates'             => 'AOS_PDF_Templates',
            'jjwg_Maps'                     => 'jjwg_Maps',
            'jjwg_Markers'                  => 'jjwg_Markers',
            'jjwg_Areas'                    => 'jjwg_Areas',
            'jjwg_Address_Cache'            => 'jjwg_Address_Cache',
            'AOR_Reports'                   => 'AOR_Reports',
            'AOW_WorkFlow'                  => 'AOW_WorkFlow',
            'AOK_KnowledgeBase'             => 'AOK_KnowledgeBase',
            'AOK_Knowledge_Base_Categories' => 'AOK_Knowledge_Base_Categories',
        );
    
        $actual = query_module_access_list($user);
        $this->assertSame($expected, $actual);
    }
    
    public function testquery_user_has_roles()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        //execute the method and test it it returns expected contents
    
        $expected = '0';
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
            'Bugs'                  => 'Bugs',
            'Reminders'             => 'Reminders',
            'Reminders_Invitees'    => 'Reminders_Invitees',
            'AOR_Scheduled_Reports' => 'AOR_Scheduled_Reports',
            'SecurityGroups'        => 'SecurityGroups',
        );
    
        $allowed = query_module_access_list(new User('1'));
        $actual = get_user_disallowed_modules('1', $allowed);
    
        $this->assertSame($expected, $actual);
    }
    
    public function testquery_client_ip()
    {
        //test without setting any server parameters
        $this->assertSame(null, query_client_ip());
    
        //test with server params set
        $_SERVER['REMOTE_ADDR'] = '1.1.1.3';
        $this->assertSame('1.1.1.3', query_client_ip());
    
        $_SERVER['HTTP_FROM'] = '1.1.1.2';
        $this->assertSame('1.1.1.2', query_client_ip());
    
        $_SERVER['HTTP_CLIENT_IP'] = '1.1.1.1';
        $this->assertSame('1.1.1.1', query_client_ip());
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
