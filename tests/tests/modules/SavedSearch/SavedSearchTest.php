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
 * Class SavedSearchTest
 */
class SavedSearchTest extends \SuiteCRM\Tests\SuiteCRMFunctionalTest
{
    public function testSavedSearch()
    {
    
        //execute the contructor and check for the Object type and  attributes
        $savedSearch = new SavedSearch();
    
        $this->assertInstanceOf('SavedSearch', $savedSearch);
        $this->assertInstanceOf('SugarBean', $savedSearch);
    
        $this->assertAttributeEquals('saved_search', 'table_name', $savedSearch);
        $this->assertAttributeEquals('SavedSearch', 'module_dir', $savedSearch);
        $this->assertAttributeEquals('SavedSearch', 'object_name', $savedSearch);
    
        //test with parameters
        $savedSearch = new SavedSearch(array('id', 'name'), 'id', 'ASC');
    
        $this->assertAttributeEquals(array('id', 'name'), 'columns', $savedSearch);
        $this->assertAttributeEquals('id', 'orderBy', $savedSearch);
        $this->assertAttributeEquals('ASC', 'sortOrder', $savedSearch);
    }
    
    public function testgetForm()
    {
        error_reporting(E_ERROR | E_PARSE);
    
        $savedSearch = new SavedSearch(array('id', 'name'), 'id', 'ASC');
        $result = $savedSearch->getForm('Leads');
    
        $this->assertGreaterThan(0, strlen($result));
    }
    
    public function testgetSelect()
    {
        $savedSearch = new SavedSearch(array('id', 'name'), 'id', 'ASC');
        $result = $savedSearch->getSelect('Leads');
    
        $this->assertGreaterThan(0, strlen($result));
    }
    
    public function testMain()
    {
        $savedSearch = new SavedSearch();
    
        $savedSearch->name = 'test';
        $savedSearch->search_module = 'Leads';
        $savedSearch->save();
    
        //test for record ID to verify that record is saved
        $this->assertTrue(isset($savedSearch->id));
        $this->assertEquals(36, strlen($savedSearch->id));
    
        //test handleSave method
        $this->handleSaveAndRetrieveSavedSearch($savedSearch->id);
    
        //test returnSavedSearch method
        $this->returnSavedSearch($savedSearch->id);
    
        //test returnSavedSearchContents method
        $this->returnSavedSearchContents($savedSearch->id);
    
        //test handleDelete method
        $this->handleDelete($savedSearch->id);
    }
    
    public function handleSaveAndRetrieveSavedSearch($id)
    {
        $savedSearch = new SavedSearch();
        $searchModuleBean = new Lead();
    
        $_REQUEST['search_module'] = 'Leads';
        $_REQUEST['description'] = 'test description';
        $_REQUEST['test_content'] = 'test text';
    
        $expected = array('search_module' => 'Leads',
                          'description'   => 'test description',
                          'test_content'  => 'test text',
                          'advanced'      => true,
        );
        
        //execute the method and then retrieve back to verify contents attribute
        $savedSearch->handleSave('', false, false, $id, $searchModuleBean);
        $savedSearch->retrieveSavedSearch($id);
        $this->assertSame($expected, $savedSearch->contents);
    }
    
    public function handleDelete($id)
    {
        $savedSearch = new SavedSearch();
    
        $savedSearch->handleDelete($id);
    
        $result = $savedSearch->retrieve($id);
        $this->assertEquals(null, $result);
    }
    
    public function returnSavedSearch($id)
    {
        $savedSearch = new SavedSearch();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $savedSearch->returnSavedSearch($id);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function returnSavedSearchContents($id)
    {
        $savedSearch = new SavedSearch();
    
        //execute the method and test if it works and does not throws an exception.
        try
        {
            $result = $savedSearch->returnSavedSearchContents($id);
            $this->assertTrue(true);
        }
        catch(Exception $e)
        {
            $this->fail();
        }
    }
    
    public function testhandleRedirect()
    {
        $savedSearch = new SavedSearch();
    
        $search_query = '&orderBy=&sortOrder=&query=&searchFormTab=&showSSDIV=';
    
        //$savedSearch->handleRedirect("Leads", $search_query, 1, 'true');
        $this->markTestIncomplete('method uses die');
    }
    
    public function testfill_in_additional_list_fields()
    {
        $savedSearch = new SavedSearch();
    
        $savedSearch->assigned_user_id = 1;
        $savedSearch->contents = array('search_module' => 'Leads');
    
        $savedSearch->fill_in_additional_list_fields();
    
        $this->assertEquals('Leads', $savedSearch->search_module);
        $this->assertEquals('Administrator', $savedSearch->assigned_user_name);
    }
    
    public function testpopulateRequest()
    {
        $savedSearch = new SavedSearch();
    
        $savedSearch->contents = array('search_module' => 'Accounts',
                                       'description'   => 'test text',
                                       'test_content'  => 'some content',
                                       'advanced'      => true,
        );
        
        $savedSearch->populateRequest();
    
        //verify thhat Request parameters are set
        $this->assertEquals('Accounts', $_REQUEST['search_module']);
        $this->assertEquals('test text', $_REQUEST['description']);
        $this->assertEquals('some content', $_REQUEST['test_content']);
    }
}
