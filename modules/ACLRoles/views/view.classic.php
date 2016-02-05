<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.detail.php');

class ACLRolesViewClassic extends ViewDetail {


 	function ACLRolesViewClassic(){
 		parent::ViewDetail();

        //turn off normal display of subpanels
        $this->options['show_subpanels'] = false; //no longer works in 6.3.0
 	}

 	function display(){
		$this->dv->process();

		$file = SugarController::getActionFilename($this->action);
		$this->includeClassicFile('modules/'. $this->module . '/'. $file . '.php');
 	}

 	function preDisplay(){
		parent::preDisplay();

		$this->options['show_subpanels'] = false; //eggsurplus: will display subpanels twice otherwise
 	}
}

?>
