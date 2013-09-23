<?php
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

$viewdefs['ProjectTask']['EditView'] = array(
    'templateMeta' => array('maxColumns' => '2', 
 
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'), 
                                            array('label' => '10', 'field' => '30')
                                            ),
                            'includes'=> array(
                                            array('file'=>'modules/ProjectTask/ProjectTask.js'),
                                         ),                                        
    ),
 'panels' =>array (
  'default' => 
  array (
    
    array (
      array (
        'name' => 'name',
        'label' => 'LBL_NAME',
      ),
      
      array (
        'name' => 'project_task_id',
        'label' => 'LBL_TASK_ID',
      ),
    ),

  	    
    array (  
      array (
        'name' => 'date_start',
      ),
      
      array (
        'name' => 'date_finish',
      ),
    ),
	array (
        'name' => 'assigned_user_name',
	),
	
    array (
    	array(
			'name' => 'status',
			'customCode' => '<select name="{$fields.status.name}" id="{$fields.status.name}" title="" tabindex="s" onchange="update_percent_complete(this.value);">{if isset($fields.status.value) && $fields.status.value != ""}{html_options options=$fields.status.options selected=$fields.status.value}{else}{html_options options=$fields.status.options selected=$fields.status.default}{/if}</select>',
		),
		'priority',
    ),   
    
     
    array(
      
      array (
        'name' => 'percent_complete',
        'customCode' => '<input type="text" name="{$fields.percent_complete.name}" id="{$fields.percent_complete.name}" size="30" value="{$fields.percent_complete.value}" title="" tabindex="0" onChange="update_status(this.value);" /></tr>',
      ),
    ),

    
    
    array (
      	'milestone_flag',
    ),
    
    array (
      
      array (
        'name' => 'project_name',
        'label' => 'LBL_PROJECT_NAME',
      ),
    ),
    array (

      'task_number',
      'order_number',
    ),

    array (
      'estimated_effort',
	  'utilization',      
    ),       
    
    array (
      array (
        'name' => 'description',
      ),
    ),
    array (
      array (
      	'name' => 'duration',
      	'hideLabel' => true,
      	'customCode' => '<input type="hidden" name="duration" id="projectTask_duration" value="0" />',
      ),
    ),
    array (
      array (
        'name' => 'duration_unit',
      	'hideLabel' => true,
      	'customCode' => '<input type="hidden" name="duration_unit" id="projectTask_durationUnit" value="Days" />',
      	),
    ),
  ),
)


);
?>