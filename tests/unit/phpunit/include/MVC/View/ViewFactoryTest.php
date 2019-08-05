<?php


class ViewFactoryTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testloadView()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        //error_reporting(E_ERROR | E_WARNING | E_PARSE);

        //check with invalid input. must return sugaview instance
        $view = ViewFactory::loadView('default', '');
        $this->assertInstanceOf('SugarView', $view);

        //check with a valid module without a specific view, must return sugarview instance
        $view = ViewFactory::loadView('default', 'Users');
        $this->assertInstanceOf('SugarView', $view);

        //check with a valid module and specific view, must reutern speciifc view instance
        $view = ViewFactory::loadView('list', 'Users');
        $this->assertInstanceOf('UsersViewList', $view);
        
        // clean up
    }

    public function test_loadConfig()
    {
        //check with a invalid module, method must not change the view options.
        $view = ViewFactory::loadView('default', '');
        $options = $view->options;
        ViewFactory::_loadConfig($view, 'default');
        $this->assertSame($options, $view->options);

        //check with a valid module which does not implement it's own view config. method must not change the view options.
        $view = ViewFactory::loadView('detail', 'Users');
        $options = $view->options;
        ViewFactory::_loadConfig($view, 'detail');
        $this->assertSame($options, $view->options);

        //check with a valid module which implement it's own view config. method still must not change the view options because it needs.
        $view = ViewFactory::loadView('area_detail_map', 'jjwg_Areas');
        $view->module = 'jjwg_Areas';
        $options = $view->options;
        ViewFactory::_loadConfig($view, 'area_detail_map');
        $this->assertSame($options, $view->options);
    }

    public function test_buildFromFile()
    {

        //checck with valid values and test if it returns correct view instance
        $type = 'list';
        $target_module = 'Users';
        $bean = null;
        $view = ViewFactory::_buildFromFile('modules/'.$target_module.'/views/view.'.$type.'.php', $bean, array(), $type, $target_module);
        $this->assertInstanceOf('UsersViewList', $view);

        //checck with valid values and test if it returns correct view instance
        $type = 'detail';
        $target_module = 'Users';
        $bean = null;
        $view = ViewFactory::_buildFromFile('modules/'.$target_module.'/views/view.'.$type.'.php', $bean, array(), $type, $target_module);
        $this->assertInstanceOf('UsersViewDetail', $view);
    }

    public function test_buildClass()
    {

        //checck with valid values and test if it returns correct view instance
        $view = ViewFactory::_buildClass('UsersViewList', null, array());
        $this->assertInstanceOf('UsersViewList', $view);

        //checck with valid values and test if it returns correct view instance
        $view = ViewFactory::_buildClass('UsersViewDetail', null, array());
        $this->assertInstanceOf('UsersViewDetail', $view);
    }
}
