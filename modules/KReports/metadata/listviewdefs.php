<?php
/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
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
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$listViewDefs['KReports'] = array(
    'NAME' => array(
        'width' => '40',
        'label' => 'LBL_LIST_SUBJECT',
        'link' => true,
        'default' => true),
    'REPORT_MODULE' => array(
        'width' => '10',
        'label' => 'LBL_LIST_MODULE',
        'link' => false,
        'default' => true),
    'REPORT_STATUS' => array(
        'width' => '10',
        'label' => 'LBL_REPORT_STATUS',
        'link' => false,
        'default' => true),
    'REPORT_SEGMENTATION' => array(
        'width' => '10',
        'label' => 'LBL_REPORT_SEGMENTATION',
        'link' => false,
        'default' => true),
    'DATE_ENTERED' => array(
        'width' => '10',
        'label' => 'LBL_LIST_DATEENTERED',
        'link' => false,
        'default' => true),
    'DATE_MODIFIED' => array(
        'width' => '10',
        'label' => 'LBL_LIST_DATEMODIFIED',
        'link' => false,
        'default' => true),
    'ASSIGNED_USER_NAME' => array(
        'width' => '10',
        'label' => 'LBL_LIST_ASSIGNED_USER_NAME',
        'link' => false,
        'default' => true),
);
?>
