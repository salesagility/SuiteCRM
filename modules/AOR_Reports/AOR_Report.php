<?php
/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */

class AOR_Report extends Basic {
	var $new_schema = true;
	var $module_dir = 'AOR_Reports';
	var $object_name = 'AOR_Report';
	var $table_name = 'aor_reports';
	var $importable = true;
	var $disable_row_level_security = true ;

	var $id;
	var $name;
	var $date_entered;
	var $date_modified;
	var $modified_user_id;
	var $modified_by_name;
	var $created_by;
	var $created_by_name;
	var $description;
	var $deleted;
	var $created_by_link;
	var $modified_user_link;
	var $assigned_user_id;
	var $assigned_user_name;
	var $assigned_user_link;
	var $report_module;

	function AOR_Report(){
		parent::Basic();
        $this->load_report_beans();
        require_once('modules/AOW_WorkFlow/aow_utils.php');
	}

	function bean_implements($interface){
		switch($interface){
			case 'ACL': return true;
		}
		return false;
	}

    function save($check_notify = FALSE){

        // TODO: process of saveing the fields and conditions is too long so we will have to make some optimization on save_lines functions
        set_time_limit(3600);

        if (empty($this->id)){
            unset($_POST['aor_conditions_id']);
            unset($_POST['aor_fields_id']);
        }

        parent::save($check_notify);

        require_once('modules/AOR_Fields/AOR_Field.php');
        $field = new AOR_Field();
        $field->save_lines($_POST, $this, 'aor_fields_');

        require_once('modules/AOR_Conditions/AOR_Condition.php');
        $condition = new AOR_Condition();
        $condition->save_lines($_POST, $this, 'aor_conditions_');

        require_once('modules/AOR_Charts/AOR_Chart.php');
        $chart = new AOR_Chart();
        $chart->save_lines($_POST, $this, 'aor_chart_');
    }

    function load_report_beans(){
        global $beanList, $app_list_strings;

        $app_list_strings['aor_moduleList'] = $app_list_strings['moduleList'];

        foreach($app_list_strings['aor_moduleList'] as $mkey => $mvalue){
            if(!isset($beanList[$mkey]) || str_begin($mkey, 'AOR_') || str_begin($mkey, 'AOW_')){
                unset($app_list_strings['aor_moduleList'][$mkey]);
            }
        }

        $app_list_strings['aor_moduleList'] = array_merge((array)array(''=>''), (array)$app_list_strings['aor_moduleList']);

        asort($app_list_strings['aor_moduleList']);
    }


    function getReportFields(){
        $fields = array();
        foreach($this->get_linked_beans('aor_fields','AOR_Fields') as $field){
            $fields[] = $field;
        }
        usort($fields,function($a,$b){
            return $a->field_order - $b->field_order;
        });
        return $fields;
    }

    const CHART_TYPE_PCHART = 'pchart';
    const CHART_TYPE_CHARTJS = 'chartjs';
    const CHART_TYPE_RGRAPH = 'rgraph';


    function build_report_chart($chartIds = null, $chartType = self::CHART_TYPE_PCHART){
        global $beanList;


        $sql = "SELECT id FROM aor_fields WHERE aor_report_id = '".$this->id."' AND deleted = 0 ORDER BY field_order ASC";
        $result = $this->db->query($sql);

        $fields = array();
        $i = 0;

        $mainGroupField = null;

        while ($row = $this->db->fetchByAssoc($result)) {

            $field = new AOR_Field();
            $field->retrieve($row['id']);

            $path = unserialize(base64_decode($field->module_path));

            $field_bean = new $beanList[$this->report_module]();

            $field_module = $this->report_module;
            $field_alias = $field_bean->table_name;
            if($path[0] != $this->report_module){
                foreach($path as $rel){
                    if(empty($rel)){
                        continue;
                    }
                    $field_module = getRelatedModule($field_module,$rel);
                    $field_alias = $field_alias . ':'.$rel;
                }
            }
            $label = str_replace(' ','_',$field->label).$i;
            $fields[$label]['field'] = $field->field;
            $fields[$label]['label'] = $field->label;
            $fields[$label]['display'] = $field->display;
            $fields[$label]['function'] = $field->field_function;
            $fields[$label]['module'] = $field_module;
            $fields[$label]['alias'] = $field_alias;
            $fields[$label]['link'] = $field->link;
            $fields[$label]['total'] = $field->total;


            // get the main group

            if($field->group_display) {

                // if we have a main group already thats wrong cause only one main grouping field possible
                if(!is_null($mainGroupField)) {
                    $GLOBALS['log']->fatal('main group already found');
                }

                $mainGroupField = $field;
            }

            ++$i;
        }



        $query = $this->build_report_query();
        $result = $this->db->query($query);
        $data = array();
        while($row = $this->db->fetchByAssoc($result, false))
        {
            foreach($fields as $name => $att){

                $currency_id = isset($row[$att['alias'].'_currency_id']) ? $row[$att['alias'].'_currency_id'] : '';

                switch ($att['function']){
                    case 'COUNT':
                        break;
                    default:
                        if(!is_numeric($row[$name])) {
                            $row[$name] = trim(strip_tags(getModuleField($att['module'], $att['field'], $att['field'], 'DetailView', $row[$name], '', $currency_id)));
                        }
                        break;
                }
            }


            $data[] = $row;
        }
        $fields = $this->getReportFields();

        switch($chartType) {
            case self::CHART_TYPE_PCHART:
                $html = '<script src="modules/AOR_Charts/lib/pChart/imagemap.js"></script>';
                break;
            case self::CHART_TYPE_CHARTJS:
                $html = '<script src="modules/AOR_Reports/js/Chart.js"></script>';
                break;
            case self::CHART_TYPE_RGRAPH:
                if($_REQUEST['module']!= 'Home')//Need the require_once for the rgraphincludes as they are only loaded when the home page is hit
                    require_once('include/SuiteGraphs/RGraphIncludes.php');

                break;
        }
        $x = 0;
        foreach($this->get_linked_beans('aor_charts','AOR_Charts') as $chart){
            if($chartIds !== null && !in_array($chart->id,$chartIds)){
                continue;
            }
            $html .= $chart->buildChartHTML($data,$fields,$x, $chartType, $mainGroupField);
            $x++;
        }
        return $html;
    }


    public function buildMultiGroupReport($offset = -1, $links = true, $level = 2, $path = array()) {
        global $beanList;

        $rows = $this->getGroupDisplayFieldByReportId($this->id, $level);

        if(count($rows) > 1) {
            $GLOBALS['log']->fatal('ambiguous group display for report ' . $this->id);
        }
        else if(count($rows) == 1){
            $rows[0]['module_path'] = unserialize(base64_decode($rows[0]['module_path']));
            if(!$rows[0]['module_path'][0]) {
                $module = new $beanList[$this->report_module]();
                $rows[0]['field_id_name'] = $module->field_defs[$rows[0]['field']]['id_name'] ? $module->field_defs[$rows[0]['field']]['id_name'] : $module->field_defs[$rows[0]['field']]['name'];
                $rows[0]['module_path'][0] = $module->table_name;
            }
            else {
                $rows[0]['field_id_name'] = $rows[0]['field'];
            }
            $path[] = $rows[0];

            if($level>10) {
                $msg = 'Too many nested groups';
                $GLOBALS['log']->fatal($msg);
                return null;
            }

            return $this->buildMultiGroupReport($offset, $links, $level+1, $path);
        }
        else if(!$rows) {
            if($path) {
                $html = '';
                foreach ($path as $pth) {
                    $_fieldIdName = $this->db->quoteIdentifier($pth['field_id_name']);
                    $query = "SELECT $_fieldIdName FROM " . $this->db->quoteIdentifier($pth['module_path'][0]) . " GROUP BY $_fieldIdName;";
                    $values = $this->dbSelect($query);

                    foreach($values as $value) {

                        //$where = [ $this->db->quote($pth['module_path'][0]) . '.' . $_fieldIdName . ' = \'' . $this->db->quote($value[$pth['field_id_name']]) . '\'' ];

                        $moduleFieldByGroupValue = $this->getModuleFieldByGroupValue($beanList, $value[$pth['field_id_name']]);
                        $moduleFieldByGroupValue = $this->addDataIdValueToInnertext($moduleFieldByGroupValue);
                        $html .= $this->getMultiGroupFrameHTML($moduleFieldByGroupValue, $this->build_group_report($offset, $links/*, ['where' => $where]*/));
                    }
                }
                return $html;
            }
            else {
                return $this->build_group_report($offset, $links);
            }
        }
        else {
            throw new Exception('incorrect results');
        }
        throw new Exception('incorrect state');
    }

    private function getGroupDisplayFieldByReportId($reportId = null, $level = 1) {

        // set the default values

        if (is_null($reportId)) {
            $reportId = $this->id;
        }

        if (!$level) {
            $level = 1;
        }

        // escape values for query

        $_id = $this->db->quote($reportId);
        $_level = (int) $level;

        // get results array

        $query = "SELECT id, field, module_path FROM aor_fields WHERE aor_report_id = '$_id' AND group_display = $_level AND deleted = 0;";
        $rows = $this->dbSelect($query);

        return $rows;
    }


    private function dbSelect($query) {
        $results = $this->db->query($query);

        $rows = array();
        while($row = $this->db->fetchByAssoc($results)) {
            $rows[] = $row;
        }

        return $rows;
    }

    private function getMultiGroupFrameHTML($header, $body) {
        $html = '<div class="multi-group-list" style="border: 1px solid black; padding: 10px;">
                    <h3>' . $header . '</h3>
                    <div class="multi-group-list-inner">' . $body . '</div>
                </div>';
        return $html;
    }

    private function addDataIdValueToInnertext($html) {
        preg_match('/\sdata-id-value\s*=\s*"([^"]*)"/', $html, $match);
        $html = preg_replace('/(>)([^<]*)(<\/\w+>$)/', '$1$2' . $match[1] . '$3', $html);
        return $html;
    }


    function build_group_report($offset = -1, $links = true, $extra = array()){
        global $beanList;

        $html = '';
        $query = '';
        $query_array = array();
        $module = new $beanList[$this->report_module]();

        $sql = "SELECT id FROM aor_fields WHERE aor_report_id = '".$this->id."' AND group_display = 1 AND deleted = 0 ORDER BY field_order ASC";
        $field_id = $this->db->getOne($sql);

        if(!$field_id) {
            $query_array['select'][] = $module->table_name . ".id AS '" . $module->table_name . "_id'";
        }

        if($field_id != ''){
            $field = new AOR_Field();
            $field->retrieve($field_id);

            $field_label = str_replace(' ','_',$field->label);

            $path = unserialize(base64_decode($field->module_path));

            $field_module = $module;
            $table_alias = $field_module->table_name;
            if(!empty($path[0]) && $path[0] != $module->module_dir){
                foreach($path as $rel){
                    $new_field_module = new $beanList[getRelatedModule($field_module->module_dir,$rel)];
                    $oldAlias = $table_alias;
                    $table_alias = $table_alias.":".$rel;

                    $query_array = $this->build_report_query_join($rel, $table_alias, $oldAlias, $field_module, 'relationship', $query_array, $new_field_module);
                    $field_module = $new_field_module;

                    // ?
                    //$table_alias = $rel;
                }
            }

            $data = $field_module->field_defs[$field->field];

            if($data['type'] == 'relate' && isset($data['id_name'])) {
                $field->field = $data['id_name'];
            }

            if($data['type'] == 'currency' && !stripos($field->field, '_USD') && isset($field_module->field_defs['currency_id'])) {
                if((isset($field_module->field_defs['currency_id']['source']) && $field_module->field_defs['currency_id']['source'] == 'custom_fields')) {
                    $query['select'][$table_alias.'_currency_id'] = $table_alias.'_cstm'.".currency_id AS '".$table_alias."_currency_id'";
                } else {
                    $query_array['select'][$table_alias . '_currency_id'] = $table_alias . ".currency_id AS '" . $table_alias . "_currency_id'";
                }
            }

            if(  (isset($data['source']) && $data['source'] == 'custom_fields')) {
                $select_field = $this->db->quoteIdentifier($table_alias.'_cstm').'.'.$field->field;
                // ? $query_array = $this->build_report_query_join($table_alias.'_cstm', $table_alias.'_cstm',$table_alias, $field_module, 'custom', $query);
                $query_array = $this->build_report_query_join($table_alias.'_cstm', $table_alias.'_cstm', $field_module, 'custom', $query);
            } else {
                $select_field= $this->db->quoteIdentifier($table_alias).'.'.$field->field;
            }

            if($field->sort_by != ''){
                $query_array['sort_by'][] = $field_label.' '.$field->sort_by;
            }

            if($field->group_by == 1){
                $query_array['group_by'][] = $select_field;
            }

            if($field->field_function != null){
                $select_field = $field->field_function.'('.$select_field.')';
            }

            $query_array['select'][] = $select_field ." AS '".$field_label."'";
            if(isset($extra['select']) && $extra['select']) {
                foreach($extra['select'] as $selectField => $selectAlias) {
                    if($selectAlias) {
                        $query_array['select'][] = $selectField . " AS " . $selectAlias;
                    }
                    else {
                        $query_array['select'][] = $selectField;
                    }
                }
            }
            $query_array['where'][] = $select_field ." IS NOT NULL AND ";
            if(isset($extra['where']) && $extra['where']) {
                $query_array['where'][] = implode(' AND ', $extra['where']) . ' AND ';
            }

            $query_array = $this->build_report_query_where($query_array);

            foreach ($query_array['select'] as $select){
                $query .=  ($query == '' ? 'SELECT ' : ', ').$select;
            }

            $query .= ' FROM '.$module->table_name.' ';

            if(isset($query_array['join'])){
                foreach ($query_array['join'] as $join){
                    $query .= $join;
                }
            }
            if(isset($query_array['where'])){
                $query_where = '';
                foreach ($query_array['where'] as $where){
                    $query_where .=  ($query_where == '' ? 'WHERE ' : ' ').$where;
                }

                $query_where = $this->queryWhereRepair($query_where);

                $query .= ' '.$query_where;
            }

            if(isset($query_array['group_by'])){
                $query_group_by = '';
                foreach ($query_array['group_by'] as $group_by){
                    $query_group_by .=  ($query_group_by == '' ? 'GROUP BY ' : ', ').$group_by;
                }
                $query .= ' '.$query_group_by;
            }

            if(isset($query_array['sort_by'])){
                $query_sort_by = '';
                foreach ($query_array['sort_by'] as $sort_by){
                    $query_sort_by .=  ($query_sort_by == '' ? 'ORDER BY ' : ', ').$sort_by;
                }
                $query .= ' '.$query_sort_by;
            }

            $query .= ' group by ' . $field_label;

            $result = $this->db->query($query);

            while ($row = $this->db->fetchByAssoc($result)) {
                if($html != '') $html .= '<br />';

               $html .= $this->build_report_html($offset, $links, $row[$field_label], '', $extra);

            }
        }

        if($html == '') $html = $this->build_report_html($offset, $links);
        return $html;

    }


    function build_report_html($offset = -1, $links = true, $group_value = '', $tableIdentifier = '', $extra = array()){

        global $beanList, $sugar_config;

        $report_sql = $this->build_report_query($group_value, $extra);
        $max_rows = 20;
        $total_rows = 0;
        $count_sql = explode('ORDER BY', $report_sql);
        $count_query = 'SELECT count(*) c FROM ('.$count_sql[0].') as n';

        // We have a count query.  Run it and get the results.
        $result = $this->db->query($count_query);
        $assoc = $this->db->fetchByAssoc($result);
        if(!empty($assoc['c']))
        {
            $total_rows = $assoc['c'];
        }

        $html = "<table class='list' id='report_table".$group_value."' width='100%' cellspacing='0' cellpadding='0' border='0' repeat_header='1'>";

        if($offset >= 0){
            $start = 0;
            $end = 0;
            $previous_offset = 0;
            $next_offset = 0;
            $last_offset = 0;

            if($total_rows > 0){
                $start = $offset +1;
                $end = (($offset + $max_rows) < $total_rows) ? $offset + $max_rows : $total_rows;
                $previous_offset = ($offset - $max_rows) < 0 ? 0 : $offset - $max_rows;
                $next_offset = $offset + $max_rows;
                $last_offset = $max_rows * floor($total_rows / $max_rows);
            }

            $html .= "<thead><tr class='pagination'>";
            

            $moduleFieldByGroupValue = $this->getModuleFieldByGroupValue($beanList, $group_value);

            $html .="<td colspan='18'>
                       <table class='paginationTable' border='0' cellpadding='0' cellspacing='0' width='100%'>
                        <td style='text-align:left' ><H3><a href=\"javascript:void(0)\" class=\"collapseLink\" onclick=\"groupedReportToggler.toggleList(this);\"><img border=\"0\" id=\"detailpanel_1_img_hide\" src=\"themes/SuiteR/images/basic_search.gif\"></a>$moduleFieldByGroupValue</H3></td>
                        <td class='paginationChangeButtons' align='right' nowrap='nowrap' width='1%'>";

            if($offset == 0){
                $html .="<button type='button' id='listViewStartButton_top' name='listViewStartButton' title='Start' class='button' disabled='disabled'>
                    <img src='".SugarThemeRegistry::current()->getImageURL('start_off.gif')."' alt='Start' align='absmiddle' border='0'>
                </button>
                <button type='button' id='listViewPrevButton_top' name='listViewPrevButton' class='button' title='Previous' disabled='disabled'>
                    <img src='".SugarThemeRegistry::current()->getImageURL('previous_off.gif')."' alt='Previous' align='absmiddle' border='0'>
                </button>";
            } else {
                $html .="<button type='button' id='listViewStartButton_top' name='listViewStartButton' title='Start' class='button' onclick='changeReportPage(\"".$this->id."\",0,\"".$group_value."\",\"".$tableIdentifier."\")'>
                    <img src='".SugarThemeRegistry::current()->getImageURL('start.gif')."' alt='Start' align='absmiddle' border='0'>
                </button>
                <button type='button' id='listViewPrevButton_top' name='listViewPrevButton' class='button' title='Previous' onclick='changeReportPage(\"".$this->id."\",".$previous_offset.",\"".$group_value."\",\"".$tableIdentifier."\")'>
                    <img src='".SugarThemeRegistry::current()->getImageURL('previous.gif')."' alt='Previous' align='absmiddle' border='0'>
                </button>";
            }
            $html .=" <span class='pageNumbers'>(".$start ." - ".$end ." of ". $total_rows .")</span>";
            if($next_offset < $total_rows){
                $html .="<button type='button' id='listViewNextButton_top' name='listViewNextButton' title='Next' class='button' onclick='changeReportPage(\"".$this->id."\",".$next_offset.",\"".$group_value."\",\"".$tableIdentifier."\")'>
                        <img src='".SugarThemeRegistry::current()->getImageURL('next.gif')."' alt='Next' align='absmiddle' border='0'>
                    </button>
                     <button type='button' id='listViewEndButton_top' name='listViewEndButton' title='End' class='button' onclick='changeReportPage(\"".$this->id."\",".$last_offset.",\"".$group_value."\",\"".$tableIdentifier."\")'>
                        <img src='".SugarThemeRegistry::current()->getImageURL('end.gif')."' alt='End' align='absmiddle' border='0'>
                    </button>";
            } else {
                $html .="<button type='button' id='listViewNextButton_top' name='listViewNextButton' title='Next' class='button'  disabled='disabled'>
                        <img src='".SugarThemeRegistry::current()->getImageURL('next_off.gif')."' alt='Next' align='absmiddle' border='0'>
                    </button>
                     <button type='button' id='listViewEndButton_top' name='listViewEndButton' title='End' class='button'  disabled='disabled'>
                        <img src='".SugarThemeRegistry::current()->getImageURL('end_off.gif')."' alt='End' align='absmiddle' border='0'>
                    </button>";

            }

            $html .="</td>
                       </table>
                      </td>";

            $html .="</tr></thead>";
        } else{

            $moduleFieldByGroupValue = $this->getModuleFieldByGroupValue($beanList, $group_value);

            $html = "<H3>$moduleFieldByGroupValue</H3>".$html;
        }

        $sql = "SELECT id FROM aor_fields WHERE aor_report_id = '".$this->id."' AND deleted = 0 ORDER BY field_order ASC";
        $result = $this->db->query($sql);

        $html .= "<thead>";
        $html .= "<tr>";

        $fields = array();
        $i = 0;
        while ($row = $this->db->fetchByAssoc($result)) {

            $field = new AOR_Field();
            $field->retrieve($row['id']);

            $path = unserialize(base64_decode($field->module_path));

            $field_bean = new $beanList[$this->report_module]();

            $field_module = $this->report_module;
            $field_alias = $field_bean->table_name;
            if($path[0] != $this->report_module){
                foreach($path as $rel){
                    if(empty($rel)){
                        continue;
                    }
                    $field_module = getRelatedModule($field_module,$rel);
                    $field_alias = $field_alias . ':'.$rel;
                }
            }
            $label = str_replace(' ','_',$field->label).$i;
            $fields[$label]['field'] = $field->field;
            $fields[$label]['label'] = $field->label;
            $fields[$label]['display'] = $field->display;
            $fields[$label]['function'] = $field->field_function;
            $fields[$label]['module'] = $field_module;
            $fields[$label]['alias'] = $field_alias;
            $fields[$label]['link'] = $field->link;
            $fields[$label]['total'] = $field->total;

            $fields[$label]['params'] = array("date_format" => $field->format);


            if($fields[$label]['display']){
                $html .= "<th scope='col'>";
                $html .= "<div style='white-space: normal;' width='100%' align='left'>";
                $html .= $field->label;
                $html .= "</div></th>";
            }
            ++$i;
        }

        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody>";

        if($offset >= 0){
            $result = $this->db->limitQuery($report_sql, $offset, $max_rows);
        } else {
            $result = $this->db->query($report_sql);
        }

        $row_class = 'oddListRowS1';


        $totals = array();
        while ($row = $this->db->fetchByAssoc($result)) {
            $html .= "<tr class='".$row_class."' height='20'>";

            foreach($fields as $name => $att){
                if($att['display']){
                    $html .= "<td class='' valign='top' align='left'>";
                    if($att['link'] && $links){
                        $html .= "<a href='" . $sugar_config['site_url'] . "/index.php?module=".$att['module']."&action=DetailView&record=".$row[$att['alias'].'_id']."'>";
                    }

                    $currency_id = isset($row[$att['alias'].'_currency_id']) ? $row[$att['alias'].'_currency_id'] : '';

                    switch ($att['function']){
                        case 'COUNT':
                        //case 'SUM':
                            $html .= $row[$name];
                            break;
                        default:

                            $html .= getModuleField($att['module'], $att['field'], $att['field'], 'DetailView',$row[$name],'',$currency_id, $att['params']);
                            break;
                    }
                    if($att['total']){
                        $totals[$name][] = $row[$name];
                    }
                    if($att['link'] && $links) $html .= "</a>";
                    $html .= "</td>";
                }
            }
            $html .= "</tr>";

            $row_class = $row_class == 'oddListRowS1' ?  'evenListRowS1':'oddListRowS1';
        }
        $html .= "</tbody>";

        $html .= $this->getTotalHtml($fields,$totals);

        $html .= "</table>";

        $html .= "    <script type=\"text/javascript\">
                            groupedReportToggler = {

                                toggleList: function(elem) {
                                    $(elem).closest('table.list').find('thead, tbody').each(function(i, e){
                                        if(i>1) {
                                            $(e).toggle();
                                        }
                                    });
                                    if($(elem).find('img').first().attr('src') == 'themes/SuiteR/images/basic_search.gif') {
                                        $(elem).find('img').first().attr('src', 'themes/SuiteR/images/advanced_search.gif');
                                    }
                                    else {
                                        $(elem).find('img').first().attr('src', 'themes/SuiteR/images/basic_search.gif');
                                    }
                                }

                            };
                        </script>";

        return $html;
    }

    private function getModuleFieldByGroupValue($beanList, $group_value) {
        $moduleFieldByGroupValues = array();

        $sql = "SELECT id FROM aor_fields WHERE aor_report_id = '".$this->id."' AND group_display = 1 AND deleted = 0 ORDER BY field_order ASC LIMIT 1;";
        $result = $this->db->query($sql);
        while ($row = $this->db->fetchByAssoc($result)) {

            $field = new AOR_Field();
            $field->retrieve($row['id']);

            $path = unserialize(base64_decode($field->module_path));

            $field_bean = new $beanList[$this->report_module]();

            $field_module = $this->report_module;
            $field_alias = $field_bean->table_name;
            if($path[0] != $this->report_module){
                foreach($path as $rel){
                    if(empty($rel)){
                        continue;
                    }
                    $field_module = getRelatedModule($field_module,$rel);
                    $field_alias = $field_alias . ':'.$rel;
                }
            }

            $currency_id = isset($row[$field_alias.'_currency_id']) ? $row[$field_alias.'_currency_id'] : '';
            $moduleFieldByGroupValues[] = getModuleField($this->report_module, $field->field, $field->field, 'DetailView', $group_value, '', $currency_id, array("date_format" => $field->format));

        }

        $moduleFieldByGroupValue = implode(', ', $moduleFieldByGroupValues);
        return $moduleFieldByGroupValue;
    }

    function getTotalHTML($fields,$totals){
        global $app_list_strings;
        $html = '';
        $html .= "<tbody>";
        $html .= "<tr>";
        foreach($fields as $label => $field){
            if(!$field['display']){
                continue;
            }
            if($field['total']){
                $totalLabel = $field['label'] ." ".$app_list_strings['aor_total_options'][$field['total']];
                $html .= "<th>{$totalLabel}</th>";
            }else{
                $html .= "<th></th>";
            }
        }
        $html .= "</tr>";
        $html .= "<tr>";
        foreach($fields as $label => $field){
            if(!$field['display']){
                continue;
            }
            if($field['total'] && isset($totals[$label])){
                $html .= "<td>".$this->calculateTotal($field['total'],$totals[$label])."</td>";
            }else{
                $html .= "<td></td>";
            }
        }
        $html .= "</tr>";
        $html .= "</tbody>";
        return $html;
    }

    function calculateTotal($type, $totals){
        switch($type){
            case 'SUM':
                return array_sum($totals);
            case 'COUNT':
                return count($totals);
            case 'AVG':
                return array_sum($totals)/count($totals);
            default:
                return '';
        }
    }

    private function encloseForCSV($field){
        return '"'.$field.'"';
    }

    function build_report_csv(){

        ini_set('zlib.output_compression', 'Off');

        ob_start();
        require_once('include/export_utils.php');

        $delimiter = getDelimiter();
        $csv = '';
        //text/comma-separated-values

        $sql = "SELECT id FROM aor_fields WHERE aor_report_id = '".$this->id."' AND deleted = 0 ORDER BY field_order ASC";
        $result = $this->db->query($sql);

        $fields = array();
        $i = 0;
        while ($row = $this->db->fetchByAssoc($result)) {

            $field = new AOR_Field();
            $field->retrieve($row['id']);

            $path = unserialize(base64_decode($field->module_path));

            $field_module = $this->report_module;
            if($path[0] != $this->report_module){
                foreach($path as $rel){
                    $field_module = getRelatedModule($field_module,$rel);
                }
            }
            $label = str_replace(' ','_',$field->label).$i;
            $fields[$label]['field'] = $field->field;
            $fields[$label]['display'] = $field->display;
            $fields[$label]['function'] = $field->field_function;
            $fields[$label]['module'] = $field_module;


            if($field->display){
                $csv.= $this->encloseForCSV($field->label);
                $csv .= $delimiter;
            }
            ++$i;
        }

        $sql = $this->build_report_query();
        $result = $this->db->query($sql);

        while ($row = $this->db->fetchByAssoc($result)) {
            $csv .= "\r\n";
            foreach($fields as $name => $att){
                if($att['display']){
                    if($att['function'] != '' )
                        $csv .= $this->encloseForCSV($row[$name]);
                    else
                        $csv .= $this->encloseForCSV(trim(strip_tags(getModuleField($att['module'], $att['field'], $att['field'], 'DetailView',$row[$name]))));
                    $csv .= $delimiter;
                }
            }
        }

        $csv= $GLOBALS['locale']->translateCharset($csv, 'UTF-8', $GLOBALS['locale']->getExportCharset());

        ob_clean();
        header("Pragma: cache");
        header("Content-type: text/comma-separated-values; charset=".$GLOBALS['locale']->getExportCharset());
        header("Content-Disposition: attachment; filename=\"{$this->name}.csv\"");
        header("Content-transfer-encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
        header("Last-Modified: " . TimeDate::httpTime() );
        header("Cache-Control: post-check=0, pre-check=0", false );
        header("Content-Length: ".mb_strlen($csv, '8bit'));
        if (!empty($sugar_config['export_excel_compatible'])) {
            $csv==chr(255) . chr(254) . mb_convert_encoding($csv, 'UTF-16LE', 'UTF-8');
        }
        print $csv;

        sugar_cleanup(true);
    }



    function build_report_query($group_value ='', $extra = array()){
        global $beanList;

        $module = new $beanList[$this->report_module]();

        $query = '';
        $query_array = array();

        $query_array = $this->build_report_query_select($query_array, $group_value);
        if(isset($extra['where']) && $extra['where']) {
            $query_array['where'][] = implode(' AND ', $extra['where']) . ' AND ';
        }
        $query_array = $this->build_report_query_where($query_array);

        foreach ($query_array['select'] as $select){
            $query .=  ($query == '' ? 'SELECT ' : ', ').$select;
        }

        $query .= ' FROM '.$this->db->quoteIdentifier($module->table_name).' ';

        if(isset($query_array['join'])){
            foreach ($query_array['join'] as $join){
                $query .= $join;
            }
        }
        if(isset($query_array['where'])){
            $query_where = '';
            foreach ($query_array['where'] as $where){
                $query_where .=  ($query_where == '' ? 'WHERE ' : ' ').$where;
            }

            $query_where = $this->queryWhereRepair($query_where);

            $query .= ' '.$query_where;
        }

        if(isset($query_array['group_by'])){
            $query_group_by = '';
            foreach ($query_array['group_by'] as $group_by){
                $query_group_by .=  ($query_group_by == '' ? 'GROUP BY ' : ', ').$group_by;
            }
            $query .= ' '.$query_group_by;
        }

        if(isset($query_array['sort_by'])){
            $query_sort_by = '';
            foreach ($query_array['sort_by'] as $sort_by){
                $query_sort_by .=  ($query_sort_by == '' ? 'ORDER BY ' : ', ').$sort_by;
            }
            $query .= ' '.$query_sort_by;
        }
        return $query;

    }

    private function queryWhereRepair($query_where) {

        // remove empty parenthesis and fix query syntax

        $safe = 0;
        $query_where_clean = '';
        while($query_where_clean != $query_where) {
            $query_where_clean = $query_where;
            $query_where = preg_replace('/\b(AND|OR)\s*\(\s*\)|\(\s*\)/i', '', $query_where_clean);
            $safe++;
            if($safe>100){
                $GLOBALS['log']->fatal('Invalid report query conditions');
                break;
            }
        }

        return $query_where;
    }

    function build_report_query_select($query = array(), $group_value =''){
        global $beanList;

        if($beanList[$this->report_module]){
            $module = new $beanList[$this->report_module]();

            $query['select'][] = $this->db->quoteIdentifier($module->table_name).".id AS '".$module->table_name."_id'";

            $sql = "SELECT id FROM aor_fields WHERE aor_report_id = '".$this->id."' AND deleted = 0 ORDER BY field_order ASC";
            $result = $this->db->query($sql);
            $i = 0;
            while ($row = $this->db->fetchByAssoc($result)) {

                $field = new AOR_Field();
                $field->retrieve($row['id']);

                $field->label = str_replace(' ','_',$field->label).$i;

                $path = unserialize(base64_decode($field->module_path));

                $field_module = $module;
                $table_alias = $field_module->table_name;
                $oldAlias = $table_alias;
                if(!empty($path[0]) && $path[0] != $module->module_dir){
                    foreach($path as $rel){
                        $new_field_module = new $beanList[getRelatedModule($field_module->module_dir,$rel)];
                        $oldAlias = $table_alias;
                        $table_alias = $table_alias.":".$rel;
                        $query = $this->build_report_query_join($rel, $table_alias, $oldAlias, $field_module, 'relationship', $query, $new_field_module);

                        $field_module = $new_field_module;
                    }
                }

                $data = $field_module->field_defs[$field->field];

                if($data['type'] == 'relate' && isset($data['id_name'])) {
                    $field->field = $data['id_name'];
                    $data_new = $field_module->field_defs[$field->field];
                    if(isset($data_new['source']) && $data_new['source'] == 'non-db' && $data_new['type'] != 'link' && isset($data['link'])){
                        $data_new['type'] = 'link';
                        $data_new['relationship'] = $data['link'];
                    }
                    $data = $data_new;
                }

                if($data['type'] == 'link' && $data['source'] == 'non-db') {
                    $new_field_module = new $beanList[getRelatedModule($field_module->module_dir,$data['relationship'])];
                    $table_alias = $data['relationship'];
                    $query = $this->build_report_query_join($data['relationship'],$table_alias, $oldAlias, $field_module, 'relationship', $query, $new_field_module);
                    $field_module = $new_field_module;
                    $field->field = 'id';
                }

                if($data['type'] == 'currency' && isset($field_module->field_defs['currency_id'])) {
                    if((isset($field_module->field_defs['currency_id']['source']) && $field_module->field_defs['currency_id']['source'] == 'custom_fields')) {
                        $query['select'][$table_alias.'_currency_id'] = $this->db->quoteIdentifier($table_alias.'_cstm').".currency_id AS '".$table_alias."_currency_id'";
                    } else {
                        $query['select'][$table_alias.'_currency_id'] = $this->db->quoteIdentifier($table_alias).".currency_id AS '".$table_alias."_currency_id'";
                    }
                }

                if((isset($data['source']) && $data['source'] == 'custom_fields')) {
                    $select_field = $this->db->quoteIdentifier($table_alias.'_cstm').'.'.$field->field;
                    $query = $this->build_report_query_join($table_alias.'_cstm', $table_alias.'_cstm',$table_alias, $field_module, 'custom', $query);
                } else {
                    $select_field= $this->db->quoteIdentifier($table_alias).'.'.$field->field;
                }

                if($field->sort_by != ''){
                    $query['sort_by'][] = $select_field." ".$field->sort_by;
                }

                if($field->group_by == 1){
                    $query['group_by'][] = $field->format ? str_replace('(%1)', '(' . $select_field . ')', preg_replace(array('/\s+/', '/Y/', '/m/', '/d/'), array(', ', 'YEAR(%1)', 'MONTH(%1)', 'DAY(%1)'), trim(preg_replace('/[^Ymd]/', ' ', $field->format)))) : $select_field;
                }

                if($field->field_function != null){
                    $select_field = $field->field_function.'('.$select_field.')';
                }

                $query['select'][] = $select_field ." AS '".$field->label."'";

                if($field->group_display == 1 && $group_value) $query['where'][] = $select_field." = '".$group_value."' AND ";
                    ++$i;
            }
        }
        return $query;
    }


    function build_report_query_join($name, $alias, $parentAlias, SugarBean $module, $type, $query = array(),SugarBean $rel_module = null ){

        if(!isset($query['join'][$alias])){

            switch ($type){
                case 'custom':
                    $query['join'][$alias] = 'LEFT JOIN '.$this->db->quoteIdentifier($module->get_custom_table_name()).' '.$this->db->quoteIdentifier($name).' ON '.$this->db->quoteIdentifier($parentAlias).'.id = '. $this->db->quoteIdentifier($name).'.id_c ';
                    break;

                case 'relationship':
                    if($module->load_relationship($name)){
                        $params['join_type'] = 'LEFT JOIN';
                        if($module->$name->relationship_type != 'one-to-many'){
                            if($module->$name->getSide() == REL_LHS){
                                $params['right_join_table_alias'] = $this->db->quoteIdentifier($alias);
                                $params['join_table_alias'] = $this->db->quoteIdentifier($alias);
                                $params['left_join_table_alias'] = $this->db->quoteIdentifier($parentAlias);
                            }else{
                                $params['right_join_table_alias'] = $this->db->quoteIdentifier($parentAlias);
                                $params['join_table_alias'] = $this->db->quoteIdentifier($alias);
                                $params['left_join_table_alias'] = $this->db->quoteIdentifier($alias);
                            }

                        }else{
                            $params['right_join_table_alias'] = $this->db->quoteIdentifier($parentAlias);
                            $params['join_table_alias'] = $this->db->quoteIdentifier($alias);
                            $params['left_join_table_alias'] = $this->db->quoteIdentifier($parentAlias);
                        }
                        $linkAlias = $parentAlias."|".$alias;
                        $params['join_table_link_alias'] = $this->db->quoteIdentifier($linkAlias);
                        $join = $module->$name->getJoin($params, true);
                        $query['join'][$alias] = $join['join'];
                        if($rel_module != null) {
                            $query['join'][$alias] .= $this->build_report_access_query($rel_module, $name);
                        }
                        $query['select'][] = $join['select']." AS '".$alias."_id'";
                    }
                    break;
                default:
                    break;

            }

        }
        return $query;
    }

    function build_report_access_query(SugarBean $module, $alias){

        $module->table_name = $alias;
        $where = '';
        if($module->bean_implements('ACL') && ACLController::requireOwner($module->module_dir, 'list') )
        {
            global $current_user;
            $owner_where = $module->getOwnerWhere($current_user->id);
            $where = ' AND '.$owner_where;

        }

        if(file_exists('modules/SecurityGroups/SecurityGroup.php')){
            /* BEGIN - SECURITY GROUPS */
            if($module->bean_implements('ACL') && ACLController::requireSecurityGroup($module->module_dir, 'list') )
            {
                require_once('modules/SecurityGroups/SecurityGroup.php');
                global $current_user;
                $owner_where = $module->getOwnerWhere($current_user->id);
                $group_where = SecurityGroup::getGroupWhere($alias,$module->module_dir,$current_user->id);
                if(!empty($owner_where)){
                    $where .= " AND (".  $owner_where." or ".$group_where.") ";
                } else {
                    $where .= ' AND '.  $group_where;
                }
            }
            /* END - SECURITY GROUPS */
        }

        return $where;
    }

    /**
     * @param array $query
     * @return array
     */
    function build_report_query_where($query = array()){
        global $beanList, $app_list_strings, $sugar_config;

        $closure = false;
        if(!empty($query['where'])) {
            $query['where'][] = '(';
            $closure = true;
        }

        if($beanList[$this->report_module]){
            $module = new $beanList[$this->report_module]();

            $sql = "SELECT id FROM aor_conditions WHERE aor_report_id = '".$this->id."' AND deleted = 0 ORDER BY condition_order ASC";
            $result = $this->db->query($sql);

            $tiltLogicOp = true;

            while ($row = $this->db->fetchByAssoc($result)) {
                $condition = new AOR_Condition();
                $condition->retrieve($row['id']);

                $path = unserialize(base64_decode($condition->module_path));

                $condition_module = $module;
                $table_alias = $condition_module->table_name;
                $oldAlias = $table_alias;
                if(!empty($path[0]) && $path[0] != $module->module_dir){
                    foreach($path as $rel){
                        if(empty($rel)){
                            continue;
                        }
                        // Bug: Prevents relationships from loading.
                        //$rel = strtolower($rel);
                        $new_condition_module = new $beanList[getRelatedModule($condition_module->module_dir,$rel)];
                        $oldAlias = $table_alias;
                        $table_alias = $table_alias.":".$rel;
                        $query = $this->build_report_query_join($rel, $table_alias, $oldAlias, $condition_module, 'relationship', $query, $new_condition_module);
                        $condition_module = $new_condition_module;
                    }
                }
                if(isset($app_list_strings['aor_sql_operator_list'][$condition->operator])) {
                    $where_set = false;

                    $data = $condition_module->field_defs[$condition->field];

                    if ($data['type'] == 'relate' && isset($data['id_name'])) {
                        $condition->field = $data['id_name'];
                        $data_new = $condition_module->field_defs[$condition->field];
                        if (!empty($data_new['source']) && $data_new['source'] == 'non-db' && $data_new['type'] != 'link' && isset($data['link'])) {
                            $data_new['type'] = 'link';
                            $data_new['relationship'] = $data['link'];
                        }
                        $data = $data_new;
                    }

                    if($data['type'] == 'link' && $data['source'] == 'non-db') {
                        $new_field_module = new $beanList[getRelatedModule($condition_module->module_dir,$data['relationship'])];
                        $table_alias = $data['relationship'];
                        $query = $this->build_report_query_join($data['relationship'],$table_alias, $oldAlias, $condition_module, 'relationship', $query, $new_field_module);
                        $condition_module = $new_field_module;

                        // Debugging: security groups conditions - It's a hack to just get the query working
                        if($condition_module->module_dir = 'SecurityGroups' && count($path) > 1) {
//                            $table_alias = 'opportunities:assigned_user_link:SecurityGroups' ;
                            $table_alias = $oldAlias. ':' .$rel;
                        }
                        $condition->field = 'id';
                    }
                    if ((isset($data['source']) && $data['source'] == 'custom_fields')) {
                        $field = $this->db->quoteIdentifier($table_alias . '_cstm') . '.' . $condition->field;
                        $query = $this->build_report_query_join($table_alias . '_cstm', $table_alias . '_cstm', $oldAlias, $condition_module, 'custom', $query);
                    } else {
                        $field = $this->db->quoteIdentifier($table_alias) . '.' . $condition->field;
                    }

                    if (!empty($this->user_parameters[$condition->id]) && $condition->parameter) {
                        $condParam = $this->user_parameters[$condition->id];
                        $condition->value = $condParam['value'];
                        $condition->operator = $condParam['operator'];
                        $condition->value_type = $condParam['type'];
                    }

                    switch ($condition->value_type) {
                        case 'Field':
                            $data = $condition_module->field_defs[$condition->value];

                            if ($data['type'] == 'relate' && isset($data['id_name'])) {
                                $condition->value = $data['id_name'];
                                $data_new = $condition_module->field_defs[$condition->value];
                                if ($data_new['source'] == 'non-db' && $data_new['type'] != 'link' && isset($data['link'])) {
                                    $data_new['type'] = 'link';
                                    $data_new['relationship'] = $data['link'];
                                }
                                $data = $data_new;
                            }

                            if ($data['type'] == 'link' && $data['source'] == 'non-db') {
                                $new_field_module = new $beanList[getRelatedModule($condition_module->module_dir, $data['relationship'])];
                                $table_alias = $data['relationship'];
                                $query = $this->build_report_query_join($data['relationship'], $table_alias, $oldAlias, $condition_module, 'relationship', $query, $new_field_module);
                                $condition_module = $new_field_module;
                                $condition->field = 'id';
                            }
                            if ((isset($data['source']) && $data['source'] == 'custom_fields')) {
                                $value = $condition_module->table_name . '_cstm.' . $condition->value;
                                $query = $this->build_report_query_join($condition_module->table_name . '_cstm', $table_alias . '_cstm', $table_alias, $condition_module, 'custom', $query);
                            } else {
                                $value = $condition_module->table_name . '.' . $condition->value;
                            }
                            break;

                        case 'Date':
                            $params = unserialize(base64_decode($condition->value));
                            if ($params[0] == 'now') {
                                if ($sugar_config['dbconfig']['db_type'] == 'mssql') {
                                    $value = 'GetDate()';
                                } else {
                                    $value = 'NOW()';
                                }
                            } else if($params[0] == 'today'){
                                if($sugar_config['dbconfig']['db_type'] == 'mssql'){
                                    //$field =
                                    $value  = 'CAST(GETDATE() AS DATE)';
                                } else {
                                    $field = 'DATE('.$field.')';
                                    $value = 'Curdate()';
                                }
                            } else {
                                $data = $condition_module->field_defs[$params[0]];
                                if ((isset($data['source']) && $data['source'] == 'custom_fields')) {
                                    $value = $condition_module->table_name . '_cstm.' . $params[0];
                                    $query = $this->build_report_query_join($condition_module->table_name . '_cstm', $table_alias . '_cstm', $table_alias, $condition_module, 'custom', $query);
                                } else {
                                    $value = $condition_module->table_name . '.' . $params[0];
                                }
                            }

                            if ($params[1] != 'now') {
                                switch ($params[3]) {
                                    case 'business_hours';
                                        //business hours not implemented for query, default to hours
                                        $params[3] = 'hours';
                                    default:
                                        if ($sugar_config['dbconfig']['db_type'] == 'mssql') {
                                            $value = "DATEADD(" . $params[3] . ",  " . $app_list_strings['aor_date_operator'][$params[1]] . " $params[2], $value)";
                                        } else {
                                            $value = "DATE_ADD($value, INTERVAL " . $app_list_strings['aor_date_operator'][$params[1]] . " $params[2] " . $params[3] . ")";
                                        }
                                        break;
                                }
                            }
                            break;

                        case 'Multi':
                            $sep = ' AND ';
                            if ($condition->operator == 'Equal_To') $sep = ' OR ';
                            $multi_values = unencodeMultienum($condition->value);
                            if (!empty($multi_values)) {
                                $value = '(';
                                foreach ($multi_values as $multi_value) {
                                    if ($value != '(') $value .= $sep;
                                    $value .= $field . ' ' . $app_list_strings['aor_sql_operator_list'][$condition->operator] . " '" . $multi_value . "'";
                                }
                                $value .= ')';
                            }
                            $query['where'][] = $value;
                            $where_set = true;
                            break;
                        case "Period":
                            if (array_key_exists($condition->value, $app_list_strings['date_time_period_list'])) {
                                $params = $condition->value;
                            } else {
                                $params = base64_decode($condition->value);
                            }
                            $value = '"' . getPeriodDate($params)->format('Y-m-d H:i:s') . '"';
                            break;
                        case "CurrentUserID":
                            global $current_user;
                            $value = '"' . $current_user->id . '"';
                            break;
                        case 'Value':
                        default:
                            $value = "'" . $this->db->quote($condition->value) . "'";
                            break;
                    }

                    //handle like conditions
                    Switch($condition->operator) {
                        case 'Contains':
                            $value = "CONCAT('%', ".$value." ,'%')";
                            break;
                        case 'Starts_With':
                            $value = "CONCAT(".$value." ,'%')";
                            break;
                        case 'Ends_With':
                            $value = "CONCAT('%', ".$value.")";
                            break;
                    }


                    if (!$where_set) $query['where'][] = ($tiltLogicOp ? '' : ($condition->logic_op ? $condition->logic_op . ' ': 'AND ')) . $field . ' ' . $app_list_strings['aor_sql_operator_list'][$condition->operator] . ' ' . $value;

                    $tiltLogicOp = false;
                }
                else if($condition->parenthesis) {
                    if($condition->parenthesis == 'START') {
                        $query['where'][] = ($tiltLogicOp ? '' : ($condition->logic_op ? $condition->logic_op . ' ' : 'AND ')) .  '(';
                        $tiltLogicOp = true;
                    }
                    else {
                        $query['where'][] = ')';
                        $tiltLogicOp = false;
                    }
                }
                else {
                    $GLOBALS['log']->debug('illegal condition');
                }

            }

            if(isset($query['where']) && $query['where']) {
                array_unshift($query['where'], '(');
                $query['where'][] = ') AND ';
            }
            $query['where'][] = $module->table_name.".deleted = 0 ".$this->build_report_access_query($module, $module->table_name);

        }

        if($closure) {
            $query['where'][] = ')';
        }

        return $query;
    }

}
