<?php

namespace SuiteCRM\Api\V8\Library;

class ModuleLib
{
    /**
     * @param $filter
     * @param $user
     *
     * @return array
     */
    public function getAvailableModules($filter, $user)
    {
        if (empty($filter)) {
            $filter = 'all';
        }
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
        $ret['data'] = $modules;

        return $ret;
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function get_user_module_list($user)
    {
        global $app_list_strings, $current_language, $beanList, $beanFiles;
        require_once 'include/utils/security_utils.php';
        $app_list_strings = return_app_list_strings_language($current_language);
        $modules = query_module_access_list($user);
        \ACLController:: filterModuleList($modules, false);
        global $modInvisList;

        foreach ($modInvisList as $invis) {
            $modules[$invis] = 'read_only';
        }

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

    /**
     * @param $matchingBean
     * @param $data
     */
    public function updateModuleItem($matchingBean, $data)
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (!empty($key) && !empty($value)) {
                    $matchingBean->$key = $value;
                }
            }
            $matchingBean->save();
        }
    }

    /**
     * @param $moduleType
     * @param $data
     *
     * @return string
     */
    public function createModuleItem($moduleType, $data)
    {
        $GLOBALS['mod_strings'] = return_module_language($GLOBALS['current_language'], $moduleType);
        $matchingBean = \BeanFactory::getBean($moduleType);
        if (!empty($data)) {
            if (isset($data['id'])) {
                if (\BeanFactory::getBean($moduleType, $data['id'])) {
                    return '';
                }
                $matchingBean->new_with_id = true;
            }
            foreach ($data as $key => $value) {
                if (!empty($key) && !empty($value)) {
                    $matchingBean->$key = $value;
                }
            }
            $matchingBean->save();

            return $matchingBean->id;
        }

        return '';
    }

    /**
     * @param $modules
     * @param $views
     * @param $types
     * @param $hash
     *
     * @return array
     */
    public function getModuleLayout($modules, $views, $types, $hash)
    {
        global $beanList, $beanFiles;
        $results = array();
        foreach ($modules as $module_name) {
            $class_name = $beanList[$module_name];
            require_once $beanFiles[$class_name];
            $seed = new $class_name();

            foreach ($views as $view) {
                foreach ($types as $type) {
                    $a_vardefs = $this->get_module_view_defs($module_name, $type, $view);
                    if (strtolower($hash === 'true')) {
                        $results[$module_name][$type][$view] = md5(serialize($a_vardefs));
                    } else {
                        $results[$module_name][$type][$view] = $a_vardefs;
                    }
                }
            }
        }

        return $results;
    }

    /**
     * @param $availModules
     *
     * @return array
     */
    public function get_visible_modules($availModules)
    {
        require_once 'modules/MySettings/TabController.php';
        $controller = new \TabController();
        $tabs = $controller->get_tabs_system();

        return $this->getModulesFromList($tabs[0], $availModules);
    }

    /**
     * @param $list
     * @param $availModules
     *
     * @return array
     */
    public function getModulesFromList($list, $availModules)
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

    /**
     * @param $beanType
     * @param $id
     */
    public function deleteModuleItem($beanType, $id)
    {
        $beanType->mark_deleted($id);
    }

    /**
     * @param $module
     *
     * @return array
     */
    public function checkModuleRoleAccess($module)
    {
        $results = array();
        $actions = array('edit', 'delete', 'list', 'view', 'import', 'export');
        foreach ($actions as $action) {
            $access = \ACLController::checkAccess($module, $action, true);
            $results[] = array('action' => $action, 'access' => $access);
        }

        return $results;
    }

    /**
     * @param $module_name
     * @param $type
     * @param $view
     *
     * @return array
     */
    public function get_module_view_defs($module_name, $type, $view)
    {
        global $viewdefs, $listViewDefs;
        require_once 'include/MVC/View/SugarView.php';
        $metadataFile = null;
        $results = array();
        $view = strtolower($view);
        switch (strtolower($type)) {
            case 'default':
            default:
                if ($view == 'subpanel') {
                    $results = $this->get_subpanel_defs($module_name, $type);
                } else {
                    $v = new \SugarView(null, array());
                    $v->module = $module_name;
                    $v->type = $view;
                    $fullView = ucfirst($view).'View';
                    $metadataFile = $v->getMetaDataFile();

                    if ($metadataFile !== null) {
                        require_once $metadataFile;
                        if ($view == 'list') {
                            $results = $listViewDefs[$module_name];
                        } else {
                            $results = $viewdefs[$module_name][$fullView];
                        }
                    }
                }
        }

        return $results;
    }

    /**
     * @param $bean
     *
     * @return mixed
     */
    public function getModuleLinks($bean)
    {
        return $bean->get_linked_fields();
    }

    /**
     * @param $module
     * @param $fields
     *
     * @return array
     */
    public function getModuleFields($module, $fields)
    {
        global $beanList, $beanFiles;

        $class_name = $beanList[$module];
        require_once $beanFiles[$class_name];
        $seed = new $class_name();
        $list = $this->get_return_module_fields($seed, $module, $fields);

        return $list;
    }

    /**
     * @param $modules
     * @param $hash
     *
     * @return array
     */
    public function getLanguageDefinition($modules, $hash)
    {
        global $current_language;

        $results = array();
        if (!empty($modules)) {
            foreach ($modules as $mod) {
                if (strtolower($mod) == 'app_strings') {
                    $values = return_application_language($current_language);
                    $key = 'app_strings';
                } else {
                    if (strtolower($mod) == 'app_list_strings') {
                        $values = return_app_list_strings_language($current_language);
                        $key = 'app_list_strings';
                    } else {
                        $values = return_module_language($current_language, $mod);
                        $key = $mod;
                    }
                }

                if (strtolower($hash) === 'true') {
                    $values = md5(serialize($values));
                }

                $results[$key] = $values;
            }
        }

        return $results;
    }

    /**
     * @param $userId
     * @param $module
     *
     * @return array
     */
    public function getLastViewed($userId, $module)
    {
        $tracker = new \Tracker();
        $entryList = $tracker->get_recently_viewed($userId, $module);
        $module_results = array();
        foreach ($entryList as $entry) {
            $module_results[] = $entry;
        }

        return $module_results;
    }

    /**
     * @param $module
     * @param $type
     *
     * @return array
     */
    public function get_subpanel_defs($module, $type)
    {
        global $beanList, $layout_defs;
        $results = array();
        switch ($type) {
            case 'default':
            default:
                if (file_exists('modules/'.$module.'/metadata/subpaneldefs.php')) {
                    require 'modules/'.$module.'/metadata/subpaneldefs.php';
                }
                if (file_exists('custom/modules/'.$module.'/Ext/Layoutdefs/layoutdefs.ext.php')) {
                    require 'custom/modules/'.$module.'/Ext/Layoutdefs/layoutdefs.ext.php';
                }
        }

        //Filter results for permissions
        foreach ($layout_defs[$module]['subpanel_setup'] as $subpanel => $subpaneldefs) {
            $moduleToCheck = $subpaneldefs['module'];
            if (!isset($beanList[$moduleToCheck])) {
                continue;
            }
            $class_name = $beanList[$moduleToCheck];
            $bean = new $class_name();
            if ($bean->ACLAccess('list')) {
                $results[$subpanel] = $subpaneldefs;
            }
        }

        return $results;
    }

    /**
     * @param $value
     * @param $module
     * @param $fields
     * @param bool $translate
     *
     * @return array
     */
    public function get_return_module_fields($value, $module, $fields, $translate = true)
    {
        global $module_name;
        $module_name = $module;
        $result = $this->get_field_list($value, $fields, $translate);
        $tableName = $value->getTableName();

        return array(
            'module_name' => $module,
            'table_name' => $tableName,
            'module_fields' => $result['module_fields'],
            'link_fields' => $result['link_fields'],
        );
    }

    /**
     * @param $value
     * @param $fields
     * @param bool $translate
     *
     * @return array
     */
    public function get_field_list($value, $fields, $translate = true)
    {
        $module_fields = array();
        $link_fields = array();
        if (!empty($value->field_defs)) {
            foreach ($value->field_defs as $var) {
                if (!empty($fields) && !in_array($var['name'], $fields)) {
                    continue;
                }
                if (isset($var['source']) && ($var['source'] != 'db' && $var['source'] != 'non-db' && $var['source'] != 'custom_fields') && $var['name'] != 'email1' && $var['name'] != 'email2' && (!isset($var['type']) || $var['type'] != 'relate')) {
                    continue;
                }
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

                if ($var['type'] == 'bool') {
                    $var['options'] = 'checkbox_dom';
                }

                if (isset($var['options'])) {
                    $options_dom = translate($var['options'], $value->module_dir);
                    if (!is_array($options_dom)) {
                        $options_dom = array();
                    }
                    foreach ($options_dom as $key => $oneOption) {
                        $options_ret[$key] = get_name_value($key, $oneOption);
                    }
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
                        $entry['label'] = isset($var['vname']) ? translate($var['vname'],
                            $value->module_dir) : $var['name'];
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
                    if ($var['type'] == 'parent' && isset($var['type_name'])) {
                        $entry['type_name'] = $var['type_name'];
                    }

                    $module_fields[$var['name']] = $entry;
                } // else
            } //foreach
        } //if

        if ($value->module_dir == 'Meetings' || $value->module_dir == 'Calls') {
            if (isset($module_fields['duration_minutes']) && isset($GLOBALS['app_list_strings']['duration_intervals'])) {
                $options_dom = $GLOBALS['app_list_strings']['duration_intervals'];
                $options_ret = array();
                foreach ($options_dom as $key => $oneOption) {
                    $options_ret[$key] = get_name_value($key, $oneOption);
                }

                $module_fields['duration_minutes']['options'] = $options_ret;
            }
        }

        if ($value->module_dir == 'Bugs') {
            require_once 'modules/Releases/Release.php';
            $seedRelease = new \Release();
            $options = $seedRelease->get_releases(true, 'Active');
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

    /**
     * @param $note
     * @param $id
     *
     * @return array
     */
    public function getNoteAttachment($note, $id)
    {
        require_once 'modules/Notes/NoteSoap.php';
        $ns = new \NoteSoap();
        if (!isset($note->filename)) {
            $note->filename = '';
        }
        $file = $ns->retrieveFile($id, $note->filename);
        if ($file == -1) {
            $file = '';
        }

        return array(
            'note_attachment' => array(
                'id' => $id,
                'filename' => $note->filename,
                'file' => $file,
                'related_module_id' => $note->parent_id,
                'related_module_name' => $note->parent_type,
            ),
        );
    }

    /**
     * @param $related_module
     * @param $id_list
     *
     * @return array
     */
    public function getModuleRelationships($related_module, $id_list)
    {
        global $beanList, $beanFiles;

        $list = array();

        $in = "'".implode("', '", $id_list)."'";

        $related_class_name = $beanList[$related_module];
        require_once $beanFiles[$related_class_name];
        $related_mod = new $related_class_name();

        $sql = "SELECT {$related_mod->table_name}.id FROM {$related_mod->table_name} ";

        if (isset($related_mod->custom_fields)) {
            $customJoin = $related_mod->custom_fields->getJOIN();
            $sql .= $customJoin ? $customJoin['join'] : '';
        }

        $sql .= " WHERE {$related_mod->table_name}.id IN ({$in}) ";

        if (!empty($related_module_query)) {
            $sql .= " AND ( {$related_module_query} )";
        }

        $result = $related_mod->db->query($sql);
        while ($row = $related_mod->db->fetchByAssoc($result)) {
            $list[] = $row['id'];
        }

        $return_list = array();

        foreach ($list as $id) {
            $related_class_name = $beanList[$related_module];
            $related_mod = new $related_class_name();
            $related_mod->retrieve($id);

            $return_list[] = array(
                'id' => $id,
                'date_modified' => $related_mod->date_modified,
                'deleted' => $related_mod->deleted,
            );
        }

        return $return_list;
    }

    /**
     * @param $moduleName
     * @param $moduleId
     * @param $linkFieldName
     * @param $relatedIds
     * @param $nameValues
     *
     * @return array
     */
    public function createRelationship($moduleName, $moduleId, $linkFieldName, $relatedIds, $nameValues)
    {
        $count = 0;
        $failed = 0;

        if ($this->new_handle_set_relationship($moduleName, $moduleId, $linkFieldName, $relatedIds, $nameValues,
            false)
        ) {
            ++$count;
        } else {
            ++$failed;
        } // else

        return array('created' => $count, 'failed' => $failed);
    }

    /**
     * @param $moduleName
     * @param $moduleId
     * @param $linkFieldName
     * @param $relatedIds
     * @param $nameValues
     *
     * @return array
     */
    public function deleteRelationship($moduleName, $moduleId, $linkFieldName, $relatedIds, $nameValues)
    {
        $deleted = 0;
        $failed = 0;

        if ($this->new_handle_set_relationship($moduleName, $moduleId, $linkFieldName, $relatedIds, $nameValues,
            true)
        ) {
            ++$deleted;
        } else {
            ++$failed;
        } // else

        return array('deleted' => $deleted, 'failed' => $failed);
    }

    /**
     * @param $moduleNames
     * @param $moduleIds
     * @param $linkFieldNames
     * @param $relatedIds
     * @param $nameValues
     *
     * @return array
     */
    public function createRelationships($moduleNames, $moduleIds, $linkFieldNames, $relatedIds, $nameValues)
    {
        $count = 0;
        $failed = 0;
        $counter = 0;
        foreach ($moduleNames as $moduleName) {
            if ($this->new_handle_set_relationship($moduleName, $moduleIds[$counter], $linkFieldNames[$counter],
                $relatedIds[$counter], $nameValues[$counter], 0)
            ) {
                ++$count;
            } else {
                ++$failed;
            }
            ++$counter;
        }

        return array('created' => $count, 'failed' => $failed);
    }

    /**
     * @param $moduleNames
     * @param $moduleIds
     * @param $linkFieldNames
     * @param $relatedIds
     * @param $nameValues
     *
     * @return array
     */
    public function deleteRelationships($moduleNames, $moduleIds, $linkFieldNames, $relatedIds, $nameValues)
    {
        $failed = 0;
        $counter = 0;
        $deleted = 0;
        foreach ($moduleNames as $moduleName) {
            if ($this->new_handle_set_relationship($moduleName, $moduleIds[$counter], $linkFieldNames[$counter],
                $relatedIds[$counter], $nameValues[$counter], 1)
            ) {
                ++$deleted;
            } else {
                ++$failed;
            }
            ++$counter;
        }

        return array('deleted' => $deleted, 'failed' => $failed);
    }

    /**
     * @param $get_module
     * @param $from_module
     * @param $get_id
     *
     * @return array|bool
     */
    public function get_linked_records($get_module, $from_module, $get_id)
    {
        global $beanList, $beanFiles;

        // instantiate and retrieve $from_module
        $from_class = $beanList[$from_module];
        require_once $beanFiles[$from_class];
        $from_mod = new $from_class();
        $from_mod->retrieve($get_id);

        $field = $this->get_module_link_field($from_module, $get_module);
        if ($field === false) {
            return false;
        }

        $from_mod->load_relationship($field);
        $id_arr = $from_mod->$field->get();

        //bug: 38065
        if ($get_module == 'EmailAddresses') {
            $emails = $from_mod->emailAddress->addresses;
            $email_arr = array();
            foreach ($emails as $email) {
                $email_arr[] = $email['email_address_id'];
            }

            return $email_arr;
        }

        return $id_arr;
    }

    // Returns name of 'link' field between two given modules
    /**
     * @param $module_1
     * @param $module_2
     *
     * @return bool
     */
    public function get_module_link_field($module_1, $module_2)
    {
        global $beanList, $beanFiles;

        // check to make sure both modules exist
        if (empty($beanList[$module_1]) || empty($beanList[$module_2])) {
            return false;
        }

        $class_1 = $beanList[$module_1];
        require_once $beanFiles[$class_1];

        $obj_1 = new $class_1();

        // loop through link fields of $module_1, checking for a link to $module_2
        foreach ($obj_1->get_linked_fields() as $linked_field) {
            $obj_1->load_relationship($linked_field['name']);
            $field = $linked_field['name'];

            if (empty($obj_1->$field)) {
                continue;
            }

            if ($obj_1->$field->getRelatedModuleName() == $module_2) {
                return $field;
            }
        }

        return false;
    }

    /**
     * @param $module_name
     * @param $module_id
     * @param $link_field_name
     * @param $related_ids
     * @param $name_value_list
     * @param $delete
     *
     * @return bool
     */
    public function new_handle_set_relationship(
        $module_name,
        $module_id,
        $link_field_name,
        $related_ids,
        $name_value_list,
        $delete
    ) {
        global $beanList, $beanFiles;

        if (empty($beanList[$module_name])) {
            return false;
        }
        $class_name = $beanList[$module_name];
        require_once $beanFiles[$class_name];
        $mod = new $class_name();
        $mod->retrieve($module_id);
        if (!$mod->ACLAccess('DetailView')) {
            return false;
        }

        if ($mod->load_relationship($link_field_name)) {
            if (!$delete) {
                $name_value_pair = array();
                if (!empty($name_value_list)) {
                    $relFields = $mod->$link_field_name->getRelatedFields();
                    if (!empty($relFields)) {
                        $relFieldsKeys = array_keys($relFields);
                        foreach ($name_value_list as $key => $value) {
                            if (in_array($value['name'], $relFieldsKeys)) {
                                $name_value_pair[$value['name']] = $value['value'];
                            } // if
                        } // foreach
                    } // if
                }
                $mod->$link_field_name->add($related_ids, $name_value_pair);
            } else {
                foreach ($related_ids as $id) {
                    $mod->$link_field_name->delete($module_id, $id);
                } // foreach
            } // else
            return true;
        } else {
            return false;
        }
    }
}
