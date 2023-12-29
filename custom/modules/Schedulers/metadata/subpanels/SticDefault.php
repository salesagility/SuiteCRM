<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$subpanel_layout = array(
    'top_buttons' => array(
    ),
    'where' => "",

    'fill_in_additional_fields' => true,
    'list_fields' => array(
        'name' => array(
            'width' => '35%',
            'vname' => 'LBL_NAME',
            'widget_class' => 'SubPanelDetailViewLink',
            'link' => true,
            'sortable' => true,
            'default' => true,
        ),
        'job_interval' => array(
            'width' => '20%',
            'sortable' => true,
            'vname' => 'LBL_LIST_JOB_INTERVAL',
            'default' => true,
            'sortable' => false,
        ),
        'date_time_start' => array(
            'width' => '25%',
            'vname' => 'LBL_LIST_RANGE',
            'customCode' => '{$DATE_TIME_START} - {$DATE_TIME_END}',
            'default' => true,
            'related_fields' => array(
                0 => 'date_time_end',
            ),
        ),
        'status' => array(
            'width' => '15%',
            'vname' => 'LBL_LIST_STATUS',
            'default' => true,
        ),
        'last_run' => array(
            'type' => 'datetime',
            'vname' => 'LBL_LAST_RUN',
            'width' => '10%',
            'default' => true,
        ),
    ),
);
