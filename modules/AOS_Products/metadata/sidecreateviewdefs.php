<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
/*
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
 * @author SalesAgility Ltd <support@salesagility.com>
 */

global $mod_strings;
$module_name = 'AOS_Products';
$viewdefs[$module_name]['SideQuickCreate'] = [
    'templateMeta' => ['form' => ['buttons' => ['SAVE'],
        'button_location' => 'bottom',
        'headerTpl' => 'include/EditView/header.tpl',
        'footerTpl' => 'include/EditView/footer.tpl',
    ],
        'maxColumns' => '1',
        'panelClass' => 'none',
        'labelsOnTop' => true,
        'widths' => [
            ['label' => '10', 'field' => '30'],
        ],
    ],
    'panels' => [
        'DEFAULT' => [
            [
                ['name' => 'name', 'displayParams' => ['required' => true, 'size' => 20]],
            ],
            [
                ['name' => 'description', 'displayParams' => ['rows' => 3, 'cols' => 20]],
            ],
            [
                ['name' => 'assigned_user_name', 'displayParams' => ['required' => true, 'size' => 11, 'selectOnly' => true]],
            ],
        ],
    ]
];
