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
    'LBL_ASSIGNED_TO_ID' => 'ID Usuari Assignat',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => 'Data de Creació',
    'LBL_DATE_MODIFIED' => 'Última Modificació',
    'LBL_MODIFIED' => 'Modificat Per',
    'LBL_MODIFIED_NAME' => 'Modificat per Nom',
    'LBL_CREATED' => 'Creat Per',
    'LBL_DESCRIPTION' => 'Descripció',
    'LBL_DELETED' => 'Esborrat',
    'LBL_NAME' => 'Nom',
    'LBL_CREATED_USER' => 'Creat per Usuari',
    'LBL_MODIFIED_USER' => 'Modificat per Usuari',
    'LBL_LIST_NAME' => 'Nom',
    'LBL_EDIT_BUTTON' => 'Editar',
    'LBL_REMOVE' => 'Eliminar',
    'LBL_LIST_FORM_TITLE' => 'Llista d\'esdeveniments',
    'LBL_MODULE_NAME' => 'Esdeveniments',
    'LBL_MODULE_TITLE' => 'Esdeveniments',
    'LBL_HOMEPAGE_TITLE' => 'El meu esdeveniment',
    'LNK_NEW_RECORD' => 'Crear esdeveniment',
    'LNK_LIST' => 'Veure esdeveniments',
    'LBL_SEARCH_FORM_TITLE' => 'Cercar esdeveniment',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Veure Historial',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Activitats',
    'LBL_NEW_FORM_TITLE' => 'Nou esdeveniment',
    'LBL_LOCATION' => 'Ubicació',
    'LBL_START_DATE' => 'data d\'inici',
    'LBL_END_DATE' => 'Data/Hora de Finalització',
    'LBL_BUDGET' => 'Pressupost',
    'LBL_DATE' => 'Data d\'inici',
    'LBL_DATE_END' => 'Data Fi',
    'LBL_DURATION' => 'Durada',
    'LBL_INVITE_TEMPLATES' => 'Plantilla de correu electrònic d\'invitació',
    'LBL_INVITE_PDF' => 'Enviar invitacions',
    'LBL_EDITVIEW_PANEL1' => 'Detalls de l\'esdeveniment',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Delegats',
    'LBL_ACCEPT_REDIRECT' => 'URL d\'acceptació',
    'LBL_DECLINE_REDIRECT' => 'URL de rebuig',
    'LBL_SELECT_DELEGATES' => 'Seleccionar delegats',
    'LBL_SELECT_DELEGATES_TITLE' => 'Seleccionar delegats:-',
    'LBL_SELECT_DELEGATES_TARGET_LIST' => 'Llista de Públic Objectiu',
    'LBL_SELECT_DELEGATES_TARGETS' => 'Públic Objectiu',
    'LBL_SELECT_DELEGATES_CONTACTS' => 'Contactes',
    'LBL_SELECT_DELEGATES_LEADS' => 'Clients Potencials',
    'LBL_MANAGE_DELEGATES' => 'Gestionar delegats',
    'LBL_MANAGE_DELEGATES_TITLE' => 'Gestionar delegats:-',
    'LBL_MANAGE_ACCEPTANCES' => 'Gestionar acceptacions',
    'LBL_MANAGE_ACCEPTANCES_TITLE' => 'Gestionar acceptacions:-',
    'LBL_MANAGE_ACCEPTANCES_ACCEPTED' => 'Acceptat',
    'LBL_MANAGE_ACCEPTANCES_DECLINED' => 'Rebutjat',
    'LBL_MANAGE_POPUP_ERROR' => 'No s\'ha sel·leccionat cap delegat.',
    'LBL_MANAGE_DELEGATES_INVITED' => 'Convidats',
    'LBL_MANAGE_DELEGATES_NOT_INVITED' => 'No Convidats',
    'LBL_MANAGE_DELEGATES_ATTENDED' => 'Assistents ',
    'LBL_MANAGE_DELEGATES_NOT_ATTENDED' => 'No Assistents',
    'LBL_SUCCESS_MSG' => 'Totes les invitacions s\'han enviat correctament.',
    'LBL_ERROR_MSG_1' => 'Tots els contactes relacionats ja han estat invitats.',
    'LBL_ERROR_MSG_2' => 'L\'enviament de correus electrònics d\'invitació ha fallat! Si us plau, verifiqui la seva configuració de correu electrònic.',
    'LBL_ERROR_MSG_3' => 'Més de 10 correus electrònics han fallat al ser enviats. Si us plau, verifiqui que tots els contactes que està invitant tenen una direcció de correu electrònic correcta (veure el registre d\'errors de SuiteCRM)',
    'LBL_ERROR_MSG_4' => 'correus electrònics han fallat al ser enviats. Si us plau, verifiqui que tots els contactes que està invitant tenen una direcció de correu electrònic vàlida. (vegi el registre d\'erros de SuiteCRM.)', // LBL_ERROR_MSG_4 Begins with a number (controller.php line 581) for example 10 emails have failed to send.
    'LBL_ERROR_MSG_5' => 'Plantilla de correu electrònic invàlida',
    'LBL_EMAIL_INVITE' => 'Enviar invitació per correu electrònic',

    'LBL_FP_EVENTS_CONTACTS_FROM_CONTACTS_TITLE' => 'Contactes',
    'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENT_LOCATIONS_TITLE' => 'Ubicacions',
    'LBL_FP_EVENTS_LEADS_1_FROM_LEADS_TITLE' => 'Clients Potencials',
    'LBL_FP_EVENTS_PROSPECTS_1_FROM_PROSPECTS_TITLE' => 'Públic Objectiu',

    'LBL_HOURS_ABBREV' => 'h',
    'LBL_MINSS_ABBREV' => 'm',
    'LBL_FP_EVENTS_FP_EVENT_DELEGATES_1_FROM_FP_EVENT_DELEGATES_TITLE' => 'Delegats',

    // Attendance report
    'LBL_CONTACT_NAME' => 'Nom',
    'LBL_ACCOUNT_NAME' => 'Empresa',
    'LBL_SIGNATURE' => 'Firma',
    // contacts/leads/targets subpanels
    'LBL_LIST_INVITE_STATUS_EVENT' => 'Convidats',
    'LBL_LIST_ACCEPT_STATUS_EVENT' => 'Estat',

    'LBL_ACTIVITY_STATUS' => 'Estat de l\'activitat',
    'LBL_FP_EVENT_LOCATIONS_FP_EVENTS_1_FROM_FP_EVENTS_TITLE' => 'Ubicacions d\'esdeveniments des dels títols',
    // Email links
    'LBL_ACCEPT_LINK' => 'Acceptar',
    'LBL_DECLINE_LINK' => 'Rebutjar',

);
