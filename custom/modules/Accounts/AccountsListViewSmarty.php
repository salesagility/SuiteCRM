<?php
require_once('include/ListView/ListViewSmarty.php');
require_once('modules/AOS_PDF_Templates/formLetter.php');


class AccountsListViewSmarty extends ListViewSmarty {
	
	function AccountsListViewSmarty(){
	
		parent::ListViewSmarty();
		$this->targetList = true;
	
	}
	
	function process($file, $data, $htmlVar) {
		parent::process($file, $data, $htmlVar);

        	if(!ACLController::checkAccess($this->seed->module_dir,'export',true) || !$this->export) {    
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
