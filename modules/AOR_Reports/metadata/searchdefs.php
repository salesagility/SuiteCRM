<?php
/**
 * Advanced OpenReports, SugarCRM Reporting.
 * @package Advanced OpenReports for SugarCRM
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
 
  $searchdefs['AOR_Reports'] = array(
					'templateMeta' => array(
							'maxColumns' => '3',
  							'maxColumnsBasic' => '4', 
                            'widths' => array('label' => '10', 'field' => '30'),                 
                           ),
                    'layout' => array(  					
						'basic_search' => array(
							'name', 
							array('name'=>'current_user_only', 'label'=>'LBL_CURRENT_USER_FILTER', 'type'=>'bool'),
							),
						'advanced_search' => array(
							'name', 
							array('name' => 'assigned_user_id', 'label' => 'LBL_ASSIGNED_TO', 'type' => 'enum', 'function' => array('name' => 'get_user_array', 'params' => array(false))),
						),
					),
 			   );
?>
