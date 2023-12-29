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
$module_name = 'AOS_PDF_Templates';
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
          'field' => '60',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'include/javascript/tiny_mce/tiny_mce.js',
        ),
        1 => 
        array (
          'file' => 'modules/AOS_PDF_Templates/AOS_PDF_Templates.js',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => 'assigned_user_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'label' => 'LBL_TYPE',
            'displayParams' => 
            array (
              'field' => 
              array (
                'onchange' => 'populateModuleVariables(this.options[this.selectedIndex].value)',
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'active',
            'studio' => 'visible',
            'label' => 'LBL_ACTIVE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'page_size',
            'label' => 'LBL_PAGE_SIZE',
          ),
          1 => 
          array (
            'name' => 'orientation',
            'label' => 'LBL_ORIENTATION',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'insert_fields',
            'label' => 'LBL_INSERT_FIELDS',
            'customCode' => '{$INSERT_FIELDS}',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'pdfheader',
            'label' => 'LBL_HEADER',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'pdffooter',
            'label' => 'LBL_FOOTER',
          ),
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'margin_left',
            'label' => 'LBL_MARGIN_LEFT',
          ),
          1 => 
          array (
            'name' => 'margin_right',
            'label' => 'LBL_MARGIN_RIGHT',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'margin_top',
            'label' => 'LBL_MARGIN_TOP',
          ),
          1 => 
          array (
            'name' => 'margin_bottom',
            'label' => 'LBL_MARGIN_BOTTOM',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'margin_header',
            'label' => 'LBL_MARGIN_HEADER',
          ),
          1 => 
          array (
            'name' => 'margin_footer',
            'label' => 'LBL_MARGIN_FOOTER',
          ),
        ),
      ),
    ),
  ),
);
;
?>
