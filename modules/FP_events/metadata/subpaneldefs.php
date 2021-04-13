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



$layout_defs['FP_events'] = array(
    // list of what Subpanels to show in the DetailView
    'subpanel_setup' => array(

        'delegates' => array(
            'order' => 10,
            'sort_order' => 'desc',
            'title_key' => 'LBL_DEFAULT_SUBPANEL_TITLE',
            'type' => 'collection',
            'subpanel_name' => 'delegates',   //this values is not associated with a physical file.
            'header_definition_from_subpanel'=> 'Contacts',
            'module'=>'Delegates',
            'select_link_top'=>true,

            'top_buttons' => array(
                array('widget_class' => 'SubPanelDelegatesSelectButton'),
                array('widget_class' => 'SubPanelManageDelegatesButton'),
                array('widget_class' => 'SubPanelManageAcceptancesButton'),
                array('widget_class' => 'SubPanelSendInvitesButton'),
                array('widget_class' => 'SubPanelCheck'),
                array('widget_class' => 'SubPanelTopFilterButton'),
            ),

            'collection_list' => array(
                'contacts' => array(
                    'module' => 'Contacts',
                    'subpanel_name' => 'FP_events_subpanel_fp_events_contacts',
                    'get_subpanel_data' => 'fp_events_contacts',
                ),
                'prospects' => array(
                    'module' => 'Prospects',
                    'subpanel_name' => 'FP_events_subpanel_fp_events_prospects_1',
                    'get_subpanel_data' => 'fp_events_prospects_1',
                ),
                'leads' => array(
                    'module' => 'Leads',
                    'subpanel_name' => 'FP_events_subpanel_fp_events_leads_1',
                    'get_subpanel_data' => 'fp_events_leads_1',
                ),
            ),
            'searchdefs' => array(
                'first_name' =>
                    array(
                        'name' => 'first_name',
                        'default' => true,
                        'width' => '10%',
                    ),
                'last_name' =>
                    array(
                        'name' => 'last_name',
                        'default' => true,
                        'width' => '10%',
                    ),
            ),
        ),
    ),
);
