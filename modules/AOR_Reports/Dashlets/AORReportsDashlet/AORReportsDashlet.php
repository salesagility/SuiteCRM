<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/Dashlets/Dashlet.php');


class AORReportsDashlet extends Dashlet {

    function AORReportsDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/AOR_Reports/Dashlets/AORReportsDashlet/AORReportsDashlet.data.php');

        parent::Dashlet($id);
        $this->isConfigurable = true;

        if(empty($def['dashletTitle'])) {
            $this->title = translate('LBL_AOR_REPORTS_DASHLET', 'AOR_Reports');
        }else{
            $this->title = $def['dashletTitle'];
        }
        $this->report = BeanFactory::getBean('AOR_Reports',$def['aor_report_id']);
    }

    public function display() {
        global $current_language;
        $mod_strings = return_module_language($current_language, 'AOR_Reports');
        $dashletSmarty = new Sugar_Smarty();
        $dashletTemplate = get_custom_file_if_exists('modules/AOR_Reports/Dashlets/AORReportsDashlet/dashlet.tpl');
        $dashletSmarty->assign('MOD',$mod_strings);
        $dashletSmarty->assign('dashlet_id',$this->id);
        $dashletSmarty->assign('report_id',$this->report->id);
        return $dashletSmarty->fetch($dashletTemplate);
    }

	function process() {
    }

    public function displayOptions() {
        global $current_language;
        $mod_strings = return_module_language($current_language, 'AOR_Reports');
        $optionsSmarty = new Sugar_Smarty();
        $optionsSmarty->assign('MOD',$mod_strings);
        $displayRowOptions = $GLOBALS['sugar_config']['dashlet_display_row_options'];
        $optionsSmarty->assign('id', $this->id);
        $optionsSmarty->assign('displayRowOptions', $displayRowOptions);
        $optionsSmarty->assign('displayRowSelect', $this->displayRows);
        $optionsSmarty->assign('dashletTitle', $this->title);
        $optionsSmarty->assign('aor_report_id', $this->report->id);
        $optionsSmarty->assign('aor_report_name', $this->report->name);
        $optionsTemplate = get_custom_file_if_exists('modules/AOR_Reports/Dashlets/AORReportsDashlet/dashletConfigure.tpl');

        return $optionsSmarty->fetch($optionsTemplate);
    }
    public function saveOptions($req) {
        $allowedKeys = array('aor_report_id'=>1,'dashletTitle'=>1);
        return array_intersect_key($req,$allowedKeys);
    }

    public function hasAccess() {
        return true;
    }
}
