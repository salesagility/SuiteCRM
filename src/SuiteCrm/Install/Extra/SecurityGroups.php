<?php
/**
 * Created by Adam Jakab.
 * Date: 26/04/16
 * Time: 10.00
 */

namespace SuiteCrm\Install\Extra;

/**
 * Class SecurityGroups
 * @package SuiteCrm\Install\Extra
 */
class SecurityGroups implements ExtraInterface
{
    /**
     * @param array $config
     */
    public function execute($config) {
        /** array $sugar_config */
        global $sugar_config;
        /** If this is the first install set some default settings */
        if (!array_key_exists('securitysuite_additive', $sugar_config)) {
            $sugar_config['securitysuite_additive'] = true;
            $sugar_config['securitysuite_user_role_precedence'] = true;
            $sugar_config['securitysuite_user_popup'] = true;
            $sugar_config['securitysuite_popup_select'] = false;
            $sugar_config['securitysuite_inherit_creator'] = true;
            $sugar_config['securitysuite_inherit_parent'] = true;
            $sugar_config['securitysuite_inherit_assigned'] = true;
            $sugar_config['securitysuite_strict_rights'] = false;
        }

        if (!array_key_exists('securitysuite_strict_rights', $sugar_config)) {
            $sugar_config['securitysuite_strict_rights'] = true;
        }

        if (!array_key_exists('securitysuite_filter_user_list', $sugar_config)) {
            $sugar_config['securitysuite_filter_user_list'] = false;
        }
        $sugar_config['securitysuite_version'] = '6.5.17';

        ksort($sugar_config);
        write_array_to_file('sugar_config', $sugar_config, 'config.php');
        $this->installHooks();
    }


    protected function installHooks()
    {
        $hooks = array(
            array(
                'module' => '',
                'hook' => 'after_ui_footer',
                'order' => 10,
                'description' => 'popup_onload',
                'file' => 'modules/SecurityGroups/AssignGroups.php',
                'class' => 'AssignGroups',
                'function' => 'popup_onload',
            ),
            array(
                'module' => '',
                'hook' => 'after_ui_frame',
                'order' => 20,
                'description' => 'mass_assign',
                'file' => 'modules/SecurityGroups/AssignGroups.php',
                'class' => 'AssignGroups',
                'function' => 'mass_assign',
            ),
            array(
                'module' => '',
                'hook' => 'after_save',
                'order' => 30,
                'description' => 'popup_select',
                'file' => 'modules/SecurityGroups/AssignGroups.php',
                'class' => 'AssignGroups',
                'function' => 'popup_select',
            ),
        );

        foreach ($hooks as $hook) {
            check_logic_hook_file($hook['module'], $hook['hook'], array($hook['order'], $hook['description'], $hook['file'], $hook['class'], $hook['function']));
        }

    }
}