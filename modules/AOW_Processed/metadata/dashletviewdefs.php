<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 * Advanced OpenWorkflow, Automating SugarCRM.
 * @package Advanced OpenWorkflow for SugarCRM
 * @copyright SalesAgility Ltd http://www.salesagility.com
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
 * @author SalesAgility <info@salesagility.com>
 */



global $current_user;

$dashletData['AOW_ProcessedDashlet']['searchFields'] = array('date_entered'     => array('default' => ''),
                                                          'date_modified'    => array('default' => ''),
                                                          'assigned_user_id' => array('type'    => 'assigned_user_name',
                                                                                      'default' => $current_user->name));
$dashletData['AOW_ProcessedDashlet']['columns'] =  array(   'name' => array('width'   => '40',
                                                                      'label'   => 'LBL_LIST_NAME',
                                                                      'link'    => true,
                                                                      'default' => true),
                                                      'date_entered' => array('width'   => '15',
                                                                              'label'   => 'LBL_DATE_ENTERED',
                                                                              'default' => true),
                                                      'date_modified' => array('width'   => '15',
                                                                              'label'   => 'LBL_DATE_MODIFIED'),
                                                      'created_by' => array('width'   => '8',
                                                                            'label'   => 'LBL_CREATED'),
                                                      'assigned_user_name' => array('width'   => '8',
                                                                                     'label'   => 'LBL_LIST_ASSIGNED_USER'),
                                               );
