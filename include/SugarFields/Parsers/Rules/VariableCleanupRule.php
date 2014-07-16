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


/**
 * VariableCleanupRule.php
 * 
 * This is a utility base class to provide further refinement when converting 
 * pre 5.x files to the new meta-data rules.
 *
 * @author Collin Lee
 */
 
require_once('include/SugarFields/Parsers/Rules/BaseRule.php');
 
class VariableCleanupRule extends BaseRule {

function VariableCleanupRule() {
	
}

function parsePanels($panels, $view) {

   if($view == 'DetailView') {
		foreach($panels as $name=>$panel) {
	   	  foreach($panel as $rowCount=>$row) {
	   	  	 foreach($row as $key=>$column) {
	   	  	 	//This converts variable ended with "_c_checked" to just "_c" (for checkboxes in DetailView)
				if(!is_array($column) && isset($column) && preg_match('/(.*?)_c_checked$/s', $column, $matches)) {
	   	  	 	   if(count($matches) == 2) {
	   	  	 	      $panels[$name][$rowCount][$key] = $matches[1] . "_c";
	   	  	 	   }
	   	  	 	} else if($this->matches($column, '/^parent_id$/si')) {
	   	  	 		  $panels[$name][$rowCount][$key] = '';
				} else if($this->matches($column, '/^assigned_user_id$/si')) {
	   	  	 	   $panels[$name][$rowCount][$key] = '';	
	   	  	 	}
	   	  	 } //foreach 
	   	  } //foreach
	   } //foreach
	   
   } else if ($view == 'EditView') {
   	    
		foreach($panels as $name=>$panel) {
	   	  foreach($panel as $rowCount=>$row) {
	   	  	 foreach($row as $key=>$column) {
	   	  	 	if($this->matches($column, '/^(.*?)_c\[\]$/s')) {
	   	  	 	   //This converts multienum variables named with [] suffix back to normal and removes custom code
	   	  	 	   $val = $this->getMatch($column, '/^(.*?)_c\[\]$/s');
	   	  	 	   $panels[$name][$rowCount][$key] = $val[1] . '_c';
	   	  	 	} else if($this->matches($column, '/^parent_id$/si')) {
	   	  	 	   //Remove parent_id field (replaced with parent_name from master copy)
	   	  	 	   $panels[$name][$rowCount][$key] = '';	
	   	  	 	} else if($this->matches($column, '/^assigned_user_id$/si')) {
	   	  	 	   //Remove assigned_user_id field (replaced with assigned_user_name from master copy)
	   	  	 	   $panels[$name][$rowCount][$key] = '';	
	   	  	 	} else if($this->matches($column, '/^RADIOOPTIONS_/si')) {
	   	  	 	   //This converts radioenum variables
	   	  	 	   $val = $this->getMatch($column, '/^RADIOOPTIONS_(.*)?$/si');
	   	  	 	   $panels[$name][$rowCount][$key] = $val[1];
	   	  	 	}
	   	  	 } //foreach
	   	  } //foreach
	   } //foreach   	
   }
   
   return $panels;
}

}

?>
