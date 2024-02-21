<?php
/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
 *
 * This file has been modified by SinergiaTIC in SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact Christian Knoll at info@kreporter.org
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$searchdefs['KReports'] = array(
    'templateMeta' => array(
        'maxColumns' => '3',
        'widths' => array('label' => '10', 'field' => '30'),
    ),
    'layout' => array(
        'basic_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'label' => 'LBL_LIST_SUBJECT',
                'width' => '10%',
            ),
            'report_modules' => array(
                'type' => 'enum',
                'name' => 'report_module', 
                'default' => true,
                'label' => 'LBL_MODULE',
                'width' => '10%',
            ),
            'report_status' => array(
                'type' => 'enum',
                'name' => 'report_status', 
                'default' => true,
                'label' => 'LBL_REPORT_STATUS',
                'width' => '10%',
            ),
            'report_segmentation' => array(
                'type' => 'enum',
                'name' => 'report_segmentation', 
                'default' => true,
                'label' => 'LBL_REPORT_SEGMENTATION',
                'width' => '10%',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'default' => true,
                'name' => 'date_entered',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'default' => true,
                'name' => 'date_modified',
            ),
            'assigned_user_id' => array(
                // STIC-Custom 20211108 AAM - Fixing field type, so the filter would work
                // STIC#469
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
                // END STIC
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
        'advanced_search' => array(
            'name' => array(
                'name' => 'name',
                'default' => true,
                'label' => 'LBL_LIST_SUBJECT',
                'width' => '10%',
            ),
            'report_modules' => array(
                'type' => 'enum',
                'name' => 'report_module', 
                'default' => true,
                'label' => 'LBL_MODULE',
                'width' => '10%',
            ),
            'date_entered' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_ENTERED',
                'default' => true,
                'name' => 'date_entered',
            ),
            'date_modified' => array(
                'type' => 'datetime',
                'label' => 'LBL_DATE_MODIFIED',
                'default' => true,
                'name' => 'date_modified',
            ),
            'description' => array(
                'type' => 'text',
                'label' => 'LBL_DESCRIPTION',
                'sortable' => false,
                'width' => '10%',
                'default' => true,
                'name' => 'description',
            ),
            'assigned_user_id' => array(
                // STIC-Custom 20211108 AAM - Fixing field type, so the filter would work
                // STIC#469
                'name' => 'assigned_user_id',
                'label' => 'LBL_ASSIGNED_TO',
                'type' => 'enum',
                'function' => array(
                    'name' => 'get_user_array',
                    'params' => array(
                        0 => false,
                    ),
                ),
                'width' => '10%',
                'default' => true,
                // END STIC
            ),
            'created_by' => array(
                // STIC-Custom 20211108 AAM - Fixing field type, so the filter would work
                // STIC#469
                // 'type' => 'relate',
                'type' => 'assigned_user_name',
                'label' => 'LBL_CREATED',
                'width' => '10%',
                'default' => true,
                'name' => 'created_by',
                // END STIC
            ),
            'modified_user_id' => array(
                // STIC-Custom 20211108 AAM - Fixing field type, so the filter would work
                // STIC#469
                // 'type' => 'relate',
                'type' => 'assigned_user_name',
                'label' => 'LBL_MODIFIED',
                'width' => '10%',
                'default' => true,
                'name' => 'modified_user_id',
                // END STIC
            ),
            'current_user_only' => array(
                'name' => 'current_user_only', 
                'label' => 'LBL_CURRENT_USER_FILTER', 
                'width' => '10%',
                'default' => true,
                'type' => 'bool'
            ),
            'favorites_only' => array(
                'name' => 'favorites_only',
                'label' => 'LBL_FAVORITES_FILTER',
                'type' => 'bool',
                'default' => true,
                'width' => '10%',
            ),
        ),
    ),
);
?>
