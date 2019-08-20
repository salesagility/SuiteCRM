<?php

class SavedSearchTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

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
        $state = new SuiteCRM\StateSaver();
        
        
        

        $savedSearch = new SavedSearch(array('id', 'name'), 'id', 'ASC');
        $result = $savedSearch->getForm('Leads');

        $this->assertGreaterThan(0, strlen($result));
        
        // clean up
    }

    public function testgetSelect()
    {
        $savedSearch = new SavedSearch(array('id', 'name'), 'id', 'ASC');
        $result = $savedSearch->getSelect('Leads');

        $this->assertGreaterThan(0, strlen($result));
    }

//    public function testMain()
//    {
//        $savedSearch = new SavedSearch();
//
//        $savedSearch->name = 'test';
//        $savedSearch->search_module = 'Leads';
//        $savedSearch->save();
//
//        //test for record ID to verify that record is saved
//        $this->assertTrue(isset($savedSearch->id));
//        $this->assertEquals(36, strlen($savedSearch->id));
//
//
//        // Where is the unit test?
//        // Where is the main method?
//        // Why is this combined?
//        // TODO: TASK: UNDEFINED - build the tests for the following methods.
//        $this->markTestIncomplete('');
    ////        //test handleSave method
    ////        $this->handleSaveAndRetrieveSavedSearch($savedSearch->id);
    ////
    ////        //test returnSavedSearch method
    ////        $this->returnSavedSearch($savedSearch->id);
    ////
    ////        //test returnSavedSearchContents method
    ////        $this->returnSavedSearchContents($savedSearch->id);
    ////
    ////        //test handleDelete method
    ////        $this->handleDelete($savedSearch->id);
//    }

    public function handleSaveAndRetrieveSavedSearch($id)
    {
        $savedSearch = new SavedSearch();
        $searchModuleBean = new Lead();

        $_REQUEST['search_module'] = 'Leads';
        $_REQUEST['description'] = 'test description';
        $_REQUEST['test_content'] = 'test text';

        $expected = array('search_module' => 'Leads', 'description' => 'test description', 'test_content' => 'test text', 'advanced' => true);

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
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $savedSearch = new SavedSearch();

        //execute the method and test if it works and does not throws an exception.
        try {
            $savedSearch->returnSavedSearch($id);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
    }

    public function returnSavedSearchContents($id)
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        
        
        $savedSearch = new SavedSearch();

        //execute the method and test if it works and does not throws an exception.
        try {
            $result = $savedSearch->returnSavedSearchContents($id);
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
        
        // clean up
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
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('saved_search');

        // test
        
        $savedSearch = new SavedSearch();

        $savedSearch->assigned_user_id = 1;
        $savedSearch->contents = array('search_module' => 'Leads');

        $savedSearch->fill_in_additional_list_fields();

        $this->assertEquals('Leads', $savedSearch->search_module);
        $this->assertEquals('Administrator', $savedSearch->assigned_user_name);
        
        // clean up
        
        $state->popTable('saved_search');
    }

    public function testpopulateRequest()
    {
        // save state

        $state = new \SuiteCRM\StateSaver();
        $state->pushTable('saved_search');
        $state->pushGlobals();

        // test
        
        $savedSearch = new SavedSearch();

        $savedSearch->contents = array('search_module' => 'Accounts',
                                        'description' => 'test text',
                                        'test_content' => 'some content',
                                        'advanced' => true, );

        $savedSearch->populateRequest();

        //verify thhat Request parameters are set
        $this->assertEquals('Accounts', $_REQUEST['search_module']);
        $this->assertEquals('test text', $_REQUEST['description']);
        $this->assertEquals('some content', $_REQUEST['test_content']);

        // clean up
        
        $state->popTable('saved_search');
        $state->popGlobals();
    }
}
