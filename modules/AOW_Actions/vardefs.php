<?php
/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author SalesAgility <info@salesagility.com>
 */


$dictionary['AOW_Action'] = array(
	'table'=>'aow_actions',
	'audited'=>false,
	'duplicate_merge'=>true,
	'fields'=>array (
  'aow_workflow_id' => 
  array (
    'required' => false,
    'name' => 'aow_workflow_id',
    'vname' => 'LBL_WORKFLOW_ID',
    'type' => 'id',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => false,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 36,
    'size' => '20',
  ),
  'action_order' => 
  array (
    'required' => false,
    'name' => 'action_order',
    'vname' => 'LBL_ORDER',
    'type' => 'int',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => '255',
    'size' => '20',
    'enable_range_search' => false,
    'disable_num_format' => '',
  ),
  'action' => 
  array (
    'required' => false,
    'name' => 'action',
    'vname' => 'LBL_ACTION',
    'type' => 'enum',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 100,
    'size' => '20',
    'options' => 'aow_actions_list',
    'studio' => 'visible',
    'dependency' => false,
  ),
  'parameters' =>
  array (
    'name' => 'parameters',
    'type' => 'longtext',
    'vname' => 'LBL_PARAMETERS',
    'isnull' => true,
  ),
  'aow_workflow' =>
  array (
    'name' => 'aow_workflow',
    'type' => 'link',
    'relationship' => 'aow_workflow_aow_actions',
    'module'=>'AOW_WorkFlow',
    'bean_name'=>'AOW_WorkFlow',
    'source'=>'non-db',
   ),
  'aow_processed' =>
  array (
    'name' => 'aow_processed',
    'type' => 'link',
    'relationship' => 'aow_processed_aow_actions',
    'module'=>'AOW_Processed',
    'bean_name'=>'AOW_Processed',
    'source'=>'non-db',
  ),
),
	'relationships'=>array (
),
    'indices' => array(
        array(
            'name' => 'aow_action_index_workflow_id',
            'type' => 'index',
            'fields' => array('aow_workflow_id'),
        ),
    ),
	'optimistic_locking'=>true,
		'unified_search'=>true,
	);
if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AOW_Actions','AOW_Action', array('basic'));
