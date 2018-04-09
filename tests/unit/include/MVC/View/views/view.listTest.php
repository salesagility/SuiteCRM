<?php

class ViewListTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        global $current_user;
        get_sugar_config_defaults();
        $current_user = new User();
    }

    public function testViewList()
    {
        //execute the contructor and check for the Object type and type attribute
        $view = new ViewList();
        $this->assertInstanceOf('ViewList', $view);
        $this->assertInstanceOf('SugarView', $view);
        $this->assertAttributeEquals('list', 'type', $view);
    }

    public function testlistViewPrepare()
    {
        error_reporting(E_ERROR | E_PARSE);

        //test without setting parameters. it should return some html
        $view = new ViewList();
        $view->module = 'Users';

        ob_start();
        $view->listViewPrepare();
        $renderedContent = ob_get_contents();
        ob_end_clean();
        $this->assertGreaterThan(0, strlen($renderedContent));

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
    }

    public function testlistViewProcess()
    {
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
    }

    public function testprepareSearchForm()
    {
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
    }

    public function testprocessSearchForm()
    {
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
    }

    public function testpreDisplay()
    {
        //execute the method and test if it sets the lv attribute to ListViewSmarty object.
        $view = new ViewList();
        $view->preDisplay();
        $this->assertInstanceOf('ListViewSmarty', $view->lv);
    }

    public function testdisplay()
    {
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
    }
}
