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
    'LBL_ACCEPT_THIS' => '¿Aceptar?',
    'LBL_ADD_BUTTON' => 'Engadir',
    'LBL_ADD_INVITEE' => 'Engadir Asistentes',
    'LBL_CONTACT_NAME' => 'Contacto:',
    'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contactos',
    'LBL_CREATED_BY' => 'Creado por',
    'LBL_DATE_END' => 'Data Fin',
    'LBL_DATE_TIME' => 'Data e hora de inicio:',
    'LBL_DATE' => 'Data Inicio:',
    'LBL_DEFAULT_SUBPANEL_TITLE' => 'Reunións',
    'LBL_DESCRIPTION' => 'Descrición:',
    'LBL_DIRECTION' => 'Enderezo:',
    'LBL_DURATION_HOURS' => 'Duración (Horas):',
    'LBL_DURATION_MINUTES' => 'Duración (Minutos):',
    'LBL_DURATION' => 'Duración:',
    'LBL_EMAIL' => 'Email',
    'LBL_FIRST_NAME' => 'Nome',
    'LBL_HISTORY_SUBPANEL_TITLE' => 'Notas',
    'LBL_HOURS_ABBREV' => 'h',
    'LBL_HOURS_MINS' => '(horas/minutos)',
    'LBL_INVITEE' => 'Asistentes',
    'LBL_LAST_NAME' => 'Apelidos',
    'LBL_ASSIGNED_TO_NAME' => 'Asignado a:',
    'LBL_LIST_ASSIGNED_TO_NAME' => 'Usuario Asignado',
    'LBL_LIST_CLOSE' => 'Cerrado',
    'LBL_LIST_CONTACT' => 'Contacto',
    'LBL_LIST_DATE_MODIFIED' => 'Data de Modificación',
    'LBL_LIST_DATE' => 'Data Inicio',
    'LBL_LIST_DIRECTION' => 'Enderezo',
    'LBL_LIST_DUE_DATE' => 'Data de Vencemento',
    'LBL_LIST_FORM_TITLE' => 'Lista de Reunións',
    'LBL_LIST_MY_MEETINGS' => 'As Miñas Reunións',
    'LBL_LIST_RELATED_TO' => 'Relacionado con',
    'LBL_LIST_STATUS' => 'Estado',
    'LBL_LIST_SUBJECT' => 'Asunto',
    'LBL_LEADS_SUBPANEL_TITLE' => 'Clientes Potenciais',
    'LBL_LOCATION' => 'Lugar:',
    'LBL_MINSS_ABBREV' => 'm',
    'LBL_MODIFIED_BY' => 'Modificado por',
    'LBL_MODULE_NAME' => 'Reunións',
    'LBL_MODULE_TITLE' => 'Reunións: Inicio',
    'LBL_NAME' => 'Nome',
    'LBL_NEW_FORM_TITLE' => 'Crear Cita',
    'LBL_OUTLOOK_ID' => 'ID Outlook',
    'LBL_SEQUENCE' => 'Secuencia de actualización da reunión',
    'LBL_PHONE' => 'Teléfono',
    'LBL_REMINDER_TIME' => 'Hora Aviso',
    'LBL_EMAIL_REMINDER_SENT' => 'Recordatorio por correo electrónico enviado',
    'LBL_REMINDER' => 'Aviso:',
    'LBL_REMINDER_POPUP' => 'Ventá emerxente',
    'LBL_REMINDER_EMAIL_ALL_INVITEES' => 'Enviar correo electrónico a todos os asistentes',
    'LBL_EMAIL_REMINDER' => 'Eecordatorio por correo electrónico',
    'LBL_EMAIL_REMINDER_TIME' => 'Tempo de recordatorio por correo electrónico',
    'LBL_REMOVE' => 'Quitar',
    'LBL_SCHEDULING_FORM_TITLE' => 'Planificación',
    'LBL_SEARCH_BUTTON' => 'Busca',
    'LBL_SEARCH_FORM_TITLE' => 'Busca de Reunións',
    'LBL_SEND_BUTTON_LABEL' => 'Gardar e Enviar Invitacións',
    'LBL_SEND_BUTTON_TITLE' => 'Gardar e Enviar Invitacións',
    'LBL_STATUS' => 'Estado:',
    'LBL_TYPE' => 'Tipo de reunión',
    'LBL_PASSWORD' => 'Contrasinal da reunión',
    'LBL_URL' => 'Iniciar/Unirse á reunión',
    'LBL_HOST_URL' => 'Host URL',
    'LBL_DISPLAYED_URL' => 'Ver URL',
    'LBL_CREATOR' => 'Creador de reunións',
    'LBL_EXTERNALID' => 'ID App Externa',
    'LBL_SUBJECT' => 'Asunto:',
    'LBL_TIME' => 'Hora Inicio:',
    'LBL_USERS_SUBPANEL_TITLE' => 'Usuarios',
    'LBL_PARENT_TYPE' => 'Tipo de Pai',
    'LBL_PARENT_ID' => 'ID Pai',
    'LNK_MEETING_LIST' => 'Ver Reunións',
    'LNK_NEW_APPOINTMENT' => 'Crear Cita',
    'LNK_NEW_MEETING' => 'Programar Reunión',
    'LNK_IMPORT_MEETINGS' => 'Importar Reunións',

    'LBL_CREATED_USER' => 'Usuario Creado',
    'LBL_MODIFIED_USER' => 'Usuario Modificado',
    'NOTICE_DURATION_TIME' => 'O tempo de duración debe ser maior que 0',
    'LBL_MEETING_INFORMATION' => 'Visión Global', //Can be translated in all caps. This string will be used by SuiteP template menu actions
    'LBL_LIST_JOIN_MEETING' => 'Unirser á reunión',
    'LBL_ACCEPT_STATUS' => 'Aceptar estato',
    'LBL_ACCEPT_LINK' => 'Aceptar Link',
    // You are not invited to the meeting messages
    'LBL_EXTNOT_MAIN' => 'Non é capaz de unirse a esta reunión, porque vostede non é un asistente.',
    'LBL_EXTNOT_RECORD_LINK' => 'Ver reunión',

    //cannot start messages
    'LBL_EXTNOSTART_MAIN' => 'Non se pode iniciar esta reunión, xa que non é un administrador ou o dueño da reunión.',

    // create invitee functionallity
    'LBL_CREATE_INVITEE' => 'Crear unha invitación',
    'LBL_CREATE_CONTACT' => 'Novo Contacto',  // Create invitee functionallity
    'LBL_CREATE_LEAD' => 'Novo Cliente Potencial', // Create invitee functionallity
    'LBL_CREATE_AND_ADD' => 'Crear e Engadir', // Create invitee functionallity
    'LBL_CANCEL_CREATE_INVITEE' => 'Cancelar',
    'LBL_EMPTY_SEARCH_RESULT' => 'Sentímolo, non se encontraron resultados. Por favor cree un asistente abaixo.',
    'LBL_NO_ACCESS' => 'Non ten permisos para crear rexistros no módulo $module',  // Create invitee functionallity

    'LBL_REPEAT_TYPE' => 'Repetición',
    'LBL_REPEAT_INTERVAL' => 'Intervalo de repetición',
    'LBL_REPEAT_DOW' => 'Repita o Dow',
    'LBL_REPEAT_UNTIL' => 'Repetir ata',
    'LBL_REPEAT_COUNT' => 'Número de repeticións',
    'LBL_REPEAT_PARENT_ID' => 'Repita o ID principal',
    'LBL_RECURRING_SOURCE' => 'Fonte periódica',

    'LBL_SYNCED_RECURRING_MSG' => 'Esta convocatoria orixinouse noutro sistema e sincronízanse co SuiteCRM. Para realizar cambios, vaia á reunión orixinal no outro sistema. Os cambios realizados no outro sistema pódense sincronizar con este rexistro.',
    'LBL_RELATED_TO' => 'Relacionado con:',

    // for reminders
    'LBL_REMINDERS' => 'Recordatorios',
    'LBL_REMINDERS_ACTIONS' => 'Accións:',
    'LBL_REMINDERS_POPUP' => 'Ventá emerxente',
    'LBL_REMINDERS_EMAIL' => 'Enviar correo electrónico a todos os asistentes',
    'LBL_REMINDERS_WHEN' => 'Cando:',
    'LBL_REMINDERS_REMOVE_REMINDER' => 'Eliminar recordatorio',
    'LBL_REMINDERS_ADD_ALL_INVITEES' => 'Engadir a todos os invitados',
    'LBL_REMINDERS_ADD_REMINDER' => 'Engadir recordatorio',

    // for google sync
    'LBL_GSYNC_ID' => 'ID de evento de Google',
    'LBL_GSYNC_LASTSYNC' => 'Última marca de tempo de Google Sync',
);
