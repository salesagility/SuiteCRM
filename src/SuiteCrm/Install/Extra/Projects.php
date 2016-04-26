<?php
/**
 * Created by Adam Jakab.
 * Date: 26/04/16
 * Time: 10.00
 */

namespace SuiteCrm\Install\Extra;

/**
 * Class Projects
 * @package SuiteCrm\Install\Extra
 */
class Projects implements ExtraInterface
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
            //Projects
            array(
                'module' => 'Projects',
                'hook' => 'before_delete',
                'order' => 1,
                'description' => 'Delete Project Tasks',
                'file' => 'modules/Project/delete_project_tasks.php',
                'class' => 'delete_project_tasks',
                'function' => 'delete_tasks',
            ),
            // ProjectTasks
            array(
                'module' => 'ProjectTask',
                'hook' => 'before_save',
                'order' => 1,
                'description' => 'update project end date',
                'file' => 'modules/ProjectTask/updateDependencies.php',
                'class' => 'updateDependencies',
                'function' => 'update_dependency',
            ),
            array(
                'module' => 'ProjectTask',
                'hook' => 'after_save',
                'order' => 1,
                'description' => 'update project end date',
                'file' => 'modules/ProjectTask/updateProject.php',
                'class' => 'updateEndDate',
                'function' => 'update',
            ),
        );

        foreach ($hooks as $hook) {
            check_logic_hook_file($hook['module'], $hook['hook'], array($hook['order'], $hook['description'], $hook['file'], $hook['class'], $hook['function']));
        }
    }
}