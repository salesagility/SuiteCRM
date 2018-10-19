<?php

use org\bovigo\vfs\vfsStream;

require_once 'include/utils/logic_utils.php';

class logic_utilsTest extends SuiteCRM\StateCheckerUnitAbstract
{
    public function testget_hook_array()
    {
        //test with a vaid module. it will return an array
        if (file_exists("custom/modules/Accounts/logic_hooks.php")) {
            $AccountsHooks = get_hook_array('Accounts');
            $this->assertTrue(is_array($AccountsHooks));
        }

        //test with an invalid array. it will throw an file include exception.
        $BugsHooks = '';
        try {
            $BugsHooks = get_hook_array('Bugs');
        } catch (Exception $e) {
        }

        $this->assertFalse(is_array($BugsHooks));
    }

    private function getTestHook()
    {

        //array containing hooks array to test

        $hook_array = array();
        $hook_array['after_ui_footer'] = array();
        $hook_array['after_ui_footer'][] = array(
            10,
            'popup_onload',
            'modules/SecurityGroups/AssignGroups.php',
            'AssignGroups',
            'popup_onload'
        );
        $hook_array['after_ui_frame'] = array();
        $hook_array['after_ui_frame'][] = array(
            20,
            'mass_assign',
            'modules/SecurityGroups/AssignGroups.php',
            'AssignGroups',
            'mass_assign'
        );
        $hook_array['after_ui_frame'][] = array(
            1,
            'Load Social JS',
            'custom/include/social/hooks.php',
            'hooks',
            'load_js'
        );
        $hook_array['after_save'] = array();
        $hook_array['after_save'][] = array(
            30,
            'popup_select',
            'modules/SecurityGroups/AssignGroups.php',
            'AssignGroups',
            'popup_select'
        );
        $hook_array['after_save'][] = array(
            1,
            'AOD Index Changes',
            'modules/AOD_Index/AOD_LogicHooks.php',
            'AOD_LogicHooks',
            'saveModuleChanges'
        );
        $hook_array['after_delete'] = array();
        $hook_array['after_delete'][] = array(
            1,
            'AOD Index changes',
            'modules/AOD_Index/AOD_LogicHooks.php',
            'AOD_LogicHooks',
            'saveModuleDelete'
        );
        $hook_array['after_restore'] = array();
        $hook_array['after_restore'][] = array(
            1,
            'AOD Index changes',
            'modules/AOD_Index/AOD_LogicHooks.php',
            'AOD_LogicHooks',
            'saveModuleRestore'
        );

        return $hook_array;
    }

    public function check_existing_elementProvider()
    {
        //provide test cases dataset to validate

        $hook_array = $this->getTestHook();

        return array(
            array($hook_array, 'after_save', array(0, 'popup_select'), true),
            array($hook_array, 'after_save', array(0, 'foo'), false),
            array($hook_array, 'foo', array(0, 'popup_select'), false),
        );
    }

    /**
     * @dataProvider check_existing_elementProvider
     */
    public function testcheck_existing_element($hook_array, $event, $action_array, $expected)
    {
        //test with dataset containing valid and invalid cases
        $this->assertSame(check_existing_element($hook_array, $event, $action_array), $expected);
    }

    public function testreplace_or_add_logic_type()
    {
        //execute the method and test if it returns expected values

        $hook_array = $this->getTestHook();
        $expected = "<?php\n// Do not store anything in this file that is not part of the array or the hook version.  This file will	\n// be automatically rebuilt in the future. \n \$hook_version = 1; \n\$hook_array = Array(); \n// position, file, function \n\$hook_array['after_ui_footer'] = Array(); \n\$hook_array['after_ui_footer'][] = Array(10, 'popup_onload', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_onload'); \n\$hook_array['after_ui_frame'] = Array(); \n\$hook_array['after_ui_frame'][] = Array(20, 'mass_assign', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'mass_assign'); \n\$hook_array['after_ui_frame'][] = Array(1, 'Load Social JS', 'custom/include/social/hooks.php','hooks', 'load_js'); \n\$hook_array['after_save'] = Array(); \n\$hook_array['after_save'][] = Array(30, 'popup_select', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_select'); \n\$hook_array['after_save'][] = Array(1, 'AOD Index Changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleChanges'); \n\$hook_array['after_delete'] = Array(); \n\$hook_array['after_delete'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleDelete'); \n\$hook_array['after_restore'] = Array(); \n\$hook_array['after_restore'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleRestore'); \n\n\n\n?>";
        $this->assertEquals($expected, replace_or_add_logic_type($hook_array));
    }

    public function testwrite_logic_file()
    {
        //execute the method and test if it returns expected values,
        //check if file is created and contains expected contents

        $vfs = vfsStream::setup('custom/modules/TEST_Test');

        if ($vfs->hasChild('logic_hooks.php') == true) {
            unlink('custom/modules/TEST_Test/logic_hooks.php');
            rmdir('custom/modules/TEST_Test');
        }

        $expectedContents = "<?php\n// Do not store anything in this file that is not part of the array or the hook version.  This file will	\n// be automatically rebuilt in the future. \n \$hook_version = 1; \n\$hook_array = Array(); \n// position, file, function \n\$hook_array['after_ui_footer'] = Array(); \n\$hook_array['after_ui_footer'][] = Array(10, 'popup_onload', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_onload'); \n\$hook_array['after_ui_frame'] = Array(); \n\$hook_array['after_ui_frame'][] = Array(20, 'mass_assign', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'mass_assign'); \n\$hook_array['after_ui_frame'][] = Array(1, 'Load Social JS', 'custom/include/social/hooks.php','hooks', 'load_js'); \n\$hook_array['after_save'] = Array(); \n\$hook_array['after_save'][] = Array(30, 'popup_select', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_select'); \n\$hook_array['after_save'][] = Array(1, 'AOD Index Changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleChanges'); \n\$hook_array['after_delete'] = Array(); \n\$hook_array['after_delete'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleDelete'); \n\$hook_array['after_restore'] = Array(); \n\$hook_array['after_restore'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleRestore'); \n\n\n\n?>";
        write_logic_file('TEST_Test', $expectedContents);

        //Check file created
        $this->assertFileExists('custom/modules/TEST_Test/logic_hooks.php');
        $actualContents = file_get_contents('custom/modules/TEST_Test/logic_hooks.php');
        $this->assertSame($expectedContents, $actualContents);

        $expectedArray = $this->getTestHook();

        $actualArray = get_hook_array('TEST_Test');

        $this->assertSame($expectedArray, $actualArray);

        unlink('custom/modules/TEST_Test/logic_hooks.php');
        rmdir('custom/modules/TEST_Test');
    }

    public function testbuild_logic_file()
    {
        //execute the method and test if it returns expected values

        $hook_array = $this->getTestHook();
        $expected = "// Do not store anything in this file that is not part of the array or the hook version.  This file will	\n// be automatically rebuilt in the future. \n \$hook_version = 1; \n\$hook_array = Array(); \n// position, file, function \n\$hook_array['after_ui_footer'] = Array(); \n\$hook_array['after_ui_footer'][] = Array(10, 'popup_onload', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_onload'); \n\$hook_array['after_ui_frame'] = Array(); \n\$hook_array['after_ui_frame'][] = Array(20, 'mass_assign', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'mass_assign'); \n\$hook_array['after_ui_frame'][] = Array(1, 'Load Social JS', 'custom/include/social/hooks.php','hooks', 'load_js'); \n\$hook_array['after_save'] = Array(); \n\$hook_array['after_save'][] = Array(30, 'popup_select', 'modules/SecurityGroups/AssignGroups.php','AssignGroups', 'popup_select'); \n\$hook_array['after_save'][] = Array(1, 'AOD Index Changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleChanges'); \n\$hook_array['after_delete'] = Array(); \n\$hook_array['after_delete'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleDelete'); \n\$hook_array['after_restore'] = Array(); \n\$hook_array['after_restore'][] = Array(1, 'AOD Index changes', 'modules/AOD_Index/AOD_LogicHooks.php','AOD_LogicHooks', 'saveModuleRestore'); \n\n\n";
        $this->assertEquals($expected, build_logic_file($hook_array));
    }
}
