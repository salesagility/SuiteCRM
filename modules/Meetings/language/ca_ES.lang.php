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
    'LBL_ACCEPT_THIS' => 'Acceptar?',
    'LBL_ADD_BUTTON' => 'Afegir',
    'LBL_ADD_INVITEE' => 'Afegir Assistents',
    'LBL_CONTACT_NAME' => 'Nom Contacte: ',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactes',
    'LBL_CREATED_BY' => 'Creat per',
    'LBL_DATE_END' => 'Data Fi',
    'LBL_DATE_TIME' => 'Data i hora d\'inici:',
    'LBL_DATE' => 'Data Inici:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Reunions',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LBL_DIRECTION' => 'Direcció:',
    'LBL_DURATION_HOURS' => 'Hores Durada:',
    'LBL_DURATION_MINUTES' => 'Minuts Durada:',
    'LBL_DURATION' => 'Durada:',
    'LBL_EMAIL' => 'Correu electrònic',
    'LBL_FIRST_NAME' => 'Nom',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Notes',
    'LBL_HOURS_ABBREV' => 'h',
    'LBL_HOURS_MINS' => '(hores/minuts)',
    'LBL_INVITEE' => 'Assistents',
    'LBL_LAST_NAME' => 'Cognoms',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuari Assignat',
    'LBL_LIST_CLOSE' => 'Tancat',
    'LBL_LIST_CONTACT' => 'Contacte',
    'LBL_LIST_DATE_MODIFIED' => 'Data de Modificació',
    'LBL_LIST_DATE' => 'Data Inici',
    'LBL_LIST_DIRECTION' => 'Direcció',
    'LBL_LIST_DUE_DATE' => 'Data de Venciment',
    'LBL_LIST_FORM_TITLE' => 'Llista de Reunions',
    'LBL_LIST_MY_MEETINGS' => 'Les Meves Reunions',
    'LBL_LIST_RELATED_TO' => 'Relacionat amb',
    'LBL_LIST_STATUS' => 'Estat',
    'LBL_LIST_SUBJECT' => 'Assumpte',
    'LBL_LEADS_SUBPANEL_TITLE' => 'Clients Potencials',
    'LBL_LOCATION' => 'Lloc:',
    'LBL_MINSS_ABBREV' => 'm',
    'LBL_MODIFIED_BY' => 'Modificat per',
    'LBL_MODULE_NAME' => 'Reunions',
    'LBL_MODULE_TITLE' => 'Reunions: Inici',
    'LBL_NAME' => 'Nom',
    'LBL_NEW_FORM_TITLE' => 'Crear Cita',
    'LBL_OUTLOOK_ID' => 'ID Outlook',
    'LBL_SEQUENCE' => 'Seqüència d\'actualització de reunió',
    'LBL_PHONE' => 'Telèfon',
    'LBL_REMINDER_TIME' => 'Hora Avís',
    'LBL_EMAIL_REMINDER_SENT' => 'Recordatori per correu electrònic enviat',
    'LBL_REMINDER' => 'Avís:',
    'LBL_REMINDER_POPUP' => 'Finestra emergent',
    'LBL_REMINDER_EMAIL_ALL_INVITEES' => 'Enviar correu electrònic a tots els assistents',
    'LBL_EMAIL_REMINDER' => 'Recordatori per correu electrònic',
    'LBL_EMAIL_REMINDER_TIME' => 'Temps de recordatori per correu electrònic',
    'LBL_REMOVE' => 'Eliminar',
    'LBL_SCHEDULING_FORM_TITLE' => 'Planificació',
    'LBL_SEARCH_BUTTON' => 'Cerca',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca de Reunions',
    'LBL_SEND_BUTTON_LABEL' => 'Enviar Invitacions',
    'LBL_SEND_BUTTON_TITLE' => 'Desar i enviar invitacions',
    'LBL_STATUS' => 'Estat:',
    'LBL_TYPE' => 'Tipus de reunió',
    'LBL_PASSWORD' => 'Contrasenya de la reunió',
    'LBL_URL' => 'Iniciar/Unir-se a la reunió',
    'LBL_HOST_URL' => 'Host URL',
    'LBL_DISPLAYED_URL' => 'Mostrar URL',
    'LBL_CREATOR' => 'Creador de la reunió',
    'LBL_EXTERNALID' => 'Id App externa',
    'LBL_SUBJECT' => 'Assumpte: ',
    'LBL_TIME' => 'Hora Inici:',
    'LBL_USERS_SUBPANEL_TITLE' => 'Usuaris',
    'LBL_PARENT_TYPE' => 'Tipus de Pare',
    'LBL_PARENT_ID' => 'Id pare',
    'LNK_MEETING_LIST' => 'Reunions',
    'LNK_NEW_APPOINTMENT' => 'Crear Cita',
    'LNK_NEW_MEETING' => 'Programar Reunió',
    'LNK_IMPORT_MEETINGS' => 'Importar Reunions',

    'LBL_CREATED_USER' => 'Usuari Creat',
    'LBL_MODIFIED_USER' => 'Usuari Modificat',
    'NOTICE_DURATION_TIME' => 'El temps de durada te que ser major que 0',
    'LBL_MEETING_INFORMATION' => 'Visió general de la reunió', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_LIST_JOIN_MEETING' => 'Unir-se a la reunió',
    'LBL_ACCEPT_STATUS' => 'Estat d\'acceptació',
    'LBL_ACCEPT_LINK' => 'Enllaç d\'acceptació',
    // You are not invited to the meeting messages
    'LBL_EXTNOT_MAIN' => 'No es pot unir a aquesta reunió, ja que no és un assistent.',
    'LBL_EXTNOT_RECORD_LINK' => 'Veure reunió',

    //cannot start messages
    'LBL_EXTNOSTART_MAIN' => 'No pot iniciar aquesta reunió, ja que no és un administrador o el propietari d\'aquesta reunió.',

    // create invitee functionallity
    'LBL_CREATE_INVITEE' => 'Crear una invitació',
    'LBL_CREATE_CONTACT' => 'Com a contacte',  // Create invitee functionallity
    'LBL_CREATE_LEAD' => 'Com a client potencial', // Create invitee functionallity
    'LBL_CREATE_AND_ADD' => 'Crear i afegir', // Create invitee functionallity
    'LBL_CANCEL_CREATE_INVITEE' => 'Cancel·lar',
    'LBL_EMPTY_SEARCH_RESULT' => 'Disculpi, no s\'han trobat resultats. Si us plau, creï una invitació a sota.',
    'LBL_NO_ACCESS' => 'Vostè no té permís per a crear $module',  // Create invitee functionallity

    'LBL_REPEAT_TYPE' => 'Tipus de repetició',
    'LBL_REPEAT_INTERVAL' => 'Interval de repetició',
    'LBL_REPEAT_DOW' => 'Repeteix el Dow',
    'LBL_REPEAT_UNTIL' => 'Repetir fins',
    'LBL_REPEAT_COUNT' => 'Número de repeticions',
    'LBL_REPEAT_PARENT_ID' => 'Id repetició pare',
    'LBL_RECURRING_SOURCE' => 'Font recurrent',

    'LBL_SYNCED_RECURRING_MSG' => 'Aquesta convocatòria es va originar en un altre sistema i se sincronitzen amb el SuiteCRM. Per realitzar canvis, aneu a la reunió original en l\'altre sistema. Els canvis realitzats en l\'altre sistema es pot sincronitzar amb aquest registre.',
    'LBL_RELATED_TO' => 'Relacionat amb:',

    // for reminders
    'LBL_REMINDERS' => 'Recordatoris',
    'LBL_REMINDERS_ACTIONS' => 'Accions:',
    'LBL_REMINDERS_POPUP' => 'Finestra emergent',
    'LBL_REMINDERS_EMAIL' => 'Enviar invitació per correu electrònic',
    'LBL_REMINDERS_WHEN' => 'Quan:',
    'LBL_REMINDERS_REMOVE_REMINDER' => 'Eliminar recordatori',
    'LBL_REMINDERS_ADD_ALL_INVITEES' => 'Afegir tots els invitats',
    'LBL_REMINDERS_ADD_REMINDER' => 'Afegir un recordatori',

    // for google sync
    'LBL_GSYNC_ID' => 'ID d\'event de Google',
    'LBL_GSYNC_LASTSYNC' => 'Data i hora de l\'última sincronització amb Google',
);
