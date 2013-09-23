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

$viewdefs['ProjectTask']['DetailView'] = array(
    'templateMeta' => array('maxColumns' => '2',
                            'widths' => array(
                                            array('label' => '10', 'field' => '30'),
                                            array('label' => '10', 'field' => '30')
                                            ),
                            'includes'=> array(
                                         array('file'=>'modules/ProjectTask/ProjectTask.js'),
                                         	),
                            'form' => array(
										'buttons' => array( 'EDIT',
																'DUPLICATE', 'DELETE',
														),
										'hideAudit' => true,
											),

    ),
 'panels' =>array (
  'default' =>
  array (

    array (
      'name',

      array (
        'name' => 'project_task_id',
        'label' => 'LBL_TASK_ID',
      ),
    ),    

    array (
      'date_start',
      'date_finish',
    ),
	array (
		array (
		        'name' => 'assigned_user_name',
		        'label' => 'LBL_ASSIGNED_USER_ID',
		      ),
		array (
		),
	),    


    array (
		'status',
		'priority',
    ),    
    
    array (
      'percent_complete',
      array (
        'name' => 'milestone_flag',
        'label' => 'LBL_MILESTONE_FLAG',
      ),
    ),    


    array (

      array (
        'name' => 'project_name',
        'customCode' => '<a href="index.php?module=Project&action=DetailView&record={$fields.project_id.value}">{$fields.project_name.value}&nbsp;</a>',
        'label' => 'LBL_PARENT_ID',
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

  ),
)


);
?>