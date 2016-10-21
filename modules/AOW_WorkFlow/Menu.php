<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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


global $mod_strings, $app_strings, $sugar_config;
 
if(ACLController::checkAccess('AOW_WorkFlow', 'edit', true))$module_menu[]=Array("index.php?module=AOW_WorkFlow&action=EditView&return_module=AOW_WorkFlow&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'],"Create", 'AOW_WorkFlow');
if(ACLController::checkAccess('AOW_WorkFlow', 'list', true))$module_menu[]=Array("index.php?module=AOW_WorkFlow&action=index&return_module=AOW_WorkFlow&return_action=DetailView", $mod_strings['LNK_LIST'],"List", 'AOW_WorkFlow');
if(ACLController::checkAccess('AOW_Processed', 'list', true))$module_menu[]=Array("index.php?module=AOW_Processed&action=index&return_module=AOW_Processed&return_action=DetailView", $mod_strings['LNK_PROCESSED_LIST'],"View_Process_Audit", 'AOW_Processed');