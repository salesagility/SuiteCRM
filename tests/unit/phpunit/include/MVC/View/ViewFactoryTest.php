<?php

use SuiteCRM\Tests\SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class ViewFactoryTest extends SuitePHPUnitFrameworkTestCase
{
    public function testloadView(): void
    {
        //check with invalid input. must return sugaview instance
        $view = ViewFactory::loadView('default', '');
        self::assertInstanceOf('SugarView', $view);

        //check with a valid module without a specific view, must return sugarview instance
        $view = ViewFactory::loadView('default', 'Users');
        self::assertInstanceOf('SugarView', $view);

        //check with a valid module and specific view, must reutern speciifc view instance
        $view = ViewFactory::loadView('list', 'Users');
        self::assertInstanceOf('UsersViewList', $view);
    }

    public function test_loadConfig(): void
    {
        //check with a invalid module, method must not change the view options.
        $view = ViewFactory::loadView('default', '');
        $options = $view->options;
        ViewFactory::_loadConfig($view, 'default');
        self::assertSame($options, $view->options);

        //check with a valid module which does not implement it's own view config. method must not change the view options.
        $view = ViewFactory::loadView('detail', 'Users');
        $options = $view->options;
        ViewFactory::_loadConfig($view, 'detail');
        self::assertSame($options, $view->options);

        //check with a valid module which implement it's own view config. method still must not change the view options because it needs.
        $view = ViewFactory::loadView('area_detail_map', 'jjwg_Areas');
        $view->module = 'jjwg_Areas';
        $options = $view->options;
        ViewFactory::_loadConfig($view, 'area_detail_map');
        self::assertSame($options, $view->options);
    }

    public function test_buildFromFile(): void
    {
        //check with valid values and test if it returns correct view instance
        $type = 'list';
        $target_module = 'Users';
        $bean = null;
        $view = ViewFactory::_buildFromFile('modules/'.$target_module.'/views/view.'.$type.'.php', $bean, array(), $type, $target_module);
        self::assertInstanceOf('UsersViewList', $view);

        //check with valid values and test if it returns correct view instance
        $type = 'detail';
        $target_module = 'Users';
        $bean = null;
        $view = ViewFactory::_buildFromFile('modules/'.$target_module.'/views/view.'.$type.'.php', $bean, array(), $type, $target_module);
        self::assertInstanceOf('UsersViewDetail', $view);
    }

    public function test_buildClass(): void
    {
        //check with valid values and test if it returns correct view instance
        $view = ViewFactory::_buildClass('UsersViewList', null, array());
        self::assertInstanceOf('UsersViewList', $view);

        //check with valid values and test if it returns correct view instance
        $view = ViewFactory::_buildClass('UsersViewDetail', null, array());
        self::assertInstanceOf('UsersViewDetail', $view);
    }
}
