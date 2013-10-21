<?php
/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
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

$dictionary['AOR_Report'] = array(
	'table'=>'aor_reports',
	'audited'=>true,
	'duplicate_merge'=>true,
	'fields'=>array (
	  'report_module' => 
	  array (
		'required' => true,
		'name' => 'report_module',
		'vname' => 'LBL_REPORT_MODULE',
		'type' => 'enum',
		'massupdate' => 0,
		'default' => '',
		'no_default' => false,
		'comments' => '',
		'help' => '',
		'importable' => 'true',
		'duplicate_merge' => 'disabled',
		'duplicate_merge_dom_value' => '0',
		'audited' => true,
		'reportable' => true,
		'unified_search' => false,
		'merge_filter' => 'disabled',
		'len' => 100,
		'size' => '20',
		'options' => 'aor_moduleList',
		'studio' => 'visible',
		'dependency' => false,
	  ),
    'field_lines' =>
    array (
        'required' => false,
        'name' => 'field_lines',
        'vname' => 'LBL_FIELD_LINES',
        'type' => 'function',
        'source' => 'non-db',
        'massupdate' => 0,
        'importable' => 'false',
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => 0,
        'audited' => false,
        'reportable' => false,
        'function' =>
        array (
            'name' => 'display_field_lines',
            'returns' => 'html',
            'include' => 'modules/AOR_Fields/fieldLines.php'
        ),
    ),
    'condition_lines' =>
    array (
        'required' => false,
        'name' => 'condition_lines',
        'vname' => 'LBL_CONDITION_LINES',
        'type' => 'function',
        'source' => 'non-db',
        'massupdate' => 0,
        'importable' => 'false',
        'duplicate_merge' => 'disabled',
        'duplicate_merge_dom_value' => 0,
        'audited' => false,
        'reportable' => false,
        'function' =>
        array (
            'name' => 'display_condition_lines',
            'returns' => 'html',
            'include' => 'modules/AOR_Conditions/conditionLines.php'
        ),
    ),
  'aor_fields' =>
  array (
    'name' => 'aor_fields',
    'type' => 'link',
    'relationship' => 'aor_reports_aor_fields',
    'module'=>'AOR_Fields',
    'bean_name'=>'AOR_Field',
    'source'=>'non-db',
  ),
  'aor_conditions' =>
  array (
     'name' => 'aor_conditions',
     'type' => 'link',
     'relationship' => 'aor_reports_aor_conditions',
     'module'=>'AOR_Conditions',
     'bean_name'=>'AOR_Condition',
     'source'=>'non-db',
  ),
),
'relationships'=>array (
    'aor_reports_aor_fields' =>
    array(
        'lhs_module'=> 'AOR_Reports',
        'lhs_table'=> 'aor_reports',
        'lhs_key' => 'id',
        'rhs_module'=> 'AOR_Fields',
        'rhs_table'=> 'aor_field',
        'rhs_key' => 'aor_report_id',
        'relationship_type'=>'one-to-many',
    ),
    'aor_reports_aor_conditions' =>
    array(
        'lhs_module'=> 'AOR_Reports',
        'lhs_table'=> 'aor_reports',
        'lhs_key' => 'id',
        'rhs_module'=> 'AOR_Conditions',
        'rhs_table'=> 'aor_conditions',
        'rhs_key' => 'aor_report_id',
        'relationship_type'=>'one-to-many',
    ),
),
	'optimistic_locking'=>true,
	'unified_search'=>true,
);

if (!class_exists('VardefManager')){
        require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AOR_Reports','AOR_Report', array('basic','assignable'));

