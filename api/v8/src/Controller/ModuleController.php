<?php
namespace SuiteCRM\Controller;
use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;


class ModuleController extends Api{

    public function getModuleRecords(Request $req, Response $res, $args){


        $module = \BeanFactory::getBean($args['module_name']);
        if(is_object($module)){
            $records = $module->get_full_list();

            if(count($records)){
                foreach($records as $record){
                    $return_records[] = $record->toArray();
                }
            }


        }else{
            return $this->generateResponse($res, 400,NULL,'Module Not Found');

        }

        return $this->generateResponse($res,200,$return_records,'Success');

    }

    //SuiteCRM/service/api/v8/restapi.php/Accounts/142b9a59-e2d3-4e26-4bee-56531874548f
    function getModuleById(Request $req, Response $res, $args){
        //This will return the main bean first followed by an entry ([] for no-matching beans) for the items passed via
//the links[].
//E.g. Accounts/12345abc?links[]=contacts&links[]=cases&links[]=notes will return the account body first, followed by
//the contacts, cases, and notes in that order
        global $errorList, $param_links, $moduleList;
        $queryParams = $req->getQueryParams();

        $module = $args['module'];
        $id = $args['id'];

        $param_links = array();
        if(!empty($queryParams['links']))
            $param_links = $queryParams['links'] ;

        $ret = array();

        if (in_array($module, $moduleList)) {
            $matchingBean = \BeanFactory::getBean($module, $id);
            if ($matchingBean) {
                //return $matchingBean->toArray();
                $ret['module']= $matchingBean->toArray();

                if (!empty($param_links) && is_array($param_links)) {
                    $linkBeanList = $matchingBean->get_linked_fields();
                    $allLinkBeans = array();
                    foreach ($param_links as $link) {

                        //check that each of the supplied links match the vardefs?
                        //report the above elegantly if no link found
                        $item = $linkBeanList[$link];
                        $linkedBeans = $matchingBean->get_linked_beans($item['name'], $item['module']);
                        $beans = array();   //Clear the array before the next link parameter
                        foreach ($linkedBeans as $bean) {
                            $beans[] = $bean->toArray();
                        }

                        $allLinkBeans[$link]= $beans;
                    }
                    $ret['links'] = $allLinkBeans;

                }
                return $this->generateResponse($res,200,$ret,'Success');

            } else {
                $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but id not matched. Module = '.$module.' id = '.$id);
                return $this->generateResponse($res, 404,NULL,'Non-matched item');
            }
        } else {
            $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but module not matched. Module = '.$module.' id = '.$id);
            return $this->generateResponse($res, 404,NULL,'Non-matched item');
        }


    }

    function createModule(Request $req, Response $res, $args)
    {
        global $errorList, $moduleList;
        $module = $args['module'];
        $formParams = $req->getParsedBody();

        if (in_array($module, $moduleList)) {
            $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $module);
            $matchingBean = \BeanFactory::getBean($module);
            if (!empty($formParams['create'])) {
                foreach ($formParams['create'] as $item) {
                    //TODO make sure that the data is safe before it is inserted!
                    if(!empty($item['name']) && !empty($item['value']))
                    {
                        $itemToUpdate = $item['name'];
                        $updateValue = $item['value'];
                        $matchingBean->$itemToUpdate = $updateValue;
                    }
                }
            }
            $matchingBean->save();
            return $this->generateResponse($res,201,$matchingBean->id,'Success');
        } else {
            $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but module not matched.  Module = '.$module);
            return $this->generateResponse($res, 404,NULL,'Non-matched item');

        }


    }


    function updateModule(Request $req, Response $res, $args)
    {
        global $errorList, $moduleList;
        $formParams = $req->getParsedBody();
        $module = $args['module'];
        $id = $args['id'];

        if (in_array($module, $moduleList)) {
            $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $module);
            $matchingBean = \BeanFactory::getBean($module, $id);
            if (!empty($matchingBean)) {
                if (!empty($formParams['update'])) {
                    foreach ($formParams['update'] as $item) {
                        //TODO make sure that the data is safe before it is inserted!

                        if(!empty($item['name']) && !empty($item['value']))
                        {
                            $itemToUpdate = $item['name'];
                            $updateValue = $item['value'];
                            $matchingBean->$itemToUpdate = $updateValue;
                        }
                    }
                    $matchingBean->save();
                    return $this->generateResponse($res,200,NULL,'Success');
                }

            } else {
                $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but id not matched.  Module = '.$module.' Id= '.$id);
                return $this->generateResponse($res, 404,NULL,'Non-matched item');
            }
        } else {
            $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but module not matched.  Module = '.$module.' Id= '.$id);
            return $this->generateResponse($res, 404,NULL,'Non-matched item');
        }

    }

    function deleteModule(Request $req, Response $res, $args)
    {
        global $errorList, $moduleList;
        $module = $args['module'];
        $id = $args['id'];

        if (in_array($module, $moduleList)) {
            $matchingBean = \BeanFactory::getBean($module, $id);
            if (!empty($matchingBean)) {
                $matchingBean->mark_deleted($id);
                return $this->generateResponse($res,200,$id,'Success');
            } else {
                $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but id not matched.  Module = '.$module.' Id= '.$id);
                return $this->generateResponse($res, 404,NULL,'Non-matched item');
            }
        } else {
            $GLOBALS['log']->info(__FILE__.': '.__FUNCTION__.' called but module not matched.  Module = '.$module.' Id= '.$id);
            return $this->generateResponse($res, 404,NULL,'Non-matched item');
        }
    }


    ///language_definition?modules[]=Accounts&modules[]=Emails
    function getLanguageDefinition(Request $req, Response $res, $args)
    {
        global $beanList, $beanFiles, $sugar_config, $current_language;

        $queryParams = $req->getQueryParams();

        $modules = '';

        if(!empty($queryParams['modules']))
            $modules =$queryParams['modules'];

        $hash = 'false';

        if (isset($queryParams['hash']))
            $hash = $queryParams['hash'];

        $results = array();
        if (!empty($modules)) {
            foreach ($modules as $mod) {
                if (strtolower($mod) == 'app_strings') {
                    $values = return_application_language($current_language);
                    $key = 'app_strings';
                } else if (strtolower($mod) == 'app_list_strings') {
                    $values = return_app_list_strings_language($current_language);
                    $key = 'app_list_strings';
                } else {
                    $values = return_module_language($current_language, $mod);
                    $key = $mod;
                }

                if (strtolower($hash) === "true")
                    $values = md5(serialize($values));

                $results[$key] = $values;
            }
        }

        return $this->generateResponse($res,200,$results,'Success');

    }

    function getAvailableModules(Request $req, Response $res, $args)
    {
        global $userId, $errorList;

        $queryParams = $req->getQueryParams();

        $filter = 'all';
        if(!empty($queryParams['filter']))
            $filter = $queryParams['filter'];

        if ($userId !== null) {
            $user = \BeanFactory::getBean('Users', $userId);

            if ($user === false) {
                $GLOBALS['log']->warn(__FILE__.': ' . __FUNCTION__ . ' called but user not found for userid ' . $userId);
                return array("api_error" => true, "error" => $errorList["incorrect_login"]);
            } else {
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
                return $this->generateResponse($res,200,$modules,'Success');
            }


        } else {//The userid was not retrieved from the system
            $GLOBALS['log']->warn(__FILE__.': ' . __FUNCTION__ . ' called but user not found for userid ' . $userId);
            return $this->generateResponse($res,401,NULL,'Incorrect login');
        }
    }

    //last_viewed?modules[]=Accounts&modules[]=Emails
    function getLastViewed(Request $req, Response $res, $args)
    {
        global $errorList, $moduleList, $userId;
        $queryParams = $req->getQueryParams();

        $modules = '';
        if(!empty($queryParams['modules']))
            $modules =$queryParams['modules'];

        if ($userId !== null) {
            if ($modules !== null && is_array($modules)) {
                $results = array();
                foreach ($modules as $module) {
                    $module_results = array();
                    if (in_array($module, $moduleList)) {
                        $tracker = new \Tracker();
                        $entryList = $tracker->get_recently_viewed($userId, $module);

                        foreach ($entryList as $entry) {
                            $module_results[] = $entry;
                        }
                        $results[$module] = $module_results;
                    } else {
                        $GLOBALS['log']->warn(__FILE__.': ' . __FUNCTION__ . ' called but module not matched');
                        return $this->generateResponse($res, 404,NULL,'Non-matched item');
                    }
                }
                return $this->generateResponse($res,200,$results,'Success');
            } else {
                $GLOBALS['log']->warn(__FILE__.': ' . __FUNCTION__ . ' called but modules are null');
                return $this->generateResponse($res, 400,NULL,'Incorrect parameters');
            }
        } else {//The userid was not retrieved from the system
            $GLOBALS['log']->warn(__FILE__.': ' . __FUNCTION__ . ' called but user not found for userid ' . $userId);
            return $this->generateResponse($res,401,NULL,'Incorrect login');
        }
    }


    //Emails?fields[]=name&fields[]=id
    function getModuleFieldList(Request $req, Response $res, $args)
    {
        global $beanList, $beanFiles, $moduleList, $errorList;
        $queryParams = $req->getQueryParams();
        $fields = array();
        if (!empty($queryParams['fields'])) {
            //If the user has entered the parameter as fields[] = xxx
            if (is_array($queryParams['fields']))
                $fields = $queryParams['fields'];
            else //If the user has entered the parameter as fields = xxx
                $fields[] = $queryParams['fields'];
        }

        $module = $args['module'];
        if (in_array($module, $moduleList)) {
            $module_fields = array();
            $class_name = $beanList[$module];
            require_once($beanFiles[$class_name]);
            $seed = new $class_name();
            $list = $this->get_return_module_fields($seed, $module, $fields);
            return $this->generateResponse($res,200,$list,'Success');

        } else {
            $GLOBALS['log']->info(__FILE__.': ' . __FUNCTION__ . ' called but module not matched (' . $module . ')');
            return $this->generateResponse($res, 404,NULL,'Non-matched item');
        }
    }

    function getModuleLinks(Request $req, Response $res, $args)
    {
        global $errorList, $moduleList;
        $module = $args['module'];
        if (in_array($module, $moduleList)) {
            $bean = \BeanFactory::getBean($module);
            if (!empty($bean)) {
                return $this->generateResponse($res,200,$bean->get_linked_fields(),'Success');
            } else {
                $GLOBALS['log']->info(__FILE__.': ' . __FUNCTION__ . ' called but module not matched (' . $module . ')');
                return $this->generateResponse($res, 404,NULL,'Non-matched item');
            }
        } else {
            $GLOBALS['log']->info(__FILE__.': ' . __FUNCTION__ . ' called but module not matched (' . $module . ')');
            return $this->generateResponse($res, 404,NULL,'Non-matched item');
        }
    }

    //module_layout?modules[]=Accounts&views[]=Detail&types[]=default
    function getModuleLayout(Request $req, Response $res, $args)
    {
        global $beanList, $beanFiles, $errorList;
        $queryParams = $req->getQueryParams();

        $modules = '';
        if(!empty($queryParams['modules']))
            $modules = $queryParams['modules'];

        $views = '';
        if(!empty($queryParams['views']))
            $views = $queryParams['views'];

        $types = '';
        if(!empty($queryParams['types']))
            $types = $queryParams['types'];

        $hash = 'false';

        if (!empty($queryParams['hash']))
            $hash = $queryParams['hash'];

        if (empty($modules) || empty($views) || empty($types) || !is_array($modules)|| !is_array($views) || !is_array($types)) {//http://stackoverflow.com/a/10323055
            return $this->generateResponse($res, 400,NULL,'Incorrect parameters');
        } else {
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

            return $this->generateResponse($res,200,$results,'Success');
        }

    }

    //END OF ROUTE METHODS

    function get_module_view_defs($module_name, $type, $view)
    {
        global $viewdefs, $listViewDefs;
        require_once('include/MVC/View/SugarView.php');
        //require_once('include/HTMLPurifier/standalone');
        $metadataFile = null;
        $results = array();
        $view = strtolower($view);
        switch (strtolower($type)) {
            case 'default':
            default:
                if ($view == 'subpanel')
                    $results = get_subpanel_defs($module_name, $type);
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