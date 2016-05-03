<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.detail.php');

class ACLRolesViewClassic extends ViewDetail {


 	function __construct(){
 		parent::__construct();

        //turn off normal display of subpanels
        $this->options['show_subpanels'] = false; //no longer works in 6.3.0
 	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function ACLRolesViewClassic(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
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
