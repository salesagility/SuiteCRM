<?php

use SuiteCRM\StateCheckerPHPUnitTestCaseAbstract;
use SuiteCRM\StateSaver;

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

include_once __DIR__ . '/../../../../../modules/SharedSecurityRules/SharedSecurityRules.php';

/**
 * SharedSecurityRulesTest
 *
 * @author gyula
 */
class SharedSecurityRulesTest extends StateCheckerPHPUnitTestCaseAbstract
{
    
    /**
     *
     * @var StateSaver
     */
    protected $state;

    protected function setUp()
    {
        parent::setUp();
        $this->state = new StateSaver();
        $this->state->pushTable('aod_indexevent');
    }
    
    protected function tearDown()
    {
        $this->state->popTable('aod_indexevent');
        parent::tearDown();
    }

    public function testGetFieldDefsLeeds()
    {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        
        $ssr->exemptFields = ['varchar'];
        $module = 'Leads';
        $bean = BeanFactory::getBean($module);
        $result = $ssr->getFieldDefs($bean->field_defs, $module);
        $this->assertEquals([
            '' => '',
            'accept_status_name' => 'Accept Status',
            'm_accept_status_fields' => 'Accept Status',
            'c_accept_status_fields' => 'Accept Status',
            'accounts' => 'Account',
            'account_description' => 'Account Description',
            'account_id' => 'Account ID',
            'email' => 'Any Email:',
            'assigned_user_id' => 'Assigned User:',
            'assigned_user_name' => 'Assigned to',
            'assigned_user_link' => 'Assigned to User',
            'birthdate' => 'Birthdate:',
            'oldcalls' => 'Calls',
            'calls' => 'Calls',
            'campaign_id' => 'Campaign ID',
            'campaign_name' => 'Campaign:',
            'campaigns' => 'CampaignLog',
            'campaign_leads' => 'Campaigns',
            'contact_id' => 'Contact ID',
            'contacts' => 'Contacts',
            'converted' => 'Converted',
            'created_by' => 'Created By',
            'created_by_name' => 'Created By',
            'created_by_link' => 'Created User',
            'date_entered' => 'Date Created',
            'date_modified' => 'Date Modified',
            'deleted' => 'Deleted',
            'description' => 'Description:',
            'do_not_call' => 'Do Not Call:',
            'email_addresses' => 'Email',
            'email_addresses_primary' => 'Email Address',
            'webtolead_email1' => 'Email Address:',
            'webtolead_email_opt_out' => 'Email Opt Out:',
            'email_opt_out' => 'Email Opt Out:',
            'emails' => 'Emails',
            'fp_events_leads_1' => 'Events',
            'id' => 'ID',
            'invalid_email' => 'Invalid Email:',
            'webtolead_invalid_email' => 'Invalid Email:',
            'e_accept_status_fields' => 'LBL_CONT_ACCEPT_STATUS', // TODO: <-- fields has no translation???
            'e_invite_status_fields' => 'LBL_CONT_INVITE_STATUS',
            'event_accept_status' => 'LBL_LIST_ACCEPT_STATUS_EVENT',
            'event_status_name' => 'LBL_LIST_INVITE_STATUS_EVENT',
            'jjwg_maps_lat_c' => 'Latitude',
            'lawful_basis' => 'Lawful Basis',
            'date_reviewed' => 'Lawful Basis Date Reviewed',
            'lawful_basis_source' => 'Lawful Basis Source',
            'lead_source_description' => 'Lead Source Description:',
            'lead_source' => 'Lead Source:',
            'contact' => 'Leads',
            'jjwg_maps_lng_c' => 'Longitude',
            'oldmeetings' => 'Meetings',
            'meetings' => 'Meetings',
            'modified_user_id' => 'Modified By',
            'modified_by_name' => 'Modified By Name',
            'modified_user_link' => 'Modified User',
            'email_addresses_non_primary' => 'Non Primary E-mails',
            'notes' => 'Notes',
            'opportunity' => 'Opportunities',
            'opportunity_id' => 'Opportunity ID',
            'webtolead_email2' => 'Other Email:',
            'prospect_lists' => 'Prospect List',
            'reports_to_id' => 'Reports To ID',
            'reportees' => 'Reports To:',
            'reports_to_link' => 'Reports To:',
            'salutation' => 'Salutation',
            'SecurityGroups' => 'Security Groups',
            'status_description' => 'Status Description:',
            'status' => 'Status:',
            'tasks' => 'Tasks',
        ], $result);
    }
    
    public function testGetFieldDefsSSREmptyLabel()
    {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        
        $ssr->exemptFields = ['varchar'];
        $module = 'Accounts';
        $bean = BeanFactory::getBean($module);
        $bean->field_defs['foo'] = ['vname' => 'nonexist_vname', 'type' => 'id', 'name' => 'nonexist_name'];
        $result = $ssr->getFieldDefs($bean->field_defs, $module);
        $this->assertEquals([
            '' => '',
            'nonexist_name' => 'nonexist_vname',
            'email' => 'Any Email:',
            'assigned_user_id' => 'Assigned User:',
            'assigned_user_link' => 'Assigned to User',
            'assigned_user_name' => 'Assigned to:',
            'bugs' => 'Bugs',
            'calls' => 'Calls',
            'campaign_id' => 'Campaign ID',
            'campaign_name' => 'Campaign:',
            'campaigns' => 'CampaignLog',
            'campaign_accounts' => 'Campaigns',
            'cases' => 'Cases',
            'contacts' => 'Contacts',
            'aos_contracts' => 'Contracts',
            'created_by' => 'Created By',
            'created_by_name' => 'Created By',
            'created_by_link' => 'Created by User',
            'date_entered' => 'Date Created:',
            'date_modified' => 'Date Modified:',
            'deleted' => 'Deleted',
            'description' => 'Description:',
            'documents' => 'Documents',
            'email_addresses_primary' => 'Email Address',
            'email_addresses' => 'Email Addresses',
            'email_opt_out' => 'Email Opt Out:',
            'emails' => 'Emails',
            'id' => 'ID',
            'industry' => 'Industry:',
            'invalid_email' => 'Invalid Email:',
            'aos_invoices' => 'Invoices',
            'jjwg_maps_lat_c' => 'Latitude',
            'leads' => 'Leads',
            'jjwg_maps_lng_c' => 'Longitude',
            'meetings' => 'Meetings',
            'member_of' => 'Member of:',
            'parent_name' => 'Member of:',
            'members' => 'Members',
            'modified_user_id' => 'Modified By',
            'modified_by_name' => 'Modified By Name',
            'modified_user_link' => 'Modified by User',
            'email_addresses_non_primary' => 'Non Primary E-mails',
            'notes' => 'Notes',
            'opportunities' => 'Opportunity',
            'parent_id' => 'Parent Account ID',
            'project' => 'Projects',
            'prospect_lists' => 'Prospect List',
            'aos_quotes' => 'Quotes',
            'SecurityGroups' => 'Security Groups',
            'tasks' => 'Tasks',
            'account_type' => 'Type:',
        ], $result);
        unset($bean->field_defs['foo']);
    }
    
    public function testGetFieldDefsSSR()
    {
        $ssr = BeanFactory::getBean('SharedSecurityRules');

        $result = $ssr->getFieldDefs(null, null);
        $this->assertEquals([], $result);
                
        // with dbType in exemptFields
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $ssr->exemptFields = ['varchar'];
        $module = 'Accounts';
        $bean = BeanFactory::getBean($module);
        $result = $ssr->getFieldDefs($bean->field_defs, $module);
        $this->assertEquals([
            '' => '',
            'email' => 'Any Email:',
            'assigned_user_link' => 'Assigned to User',
            'assigned_user_name' => 'Assigned to:',
            'bugs' => 'Bugs',
            'calls' => 'Calls',
            'campaign_name' => 'Campaign:',
            'campaigns' => 'CampaignLog',
            'campaign_accounts' => 'Campaigns',
            'cases' => 'Cases',
            'contacts' => 'Contacts',
            'aos_contracts' => 'Contracts',
            'created_by_name' => 'Created By',
            'created_by_link' => 'Created by User',
            'date_entered' => 'Date Created:',
            'date_modified' => 'Date Modified:',
            'deleted' => 'Deleted',
            'description' => 'Description:',
            'documents' => 'Documents',
            'email_addresses_primary' => 'Email Address',
            'email_addresses' => 'Email Addresses',
            'email_opt_out' => 'Email Opt Out:',
            'emails' => 'Emails',
            'industry' => 'Industry:',
            'invalid_email' => 'Invalid Email:',
            'aos_invoices' => 'Invoices',
            'jjwg_maps_lat_c' => 'Latitude',
            'leads' => 'Leads',
            'jjwg_maps_lng_c' => 'Longitude',
            'meetings' => 'Meetings',
            'member_of' => 'Member of:',
            'parent_name' => 'Member of:',
            'members' => 'Members',
            'modified_by_name' => 'Modified By Name',
            'modified_user_link' => 'Modified by User',
            'email_addresses_non_primary' => 'Non Primary E-mails',
            'notes' => 'Notes',
            'opportunities' => 'Opportunity',
            'project' => 'Projects',
            'prospect_lists' => 'Prospect List',
            'aos_quotes' => 'Quotes',
            'SecurityGroups' => 'Security Groups',
            'tasks' => 'Tasks',
            'account_type' => 'Type:',
            'assigned_user_id' => 'Assigned User:',
            'campaign_id' => 'Campaign ID',
            'created_by' => 'Created By',
            'id' => 'ID',
            'modified_user_id' => 'Modified By',
            'parent_id' => 'Parent Account ID',
        ], $result);
        
        // with exemptFields
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $ssr->exemptFields = ['id'];
        $module = 'Accounts';
        $bean = BeanFactory::getBean($module);
        $result = $ssr->getFieldDefs($bean->field_defs, $module);
        $this->assertEquals([
            '' => '',
            'jjwg_maps_address_c' => 'Address',
            'phone_alternate' => 'Alternate Phone:',
            'annual_revenue' => 'Annual Revenue:',
            'email' => 'Any Email:',
            'assigned_user_link' => 'Assigned to User',
            'assigned_user_name' => 'Assigned to:',
            'billing_address_city' => 'Billing City:',
            'billing_address_country' => 'Billing Country:',
            'billing_address_postalcode' => 'Billing Postal Code:',
            'billing_address_state' => 'Billing State:',
            'billing_address_street_2' => 'Billing Street 2',
            'billing_address_street_3' => 'Billing Street 3',
            'billing_address_street_4' => 'Billing Street 4',
            'billing_address_street' => 'Billing Street:',
            'bugs' => 'Bugs',
            'calls' => 'Calls',
            'campaign_name' => 'Campaign:',
            'campaigns' => 'CampaignLog',
            'campaign_accounts' => 'Campaigns',
            'cases' => 'Cases',
            'contacts' => 'Contacts',
            'aos_contracts' => 'Contracts',
            'created_by_name' => 'Created By',
            'created_by_link' => 'Created by User',
            'date_entered' => 'Date Created:',
            'date_modified' => 'Date Modified:',
            'deleted' => 'Deleted',
            'description' => 'Description:',
            'documents' => 'Documents',
            'email_addresses_primary' => 'Email Address',
            'email1' => 'Email Address:',
            'email_addresses' => 'Email Addresses',
            'email_opt_out' => 'Email Opt Out:',
            'emails' => 'Emails',
            'employees' => 'Employees:',
            'phone_fax' => 'Fax:',
            'jjwg_maps_geocode_status_c' => 'Geocode Status',
            'industry' => 'Industry:',
            'invalid_email' => 'Invalid Email:',
            'aos_invoices' => 'Invoices',
            'jjwg_maps_lat_c' => 'Latitude',
            'leads' => 'Leads',
            'jjwg_maps_lng_c' => 'Longitude',
            'meetings' => 'Meetings',
            'member_of' => 'Member of:',
            'parent_name' => 'Member of:',
            'members' => 'Members',
            'modified_by_name' => 'Modified By Name',
            'modified_user_link' => 'Modified by User',
            'name' => 'Name:',
            'email_addresses_non_primary' => 'Non Primary E-mails',
            'notes' => 'Notes',
            'phone_office' => 'Office Phone:',
            'opportunities' => 'Opportunity',
            'ownership' => 'Ownership:',
            'project' => 'Projects',
            'prospect_lists' => 'Prospect List',
            'aos_quotes' => 'Quotes',
            'rating' => 'Rating:',
            'sic_code' => 'SIC Code:',
            'SecurityGroups' => 'Security Groups',
            'shipping_address_city' => 'Shipping City:',
            'shipping_address_country' => 'Shipping Country:',
            'shipping_address_postalcode' => 'Shipping Postal Code:',
            'shipping_address_state' => 'Shipping State:',
            'shipping_address_street_2' => 'Shipping Street 2',
            'shipping_address_street_3' => 'Shipping Street 3',
            'shipping_address_street_4' => 'Shipping Street 4',
            'shipping_address_street' => 'Shipping Street:',
            'tasks' => 'Tasks',
            'ticker_symbol' => 'Ticker Symbol:',
            'account_type' => 'Type:',
            'website' => 'Website:',
        ], $result);
    

        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $module = 'Accounts';
        $bean = BeanFactory::getBean($module);
        $result = $ssr->getFieldDefs($bean->field_defs, $module);
        $this->assertEquals([
            '' => '',
            'jjwg_maps_address_c' => 'Address',
            'phone_alternate' => 'Alternate Phone:',
            'annual_revenue' => 'Annual Revenue:',
            'email' => 'Any Email:',
            'assigned_user_id' => 'Assigned User:',
            'assigned_user_link' => 'Assigned to User',
            'assigned_user_name' => 'Assigned to:',
            'billing_address_city' => 'Billing City:',
            'billing_address_country' => 'Billing Country:',
            'billing_address_postalcode' => 'Billing Postal Code:',
            'billing_address_state' => 'Billing State:',
            'billing_address_street_2' => 'Billing Street 2',
            'billing_address_street_3' => 'Billing Street 3',
            'billing_address_street_4' => 'Billing Street 4',
            'billing_address_street' => 'Billing Street:',
            'bugs' => 'Bugs',
            'calls' => 'Calls',
            'campaign_id' => 'Campaign ID',
            'campaign_name' => 'Campaign:',
            'campaigns' => 'CampaignLog',
            'campaign_accounts' => 'Campaigns',
            'cases' => 'Cases',
            'contacts' => 'Contacts',
            'aos_contracts' => 'Contracts',
            'created_by' => 'Created By',
            'created_by_name' => 'Created By',
            'created_by_link' => 'Created by User',
            'date_entered' => 'Date Created:',
            'date_modified' => 'Date Modified:',
            'deleted' => 'Deleted',
            'description' => 'Description:',
            'documents' => 'Documents',
            'email_addresses_primary' => 'Email Address',
            'email1' => 'Email Address:',
            'email_addresses' => 'Email Addresses',
            'email_opt_out' => 'Email Opt Out:',
            'emails' => 'Emails',
            'employees' => 'Employees:',
            'phone_fax' => 'Fax:',
            'jjwg_maps_geocode_status_c' => 'Geocode Status',
            'id' => 'ID',
            'industry' => 'Industry:',
            'invalid_email' => 'Invalid Email:',
            'aos_invoices' => 'Invoices',
            'jjwg_maps_lat_c' => 'Latitude',
            'leads' => 'Leads',
            'jjwg_maps_lng_c' => 'Longitude',
            'meetings' => 'Meetings',
            'member_of' => 'Member of:',
            'parent_name' => 'Member of:',
            'members' => 'Members',
            'modified_user_id' => 'Modified By',
            'modified_by_name' => 'Modified By Name',
            'modified_user_link' => 'Modified by User',
            'name' => 'Name:',
            'email_addresses_non_primary' => 'Non Primary E-mails',
            'notes' => 'Notes',
            'phone_office' => 'Office Phone:',
            'opportunities' => 'Opportunity',
            'ownership' => 'Ownership:',
            'parent_id' => 'Parent Account ID',
            'project' => 'Projects',
            'prospect_lists' => 'Prospect List',
            'aos_quotes' => 'Quotes',
            'rating' => 'Rating:',
            'sic_code' => 'SIC Code:',
            'SecurityGroups' => 'Security Groups',
            'shipping_address_city' => 'Shipping City:',
            'shipping_address_country' => 'Shipping Country:',
            'shipping_address_postalcode' => 'Shipping Postal Code:',
            'shipping_address_state' => 'Shipping State:',
            'shipping_address_street_2' => 'Shipping Street 2',
            'shipping_address_street_3' => 'Shipping Street 3',
            'shipping_address_street_4' => 'Shipping Street 4',
            'shipping_address_street' => 'Shipping Street:',
            'tasks' => 'Tasks',
            'ticker_symbol' => 'Ticker Symbol:',
            'account_type' => 'Type:',
            'website' => 'Website:',
        ], $result);
    }

    public function testChangeOperatorSSR()
    {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        
        $result = $ssr->changeOperator(null, null, null);
        $this->assertEquals(false, $result);
        
        $result = $ssr->changeOperator('Equal_To', 'foo', false);
        $this->assertEquals(" = 'foo' ", $result);
        
        $result = $ssr->changeOperator('Equal_To', 'foo', true);
        $this->assertEquals(" != 'foo' ", $result);
        
        $result = $ssr->changeOperator('Not_Equal_To', 'foo', false);
        $this->assertEquals(" != 'foo' ", $result);
        
        $result = $ssr->changeOperator('Not_Equal_To', 'foo', true);
        $this->assertEquals(" = 'foo' ", $result);
        
        $result = $ssr->changeOperator('Starts_With', 'foo', false);
        $this->assertEquals(" LIKE 'foo%'", $result);
        
        $result = $ssr->changeOperator('Starts_With', 'foo', true);
        $this->assertEquals(" NOT LIKE 'foo%'", $result);
        
        $result = $ssr->changeOperator('Ends_With', 'foo', false);
        $this->assertEquals(" LIKE '%foo'", $result);
        
        $result = $ssr->changeOperator('Ends_With', 'foo', true);
        $this->assertEquals(" NOT LIKE '%foo'", $result);
        
        $result = $ssr->changeOperator('Contains', 'foo', false);
        $this->assertEquals(" LIKE '%foo%'", $result);
        
        $result = $ssr->changeOperator('Contains', 'foo', true);
        $this->assertEquals(" NOT LIKE '%foo%' ", $result);
        
        $result = $ssr->changeOperator('is_null', 'foo', false);
        $this->assertEquals(" IS NULL ", $result);
        
        $result = $ssr->changeOperator('is_null', 'foo', true);
        $this->assertEquals(" IS NOT NULL ", $result);
    }
    

    public function testBeanImplementsIfNotImplemented()
    {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $result = $ssr->bean_implements('should_not_implemented_for_test');
        $this->assertFalse($result);
    }
    
    public function testSave()
    {
        $state = new StateSaver();
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushGlobals();
        
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue((bool)$usr->id);
        
        global $current_user;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $id = $ssr->save();
        $this->assertTrue(isValidId($id));
        
        $ssr = BeanFactory::getBean('SharedSecurityRules', $id);
        $this->assertEquals($id, $ssr->id);
                        
        $this->assertTrue(isset($_SESSION['ACL'][$usr->id]) && is_array($_SESSION['ACL'][$usr->id]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
    }
    
    
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelAndCorrectEmail
     *
     * @global type $current_user
     */
    public function testCheckRulesWithCorrectAccessLevelAndCorrectEmail()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushTable('acl_roles');
        $state->pushTable('acl_roles_users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        /**
         * @var SharedSecurityRules
         */
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $role = BeanFactory::getBean('ACLRoles');
        $role->role_id = 'a_role_id';
        $role->user_id = $uid;
        $rid = $role->save();
        $this->assertEquals($role->id, $rid);
        $ssra->parameters = base64_encode(serialize([
            'test',
            'foo' => 'bar',
            'email_target_type' => ['test_key' => 'Users'],
            'accesslevel' => ['test_al_key' => 'test_al_value', 'test_key' => 'test_value'],
            'email' => ['test_key' => [0 => 'role', 2 => $rid]],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'test_value');
        $this->assertEquals(null, $ret); // TODO: <-- different results in phpunit vs codeception???
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('acl_roles_users');
        $state->popTable('acl_roles');
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
        
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelAndCorrectEmailWithUserIdInAclRolesUsersTable
     *
     * @global type $current_user
     */
    public function testCheckRulesWithUserIdInAclRolesUsersTable()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushTable('acl_roles');
        $state->pushTable('acl_roles_users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $role = BeanFactory::getBean('ACLRoles');
        $role->role_id = 'a_role_id';
        $role->user_id = $uid;
        $rid = $role->save();
        $this->assertEquals($role->id, $rid);
        $ssra->parameters = base64_encode(serialize([
            'test',
            'foo' => 'bar',
            'email_target_type' => ['test_key' => 'Users'],
            'accesslevel' => ['test_al_key' => 'test_al_value', 'test_key' => 'test_value'],
            'email' => ['test_key' => [0 => 'role', 2 => $rid]],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'test_value');
        $this->assertEquals(null, $ret); // TODO: <-- different results in phpunit vs codeception???
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('acl_roles_users');
        $state->popTable('acl_roles');
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     *
     * @global type $current_usertestCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelAndCorrectEmailWithSecurityGroup
     */
    public function testCheckRulesWithSecurityGroup()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushTable('acl_roles');
        $state->pushTable('acl_roles_users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $role = BeanFactory::getBean('ACLRoles');
        $role->role_id = 'a_role_id';
        $role->user_id = $uid;
        $rid = $role->save();
        $this->assertEquals($role->id, $rid);
        $ssra->parameters = base64_encode(serialize([
            'test',
            'foo' => 'bar',
            'email_target_type' => ['test_key' => 'Users'],
            'accesslevel' => ['test_al_key' => 'test_al_value', 'test_key' => 'test_value'],
            'email' => ['test_key' => [0 => 'security_group', 2 => $rid]],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'test_value');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('acl_roles_users');
        $state->popTable('acl_roles');
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     *
     * @global type $current_usertestCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelAndCorrectEmailAndFindAccess
     */
    public function testCheckRulesWithCorrectAccessLevelAndCorrectEmailAndFindAccess()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushTable('acl_roles');
        $state->pushTable('acl_roles_users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $role = BeanFactory::getBean('ACLRoles');
        $role->role_id = 'a_role_id';
        $role->user_id = $uid;
        $rid = $role->save();
        $this->assertEquals($role->id, $rid);
        $ssra->parameters = base64_encode(serialize([
            'test',
            'foo' => 'bar',
            'email_target_type' => ['test_key' => 'Users'],
            'accesslevel' => ['test_al_key' => 'test_al_value', 'test_key' => 'test_value', 'list'],
            'email' => ['test_key' => [0 => 'role', 2 => $rid]],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('acl_roles_users');
        $state->popTable('acl_roles');
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     *
     * @global type $current_usertestCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithCorrectAccessLevelButIncorrectEmail
     */
    public function testCheckRulesWithCorrectAccessLevelButIncorrectEmail()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssra->parameters = base64_encode(serialize([
            'test',
            'foo' => 'bar',
            'email_target_type' => ['test_key' => 'Users'],
            'accesslevel' => ['test_al_key' => 'test_al_value'],
            'email' => ['test_key' => [0 => 'role']],
        ]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithIncorrectAccessLevel
     *
     * @global type $current_user
     */
    public function testCheckRulesWithIncorrectAccessLevel()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssra->parameters = base64_encode(serialize(['test', 'foo' => 'bar', 'email_target_type' => ['test_key' => 'test_value'], 'accesslevel' => 'it_is_incorrect']));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParametersWithEmailTargetTypeWithNoAccessLevel
     *
     * @global type $current_user
     */
    public function testCheckRulesWithNoAccessLevel()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssra->parameters = base64_encode(serialize(['test', 'foo' => 'bar', 'email_target_type' => ['test_key' => 'test_value']]));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResultsAndActionResultsWithBase64EncodedSerializedActionParameters
     *
     * @global type $current_user
     */
    public function testCheckRulesWithBase64EncodedSerializedActionParameters()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssra->parameters = base64_encode(serialize(['test', 'foo' => 'bar']));
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    /**
     * testCheckRulesWithFilledFetchedRowWithQueryResults
     *
     * @global type $current_user
     */
    public function testCheckRulesWithQueryResults()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushTable('sharedsecurityrules');
        $state->pushTable('sharedsecurityrulesactions');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ssr->status = 'Complete';
        $ssr->flow_module = 'Accounts';
        $ssrid = $ssr->save();
        $this->assertEquals($ssr->id, $ssrid);
        $ssra = BeanFactory::getBean('SharedSecurityRulesActions');
        $ssra->sa_shared_security_rules_id = $ssrid;
        $ssraid = $ssra->save();
        $this->assertEquals($ssra->id, $ssraid);
        
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('sharedsecurityrulesactions');
        $state->popTable('sharedsecurityrules');
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    public function testCheckRulesWithFilledFetchedRow()
    {
        $state = new StateSaver();
        $state->pushTable('accounts');
        $state->pushTable('accounts_cstm');
        $state->pushTable('users');
        $state->pushGlobals();
        
        global $current_user;
        $usr = BeanFactory::getBean('Users');
        $usr->save();
        $this->assertTrue(isValidId($usr->id));
        $uid = $usr->id;
        $current_user = $usr;
        
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $acc->assigned_user_id = $uid;
        $acc->create_by = $uid;
        $id = $acc->save();
        $this->assertEquals($acc->id, $id);
        $acc->retrieve($id);
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
        
        $this->assertTrue(isset($_SESSION['ACL'][$uid]));
        
        $state->popGlobals();
        $state->popTable('users');
        $state->popTable('accounts_cstm');
        $state->popTable('accounts');
    }
    
    public function testCheckRules()
    {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $acc = BeanFactory::getBean('Accounts');
        $ret = $ssr->checkRules($acc, 'list');
        $this->assertEquals(null, $ret);
    }
    
    public function testGetParenthesisConditions()
    {
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

    public function testBuildRuleWhere()
    {
        $acc = BeanFactory::getBean('Accounts');
        $ret = SharedSecurityRules::buildRuleWhere($acc);
        $this->assertEquals([
            'resWhere' => '',
            'addWhere' => '',
                ], $ret);
    }

    public function testCheckHistory()
    {
        $ssrh = new SharedSecurityRulesHelper(DBManagerFactory::getInstance());
        $acc = BeanFactory::getBean('Accounts');
        $ret = $ssrh->checkHistory($acc, 'name', 'test');
        $this->assertEquals(null, $ret);
    }
    
    public function testChangeOperator()
    {
        $ssrh = new SharedSecurityRulesHelper(DBManagerFactory::getInstance());
        $acc = BeanFactory::getBean('Accounts');
        $ret = $ssrh->checkHistory($acc, 'incorrect_value', 'incorrect_reverse');
        $this->assertEquals(null, $ret);
    }
    
    public function testGetFieldDefs()
    {
        $ssr = BeanFactory::getBean('SharedSecurityRules');
        $ret = $ssr->getFieldDefs(array(), 'module_not_exists');
        $this->assertEquals(['' => ''], $ret);
    }
}
