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
    'LBL_BLANK' => ' ',
    'LBL_MODULE_NAME' => 'Trucades',
    'LBL_MODULE_TITLE' => 'Trucades: Inici',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de Trucades',
    'LBL_LIST_FORM_TITLE' => 'Llista de Trucades',
    'LBL_NEW_FORM_TITLE' => 'Crear Cita',
    'LBL_LIST_CLOSE' => 'Tancar',
    'LBL_LIST_SUBJECT' => 'Assumpte',
    'LBL_LIST_CONTACT' => 'Contacte',
    'LBL_LIST_RELATED_TO' => 'Relacionat amb',
    'LBL_LIST_RELATED_TO_ID' => 'Relacionat amb ID',
    'LBL_LIST_DATE' => 'Data Inici',
    'LBL_LIST_DIRECTION' => 'Direcció',
    'LBL_SUBJECT' => 'Assumpte:',
    'LBL_REMINDER' => 'Avís:',
    'LBL_CONTACT_NAME' => 'Contacte:',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_STATUS' => 'Estat:',
    'LBL_DIRECTION' => 'Direcció:',
    'LBL_DATE' => 'Data Inici:',
    'LBL_DURATION' => 'Durada:',
    'LBL_DURATION_HOURS' => 'Hores Durada:',
    'LBL_DURATION_MINUTES' => 'Minuts Durada:',
    'LBL_HOURS_MINUTES' => '(hores/minuts)',
    'LBL_DATE_TIME' => 'Inici:',
    'LBL_TIME' => 'Hora inici:',
    'LBL_HOURS_ABBREV' => 'h',
    'LBL_MINSS_ABBREV' => 'm',
    'LNK_NEW_CALL' => 'Programar Trucada',
    'LNK_NEW_MEETING' => 'Programar Reunió',
    'LNK_CALL_LIST' => 'Trucades',
    'LNK_IMPORT_CALLS' => 'Importar Trucades',
    'ERR_DELETE_RECORD' => 'Ha d\'especificar un número de registre a eliminar.',
    'LBL_INVITEE' => 'Participants',
    'LBL_RELATED_TO' => 'Relacionat amb:',
    'LNK_NEW_APPOINTMENT' => 'Crear Cita',
    'LBL_SCHEDULING_FORM_TITLE' => 'Planificació',
    'LBL_ADD_INVITEE' => 'Afegir Convidats',
    'LBL_NAME' => 'Nom',
    'LBL_FIRST_NAME' => 'Nom',
    'LBL_LAST_NAME' => 'Cognom',
    'LBL_EMAIL' => 'Correu electrònic',
    'LBL_PHONE' => 'Telèfon',
    'LBL_REMINDER_POPUP' => 'Finestra emergent',
    'LBL_REMINDER_EMAIL_ALL_INVITEES' => 'Enviar correu electrònic a tots els assistents',
    'LBL_EMAIL_REMINDER' => 'Recordatori per correu electrònic',
    'LBL_EMAIL_REMINDER_TIME' => 'Temps de recordatori per correu electrònic',
    'LBL_SEND_BUTTON_TITLE' => 'Enviar Invitacions',
    'LBL_SEND_BUTTON_LABEL' => 'Enviar Invitacions',
    'LBL_DATE_END' => 'Data de Fi',
    'LBL_REMINDER_TIME' => 'Hora Avís',
    'LBL_EMAIL_REMINDER_SENT' => 'Recordatori per correu electrònic enviat',
    'LBL_SEARCH_BUTTON' => 'Cercar',
    'LBL_ADD_BUTTON' => 'Afegir',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Trucades',
    'LNK_SELECT_ACCOUNT' => 'Seleccionar Compte',
    'LNK_NEW_ACCOUNT' => 'Nou Compte',
    'LNK_NEW_OPPORTUNITY' => 'Nova Oportunitat',
    'LBL_LEADS_SUBPANEL_TITLE' => 'Clients Potencials',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactes',
    'LBL_USERS_SUBPANEL_TITLE' => 'Usuaris',
    'LBL_OUTLOOK_ID' => 'ID Outlook',
    'LBL_MEMBER_OF' => 'Membre De',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Notes',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuari Assignat',
    'LBL_LIST_MY_CALLS' => 'Les Meves Trucades',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_ASSIGNED_TO_ID' => 'Usuari Assignat',
    'NOTICE_DURATION_TIME' => 'El temps de durada te que ser major que 0',
    'LBL_CALL_INFORMATION' => 'Visió general de la trucada', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_REMOVE' => 'Eliminar',
    'LBL_ACCEPT_STATUS' => 'Estat d\'acceptació',
    'LBL_ACCEPT_LINK' => 'Enllaç d\'acceptació',

    // create invitee functionality
    'LBL_CREATE_INVITEE' => 'Crear una invitació',
    'LBL_CREATE_CONTACT' => 'Com a contacte',
    'LBL_CREATE_LEAD' => 'Com a client potencial',
    'LBL_CREATE_AND_ADD' => 'Crear i afegir',
    'LBL_CANCEL_CREATE_INVITEE' => 'Cancel·lar',
    'LBL_EMPTY_SEARCH_RESULT' => 'Disculpi, no s\'han trobat resultats. Si us plau, creï una invitació a sota.',
    'LBL_NO_ACCESS' => 'Vostè no té permís per a crear $module',

    'LBL_REPEAT_TYPE' => 'Tipus de repetició',
    'LBL_REPEAT_INTERVAL' => 'Interval de repetició',
    'LBL_REPEAT_DOW' => 'Repeteix el Dow',
    'LBL_REPEAT_UNTIL' => 'Repetir fins',
    'LBL_REPEAT_COUNT' => 'Número de repeticions',
    'LBL_REPEAT_PARENT_ID' => 'Id repetició pare',
    'LBL_RECURRING_SOURCE' => 'Font recurrent',

    'LBL_SYNCED_RECURRING_MSG' => 'Aquesta convocatòria es va originar en un altre sistema i ha estat sincronitzada amb SuiteCRM. Per realitzar canvis, aneu a la trucada original a l\'altre sistema. Els canvis realitzats a l\'altre sistema es poden sincronitzar amb aquest registre.',

    // for reminders
    'LBL_REMINDERS' => 'Recordatoris',
    'LBL_REMINDERS_ACTIONS' => 'Accions:',
    'LBL_REMINDERS_POPUP' => 'Finestra emergent',
    'LBL_REMINDERS_EMAIL' => 'Envia una invitació per correu electrònic',
    'LBL_REMINDERS_WHEN' => 'Quan:',
    'LBL_REMINDERS_REMOVE_REMINDER' => 'Elimina el recordatori',
    'LBL_REMINDERS_ADD_ALL_INVITEES' => 'Afegeix tots els convidats',
    'LBL_REMINDERS_ADD_REMINDER' => 'Afegeix un recordatori',

    'LBL_RESCHEDULE' => 'Replanifica',
    'LBL_RESCHEDULE_COUNT' => 'Intents de trucada',
    'LBL_RESCHEDULE_DATE' => 'Data',
    'LBL_RESCHEDULE_REASON' => 'Motiu',
    'LBL_RESCHEDULE_ERROR1' => 'Seleccioneu una data vàlida',
    'LBL_RESCHEDULE_ERROR2' => 'Seleccioneu un motiu',
    'LBL_RESCHEDULE_PANEL' => 'Replanificar',
    'LBL_RESCHEDULE_HISTORY' => 'Historial d\'intents de trucada',
    'LBL_CANCEL' => 'Cancel·la',
    'LBL_SAVE' => 'Desa',

    'LBL_CALLS_RESCHEDULE' => 'Replanifica la trucada',
    'LBL_LIST_STATUS'=>'Estat',
    'LBL_LIST_DATE_MODIFIED'=>'Última Modificació',
    'LBL_LIST_DUE_DATE'=>'Data de Venciment',
);
