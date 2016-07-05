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
 * Class AOD_IndexTest
 */
class AOD_IndexTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testAOD_Index()
    {
    
        //execute the contructor and check for the Object type and type attribute
        $aod_index = new AOD_Index();
        $this->assertInstanceOf('AOD_Index', $aod_index);
        $this->assertInstanceOf('Basic', $aod_index);
        $this->assertInstanceOf('SugarBean', $aod_index);
    
        $this->assertAttributeEquals('AOD_Index', 'module_dir', $aod_index);
        $this->assertAttributeEquals('AOD_Index', 'object_name', $aod_index);
        $this->assertAttributeEquals('aod_index', 'table_name', $aod_index);
        $this->assertAttributeEquals(true, 'new_schema', $aod_index);
        $this->assertAttributeEquals(true, 'disable_row_level_security', $aod_index);
        $this->assertAttributeEquals(false, 'importable', $aod_index);
        $this->assertAttributeEquals(false, 'tracker_visibility', $aod_index);
    }
    
    public function testisEnabled()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $aod_index = new AOD_Index();
    
        //execute the method and verify that it returns true
        $result = $aod_index->isEnabled();
        $this->assertTrue($result);
    }
    
    public function testfind()
    {
        $aod_index = new AOD_Index();
    
        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';
    
        //execute the method without parameters and verify that it returns true
        $hits = $aod_index->find();
        $this->assertTrue(is_array($hits));
    
        //execute the method with parameters and verify that it returns true
        $hits = $aod_index->find('/');
        $this->assertTrue(is_array($hits));
    }
    
    public function testoptimise()
    {
        $aod_index = new AOD_Index();
        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';
        $last_optimized = $aod_index->last_optimised;
    
        //execute the method and test if the last optimized date is changed to a later date/time.
        $aod_index->optimise();
        $this->assertGreaterThan($last_optimized, $aod_index->last_optimised);
    }
    
    public function testgetIndex()
    {
        $aod_index = new AOD_Index();
        $result = $aod_index->getIndex();
    
        //execute the method and verify it returns a different instance of samme type 
        $this->assertInstanceOf('AOD_Index', $result);
        $this->assertNotSame($aod_index, $result);
    }
    
    public function testgetDocumentForBean()
    {
        $user = new User(1);
    
        $aod_index = new AOD_Index();
        $result = $aod_index->getDocumentForBean($user);
    
        //execute the method and verify that it returns an array
        $this->assertTrue(is_array($result));
    
        //verify that returned array has a valid Zend_Search_Lucene_Document instance
        $this->assertInstanceOf('Zend_Search_Lucene_Document', $result['document']);
    }
    
    public function testcommit()
    {
        $aod_index = new AOD_Index();
        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $aod_index->commit();
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testisModuleSearchable()
    {
    
        //test with an invalid module
        $this->assertFalse(AOD_Index::isModuleSearchable('', ''));
    
        //test for modules that are searchable
        $this->assertTrue(AOD_Index::isModuleSearchable('DocumentRevisions', 'DocumentRevision'));
        $this->assertTrue(AOD_Index::isModuleSearchable('Cases', 'Case'));
        $this->assertTrue(AOD_Index::isModuleSearchable('Accounts', 'Account'));
    
        //test for modules that are not searchable
        $this->assertFalse(AOD_Index::isModuleSearchable('AOD_IndexEvent', 'AOD_IndexEvent'));
        $this->assertFalse(AOD_Index::isModuleSearchable('AOD_Index', 'AOD_Index'));
        $this->assertFalse(AOD_Index::isModuleSearchable('AOW_Actions', 'AOW_Action'));
        $this->assertFalse(AOD_Index::isModuleSearchable('AOW_Conditions', 'AOW_Condition'));
        $this->assertFalse(AOD_Index::isModuleSearchable('AOW_Processed', 'AOW_Processed'));
        $this->assertFalse(AOD_Index::isModuleSearchable('SchedulersJobs', 'SchedulersJob'));
        $this->assertFalse(AOD_Index::isModuleSearchable('Users', 'User'));
    }
    
    public function testindex()
    {
        $aod_index = new AOD_Index();
        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';
    
        //test with a not searchable module, it will return false
        $result = $aod_index->index('Users', 1);
        $this->assertFalse($result);
    
        //test with a searchable module but invalid bean id, it will still index it
        $result = $aod_index->index('Accounts', 1);
        $this->assertEquals(null, $result);
    }
    
    public function testremove()
    {
        $aod_index = new AOD_Index();
        $aod_index->id = 1;
        $aod_index->location = 'modules/AOD_Index/Index/Index';
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $aod_index->remove('Accounts', 1);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testgetIndexableModules()
    {
        $expected = array(
            'AM_ProjectTemplates'           => 'AM_ProjectTemplates',
            'AM_TaskTemplates'              => 'AM_TaskTemplates',
            'AOK_KnowledgeBase'             => 'AOK_KnowledgeBase',
            'AOK_Knowledge_Base_Categories' => 'AOK_Knowledge_Base_Categories',
            'AOP_Case_Events'               => 'AOP_Case_Events',
            'AOP_Case_Updates'              => 'AOP_Case_Updates',
            'AOR_Charts'                    => 'AOR_Chart',
            'AOR_Conditions'                => 'AOR_Condition',
            'AOR_Fields'                    => 'AOR_Field',
            'AOR_Reports'                   => 'AOR_Report',
            'AOS_Contracts'                 => 'AOS_Contracts',
            'AOS_Product_Categories'        => 'AOS_Product_Categories',
            'AOW_WorkFlow'                  => 'AOW_WorkFlow',
            'Accounts'                      => 'Account',
            'Alerts'                        => 'Alert',
            'Bugs'                          => 'Bug',
            'Calls'                         => 'Call',
            'Calls_Reschedule'              => 'Calls_Reschedule',
            'Campaigns'                     => 'Campaign',
            'Cases'                         => 'aCase',
            'Contacts'                      => 'Contact',
            'DocumentRevisions'             => 'DocumentRevision',
            'Documents'                     => 'Document',
            'FP_events'                     => 'FP_events',
            'Favorites'                     => 'Favorites',
            'Leads'                         => 'Lead',
            'Meetings'                      => 'Meeting',
            'Notes'                         => 'Note',
            'Opportunities'                 => 'Opportunity',
            'OutboundEmailAccounts'         => 'OutboundEmailAccounts',
            'Project'                       => 'Project',
            'ProjectTask'                   => 'ProjectTask',
            'ProspectLists'                 => 'ProspectList',
            'Prospects'                     => 'Prospect',
            'Spots'                         => 'Spots',
            'Tasks'                         => 'Task',
            'TemplateSectionLine'           => 'TemplateSectionLine',
        );
    
        $aod_index = new AOD_Index();
    
        //execute the method and verify that it retunrs expected results
        $actual = $aod_index->getIndexableModules();
        $this->assertSame($expected, $actual);
    }
}
