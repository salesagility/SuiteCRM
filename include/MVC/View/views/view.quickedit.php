<?php
//FILE SUGARCRM flav=pro || flav=sales
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/



require_once('include/MVC/View/views/view.ajax.php');
require_once('include/EditView/EditView2.php');


class ViewQuickedit extends ViewAjax
{
    /**
     * $var true if this form is used in the Dashlet Container
     */
	protected $_isDCForm = false;

	/**
	 * @var EditView object
	 */
	protected $ev;

    /**
     * @var headerTpl String variable of the Smarty template file used to render the header portion
     */
    protected $headerTpl = 'include/EditView/header.tpl';

    /**
     * @var footerTpl String variable of the Smarty template file used to render the footer portion
     */
    protected $footerTpl = 'include/EditView/footer.tpl';

    /**
     * @var defaultButtons Array of default buttons assigned to the form (see function.sugar_button.php)
     */
    protected $defaultButtons = array('DCMENUSAVE', 'DCMENUCANCEL', 'DCMENUFULLFORM');

    /**
     * @see SugarView::preDisplay()
     */
    public function preDisplay()
    {
    	if(!empty($_REQUEST['source_module']) && $_REQUEST['source_module'] != 'undefined' && !empty($_REQUEST['record'])) {
			$this->bean = loadBean($_REQUEST['source_module']);
			if ( $this->bean instanceOf SugarBean
			        && !in_array($this->bean->object_name,array('EmailMan')) ) {
                $this->bean->retrieve($_REQUEST['record']);
                if(!empty($this->bean->id))$_REQUEST['parent_id'] = $this->bean->id;
                if(!empty($this->bean->module_dir))$_REQUEST['parent_type'] = $this->bean->module_dir;
                if(!empty($this->bean->name))$_REQUEST['parent_name'] = $this->bean->name;
                if(!empty($this->bean->id))$_REQUEST['return_id'] = $this->bean->id;
                if(!empty($this->bean->module_dir))$_REQUEST['return_module'] = $this->bean->module_dir;

                //Now preload any related fields
			    if(isset($_REQUEST['module'])) {
                	$target_bean = loadBean($_REQUEST['module']);
	                foreach($target_bean->field_defs as $fields) {
	                	if($fields['type'] == 'relate' && isset($fields['module']) && $fields['module'] == $_REQUEST['source_module'] && isset($fields['rname'])) {
	                	   $rel_name = $fields['rname'];
	                	   if(isset($this->bean->$rel_name)) {
	                	   	  $_REQUEST[$fields['name']] = $this->bean->$rel_name;
	                	   }
	                	 	if(!empty($_REQUEST['record']) && !empty($fields['id_name'])) {
	                	 		$_REQUEST[$fields['id_name']] = $_REQUEST['record'];
	                	   }
	                	}
	                }
                }
            }
            $this->_isDCForm = true;
    	}
    }

    /**
     * @see SugarView::display()
     */
    public function display()
    {	    
        if(($this->bean instanceOf SugarBean) && !$this->bean->ACLAccess('edit')){
            $no_defs_js = '<script>SUGAR.ajaxUI.loadContent("index.php?module=' . $this->bean->module_dir . '&action=Noaccess&record=' . $this->bean->id.'")</script>';
            echo json_encode(array('scriptOnly'=> $no_defs_js));
            return;
        }

    	$view = (!empty($_REQUEST['target_view']))?$_REQUEST['target_view']: 'QuickCreate';
		$module = $_REQUEST['module'];

		// locate the best viewdefs to use: 1. custom/module/quickcreatedefs.php 2. module/quickcreatedefs.php 3. custom/module/editviewdefs.php 4. module/editviewdefs.php
		$base = 'modules/' . $module . '/metadata/';
		$source = 'custom/' . $base . strtolower($view) . 'defs.php';
		if (!file_exists( $source))
		{
			$source = $base . strtolower($view) . 'defs.php';
			if (!file_exists($source))
			{
				//if our view does not exist default to EditView
				$view = 'EditView';
				$source = 'custom/' . $base . 'editviewdefs.php';
				if (!file_exists($source))
				{
					$source = $base . 'editviewdefs.php';
				}
			}
		}

        // In some cases, the source file will not exist. In these cases, just navigate to the full form directly.
        if(!file_exists($source)){
            global $app_strings;

            //write out jscript that will get evaluated and redirect the browser window.
            $no_defs_js = '<script>SUGAR.ajaxUI.loadContent("index.php?return_module='.$this->bean->module_dir.'&module=' . $this->bean->module_dir . '&action=EditView&record=' . $this->bean->id.'")</script>';

            //reports is a special case as it does not have an edit view so navigate to wizard view
            if(strtolower($module) == 'reports'){
                $no_defs_js = '<script>SUGAR.ajaxUI.loadContent("index.php?return_module='.$this->bean->module_dir.'&module=' . $this->bean->module_dir . '&action=ReportsWizard&record=' . $this->bean->id.'")</script>';
            }
            //if this is not reports and there are no edit view files then go to detail view
            elseif(!file_exists('custom/' . $base . 'editviewdefs.php') && !file_exists($base . 'editviewdefs.php')
            && !file_exists('custom/modules/' . $module .'/EditView.php') && !file_exists('modules/' . $module .'/EditView.php')
            ){
                $no_defs_js = '<script>SUGAR.ajaxUI.loadContent("index.php?return_module='.$this->bean->module_dir.'&module=' . $this->bean->module_dir . '&action=DetailView&record=' . $this->bean->id.'")</script>';
            }

            echo json_encode(array('scriptOnly'=> $no_defs_js));

          return;

        }

        $this->ev = $this->getEditView();
		$this->ev->view = $view;
		$this->ev->ss = new Sugar_Smarty();

		$this->ev->ss->assign('isDCForm', $this->_isDCForm);
		//$_REQUEST['return_action'] = 'SubPanelViewer';
		$this->ev->setup($module, $this->bean, $source);
		$this->ev->showSectionPanelsTitles = false;
	    $this->ev->defs['templateMeta']['form']['headerTpl'] = $this->headerTpl;
		$this->ev->defs['templateMeta']['form']['footerTpl'] = $this->footerTpl;
		$this->ev->defs['templateMeta']['form']['buttons'] = $this->defaultButtons;
		$this->ev->defs['templateMeta']['form']['button_location'] = 'bottom';
		$this->ev->defs['templateMeta']['form']['hidden'] = '<input type="hidden" name="is_ajax_call" value="1" />';
		$this->ev->defs['templateMeta']['form']['hidden'] .= '<input type="hidden" name="from_dcmenu" value="1" />';
        $this->ev->defs['templateMeta']['form']['hideAudit']=true;

        //use module level view if available
        $editFileName = 'modules/'.$module.'/views/view.edit.php';
        if(file_exists('custom/modules/'.$module.'/views/view.edit.php')) {
            $editFileName = 'custom/modules/'.$module.'/views/view.edit.php';
        }

        $defaultProcess = true;
        if(file_exists($editFileName)) {
           include($editFileName);
           $c = $module . 'ViewEdit';

           if(class_exists($c)) {
               $view = new $c;
               if($view->useForSubpanel) {
	            	$defaultProcess = false;

                   //Check if we should use the module's QuickCreate.tpl file
                   if($view->useModuleQuickCreateTemplate && file_exists('modules/'.$module.'/tpls/QuickCreate.tpl')) {
                      $this->ev->defs['templateMeta']['form']['headerTpl'] = 'modules/'.$module.'/tpls/QuickCreate.tpl';
                   }

                   $view->ev = & $this->ev;
                   $view->ss = & $this->ev->ss;
                   $class = $GLOBALS['beanList'][$module];
                   if(!empty($GLOBALS['beanFiles'][$class])){
                       require_once($GLOBALS['beanFiles'][$class]);
                       $bean = new $class();
                       if (isset($_REQUEST['record']) && $_REQUEST['record'] != false)
                       {
                           $bean->retrieve($_REQUEST['record']);
                       }
                       $view->bean = $bean;
                   }
                   $view->ev->formName = 'form_DC'.$view->ev->view .'_'.$module;
                   $view->showTitle = false; // Do not show title since this is for subpanel
                   ob_start();
                   $view->display();
                   $captured =  ob_get_clean();
                   echo json_encode(array('title'=> $this->bean->name, 'url'=>'index.php?module=' . $this->bean->module_dir . '&action=DetailView&record=' . $this->bean->id ,'html'=> $captured, 'eval'=>true));
               }
           }
       }

        //if defaultProcess is still true, then the default edit view was not used.  Finish processing.
        if($defaultProcess){
		   $form_name = 'form_DC'.$this->ev->view .'_'.$module;
		   $this->ev->formName = $form_name;
		   $this->ev->process(true, $form_name);
			ob_clean();
            echo json_encode(array('title'=> $this->bean->name, 'url'=>'index.php?module=' . $this->bean->module_dir . '&action=DetailView&record=' . $this->bean->id ,'html'=> $this->ev->display(false, true), 'eval'=>true));
		}
	}


    /**
     * Get EditView object
     * @return EditView
     */
    protected function getEditView()
    {
        return new EditView();
    }
}
