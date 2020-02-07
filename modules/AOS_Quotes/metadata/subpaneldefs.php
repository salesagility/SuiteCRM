<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/**
 * Advanced OpenSales, Advanced, robust set of sales modules.
 * @package Advanced OpenSales for SugarCRM
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


$layout_defs['AOS_Quotes'] = array(
    'subpanel_setup' => array(
        'aos_quotes_aos_contracts' =>
        array(
            'order' => 100,
            'module' => 'AOS_Contracts',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'AOS_Contracts',
            'get_subpanel_data' => 'aos_quotes_aos_contracts',
            'top_buttons' =>
            array(
                0 =>
                array(
                    'widget_class' => 'SubPanelTopCreateButton',
                ),
                    1 =>
                    array(
                    'widget_class' => 'SubPanelTopSelectButton',
                    'popup_module' => 'AOS_Contracts',
                    'mode' => 'MultiSelect',
                ),
            ),
        ),
    
    'aos_quotes_aos_invoices' =>
    array(
        'order' => 100,
        'module' => 'AOS_Invoices',
        'subpanel_name' => 'default',
        'sort_order' => 'asc',
        'sort_by' => 'id',
        'title_key' => 'AOS_Invoices',
        'get_subpanel_data' => 'aos_quotes_aos_invoices',
        'top_buttons' =>
        array(
                0 =>
             array(
                'widget_class' => 'SubPanelTopCreateButton',
            ),
            1 =>
            array(
                'widget_class' => 'SubPanelTopSelectButton',
                'popup_module' => 'AOS_Invoices',
                'mode' => 'MultiSelect',
            ),
        ),
    ),
    
    'aos_quotes_project' =>
    array(
        'order' => 100,
        'module' => 'Project',
        'subpanel_name' => 'default',
        'sort_order' => 'asc',
        'sort_by' => 'id',
        'title_key' => 'Project',
        'get_subpanel_data' => 'aos_quotes_project',
        'top_buttons' =>
        array(
            0 =>
            array(
                'widget_class' => 'SubPanelTopCreateButton',
            ),
            1 =>
            array(
                'widget_class' => 'SubPanelTopSelectButton',
                'popup_module' => 'Accounts',
                'mode' => 'MultiSelect',
                ),
        ),
    ),
),
);
