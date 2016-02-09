<?php
namespace SuiteCRM\Api\V8\Library;


class ModuleLib{

    function getAvailableModules($filter, $user)
    {
        if (empty($filter)) $filter = "all";
        $modules = array();
        $availModules = $this->get_user_module_list($user);
        switch ($filter) {
            case 'default':
                $modules = $this->get_visible_modules($availModules);
                break;
            case 'all':
            default:
                $modules = $this->getModulesFromList(array_flip($availModules), $availModules);
        }
        $ret = array();
        $ret['data'] =$modules;
        return $ret;
    }

    function get_user_module_list($user)
    {
        global $app_list_strings, $current_language, $beanList, $beanFiles;
        require_once('include/utils/security_utils.php');
        $app_list_strings = return_app_list_strings_language($current_language);
        $modules = query_module_access_list($user);
        \ACLController:: filterModuleList($modules, false);
        global $modInvisList;

        foreach ($modInvisList as $invis) {
            $modules[$invis] = 'read_only';
        }

        $actions = \ACLAction::getUserActions($user->id, true);
        //Remove all modules that don't have a beanFiles entry associated with it
        foreach ($modules as $module_name => $module) {
            if (isset($beanList[$module_name])) {
                $class_name = $beanList[$module_name];
                if (empty($beanFiles[$class_name])) {
                    unset($modules[$module_name]);
                }
            } else {
                unset($modules[$module_name]);
            }
        }

        return $modules;

    }

    function get_visible_modules($availModules)
    {
        require_once("modules/MySettings/TabController.php");
        $controller = new \TabController();
        $tabs = $controller->get_tabs_system();
        return getModulesFromList($tabs[0], $availModules);

    }

    function getModulesFromList($list, $availModules)
    {
        global $app_list_strings;
        $enabled_modules = array();
        $availModulesKey = array_flip($availModules);
        foreach ($list as $key => $value) {
            if (isset($availModulesKey[$key])) {
                $label = !empty($app_list_strings['moduleList'][$key]) ? $app_list_strings['moduleList'][$key] : '';
                $acl = $this->checkModuleRoleAccess($key);
                $enabled_modules[] = array('module_key' => $key, 'module_label' => $label, 'acls' => $acl);
            }
        }
        return $enabled_modules;
    }

    function checkModuleRoleAccess($module)
    {
        $results = array();
        $actions = array('edit', 'delete', 'list', 'view', 'import', 'export');
        foreach ($actions as $action) {
            $access = \ACLController::checkAccess($module, $action, true);
            $results[] = array('action' => $action, 'access' => $access);
        }

        return $results;
    }


}