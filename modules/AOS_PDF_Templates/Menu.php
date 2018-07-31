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


global $mod_strings, $app_strings, $sugar_config;
 
if(ACLController::checkAccess('AOS_PDF_Templates', 'edit', true))$module_menu[]=Array("index.php?module=AOS_PDF_Templates&action=EditView&return_module=AOS_PDF_Templates&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'],"Create", 'AOS_PDF_Templates');
if(ACLController::checkAccess('AOS_PDF_Templates', 'list', true))$module_menu[]=Array("index.php?module=AOS_PDF_Templates&action=index&return_module=AOS_PDF_Templates&return_action=DetailView", $mod_strings['LNK_LIST'],"List", 'AOS_PDF_Templates');
if(ACLController::checkAccess('AOS_PDF_Templates', 'import', true))$module_menu[]=Array("index.php?module=Import&action=Step1&import_module=AOS_PDF_Templates&return_module=AOS_PDF_Templates&return_action=index", $app_strings['LBL_IMPORT'],"Import", 'AOS_PDF_Templates');