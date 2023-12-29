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
    'ERR_DELETE_RECORD' => 'Ha d\'especificar un número de registre per eliminar el compte.',
    'LBL_TOOL_TIP_BOX_TITLE' => 'Suggerencies amb base de coneixement',
    'LBL_TOOL_TIP_TITLE' => 'Títol',
    'LBL_TOOL_TIP_BODY' => 'Cos:',
    'LBL_TOOL_TIP_INFO' => 'Informació addicional:',
    'LBL_TOOL_TIP_USE' => 'Utilitza com:',
    'LBL_SUGGESTION_BOX' => 'Suggeriments',
    'LBL_NO_SUGGESTIONS' => 'Sense suggeriments',
    'LBL_RESOLUTION_BUTTON' => 'Resolució',
    'LBL_SUGGESTION_BOX_STATUS' => 'Situació',
    'LBL_SUGGESTION_BOX_TITLE' => 'Títol',
    'LBL_SUGGESTION_BOX_REL' => 'Rellevància',

    'LBL_ACCOUNT_ID' => 'ID Compte',
    'LBL_ACCOUNT_NAME' => 'Compte:',
    'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Comptes',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_BUGS_SUBPANEL_TITLE' => 'Incidències',
    'LBL_CASE_NUMBER' => 'Número:',
    'LBL_CASE' => 'Cas:',
    'LBL_CONTACT_NAME' => 'Contacte:',
    'LBL_CONTACT_ROLE' => 'Rol:',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactes',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Casos',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_INVITEE' => 'Contactes',
    'LBL_MEMBER_OF' => 'Compte',
    'LBL_MODULE_NAME' => 'Casos',
    'LBL_MODULE_TITLE' => 'Casos: Inici',
    'LBL_NEW_FORM_TITLE' => 'Nou Cas',
    'LBL_NUMBER' => 'Número:',
    'LBL_PRIORITY' => 'Prioritat:',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'Projectes',
    'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documents',
    'LBL_RESOLUTION' => 'Resolució:',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de Casos',
    'LBL_STATUS' => 'Situació:',
    'LBL_SUBJECT' => 'Assumpte:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuari Assignat',
    'LBL_LIST_ACCOUNT_NAME' => 'Compte',
    'LBL_LIST_ASSIGNED' => 'Assignat a',
    'LBL_LIST_CLOSE' => 'Tancar',
    'LBL_LIST_FORM_TITLE' => 'Llista de Casos',
    'LBL_LIST_LAST_MODIFIED' => 'Modificat',
    'LBL_LIST_MY_CASES' => 'Els Meus Casos Oberts',
    'LBL_LIST_NUMBER' => 'Núm.',
    'LBL_LIST_PRIORITY' => 'Prioritat',
    'LBL_LIST_STATUS' => 'Situació',
    'LBL_LIST_SUBJECT' => 'Assumpte',

    'LNK_CASE_LIST' => 'Casos',
    'LNK_NEW_CASE' => 'Nou Cas',
    'LBL_LIST_DATE_CREATED' => 'Data de Creació',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_TYPE' => 'Tipus',
    'LBL_WORK_LOG' => 'Registre de Treball',
    'LNK_IMPORT_CASES' => 'Importar casos',

    'LBL_CREATED_USER' => 'Usuari Creat',
    'LBL_MODIFIED_USER' => 'Usuari Modificat',
    'LBL_PROJECT_SUBPANEL_TITLE' => 'Projectes',
    'LBL_CASE_INFORMATION' => 'Visió general del cas',  //Can be translated in all caps. This string will be used by SuiteP template menu actions

    // SNIP
    'LBL_UPDATE_TEXT' => 'Actualitzar text', //Field for Case updates with text only
    'LBL_INTERNAL' => 'Actualització interna',
    'LBL_AOP_CASE_UPDATES' => 'Actualitzacions de casos',
    'LBL_AOP_CASE_UPDATES_THREADED' => 'Actualitzacions de casos encadenats',
    'LBL_CASE_UPDATES_COLLAPSE_ALL' => 'Col·lapsar tot',
    'LBL_CASE_UPDATES_EXPAND_ALL' => 'Expandeix tot',
    'LBL_AOP_CASE_ATTACHMENTS' => 'Adjunts:',

    'LBL_AOP_CASE_EVENTS' => 'Esdeveniments de casos',
    'LBL_CASE_ATTACHMENTS_DISPLAY' => 'Adjunts de cas:',
    'LBL_ADD_CASE_FILE' => 'Afegir fitxer',
    'LBL_REMOVE_CASE_FILE' => 'Eliminar fitxer',
    'LBL_SELECT_CASE_DOCUMENT' => 'Seleccionar document',
    'LBL_CLEAR_CASE_DOCUMENT' => 'Netejar document',
    'LBL_SELECT_INTERNAL_CASE_DOCUMENT' => 'Document intern a CRM',
    'LBL_SELECT_EXTERNAL_CASE_DOCUMENT' => 'Fitxer extern',
    'LBL_CONTACT_CREATED_BY_NAME' => 'Creat per contacte',
    'LBL_CONTACT_CREATED_BY' => 'Creat per',
    'LBL_CASE_UPDATE_FORM' => 'Actualitzar l\'adjunt', //Form for attachments on case updates
    'LBL_CREATOR_PORTAL' => 'URL del Portal', //PR 5426
    'LBL_SUGGESTION' => 'Suggeriment', //PR 5426
    'LBL_UNKNOWN_CONTACT' => 'Persona desconegut',
);