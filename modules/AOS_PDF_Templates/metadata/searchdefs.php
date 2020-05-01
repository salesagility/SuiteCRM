<?php
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM.
 *
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
 * @author SalesAgility Ltd <support@salesagility.com>
 */

/*
 * Created on May 29, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  $searchdefs['AOS_PDF_Templates'] = [
      'templateMeta' => [
          'maxColumns' => '3',
          'widths' => ['label' => '10', 'field' => '30'],
      ],
      'layout' => [
          'basic_search' => [
              'name',
              ['name' => 'current_user_only', 'label' => 'LBL_CURRENT_USER_FILTER', 'type' => 'bool'],
              ['name' => 'favorites_only', 'label' => 'LBL_FAVORITES_FILTER', 'type' => 'bool'],
          ],
          'advanced_search' => [
              'name',
              'date_entered',
              'date_modified',
              'type',
              ['name' => 'created_by', 'label' => 'LBL_CREATED', 'type' => 'enum', 'function' => ['name' => 'get_user_array', 'params' => [false]]],
          ],
      ],
  ];
