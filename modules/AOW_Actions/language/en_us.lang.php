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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Date Created',
    'LBL_DATE_MODIFIED' => 'Date Modified',
    'LBL_MODIFIED' => 'Modified By',
    'LBL_MODIFIED_ID' => 'Modified By Id',
    'LBL_MODIFIED_NAME' => 'Modified By Name',
    'LBL_CREATED_USER' => 'Created by User',
    'LBL_MODIFIED_USER' => 'Modified by User',
    'LBL_CREATED' => 'Created By',
    'LBL_DESCRIPTION' => 'Description',
    'LBL_CREATED_ID' => 'Created By Id',
    'LBL_DELETED' => 'Deleted',
    'LBL_NAME' => 'Name',
    'LBL_MODULE_NAME' => 'WorkFlow Actions',
    'LBL_MODULE_TITLE' => 'WorkFlow Actions',
    'LBL_AOW_WORKFLOW_ID' => 'AOW_WorkFlow Id',
    'LBL_ACTION' => 'Action',
    'LBL_PARAMETERS' => 'Parameters',
    'LBL_SELECT_ACTION' => 'Select Action',
    'LBL_CREATE_EMAIL_TEMPLATE' => 'Create',
    'LBL_RECORD_TYPE' => 'Record Type',
    'LBL_SENDEMAIL' => 'Send Email',
    'LBL_CREATERECORD' => 'Create Record',
    'LBL_MODIFYRECORD' => 'Modify Record',
    'LBL_ADD_FIELD' => 'Add Field',
    'LBL_ADD_RELATIONSHIP' => 'Add Relationship',
    'LBL_EDIT_EMAIL_TEMPLATE' => 'Edit',
    'LBL_EMAIL' => 'Email',
    'LBL_EMAIL_TEMPLATE' => 'Email Template',
    'LBL_SETAPPROVAL' => 'Set Approval',
    'LBL_RELATE_WORKFLOW' => 'Relate to WorkFlow Module',
    'LBL_INDIVIDUAL_EMAILS' => 'Send Individual Emails',
    'LBL_COMPUTEFIELD' => 'Calculate Fields',
    'LBL_COMPUTEFIELD_PARAMETERS' => 'Parameters',
    'LBL_COMPUTEFIELD_FIELD_NAME' => 'Field name',
    'LBL_COMPUTEFIELD_IDENTIFIER' => 'Identifier',
    'LBL_COMPUTEFIELD_ADD_PARAMETER' => 'Add parameter',
    'LBL_COMPUTEFIELD_RELATION_PARAMETERS' => 'Relation parameters',
    'LBL_COMPUTEFIELD_RELATION' => 'Relation',
    'LBL_COMPUTEFIELD_ADD_RELATION_PARAMETER' => 'Add relation parameter',
    'LBL_COMPUTEFIELD_FORMULA' => 'Formula',
    'LBL_COMPUTEFIELD_FORMULAS' => 'Formulas',
    'LBL_COMPUTEFIELD_ADD_FORMULA' => 'Add formula',
    'LBL_COMPUTEFIELD_VALUE_TYPE' => 'Value type',
    'LBL_COMPUTEFIELD_RAW_VALUE' => 'Raw value',
    'LBL_COMPUTEFIELD_FORMATTED_VALUE' => 'Formatted value'
);
