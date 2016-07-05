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
 * Class EmailMarketingTest
 */
class EmailMarketingTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testEmailMarketing()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $emailMarketing = new EmailMarketing();
    
        $this->assertInstanceOf('EmailMarketing', $emailMarketing);
        $this->assertInstanceOf('SugarBean', $emailMarketing);
    
        $this->assertAttributeEquals('EmailMarketing', 'module_dir', $emailMarketing);
        $this->assertAttributeEquals('EmailMarketing', 'object_name', $emailMarketing);
        $this->assertAttributeEquals('email_marketing', 'table_name', $emailMarketing);
    
        $this->assertAttributeEquals(true, 'new_schema', $emailMarketing);
    }
    
    public function testretrieve()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $emailMarketing = new EmailMarketing();
    
        $result = $emailMarketing->retrieve();
        $this->assertInstanceOf('EmailMarketing', $result);
    }
    
    public function testget_summary_text()
    {
        $emailMarketing = new EmailMarketing();
    
        //test without setting name
        $this->assertEquals(null, $emailMarketing->get_summary_text());
    
        //test with name set
        $emailMarketing->name = 'test';
        $this->assertEquals('test', $emailMarketing->get_summary_text());
    }
    
    public function testcreate_export_query()
    {
        $emailMarketing = new EmailMarketing();
    
        //test with empty string params
        $expected =
            " SELECT  email_marketing.*  , jt0.name template_name , jt0.assigned_user_id template_name_owner  , 'EmailTemplates' template_name_mod FROM email_marketing   LEFT JOIN  email_templates jt0 ON email_marketing.template_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0 where email_marketing.deleted=0";
        $actual = $emailMarketing->create_export_query('', '');
        $this->assertSame($expected, $actual);
    
        //test with valid string params
        $expected =
            " SELECT  email_marketing.*  , jt0.name template_name , jt0.assigned_user_id template_name_owner  , 'EmailTemplates' template_name_mod FROM email_marketing   LEFT JOIN  email_templates jt0 ON email_marketing.template_id=jt0.id AND jt0.deleted=0\n\n AND jt0.deleted=0 where (email_marketing.name=\"\") AND email_marketing.deleted=0";
        $actual = $emailMarketing->create_export_query('email_marketing.id', 'email_marketing.name=""');
        $this->assertSame($expected, $actual);
    }
    
    public function testget_list_view_data()
    {
        $emailMarketing = new EmailMarketing();
    
        //execute the method and verify that it retunrs expected results
        $expected = array(
            'ALL_PROSPECT_LISTS' => '0',
        );
    
        $actual = $emailMarketing->get_list_view_data();
        $this->assertSame($expected, $actual);
    }
    
    public function testbean_implements()
    {
        $emailMarketing = new EmailMarketing();
        $this->assertEquals(false, $emailMarketing->bean_implements('')); //test with blank value
        $this->assertEquals(false, $emailMarketing->bean_implements('test')); //test with invalid value
        $this->assertEquals(true, $emailMarketing->bean_implements('ACL')); //test with valid value
    }
    
    public function testget_all_prospect_lists()
    {
        $emailMarketing = new EmailMarketing();
    
        //execute the method and verify that it retunrs expected results
        $expected =
            "select prospect_lists.* from prospect_lists  left join prospect_list_campaigns on prospect_list_campaigns.prospect_list_id=prospect_lists.id where prospect_list_campaigns.deleted=0 and prospect_list_campaigns.campaign_id='' and prospect_lists.deleted=0 and prospect_lists.list_type not like 'exempt%'";
        $actual = $emailMarketing->get_all_prospect_lists();
        $this->assertSame($expected, $actual);
    }
}
