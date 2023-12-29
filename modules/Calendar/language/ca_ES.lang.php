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

    'LBL_SHAREDWEEK' => 'Setmana compartida',
    'LBL_SHAREDMONTH' => 'Mes compartit',

    'LBL_MODULE_NAME' => 'Calendari',
    'LBL_MODULE_TITLE' => 'Calendari',
    'LNK_NEW_CALL' => 'Programa una Trucada',
    'LNK_NEW_MEETING' => 'Programa una Reunió',
    'LNK_NEW_TASK' => 'Crea una Tasca',
    'LNK_CALL_LIST' => 'Trucades',
    'LNK_MEETING_LIST' => 'Reunions',
    'LNK_TASK_LIST' => 'Tasques',
    'LNK_TASK' => 'Tasques',
    'LNK_TASK_VIEW' => 'Mostra la Tasca',
    'LNK_EVENT' => 'Esdeveniment',
    'LNK_EVENT_VIEW' => "Mostra l'Esdeveniment",
    'LNK_VIEW_CALENDAR' => 'Avui',
    'LNK_IMPORT_CALLS' => 'Importa Trucades',
    'LNK_IMPORT_MEETINGS' => 'Importa Reunions',
    'LNK_IMPORT_TASKS' => 'Importa Tasques',
    'LBL_MONTH' => 'Mes',
    'LBL_AGENDADAY' => 'Dia',
    'LBL_YEAR' => 'Any',

    'LBL_AGENDAWEEK' => 'Setmana',
    'LBL_PREVIOUS_MONTH' => 'Mes anterior',
    'LBL_PREVIOUS_DAY' => 'Dia anterior',
    'LBL_PREVIOUS_YEAR' => 'Any anterior',
    'LBL_PREVIOUS_WEEK' => 'Setmana anterior',
    'LBL_NEXT_MONTH' => 'Mes següent',
    'LBL_NEXT_DAY' => 'Dia següent',
    'LBL_NEXT_YEAR' => 'Any següent',
    'LBL_NEXT_WEEK' => 'Setmana següent',
    'LBL_AM' => 'AM',
    'LBL_PM' => 'PM',
    'LBL_SCHEDULED' => 'Planificat',
    'LBL_BUSY' => 'Ocupat',
    'LBL_CONFLICT' => 'Conflicte',
    'LBL_USER_CALENDARS' => 'Calendaris d\'Usuari',
    'LBL_SHARED' => 'Compartit',
    'LBL_PREVIOUS_SHARED' => 'Anterior',
    'LBL_NEXT_SHARED' => 'Següent',
    'LBL_SHARED_CAL_TITLE' => 'Calendari compartit',
    'LBL_USERS' => 'Usuari',
    'LBL_REFRESH' => 'Actualitza',
    'LBL_EDIT_USERLIST' => 'Llista d\'Usuaris',
    'LBL_SELECT_USERS' => 'Seleccioneu els usuaris dels quals voleu veure el calendari',
    'LBL_FILTER_BY_TEAM' => 'Filtrat d\'usuaris per equip:',
    'LBL_ASSIGNED_TO_NAME' => 'Assignat a',
    'LBL_DATE' => 'Data i Hora d\'Inici',
    'LBL_CREATE_MEETING' => 'Programa una Reunió',
    'LBL_CREATE_CALL' => 'Programa una Trucada',
    'LBL_HOURS_ABBREV' => 'h',
    'LBL_MINS_ABBREV' => 'm',


    'LBL_YES' => 'Sí',
    'LBL_NO' => 'No',
    'LBL_SETTINGS' => 'Configuració',
    'LBL_CREATE_NEW_RECORD' => 'Crea una activitat',
    'LBL_LOADING' => 'Carregant...',
    'LBL_SAVING' => 'Desant...',
    'LBL_SENDING_INVITES' => 'Desant i enviant invitacions...',
    'LBL_CONFIRM_REMOVE' => 'Segur que voleu eliminar aquest registre?',
    'LBL_CONFIRM_REMOVE_ALL_RECURRING' => 'Segur que voleu eliminar tots els registres recurrents?',
    'LBL_EDIT_RECORD' => "Edita l'activitat",
    'LBL_ERROR_SAVING' => 'Error al desar',
    'LBL_ERROR_LOADING' => 'Error al carregar',
    'LBL_GOTO_DATE' => 'Ves a la data',
    'NOTICE_DURATION_TIME' => 'La durada ha de ser més gran que 0',
    'LBL_STYLE_BASIC' => 'Bàsic',
    'LBL_STYLE_ADVANCED' => 'Avançat',

    'LBL_NO_USER' => 'No hi ha resultats pel camp: Assignat a',
    'LBL_SUBJECT' => 'Assumpte',
    'LBL_DURATION' => 'Durada',
    'LBL_STATUS' => 'Estat',
    'LBL_PRIORITY' => 'Prioritat',

    'LBL_SETTINGS_TITLE' => 'Configuració',
    'LBL_SETTINGS_DISPLAY_TIMESLOTS' => 'Mostra els intervals de temps en setmanes i dies:',
    'LBL_SETTINGS_TIME_STARTS' => "Hora d'inici:",
    'LBL_SETTINGS_TIME_ENDS' => 'Hora de finalització:',
    'LBL_SETTINGS_CALLS_SHOW' => 'Mostra les trucades:',
    'LBL_SETTINGS_TASKS_SHOW' => 'Mostra les tasques:',
    'LBL_SETTINGS_COMPLETED_SHOW' => 'Mostra les reunions, trucades i tasques realitzades:',
    'LBL_SETTINGS_DISPLAY_SHARED_CALENDAR_SEPARATE' => 'Comparteix el calendari separat:',

    'LBL_SAVE_BUTTON' => 'Desa',
    'LBL_DELETE_BUTTON' => 'Elimina',
    'LBL_APPLY_BUTTON' => 'Aplica',
    'LBL_SEND_INVITES' => 'Envia les invitacions',
    'LBL_CANCEL_BUTTON' => 'Cancel·la',
    'LBL_CLOSE_BUTTON' => 'Tanca',

    'LBL_GENERAL_TAB' => 'Detalls',
    'LBL_PARTICIPANTS_TAB' => 'Assistents',
    'LBL_REPEAT_TAB' => 'Repetició',

    'LBL_REPEAT_TYPE' => 'Repetir',
    'LBL_REPEAT_INTERVAL' => 'Cada',
    'LBL_REPEAT_END' => 'Últim',
    'LBL_REPEAT_END_AFTER' => 'Després de',
    'LBL_REPEAT_OCCURRENCES' => 'recurrències',
    'LBL_REPEAT_END_BY' => 'Per',
    'LBL_REPEAT_DOW' => 'En',
    'LBL_REPEAT_UNTIL' => 'Repetir fins',
    'LBL_REPEAT_COUNT' => 'Nombre de recurrències',
    'LBL_REPEAT_LIMIT_ERROR' => 'La sol·licitud hauria creat més de $limit reunions.',

    'LBL_EDIT_ALL_RECURRENCES' => 'Edita totes les recurrències',
    'LBL_REMOVE_ALL_RECURRENCES' => 'Elimina totes les recurrències',

    'LBL_DATE_END_ERROR' => "La data de finalització és anterior a la data d'inici.",
    'ERR_YEAR_BETWEEN' => "El calendari no permet l'any que heu introduït.<br>L'any ha d'estar entre 1970 i 2037.",
    'ERR_NEIGHBOR_DATE' => 'get_neighbor_date_str: no està definit en aquesta vista',
    'LBL_NO_ITEMS_MOBILE' => 'Aquesta setmana el vostre calendari està lliure.',
    'LBL_GENERAL_SETTINGS' => 'Configuracions generals',
    'LBL_COLOR_SETTINGS' => 'Configuració de color',
    'LBL_MODULE' => 'Mòdul',
    'LBL_BODY' => 'Cos',
    'LBL_BORDER' => 'Frontera',
    'LBL_TEXT' => 'Text',
);


$mod_list_strings = array(
    'dom_cal_weekdays' =>
        array(
            '0' => "dg.",
            '1' => "dl.",
            '2' => "dt.",
            '3' => "dc.",
            '4' => "dj.",
            '5' => "dv.",
            '6' => "ds.",
        ),
    'dom_cal_weekdays_long' =>
        array(
            '0' => "Diumenge",
            '1' => "Dilluns",
            '2' => "Dimarts",
            '3' => "Dimecres",
            '4' => "Dijous",
            '5' => "Divendres",
            '6' => "Dissabte",
        ),
    'dom_cal_month' =>
        array(
            '0' => "",
            '1' => "gen.",
            '2' => "feb.",
            '3' => "mar.",
            '4' => "abr.",
            '5' => "mai.",
            '6' => "jun.",
            '7' => "jul.",
            '8' => "ago.",
            '9' => "set.",
            '10' => "oct.",
            '11' => "nov.",
            '12' => "des.",
        ),
    'dom_cal_month_long' =>
        array(
            '0' => "",
            '1' => "Gener",
            '2' => "Febrer",
            '3' => "Març",
            '4' => "Abril",
            '5' => "Maig",
            '6' => "Juny",
            '7' => "Juliol",
            '8' => "Agost",
            '9' => "Setembre",
            '10' => "Octubre",
            '11' => "Novembre",
            '12' => "Desembre",
        ),
);
