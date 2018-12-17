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




global $current_user, $app_strings;

$dashletData['MyEmailsDashlet']['searchFields'] = array(
                                                       'date_sent'  => array('default' => ''),
                                                       'name'  => array('default' => ''),
                                                       //'from_addr_name' => array('default' => ''),
                                                       'assigned_user_id'   => array('default' => ''),
    'category_id'      => array('default' => ''),
                                                       );
$dashletData['MyEmailsDashlet']['columns'] = array(
                                                   'from_addr' => array('width'   => '15',
                                                                       'label'   => 'LBL_FROM',
                                                                       'default' => true),
                                                   'name' => array('width'   => '40',
                                                                   'label'   => 'LBL_SUBJECT',
                                                                   'link'    => true,
                                                                   'default' => true),
                                                   'to_addrs_names' => array('width'   => '15',
                                                                         'label'   => 'LBL_TO_ADDRS',
                                                                         'default' => false),
                                                   'assigned_user_name' => array('width'   => '15',
                                                                         'label'   => 'LBL_LIST_ASSIGNED',
                                                                         'default' => false),

                                                   'date_sent' => array('width'   => '15',
                                                                         'label'   => 'LBL_DATE_SENT',
                                                                         'default' => true,
                                                                         'defaultOrderColumn' => array('sortOrder' => 'ASC')
                                                                         ),
                                                  'date_entered' => array('width'   => '15',
                                                                          'label'   => 'LBL_DATE_ENTERED'),
                                                  'date_modified' => array('width'   => '15',
                                                                           'label'   => 'LBL_DATE_MODIFIED'),
                                                  'quick_reply' => array('width'   => '15',
                                                                        'label'   => 'LNK_QUICK_REPLY',
                                                                        'sortable' => false,
                                                                        'default' => true),

    'category_id' => array('width' => '8',
        'label' => 'LBL_CATEGORY',
        'default' => true),
);
