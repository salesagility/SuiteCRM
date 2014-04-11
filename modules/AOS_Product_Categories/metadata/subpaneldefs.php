<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Products
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
 * @author Salesagility Ltd <support@salesagility.com>
 */


$layout_defs['AOS_Product_Categories'] = array(
	'subpanel_setup' => array(
        'sub_categories' => array (
            'order' => 100,
            'module' => 'AOS_Product_Categories',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_SUB_CATEGORIES',
            'get_subpanel_data' => 'sub_categories',
            'top_buttons' =>
            array (
                0 =>
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                ),
                1 =>
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                ),
            ),
        ),
        'aos_products' => array (
            'order' => 100,
            'module' => 'AOS_Products',
            'subpanel_name' => 'default',
            'sort_order' => 'asc',
            'sort_by' => 'id',
            'title_key' => 'LBL_AOS_PRODUCTS_SUBPANEL_TITLE',
            'get_subpanel_data' => 'aos_products',
            'top_buttons' =>
            array (
                0 =>
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                ),
                1 =>
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                ),
            ),
        ),
    ),
);
?>
