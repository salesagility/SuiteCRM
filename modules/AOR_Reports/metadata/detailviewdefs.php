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

$viewdefs['AOR_Reports']['DetailView'] = array(
'templateMeta' => array(
    'form' => array(
        'buttons'=>array(
            array(
                'customCode' => '{if $bean->aclAccess("edit","not_set","not_set",$bean->report_module)}
                <input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" 
                onclick="var _form = document.getElementById(\'formDetailView\'); _form.return_module.value=\'AOR_Reports\'; 
                _form.return_action.value=\'DetailView\'; _form.return_id.value=\'{$id}\'; _form.action.value=\'EditView\';
                SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">
                {/if}'
            ),
            array(
                'customCode' => '{if $bean->aclAccess("edit","not_set","not_set",$bean->report_module)}
                <input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" 
                onclick="var _form = document.getElementById(\'formDetailView\'); _form.return_module.value=\'AOR_Reports\'; 
                _form.return_action.value=\'DetailView\'; _form.isDuplicate.value=true; _form.action.value=\'EditView\'; 
                _form.return_id.value=\'{$id}\';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" 
                value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">
                {/if}'
            ),
            array(
                'customCode' => '{if $bean->aclAccess("delete","not_set","not_set",$bean->report_module)}
                <input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" 
                onclick="var _form = document.getElementById(\'formDetailView\'); _form.return_module.value=\'AOR_Reports\'; 
                _form.return_action.value=\'ListView\'; _form.action.value=\'Delete\'; if(confirm(\'{$APP.NTC_DELETE_CONFIRMATION}\')) 
                SUGAR.ajaxUI.submitForm(_form);" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">
                {/if}',
            ),
            array (
                'customCode' => '<input type="button" class="button" id="download_csv_button_old" value="{$MOD.LBL_EXPORT}">',
            ),
            array (
                'customCode' => '<input type="button" class="button" id="download_pdf_button_old" value="{$MOD.LBL_DOWNLOAD_PDF}">',
            ),
            array (
                'customCode' => '<input type="button" class="button" onClick="openProspectPopup();" value="{$MOD.LBL_ADD_TO_PROSPECT_LIST}">',
            ),
        ),
        'footerTpl' => 'modules/AOR_Reports/tpls/report.tpl',
    ),
    'maxColumns' => '2',
    'widths' => array(
                    array('label' => '10', 'field' => '30'),
                    array('label' => '10', 'field' => '30')
                    ),
    'includes'=> array(
        array('file'=>'modules/AOR_Reports/AOR_Report.js'),
    ),
    'tabDefs' =>
        array (
            'DEFAULT' =>
                array (
                    'newTab' => false,
                    'panelDefault' => 'collapsed',
                ),
        ),
),

'panels' =>array (
    'default' =>
    array (
  array (
    'name',
    'assigned_user_name',
  ),

  array (
	array (
      'name' => 'date_entered',
      'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
      'label' => 'LBL_DATE_ENTERED',
    ),
    array (
      'name' => 'date_modified',
      'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
      'label' => 'LBL_DATE_MODIFIED',
    ),
  ),

  array (
    'description',
  ),
    ),
)
);
?>
