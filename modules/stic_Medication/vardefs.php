<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

$dictionary['stic_Medication'] = array(
  'table' => 'stic_medication',
  'audited' => true,
  'inline_edit' => true,
  'duplicate_merge' => true,
  'fields' => array(
    'active_principle' =>
    array(
      'required' => false,
      'name' => 'active_principle',
      'vname' => 'LBL_ACTIVE_PRINCIPLE',
      'type' => 'varchar',
      'massupdate' => 1,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'inline_edit' => true,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => '255',
      'size' => '20',
    ),
    'presentation' =>
    array(
      'required' => false,
      'name' => 'presentation',
      'vname' => 'LBL_PRESENTATION',
      'type' => 'varchar',
      'massupdate' => 1,
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'inline_edit' => true,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => '255',
      'size' => '20',
    ),
    'active' =>
    array(
      'required' => false,
      'name' => 'active',
      'vname' => 'LBL_ACTIVE',
      'type' => 'bool',
      'massupdate' => 1,
      'default' => '1',
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'inline_edit' => true,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => '255',
      'size' => '20',
    ),
    'stock_depletion' =>
    array(
      'required' => false,
      'name' => 'stock_depletion',
      'vname' => 'LBL_STOCK_DEPLETION',
      'type' => 'bool',
      'massupdate' => 1,
      'default' => '0',
      'no_default' => false,
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'inline_edit' => true,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => '255',
      'size' => '20',
    ),
    'stic_prescription_stic_medication' =>
    array(
      'name' => 'stic_prescription_stic_medication',
      'type' => 'link',
      'relationship' => 'stic_prescription_stic_medication',
      'source' => 'non-db',
      'module' => 'stic_Prescription',
      'bean_name' => false,
      'side' => 'right',
      'vname' => 'LBL_STIC_PRESCRIPTION_STIC_MEDICATION_FROM_STIC_PRESCRIPTION_TITLE',
    )
  ),
  'relationships' => array(),
  'optimistic_locking' => true,
  'unified_search' => true,
  'unified_search_default_enabled' => false,
);
if (!class_exists('VardefManager')) {
  require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('stic_Medication', 'stic_Medication', array('basic', 'assignable', 'security_groups'));

$dictionary['stic_Medication']['fields']['description']['rows'] = '2'; // Make textarea fields shorter