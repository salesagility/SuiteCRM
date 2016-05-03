<?php

require_once('include/MVC/View/views/view.list.php');
require_once('modules/Opportunities/OpportunitiesListViewSmarty.php');

class OpportunitiesViewList extends ViewList {

	function __construct(){
		parent::__construct();
	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function OpportunitiesViewList(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


	function preDisplay(){
		$this->lv = new OpportunitiesListViewSmarty();
	}
}

?>