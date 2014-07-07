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


require_once('include/Dashlets/Dashlet.php');


class CalendarDashlet extends Dashlet {
    var $view = 'week';

    function CalendarDashlet($id, $def) {
        $this->loadLanguage('CalendarDashlet','modules/Calendar/Dashlets/');

		parent::Dashlet($id); 
         
		$this->isConfigurable = true; 
		$this->hasScript = true;  
                
		if(empty($def['title'])) 
			$this->title = $this->dashletStrings['LBL_TITLE'];
		else 
			$this->title = $def['title'];  
			
		if(!empty($def['view']))
			$this->view = $def['view'];			
             
    }

    function display(){
		ob_start();
		
		if(isset($GLOBALS['cal_strings']))
			return parent::display() . "Only one Calendar dashlet is allowed.";
			
		require_once('modules/Calendar/Calendar.php');
		require_once('modules/Calendar/CalendarDisplay.php');
		require_once("modules/Calendar/CalendarGrid.php");
		
		global $cal_strings, $current_language;
		$cal_strings = return_module_language($current_language, 'Calendar');
		
		if(!ACLController::checkAccess('Calendar', 'list', true))
			ACLController::displayNoAccess(true);
						
		$cal = new Calendar($this->view);
		$cal->dashlet = true;
		$cal->add_activities($GLOBALS['current_user']);
		$cal->load_activities();
		
		$display = new CalendarDisplay($cal,$this->id);
		$display->display_calendar_header(false);		
		$display->display();
			
		$str = ob_get_contents();	
		ob_end_clean();
		
		return parent::display() . $str;
    }
    

    function displayOptions() {
        global $app_strings,$mod_strings;        
        $ss = new Sugar_Smarty();
        $ss->assign('MOD', $this->dashletStrings);        
        $ss->assign('title', $this->title);
        $ss->assign('view', $this->view);
        $ss->assign('id', $this->id);

        return parent::displayOptions() . $ss->fetch('modules/Calendar/Dashlets/CalendarDashlet/CalendarDashletOptions.tpl');
    }  

    function saveOptions($req) {
        global $sugar_config, $timedate, $current_user, $theme;
        $options = array();
        $options['title'] = $_REQUEST['title']; 
        $options['view'] = $_REQUEST['view'];       
         
        return $options;
    }

    function displayScript(){
	return "";
    }


}

?>
