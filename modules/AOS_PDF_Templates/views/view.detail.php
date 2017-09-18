<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.detail.php');

class AOS_PDF_TemplatesViewDetail extends ViewDetail {
	function __construct(){
 		parent::__construct();
 	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function AOS_PDF_TemplatesViewDetail(){
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
		$this->setDecodeHTML();
		parent::display();
	}

	function setDecodeHTML(){
		$this->bean->pdfheader = html_entity_decode(str_replace('&nbsp;',' ',$this->bean->pdfheader));
		$this->bean->description = html_entity_decode(str_replace('&nbsp;',' ',$this->bean->description));
		$this->bean->pdffooter = html_entity_decode(str_replace('&nbsp;',' ',$this->bean->pdffooter));
	}
}
?>
