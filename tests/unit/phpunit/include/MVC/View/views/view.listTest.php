<?php

class ViewListTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    protected function setUp()
    {
        parent::setUp();

        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testlistViewProcess()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

        // test
        $query = "SELECT * FROM aod_index";
        $resource = DBManagerFactory::getInstance()->query($query);
        $rows = [];
        while ($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        }
        $tableAodIndex = $rows;
        
        $query = "SELECT * FROM email_addresses";
        $resource = DBManagerFactory::getInstance()->query($query);
        $rows = [];
        while ($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        }
        $tableEmailAddresses = $rows;
        
        
        //execute the method and call methods to get the required child objects set. it should return some html.
        $view = new ViewList();
        $view->seed = new User();
        $view->prepareSearchForm();
        $view->preDisplay();

        ob_start();
        $view->listViewProcess();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));
        
        
        
        // clean up
        DBManagerFactory::getInstance()->query("DELETE FROM email_addresses");
        foreach ($tableEmailAddresses as $row) {
            $query = "INSERT email_addresses INTO (";
            $query .= (implode(',', array_keys($row)) . ') VALUES (');
            foreach ($row as $value) {
                $quoteds[] = "'$value'";
            }
            $query .= (implode(', ', $quoteds)) . ')';
            DBManagerFactory::getInstance()->query($query);
        }
        
        DBManagerFactory::getInstance()->query("DELETE FROM aod_index");
        foreach ($tableAodIndex as $row) {
            $query = "INSERT aod_index INTO (";
            $query .= (implode(',', array_keys($row)) . ') VALUES (');
            foreach ($row as $value) {
                $quoteds[] = "'$value'";
            }
            $query .= (implode(', ', $quoteds)) . ')';
            DBManagerFactory::getInstance()->query($query);
        }
        
        // clean up
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testViewList()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

        // test
        //execute the contructor and check for the Object type and type attribute
        $view = new ViewList();
        $this->assertInstanceOf('ViewList', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('list', 'type', $view);
        
        // clean up
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testlistViewPrepare()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

        // test
        //test without setting parameters. it should return some html
        $view = new ViewList();
        $view->module = 'Users';

        ob_start();
        $view->listViewPrepare();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertLessThanOrEqual(0, strlen($renderedContent));

        //test with some REQUEST parameters preset. it should return some html and set the REQUEST key we provided in current_query_by_page REQUEST Param.
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

        // clean up
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testprepareSearchForm()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

        // test
        //test without any REQUEST parameters set. it will set searchform attribute to a searchform object.
        $view1 = new ViewList();
        $view1->module = 'Users';
        $view1->prepareSearchForm();
        $this->assertInstanceOf('SearchForm', $view1->searchForm);

        //test with REQUEST parameters set. it will set searchform attribute to a searchform object.
        $view2 = new ViewList();
        $view2->module = 'Users';
        $_REQUEST['search_form'] = true;
        $_REQUEST['searchFormTab'] = 'advanced_search';
        $view2->prepareSearchForm();

        $this->assertInstanceOf('SearchForm', $view2->searchForm);

        // clean up
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testprocessSearchForm()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

        // test
        
        //test without use_old_search. it should return html.
        $view = new ViewList();
        $view->prepareSearchForm();

        ob_start();
        $view->processSearchForm();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));

        //test with use_old_search = true. there is a $view variable which is never set so it doesn't returns anything.
        $view = new ViewList();
        $view->prepareSearchForm();
        $view->use_old_search = true;

        ob_start();
        $view->processSearchForm();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertEquals(0, strlen($renderedContent));
        
        // clean up
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testpreDisplay()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

        // test
        //execute the method and test if it sets the lv attribute to ListViewSmarty object.
        $view = new ViewList();
        $view->preDisplay();
        $this->assertInstanceOf('ListViewSmarty', $view->lv);

        // clean up
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }

    public function testdisplay()
    {
        // save state
        $state = new \SuiteCRM\StateSaver();
        $state->pushGlobals();
        $state->pushTable('tracker');
        $state->pushTable('email_addresses');
        $state->pushTable('aod_index');

        // test
        $query = "SELECT * FROM email_addresses";
        $resource = DBManagerFactory::getInstance()->query($query);
        $rows = [];
        while ($row = $resource->fetch_assoc()) {
            $rows[] = $row;
        }
        $tableEmailAddresses = $rows;
        
        $view = new ViewList();

        //test without setting bean attibute. it shuold return no access html.
        ob_start();
        $view->display();
        $renderedContent1 = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent1));

        //test with bean, seed and other arrtibutes set. it shuold return html.
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
        
        // clean up
        DBManagerFactory::getInstance()->query("DELETE FROM email_addresses");
        foreach ($tableEmailAddresses as $row) {
            $query = "INSERT email_addresses INTO (";
            $query .= (implode(',', array_keys($row)) . ') VALUES (');
            foreach ($row as $value) {
                $quoteds[] = "'$value'";
            }
            $query .= (implode(', ', $quoteds)) . ')';
            DBManagerFactory::getInstance()->query($query);
        }
        
        // clean up
        $state->popTable('aod_index');
        $state->popTable('email_addresses');
        $state->popTable('tracker');
        $state->popGlobals();
    }
}
