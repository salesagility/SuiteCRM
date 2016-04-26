<?php
/**
 * Created by Adam Jakab.
 * Date: 26/04/16
 * Time: 10.00
 */

namespace SuiteCrm\Install\Extra;

/**
 * Class Reschedule
 * @package SuiteCrm\Install\Extra
 */
class Reschedule implements ExtraInterface
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
            //Calls
            array(
                'module' => 'Calls',
                'hook' => 'process_record',
                'order' => 1,
                'description' => 'count',
                'file' => 'modules/Calls_Reschedule/reschedule_count.php',
                'class' => 'reschedule_count',
                'function' => 'count',
            ),
        );

        foreach ($hooks as $hook) {
            check_logic_hook_file($hook['module'], $hook['hook'], array($hook['order'], $hook['description'], $hook['file'], $hook['class'], $hook['function']));
        }
    }
}