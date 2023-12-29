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
    'LBL_MODULE_NAME' => 'Incidències',
    'LBL_MODULE_TITLE' => "Seguiment d'incidències: Inici",
    'LBL_MODULE_ID' => 'Incidències',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca Incidències',
    'LBL_LIST_FORM_TITLE' => "Llista d'Incidències",
    'LBL_NEW_FORM_TITLE' => 'Nova Incidència',
    'LBL_SUBJECT' => 'Assumpte:',
    'LBL_NUMBER' => 'Número:',
    'LBL_STATUS' => 'Estat:',
    'LBL_PRIORITY' => 'Prioritat:',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_CONTACT_NAME' => 'Contacte:',
    'LBL_CONTACT_ROLE' => 'Rol:',
    'LBL_LIST_NUMBER' => 'Núm.',
    'LBL_LIST_SUBJECT' => 'Assumpte',
    'LBL_LIST_STATUS' => 'Estat',
    'LBL_LIST_PRIORITY' => 'Prioritat',
    'LBL_LIST_RESOLUTION' => 'Resolució',
    'LBL_LIST_LAST_MODIFIED' => 'Modificat',
    'LBL_INVITEE' => 'Contactes',
    'LBL_TYPE' => 'Tipus:',
    'LBL_LIST_TYPE' => 'Tipus',
    'LBL_RESOLUTION' => 'Resolució:',
    'LBL_RELEASE' => 'Publicació:',
    'LNK_NEW_BUG' => "Informe d'Incidència",
    'LNK_BUG_LIST' => 'Incidències',
    'ERR_DELETE_RECORD' => "Heu d'especificar un número de registre per eliminar la incidència.",
    'LBL_LIST_MY_BUGS' => 'Les meves Incidències assignades',
    'LNK_IMPORT_BUGS' => 'Importa Errors',
    'LBL_FOUND_IN_RELEASE' => 'Trobat a la versió:',
    'LBL_FIXED_IN_RELEASE' => 'Corregit a la versió:',
    'LBL_LIST_FIXED_IN_RELEASE' => 'Corregit a la versió',
    'LBL_WORK_LOG' => "Registre d'activitat:",
    'LBL_SOURCE' => 'Font:',
    'LBL_PRODUCT_CATEGORY' => 'Categoria:',

    'LBL_CREATED_BY' => 'Creat per:',
    'LBL_MODIFIED_BY' => 'Modificat per:',

    'LBL_LIST_EMAIL_ADDRESS' => 'Adreça de correu electrònic',
    'LBL_LIST_CONTACT_NAME' => 'Contacte',
    'LBL_LIST_ACCOUNT_NAME' => 'Compte',
    'LBL_LIST_PHONE' => 'Telèfon',
    'NTC_DELETE_CONFIRMATION' => 'Esteu segur que desitgeu desvincular aquest contacte de la incidència?',

    'LBL_DEFAULT_SUBPANEL_TITLE' => "Seguiment d'Incidències",
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactes',
    'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Comptes',
    'LBL_CASES_SUBPANEL_TITLE' => 'Casos',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projectes',
    'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documents',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuari Assignat',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',

    'LBL_BUG_INFORMATION' => 'Visió general de l\'error', //Can be translated in all caps. This string will be used by SuiteP template menu actions

);
