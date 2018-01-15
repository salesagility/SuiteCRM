<?php
require_once('include/ListView/ListViewSmarty.php');
require_once('modules/AOS_PDF_Templates/formLetter.php');


class LeadsListViewSmarty extends ListViewSmarty {

	function __construct(){

		parent::__construct();
		$this->targetList = true;

	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function LeadsListViewSmarty(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    /**
     * 
     * @global array $sugar_config
     * @param file $file Template file to use
     * @param array $data from ListViewData
     * @param string $htmlVar the corresponding html public in xtpl per row
     *
     */
    public function process($file, $data, $htmlVar) {

        global $sugar_config;

        $confirmOptInEnabled = isset($sugar_config['email_enable_confirm_opt_in']) && $sugar_config['email_enable_confirm_opt_in'];

        if ($confirmOptInEnabled) {
            $this->actionsMenuExtraItems[] = $this->buildSendConfirmOptInEmailToPersonAndCompany();
        }

        parent::process($file, $data, $htmlVar);

        if (!ACLController::checkAccess($this->seed->module_dir, 'export', true) || !$this->export) {
            $this->ss->assign('exportLink', $this->buildExportLink());
        }
    }

    function buildExportLink($id = 'export_link'){
		global $app_strings;
		global $sugar_config;

		$script = "";
		if(ACLController::checkAccess($this->seed->module_dir,'export',true)) {
			if($this->export) {
                		$script = parent::buildExportLink($id);
            		}
        	}

            $script .= "<a href='javascript:void(0)' id='map_listview_top' " .
                    " onclick=\"return sListView.send_form(true, 'jjwg_Maps', " .
                    "'index.php?entryPoint=jjwg_Maps&display_module={$_REQUEST['module']}', " .
                    "'{$app_strings['LBL_LISTVIEW_NO_SELECTED']}')\">{$app_strings['LBL_MAP']}</a>";

		return formLetter::LVSmarty().$script;
	}

}

?>
