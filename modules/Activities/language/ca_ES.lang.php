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
    'LBL_MODULE_NAME' => 'Activitats',
    'LBL_MODULE_TITLE' => 'Activitats: Inici',
    'LBL_SEARCH_FORM_TITLE' => 'Cerca d\'activitats',
    'LBL_LIST_FORM_TITLE' => 'Llista d\'activitats',
    'LBL_LIST_SUBJECT' => 'Assumpte',
    'LBL_OVERVIEW' => 'Visió general',
    'LBL_TASKS' => 'Tasques',
    'LBL_MEETINGS' => 'Reunions',
    'LBL_CALLS' => 'Trucades',
    'LBL_EMAILS' => 'Correus electrònics',
    'LBL_NOTES' => 'Notes',
    'LBL_PRINT' => 'Impressió',
    'LBL_MEETING_TYPE' => 'Reunions',
    'LBL_CALL_TYPE' => 'Trucades',
    'LBL_EMAIL_TYPE' => 'Correu electrònic',
    'LBL_NOTE_TYPE' => 'Notes',
    'LBL_DATA_TYPE_START' => 'Inici:',
    'LBL_DATA_TYPE_SENT' => 'Enviat:',
    'LBL_DATA_TYPE_MODIFIED' => 'Modificat:',
    'LBL_LIST_CONTACT' => 'Contacte',
    'LBL_LIST_RELATED_TO' => 'Relacionat amb',
    'LBL_LIST_DATE' => 'Data',
    'LBL_LIST_CLOSE' => 'Tancar',
    'LBL_SUBJECT' => 'Assumpte:',
    'LBL_STATUS' => 'Estat:',
    'LBL_LOCATION' => 'Lloc:',
    'LBL_DATE_TIME' => 'Data i hora d\'inici:',
    'LBL_DATE' => 'Data d\'inici:',
    'LBL_TIME' => 'Hora d\'inici:',
    'LBL_DURATION' => 'Durada:',
    'LBL_HOURS_MINS' => '(hores/minuts)',
    'LBL_CONTACT_NAME' => 'Nom de contacte:',
    'LBL_DESCRIPTION' => 'Descripció:',
    'LNK_NEW_CALL' => 'Programar Trucada',
    'LNK_NEW_MEETING' => 'Programar Reunió',
    'LNK_NEW_TASK' => 'Nova Tasca',
    'LNK_NEW_NOTE' => 'Nova Nota o Arxiu Adjunt',
    'LNK_NEW_EMAIL' => 'Crear correu electrònic arxivat',
    'LNK_CALL_LIST' => 'Trucades',
    'LNK_MEETING_LIST' => 'Reunions',
    'LNK_TASK_LIST' => 'Tasques',
    'LNK_NOTE_LIST' => 'Notes',
    'LBL_DELETE_ACTIVITY' => 'Està segur que vol eliminar aquesta activitat?',
    'ERR_DELETE_RECORD' => 'Ha d\'especificar un número de registre a eliminar.',
    'LBL_INVITEE' => 'Assistents',
    'LBL_LIST_DIRECTION' => 'Direcció',
    'LBL_DIRECTION' => 'Direcció',
    'LNK_NEW_APPOINTMENT' => 'Nova cita',
    'LNK_VIEW_CALENDAR' => 'Veure calendari',
    'LBL_OPEN_ACTIVITIES' => 'Activitats obertes',
    'LBL_HISTORY' => 'Historial',
    'LBL_NEW_TASK_BUTTON_TITLE' => 'Crear tasca',
    'LBL_NEW_TASK_BUTTON_LABEL' => 'Crear tasca',
    'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Programar Reunió',
    'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Programar Reunió',
    'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Programar Trucada',
    'LBL_NEW_NOTE_BUTTON_TITLE' => 'Nova Nota o Arxiu Adjunt',
    'LBL_NEW_NOTE_BUTTON_LABEL' => 'Nova Nota o Arxiu Adjunt',
    'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Arxivar correu electrònic',
    'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Arxivar correu electrònic',
    'LBL_LIST_STATUS' => 'Estat',
    'LBL_LIST_DUE_DATE' => 'Data Venciment',
    'LBL_LIST_LAST_MODIFIED' => 'Modificat',
    'LNK_IMPORT_CALLS' => 'Importar Trucades',
    'LNK_IMPORT_MEETINGS' => 'Importar Reunions',
    'LNK_IMPORT_TASKS' => 'Importar Tasques',
    'LNK_IMPORT_NOTES' => 'Importar Notes',
    'LBL_ACCEPT_THIS' => 'Acceptar?',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Activitats obertes',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuari Assignat',

    'LBL_ACCEPT' => 'Acceptar' /*for 508 compliance fix*/,
);
