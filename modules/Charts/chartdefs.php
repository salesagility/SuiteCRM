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


$chartsStrings = return_module_language($GLOBALS['current_language'], 'Charts');

$chartDefs = array(
	'pipeline_by_sales_stage'=>
		array( 	'type' => 'code',
				'id' => 'Chart_pipeline_by_sales_stage',
				'label' => $chartsStrings['LBL_CHART_PIPELINE_BY_SALES_STAGE'],
				'chartUnits' => $chartsStrings['LBL_OPP_SIZE'] . ' $1' . $chartsStrings['LBL_OPP_THOUSANDS'],
				'chartType' => 'horizontal group by chart',
				'groupBy' => array( 'sales_stage', 'user_name' ), 
				'base_url'=> 
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				'url_params' => array( 'assigned_user_id', 'sales_stage', 'date_start', 'date_closed' ),				
			),
	'lead_source_by_outcome'=>
		array(	'type' => 'code',
				'id' => 'Chart_lead_source_by_outcome',
				'label' => $chartsStrings['LBL_CHART_LEAD_SOURCE_BY_OUTCOME'],
				'chartUnits' => '',
				'chartType' => 'horizontal group by chart',
				'groupBy' => array( 'lead_source', 'sales_stage' ),
				'base_url'=> 
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				'url_params' => array( 'lead_source', 'sales_stage', 'date_start', 'date_closed' ),				
			 ),
	'outcome_by_month'=>
		array(	'type' => 'code',
				'id' => 'Chart_outcome_by_month',
				'label' => $chartsStrings['LBL_CHART_OUTCOME_BY_MONTH'],
				'chartUnits' => $chartsStrings['LBL_OPP_SIZE'] . ' $1' . $chartsStrings['LBL_OPP_THOUSANDS'],
				'chartType' => 'stacked group by chart',
				'groupBy' => array( 'm', 'sales_stage', ),
				'base_url'=> 
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				'url_params' => array( 'sales_stage', 'date_closed' ),								
			 ),
	'pipeline_by_lead_source'=>
		array(	'type' => 'code',
				'id' => 'Chart_pipeline_by_lead_source',
				'label' => $chartsStrings['LBL_CHART_PIPELINE_BY_LEAD_SOURCE'],
				'chartUnits' => $chartsStrings['LBL_OPP_SIZE'] . ' $1' . $chartsStrings['LBL_OPP_THOUSANDS'],
				'chartType' => 'pie chart',
				'groupBy' => array( 'lead_source', ),
				'base_url'=> 
					array( 	'module' => 'Opportunities',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				'url_params' => array( 'lead_source', ),
			 ),
	
	'my_modules_used_last_30_days' =>
		array( 	'type' => 'code',
				'id' => 'my_modules_used_last_30_days',
				'label' => $chartsStrings['LBL_CHART_MY_MODULES_USED_30_DAYS'],
				'chartType' => 'horizontal bar chart',
				'chartUnits' => $chartsStrings['LBL_MY_MODULES_USED_SIZE'],
				'groupBy' => array( 'module_name'),
				'base_url'=> 
					array( 	'module' => 'Trackers',
							'action' => 'index',
							'query' => 'true',
							'searchFormTab' => 'advanced_search',
						 ),
				
		),

);

if(file_exists('custom/Charts/chartDefs.ext.php')){
	include_once('custom/Charts/chartDefs.ext.php');	
}
?>