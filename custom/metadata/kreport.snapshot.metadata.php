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

if (!defined('sugarEntry') || !sugarEntry)
   die('Not A Valid Entry Point');

$dictionary['KReportSnapshots'] = array(
    'table' => 'kreportsnapshots',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'type' => 'id',
        ),
        'report_id' => array(
            'name' => 'report_id',
            'type' => 'id',
        ),
        'snapshotdate' => array(
            'name' => 'snapshotdate',
            'type' => 'datetime',
        ),
        'snapshotquery' => array(
            'name' => 'snapshotquery',
            'type' => 'text',
        ),
        'data' => array(
            'name' => 'data',
            'type' => 'longblob'
        ),
    ),
    'indices' => array(
    ),
);

$dictionary['KReportSnapshotsData'] = array(
    'table' => 'kreportsnapshotsdata',
    'fields' => array(
        /* 	   'id' => array(
          'name' => 'id',
          'type' => 'id',
          ), */
        'snapshot_id' => array(
            'name' => 'snapshot_id',
            'type' => 'id',
        ),
        'record_id' => array(
            'name' => 'record_id',
            'type' => 'double',
        ),
        'data' => array(
            'name' => 'data',
            'type' => 'blob',
        ),
    ),
    'indices' => array(
        //array('name' => 'snapshot_data', 'type' => 'primary', 'fields' => array('snapshot_id', 'record_id'))
    ),
);
