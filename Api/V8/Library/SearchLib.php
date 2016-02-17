<?php
namespace SuiteCRM\Api\V8\Library;


class SearchLib
{
    var $searchFormPath = 'include/SearchForm/SearchForm2.php';
    var $searchFormClass = 'SearchForm';
    var $displayColumns;
    var $searchColumns; // set by view.list.php

    function getSearchResults($userId)
    {

        //$results = $this->doSearchSimple($userId,$_REQUEST['query_string'],0,50);
        $results = $this->doSearchAdvanced($userId,$_REQUEST['query_string']);

        /*
                require_once('include/utils/layout_utils.php');
                require_once('modules/Home/UnifiedSearchAdvanced.php');
                $usa = new \UnifiedSearchAdvanced();
                $_REQUEST['module']='Home';
                $results = $usa->search();
        */
        return $results;
    }

    function doSearchAdvanced($userId, $queryString)
    {

        $unified_search_modules = $this->getUnifiedSearchModules();
        $unified_search_modules_display = $this->getUnifiedSearchModulesDisplay();

        global $modListHeader, $beanList, $beanFiles, $current_language, $app_strings, $current_user, $mod_strings;

        $this->query_string = $GLOBALS['db']->quote(securexss(from_html(clean_string($queryString,
            'UNIFIED_SEARCH'))));

        if (!empty($_REQUEST['advanced']) && $_REQUEST['advanced'] != 'false') {
            $modules_to_search = array();
            if (!empty($_REQUEST['search_modules'])) {
                foreach (explode(',', $_REQUEST['search_modules']) as $key) {
                    if (isset($unified_search_modules_display[$key]) && !empty($unified_search_modules_display[$key]['visible'])) {
                        $modules_to_search[$key] = $beanList[$key];
                    }
                }
            }

            $current_user->setPreference('showGSDiv', isset($_REQUEST['showGSDiv']) ? $_REQUEST['showGSDiv'] : 'no', 0,
                'search');
            $current_user->setPreference('globalSearch', $modules_to_search, 0,
                'search'); // save selections to user preference
        } else {
            $users_modules = $current_user->getPreference('globalSearch', 'search');
            $modules_to_search = array();

            if (!empty($users_modules)) {
                // use user's previous selections
                foreach ($users_modules as $key => $value) {
                    if (isset($unified_search_modules_display[$key]) && !empty($unified_search_modules_display[$key]['visible'])) {
                        $modules_to_search[$key] = $beanList[$key];
                    }
                }
            } else {
                foreach ($unified_search_modules_display as $module => $data) {
                    if (!empty($data['visible'])) {
                        $modules_to_search[$module] = $beanList[$module];
                    }
                }
            }
            $current_user->setPreference('globalSearch', $modules_to_search, 'search');
        }


        $templateFile = 'modules/Home/UnifiedSearchAdvancedForm.tpl';
        if (file_exists('custom/' . $templateFile)) {
            $templateFile = 'custom/' . $templateFile;
        }

        $module_results = array();
        $has_results = false;

        if (!empty($this->query_string)) {
            foreach ($modules_to_search as $moduleName => $beanName) {
                require_once $beanFiles[$beanName];
                $seed = new $beanName();

                $mod_strings = return_module_language($current_language, $seed->module_dir);

                //retrieve the original list view defs and store for processing in case of custom layout changes
                require('modules/' . $seed->module_dir . '/metadata/listviewdefs.php');
                $orig_listViewDefs = $listViewDefs;

                if (file_exists('custom/modules/' . $seed->module_dir . '/metadata/listviewdefs.php')) {
                    require('custom/modules/' . $seed->module_dir . '/metadata/listviewdefs.php');
                }

                if (!isset($listViewDefs) || !isset($listViewDefs[$seed->module_dir])) {
                    continue;
                }

                $unifiedSearchFields = array();
                $innerJoins = array();
                foreach ($unified_search_modules[$moduleName]['fields'] as $field => $def) {
                    $listViewCheckField = strtoupper($field);
                    //check to see if the field is in listview defs
                    if (empty($listViewDefs[$seed->module_dir][$listViewCheckField]['default'])) {
                        //check to see if field is in original list view defs (in case we are using custom layout defs)
                        if (!empty($orig_listViewDefs[$seed->module_dir][$listViewCheckField]['default'])) {
                            //if we are here then the layout has been customized, but the field is still needed for query creation
                            $listViewDefs[$seed->module_dir][$listViewCheckField] = $orig_listViewDefs[$seed->module_dir][$listViewCheckField];
                        }

                    }

                    //bug: 34125 we might want to try to use the LEFT JOIN operator instead of the INNER JOIN in the case we are
                    //joining against a field that has not been populated.
                    if (!empty($def['innerjoin'])) {
                        if (empty($def['db_field'])) {
                            continue;
                        }
                        $innerJoins[$field] = $def;
                        $def['innerjoin'] = str_replace('INNER', 'LEFT', $def['innerjoin']);
                    }

                    if (isset($seed->field_defs[$field]['type'])) {
                        $type = $seed->field_defs[$field]['type'];
                        if ($type == 'int' && !is_numeric($this->query_string)) {
                            continue;
                        }
                    }

                    $unifiedSearchFields[$moduleName] [$field] = $def;
                    $unifiedSearchFields[$moduleName] [$field]['value'] = $this->query_string;
                }

                /*
                 * Use searchForm2->generateSearchWhere() to create the search query, as it can generate SQL for the full set of comparisons required
                 * generateSearchWhere() expects to find the search conditions for a field in the 'value' parameter of the searchFields entry for that field
                 */
                require_once $beanFiles[$beanName];
                $seed = new $beanName();

                require_once $this->searchFormPath;
                $searchForm = new $this->searchFormClass ($seed, $moduleName);

                $searchForm->setup(array($moduleName => array()), $unifiedSearchFields, '',
                    'saved_views' /* hack to avoid setup doing further unwanted processing */);
                $where_clauses = $searchForm->generateSearchWhere();
                //add inner joins back into the where clause
                $params = array('custom_select' => "");
                foreach ($innerJoins as $field => $def) {
                    if (isset ($def['db_field'])) {
                        foreach ($def['db_field'] as $dbfield) {
                            $where_clauses[] = $dbfield . " LIKE '" . $this->query_string . "%'";
                        }
                        $params['custom_select'] .= ", $dbfield";
                        $params['distinct'] = true;
                        //$filterFields[$dbfield] = $dbfield;
                    }
                }

                if (count($where_clauses) > 0) {
                    $where = '((' . implode(' ) OR ( ', $where_clauses) . '))';
                } else {
                    /* Clear $where from prev. module
                       if in current module $where_clauses */
                    $where = '';
                }
                $displayColumns = array();
                foreach ($listViewDefs[$seed->module_dir] as $colName => $param) {
                    if (!empty($param['default']) && $param['default'] == true) {
                        $param['url_sort'] = true;//bug 27933
                        $displayColumns[$colName] = $param;
                    }
                }

                $this->setup($seed, 'include/ListView/ListViewNoMassUpdate.tpl', $where, $params, 0, 10);


                $displayColumns = array();
                foreach($listViewDefs[$seed->module_dir] as $colName => $param)
                {
                    if(!empty($param['default']) && $param['default'] == true)
                    {
                        $param['url_sort'] = true;//bug 27933
                        $displayColumns[$colName] = $param;
                    }
                }

                if(count($displayColumns) > 0)
                {
                    $this->displayColumns = $displayColumns;
                } else {
                    $this->displayColumns = $listViewDefs[$seed->module_dir];
                }

                $module_results[$moduleName] = $GLOBALS['app_list_strings']['moduleList'][$seed->module_dir];//'<br /><br />' . get_form_header($GLOBALS['app_list_strings']['moduleList'][$seed->module_dir] . ' (' . $lv->data['pageData']['offsets']['total'] . ')', '', false);
            }
        }

        /*
        if ($has_results) {
            foreach ($module_counts as $name => $value) {
                echo $module_results[$name];
            }
        } else {
            if (empty($_REQUEST['form_only'])) {
                echo $home_mod_strings['LBL_NO_RESULTS'];
                echo $home_mod_strings['LBL_NO_RESULTS_TIPS'];
            }
        }
        */
        return $module_results;

    }

    function shouldProcess($moduleDir){
        $searching = false;
        $sessionSearchQuery = "{$moduleDir}2_QUERY_QUERY";
        if (!empty($_SESSION[$sessionSearchQuery])) {
            $searching = true;
        }
        if(!empty($GLOBALS['sugar_config']['save_query']) && $GLOBALS['sugar_config']['save_query'] == 'populate_only'){
            if(empty($GLOBALS['displayListView'])
                && (!empty($_REQUEST['clear_query'])
                    || $_REQUEST['module'] == $moduleDir
                    && ((empty($_REQUEST['query']) || $_REQUEST['query'] == 'MSI' )
                        && (!$searching)))) {
                $_SESSION['last_search_mod'] = $_REQUEST['module'] ;
                $this->should_process = false;
                return false;
            }
        }
        $this->should_process = true;
        return true;
    }

    function setupFilterFields($filter_fields = array())
    {
        // create filter fields based off of display columns
        if(empty($filter_fields) || $this->mergeDisplayColumns) {
            foreach($this->displayColumns as $columnName => $def) {

                $filter_fields[strtolower($columnName)] = true;

                if(isset($this->seed->field_defs[strtolower($columnName)]['type']) &&
                    strtolower($this->seed->field_defs[strtolower($columnName)]['type']) == 'currency' &&
                    isset($this->seed->field_defs['currency_id'])) {
                    $filter_fields['currency_id'] = true;
                }

                if(!empty($def['related_fields'])) {
                    foreach($def['related_fields'] as $field) {
                        //id column is added by query construction function. This addition creates duplicates
                        //and causes issues in oracle. #10165
                        if ($field != 'id') {
                            $filter_fields[$field] = true;
                        }
                    }
                }
                if (!empty($this->seed->field_defs[strtolower($columnName)]['db_concat_fields'])) {
                    foreach($this->seed->field_defs[strtolower($columnName)]['db_concat_fields'] as $index=>$field){
                        if(!isset($filter_fields[strtolower($field)]) || !$filter_fields[strtolower($field)])
                        {
                            $filter_fields[strtolower($field)] = true;
                        }
                    }
                }
            }
            foreach ($this->searchColumns as $columnName => $def )
            {
                $filter_fields[strtolower($columnName)] = true;
            }
        }


        return $filter_fields;
    }

    function getListViewData($seed, $where, $offset=-1, $limit = -1, $filter_fields=array(),$params=array(),$id_field = 'id',$singleSelect=true) {
        global $current_user;
        SugarVCR::erase($seed->module_dir);
        $this->seed =& $seed;
        $totalCounted = empty($GLOBALS['sugar_config']['disable_count_query']);
        $_SESSION['MAILMERGE_MODULE_FROM_LISTVIEW'] = $seed->module_dir;
        if(empty($_REQUEST['action']) || $_REQUEST['action'] != 'Popup'){
            $_SESSION['MAILMERGE_MODULE'] = $seed->module_dir;
        }

        $this->setVariableName($seed->object_name, $where, $this->listviewName);

        $this->seed->id = '[SELECT_ID_LIST]';

        // if $params tell us to override all ordering
        if(!empty($params['overrideOrder']) && !empty($params['orderBy'])) {
            $order = $this->getOrderBy(strtolower($params['orderBy']), (empty($params['sortOrder']) ? '' : $params['sortOrder'])); // retreive from $_REQUEST
        }
        else {
            $order = $this->getOrderBy(); // retreive from $_REQUEST
        }

        // still empty? try to use settings passed in $param
        if(empty($order['orderBy']) && !empty($params['orderBy'])) {
            $order['orderBy'] = $params['orderBy'];
            $order['sortOrder'] =  (empty($params['sortOrder']) ? '' : $params['sortOrder']);
        }

        //rrs - bug: 21788. Do not use Order by stmts with fields that are not in the query.
        // Bug 22740 - Tweak this check to strip off the table name off the order by parameter.
        // Samir Gandhi : Do not remove the report_cache.date_modified condition as the report list view is broken
        $orderby = $order['orderBy'];
        if (strpos($order['orderBy'],'.') && ($order['orderBy'] != "report_cache.date_modified")) {
            $orderby = substr($order['orderBy'],strpos($order['orderBy'],'.')+1);
        }
        if ($orderby != 'date_entered' && !in_array($orderby, array_keys($filter_fields))) {
            $order['orderBy'] = '';
            $order['sortOrder'] = '';
        }

        if (empty($order['orderBy'])) {
            $orderBy = '';
        } else {
            $orderBy = $order['orderBy'] . ' ' . $order['sortOrder'];
            //wdong, Bug 25476, fix the sorting problem of Oracle.
            if (isset($params['custom_order_by_override']['ori_code']) && $order['orderBy'] == $params['custom_order_by_override']['ori_code'])
                $orderBy = $params['custom_order_by_override']['custom_code'] . ' ' . $order['sortOrder'];
        }

        if (empty($params['skipOrderSave'])) { // don't save preferences if told so
            $current_user->setPreference('listviewOrder', $order, 0, $this->var_name); // save preference
        }

        // If $params tells us to override for the special last_name, first_name sorting
        if (!empty($params['overrideLastNameOrder']) && $order['orderBy'] == 'last_name') {
            $orderBy = 'last_name '.$order['sortOrder'].', first_name '.$order['sortOrder'];
        }

        $ret_array = $seed->create_new_list_query($orderBy, $where, $filter_fields, $params, 0, '', true, $seed, $singleSelect);
        $ret_array['inner_join'] = '';
        if (!empty($this->seed->listview_inner_join)) {
            $ret_array['inner_join'] = ' ' . implode(' ', $this->seed->listview_inner_join) . ' ';
        }

        if(!is_array($params)) $params = array();
        if(!isset($params['custom_select'])) $params['custom_select'] = '';
        if(!isset($params['custom_from'])) $params['custom_from'] = '';
        if(!isset($params['custom_where'])) $params['custom_where'] = '';
        if(!isset($params['custom_order_by'])) $params['custom_order_by'] = '';
        $main_query = $ret_array['select'] . $params['custom_select'] . $ret_array['from'] . $params['custom_from'] . $ret_array['inner_join']. $ret_array['where'] . $params['custom_where'] . $ret_array['order_by'] . $params['custom_order_by'];
        //C.L. - Fix for 23461
        if(empty($_REQUEST['action']) || $_REQUEST['action'] != 'Popup') {
            $_SESSION['export_where'] = $ret_array['where'];
        }
        if($limit < -1) {
            $result = $this->db->query($main_query);
        }
        else {
            if($limit == -1) {
                $limit = $this->getLimit();
            }
            $dyn_offset = $this->getOffset();
            if($dyn_offset > 0 || !is_int($dyn_offset))$offset = $dyn_offset;

            if(strcmp($offset, 'end') == 0){
                $totalCount = $this->getTotalCount($main_query);
                $offset = (floor(($totalCount -1) / $limit)) * $limit;
            }
            if($this->seed->ACLAccess('ListView')) {
                $result = $this->db->limitQuery($main_query, $offset, $limit + 1);
            }
            else {
                $result = array();
            }

        }

        $data = array();

        $temp = clone $seed;

        $rows = array();
        $count = 0;
        $idIndex = array();
        $id_list = '';

        while(($row = $this->db->fetchByAssoc($result)) != null)
        {
            if($count < $limit)
            {
                $id_list .= ',\''.$row[$id_field].'\'';
                $idIndex[$row[$id_field]][] = count($rows);
                $rows[] = $seed->convertRow($row);
            }
            $count++;
        }

        if (!empty($id_list))
        {
            $id_list = '('.substr($id_list, 1).')';
        }

        SugarVCR::store($this->seed->module_dir,  $main_query);
        if($count != 0) {
            //NOW HANDLE SECONDARY QUERIES
            if(!empty($ret_array['secondary_select'])) {
                $secondary_query = $ret_array['secondary_select'] . $ret_array['secondary_from'] . ' WHERE '.$this->seed->table_name.'.id IN ' .$id_list;
                if(isset($ret_array['order_by']))
                {
                    $secondary_query .= ' ' . $ret_array['order_by'];
                }

                $secondary_result = $this->db->query($secondary_query);

                $ref_id_count = array();
                while($row = $this->db->fetchByAssoc($secondary_result)) {

                    $ref_id_count[$row['ref_id']][] = true;
                    foreach($row as $name=>$value) {
                        //add it to every row with the given id
                        foreach($idIndex[$row['ref_id']] as $index){
                            $rows[$index][$name]=$value;
                        }
                    }
                }

                $rows_keys = array_keys($rows);
                foreach($rows_keys as $key)
                {
                    $rows[$key]['secondary_select_count'] = count($ref_id_count[$rows[$key]['ref_id']]);
                }
            }

            // retrieve parent names
            if(!empty($filter_fields['parent_name']) && !empty($filter_fields['parent_id']) && !empty($filter_fields['parent_type'])) {
                foreach($idIndex as $id => $rowIndex) {
                    if(!isset($post_retrieve[$rows[$rowIndex[0]]['parent_type']])) {
                        $post_retrieve[$rows[$rowIndex[0]]['parent_type']] = array();
                    }
                    if(!empty($rows[$rowIndex[0]]['parent_id'])) $post_retrieve[$rows[$rowIndex[0]]['parent_type']][] = array('child_id' => $id , 'parent_id'=> $rows[$rowIndex[0]]['parent_id'], 'parent_type' => $rows[$rowIndex[0]]['parent_type'], 'type' => 'parent');
                }
                if(isset($post_retrieve)) {
                    $parent_fields = $seed->retrieve_parent_fields($post_retrieve);
                    foreach($parent_fields as $child_id => $parent_data) {
                        //add it to every row with the given id
                        foreach($idIndex[$child_id] as $index){
                            $rows[$index]['parent_name']= $parent_data['parent_name'];
                        }
                    }
                }
            }

            $pageData = array();

            reset($rows);
            while($row = current($rows)){

                $temp = clone $seed;
                $dataIndex = count($data);

                $temp->setupCustomFields($temp->module_dir);
                $temp->loadFromRow($row);
                if (empty($this->seed->assigned_user_id) && !empty($temp->assigned_user_id)) {
                    $this->seed->assigned_user_id = $temp->assigned_user_id;
                }
                if($idIndex[$row[$id_field]][0] == $dataIndex){
                    $pageData['tag'][$dataIndex] = $temp->listviewACLHelper();
                }else{
                    $pageData['tag'][$dataIndex] = $pageData['tag'][$idIndex[$row[$id_field]][0]];
                }
                $data[$dataIndex] = $temp->get_list_view_data($filter_fields);
                $detailViewAccess = $temp->ACLAccess('DetailView');
                $editViewAccess = $temp->ACLAccess('EditView');
                $pageData['rowAccess'][$dataIndex] = array('view' => $detailViewAccess, 'edit' => $editViewAccess);
                $additionalDetailsAllow = $this->additionalDetails && $detailViewAccess && (file_exists(
                            'modules/' . $temp->module_dir . '/metadata/additionalDetails.php'
                        ) || file_exists('custom/modules/' . $temp->module_dir . '/metadata/additionalDetails.php'));
                $additionalDetailsEdit = $editViewAccess;
                if($additionalDetailsAllow) {
                    if($this->additionalDetailsAjax) {
                        $ar = $this->getAdditionalDetailsAjax($data[$dataIndex]['ID']);
                    }
                    else {
                        $additionalDetailsFile = 'modules/' . $this->seed->module_dir . '/metadata/additionalDetails.php';
                        if(file_exists('custom/modules/' . $this->seed->module_dir . '/metadata/additionalDetails.php')){
                            $additionalDetailsFile = 'custom/modules/' . $this->seed->module_dir . '/metadata/additionalDetails.php';
                        }
                        require_once($additionalDetailsFile);
                        $ar = $this->getAdditionalDetails($data[$dataIndex],
                            (empty($this->additionalDetailsFunction) ? 'additionalDetails' : $this->additionalDetailsFunction) . $this->seed->object_name,
                            $additionalDetailsEdit);
                    }
                    $pageData['additionalDetails'][$dataIndex] = $ar['string'];
                    $pageData['additionalDetails']['fieldToAddTo'] = $ar['fieldToAddTo'];
                }
                next($rows);
            }
        }
        $nextOffset = -1;
        $prevOffset = -1;
        $endOffset = -1;
        if($count > $limit) {
            $nextOffset = $offset + $limit;
        }

        if($offset > 0) {
            $prevOffset = $offset - $limit;
            if($prevOffset < 0)$prevOffset = 0;
        }
        $totalCount = $count + $offset;

        if( $count >= $limit && $totalCounted){
            $totalCount  = $this->getTotalCount($main_query);
        }
        SugarVCR::recordIDs($this->seed->module_dir, array_keys($idIndex), $offset, $totalCount);
        $module_names = array(
            'Prospects' => 'Targets'
        );
        $endOffset = (floor(($totalCount - 1) / $limit)) * $limit;
        $pageData['ordering'] = $order;
        $pageData['ordering']['sortOrder'] = $this->getReverseSortOrder($pageData['ordering']['sortOrder']);
        //get url parameters as an array
        $pageData['queries'] = $this->generateQueries($pageData['ordering']['sortOrder'], $offset, $prevOffset, $nextOffset,  $endOffset, $totalCounted);
        //join url parameters from array to a string
        $pageData['urls'] = $this->generateURLS($pageData['queries']);
        $pageData['offsets'] = array( 'current'=>$offset, 'next'=>$nextOffset, 'prev'=>$prevOffset, 'end'=>$endOffset, 'total'=>$totalCount, 'totalCounted'=>$totalCounted);
        $pageData['bean'] = array('objectName' => $seed->object_name, 'moduleDir' => $seed->module_dir, 'moduleName' => strtr($seed->module_dir, $module_names));
        $pageData['stamp'] = $this->stamp;
        $pageData['access'] = array('view' => $this->seed->ACLAccess('DetailView'), 'edit' => $this->seed->ACLAccess('EditView'));
        $pageData['idIndex'] = $idIndex;
        if(!$this->seed->ACLAccess('ListView')) {
            $pageData['error'] = 'ACL restricted access';
        }

        $queryString = '';

        if( isset($_REQUEST["searchFormTab"]) && $_REQUEST["searchFormTab"] == "advanced_search" ||
            isset($_REQUEST["type_basic"]) && (count($_REQUEST["type_basic"] > 1) || $_REQUEST["type_basic"][0] != "") ||
            isset($_REQUEST["module"]) && $_REQUEST["module"] == "MergeRecords")
        {
            $queryString = "-advanced_search";
        }
        else if (isset($_REQUEST["searchFormTab"]) && $_REQUEST["searchFormTab"] == "basic_search")
        {
            if($seed->module_dir == "Reports") $searchMetaData = SearchFormReports::retrieveReportsSearchDefs();
            else $searchMetaData = SearchForm::retrieveSearchDefs($seed->module_dir);

            $basicSearchFields = array();

            if( isset($searchMetaData['searchdefs']) && isset($searchMetaData['searchdefs'][$seed->module_dir]['layout']['basic_search']) )
                $basicSearchFields = $searchMetaData['searchdefs'][$seed->module_dir]['layout']['basic_search'];

            foreach( $basicSearchFields as $basicSearchField)
            {
                $field_name = (is_array($basicSearchField) && isset($basicSearchField['name'])) ? $basicSearchField['name'] : $basicSearchField;
                $field_name .= "_basic";
                if( isset($_REQUEST[$field_name])  && ( !is_array($basicSearchField) || !isset($basicSearchField['type']) || $basicSearchField['type'] == 'text' || $basicSearchField['type'] == 'name') )
                {
                    // Ensure the encoding is UTF-8
                    $queryString = htmlentities($_REQUEST[$field_name], null, 'UTF-8');
                    break;
                }
            }
        }

        return array('data'=>$data , 'pageData'=>$pageData, 'query' => $queryString);
    }

    function setup($seed, $file, $where, $params = array(), $offset = 0, $limit = -1,  $filter_fields = array(), $id_field = 'id') {
        $this->should_process = true;
        if(isset($seed->module_dir) && !$this->shouldProcess($seed->module_dir)){
            return false;
        }

        $this->seed = $seed;

        $filter_fields = $this->setupFilterFields($filter_fields);

        $data = $this->lvd->getListViewData($seed, $where, $offset, $limit, $filter_fields, $params, $id_field);

        $this->fillDisplayColumnsWithVardefs();

        $this->process($file, $data, $seed->object_name);
        return true;
    }

    function process($file, $data, $htmlVar) {
        $this->rowCount = count($data['data']);
        $this->moduleString = $data['pageData']['bean']['moduleDir'] . '2_' . strtoupper($htmlVar) . '_offset';
    }

    public function getUnifiedSearchModulesDisplay()
    {
        if(!file_exists('custom/modules/unified_search_modules_display.php'))
        {
            $unified_search_modules = $this->getUnifiedSearchModules();

            $unified_search_modules_display = array();

            if(!empty($unified_search_modules))
            {
                foreach($unified_search_modules as $module=>$data)
                {
                    $unified_search_modules_display[$module]['visible'] = (isset($data['default']) && $data['default']) ? true : false;
                }
            }

            $this->writeUnifiedSearchModulesDisplayFile($unified_search_modules_display);
        }

        include('custom/modules/unified_search_modules_display.php');
        return $unified_search_modules_display;
    }

    public function getUnifiedSearchModules()
    {
        //Make directory if it doesn't exist
        $cachedir = sugar_cached('modules');
        if(!file_exists($cachedir))
        {
            mkdir_recursive($cachedir);
        }

        //Load unified_search_modules.php file
        $cachedFile = sugar_cached('modules/unified_search_modules.php');
        if(!file_exists($cachedFile))
        {
            $this->buildCache();
        }

        include $cachedFile;
        return $unified_search_modules;
    }

    function doSearchSimple($userId, $queryString, $start = 0, $amount = 20)
    {

        $currentUser = \BeanFactory::getBean("Users", $userId);

        $index = \BeanFactory::getBean("AOD_Index")->getIndex();
        $hits = array();
        $start = 0;
        $amount = 20;
        $total = 0;
        if (!empty($_REQUEST['start'])) {
            $start = $_REQUEST['start'];
        }
        if (!empty($_REQUEST['total'])) {
            $total = $_REQUEST['total'];
        }
        if (array_key_exists('listViewStartButton', $_REQUEST)) {
            $start = 0;
        } elseif (array_key_exists('listViewPrevButton', $_REQUEST)) {
            $start = max($start - $amount, 0);
        } elseif (array_key_exists('listViewNextButton', $_REQUEST)) {
            $start = min($start + $amount, $total);
        } elseif (array_key_exists('listViewEndButton', $_REQUEST)) {
            $start = floor($total / $amount) * $amount;
        }
        if ($queryString) {
            return $this->doSearch($queryString, $currentUser, $start, $amount);
            //$total = $res['total'];
            //$hits = $res['hits'];
        }
    }

    function doSearch($queryString, $currentUser, $start, $amount)
    {
        $index = \BeanFactory::getBean("AOD_Index")->getIndex();

        $cachePath = 'cache/modules/AOD_Index/QueryCache/' . md5($queryString);
        if (is_file($cachePath)) {
            $mTime = $this->getCorrectMTime($cachePath);
            if ($mTime > (time() - 5 * 60)) {
                $hits = unserialize(sugar_file_get_contents($cachePath));
            }
        }
        if (!isset($hits)) {
            $tmphits = $index->find($queryString);
            $hits = array();
            foreach ($tmphits as $hit) {
                $bean = \BeanFactory::getBean($hit->record_module, $hit->record_id);
                if (empty($bean)) {
                    continue;
                }
                if ($bean->bean_implements('ACL') && !is_admin($currentUser)) {
                    //Annoyingly can't use the following as it always passes true for is_owner checks on list
                    //$bean->ACLAccess('list');
                    $in_group = SecurityGroup::groupHasAccess($bean->module_dir, $bean->id, 'list');
                    $is_owner = $bean->isOwner($currentUser->id);
                    $access = ACLController::checkAccess($bean->module_dir, 'list', $is_owner, 'module', $in_group);
                    if (!$access) {
                        continue;
                    }
                }
                $newHit = new \stdClass;
                $newHit->record_module = $hit->record_module;
                $newHit->record_id = $hit->record_id;
                $newHit->score = $hit->score;
                $newHit->label = $this->getModuleLabel($bean->module_name);
                $newHit->name = $bean->get_summary_text();
                //$newHit->summary = $this->getRecordSummary($bean);
                $newHit->date_entered = $bean->date_entered;
                $newHit->date_modified = $bean->date_modified;
                $hits[] = $newHit;
            }
            //Cache results so pagination is nice and snappy.
            $this->cacheQuery($queryString, $hits);
        }

        $total = count($hits);
        $hits = array_slice($hits, $start, $amount);
        $results = array('total' => $total, 'hits' => $hits);
        return $results;
    }

    function getModuleLabel($module)
    {
        return translate('LBL_MODULE_NAME', $module);
    }

    function getRecordSummary(SugarBean $bean)
    {
        global $listViewDefs;
        if (!isset($listViewDefs) || !isset($listViewDefs[$bean->module_dir])) {
            if (file_exists('custom/modules/' . $bean->module_dir . '/metadata/listviewdefs.php')) {
                require('custom/modules/' . $bean->module_dir . '/metadata/listviewdefs.php');
            } else {
                if (file_exists('modules/' . $bean->module_dir . '/metadata/listviewdefs.php')) {
                    require('modules/' . $bean->module_dir . '/metadata/listviewdefs.php');
                }
            }
        }
        if (!isset($listViewDefs) || !isset($listViewDefs[$bean->module_dir])) {
            return $bean->get_summary_text();
        }
        $summary = array();;
        foreach ($listViewDefs[$bean->module_dir] as $key => $entry) {
            if (!$entry['default']) {
                continue;
            }
            $key = strtolower($key);

            if (in_array($key, array('date_entered', 'date_modified', 'name'))) {
                continue;
            }
            $summary[] = $bean->$key;
        }
        $summary = array_filter($summary);
        return implode(' || ', $summary);
    }

    function cacheQuery($queryString, $resArray)
    {
        $file = create_cache_directory('modules/AOD_Index/QueryCache/' . md5($queryString));
        $out = serialize($resArray);
        sugar_file_put_contents_atomic($file, $out);
    }

    function getCorrectMTime($filePath)
    {
        $time = filemtime($filePath);
        $isDST = (date('I', $time) == 1);
        $systemDST = (date('I') == 1);
        $adjustment = 0;
        if ($isDST == false && $systemDST == true) {
            $adjustment = 3600;
        } elseif ($isDST == true && $systemDST == false) {
            $adjustment = -3600;
        } else {
            $adjustment = 0;
        }
        return ($time + $adjustment);
    }


}