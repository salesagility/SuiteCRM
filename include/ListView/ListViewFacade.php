<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/


/*
 * Created on Sep 10, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require_once('include/ListView/ListViewSmarty.php');


 /**
  * A Facade to ListView and ListViewSmarty
  */
 class ListViewFacade{

 	var $focus = null;
 	var $module = '';
 	var $type = 0;

 	var $lv;

 	//ListView fields
 	var $template;
 	var $title;
 	var $where = '';
 	var $params = array();
 	var $offset = 0;
 	var $limit = -1;
 	var $filter_fields = array();
 	var $id_field = 'id';
 	var $prefix = '';
 	var $mod_strings = array();

 	/**
 	 * Constructor
 	 * @param $focus - the bean
 	 * @param $module - the module name
 	 * @param - 0 = decide for me, 1 = ListView.html, 2 = ListViewSmarty
 	 */
 	function __construct($focus, $module, $type = 0){
 		$this->focus = $focus;
 		$this->module = $module;
 		$this->type = $type;
 		$this->build();
 	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function ListViewFacade($focus, $module, $type = 0){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($focus, $module, $type);
    }


 	function build(){
 		//we will assume that if the ListView.html file exists we will want to use that one
 		if(file_exists('modules/'.$this->module.'/ListView.html')){
 			$this->type = 1;
 			$this->lv = new ListView();
 			$this->template = 'modules/'.$this->module.'/ListView.html';
 		}else{
			$metadataFile = null;
        	$foundViewDefs = false;
        	if(file_exists('custom/modules/' . $this->module. '/metadata/listviewdefs.php')){
            	$metadataFile = 'custom/modules/' .  $this->module . '/metadata/listviewdefs.php';
            	$foundViewDefs = true;
        	}else{
            	if(file_exists('custom/modules/'. $this->module.'/metadata/metafiles.php')){
                	require_once('custom/modules/'. $this->module.'/metadata/metafiles.php');
                	if(!empty($metafiles[ $this->module]['listviewdefs'])){
                    	$metadataFile = $metafiles[ $this->module]['listviewdefs'];
                    	$foundViewDefs = true;
                	}
            	}elseif(file_exists('modules/'. $this->module.'/metadata/metafiles.php')){
                	require_once('modules/'. $this->module.'/metadata/metafiles.php');
                	if(!empty($metafiles[ $this->module]['listviewdefs'])){
                    	$metadataFile = $metafiles[ $this->module]['listviewdefs'];
                    	$foundViewDefs = true;
                	}
            	}
        	}
	        if(!$foundViewDefs && file_exists('modules/'. $this->module.'/metadata/listviewdefs.php')){
	                $metadataFile = 'modules/'. $this->module.'/metadata/listviewdefs.php';
	        }
	        require_once($metadataFile);


			$this->lv = new ListViewSmarty();
			$displayColumns = array();
			if(!empty($_REQUEST['displayColumns'])) {
			    foreach(explode('|', $_REQUEST['displayColumns']) as $num => $col) {
			        if(!empty($listViewDefs[$this->module][$col]))
			            $displayColumns[$col] = $listViewDefs[$this->module][$col];
			    }
			}
			else {
			    foreach($listViewDefs[$this->module] as $col => $params) {
			        if(!empty($params['default']) && $params['default'])
			            $displayColumns[$col] = $params;
			    }
			}
			$this->lv->displayColumns = $displayColumns;
			$this->type = 2;
			$this->template = 'include/ListView/ListViewGeneric.tpl';
 		}
 	}

 	function setup($template = '', $where = '', $params = array(), $mod_strings = array(), $offset = 0, $limit = -1, $orderBy = '', $prefix = '', $filter_fields = array(), $id_field = 'id'){
 		if(!empty($template))
 			$this->template = $template;

 		$this->mod_strings = $mod_strings;

 		if($this->type == 1){
 			$this->lv->initNewXTemplate($this->template,$this->mod_strings);
 			$this->prefix = $prefix;
 			$this->lv->setQuery($where, $limit, $orderBy, $prefix);
 			$this->lv->show_select_menu = false;
			$this->lv->show_export_button = false;
			$this->lv->show_delete_button = false;
			$this->lv->show_mass_update = false;
			$this->lv->show_mass_update_form = false;
 		}else{
 			$this->lv->export = false;
			$this->lv->delete = false;
			$this->lv->select = false;
			$this->lv->mailMerge = false;
			$this->lv->multiSelect = false;
 			$this->lv->setup($this->focus, $this->template, $where, $params, $offset, $limit,  $filter_fields, $id_field);

 		}
 	}

 	function display($title = '', $section = 'main', $return = FALSE){
 		if($this->type == 1){
            ob_start();
 			$this->lv->setHeaderTitle($title);
 			$this->lv->processListView($this->focus, $section, $this->prefix);
            $output = ob_get_contents();
            ob_end_clean();
 		}else{
             $output = get_form_header($title, '', false) . $this->lv->display();
 		}
        if($return)
            return $output;
        else
            echo $output;
 	}

	function setTitle($title = ''){
		$this->title = $title;
	}
 }
?>
