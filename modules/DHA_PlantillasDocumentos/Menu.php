<?php
/**
 * This file is part of Mail Merge Reports by Izertis.
 * Copyright (C) 2015 Izertis. 
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
 * You can contact Izertis at email address info@izertis.com.
 */
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

global $mod_strings, $app_strings, $sugar_config, $current_user;
 
if(ACLController::checkAccess('DHA_PlantillasDocumentos', 'edit', true))$module_menu[]=Array("index.php?module=DHA_PlantillasDocumentos&action=EditView&return_module=DHA_PlantillasDocumentos&return_action=DetailView", $mod_strings['LNK_NEW_RECORD'],"CreateDHA_PlantillasDocumentos", 'DHA_PlantillasDocumentos');
if(ACLController::checkAccess('DHA_PlantillasDocumentos', 'list', true))$module_menu[]=Array("index.php?module=DHA_PlantillasDocumentos&action=index&return_module=DHA_PlantillasDocumentos&return_action=DetailView", $mod_strings['LNK_LIST'],"DHA_PlantillasDocumentos", 'DHA_PlantillasDocumentos');
//if(ACLController::checkAccess('DHA_PlantillasDocumentos', 'import', true))$module_menu[]=Array("index.php?module=Import&action=Step1&import_module=DHA_PlantillasDocumentos&return_module=DHA_PlantillasDocumentos&return_action=index", $app_strings['LBL_IMPORT'],"Import", 'DHA_PlantillasDocumentos');
if(ACLController::checkAccess('DHA_PlantillasDocumentos', 'edit', true))$module_menu[]=Array("index.php?module=DHA_PlantillasDocumentos&action=varlist&return_module=DHA_PlantillasDocumentos&return_action=DetailView", $mod_strings['LBL_LISTA_VARIABLES'],"DHA_PlantillasDocumentosVarList", 'DHA_PlantillasDocumentos');

// if(is_admin($current_user)){
   // $module_menu[]=Array("index.php?module=DHA_PlantillasDocumentos&action=Configuration&return_module=DHA_PlantillasDocumentos&return_action=index", $mod_strings['LBL_CONFIG'],"DHA_PlantillasDocumentosConfig", 'DHA_PlantillasDocumentos');
// }