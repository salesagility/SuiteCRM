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
        if (empty($this->id)){
            unset($_POST['aor_conditions_id']);
            unset($_POST['aor_fields_id']);
        }

        parent::save($check_notify);

        require_once('modules/AOR_Fields/AOR_Field.php');
        $condition = new AOR_Field();
        $condition->save_lines($_POST, $this, 'aor_fields_');

        require_once('modules/AOR_Conditions/AOR_Condition.php');
        $condition = new AOR_Condition();
        $condition->save_lines($_POST, $this, 'aor_conditions_');
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

    function build_report_chart(){

        require_once('include/SugarCharts/SugarChartFactory.php');
        $chart = SugarChartFactory::getInstance();

       /* echo $resources = $chart->getChartResources();
        echo $mySugarResources = $chart->getMySugarChartResources();*/

        $chart->setProperties('test', 'sub_test', 'funnel chart 3D');
        $chart->group_by = array('Type2','Assigned to1');
        $result = $this->db->query($this->build_report_query());
        $data = array();
        while($row = $this->db->fetchByAssoc($result, false))
        {
            $row['key'] = $row['Type2'];
            $row['value'] =  $row['Type2'];
            $row['total'] =  $row['count0'];
            $data[] = $row;
        }

        $chart->setData($data);

        $file = create_cache_directory('modules/AOR_Reports/Charts/') .'chart.xml';

        $chart->saveXMLFile($file, $chart->generateXML());

        return $chart->display('test', $file, '100%', '480', false);
    }


    function build_group_report($offset = -1, $links = true){
        global $beanList;

        $html = '';
        $query = '';
        $query_array = array();
        $module = new $beanList[$this->report_module]();

        $sql = "SELECT id FROM aor_fields WHERE aor_report_id = '".$this->id."' AND group_display = 1 AND deleted = 0 ORDER BY field_order ASC";
        $field_id = $this->db->getOne($sql);

        $query_array['select'][] = $module->table_name.".id AS '".$module->table_name."_id'";

        if($field_id != ''){
            $field = new AOR_Field();
            $field->retrieve($field_id);

            $field_label = str_replace(' ','_',$field->label);

            $path = unserialize(base64_decode($field->module_path));

            $field_module = $module;
            $table_alias = $field_module->table_name;
            if($path[0] != $module->module_dir){
                foreach($path as $rel){
                    $new_field_module = new $beanList[getRelatedModule($field_module->module_dir,$rel)];
                    $query_array = $this->build_report_query_join($rel, $field_module, 'relationship', $query_array, $new_field_module);
                    $field_module = $new_field_module;
                    $table_alias = $rel;
                }
            }

            $data = $field_module->field_defs[$field->field];

            if($data['type'] == 'relate' && isset($data['id_name'])) {
                $field->field = $data['id_name'];
            }

            if($data['type'] == 'currency' && !stripos($field->field, '_USD') && isset($field_module->field_defs['currency_id'])) {
                $query_array['select'][$table_alias.'_currency_id'] = $table_alias.".currency_id AS '".$table_alias."_currency_id'";
            }

            if(  (isset($data['source']) && $data['source'] == 'custom_fields')) {
                $select_field = $table_alias.'_cstm.'.$field->field;
                $query_array = $this->build_report_query_join($table_alias.'_cstm', $field_module, 'custom', $query);
            } else {
                $select_field= $table_alias.'.'.$field->field;
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
            $query_array['where'][] = $select_field ." IS NOT NULL ";

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
                    $query_where .=  ($query_where == '' ? 'WHERE ' : ' AND ').$where;
                }
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

            $result = $this->db->query($query);

            while ($row = $this->db->fetchByAssoc($result)) {
                if($html != '') $html .= '<br />';

               $html .= $this->build_report_html($offset, $links, $row[$field_label]);

            }
        }

        if($html == '') $html = $this->build_report_html($offset, $links);
        return $html;

    }


    function build_report_html($offset = -1, $links = true, $group_value = ''){

        global $beanList;

        $report_sql = $this->build_report_query($group_value);
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



            $html .="<td colspan='18'>
                       <table class='paginationTable' border='0' cellpadding='0' cellspacing='0' width='100%'>
                        <td style='text-align:left' ><H3>$group_value</H3></td>
                        <td class='paginationChangeButtons' align='right' nowrap='nowrap' width='1%'>";

            if($offset == 0){
                $html .="<button type='button' id='listViewStartButton_top' name='listViewStartButton' title='Start' class='button' disabled='disabled'>
                    <img src='".SugarThemeRegistry::current()->getImageURL('start_off.gif')."' alt='Start' align='absmiddle' border='0'>
                </button>
                <button type='button' id='listViewPrevButton_top' name='listViewPrevButton' class='button' title='Previous' disabled='disabled'>
                    <img src='".SugarThemeRegistry::current()->getImageURL('previous_off.gif')."' alt='Previous' align='absmiddle' border='0'>
                </button>";
            } else {
                $html .="<button type='button' id='listViewStartButton_top' name='listViewStartButton' title='Start' class='button' onclick='changeReportPage(0,\"".$group_value."\")'>
                    <img src='".SugarThemeRegistry::current()->getImageURL('start.gif')."' alt='Start' align='absmiddle' border='0'>
                </button>
                <button type='button' id='listViewPrevButton_top' name='listViewPrevButton' class='button' title='Previous' onclick='changeReportPage(".$previous_offset.",\"".$group_value."\")'>
                    <img src='".SugarThemeRegistry::current()->getImageURL('previous.gif')."' alt='Previous' align='absmiddle' border='0'>
                </button>";
            }
            $html .=" <span class='pageNumbers'>(".$start ." - ".$end ." of ". $total_rows .")</span>";
            if($next_offset < $total_rows){
                $html .="<button type='button' id='listViewNextButton_top' name='listViewNextButton' title='Next' class='button' onclick='changeReportPage(".$next_offset.",\"".$group_value."\")'>
                        <img src='".SugarThemeRegistry::current()->getImageURL('next.gif')."' alt='Next' align='absmiddle' border='0'>
                    </button>
                     <button type='button' id='listViewEndButton_top' name='listViewEndButton' title='End' class='button' onclick='changeReportPage(".$last_offset.",\"".$group_value."\")'>
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
            $html = "<H3>$group_value</H3>".$html;
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
                    $field_module = getRelatedModule($field_module,$rel);
                    $field_alias = $rel;
                }
            }
            $label = str_replace(' ','_',$field->label).$i;
            $fields[$label]['field'] = $field->field;
            $fields[$label]['display'] = $field->display && !$field->group_display;
            $fields[$label]['function'] = $field->field_function;
            $fields[$label]['module'] = $field_module;
            $fields[$label]['alias'] = $field_alias;
            $fields[$label]['link'] = $field->link;


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

        if($offset >= 0){
            $result = $this->db->limitQuery($report_sql, $offset, $max_rows);
        } else {
            $result = $this->db->query($report_sql);
        }

        $row_class = 'oddListRowS1';

        while ($row = $this->db->fetchByAssoc($result)) {
            $html .= "<tr class='".$row_class."' height='20'>";

            foreach($fields as $name => $att){
                if($att['display']){
                    $html .= "<td class='' valign='top' align='left'>";
                    if($att['link'] && $links) $html .= "<a href='index.php?module=".$att['module']."&action=DetailView&record=".$row[$att['alias'].'_id']."'>";

                    $currency_id = isset($row[$att['alias'].'_currency_id']) ? $row[$att['alias'].'_currency_id'] : '';

                    switch ($att['function']){
                        case 'COUNT':
                        //case 'SUM':
                            $html .= $row[$name];
                            break;
                        default:
                            $html .= getModuleField($att['module'], $att['field'], $att['field'], 'DetailView',$row[$name],'',$currency_id);
                            break;
                    }
                    if($att['link'] && $links) $html .= "</a>";
                    $html .= "</td>";
                }
            }
            $html .= "</tr>";

            $row_class = $row_class == 'oddListRowS1' ?  'evenListRowS1':'oddListRowS1';
        }

        $html .= "</table>";

        return $html;
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
                $csv.= $field->label;
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
                        $csv .= $row[$name];
                    else
                        $csv .= trim(strip_tags(getModuleField($att['module'], $att['field'], $att['field'], 'DetailView',$row[$name])));
                    $csv .= $delimiter;
                }
            }
        }

        $csv= $GLOBALS['locale']->translateCharset($csv, 'UTF-8', $GLOBALS['locale']->getExportCharset());

        ob_clean();
        header("Pragma: cache");
        header("Content-type: text/comma-separated-values; charset=".$GLOBALS['locale']->getExportCharset());
        header("Content-Disposition: attachment; filename={$this->name}.csv");
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



    function build_report_query($group_value =''){
        global $beanList;

        $module = new $beanList[$this->report_module]();

        $query = '';
        $query_array = array();

        $query_array = $this->build_report_query_select($query_array, $group_value);
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
                $query_where .=  ($query_where == '' ? 'WHERE ' : ' AND ').$where;
            }
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

    function build_report_query_select($query = array(), $group_value =''){
        global $beanList;

        if($beanList[$this->report_module]){
            $module = new $beanList[$this->report_module]();

            $query['select'][] = $module->table_name.".id AS '".$module->table_name."_id'";

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
                if($path[0] != $module->module_dir){
                    foreach($path as $rel){
                        $new_field_module = new $beanList[getRelatedModule($field_module->module_dir,$rel)];
                        $query = $this->build_report_query_join($rel, $field_module, 'relationship', $query, $new_field_module);
                        $field_module = $new_field_module;
                        $table_alias = $rel;
                    }
                }

                $data = $field_module->field_defs[$field->field];

                if($data['type'] == 'relate' && isset($data['id_name'])) {
                    $field->field = $data['id_name'];
                    $data_new = $field_module->field_defs[$field->field];
                    if($data_new['source'] == 'non-db' && $data_new['type'] != 'link' && isset($data['link'])){
                        $data_new['type'] = 'link';
                        $data_new['relationship'] = $data['link'];
                    }
                    $data = $data_new;
                }

                if($data['type'] == 'link' && $data['source'] == 'non-db') {
                    $new_field_module = new $beanList[getRelatedModule($field_module->module_dir,$data['relationship'])];
                    $query = $this->build_report_query_join($data['relationship'], $field_module, 'relationship', $query, $new_field_module);
                    $field_module = $new_field_module;
                    $table_alias = $data['relationship'];
                    $field->field = 'id';
                }

                if($data['type'] == 'currency' && isset($field_module->field_defs['currency_id'])) {
                    $query['select'][$table_alias.'_currency_id'] = $table_alias.".currency_id AS '".$table_alias."_currency_id'";
                }

                if((isset($data['source']) && $data['source'] == 'custom_fields')) {
                    $select_field = $table_alias.'_cstm.'.$field->field;
                    $query = $this->build_report_query_join($table_alias.'_cstm', $field_module, 'custom', $query);
                } else {
                    $select_field= $table_alias.'.'.$field->field;
                }

                if($field->sort_by != ''){
                    $query['sort_by'][] = $select_field." ".$field->sort_by;
                }

                if($field->group_by == 1){
                    $query['group_by'][] = $select_field;
                }

                if($field->field_function != null){
                    $select_field = $field->field_function.'('.$select_field.')';
                }

                $query['select'][] = $select_field ." AS '".$field->label."'";

                if($field->group_display) $query['where'][] = $select_field." = '".$group_value."'";
                    ++$i;
            }
        }
        return $query;
    }


    function build_report_query_join($name, SugarBean $module, $type, $query = array(),SugarBean $rel_module = null ){

        if(!isset($query['join'][$name])){

            switch ($type){
                case 'custom':
                    $query['join'][$name] = 'LEFT JOIN '.$module->get_custom_table_name().' '.$name.' ON '.$module->table_name.'.id = '. $name.'.id_c ';
                    break;

                case 'relationship':
                    if($module->load_relationship($name)){
                        $params['join_type'] = 'LEFT JOIN';
                        $params['join_table_alias'] = $name;
                        $join = $module->$name->getJoin($params, true);

                        $query['join'][$name] = $join['join'];
                        if($rel_module != null) $query['join'][$name] .= $this->build_report_access_query($rel_module, $name);
                        $query['select'][] = $join['select']." AS '".$name."_id'";
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

    function build_report_query_where($query = array()){
        global $beanList, $app_list_strings, $sugar_config;


        if($beanList[$this->report_module]){
            $module = new $beanList[$this->report_module]();

            $sql = "SELECT id FROM aor_conditions WHERE aor_report_id = '".$this->id."' AND deleted = 0 ORDER BY condition_order ASC";
            $result = $this->db->query($sql);

            while ($row = $this->db->fetchByAssoc($result)) {
                $condition = new AOR_Condition();
                $condition->retrieve($row['id']);

                $path = unserialize(base64_decode($condition->module_path));

                $condition_module = $module;
                $table_alias = $condition_module->table_name;
                if($path[0] != $module->module_dir){
                    foreach($path as $rel){
                        $new_condition_module = new $beanList[getRelatedModule($condition_module->module_dir,$rel)];
                        $query = $this->build_report_query_join($rel, $condition_module, 'relationship', $query, $new_condition_module);
                        $condition_module = $new_condition_module;
                        $table_alias = $rel;
                    }
                }

                if(isset($app_list_strings['aor_sql_operator_list'][$condition->operator])){
                    $where_set = false;

                    $data = $condition_module->field_defs[$condition->field];

                    if($data['type'] == 'relate' && isset($data['id_name'])) {
                        $condition->field = $data['id_name'];
                        $data_new = $condition_module->field_defs[$condition->field];
                        if($data_new['source'] == 'non-db' && $data_new['type'] != 'link' && isset($data['link'])){
                            $data_new['type'] = 'link';
                            $data_new['relationship'] = $data['link'];
                        }
                        $data = $data_new;
                    }

                    if($data['type'] == 'link' && $data['source'] == 'non-db'){
                        $new_field_module = new $beanList[getRelatedModule($condition_module->module_dir,$data['relationship'])];
                        $query = $this->build_report_query_join($data['relationship'], $condition_module, 'relationship', $query, $new_field_module);
                        $field_module = $new_field_module;
                        $table_alias = $data['relationship'];
                        $condition->field = 'id';
                    }
                    if(  (isset($data['source']) && $data['source'] == 'custom_fields')) {
                        $field = $table_alias.'_cstm.'.$condition->field;
                        $query = $this->build_report_query_join($table_alias.'_cstm', $condition_module, 'custom', $query);
                    } else {
                        $field = $table_alias.'.'.$condition->field;
                    }

                    switch($condition->value_type) {
                        case 'Field':
                            $data = $condition_module->field_defs[$condition->value];

                            if($data['type'] == 'relate' && isset($data['id_name'])) {
                                $condition->value = $data['id_name'];
                                $data_new = $condition_module->field_defs[$condition->value];
                                if($data_new['source'] == 'non-db' && $data_new['type'] != 'link' && isset($data['link'])){
                                    $data_new['type'] = 'link';
                                    $data_new['relationship'] = $data['link'];
                                }
                                $data = $data_new;
                            }

                            if($data['type'] == 'link' && $data['source'] == 'non-db'){
                                $new_field_module = new $beanList[getRelatedModule($field_module->module_dir,$data['relationship'])];
                                $query = $this->build_report_query_join($data['relationship'], $field_module, 'relationship', $query, $new_field_module);
                                $field_module = $new_field_module;
                                $table_alias = $data['relationship'];
                                $field->field = 'id';
                            }
                            if(  (isset($data['source']) && $data['source'] == 'custom_fields')) {
                                $value = $condition_module->table_name.'_cstm.'.$condition->value;
                                $query = $this->build_report_query_join($condition_module->table_name.'_cstm', $condition_module, 'custom', $query);
                            } else {
                                $value = $condition_module->table_name.'.'.$condition->value;
                            }
                            break;

                        case 'Date':
                            $params =  unserialize(base64_decode($condition->value));
                            if($params[0] == 'now'){
                                if($sugar_config['dbconfig']['db_type'] == 'mssql'){
                                    $value  = 'GetDate()';
                                } else {
                                    $value = 'NOW()';
                                }
                            } else {
                                $data = $condition_module->field_defs[$params[0]];
                                if(  (isset($data['source']) && $data['source'] == 'custom_fields')) {
                                    $value = $condition_module->table_name.'_cstm.'.$params[0];
                                    $query = $this->build_report_query_join($condition_module->table_name.'_cstm', $condition_module, 'custom', $query);
                                } else {
                                    $value = $condition_module->table_name.'.'.$params[0];
                                }
                            }

                            if($params[1] != 'now'){
                                switch($params[3]) {
                                    case 'business_hours';
                                        //business hours not implemented for query, default to hours
                                        $params[3] = 'hours';
                                    default:
                                        if($sugar_config['dbconfig']['db_type'] == 'mssql'){
                                            $value = "DATEADD(".$params[3].",  ".$app_list_strings['aor_date_operator'][$params[1]]." $params[2], $value)";
                                        } else {
                                            $value = "DATE_ADD($value, INTERVAL ".$app_list_strings['aor_date_operator'][$params[1]]." $params[2] ".$params[3].")";
                                        }
                                        break;
                                }
                            }
                            break;

                        case 'Multi':
                            $sep = ' AND ';
                            if($condition->operator == 'Equal_To') $sep = ' OR ';
                            $multi_values = unencodeMultienum($condition->value);
                            if(!empty($multi_values)){
                                $value = '(';
                                foreach($multi_values as $multi_value){
                                    if($value != '(') $value .= $sep;
                                    $value .= $field.' '.$app_list_strings['aor_sql_operator_list'][$condition->operator]." '".$multi_value."'";
                                }
                                $value .= ')';
                            }
                            $query['where'][] = $value;
                            $where_set = true;
                            break;

                        case 'Value':
                        default:
                            $value = "'".$condition->value."'";
                            break;
                    }


                    if(!$where_set) $query['where'][] = $field.' '.$app_list_strings['aor_sql_operator_list'][$condition->operator].' '.$value;


                }
            }

            $query['where'][] = $module->table_name.".deleted = 0 ".$this->build_report_access_query($module, $module->table_name);

        }
        return $query;
    }

}
?>
