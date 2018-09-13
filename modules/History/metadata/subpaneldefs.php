<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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




$layout_defs['History'] = array(
    // default subpanel provided by this SugarBean
    'default_subpanel_define' => array(
        'subpanel_title' => 'LBL_DEFAULT_SUBPANEL_TITLE',
        'top_buttons' => array(
            array('widget_class' => 'SubPanelTopCreateNoteButton'),
            array('widget_class' => 'SubPanelTopArchiveEmailButton'),
            array('widget_class' => 'SubPanelTopSummaryButton'),
        ),
        
//TODO try and merge with the activities
        'list_fields' => array(
            'Meetings' => array(
                'columns' => array(
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Meetings',
                        'width' => '2%',
                    ),
                    array(
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ),
                    array(
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ),
                    array(
                        'name' => 'parent_name',
                        'module' => 'Meetings',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ),
                    array(
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Meetings',
                        'width' => '4%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'meetings',
                        'module' => 'Meetings',
                        'width' => '4%',
                    ),
                ),
                'where' => "(meetings.status='Held' OR meetings.status='Not Held')",
                'order_by' => 'meetings.date_modified',
            ),
            'Emails' => array(
                'columns' => array(
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Emails',
                        'width' => '2%',
                    ),
                    array(
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ),
                    array(
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'category_id',
                        'vname' => 'LBL_LIST_CATEGORY',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ),
                    array(
                        'name' => 'parent_name',
                        'module' => 'Emails',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ),
                    array(
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Emails',
                        'width' => '4%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'emails',
                        'module' => 'Emails',
                        'width' => '4%',
                    ),
                ),
                'where' => "(emails.status='sent')",
                'order_by' => 'emails.date_modified',
            ),
            'Notes' => array(
                'columns' => array(
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Notes',
                        'width' => '2%',
                    ),
                    array(
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ),
                    array( // this column does not exist on
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ),
                    array(
                        'name' => 'parent_name',
                        'module' => 'Notes',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ),
                    array(
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Notes',
                        'width' => '4%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'notes',
                        'module' => 'Notes',
                        'width' => '4%',
                    ),
                ),
                'where' => '',
                'order_by' => 'notes.date_modified',
            ),
            'Tasks' => array(
                'columns' => array(
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Tasks',
                        'width' => '2%',
                    ),
                    array(
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ),
                    array(
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ),
                    array(
                        'name' => 'parent_name',
                        'module' => 'Tasks',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ),
                    array(
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Tasks',
                        'width' => '4%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'tasks',
                        'module' => 'Tasks',
                        'width' => '4%',
                    ),
                ),
                'where' => "(tasks.status='Completed' OR tasks.status='Deferred')",
                'order_by' => 'tasks.date_start',
            ),
            'Calls' => array(
                'columns' => array(
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Calls',
                        'width' => '2%',
                    ),
                    array(
                        'name' => 'name',
                        'vname' => 'LBL_LIST_SUBJECT',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'width' => '28%',
                    ),
                    array(
                        'name' => 'status',
                        'vname' => 'LBL_LIST_STATUS',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'contact_name',
                        'module' => 'Contacts',
                        'widget_class' => 'SubPanelDetailViewLink',
                        'target_record_key' => 'contact_id',
                        'target_module' => 'Contacts',
                        'vname' => 'LBL_LIST_CONTACT',
                        'width' => '20%',
                    ),
                    array(
                        'name' => 'parent_name',
                        'module' => 'Meetings',
                        'vname' => 'LBL_LIST_RELATED_TO',
                        'width' => '22%',
                    ),
                    array(
                        'name' => 'date_modified',
                        //'db_alias_to' => 'the_date',
                        'vname' => 'LBL_LIST_LAST_MODIFIED',
                        'width' => '10%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelEditButton',
                        'module' => 'Calls',
                        'width' => '4%',
                    ),
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelRemoveButton',
                        'linked_field' => 'calls',
                        'module' => 'Calls',
                        'width' => '4%',
                    ),
                ),
                'where' => "(calls.status='Held' OR calls.status='Not Held')",
                'order_by' => 'calls.date_modified',
            ),
        ),
    ),
);
