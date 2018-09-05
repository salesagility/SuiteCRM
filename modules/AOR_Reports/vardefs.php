<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

$dictionary['AOR_Report'] = array(
    'table'=>'aor_reports',
    'audited'=>true,
    'duplicate_merge'=>true,
    'fields'=>array(
      'report_module' =>
      array(
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

    'graphs_per_row' =>
    array(
        'required' => true,
        'name' => 'graphs_per_row',
        'vname' => 'LBL_GRAPHS_PER_ROW',
        'type' => 'int',
        'massupdate' => 0,
        'default' => 2,
        'no_default' => false,
    ),

    'field_lines' =>
    array(
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
        array(
            'name' => 'display_field_lines',
            'returns' => 'html',
            'include' => 'modules/AOR_Fields/fieldLines.php'
        ),
    ),
    'condition_lines' =>
    array(
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
        array(
            'name' => 'display_condition_lines',
            'returns' => 'html',
            'include' => 'modules/AOR_Conditions/conditionLines.php'
        ),
    ),
  'aor_fields' =>
  array(
    'name' => 'aor_fields',
    'type' => 'link',
    'relationship' => 'aor_reports_aor_fields',
    'module'=>'AOR_Fields',
    'bean_name'=>'AOR_Field',
    'source'=>'non-db',
    'id_name' => 'aor_report_id',
  ),
  'aor_conditions' =>
  array(
     'name' => 'aor_conditions',
     'type' => 'link',
     'relationship' => 'aor_reports_aor_conditions',
     'module'=>'AOR_Conditions',
     'bean_name'=>'AOR_Condition',
     'source'=>'non-db',
  ),
  'aor_charts' =>
      array(
        'name' => 'aor_charts',
        'type' => 'link',
        'relationship' => 'aor_charts_aor_reports',
        'source' => 'non-db',
        'id_name' => 'aor_report_id',
        'vname' => 'LBL_AOR_CHARTS',
      ),
  'aor_scheduled_reports' =>
    array(
        'name' => 'aor_scheduled_reports',
        'type' => 'link',
        'relationship' => 'aor_scheduled_reports_aor_reports',
        'module'=>'AOR_Scheduled_Reports',
        'bean_name'=>'AOR_Scheduled_Reports',
        'source'=>'non-db',
    ),

),
'relationships'=>array(
    'aor_reports_aor_fields' =>
    array(
        'lhs_module'=> 'AOR_Reports',
        'lhs_table'=> 'aor_reports',
        'lhs_key' => 'id',
        'rhs_module'=> 'AOR_Fields',
        'rhs_table'=> 'aor_fields',
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
    "aor_scheduled_reports_aor_reports" => array(
        'lhs_module'=> 'AOR_Reports',
        'lhs_table'=> 'aor_reports',
        'lhs_key' => 'id',
        'rhs_module'=> 'AOR_Scheduled_Reports',
        'rhs_table'=> 'aor_scheduled_reports',
        'rhs_key' => 'aor_report_id',
        'relationship_type'=>'one-to-many',
    ),
),
    'optimistic_locking'=>true,
    'unified_search'=>true,
);

if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('AOR_Reports', 'AOR_Report', array('basic','assignable','security_groups'));
