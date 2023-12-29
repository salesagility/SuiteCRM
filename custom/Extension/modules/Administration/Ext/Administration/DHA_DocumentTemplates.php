<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

global $app_list_strings;

$admin_option_defs=array();
$admin_option_defs['Administration']['DHA_PlantillasDocumentos_validations']= array(
   'DHA_PlantillasDocumentos',
   translate('LBL_MODULE_CONFIG_DESC', 'DHA_PlantillasDocumentos'),
   translate('LBL_MODULE_CONFIG_DESC', 'DHA_PlantillasDocumentos'),
   'index.php?module=DHA_PlantillasDocumentos&action=Configuration'
);
   
$admin_group_header[]= array(
   $app_list_strings['moduleList']['DHA_PlantillasDocumentos'], //translate('LBL_MODULE_TITLE', 'DHA_PlantillasDocumentos'),
   '',
   false,
   $admin_option_defs, 
   translate('LBL_MODULE_CONFIG_SECTION_DESC', 'DHA_PlantillasDocumentos')
);

?>