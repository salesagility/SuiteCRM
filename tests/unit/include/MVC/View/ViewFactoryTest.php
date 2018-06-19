<?php


class ViewFactoryTest extends SuiteCRM\StateCheckerPHPUnitTestCaseAbstract
{
    public function testloadView()
    {
        $state = new SuiteCRM\StateSaver();
        
        
        
        

        
        $view = ViewFactory::loadView('default', '');
        $this->assertInstanceOf('SugarView', $view);

        
        $view = ViewFactory::loadView('default', 'Users');
        $this->assertInstanceOf('SugarView', $view);

        
        $view = ViewFactory::loadView('list', 'Users');
        $this->assertInstanceOf('UsersViewList', $view);
        
        
        
        
    }

    public function test_loadConfig()
    {
        
        $view = ViewFactory::loadView('default', '');
        $options = $view->options;
        ViewFactory::_loadConfig($view, 'default');
        $this->assertSame($options, $view->options);

        
         $view = ViewFactory::loadView('detail', 'Users');
        $options = $view->options;
        ViewFactory::_loadConfig($view, 'detail');
        $this->assertSame($options, $view->options);

        
        $view = ViewFactory::loadView('area_detail_map', 'jjwg_Areas');
        $view->module = 'jjwg_Areas';
        $options = $view->options;
        ViewFactory::_loadConfig($view, 'area_detail_map');
        $this->assertSame($options, $view->options);
    }

    public function test_buildFromFile()
    {

        
        $type = 'list';
        $target_module = 'Users';
        $bean = null;
        $view = ViewFactory::_buildFromFile('modules/'.$target_module.'/views/view.'.$type.'.php', $bean, array(), $type, $target_module);
        $this->assertInstanceOf('UsersViewList', $view);

        
        $type = 'detail';
        $target_module = 'Users';
        $bean = null;
        $view = ViewFactory::_buildFromFile('modules/'.$target_module.'/views/view.'.$type.'.php', $bean, array(), $type, $target_module);
        $this->assertInstanceOf('UsersViewDetail', $view);
    }

    public function test_buildClass()
    {

        
        $view = ViewFactory::_buildClass('UsersViewList', null, array());
        $this->assertInstanceOf('UsersViewList', $view);

        
        $view = ViewFactory::_buildClass('UsersViewDetail', null, array());
        $this->assertInstanceOf('UsersViewDetail', $view);
    }
}
