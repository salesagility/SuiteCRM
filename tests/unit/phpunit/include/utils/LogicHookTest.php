<?php

use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

class LogicHookTest extends SuitePHPUnitFrameworkTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testinitialize()
    {
        //execute the method and test if it returns correct class instances
        $LogicHook = LogicHook::initialize();
        self::assertInstanceOf('LogicHook', $LogicHook);
    }

    public function testLogicHook()
    {
        //execute the method and test if it doesn't throw an exception
        try {
            $LogicHook = new LogicHook();
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testsetBean()
    {
        //execute the method and test if it returns correct class instances
        $result = (new LogicHook())->setBean(BeanFactory::newBean('Users'));
        self::assertInstanceOf('LogicHook', $result);
        self::assertInstanceOf('User', $result->bean);
    }

    public function testgetHooksMap()
    {
        //execute the method and test if it returns true
        $hook_map = (new LogicHook())->getHooksMap();
        self::assertTrue(is_array($hook_map));
    }

    public function testgetHooksList()
    {
        //execute the method and test if it returns true
        $hookscan = (new LogicHook())->getHooksList();
        self::assertTrue(is_array($hookscan));
    }

    public function testscanHooksDir()
    {
        //execute the method and test if it returns expected contents
        $expected_hook_map = array(
            'before_save' =>
                array(
                    array('file' => 'custom/modules/Accounts/logic_hooks.php', 'index' => 0,),
                ),
            'after_save' =>
                array(
                    array('file' => 'custom/modules/Accounts/logic_hooks.php', 'index' => 0,),
                    array('file' => 'custom/modules/Accounts/logic_hooks.php', 'index' => 1,),
                    array('file' => 'custom/modules/Accounts/logic_hooks.php', 'index' => 2,),
                    array('file' => 'custom/modules/Accounts/logic_hooks.php', 'index' => 3,),
                ),
            'after_relationship_add' =>
                array(
                    array('file' => 'custom/modules/Accounts/logic_hooks.php', 'index' => 0,),
                ),
            'after_relationship_delete' =>
                array(
                    array('file' => 'custom/modules/Accounts/logic_hooks.php', 'index' => 0,),
                ),
        );


        $expected_hookscan = array(
            'before_save' =>
                array(
                    array(
                        77,
                        'updateGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateGeocodeInfo',
                    ),
                ),
            'after_save' =>
                array(
                    array(
                        77,
                        'updateRelatedMeetingsGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateRelatedMeetingsGeocodeInfo',
                    ),
                    array(
                        78,
                        'updateRelatedProjectGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateRelatedProjectGeocodeInfo',
                    ),
                    array(
                        79,
                        'updateRelatedOpportunitiesGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateRelatedOpportunitiesGeocodeInfo',
                    ),
                    array(
                        80,
                        'updateRelatedCasesGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateRelatedCasesGeocodeInfo',
                    ),
                ),
            'after_relationship_add' =>
                array(
                    array(
                        77,
                        'addRelationship',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'addRelationship',
                    ),
                ),
            'after_relationship_delete' =>
                array(
                    array(
                        77,
                        'deleteRelationship',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'deleteRelationship',
                    ),
                ),
        );

        $LogicHook = new LogicHook();
        $LogicHook->scanHooksDir('custom/modules/Accounts');
        $hook_map = $LogicHook->getHooksMap();
        $hookscan = $LogicHook->getHooksList();


        if (file_exists('custom/modules/Accounts') && is_dir('custom/modules/Accounts')) {
            self::assertSame($expected_hook_map, $hook_map);
            self::assertSame($expected_hookscan, $hookscan);
        } else {
            self::assertTrue(empty($hook_map));
            self::assertTrue(empty($hookscan));
        }
    }

    public function testrefreshHooks()
    {
        //execute the method and test if it doesn't throws an exception
        try {
            LogicHook::refreshHooks();
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testloadHooks()
    {
        //execute the method and test if it returns expected contents
        $expected_accounts = array(
            'before_save' => array(
                array(
                    77,
                    'updateGeocodeInfo',
                    'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                    'AccountsJjwg_MapsLogicHook',
                    'updateGeocodeInfo'
                ),
            ),
            'after_save' => array(
                array(
                    77,
                    'updateRelatedMeetingsGeocodeInfo',
                    'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                    'AccountsJjwg_MapsLogicHook',
                    'updateRelatedMeetingsGeocodeInfo'
                ),
                array(
                    78,
                    'updateRelatedProjectGeocodeInfo',
                    'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                    'AccountsJjwg_MapsLogicHook',
                    'updateRelatedProjectGeocodeInfo'
                ),
                array(
                    79,
                    'updateRelatedOpportunitiesGeocodeInfo',
                    'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                    'AccountsJjwg_MapsLogicHook',
                    'updateRelatedOpportunitiesGeocodeInfo'
                ),
                array(
                    80,
                    'updateRelatedCasesGeocodeInfo',
                    'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                    'AccountsJjwg_MapsLogicHook',
                    'updateRelatedCasesGeocodeInfo'
                ),
            ),
            'after_relationship_add' => array(
                array(
                    77,
                    'addRelationship',
                    'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                    'AccountsJjwg_MapsLogicHook',
                    'addRelationship'
                ),
            ),
            'after_relationship_delete' => array(
                array(
                    77,
                    'deleteRelationship',
                    'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                    'AccountsJjwg_MapsLogicHook',
                    'deleteRelationship'
                ),
            ),
        );

        $expected_default = array(
            'after_save' => array(
                array(
                    1,
                    'AOD Index Changes',
                    'modules/AOD_Index/AOD_LogicHooks.php',
                    'AOD_LogicHooks',
                    'saveModuleChanges'
                ),
                array(30, 'popup_select', 'modules/SecurityGroups/AssignGroups.php', 'AssignGroups', 'popup_select'),
                array(99, 'AOW_Workflow', 'modules/AOW_WorkFlow/AOW_WorkFlow.php', 'AOW_WorkFlow', 'run_bean_flows'),
            ),
            'after_delete' => array(
                array(
                    1,
                    'AOD Index changes',
                    'modules/AOD_Index/AOD_LogicHooks.php',
                    'AOD_LogicHooks',
                    'saveModuleDelete'
                ),
            ),
            'after_restore' => array(
                array(
                    1,
                    'AOD Index changes',
                    'modules/AOD_Index/AOD_LogicHooks.php',
                    'AOD_LogicHooks',
                    'saveModuleRestore'
                ),
            ),
            'after_ui_footer' => array(
                array(10, 'popup_onload', 'modules/SecurityGroups/AssignGroups.php', 'AssignGroups', 'popup_onload'),
            ),
            'after_ui_frame' => array(
                array(20, 'mass_assign', 'modules/SecurityGroups/AssignGroups.php', 'AssignGroups', 'mass_assign'),
                array(1, 'Load Social JS', 'include/social/hooks.php', 'hooks', 'load_js'),
            ),
        );

        $LogicHook = new LogicHook();

        //test with a valid module
        $accounts_hooks = $LogicHook->loadHooks('Accounts');
        if (
            file_exists("custom/modules/Accounts/logic_hooks.php") ||
            file_exists("custom/modules/Accounts/Ext/LogicHooks/logichooks.ext.php")
        ) {
            self::assertSame($expected_accounts, $accounts_hooks);
        } else {
            self::assertTrue(empty($accounts_hooks));
        }

        //test with an invalid module, it will get the application hooks
        $default_hooks = $LogicHook->loadHooks('');
        if (
            file_exists("custom/modules/logic_hooks.php") ||
            file_exists("custom/application/Ext/LogicHooks/logichooks.ext.php")
        ) {
            //$this->assertSame($expected_default, $default_hooks);
        } else {
            self::assertTrue(empty($default_hooks));
        }
    }

    /*
    public function testloadHooks()
    {
        //execute the method and test if it returns expected contents

        $expected_accounts = array (
                'after_ui_frame' => Array (),
                'before_save' =>
                array (
                        array (77, 'updateGeocodeInfo', 'modules/Accounts/AccountsJjwg_MapsLogicHook.php', 'AccountsJjwg_MapsLogicHook', 'updateGeocodeInfo',),
                ),
                'after_save' =>
                array (
                        array (77, 'updateRelatedMeetingsGeocodeInfo', 'modules/Accounts/AccountsJjwg_MapsLogicHook.php', 'AccountsJjwg_MapsLogicHook', 'updateRelatedMeetingsGeocodeInfo',),
                        array (78, 'updateRelatedProjectGeocodeInfo', 'modules/Accounts/AccountsJjwg_MapsLogicHook.php', 'AccountsJjwg_MapsLogicHook', 'updateRelatedProjectGeocodeInfo', ),
                        array (79, 'updateRelatedOpportunitiesGeocodeInfo', 'modules/Accounts/AccountsJjwg_MapsLogicHook.php', 'AccountsJjwg_MapsLogicHook', 'updateRelatedOpportunitiesGeocodeInfo',),
                        array (80, 'updateRelatedCasesGeocodeInfo', 'modules/Accounts/AccountsJjwg_MapsLogicHook.php', 'AccountsJjwg_MapsLogicHook', 'updateRelatedCasesGeocodeInfo',),
                ),
                'after_relationship_add' =>
                array (
                        array ( 77, 'addRelationship', 'modules/Accounts/AccountsJjwg_MapsLogicHook.php', 'AccountsJjwg_MapsLogicHook', 'addRelationship',),
                ),
                'after_relationship_delete' =>
                array (
                        array ( 77, 'deleteRelationship', 'modules/Accounts/AccountsJjwg_MapsLogicHook.php', 'AccountsJjwg_MapsLogicHook', 'deleteRelationship',),
                ),
        );

        $expected_default = array (
                    'after_ui_footer' =>
                    array (
                            array (10,'popup_onload','modules/SecurityGroups/AssignGroups.php','AssignGroups','popup_onload',),
                    ),
                    'after_ui_frame' =>
                    array (
                            array (20, 'mass_assign', 'modules/SecurityGroups/AssignGroups.php', 'AssignGroups', 'mass_assign',),
                            array ( 1, 'Load Social JS', 'include/social/hooks.php', 'hooks', 'load_js',),
                    ),
                    'after_save' =>
                    array (
                            array ( 30,'popup_select', 'modules/SecurityGroups/AssignGroups.php','AssignGroups','popup_select',),
                            array ( 1, 'AOD Index Changes', 'modules/AOD_Index/AOD_LogicHooks.php', 'AOD_LogicHooks', 'saveModuleChanges',),
                            array ( 99, 'AOW_Workflow', 'modules/AOW_WorkFlow/AOW_WorkFlow.php', 'AOW_WorkFlow','run_bean_flows',),
                    ),
                    'after_delete' =>
                    array (
                            array ( 1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php', 'AOD_LogicHooks','saveModuleDelete',),
                    ),
                    'after_restore' =>
                    array (
                            array ( 1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php', 'AOD_LogicHooks', 'saveModuleRestore',),
                    ),
                );



        $LogicHook = new LogicHook();

        //test with a valid module
        $accounts_hooks = $LogicHook->loadHooks('Accounts');
        $this->assertSame($expected_accounts, $accounts_hooks);

        //test with an invalid module, it will get the application hooks
        $default_hooks = $LogicHook->loadHooks('');
        $this->assertSame($expected_default, $default_hooks);

    }
*/
    public function testgetHooks()
    {
        //execute the method and test if it returns expected contents

        $expected = array(
            /*'after_ui_frame' => Array (),*/
            'before_save' =>
                array(
                    array(
                        77,
                        'updateGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateGeocodeInfo',
                    ),
                ),
            'after_save' =>
                array(
                    array(
                        77,
                        'updateRelatedMeetingsGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateRelatedMeetingsGeocodeInfo',
                    ),
                    array(
                        78,
                        'updateRelatedProjectGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateRelatedProjectGeocodeInfo',
                    ),
                    array(
                        79,
                        'updateRelatedOpportunitiesGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateRelatedOpportunitiesGeocodeInfo',
                    ),
                    array(
                        80,
                        'updateRelatedCasesGeocodeInfo',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'updateRelatedCasesGeocodeInfo',
                    ),
                ),
            'after_relationship_add' =>
                array(
                    array(
                        77,
                        'addRelationship',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'addRelationship',
                    ),
                ),
            'after_relationship_delete' =>
                array(
                    array(
                        77,
                        'deleteRelationship',
                        'modules/Accounts/AccountsJjwg_MapsLogicHook.php',
                        'AccountsJjwg_MapsLogicHook',
                        'deleteRelationship',
                    ),
                ),
        );

        $LogicHook = new LogicHook();

        //test with refresh false/default
        $hooks = $LogicHook->getHooks('Accounts');
        if (
            file_exists("custom/modules/Accounts/logic_hooks.php") ||
            file_exists("custom/modules/Accounts/Ext/LogicHooks/logichooks.ext.php")
        ) {
            self::assertEquals($expected, $hooks);
        } else {
            self::assertTrue(empty($hooks));
        }

        //test wit hrefresh true
        $hooks = $LogicHook->getHooks('Accounts', true);
        if (
            file_exists("custom/modules/Accounts/logic_hooks.php") ||
            file_exists("custom/modules/Accounts/Ext/LogicHooks/logichooks.ext.php")
        ) {
            self::assertSame($expected, $hooks);
        } else {
            self::assertTrue(empty($hooks));
        }
    }

    public function testcall_custom_logic()
    {
        //execute the method and test if it doesn't throws an exception
        $LogicHook = new LogicHook();
        $LogicHook->setBean(BeanFactory::newBean('Accounts'));

        try {
            $LogicHook->call_custom_logic('', 'after_ui_footer');
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }

    public function testprocess_hooks()
    {
        // execute the method and test if it doesn't throws an exception
        $LogicHook = new LogicHook();
        $LogicHook->setBean(BeanFactory::newBean('Accounts'));
        $hooks = $LogicHook->loadHooks('');

        try {
            $LogicHook->process_hooks($hooks, 'after_ui_footer', array());
            self::assertTrue(true);
        } catch (Exception $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }
    }
}
