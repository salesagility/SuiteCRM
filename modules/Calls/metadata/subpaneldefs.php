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


$layout_defs['Calls'] = array(
    // sets up which panels to show, in which order, and with what linked_fields
    'subpanel_setup' => array(
        'contacts' => array(
            'top_buttons' => array(),
            'order' => 10,
            'module' => 'Contacts',
            'sort_order' => 'asc',
            'sort_by' => 'last_name, first_name',
            'subpanel_name' => 'ForCalls',
            'get_subpanel_data' => 'contacts',
            'title_key' => 'LBL_CONTACTS_SUBPANEL_TITLE',
        ),
        'users' => array(
            'top_buttons' => array(),
            'order' => 20,
            'module' => 'Users',
            'sort_order' => 'asc',
            'sort_by' => 'full_name',
            'subpanel_name' => 'ForCalls',
            'get_subpanel_data' => 'users',
            'title_key' => 'LBL_USERS_SUBPANEL_TITLE',
        ),
        'leads' => array(
            'order' => 30,
            'module' => 'Leads',
            'sort_order' => 'asc',
            'sort_by' => 'last_name, first_name',
            'subpanel_name' => 'ForCalls',
            'get_subpanel_data' => 'leads',
            'title_key' => 'LBL_LEADS_SUBPANEL_TITLE',
            'top_buttons' => array(),
        ),
        'history' => array(
            'order' => 40,
            'title_key' => 'LBL_HISTORY_SUBPANEL_TITLE',
            'type' => 'collection',
            'subpanel_name' => 'history',   //this values is not associated with a physical file.
            'sort_order' => 'desc',
            'sort_by' => 'date_entered',
            'header_definition_from_subpanel' => 'calls',
            'module' => 'History',
            'top_buttons' => array(
                array('widget_class' => 'SubPanelTopCreateNoteButton'),
            ),
            'collection_list' => array(
                'notes' => array(
                    'module' => 'Notes',
                    'subpanel_name' => 'ForCalls',
                    'get_subpanel_data' => 'notes',
                ),
            ),
        ), /* end history subpanel def */
        'securitygroups' => array(
            'top_buttons' => array(array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'SecurityGroups', 'mode' => 'MultiSelect'),),
            'order' => 900,
            'sort_by' => 'name',
            'sort_order' => 'asc',
            'module' => 'SecurityGroups',
            'refresh_page' => 1,
            'subpanel_name' => 'default',
            'get_subpanel_data' => 'SecurityGroups',
            'add_subpanel_data' => 'securitygroup_id',
            'title_key' => 'LBL_SECURITYGROUPS_SUBPANEL_TITLE',
        ),
    ),
);
?>
