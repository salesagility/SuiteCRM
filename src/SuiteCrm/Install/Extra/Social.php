<?php
/**
 * Created by Adam Jakab.
 * Date: 26/04/16
 * Time: 10.00
 */

namespace SuiteCrm\Install\Extra;

/**
 * Class Social
 * @package SuiteCrm\Install\Extra
 */
class Social implements ExtraInterface
{
    /**
     * @param array $config
     */
    public function execute($config) {
        $this->installHooks();
    }


    protected function installHooks()
    {
        $hooks = array(
            array(
                'module' => '',
                'hook' => 'after_ui_frame',
                'order' => 1,
                'description' => 'Load Social JS',
                'file' => 'include/social/hooks.php',
                'class' => 'hooks',
                'function' => 'load_js',
            ),
        );

        foreach ($hooks as $hook) {
            check_logic_hook_file($hook['module'], $hook['hook'], array($hook['order'], $hook['description'], $hook['file'], $hook['class'], $hook['function']));
        }
    }
}