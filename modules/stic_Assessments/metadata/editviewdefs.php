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
$module_name = 'stic_Assessments';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_DEFAULT_PANEL' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => false,
    ),
    'panels' => 
    array (
      'lbl_default_panel' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'assigned_user_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'stic_assessments_contacts_name',
            'label' => 'LBL_STIC_ASSESSMENTS_CONTACTS_FROM_CONTACTS_TITLE',
          ),
          1 => 
          array (
            'name' => 'working_with',
            'studio' => 'visible',
            'label' => 'LBL_WORKING_WITH',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'derivation',
            'studio' => 'visible',
            'label' => 'LBL_DERIVATION',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'assessment_date',
            'label' => 'LBL_ASSESSMENT_DATE',
          ),
          1 => 
          array (
            'name' => 'next_date',
            'label' => 'LBL_NEXT_DATE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'scope',
            'studio' => 'visible',
            'label' => 'LBL_SCOPE',
          ),
          1 => 
          array (
            'name' => 'moment',
            'studio' => 'visible',
            'label' => 'LBL_MOMENT',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'areas',
            'studio' => 'visible',
            'label' => 'LBL_AREAS',
          ),
          1 => 
          array (
            'name' => 'recommendations',
            'studio' => 'visible',
            'label' => 'LBL_RECOMMENDATIONS',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'conclusions',
            'studio' => 'visible',
            'label' => 'LBL_CONCLUSIONS',
          ),
          1 => 'description',
        ),
      ),
    ),
  ),
);
;
?>
