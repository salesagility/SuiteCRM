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

    function getModuleLayout($modules,$views,$types,$hash)
    {
        global $beanList, $beanFiles;
        $results = array();
        foreach ($modules as $module_name) {
            $class_name = $beanList[$module_name];
            require_once($beanFiles[$class_name]);
            $seed = new $class_name();

            foreach ($views as $view) {
                $aclViewCheck = (strtolower($view) == 'subpanel') ? 'DetailView' : ucfirst(strtolower($view)) . 'View';
                foreach ($types as $type) {
                    $a_vardefs = $this->get_module_view_defs($module_name, $type, $view);
                    if (strtolower($hash === "true"))
                        $results[$module_name][$type][$view] = md5(serialize($a_vardefs));
                    else
                        $results[$module_name][$type][$view] = $a_vardefs;
                }
            }
        }

        return $results;
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

    function get_module_view_defs($module_name, $type, $view)
    {
        global $viewdefs, $listViewDefs;
        require_once('include/MVC/View/SugarView.php');
        $metadataFile = null;
        $results = array();
        $view = strtolower($view);
        switch (strtolower($type)) {
            case 'default':
            default:
                if ($view == 'subpanel')
                    $results = $this->get_subpanel_defs($module_name, $type);
                else {
                    $v = new \SugarView(null, array());
                    $v->module = $module_name;
                    $v->type = $view;
                    $fullView = ucfirst($view) . 'View';
                    $metadataFile = $v->getMetaDataFile();

                    if($metadataFile !== null)
                    {
                        require_once($metadataFile);
                        if ($view == 'list')
                            $results = $listViewDefs[$module_name];
                        else
                            $results = $viewdefs[$module_name][$fullView];
                    }

                }
        }

        return $results;
    }

    function getModuleLinks($bean)
    {
        return $bean->get_linked_fields();
    }

    function getModuleFields($module,$fields)
    {
        global $beanList, $beanFiles;

        $module_fields = array();
        $class_name = $beanList[$module];
        require_once($beanFiles[$class_name]);
        $seed = new $class_name();
        $list = $this->get_return_module_fields($seed, $module, $fields);
        return $list;
    }

    function get_subpanel_defs($module, $type)
    {
        global $beanList, $beanFiles, $layout_defs, $app_list_strings;
        $results = array();
        switch ($type) {
            case 'default':
            default:
                if (file_exists('modules/' . $module . '/metadata/subpaneldefs.php'))
                    require('modules/' . $module . '/metadata/subpaneldefs.php');
                if (file_exists('custom/modules/' . $module . '/Ext/Layoutdefs/layoutdefs.ext.php'))
                    require('custom/modules/' . $module . '/Ext/Layoutdefs/layoutdefs.ext.php');
        }

        //Filter results for permissions
        foreach ($layout_defs[$module]['subpanel_setup'] as $subpanel => $subpaneldefs) {
            $moduleToCheck = $subpaneldefs['module'];
            if (!isset($beanList[$moduleToCheck]))
                continue;
            $class_name = $beanList[$moduleToCheck];
            $bean = new $class_name();
            if ($bean->ACLAccess('list'))
                $results[$subpanel] = $subpaneldefs;
        }

        return $results;

    }

    function get_return_module_fields($value, $module, $fields, $translate = true)
    {
        global $module_name;
        $module_name = $module;
        $result = $this->get_field_list($value, $fields, $translate);
        $tableName = $value->getTableName();

        return Array('module_name' => $module, 'table_name' => $tableName,
            'module_fields' => $result['module_fields'],
            'link_fields' => $result['link_fields'],
        );
    }

    function get_field_list($value, $fields, $translate = true)
    {
        $module_fields = array();
        $link_fields = array();
        if (!empty($value->field_defs)) {

            foreach ($value->field_defs as $var) {
                if (!empty($fields) && !in_array($var['name'], $fields)) continue;
                if (isset($var['source']) && ($var['source'] != 'db' && $var['source'] != 'non-db' && $var['source'] != 'custom_fields') && $var['name'] != 'email1' && $var['name'] != 'email2' && (!isset($var['type']) || $var['type'] != 'relate')) continue;
                if ((isset($var['source']) && $var['source'] == 'non_db') && (isset($var['type']) && $var['type'] != 'link')) {
                    continue;
                }
                $required = 0;
                $options_dom = array();
                $options_ret = array();
                // Apparently the only purpose of this check is to make sure we only return fields
                //   when we've read a record.  Otherwise this function is identical to get_module_field_list
                if (isset($var['required']) && ($var['required'] || $var['required'] == 'true')) {
                    $required = 1;
                }

                if ($var['type'] == 'bool')
                    $var['options'] = 'checkbox_dom';

                if (isset($var['options'])) {
                    $options_dom = translate($var['options'], $value->module_dir);
                    if (!is_array($options_dom)) $options_dom = array();
                    foreach ($options_dom as $key => $oneOption)
                        $options_ret[$key] = get_name_value($key, $oneOption);
                }

                if (!empty($var['dbType']) && $var['type'] == 'bool') {
                    $options_ret['type'] = get_name_value('type', $var['dbType']);
                }

                $entry = array();
                $entry['name'] = $var['name'];
                $entry['type'] = $var['type'];
                $entry['group'] = isset($var['group']) ? $var['group'] : '';
                $entry['id_name'] = isset($var['id_name']) ? $var['id_name'] : '';

                if ($var['type'] == 'link') {
                    $entry['relationship'] = (isset($var['relationship']) ? $var['relationship'] : '');
                    $entry['module'] = (isset($var['module']) ? $var['module'] : '');
                    $entry['bean_name'] = (isset($var['bean_name']) ? $var['bean_name'] : '');
                    $link_fields[$var['name']] = $entry;
                } else {
                    if ($translate) {
                        $entry['label'] = isset($var['vname']) ? translate($var['vname'], $value->module_dir) : $var['name'];
                    } else {
                        $entry['label'] = isset($var['vname']) ? $var['vname'] : $var['name'];
                    }
                    $entry['required'] = $required;
                    $entry['options'] = $options_ret;
                    $entry['related_module'] = (isset($var['id_name']) && isset($var['module'])) ? $var['module'] : '';
                    $entry['calculated'] = (isset($var['calculated']) && $var['calculated']) ? true : false;
                    if (isset($var['default'])) {
                        $entry['default_value'] = $var['default'];
                    }
                    if ($var['type'] == 'parent' && isset($var['type_name']))
                        $entry['type_name'] = $var['type_name'];

                    $module_fields[$var['name']] = $entry;
                } // else
            } //foreach
        } //if

        if ($value->module_dir == 'Meetings' || $value->module_dir == 'Calls') {
            if (isset($module_fields['duration_minutes']) && isset($GLOBALS['app_list_strings']['duration_intervals'])) {
                $options_dom = $GLOBALS['app_list_strings']['duration_intervals'];
                $options_ret = array();
                foreach ($options_dom as $key => $oneOption)
                    $options_ret[$key] = get_name_value($key, $oneOption);

                $module_fields['duration_minutes']['options'] = $options_ret;
            }
        }

        if ($value->module_dir == 'Bugs') {
            require_once('modules/Releases/Release.php');
            $seedRelease = new Release();
            $options = $seedRelease->get_releases(TRUE, "Active");
            $options_ret = array();
            foreach ($options as $name => $value) {
                $options_ret[] = array('name' => $name, 'value' => $value);
            }
            if (isset($module_fields['fixed_in_release'])) {
                $module_fields['fixed_in_release']['type'] = 'enum';
                $module_fields['fixed_in_release']['options'] = $options_ret;
            }
            if (isset($module_fields['found_in_release'])) {
                $module_fields['found_in_release']['type'] = 'enum';
                $module_fields['found_in_release']['options'] = $options_ret;
            }
            if (isset($module_fields['release'])) {
                $module_fields['release']['type'] = 'enum';
                $module_fields['release']['options'] = $options_ret;
            }
            if (isset($module_fields['release_name'])) {
                $module_fields['release_name']['type'] = 'enum';
                $module_fields['release_name']['options'] = $options_ret;
            }
        }

        if (isset($value->assigned_user_name) && isset($module_fields['assigned_user_id'])) {
            $module_fields['assigned_user_name'] = $module_fields['assigned_user_id'];
            $module_fields['assigned_user_name']['name'] = 'assigned_user_name';
        }
        if (isset($value->assigned_name) && isset($module_fields['team_id'])) {
            $module_fields['team_name'] = $module_fields['team_id'];
            $module_fields['team_name']['name'] = 'team_name';
        }
        if (isset($module_fields['modified_user_id'])) {
            $module_fields['modified_by_name'] = $module_fields['modified_user_id'];
            $module_fields['modified_by_name']['name'] = 'modified_by_name';
        }
        if (isset($module_fields['created_by'])) {
            $module_fields['created_by_name'] = $module_fields['created_by'];
            $module_fields['created_by_name']['name'] = 'created_by_name';
        }

        return array('module_fields' => $module_fields, 'link_fields' => $link_fields);
    }


}