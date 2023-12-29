<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
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
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}


$mod_strings = array(

    'LBL_ADMINISTRATION_MAIN' => 'Configuració de Conectors',
    'LBL_AVAILABLE' => 'Disponible',
    'LBL_BACK' => '< Enrera',
    'LBL_CONFIRM_CONTINUE_SAVE' => 'Alguns camps requerits s\'han deixat en blanc.  ¿Vol continuar i desar els canvis?',
    'LBL_CONNECTOR_FIELDS' => 'Camps del Conector',
    'LBL_DATA' => 'Datdes',
    'LBL_DEFAULT' => 'Per Defecte',
    'LBL_DISABLED' => 'Deshabilitat',
    'LBL_ENABLED' => 'Habilitat',
    'LBL_EXTERNAL' => 'Permet als usuaris crear registres de comptes externs a aquest connector.',
    'LBL_EXTERNAL_SET_PROPERTIES' => 'Per utilitzar aquest connector, les propietats també s\'han d\'establir a la pàgina de configuració de connectors.',
    'LBL_MERGE' => 'Combinar',
    'LBL_MODIFY_DISPLAY_TITLE' => 'Habilita Connectors',
    'LBL_MODIFY_DISPLAY_DESC' => 'Seleccioneu quins mòduls estan habilitats per a cada connector.',
    'LBL_MODULE_FIELDS' => 'Camps del mòdul',
    'LBL_MODIFY_MAPPING_TITLE' => 'Mapeja els camps del connector',
    'LBL_MODIFY_MAPPING_DESC' => 'Mapeja camps del connector a camps del mòdul per determinar quines dades del connector poden ser vistes i combinades junt amb els registres del mòdul.',
    'LBL_MODIFY_PROPERTIES_TITLE' => 'Establir Propietats del Conector',
    'LBL_MODIFY_PROPERTIES_DESC' => 'Configurar les propietats de cada conector, incloent les URLs i les claus del API.',
    'LBL_MODIFY_SEARCH_TITLE' => 'Administrar Cerca de Conectors',
    'LBL_MODIFY_SEARCH' => 'Cerca',
    'LBL_MODIFY_SEARCH_DESC' => 'Seleccioneu els camps del connector a utilitzar per a la cerca de dades de cada mòdul.',
    'LBL_MODULE_NAME' => 'Conectors',
    'LBL_NO_PROPERTIES' => 'No hi ha propietats configurables per a aquest connector.',
    'LBL_SAVE' => 'Desar',
    'LBL_SUMMARY' => 'Resum',
    'LBL_STEP1' => 'Cerca i mostra les dades',
    'LBL_STEP2' => 'Combina registres amb',
    'LBL_TEST_SOURCE' => 'Prova de connector',
    'LBL_TEST_SOURCE_FAILED' => 'Error a la prova',
    'LBL_TEST_SOURCE_SUCCESS' => 'Prova exitosa',
    'LBL_TITLE' => 'Combinació de dades',

    'ERROR_NO_ADDITIONAL_DETAIL' => 'Error: No s\'han trobat més detalls per el registre.',
    'ERROR_NO_SEARCHDEFS_DEFINED' => 'No s\'han habilitat mòduls per aquest conector.  Seleccioni un mòdul per aquest conector en la pàgina Habilitar Conectors.',
    'ERROR_NO_SEARCHDEFS_MAPPED' => 'Error: No hi ha cap connector habilitat amb camps de cerca definits.',
    'ERROR_NO_SEARCHDEFS_MAPPING' => 'Error: No s\'han definit camps de cerca per al mòdul i el connector.  Si us plau, contacti amb el administrador del sistema.',
    'ERROR_NO_DISPLAYABLE_MAPPED_FIELDS' => 'Error: No s\'ha mapejat cap camp de mòdul per ser mostrat com part dels resultats.  Si us plau, contacti amb el administrador del sistema.',
    'LBL_INFO_INLINE' => 'Informació' /*for 508 compliance fix*/,
    'LBL_CLOSE' => 'Tancament' /*for 508 compliance fix*/,

);
