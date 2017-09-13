<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

$layout_defs['Delegates'] = array(
    // default subpanel provided by this SugarBean
    'default_subpanel_define' => array(
        'subpanel_title' => 'LBL_DEFAULT_SUBPANEL_TITLE',
        'top_buttons' => array(
            array('widget_class' => 'SubPanelTopArchiveEmailButton'),
            array('widget_class' => 'SubPanelTopSummaryButton'),
        ),

        'list_fields' => array(
            'Contacts' => array(
                'columns' => array(
                    'checkbox' =>
                        array(
                            'vname' => '<ul id="selectLinkTop" class="clickMenu selectmenu SugarActionMenu" name="">
					                    <li class="sugar_action_button">
					                      <input class="checkallContacts" class="checkbox massall" type="checkbox" name="checkallContacts" style="float: left;margin: 2px 0 0 2px;" onclick="">
					                      <ul class="cust_list" style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;box-shadow: 0 5px 10px #999999;float: left;left: 0;list-style: none outside none;margin: 0;overflow: hidden;padding: 8px 0;position: absolute;top: 18px;width: auto;z-index: 10;display: none;">
					                        <li style="clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;"><a class="button_select_this_page_top" style="border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;" href="#">Select This Page</a></li>
					                        <li style="clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;"><a class="button_select_all_top" style="border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;" href="#" name="selectall">Select All‎</a></li>
					                        <li style="clear: both;margin: 0;padding: 0;white-space: nowrap;width: 100%;"><a class="button_deselect_top" style="border: 0 none !important;float: left;font-size: 12px !important;padding: 1px 10px !important;text-align: left;width: 100%;line-height: 18px;display: block;" href="#" name="deselect">Deselect All</a></li>
					                      </ul>
					                      <span class="cust_select" class="subhover"> </span>
					                    </li>
					                    </ul>',
                            'widget_type' => 'checkbox',
                            'widget_class' => 'SubPanelCheck',
                            'checkbox_value' => true,
                            'width' => '5%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'name' =>
                        array(
                            'name' => 'name',
                            'vname' => 'LBL_LIST_NAME',
                            'sort_by' => 'last_name',
                            'sort_order' => 'asc',
                            'widget_class' => 'SubPanelDetailViewLink',
                            'module' => 'Contacts',
                            'width' => '23%',
                            'default' => true,
                        ),
                    'account_name' =>
                        array(
                            'name' => 'account_name',
                            'module' => 'Accounts',
                            'target_record_key' => 'account_id',
                            'target_module' => 'Accounts',
                            'widget_class' => 'SubPanelDetailViewLink',
                            'vname' => 'LBL_LIST_ACCOUNT_NAME',
                            'width' => '22%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'phone_work' =>
                        array(
                            'name' => 'phone_work',
                            'vname' => 'LBL_LIST_PHONE',
                            'width' => '15%',
                            'default' => true,
                        ),
                    'email1' =>
                        array(
                            'name' => 'email1',
                            'vname' => 'LBL_LIST_EMAIL',
                            'widget_class' => 'SubPanelEmailLink',
                            'width' => '20%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'event_status_name' =>
                        array(
                            'vname' => 'LBL_STATUS_EVENT',
                            'width' => '10%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'event_accept_status' =>
                        array(
                            'width' => '10%',
                            'sortable' => false,
                            'default' => true,
                            'vname' => 'LBL_ACCEPT_STATUS',
                        ),
                ),
                'order_by' => 'date_entered.date_modified',
            ),
            'Leads' => array(
                'columns' => array(
                    array(
                        'name' => 'nothing',
                        'widget_class' => 'SubPanelIcon',
                        'module' => 'Emails',
                        'width' => '2%',
                    ),
                    'name' =>
                        array(
                            'name' => 'name',
                            'vname' => 'LBL_LIST_NAME',
                            'sort_by' => 'last_name',
                            'sort_order' => 'asc',
                            'widget_class' => 'SubPanelDetailViewLink',
                            'module' => 'Contacts',
                            'width' => '23%',
                            'default' => true,
                        ),
                    'account_name' =>
                        array(
                            'name' => 'account_name',
                            'module' => 'Accounts',
                            'target_record_key' => 'account_id',
                            'target_module' => 'Accounts',
                            'widget_class' => 'SubPanelDetailViewLink',
                            'vname' => 'LBL_LIST_ACCOUNT_NAME',
                            'width' => '22%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'phone_work' =>
                        array(
                            'name' => 'phone_work',
                            'vname' => 'LBL_LIST_PHONE',
                            'width' => '15%',
                            'default' => true,
                        ),
                    'email1' =>
                        array(
                            'name' => 'email1',
                            'vname' => 'LBL_LIST_EMAIL',
                            'widget_class' => 'SubPanelEmailLink',
                            'width' => '20%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'event_status_name' =>
                        array(
                            'vname' => 'LBL_STATUS',
                            'width' => '10%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'event_accept_status' =>
                        array(
                            'width' => '10%',
                            'sortable' => false,
                            'default' => true,
                            'vname' => 'LBL_ACCEPT_STATUS',
                        ),
                ),
                'order_by' => 'leads.date_modified',
            ),
            'Prospects' => array(
                'columns' => array(
                    'name' =>
                        array(
                            'name' => 'name',
                            'vname' => 'LBL_LIST_NAME',
                            'sort_by' => 'last_name',
                            'sort_order' => 'asc',
                            'widget_class' => 'SubPanelDetailViewLink',
                            'module' => 'Contacts',
                            'width' => '23%',
                            'default' => true,
                        ),
                    'account_name' =>
                        array(
                            'name' => 'account_name',
                            'module' => 'Accounts',
                            'target_record_key' => 'account_id',
                            'target_module' => 'Accounts',
                            'widget_class' => 'SubPanelDetailViewLink',
                            'vname' => 'LBL_LIST_ACCOUNT_NAME',
                            'width' => '22%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'phone_work' =>
                        array(
                            'name' => 'phone_work',
                            'vname' => 'LBL_LIST_PHONE',
                            'width' => '15%',
                            'default' => true,
                        ),
                    'email1' =>
                        array(
                            'name' => 'email1',
                            'vname' => 'LBL_LIST_EMAIL',
                            'widget_class' => 'SubPanelEmailLink',
                            'width' => '20%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'event_status_name' =>
                        array(
                            'vname' => 'LBL_STATUS',
                            'width' => '10%',
                            'sortable' => false,
                            'default' => true,
                        ),
                    'event_accept_status' =>
                        array(
                            'width' => '10%',
                            'sortable' => false,
                            'default' => true,
                            'vname' => 'LBL_ACCEPT_STATUS',
                        ),
                ),
                'order_by' => 'Prospects.date_modified',
            ),
        ),
    ),
);
