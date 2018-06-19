<?php

class ViewListTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testlistViewProcess()
    {
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

	
        
        
        $query = "SELECT * FROM aod_index";
        $resource = DBManagerFactory::getInstance()->query($query);
        $rows = [];
        while($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        } 
        $tableAodIndex = $rows;
        
        $query = "SELECT * FROM email_addresses";
        $resource = DBManagerFactory::getInstance()->query($query);
        $rows = [];
        while($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        } 
        $tableEmailAddresses = $rows;
        
        
        
        $view = new ViewList();
        $view->seed = new User();
        $view->prepareSearchForm();
        $view->preDisplay();

        ob_start();
        $view->listViewProcess();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
        
        
        
        
        
        DBManagerFactory::getInstance()->query("DELETE FROM email_addresses");
        foreach($tableEmailAddresses as $row) {
            $query = "INSERT email_addresses INTO (";
            $query .= (implode(',', array_keys($row)) . ') VALUES (');
            foreach($row as $value) {
                $quoteds[] = "'$value'";
            }
            $query .= (implode(', ', $quoteds)) . ')';
            DBManagerFactory::getInstance()->query($query);
        }
        
        DBManagerFactory::getInstance()->query("DELETE FROM aod_index");
        foreach($tableAodIndex as $row) {
            $query = "INSERT aod_index INTO (";
            $query .= (implode(',', array_keys($row)) . ') VALUES (');
            foreach($row as $value) {
                $quoteds[] = "'$value'";
            }
            $query .= (implode(', ', $quoteds)) . ')';
            DBManagerFactory::getInstance()->query($query);
        }
        
        
        
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testViewList()
    {
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

	
        
        
        $view = new ViewList();
        $this->assertInstanceOf('ViewList', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('list', 'type', $view);
        
        
        
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testlistViewPrepare()
    {
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

	
        
        
        
        

        
        $view = new ViewList();
        $view->module = 'Users';

        ob_start();
        $view->listViewPrepare();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertLessThanOrEqual(0, strlen($renderedContent));

        
        $view = new ViewList();
        $view->module = 'Users';
        $GLOBALS['module'] = 'Users';
        $_REQUEST['Users2_USER_offset'] = 1;
        $_REQUEST['current_query_by_page'] = htmlentities(json_encode(array('key' => 'value')));
        $view->bean = new User();

        ob_start();
        $view->listViewPrepare();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
        $this->assertEquals('value', $_REQUEST['key']);
         
        
        
        
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testprepareSearchForm()
    {
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

	
        
        
        
        $view1 = new ViewList();
        $view1->module = 'Users';
        $view1->prepareSearchForm();
        $this->assertInstanceOf('SearchForm', $view1->searchForm);

        
        $view2 = new ViewList();
        $view2->module = 'Users';
        $_REQUEST['search_form'] = true;
        $_REQUEST['searchFormTab'] = 'advanced_search';
        $view2->prepareSearchForm();

        $this->assertInstanceOf('SearchForm', $view2->searchForm);
        
        
        
        
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testprocessSearchForm()
    {
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

	
        
        
        $view = new ViewList();
        $view->prepareSearchForm();

        ob_start();
        $view->processSearchForm();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));

        
        $view = new ViewList();
        $view->prepareSearchForm();
        $view->use_old_search = true;

        ob_start();
        $view->processSearchForm();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(0, strlen($renderedContent));
        
        
        
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testpreDisplay()
    {
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

	
        
        
        $view = new ViewList();
        $view->preDisplay();
        $this->assertInstanceOf('ListViewSmarty', $view->lv);
        
        
        
        
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testdisplay()
    {
        
	

        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

	
        
        
        $query = "SELECT * FROM email_addresses";
        $resource = DBManagerFactory::getInstance()->query($query);
        $rows = [];
        while($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        } 
        $tableEmailAddresses = $rows;
        
        $view = new ViewList();

        
        ob_start();
        $view->display();
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent1));

        
        $view->bean = new User();
        $view->seed = new User();
        $view->module = 'Users';
        $view->prepareSearchForm();
        $view->preDisplay();

        ob_start();

        $view->display();
        $renderedContent2 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent2));
        
        
        
        DBManagerFactory::getInstance()->query("DELETE FROM email_addresses");
        foreach($tableEmailAddresses as $row) {
            $query = "INSERT email_addresses INTO (";
            $query .= (implode(',', array_keys($row)) . ') VALUES (');
            foreach($row as $value) {
                $quoteds[] = "'$value'";
            }
            $query .= (implode(', ', $quoteds)) . ')';
            DBManagerFactory::getInstance()->query($query);
        }
        
        
        
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();

    }
}
