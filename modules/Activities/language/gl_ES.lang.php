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
    'LBL_MODULE_NAME' => 'Actividades',
    'LBL_MODULE_TITLE' => 'Actividades: Inicio',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Actividades',
    'LBL_LIST_FORM_TITLE' => 'Lista de Actividades',
    'LBL_LIST_SUBJECT' => 'Asunto',
    'LBL_OVERVIEW' => 'Visión Global',
    'LBL_TASKS' => 'Tarefas',
    'LBL_MEETINGS' => 'Reunións',
    'LBL_CALLS' => 'Chamadas',
    'LBL_EMAILS' => 'Correos',
    'LBL_NOTES' => 'Notas',
    'LBL_PRINT' => 'Imprenta',
    'LBL_MEETING_TYPE' => 'Reunión',
    'LBL_CALL_TYPE' => 'Chamada',
    'LBL_EMAIL_TYPE' => 'Email',
    'LBL_NOTE_TYPE' => 'Nota',
    'LBL_DATA_TYPE_START' => 'Inicio:',
    'LBL_DATA_TYPE_SENT' => 'Enviado:',
    'LBL_DATA_TYPE_MODIFIED' => 'Modificado:',
    'LBL_LIST_CONTACT' => 'Contacto',
    'LBL_LIST_RELATED_TO' => 'Relacionado con',
    'LBL_LIST_DATE' => 'Data',
    'LBL_LIST_CLOSE' => 'Cerrar',
    'LBL_SUBJECT' => 'Asunto:',
    'LBL_STATUS' => 'Estado:',
    'LBL_LOCATION' => 'Lugar:',
    'LBL_DATE_TIME' => 'Data e hora de inicio:',
    'LBL_DATE' => 'Data de inicio:',
    'LBL_TIME' => 'Hora de inicio:',
    'LBL_DURATION' => 'Duración:',
    'LBL_HOURS_MINS' => '(horas/minutos)',
    'LBL_CONTACT_NAME' => 'Nome de contacto: ',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LNK_NEW_CALL' => 'Rexistrar Chamada',
    'LNK_NEW_MEETING' => 'Programar Reunión',
    'LNK_NEW_TASK' => 'Nova Tarefa',
    'LNK_NEW_NOTE' => 'Nova Nota ou Adxunto',
    'LNK_NEW_EMAIL' => 'Novo Email Arquivado',
    'LNK_CALL_LIST' => 'Ver Chamadas',
    'LNK_MEETING_LIST' => 'Ver Reunións',
    'LNK_TASK_LIST' => 'Ver Tarefas',
    'LNK_NOTE_LIST' => 'Ver Notas',
    'LBL_DELETE_ACTIVITY' => '¿Está seguro de que desexa eliminar esta actividade?',
    'ERR_DELETE_RECORD' => 'Debe especificar un número de rexistro para eliminar a conta.',
    'LBL_INVITEE' => 'Asistentes',
    'LBL_LIST_DIRECTION' => 'Enderezo',
    'LBL_DIRECTION' => 'Enderezo',
    'LNK_NEW_APPOINTMENT' => 'Nova Cita',
    'LNK_VIEW_CALENDAR' => 'Ver Calendario',
    'LBL_OPEN_ACTIVITIES' => 'Actividades Abertas',
    'LBL_HISTORY' => 'Historial',
    'LBL_NEW_TASK_BUTTON_TITLE' => 'Nova Tarefa',
    'LBL_NEW_TASK_BUTTON_LABEL' => 'Nova Tarefa',
    'LBL_SCHEDULE_MEETING_BUTTON_TITLE' => 'Programar Reunión',
    'LBL_SCHEDULE_MEETING_BUTTON_LABEL' => 'Programar Reunión',
    'LBL_SCHEDULE_CALL_BUTTON_LABEL' => 'Rexistrar Chamada',
    'LBL_NEW_NOTE_BUTTON_TITLE' => 'Nova Nota ou Arquivo Adxunto',
    'LBL_NEW_NOTE_BUTTON_LABEL' => 'Nova Nota ou Arquivo Adxunto',
    'LBL_TRACK_EMAIL_BUTTON_TITLE' => 'Arquivar Email',
    'LBL_TRACK_EMAIL_BUTTON_LABEL' => 'Arquivar Email',
    'LBL_LIST_STATUS' => 'Estado',
    'LBL_LIST_DUE_DATE' => 'Data Vencemento',
    'LBL_LIST_LAST_MODIFIED' => 'Última Modificación',
    'LNK_IMPORT_CALLS' => 'Importar Chamadas',
    'LNK_IMPORT_MEETINGS' => 'Importar Reunións',
    'LNK_IMPORT_TASKS' => 'Importar Tarefas',
    'LNK_IMPORT_NOTES' => 'Importar Notas',
    'LBL_ACCEPT_THIS' => '¿Aceptar?',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Actividades Abertas',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',

    'LBL_ACCEPT' => 'Aceptar' /*for 508 compliance fix*/,
);
