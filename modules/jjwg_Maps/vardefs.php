<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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

$dictionary['jjwg_Maps'] = array(
    'table' => 'jjwg_maps',
    'audited' => true,
    'fields' => array(
        'distance' =>
            array(
                'required' => true,
                'name' => 'distance',
                'vname' => 'LBL_DISTANCE',
                'type' => 'float',
                'massupdate' => 0,
                'comments' => '',
                'help' => 'Distance',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => true,
                'reportable' => true,
                'len' => '9',
                'size' => '20',
                'precision' => '4',
            ),
        'unit_type' =>
            array(
                'required' => true,
                'name' => 'unit_type',
                'vname' => 'LBL_UNIT_TYPE',
                'type' => 'enum',
                'massupdate' => 0,
                'default' => 'mi',
                'comments' => '',
                'help' => 'Unit Type (mi/km)',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => true,
                'reportable' => true,
                'len' => 100,
                'size' => '20',
                'options' => 'map_unit_type_list',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'module_type' =>
            array(
                'required' => true,
                'name' => 'module_type',
                'vname' => 'LBL_MODULE_TYPE',
                'type' => 'enum',
                'massupdate' => 0,
                'default' => 'Accounts',
                'comments' => '',
                'help' => 'Module Type to Display',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => true,
                'reportable' => true,
                'len' => 100,
                'size' => '20',
                'options' => 'map_module_type_list',
                'studio' => 'visible',
                'dependency' => false,
            ),
        'parent_name' =>
            array(
                'required' => true,
                'source' => 'non-db',
                'name' => 'parent_name',
                'vname' => 'LBL_FLEX_RELATE',
                'type' => 'parent',
                'massupdate' => 0,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => '0',
                'audited' => true,
                'reportable' => true,
                'len' => 25,
                'size' => '20',
                'options' => 'map_relate_type_list',
                'studio' => 'visible',
                'type_name' => 'parent_type',
                'id_name' => 'parent_id',
                'parent_type' => 'record_type_display',
            ),
        'parent_type' =>
            array(
                'required' => false,
                'name' => 'parent_type',
                'vname' => 'LBL_PARENT_TYPE',
                'type' => 'parent_type',
                'massupdate' => 0,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => 0,
                'audited' => false,
                'reportable' => true,
                'len' => 255,
                'size' => '20',
                'dbType' => 'varchar',
                'studio' => 'hidden',
            ),
        'parent_id' =>
            array(
                'required' => false,
                'name' => 'parent_id',
                'vname' => 'LBL_PARENT_ID',
                'type' => 'id',
                'massupdate' => 0,
                'comments' => '',
                'help' => '',
                'importable' => 'true',
                'duplicate_merge' => 'disabled',
                'duplicate_merge_dom_value' => 0,
                'audited' => false,
                'reportable' => true,
                'len' => 36,
                'size' => '20',
            ),
        'accounts' =>
            array(
                'name' => 'accounts',
                'type' => 'link',
                'relationship' => 'jjwg_Maps_accounts',
                'module' => 'Accounts',
                'bean_name' => 'Account',
                'source' => 'non-db',
                'vname' => 'LBL_ACCOUNTS',
            ),
        'contacts' =>
            array(
                'name' => 'contacts',
                'type' => 'link',
                'relationship' => 'jjwg_Maps_contacts',
                'module' => 'Contacts',
                'bean_name' => 'Contact',
                'source' => 'non-db',
                'vname' => 'LBL_CONTACTS',
            ),
        'leads' =>
            array(
                'name' => 'leads',
                'type' => 'link',
                'relationship' => 'jjwg_Maps_leads',
                'module' => 'Leads',
                'bean_name' => 'Lead',
                'source' => 'non-db',
                'vname' => 'LBL_LEADS',
            ),
        'opportunities' =>
            array(
                'name' => 'opportunities',
                'type' => 'link',
                'relationship' => 'jjwg_Maps_opportunities',
                'module' => 'Leads',
                'bean_name' => 'Opportunity',
                'source' => 'non-db',
                'vname' => 'LBL_OPPORTUNITIES',
            ),
        'cases' =>
            array(
                'name' => 'cases',
                'type' => 'link',
                'relationship' => 'jjwg_Maps_cases',
                'module' => 'Cases',
                'bean_name' => 'Case',
                'source' => 'non-db',
                'vname' => 'LBL_CASES',
            ),
        'projects' =>
            array(
                'name' => 'projects',
                'type' => 'link',
                'relationship' => 'jjwg_Maps_projects',
                'module' => 'Project',
                'bean_name' => 'Project',
                'source' => 'non-db',
                'vname' => 'LBL_PROJECTS',
            ),
        'meetings' =>
            array(
                'name' => 'meetings',
                'type' => 'link',
                'relationship' => 'jjwg_Maps_meetings',
                'module' => 'Meetings',
                'bean_name' => 'Meeting',
                'source' => 'non-db',
                'vname' => 'LBL_MEETINGS',
            ),
        'prospects' =>
            array(
                'name' => 'prospects',
                'type' => 'link',
                'relationship' => 'jjwg_Maps_prospects',
                'module' => 'Prospects',
                'bean_name' => 'Prospect',
                'source' => 'non-db',
                'vname' => 'LBL_PROSPECTS',
            ),
        'jjwp_partners' =>
            array(
                'name' => 'jjwp_partners',
                'type' => 'link',
                'relationship' => 'jjwg_Maps_jjwp_partners',
                'module' => 'jjwp_Partners',
                'bean_name' => 'jjwp_Partners',
                'source' => 'non-db',
                'vname' => 'LBL_JJWP_PARTNERS',
            ),
        'jjwg_maps_jjwg_areas' =>
            array(
                'name' => 'jjwg_maps_jjwg_areas',
                'type' => 'link',
                'relationship' => 'jjwg_maps_jjwg_areas',
                'source' => 'non-db',
                'vname' => 'LBL_JJWG_MAPS_JJWG_AREAS_FROM_JJWG_AREAS_TITLE',
            ),
        'jjwg_maps_jjwg_markers' =>
            array(
                'name' => 'jjwg_maps_jjwg_markers',
                'type' => 'link',
                'relationship' => 'jjwg_maps_jjwg_markers',
                'source' => 'non-db',
                'vname' => 'LBL_JJWG_MAPS_JJWG_MARKERS_FROM_JJWG_MARKERS_TITLE',
            ),
    ),
    'relationships' => array(
        'jjwg_Maps_accounts' =>
            array(
                'lhs_module' => 'jjwg_Maps',
                'lhs_table' => 'jjwg_Maps',
                'lhs_key' => 'parent_id',
                'rhs_module' => 'Accounts',
                'rhs_table' => 'accounts',
                'rhs_key' => 'id',
                'relationship_type' => 'one-to-many',
                'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'Accounts',
            ),
        'jjwg_Maps_contacts' =>
            array(
                'lhs_module' => 'jjwg_Maps',
                'lhs_table' => 'jjwg_Maps',
                'lhs_key' => 'parent_id',
                'rhs_module' => 'Contacts',
                'rhs_table' => 'contacts',
                'rhs_key' => 'id',
                'relationship_type' => 'one-to-many',
                'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'Contacts',
            ),
        'jjwg_Maps_leads' =>
            array(
                'lhs_module' => 'jjwg_Maps',
                'lhs_table' => 'jjwg_Maps',
                'lhs_key' => 'parent_id',
                'rhs_module' => 'Leads',
                'rhs_table' => 'leads',
                'rhs_key' => 'id',
                'relationship_type' => 'one-to-many',
                'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'Leads',
            ),
        'jjwg_Maps_opportunities' =>
            array(
                'lhs_module' => 'jjwg_Maps',
                'lhs_table' => 'jjwg_Maps',
                'lhs_key' => 'parent_id',
                'rhs_module' => 'Opportunities',
                'rhs_table' => 'opportunities',
                'rhs_key' => 'id',
                'relationship_type' => 'one-to-many',
                'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'Opportunities',
            ),
        'jjwg_Maps_cases' =>
            array(
                'lhs_module' => 'jjwg_Maps',
                'lhs_table' => 'jjwg_Maps',
                'lhs_key' => 'parent_id',
                'rhs_module' => 'Cases',
                'rhs_table' => 'cases',
                'rhs_key' => 'id',
                'relationship_type' => 'one-to-many',
                'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'Cases',
            ),
        'jjwg_Maps_projects' =>
            array(
                'lhs_module' => 'jjwg_Maps',
                'lhs_table' => 'jjwg_Maps',
                'lhs_key' => 'parent_id',
                'rhs_module' => 'Project',
                'rhs_table' => 'project',
                'rhs_key' => 'id',
                'relationship_type' => 'one-to-many',
                'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'Project',
            ),
        'jjwg_Maps_meetings' =>
            array(
                'lhs_module' => 'jjwg_Maps',
                'lhs_table' => 'jjwg_Maps',
                'lhs_key' => 'parent_id',
                'rhs_module' => 'Meetings',
                'rhs_table' => 'meetings',
                'rhs_key' => 'id',
                'relationship_type' => 'one-to-many',
                'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'Meetings',
            ),
        'jjwg_Maps_prospects' =>
            array(
                'lhs_module' => 'jjwg_Maps',
                'lhs_table' => 'jjwg_Maps',
                'lhs_key' => 'parent_id',
                'rhs_module' => 'Prospects',
                'rhs_table' => 'prospects',
                'rhs_key' => 'id',
                'relationship_type' => 'one-to-many',
                'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'Prospects',
            ),
        'jjwg_Maps_jjwp_partners' =>
            array(
                'lhs_module' => 'jjwg_Maps',
                'lhs_table' => 'jjwg_Maps',
                'lhs_key' => 'parent_id',
                'rhs_module' => 'jjwp_Partners',
                'rhs_table' => 'jjwp_partners',
                'rhs_key' => 'id',
                'relationship_type' => 'one-to-many',
                'relationship_role_column' => 'parent_type',
                'relationship_role_column_value' => 'jjwp_Partners',
            ),
    ),
    'optimistic_locking' => true,
);

if (!class_exists('VardefManager')) {
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('jjwg_Maps', 'jjwg_Maps', array('basic', 'assignable', 'security_groups'));
