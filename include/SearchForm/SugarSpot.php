<?php
//if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */


/**
 * Global search
 * @api
 */
class SugarSpot
{
    protected $module = "";

    /**
     * @param string $current_module
     */
    public function __construct($current_module = "")
    {
        $this->module = $current_module;
    }
    /**
     * searchAndDisplay
     *
     * Performs the search and returns the HTML widget containing the results
     *
     * @param  $query string what we are searching for
     * @param  $modules array modules we are searching in
     * @param  $offset int search result offset
     * @return string HTML code containing results
     *
     * @deprecated deprecated since 6.5
     */
    public function searchAndDisplay($query, $modules, $offset=-1)
    {
        $query_encoded = urlencode($query);
        $formattedResults = $this->formatSearchResultsToDisplay($query, $modules, $offset);
        $displayMoreForModule = $formattedResults['displayMoreForModule'];
        $displayResults = $formattedResults['displayResults'];

        $ss = new Sugar_Smarty();
        $ss->assign('displayResults', $displayResults);
        $ss->assign('displayMoreForModule', $displayMoreForModule);
        $ss->assign('appStrings', $GLOBALS['app_strings']);
        $ss->assign('appListStrings', $GLOBALS['app_list_strings']);
        $ss->assign('queryEncoded', $query_encoded);
        $template = 'include/SearchForm/tpls/SugarSpot.tpl';
        if (file_exists('custom/include/SearchForm/tpls/SugarSpot.tpl')) {
            $template = 'custom/include/SearchForm/tpls/SugarSpot.tpl';
        }
        return $ss->fetch($template);
    }


    protected function formatSearchResultsToDisplay($query, $modules, $offset=-1)
    {
        $results = $this->_performSearch($query, $modules, $offset);
        $displayResults = array();
        $displayMoreForModule = array();
        //$actions=0;
        foreach ($results as $m=>$data) {
            if (empty($data['data'])) {
                continue;
            }

            $countRemaining = $data['pageData']['offsets']['total'] - count($data['data']);
            if ($offset > 0) {
                $countRemaining -= $offset;
            }

            if ($countRemaining > 0) {
                $displayMoreForModule[$m] = array('query'=>$query,
                    'offset'=>$data['pageData']['offsets']['next']++,
                    'countRemaining'=>$countRemaining);
            }

            foreach ($data['data'] as $row) {
                $name = '';

                //Determine a name to use
                if (!empty($row['NAME'])) {
                    $name = $row['NAME'];
                } elseif (!empty($row['DOCUMENT_NAME'])) {
                    $name = $row['DOCUMENT_NAME'];
                } else {
                    $foundName = '';
                    foreach ($row as $k=>$v) {
                        if (strpos($k, 'NAME') !== false) {
                            if (!empty($row[$k])) {
                                $name = $v;
                                break;
                            } elseif (empty($foundName)) {
                                $foundName = $v;
                            }
                        }
                    }

                    if (empty($name)) {
                        $name = $foundName;
                    }
                }

                $displayResults[$m][$row['ID']] = $name;
            }
        }

        return array('displayResults' => $displayResults, 'displayMoreForModule' => $displayMoreForModule);
    }
    /**
     * Returns the array containing the $searchFields for a module.  This function
     * first checks the default installation directories for the SearchFields.php file and then
     * loads any custom definition (if found)
     *
     * @param  $moduleName String name of module to retrieve SearchFields entries for
     * @return array of SearchFields
     */
    protected static function getSearchFields($moduleName)
    {
        $searchFields = array();

        if (file_exists("modules/{$moduleName}/metadata/SearchFields.php")) {
            require("modules/{$moduleName}/metadata/SearchFields.php");
        }

        if (file_exists("custom/modules/{$moduleName}/metadata/SearchFields.php")) {
            require("custom/modules/{$moduleName}/metadata/SearchFields.php");
        }

        return $searchFields;
    }


    /**
     * Get count from query
     * @param SugarBean $seed
     * @param string $main_query
     */
    protected function _getCount($seed, $main_query)
    {
        $result = $seed->db->query("SELECT COUNT(*) as c FROM ($main_query) main");
        $row = $seed->db->fetchByAssoc($result);
        return isset($row['c'])?$row['c']:0;
    }

    /**
     * Determine which modules should be searched against.
     *
     * @return array
     */
    protected function getSearchModules()
    {
        $usa = new UnifiedSearchAdvanced();
        $unified_search_modules_display = $usa->getUnifiedSearchModulesDisplay();

        // load the list of unified search enabled modules
        $modules = array();

        //check to see if the user has  customized the list of modules available to search
        $users_modules = $GLOBALS['current_user']->getPreference('globalSearch', 'search');

        if (!empty($users_modules)) {
            // use user's previous selections
            foreach ($users_modules as $key => $value) {
                if (isset($unified_search_modules_display[$key]) && !empty($unified_search_modules_display[$key]['visible'])) {
                    $modules[$key] = $key;
                }
            }
        } else {
            foreach ($unified_search_modules_display as $key=>$data) {
                if (!empty($data['visible'])) {
                    $modules[$key] = $key;
                }
            }
        }
        // make sure the current module appears first in the list
        if (isset($modules[$this->module])) {
            unset($modules[$this->module]);
            $modules = array_merge(array($this->module=>$this->module), $modules);
        }

        return $modules;
    }

    /**
     * Perform a search
     *
     * @param $query string what we are searching for
     * @param $offset int search result offset
     * @return array
     */
    public function search($query, $offset = -1, $limit = 20, $options = array())
    {
        if (isset($options['modules']) && !empty($options['modules'])) {
            $modules = $options['modules'];
        } else {
            $modules = $this->getSearchModules();
        }

        return $this->_performSearch($query, $modules, $offset, $limit);
    }
    /**
     * _performSearch
     *
     * Performs the search from the global search field.
     *
     * @param  $query   string what we are searching for
     * @param  $modules array  modules we are searching in
     * @param  $offset  int   search result offset
     * @param  $limit  int    search limit
     * @return array
     */
    protected function _performSearch($query, $modules, $offset = -1, $limit = 20)
    {
        if (empty($query)) {
            return array();
        }
        $primary_module='';
        $results = array();
        require_once 'include/SearchForm/SearchForm2.php' ;
        $where = '';
        $searchEmail = preg_match('/^([^%]|%)*@([^%]|%)*$/', $query);

        // bug49650 - strip out asterisks from query in case
        // user thinks asterisk is a wildcard value
        $query = str_replace('*', '', $query);
        
        $limit = !empty($GLOBALS['sugar_config']['max_spotresults_initial']) ? $GLOBALS['sugar_config']['max_spotresults_initial'] : 5;
        if ($offset !== -1) {
            $limit = !empty($GLOBALS['sugar_config']['max_spotresults_more']) ? $GLOBALS['sugar_config']['max_spotresults_more'] : 20;
        }
        $totalCounted = empty($GLOBALS['sugar_config']['disable_count_query']);


        foreach ($modules as $moduleName) {
            if (empty($primary_module)) {
                $primary_module=$moduleName;
            }

            $searchFields = SugarSpot::getSearchFields($moduleName);

            if (empty($searchFields[$moduleName])) {
                continue;
            }

            $class = $GLOBALS['beanList'][$moduleName];
            $return_fields = array();
            $seed = new $class();
            if (!$seed->ACLAccess('ListView')) {
                continue;
            }

            if ($class == 'aCase') {
                $class = 'Case';
            }

            foreach ($searchFields[$moduleName] as $k=>$v) {
                $keep = false;
                $searchFields[$moduleName][$k]['value'] = $query;
                if (!empty($searchFields[$moduleName][$k]['force_unifiedsearch'])) {
                    continue;
                }

                if (!empty($GLOBALS['dictionary'][$class]['unified_search'])) {
                    if (empty($GLOBALS['dictionary'][$class]['fields'][$k]['unified_search'])) {
                        if (isset($searchFields[$moduleName][$k]['db_field'])) {
                            foreach ($searchFields[$moduleName][$k]['db_field'] as $field) {
                                if (!empty($GLOBALS['dictionary'][$class]['fields'][$field]['unified_search'])) {
                                    if (isset($GLOBALS['dictionary'][$class]['fields'][$field]['type'])) {
                                        if (!$this->filterSearchType($GLOBALS['dictionary'][$class]['fields'][$field]['type'], $query)) {
                                            unset($searchFields[$moduleName][$k]);
                                            continue;
                                        }
                                    }

                                    $keep = true;
                                }
                            } //foreach
                        }
                        # Bug 42961 Spot search for custom fields
                        if (!$keep && (isset($v['force_unifiedsearch']) == false || $v['force_unifiedsearch'] != true)) {
                            if (strpos($k, 'email') === false || !$searchEmail) {
                                unset($searchFields[$moduleName][$k]);
                            }
                        }
                    } else {
                        if ($GLOBALS['dictionary'][$class]['fields'][$k]['type'] == 'int' && !is_numeric($query)) {
                            unset($searchFields[$moduleName][$k]);
                        }
                    }
                } elseif (empty($GLOBALS['dictionary'][$class]['fields'][$k])) {
                    //If module did not have unified_search defined, then check the exception for an email search before we unset
                    if (strpos($k, 'email') === false || !$searchEmail) {
                        unset($searchFields[$moduleName][$k]);
                    }
                } elseif (!$this->filterSearchType($GLOBALS['dictionary'][$class]['fields'][$k]['type'], $query)) {
                    unset($searchFields[$moduleName][$k]);
                }
            } //foreach

            //If no search field criteria matched then continue to next module
            if (empty($searchFields[$moduleName])) {
                continue;
            }

            if (empty($searchFields[$moduleName])) {
                continue;
            }

            if (isset($seed->field_defs['name'])) {
                $return_fields['name'] = $seed->field_defs['name'];
            }

            foreach ($seed->field_defs as $k => $v) {
                if (isset($seed->field_defs[$k]['type']) && ($seed->field_defs[$k]['type'] == 'name') && !isset($return_fields[$k])) {
                    $return_fields[$k] = $seed->field_defs[$k];
                }
            }

            if (!isset($return_fields['name'])) {
                // if we couldn't find any name fields, try search fields that have name in it
                foreach ($searchFields[$moduleName] as $k => $v) {
                    if (strpos($k, 'name') != -1 && isset($seed->field_defs[$k]) && !isset($seed->field_defs[$k]['source'])) {
                        $return_fields[$k] = $seed->field_defs[$k];
                        break;
                    }
                }
            }

            if (!isset($return_fields['name'])) {
                // last resort - any fields that have 'name' in their name
                foreach ($seed->field_defs as $k => $v) {
                    if (strpos($k, 'name') != -1 && isset($seed->field_defs[$k])
                        && !isset($seed->field_defs[$k]['source'])) {
                        $return_fields[$k] = $seed->field_defs[$k];
                        break;
                    }
                }
            }

            if (!isset($return_fields['name'])) {
                // FAIL: couldn't find id & name for the module
                $GLOBALS['log']->error("Unable to find name for module $moduleName");
                continue;
            }

            if (isset($return_fields['name']['fields'])) {
                // some names are composite
                foreach ($return_fields['name']['fields'] as $field) {
                    $return_fields[$field] = $seed->field_defs[$field];
                }
            }


            $searchForm = new SearchForm($seed, $moduleName) ;
            $searchForm->setup(array( $moduleName => array() ), $searchFields, '', 'saved_views' /* hack to avoid setup doing further unwanted processing */) ;
            $where_clauses = $searchForm->generateSearchWhere() ;

            if (empty($where_clauses)) {
                continue;
            }
            if (count($where_clauses) > 1) {
                $query_parts =  array();

                $ret_array_start = $seed->create_new_list_query('', '', $return_fields, array(), 0, '', true, $seed, true);
                $search_keys = array_keys($searchFields[$moduleName]);

                foreach ($where_clauses as $n => $clause) {
                    $allfields = $return_fields;
                    $skey = $search_keys[$n];
                    if (isset($seed->field_defs[$skey])) {
                        // Joins for foreign fields aren't produced unless the field is in result, hence the merge
                        $allfields[$skey] = $seed->field_defs[$skey];
                    }
                    $ret_array = $seed->create_new_list_query('', $clause, $allfields, array(), 0, '', true, $seed, true);
                    $query_parts[] = $ret_array_start['select'] . $ret_array['from'] . $ret_array['where'] . $ret_array['order_by'];
                }
                $main_query = "(".join(") UNION (", $query_parts).")";
            } else {
                foreach ($searchFields[$moduleName] as $k=>$v) {
                    if (isset($seed->field_defs[$k])) {
                        $return_fields[$k] = $seed->field_defs[$k];
                    }
                }
                $ret_array = $seed->create_new_list_query('', $where_clauses[0], $return_fields, array(), 0, '', true, $seed, true);
                $main_query = $ret_array['select'] . $ret_array['from'] . $ret_array['where'] . $ret_array['order_by'];
            }

            $totalCount = null;
            if ($limit < -1) {
                $result = $seed->db->query($main_query);
            } else {
                if ($limit == -1) {
                    $limit = $GLOBALS['sugar_config']['list_max_entries_per_page'];
                }

                if ($offset == 'end') {
                    $totalCount = $this->_getCount($seed, $main_query);
                    if ($totalCount) {
                        $offset = (floor(($totalCount -1) / $limit)) * $limit;
                    } else {
                        $offset = 0;
                    }
                }
                $result = $seed->db->limitQuery($main_query, $offset, $limit + 1);
            }

            $data = array();
            $count = 0;
            while ($count < $limit && ($row = $seed->db->fetchByAssoc($result))) {
                $temp = clone $seed;
                $temp->setupCustomFields($temp->module_dir);
                $temp->loadFromRow($row);
                $data[] = $temp->get_list_view_data($return_fields);
                $count++;
            }

            $nextOffset = -1;
            $prevOffset = -1;
            $endOffset = -1;

            if ($count >= $limit) {
                $nextOffset = $offset + $limit;
            }

            if ($offset > 0) {
                $prevOffset = $offset - $limit;
                if ($prevOffset < 0) {
                    $prevOffset = 0;
                }
            }

            if ($count >= $limit && $totalCounted) {
                if (!isset($totalCount)) {
                    $totalCount  = $this->_getCount($seed, $main_query);
                }
            } else {
                $totalCount = $count + $offset;
            }

            $pageData['offsets'] = array( 'current'=>$offset, 'next'=>$nextOffset, 'prev'=>$prevOffset, 'end'=>$endOffset, 'total'=>$totalCount, 'totalCounted'=>$totalCounted);
            $pageData['bean'] = array('objectName' => $seed->object_name, 'moduleDir' => $seed->module_dir);

            $results[$moduleName] = array("data" => $data, "pageData" => $pageData);
        }
        return $results;
    }


    /**
     * Function used to walk the array and find keys that map the queried string.
     * if both the pattern and module name is found the promote the string to thet top.
     */
    protected function _searchKeys($item1, $key, $patterns)
    {
        //make the module name singular....
        if ($patterns[1][strlen($patterns[1])-1] == 's') {
            $patterns[1]=substr($patterns[1], 0, (strlen($patterns[1])-1));
        }

        $module_exists = stripos($key, $patterns[1]); //primary module name.
        $pattern_exists = stripos($key, $patterns[0]); //pattern provided by the user.
        if ($module_exists !== false and $pattern_exists !== false) {
            $GLOBALS['matching_keys']= array_merge(array(array('NAME'=>$key, 'ID'=>$key, 'VALUE'=>$item1)), $GLOBALS['matching_keys']);
        } else {
            if ($pattern_exists !== false) {
                $GLOBALS['matching_keys'][]=array('NAME'=>$key, 'ID'=>$key, 'VALUE'=>$item1);
            }
        }
    }


    /**
     * filterSearchType
     *
     * This is a private function to determine if the search type field should be filtered out based on the query string value
     *
     * @param String $type The string value of the field type (e.g. phone, date, datetime, int, etc.)
     * @param String $query The search string value sent from the global search
     * @return boolean True if the search type fits the query string value; false otherwise
     */
    protected function filterSearchType($type, $query)
    {
        switch ($type) {
            case 'id':
            case 'date':
            case 'datetime':
            case 'bool':
                return false;
                break;
            case 'int':
                if (!is_numeric($query)) {
                    return false;
                }
                break;
            case 'phone':
                //For a phone search we require at least three digits
                if (!preg_match('/[0-9]{3,}/', $query)) {
                    return false;
                }
                // no break
            case 'decimal':
            case 'float':
                if (!preg_match('/[0-9]/', $query)) {
                    return false;
                }
                break;
        }
        return true;
    }
}
