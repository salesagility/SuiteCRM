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
    'ERR_DELETE_RECORD' => 'Debe especificar un número de rexistro a eliminar.',
    'LBL_TOOL_TIP_BOX_TITLE' => 'Suxestións da Base de Coñecemento',
    'LBL_TOOL_TIP_TITLE' => 'Título: ',
    'LBL_TOOL_TIP_BODY' => 'Corpo: ',
    'LBL_TOOL_TIP_INFO' => 'Información adicional: ',
    'LBL_TOOL_TIP_USE' => 'Usar como: ',
    'LBL_SUGGESTION_BOX' => 'Suxestións',
    'LBL_NO_SUGGESTIONS' => 'Non hai Suxestións',
    'LBL_RESOLUTION_BUTTON' => 'Resolución',
    'LBL_SUGGESTION_BOX_STATUS' => 'Estado',
    'LBL_SUGGESTION_BOX_TITLE' => 'Título',
    'LBL_SUGGESTION_BOX_REL' => 'Prioridade',

    'LBL_ACCOUNT_ID' => 'ID de Conta',
    'LBL_ACCOUNT_NAME' => 'Nome de Conta:',
    'LBL_ACCOUNTS_SUBPANEL_TITLE' => 'Contas',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Actividades',
    'LBL_BUGS_SUBPANEL_TITLE' => 'Incidencias',
    'LBL_CASE_NUMBER' => 'Número:',
    'LBL_CASE' => 'Caso:',
    'LBL_CONTACT_NAME' => 'Contacto:',
    'LBL_CONTACT_ROLE' => 'Rol:',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Casos',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Historial',
    'LBL_INVITEE' => 'Contactos',
    'LBL_MEMBER_OF' => 'Conta',
    'LBL_MODULE_NAME' => 'Casos',
    'LBL_MODULE_TITLE' => 'Casos: Inicio',
    'LBL_NEW_FORM_TITLE' => 'Novo Caso',
    'LBL_NUMBER' => 'Número:',
    'LBL_PRIORITY' => 'Prioridade:',
    'LBL_PROJECTS_SUBPANEL_TITLE' => 'Proxectos',
    'LBL_DOCUMENTS_SUBPANEL_TITLE' => 'Documentos',
    'LBL_RESOLUTION' => 'Resolución:',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Casos',
    'LBL_STATUS' => 'Estado:',
    'LBL_SUBJECT' => 'Asunto:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
    'LBL_LIST_ACCOUNT_NAME' => 'Nome de Conta',
    'LBL_LIST_ASSIGNED' => 'Asignado a',
    'LBL_LIST_CLOSE' => 'Cerrar',
    'LBL_LIST_FORM_TITLE' => 'Lista de Casos',
    'LBL_LIST_LAST_MODIFIED' => 'Última Modificación',
    'LBL_LIST_MY_CASES' => 'Os Meus Casos Abertos',
    'LBL_LIST_NUMBER' => 'Núm.',
    'LBL_LIST_PRIORITY' => 'Prioridade',
    'LBL_LIST_STATUS' => 'Estado',
    'LBL_LIST_SUBJECT' => 'Asunto',

    'LNK_CASE_LIST' => 'Ver Casos',
    'LNK_NEW_CASE' => 'Novo Caso',
    'LBL_LIST_DATE_CREATED' => 'Data de Creación',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_TYPE' => 'Tipo',
    'LBL_WORK_LOG' => 'Rexistro de Traballo',
    'LNK_IMPORT_CASES' => 'Importar Casos',

    'LBL_CREATED_USER' => 'Usuario Creado',
    'LBL_MODIFIED_USER' => 'Usuario Modificado',
    'LBL_PROJECT_SUBPANEL_TITLE' => 'Proxectos',
    'LBL_CASE_INFORMATION' => 'Visión Global',  //Can be translated in all caps. This string will be used by SuiteP template menu actions

    // SNIP
    'LBL_UPDATE_TEXT' => 'Actualizacións - Texto', //Field for Case updates with text only
    'LBL_INTERNAL' => 'Actualización Interna',
    'LBL_AOP_CASE_UPDATES' => 'Actualizacións do caso',
    'LBL_AOP_CASE_UPDATES_THREADED' => 'Actualizacións de Casos Encadenados',
    'LBL_CASE_UPDATES_COLLAPSE_ALL' => 'Contraer todo',
    'LBL_CASE_UPDATES_EXPAND_ALL' => 'Expandir todo',
    'LBL_AOP_CASE_ATTACHMENTS' => 'Adxuntos:',

    'LBL_AOP_CASE_EVENTS' => 'Eventos de Casos',
    'LBL_CASE_ATTACHMENTS_DISPLAY' => 'Adxuntos:',
    'LBL_ADD_CASE_FILE' => 'Engadir arquivo',
    'LBL_REMOVE_CASE_FILE' => 'Eliminar arquivo',
    'LBL_SELECT_CASE_DOCUMENT' => 'Documento seleccionado',
    'LBL_CLEAR_CASE_DOCUMENT' => 'Limpar documento',
    'LBL_SELECT_INTERNAL_CASE_DOCUMENT' => 'Documento interno do CRM',
    'LBL_SELECT_EXTERNAL_CASE_DOCUMENT' => 'Arquivo externo',
    'LBL_CONTACT_CREATED_BY_NAME' => 'Creado polo contacto',
    'LBL_CONTACT_CREATED_BY' => 'Creado por',
    'LBL_CASE_UPDATE_FORM' => 'Actualizacións - Formulario adxunto', //Form for attachments on case updates
    'LBL_CREATOR_PORTAL' => 'URL do Portal', //PR 5426
    'LBL_SUGGESTION' => 'Suxestión', //PR 5426
    'LBL_UNKNOWN_CONTACT' => 'Persoa descoñecida',
);