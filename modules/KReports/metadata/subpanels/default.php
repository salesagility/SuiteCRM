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

$subpanel_layout = array(
    'top_buttons' => array(
        array(
            'widget_class' => 'SubPanelTopSelectButton', 'popup_module' => 'KReports'
        ),
    ),
    'list_fields' => array(
        'name' => array(
            'vname' => 'LBL_NAME',
            'width' => '30%',
        ),
        'report_module' => array(
            'vname' => 'LBL_MODULE',
            'width' => '15%',
        ),
        'report_status' => array(
            'vname' => 'LBL_REPORT_STATUS',
            'width' => '15%',
        ),
        'report_segmentation' => array(
            'vname' => 'LBL_REPORT_SEGMENTATION',
            'width' => '15%',
        ),
        'remove_button' => array(
            'vname' => 'LBL_REMOVE',
            'widget_class' => 'SubPanelRemoveButton',
            'width' => '2%',
        ),
    ),
);
?>
