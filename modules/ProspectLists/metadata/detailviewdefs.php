<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

// STIC-Custom - MHP - 20240201 - Override the core metadata files with the custom metadata files 
// https://github.com/SinergiaTIC/SinergiaCRM/pull/105 
// $viewdefs['ProspectLists']['DetailView'] = array(
// 'templateMeta' => array('form' => array('closeFormBeforeCustomButtons' => true,'buttons'=>array('EDIT', 'DUPLICATE', 'DELETE',
// array('customCode'=> '<input title="{$APP.LBL_EXPORT}"  class="button" type="button" name="opp_to_quote_button" id="export_button" value="{$APP.LBL_EXPORT}" onclick="document.location.href = \'index.php?entryPoint=export&module=ProspectLists&uid={$fields.id.value}&members=1\'">'),)),
                
//                         'maxColumns' => '2',
//                         'widths' => array(
//                                         array('label' => '10', 'field' => '30'),
//                                         array('label' => '10', 'field' => '30')
//                                         ),
//                         ),
// 'panels' => array(
//    'default' => array(
//       array(
//           'name',
//           array('name'=>'entry_count','label'=>'LBL_ENTRIES'),
//       ),
//       array(
//           'list_type',
//           'domain_name',
//       ),
//       array(
//           'description',
//       ),
//     ),
//     'LBL_PANEL_ASSIGNMENT' => array(
//         array(
//           'assigned_user_name',
//           array(
//               'name' => 'date_modified',
//               'label' => 'LBL_DATE_MODIFIED',
//               'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
//           ),
//         ),
//         array(
//             array(
//               'name' => 'date_entered',
//               'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
//             ),
//         ),
//     )
// )


// );

$viewdefs['ProspectLists']['DetailView'] = array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'closeFormBeforeCustomButtons' => true,
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 
          array (
            'customCode' => '<input title="{$APP.LBL_EXPORT}"  class="button" type="button" name="opp_to_quote_button" id="export_button" value="{$APP.LBL_EXPORT}" onclick="document.location.href = \'index.php?entryPoint=export&module=ProspectLists&uid={$fields.id.value}&members=1\'">',
          ),
        ),
      ),
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
        'LBL_OVERVIEW_PANEL' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_STIC_PANEL_RECORD_DETAILS' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_overview_panel' => 
      array (
        0 => 
        array (
          0 => 'name',
          1 => 'assigned_user_name',
        ),
        1 => 
        array (
          0 => 'list_type',
          1 => 'domain_name',
        ),
        2 => 
        array (
          0 => 'description',
        ),
      ),
      'lbl_stic_panel_record_details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'date_entered',
            'label' => 'LBL_CREATED',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'date_modified',
            'label' => 'LBL_MODIFIED_NAME',
          ),
        ),
      ),
    ),
);
// END STIC-Custom