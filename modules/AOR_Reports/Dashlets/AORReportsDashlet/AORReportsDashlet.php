<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/Dashlets/Dashlet.php');
require_once 'modules/AOR_Reports/aor_utils.php';

class AORReportsDashlet extends Dashlet {
    var $def;
    var $report;
    var $charts;
    var $onlyCharts;

    function AORReportsDashlet($id, $def = array()) {
		global $current_user, $app_strings;

        parent::Dashlet($id);
        $this->isConfigurable = true;
        $this->def = $def;
        if(empty($def['dashletTitle'])) {
            $this->title = translate('LBL_AOR_REPORTS_DASHLET', 'AOR_Reports');
        }else{
            $this->title = $def['dashletTitle'];
        }

        $this->params = array();
        if(!empty($def['parameter_id'])) {
            foreach ($def['parameter_id'] as $key => $parameterId) {
                $this->params[$parameterId] = array(
                    'id' => $parameterId,
                    'operator' => $def['parameter_operator'][$key],
                    'type' => $def['parameter_type'][$key],
                    'value' => $def['parameter_value'][$key]);
            }
        }
        if(!empty($def['aor_report_id'])) {
            $this->report = BeanFactory::getBean('AOR_Reports', $def['aor_report_id']);
            $this->report->user_parameters = $this->params;
        }
        $this->onlyCharts = !empty($def['onlyCharts']);
        $this->charts = !empty($def['charts']) ? $def['charts'] : array();
    }

    public function display() {
        global $current_language;
        $mod_strings = return_module_language($current_language, 'AOR_Reports');
        $dashletSmarty = new Sugar_Smarty();
        $dashletTemplate = get_custom_file_if_exists('modules/AOR_Reports/Dashlets/AORReportsDashlet/dashlet.tpl');
        $dashletSmarty->assign('MOD',$mod_strings);
        $dashletSmarty->assign('dashlet_id',$this->id);
        $dashletSmarty->assign('report_id',$this->report->id);
        $dashletSmarty->assign('chartHTML',$this->getChartHTML());
        $dashletSmarty->assign('onlyCharts', $this->onlyCharts);
        $dashletSmarty->assign('parameters',json_encode(array(
                                            'ids' => $this->def['parameter_id'],
                                            'operators' => $this->def['parameter_operator'],
                                            'types' => $this->def['parameter_type'],
                                            'values' => $this->def['parameter_value'])));
        return $dashletSmarty->fetch($dashletTemplate);
    }

    function getChartHTML(){
        if(!empty($this->report->id)) {
            return $this->report->build_report_chart($this->charts, AOR_Report::CHART_TYPE_CHARTJS);
        }else{
            return '';
        }
    }

	function process() {
    }

    public function displayOptions() {
        ob_start();
        global $current_language, $app_list_strings;
        $mod_strings = return_module_language($current_language, 'AOR_Reports');
        $optionsSmarty = new Sugar_Smarty();
        $optionsSmarty->assign('MOD',$mod_strings);
        $optionsSmarty->assign('id', $this->id);
        $optionsSmarty->assign('dashletTitle', $this->title);
        $optionsSmarty->assign('aor_report_id', $this->report->id);
        $optionsSmarty->assign('aor_report_name', $this->report->name);
        $optionsSmarty->assign('onlyCharts', $this->onlyCharts);
        $charts = array();
        if(!empty($this->report->id)){
            foreach($this->report->get_linked_beans('aor_charts','AOR_Charts') as $chart){
                $charts[$chart->id] = $chart->name;
            }
        }
        $conditions = getConditionsAsParameters($this->report, $this->params);
        $optionsSmarty->assign('parameters', $conditions);
        $chartOptions = get_select_options_with_id($charts,$this->charts);
        $optionsSmarty->assign('chartOptions', $chartOptions);
        $optionsTemplate = get_custom_file_if_exists('modules/AOR_Reports/Dashlets/AORReportsDashlet/dashletConfigure.tpl');
        ob_clean();
        return $optionsSmarty->fetch($optionsTemplate);
    }
    public function saveOptions($req) {
        $allowedKeys = array_flip(array('aor_report_id','dashletTitle','charts','onlyCharts','parameter_id','parameter_value','parameter_type','parameter_operator'));
        return array_intersect_key($req,$allowedKeys);
    }

    public function hasAccess() {
        return true;
    }
}
