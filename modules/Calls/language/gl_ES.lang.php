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
    'LBL_MODULE_NAME' => 'Chamadas',
    'LBL_MODULE_TITLE' => 'Chamadas: Inicio',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Chamadas',
    'LBL_LIST_FORM_TITLE' => 'Lista de Chamadas',
    'LBL_NEW_FORM_TITLE' => 'Crear Cita',
    'LBL_LIST_CLOSE' => 'Cerrar',
    'LBL_LIST_SUBJECT' => 'Asunto',
    'LBL_LIST_CONTACT' => 'Contacto',
    'LBL_LIST_RELATED_TO' => 'Relacionado con',
    'LBL_LIST_RELATED_TO_ID' => 'Relacionado con ID',
    'LBL_LIST_DATE' => 'Data Inicio',
    'LBL_LIST_DIRECTION' => 'Enderezo',
    'LBL_SUBJECT' => 'Asunto:',
    'LBL_REMINDER' => 'Aviso',
    'LBL_CONTACT_NAME' => 'Contacto:',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_STATUS' => 'Estado:',
    'LBL_DIRECTION' => 'Enderezo:',
    'LBL_DATE' => 'Data Inicio:',
    'LBL_DURATION' => 'Duración:',
    'LBL_DURATION_HOURS' => 'Duración (Horas):',
    'LBL_DURATION_MINUTES' => 'Duración (Minutos):',
    'LBL_HOURS_MINUTES' => '(horas/minutos)',
    'LBL_DATE_TIME' => 'Inicio:',
    'LBL_TIME' => 'Hora inicio:',
    'LBL_HOURS_ABBREV' => 'h',
    'LBL_MINSS_ABBREV' => 'm',
    'LNK_NEW_CALL' => 'Rexistrar Chamada',
    'LNK_NEW_MEETING' => 'Programar Reunión',
    'LNK_CALL_LIST' => 'Ver Chamadas',
    'LNK_IMPORT_CALLS' => 'Importar Chamadas',
    'ERR_DELETE_RECORD' => 'Debe especificar un número de rexistro a eliminar.',
    'LBL_INVITEE' => 'Participantes',
    'LBL_RELATED_TO' => 'Relacionado con',
    'LNK_NEW_APPOINTMENT' => 'Crear Cita',
    'LBL_SCHEDULING_FORM_TITLE' => 'Planificación',
    'LBL_ADD_INVITEE' => 'Engadir asistentes',
    'LBL_NAME' => 'Nome',
    'LBL_FIRST_NAME' => 'Nome',
    'LBL_LAST_NAME' => 'Apelidos',
    'LBL_EMAIL' => 'Email',
    'LBL_PHONE' => 'Teléfono',
    'LBL_REMINDER_POPUP' => 'Ventá emerxente',
    'LBL_REMINDER_EMAIL_ALL_INVITEES' => 'Enviar correo electrónico a todos os asistentes',
    'LBL_EMAIL_REMINDER' => 'Recordatorio por correo electrónico',
    'LBL_EMAIL_REMINDER_TIME' => 'Tempo de recordatorio por correo electrónico',
    'LBL_SEND_BUTTON_TITLE' => 'Gardar e Enviar Invitacións',
    'LBL_SEND_BUTTON_LABEL' => 'Enviar Invitacións',
    'LBL_DATE_END' => 'Data de Fin',
    'LBL_REMINDER_TIME' => 'Hora Aviso',
    'LBL_EMAIL_REMINDER_SENT' => 'Recordatorio por correo electrónico enviado',
    'LBL_SEARCH_BUTTON' => 'Buscar',
    'LBL_ADD_BUTTON' => 'Engadir',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Chamadas',
    'LNK_SELECT_ACCOUNT' => 'Seleccionar Conta',
    'LNK_NEW_ACCOUNT' => 'Nova Conta',
    'LNK_NEW_OPPORTUNITY' => 'Nova Oportunidade',
    'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciais',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
    'LBL_USERS_SUBPANEL_TITLE' => 'Usuarios',
    'LBL_OUTLOOK_ID' => 'ID Outlook',
    'LBL_MEMBER_OF' => 'Membro De',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Notas',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_LIST_MY_CALLS' => 'As Miñas Chamadas',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a',
    'LBL_ASSIGNED_TO_ID' => 'Usuario Asignado',
    'NOTICE_DURATION_TIME' => 'O tempo de duración debe ser maior que 0',
    'LBL_CALL_INFORMATION' => 'Visión Global', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_REMOVE' => 'Quitar',
    'LBL_ACCEPT_STATUS' => 'Aceptar estato',
    'LBL_ACCEPT_LINK' => 'Aceptar Link',

    // create invitee functionality
    'LBL_CREATE_INVITEE' => 'Crear unha invitación',
    'LBL_CREATE_CONTACT' => 'Novo Contacto',
    'LBL_CREATE_LEAD' => 'Novo Cliente Potencial',
    'LBL_CREATE_AND_ADD' => 'Crear e Engadir',
    'LBL_CANCEL_CREATE_INVITEE' => 'Cancelar',
    'LBL_EMPTY_SEARCH_RESULT' => 'Sentímolo, non se encontraron resultados. Por favor cree unha invitación abaixo.',
    'LBL_NO_ACCESS' => 'Non ten permisos para crear rexistros no módulo $module',

    'LBL_REPEAT_TYPE' => 'Repetición',
    'LBL_REPEAT_INTERVAL' => 'Intervalo de repetición',
    'LBL_REPEAT_DOW' => 'Repita o Dow',
    'LBL_REPEAT_UNTIL' => 'Repetir Ata',
    'LBL_REPEAT_COUNT' => 'Número de repeticións',
    'LBL_REPEAT_PARENT_ID' => 'Repita o ID principal',
    'LBL_RECURRING_SOURCE' => 'Fonte periódica',

    'LBL_SYNCED_RECURRING_MSG' => 'Esta convocatoria orixinouse noutro sistema e sincronizanse co SuiteCRM. Para realizar cambios, vaia á chamada orixinal no outro sistema. Os cambios realizados no outro sistema pódense sincronizar con este rexistro.',

    // for reminders
    'LBL_REMINDERS' => 'Recordatorios',
    'LBL_REMINDERS_ACTIONS' => 'Accións:',
    'LBL_REMINDERS_POPUP' => 'Ventá emerxente',
    'LBL_REMINDERS_EMAIL' => 'Enviar e-mail a asistentes',
    'LBL_REMINDERS_WHEN' => 'Cando:',
    'LBL_REMINDERS_REMOVE_REMINDER' => 'Eliminar recordatorio',
    'LBL_REMINDERS_ADD_ALL_INVITEES' => 'Engadir a todos os invitados',
    'LBL_REMINDERS_ADD_REMINDER' => 'Engadir recordatorio',

    'LBL_RESCHEDULE' => 'Replanificacións',
    'LBL_RESCHEDULE_COUNT' => 'Intentos de Chamada',
    'LBL_RESCHEDULE_DATE' => 'Data',
    'LBL_RESCHEDULE_REASON' => 'Razón',
    'LBL_RESCHEDULE_ERROR1' => 'Por favor seleccione unha data v&aacute;lida',
    'LBL_RESCHEDULE_ERROR2' => 'Por favor seleccione unha raz&oacute;n',
    'LBL_RESCHEDULE_PANEL' => 'Replanificacións',
    'LBL_RESCHEDULE_HISTORY' => 'Historial de Intentos de Chamada',
    'LBL_CANCEL' => 'Cancelar',
    'LBL_SAVE' => 'Gardar',

    'LBL_CALLS_RESCHEDULE' => 'Reprogramación de chamadas',
    'LBL_LIST_STATUS'=>'Estado',
    'LBL_LIST_DATE_MODIFIED'=>'Data de Modificación',
    'LBL_LIST_DUE_DATE'=>'Data de Vencemento',
);