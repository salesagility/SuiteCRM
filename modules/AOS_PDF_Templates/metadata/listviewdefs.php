<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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
 * @author SalesAgility Ltd <support@salesagility.com>
 */
$listViewDefs ['AOS_PDF_Templates'] =
array(
  'NAME' =>
  array(
    'width' => '15%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'TYPE' =>
  array(
    'width' => '10%',
    'label' => 'LBL_TYPE',
    'default' => true,
  ),
  'CREATED_BY_NAME' =>
  array(
    'width' => '10%',
    'label' => 'LBL_CREATED',
    'default' => true,
    'module' => 'Users',
    'link' => true,
    'id' => 'CREATED_BY',
  ),
  'MODIFIED_BY_NAME' =>
  array(
    'width' => '10%',
    'label' => 'LBL_MODIFIED_NAME',
    'default' => false,
  ),
  'DATE_ENTERED' =>
  array(
    'width' => '10%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
  ),
  'DATE_MODIFIED' =>
  array(
    'width' => '10%',
    'label' => 'LBL_DATE_MODIFIED',
    'default' => true,
  ),
);
