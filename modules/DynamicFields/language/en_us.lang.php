<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


$mod_strings = array (
    'LNK_NEW_CALL' => 'Log Call',
    'LNK_NEW_MEETING' => 'Schedule Meeting',
    'LNK_NEW_TASK' => 'Create Task',
    'LNK_NEW_NOTE' => 'Create Note or Attachment',
    'LNK_NEW_EMAIL' => 'Archive Email',
    'LNK_CALL_LIST' => 'Calls',
    'LNK_MEETING_LIST' => 'Meetings',
    'LNK_TASK_LIST' => 'Tasks',
    'LNK_NOTE_LIST' => 'Notes',
    'LNK_EMAIL_LIST' => 'Emails',
    'LBL_ADD_FIELD'=> 'Add Field:',
	'LBL_MODULE_SELECT' => 'Module to Edit',
	'LBL_SEARCH_FORM_TITLE' => 'Module Search',
	'COLUMN_TITLE_NAME' => 'Field Name',
    'COLUMN_TITLE_DISPLAY_LABEL' => 'Display Label',
    'COLUMN_TITLE_LABEL_VALUE' => 'Label Value',
	'COLUMN_TITLE_LABEL' => 'System Label',
	'COLUMN_TITLE_DATA_TYPE' => 'Data Type',
	'COLUMN_TITLE_MAX_SIZE' => 'Max Size',
	'COLUMN_TITLE_HELP_TEXT' => 'Help Text',
    'COLUMN_TITLE_COMMENT_TEXT' => 'Comment Text',
	'COLUMN_TITLE_REQUIRED_OPTION' => 'Required Field',
	'COLUMN_TITLE_DEFAULT_VALUE' => 'Default Value',
	'COLUMN_TITLE_DEFAULT_EMAIL' => 'Default Value',
	'COLUMN_TITLE_EXT1' => 'Extra Meta Field 1',
	'COLUMN_TITLE_EXT2' => 'Extra Meta Field 2',
	'COLUMN_TITLE_EXT3' => 'Extra Meta Field 3',
	'COLUMN_TITLE_FRAME_HEIGHT' => 'IFrame Height',
	'COLUMN_TITLE_HTML_CONTENT' =>'HTML',
	'COLUMN_TITLE_URL'=>'Default URL',
	'COLUMN_TITLE_AUDIT' =>'Audit',
        'COLUMN_TITLE_FTS' =>'Full Text Searchable',
	'COLUMN_TITLE_REPORTABLE' => 'Reportable',
	'COLUMN_TITLE_MIN_VALUE' => 'Min Value',
	'COLUMN_TITLE_MAX_VALUE' => 'Max Value',
	'COLUMN_TITLE_LABEL_ROWS' => 'Rows',
	'COLUMN_TITLE_LABEL_COLS' => 'Columns',
	'COLUMN_TITLE_DISPLAYED_ITEM_COUNT'=>'# Items displayed',
	'COLUMN_TITLE_AUTOINC_NEXT' => 'Auto Increment Next Value',
    'COLUMN_DISABLE_NUMBER_FORMAT' => 'Disable Format',
    'COLUMN_TITLE_ENABLE_RANGE_SEARCH' => 'Enable Range Search',
    'COLUMN_TITLE_GLOBAL_SEARCH'=>'Global Search',	
	'LBL_DROP_DOWN_LIST' => 'Drop Down List',
	'LBL_RADIO_FIELDS'=> 'Radio Fields',
	'LBL_MULTI_SELECT_LIST'=> 'Multi Select List',
	'COLUMN_TITLE_PRECISION'=> 'Precision',
	'MSG_DELETE_CONFIRM' => 'Are you sure you want to delete this item?',
	'POPUP_INSERT_HEADER_TITLE' => 'Add Custom Field',
	'POPUP_EDIT_HEADER_TITLE' => 'Edit Custom Field',
	'LNK_SELECT_CUSTOM_FIELD' => 'Select Custom Field',
	'LNK_REPAIR_CUSTOM_FIELD' => 'Repair Custom Fields',
	'LBL_MODULE' => 'Module',
	'COLUMN_TITLE_MASS_UPDATE'=>'Mass Update',
    'COLUMN_TITLE_IMPORTABLE'=>'Importable',
    'COLUMN_TITLE_DUPLICATE_MERGE'=>'Duplicate Merge',
    'LBL_LABEL'=>'Label',
    'LBL_DATA_TYPE'=>'Data Type',
    'LBL_DEFAULT_VALUE'=>'Default Value',
    'LBL_AUDITED'=>'Audited',
    'LBL_REPORTABLE'=>'Reportable',
    'ERR_RESERVED_FIELD_NAME' => "Reserved Keyword",
	'ERR_SELECT_FIELD_TYPE' => 'Please Select a Field Type',
	'ERR_FIELD_NAME_ALREADY_EXISTS' => 'Field Name already exists',
    'LBL_BTN_ADD' => 'Add',
    'LBL_BTN_EDIT' => 'Edit',
    'LBL_GENERATE_URL' => 'Generate URL',
	'LBL_DEPENDENT_CHECKBOX'=>'Dependent',
	'LBL_DEPENDENT_TRIGGER'=>'Trigger',
    'LBL_CALCULATED'=>'Calculated Value',
    'LBL_FORMULA'=>'Formula',
    'LBL_DYNAMIC_VALUES_CHECKBOX' => 'Dependent',
    'LBL_BTN_EDIT_VISIBILITY'=>'Edit Visibility',
    'LBL_LINK_TARGET'=>'Open Link In',
    'LBL_IMAGE_WIDTH' => 'Width',
    'LBL_IMAGE_HEIGHT' => 'Height',
    'LBL_IMAGE_BORDER' => 'Border',
	'COLUMN_TITLE_VALIDATE_US_FORMAT' => 'U.S. Format',
	'LBL_DEPENDENT'=>'Dependent',
	'LBL_VISIBLE_IF'=>'Visible If',
	'LBL_ENFORCED'=>'Enforced',
	'LBL_HELP' => 'Help' /*for 508 compliance fix*/,
	'COLUMN_TITLE_GLOBAL_SEARCH'=>'Global Search',
);


?>
