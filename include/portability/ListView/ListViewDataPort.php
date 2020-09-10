<?php

/* @noinspection PhpIncludeInspection */

require_once 'include/ListView/ListViewData.php';
require_once 'include/portability/ApiBeanMapper/ApiBeanMapper.php';
require_once 'include/SearchForm/SearchForm2.php';

class ListViewDataPort extends ListViewData
{
    /**
     * @var SugarBean
     */
    public $seed;

    /**
     * @var ApiBeanMapper
     */
    protected $apiBeanMapper;

    /**
     * @var string
     */
    protected $var_name;

    /**
     * @var string
     */
    protected $var_order_by;

    /**
     * @var string
     */
    protected $var_offset;

    /**
     * @var string
     */
    protected $stamp;

    public function __construct()
    {
        parent::__construct();
        $this->apiBeanMapper = new ApiBeanMapper();
    }

    /**
     * @inheritDoc
     */
    public function getOrderBy($orderBy = '', $direction = ''): array
    {
        return ['orderBy' => $orderBy, 'sortOrder' => $direction];
    }

    /**
     * @inheritDoc
     */
    public function setVariableName($baseName, $where, $listviewName = null, $id = null): void
    {
        $module = (!empty($listviewName)) ? $listviewName : ($this->seed->module_name ?? null);
        $this->var_name = $module . '2_' . strtoupper($baseName) . ($id ? '_' . $id : '');

        $this->var_order_by = $this->var_name . '_ORDER_BY';
        $this->var_offset = $this->var_name . '_offset';
        $timestamp = sugar_microtime();
        $this->stamp = $timestamp;
    }

    /**
     * @param $seed
     * @param $where
     * @param int $offset
     * @param int $limit
     * @param array $filter_fields
     * @param array $params
     * @param string $id_field
     * @param bool $singleSelect
     * @param null $id
     * @return array
     */
    public function get(
        $seed,
        $where,
        $offset = -1,
        $limit = -1,
        $filter_fields = array(),
        $params = array(),
        $id_field = 'id',
        $singleSelect = true,
        $id = null
    ): array {
        global $current_user;
        $data = [];
        $pageData = [];

        /* @var SugarBean $seed */
        $this->seed =& $seed;
        $totalCounted = empty($GLOBALS['sugar_config']['disable_count_query']);

        if (!$this->seed->ACLAccess('ListView')) {
            throw new BadMethodCallException('No access to list');
        }

        $this->setVariableName($seed->object_name, $where, $this->listviewName, $id);

        $this->seed->id = '[SELECT_ID_LIST]';

        [$params, $order, $orderBy] = $this->buildOrderBy($filter_fields, $params, $current_user);

        [$ret_array, $main_query] = $this->buildFindQuery($seed, $where, $filter_fields, $params, $singleSelect,
            $orderBy);

        [$result, $offset] = $this->runQuery($offset, $limit, $main_query);

        /* @var SugarBean $temp */
        $temp = clone $seed;

        $rows = array();
        $count = 0;
        $idIndex = array();
        $id_list = '';

        while (($row = $this->db->fetchByAssoc($result)) != null) {
            if ($count < $limit) {
                $id_list .= ',\'' . $row[$id_field] . '\'';
                $idIndex[$row[$id_field]][] = count($rows);
                $rows[] = $seed->convertRow($row);
            }
            $count++;
        }

        if ($count > 0) {
            [$rows] = $this->runSecondaryQueries($ret_array, $id_list, $idIndex, $rows);
            $this->fillParentFields($seed, $filter_fields, $id, $idIndex, $rows);

            foreach ($rows as $row) {
                $temp = clone $seed;
                $dataIndex = count($data);

                $temp->setupCustomFields($temp->module_dir);
                $temp->loadFromRow($row);
                $this->enforceAssignedUserId($temp);
                $this->addTagInfo($id_field, $idIndex, $row, $dataIndex, $temp, $pageData);

                $data[$dataIndex] = $this->apiBeanMapper->toArray($temp);

                $this->addACLInfo($temp, $pageData, $dataIndex);
            }
        }

        $this->addPaginationInfo($offset, $limit, $count, $totalCounted, $main_query, $order, $pageData);

        $pageData['idIndex'] = $idIndex;

        return ['data' => $data, 'pageData' => $pageData];
    }

    /**
     * @param $filter_fields
     * @param $params
     * @param $current_user
     * @return array
     */
    protected function buildOrderBy($filter_fields, $params, User $current_user): array
    {
        // if $params tell us to override all ordering
        if (!empty($params['overrideOrder']) && !empty($params['orderBy'])) {
            $order = $this->getOrderBy(strtolower($params['orderBy']),
                (empty($params['sortOrder']) ? '' : $params['sortOrder'])); // retreive from $_REQUEST
        } else {
            $order = $this->getOrderBy(); // retreive from $_REQUEST
        }

        // still empty? try to use settings passed in $param
        if (empty($order['orderBy']) && !empty($params['orderBy'])) {
            $order['orderBy'] = $params['orderBy'];
            $order['sortOrder'] = (empty($params['sortOrder']) ? '' : $params['sortOrder']);
        }

        //rrs - bug: 21788. Do not use Order by stmts with fields that are not in the query.
        // Bug 22740 - Tweak this check to strip off the table name off the order by parameter.
        // Samir Gandhi : Do not remove the report_cache.date_modified condition as the report list view is broken
        $orderby = $order['orderBy'];
        if (($order['orderBy'] !== "report_cache.date_modified") && strpos($order['orderBy'], '.')) {
            $orderby = substr($order['orderBy'], strpos($order['orderBy'], '.') + 1);
        }

        if ($orderby !== 'date_entered' && empty($params['custom_order']) && !array_key_exists($orderby,
                $filter_fields)) {
            $order['orderBy'] = '';
            $order['sortOrder'] = '';
        }

        if (empty($order['orderBy'])) {
            $orderBy = '';
        } else {
            $orderBy = $order['orderBy'] . ' ' . $order['sortOrder'];
            //wdong, Bug 25476, fix the sorting problem of Oracle.
            if (isset($params['custom_order_by_override']['ori_code']) && $order['orderBy'] === $params['custom_order_by_override']['ori_code']) {
                $orderBy = $params['custom_order_by_override']['custom_code'] . ' ' . $order['sortOrder'];
            }
        }

        // If $params tells us to override for the special last_name, first_name sorting
        if (!empty($params['overrideLastNameOrder']) && $order['orderBy'] === 'last_name') {
            $orderBy = 'last_name ' . $order['sortOrder'] . ', first_name ' . $order['sortOrder'];
        }

        return array($params, $order, $orderBy);
    }

    /**
     * @param $seed
     * @param $where
     * @param $filter_fields
     * @param $params
     * @param $singleSelect
     * @param $orderBy
     * @return array
     */
    protected function buildFindQuery(
        SugarBean $seed,
        $where,
        $filter_fields,
        $params,
        $singleSelect,
        $orderBy
    ): array {

        $ret_array = $seed->create_new_list_query(
            $orderBy,
            $where,
            $filter_fields,
            $params,
            0,
            '',
            true,
            $seed,
            $singleSelect,
            false
        );
        $ret_array['inner_join'] = '';
        if (!empty($this->seed->listview_inner_join)) {
            $ret_array['inner_join'] = ' ' . implode(' ', $this->seed->listview_inner_join) . ' ';
        }

        if (!is_array($params)) {
            $params = array();
        }
        if (!isset($params['custom_select'])) {
            $params['custom_select'] = '';
        }
        if (!isset($params['custom_from'])) {
            $params['custom_from'] = '';
        }
        if (!isset($params['custom_where'])) {
            $params['custom_where'] = '';
        }
        if (!isset($params['custom_order_by'])) {
            $params['custom_order_by'] = '';
        }
        $main_query = $ret_array['select'] . $params['custom_select'] . $ret_array['from'] . $params['custom_from'] . $ret_array['inner_join'] . $ret_array['where'] . $params['custom_where'] . $ret_array['order_by'] . $params['custom_order_by'];
        //C.L. - Fix for 23461
        if (empty($_REQUEST['action']) || $_REQUEST['action'] !== 'Popup') {
            $_SESSION['export_where'] = $ret_array['where'];
        }

        return array($ret_array, $main_query);
    }

    /**
     * @param $offset
     * @param $limit
     * @param $main_query
     * @return array
     */
    protected function runQuery($offset, $limit, $main_query): array
    {
        if ($limit < -1) {
            $result = $this->db->query($main_query);
        } else {
            if ($limit === -1) {
                $limit = $this->getLimit();
            }
            $dyn_offset = $this->getOffset();
            if ($dyn_offset > 0 || !is_int($dyn_offset)) {
                $offset = $dyn_offset;
            }

            if (strcmp($offset, 'end') === 0) {
                $totalCount = $this->getTotalCount($main_query);
                $offset = (floor(($totalCount - 1) / $limit)) * $limit;
            }
            if ($this->seed->ACLAccess('ListView')) {
                $result = $this->db->limitQuery($main_query, $offset, $limit + 1);
            } else {
                $result = array();
            }
        }

        return array($result, $offset);
    }

    /**
     * @param $ret_array
     * @param string $id_list
     * @param array $idIndex
     * @param array $rows
     * @return array
     */
    protected function runSecondaryQueries(
        $ret_array,
        string $id_list,
        array $idIndex,
        array $rows
    ): array {
        if (!empty($ret_array['secondary_select'])) {
            $secondary_query = $ret_array['secondary_select'] . $ret_array['secondary_from'] . ' WHERE ' . $this->seed->table_name . '.id IN ' . $id_list;
            if (isset($ret_array['order_by'])) {
                $secondary_query .= ' ' . $ret_array['order_by'];
            }

            $secondary_result = $this->db->query($secondary_query);

            $ref_id_count = array();

            while ($row = $this->db->fetchByAssoc($secondary_result)) {
                $ref_id_count[$row['ref_id']][] = true;
                foreach ($row as $name => $value) {
                    //add it to every row with the given id
                    foreach ($idIndex[$row['ref_id']] as $index) {
                        $rows[$index][$name] = $value;
                    }
                }
            }

            $rows_keys = array_keys($rows);
            foreach ($rows_keys as $key) {
                $rows[$key]['secondary_select_count'] = count($ref_id_count[$rows[$key]['ref_id']]);
            }
        }

        return array($rows);
    }

    /**
     * @param $seed
     * @param $filter_fields
     * @param $id
     * @param array $idIndex
     * @param $rows
     * @return void
     */
    protected function fillParentFields(
        SugarBean $seed,
        $filter_fields,
        $id,
        array $idIndex,
        &$rows
    ): void {
        if (!empty($filter_fields['parent_name']) && !empty($filter_fields['parent_id']) && !empty($filter_fields['parent_type'])) {
            foreach ($idIndex as $id => $rowIndex) {
                if (!isset($post_retrieve[$rows[$rowIndex[0]]['parent_type']])) {
                    $post_retrieve[$rows[$rowIndex[0]]['parent_type']] = array();
                }
                if (!empty($rows[$rowIndex[0]]['parent_id'])) {
                    $post_retrieve[$rows[$rowIndex[0]]['parent_type']][] = array(
                        'child_id' => $id,
                        'parent_id' => $rows[$rowIndex[0]]['parent_id'],
                        'parent_type' => $rows[$rowIndex[0]]['parent_type'],
                        'type' => 'parent'
                    );
                }
            }
            if (isset($post_retrieve)) {
                $parent_fields = $seed->retrieve_parent_fields($post_retrieve);
                foreach ($parent_fields as $child_id => $parent_data) {
                    //add it to every row with the given id
                    foreach ($idIndex[$child_id] as $index) {
                        $rows[$index]['parent_name'] = $parent_data['parent_name'];
                    }
                }
            }
        }
    }

    /**
     * @param SugarBean $temp
     * @param array $pageData
     * @param int $dataIndex
     */
    protected function addACLInfo(SugarBean $temp, array &$pageData, int $dataIndex): void
    {
        $detailViewAccess = $temp->ACLAccess('DetailView');
        $editViewAccess = $temp->ACLAccess('EditView');
        $pageData['rowAccess'][$dataIndex] = array('view' => $detailViewAccess, 'edit' => $editViewAccess);
    }

    /**
     * @param $temp
     */
    protected function enforceAssignedUserId($temp): void
    {
        if (empty($this->seed->assigned_user_id) && !empty($temp->assigned_user_id)) {
            $this->seed->assigned_user_id = $temp->assigned_user_id;
        }
    }

    /**
     * @param $id_field
     * @param array $idIndex
     * @param $row
     * @param int $dataIndex
     * @param SugarBean $temp
     * @param array $pageData
     */
    protected function addTagInfo(
        $id_field,
        array $idIndex,
        $row,
        int $dataIndex,
        SugarBean $temp,
        array &$pageData
    ): void {
        if ($idIndex[$row[$id_field]][0] === $dataIndex) {
            $pageData['tag'][$dataIndex] = $temp->listviewACLHelper();
        } else {
            $pageData['tag'][$dataIndex] = $pageData['tag'][$idIndex[$row[$id_field]][0]];
        }
    }

    /**
     * @param $offset
     * @param $limit
     * @param int $count
     * @param bool $totalCounted
     * @param $main_query
     * @param $order
     * @param array $pageData
     */
    protected function addPaginationInfo(
        $offset,
        $limit,
        int $count,
        bool $totalCounted,
        $main_query,
        $order,
        array &$pageData
    ): void {
        $nextOffset = -1;
        $prevOffset = -1;
        $endOffset = -1;
        if ($count > $limit) {
            $nextOffset = $offset + $limit;
        }

        if ($offset > 0) {
            $prevOffset = $offset - $limit;
            if ($prevOffset < 0) {
                $prevOffset = 0;
            }
        }
        $totalCount = $count + $offset;

        if ($count >= $limit && $totalCounted) {
            $totalCount = $this->getTotalCount($main_query);
        }

        $endOffset = (floor(($totalCount - 1) / $limit)) * $limit;
        $pageData['ordering'] = $order;
        $pageData['ordering']['sortOrder'] = $this->getReverseSortOrder($pageData['ordering']['sortOrder']);
        //get url parameters as an array
        $pageData['queries'] = $this->generateQueries($pageData['ordering']['sortOrder'], $offset, $prevOffset,
            $nextOffset, $endOffset, $totalCounted);

        //join url parameters from array to a string
        $pageData['offsets'] = array(
            'current' => $offset,
            'next' => $nextOffset,
            'prev' => $prevOffset,
            'end' => $endOffset,
            'total' => $totalCount,
            'totalCounted' => $totalCounted
        );
    }
}
