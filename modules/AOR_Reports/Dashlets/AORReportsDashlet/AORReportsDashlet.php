<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/Dashlets/Dashlet.php');


class AORReportsDashlet extends Dashlet {

    function AORReportsDashlet($id, $def = array()) {
		global $current_user, $app_strings;

        parent::Dashlet($id);
        $this->isConfigurable = true;

        if(empty($def['dashletTitle'])) {
            $this->title = translate('LBL_AOR_REPORTS_DASHLET', 'AOR_Reports');
        }else{
            $this->title = $def['dashletTitle'];
        }
        $this->report = BeanFactory::getBean('AOR_Reports',$def['aor_report_id']);
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
        return $dashletSmarty->fetch($dashletTemplate);
    }

    function getChartHTML(){
        $chartHTML = $this->report->build_report_chart($this->charts);
        return $chartHTML;
    }

	function process() {
    }

    public function displayOptions() {
        global $current_language;
        $mod_strings = return_module_language($current_language, 'AOR_Reports');
        $optionsSmarty = new Sugar_Smarty();
        $optionsSmarty->assign('MOD',$mod_strings);
        $optionsSmarty->assign('id', $this->id);
        $optionsSmarty->assign('dashletTitle', $this->title);
        $optionsSmarty->assign('aor_report_id', $this->report->id);
        $optionsSmarty->assign('aor_report_name', $this->report->name);
        $optionsSmarty->assign('onlyCharts', $this->onlyCharts);
        $charts = array();
        foreach($this->report->get_linked_beans('aor_charts','AOR_Charts') as $chart){
            $charts[$chart->id] = $chart->name;
        }
        $chartOptions = get_select_options_with_id($charts,$this->charts);
        $optionsSmarty->assign('chartOptions', $chartOptions);
        $optionsTemplate = get_custom_file_if_exists('modules/AOR_Reports/Dashlets/AORReportsDashlet/dashletConfigure.tpl');

        return $optionsSmarty->fetch($optionsTemplate);
    }
    public function saveOptions($req) {
        $allowedKeys = array_flip(array('aor_report_id','dashletTitle','charts','onlyCharts'));
        return array_intersect_key($req,$allowedKeys);
    }

    public function hasAccess() {
        return true;
    }
}
