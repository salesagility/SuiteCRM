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
// $viewdefs['Notes']['EditView'] = array(
//     'templateMeta' => array('form' => array('enctype'=> 'multipart/form-data',
//                                             ),
//                             'maxColumns' => '2',
//                             'widths' => array(
//                                             array('label' => '10', 'field' => '30'),
//                                             array('label' => '10', 'field' => '30')
//                                             ),
// 'javascript' => '{sugar_getscript file="include/javascript/dashlets.js"}
// <script>
// function deleteAttachmentCallBack(text)
// 	{literal} { {/literal}
// 	if(text == \'true\') {literal} { {/literal}
// 		document.getElementById(\'new_attachment\').style.display = \'\';
// 		ajaxStatus.hideStatus();
// 		document.getElementById(\'old_attachment\').innerHTML = \'\';
// 	{literal} } {/literal} else {literal} { {/literal}
// 		document.getElementById(\'new_attachment\').style.display = \'none\';
// 		ajaxStatus.flashStatus(SUGAR.language.get(\'Notes\', \'ERR_REMOVING_ATTACHMENT\'), 2000);
// 	{literal} } {/literal}
// {literal} } {/literal}
// </script>
// <script>toggle_portal_flag(); function toggle_portal_flag()  {literal} { {/literal} {$TOGGLE_JS} {literal} } {/literal} </script>',
// ),
//     'panels' =>array(
//         'lbl_note_information' => array(
//                     array('contact_name','parent_name'),
//                     array(
//                         array('name'=>'name', 'displayParams'=>array('size'=>60)),''
//                     ),

//                     array(
//                         'filename',

//                     ),
//                     array(
//                         array('name' => 'description', 'label' => 'LBL_NOTE_STATUS'),
//                     ),

//         ),


//       'LBL_PANEL_ASSIGNMENT' => array(
//         array(
//             array('name' => 'assigned_user_name','label' => 'LBL_ASSIGNED_TO'),
//         ),
//       ),
//     )
// );

$viewdefs ['Notes'] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'enctype' => 'multipart/form-data',
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
      'javascript' => '{sugar_getscript file="include/javascript/dashlets.js"}
<script>
function deleteAttachmentCallBack(text)
	{literal} { {/literal}
	if(text == \'true\') {literal} { {/literal}
		document.getElementById(\'new_attachment\').style.display = \'\';
		ajaxStatus.hideStatus();
		document.getElementById(\'old_attachment\').innerHTML = \'\';
	{literal} } {/literal} else {literal} { {/literal}
		document.getElementById(\'new_attachment\').style.display = \'none\';
		ajaxStatus.flashStatus(SUGAR.language.get(\'Notes\', \'ERR_REMOVING_ATTACHMENT\'), 2000);
	{literal} } {/literal}
{literal} } {/literal}
</script>
<script>toggle_portal_flag(); function toggle_portal_flag()  {literal} { {/literal} {$TOGGLE_JS} {literal} } {/literal} </script>',
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_NOTE_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'lbl_note_information' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'displayParams' => 
            array (
              'size' => 60,
            ),
          ),
          1 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
        1 => 
        array (
          0 => 'parent_name',
          1 => 'contact_name',
        ),
        2 => 
        array (
          0 => 'filename',
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_NOTE_STATUS',
          ),
        ),
      ),
    ),
  ),
);
// END STIC-Custom