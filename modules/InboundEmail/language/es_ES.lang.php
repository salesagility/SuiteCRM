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


    'LBL_RE' => 'RE:',

    'ERR_BAD_LOGIN_PASSWORD' => 'Usuario o contraseña incorrecta',
    'ERR_INI_ZLIB' => 'No pudo deshabilitarse la compresión Zlib temporalmente.  Puede que "Comprobar Configuración" falle.',
    'ERR_NO_IMAP' => 'No se han encontrado las librerías de IMAP.  Por favor, resuelva esto antes de continuar con la configuración de correo entrante',
    'ERR_NO_OPTS_SAVED' => 'No se han guardado valores óptimos con su cuenta de correo entrante.  Por favor, revise la configuración',
    'ERR_TEST_MAILBOX' => 'Por favor, compruebe su configuración e inténtelo de nuevo.',

    'LBL_ASSIGN_TO_USER' => 'Asignar a Usuario',
    'LBL_AUTOREPLY' => 'Plantilla de Respuesta Automática',
    'LBL_AUTOREPLY_HELP' => 'Seleccione una respuesta automática para notificar a los remitentes de correo que su respuesta ha sido recibida.',
    'LBL_BASIC' => 'Información de la Cuenta de Correo',
    'LBL_CASE_MACRO' => 'Macro de Casos',
    'LBL_CASE_MACRO_DESC' => 'Establece la macro que será analizada y utilizada para vincular el email importado a un Caso.',
    'LBL_CASE_MACRO_DESC2' => 'Establezca ésto a cualquier valor que desee, pero preserve el <b>"%1"</b>.',
    'LBL_CLOSE_POPUP' => 'Cerrar Ventana',
    'LBL_CREATE_TEMPLATE' => 'Crear',
    'LBL_DELETE_SEEN' => 'Eliminar Emails Leídos Tras Importación',
    'LBL_EDIT_TEMPLATE' => 'Editar',
    'LBL_EMAIL_OPTIONS' => 'Opciones de Gestión de Correo',
    'LBL_EMAIL_BOUNCE_OPTIONS' => 'Opciones de Gestión de Rebotes',
    'LBL_FILTER_DOMAIN_DESC' => 'Especificar un dominio al cual no se enviarán respuestas automáticas.',
    'LBL_ASSIGN_TO_GROUP_FOLDER_DESC' => 'Seleccione esta opción para se creen automáticamente registros de correo en SuiteCRM para todos los correos entrantes.',
    'LBL_FILTER_DOMAIN' => 'No enviar Respuestas Automáticas a este Dominio',
    'LBL_FIND_SSL_WARN' => '<br>La comprobación de SSL puede durar bastante tiempo.  Por favor, tenga paciencia.<br>',
    'LBL_FROM_ADDR' => 'Dirección del Remitente',
    'LBL_FROM_ADDR_DESC' => 'La dirección de correo electrónico puesta aquí no aparezca en el campo "De" dirección del correo electrónico del remitente debido a las restricciones impuestas por el proveedor de servicios de correo electrónico. En estas circunstancias, la dirección de correo electrónico que se define es la del servidor de correo saliente que esta configurado.',
    'LBL_FROM_NAME' => 'Nombre del remitente',
    'LBL_GROUP_QUEUE' => 'Asignar a Grupo',
    'LBL_HOME' => 'Inicio',
    'LBL_LIST_MAILBOX_TYPE' => 'Utilización de la Cuenta de Correo',
    'LBL_LIST_NAME' => 'Nombre:',
    'LBL_LIST_GLOBAL_PERSONAL' => 'Tipo',
    'LBL_LIST_SERVER_URL' => 'Servidor de Correo',
    'LBL_LIST_STATUS' => 'Estado',
    'LBL_LOGIN' => 'Nombre de Usuario',
    'LBL_MAILBOX_DEFAULT' => 'BANDEJA DE ENTRADA',
    'LBL_MAILBOX_SSL' => 'Usar SSL',
    'LBL_MAILBOX_TYPE' => 'Acciones Posibles',
    'LBL_DISTRIBUTION_METHOD' => 'Método de Distribución',
    'LBL_CREATE_CASE_REPLY_TEMPLATE' => 'Nueva Plantilla de Respuesta Automática para Caso',
    'LBL_CREATE_CASE_REPLY_TEMPLATE_HELP' => 'Seleccione una respuesta automática para notificar a los remitentes de correo que se ha creado un nuevo caso. El correo contiene el número de caso en la línea de Asunto acorde con la configuración de la Macro de Caso.  Esta respuesta sólo se enviará cuando se reciba el primer correo de un remitente.',
    'LBL_MAILBOX' => 'Carpetas Monitorizadas',
    'LBL_TRASH_FOLDER' => 'Papelera',
    'LBL_SENT_FOLDER' => 'Elementos Enviados',
    'LBL_SELECT' => 'Seleccionar',
    'LBL_MARK_READ_NO' => 'Email marcado como borrado tras importación',
    'LBL_MARK_READ_YES' => 'Email dejado en el servidor tras importación',
    'LBL_MARK_READ' => 'Dejar mensajes en el servidor',
    'LBL_MAX_AUTO_REPLIES' => 'Número de respuestas automáticas',
    'LBL_MAX_AUTO_REPLIES_DESC' => 'Establece el máximo número de respuestas automáticas a enviar a una única dirección de correo durante un período de 24 horas.',
    'LBL_PERSONAL_MODULE_NAME' => 'Cuenta de Correo Personal',
    'LBL_CREATE_CASE' => 'Crear Caso desde Correo',
    'LBL_CREATE_CASE_HELP' => 'Seleccione esta opción para crear automáticamente registros de casos en SuiteCRM a partir de correos entrantes.',
    'LBL_MODULE_NAME' => 'Cuenta de Correo de Grupo',
    'LBL_BOUNCE_MODULE_NAME' => 'Bandeja de Gestión de Correo Rebotado',
    'LBL_MODULE_TITLE' => 'Correo Entrante',
    'LBL_NAME' => 'Nombre',
    'LBL_NONE' => 'Ninguno',
    'LBL_ONLY_SINCE_NO' => 'No. Comprobar contra todos los correos en el servidor de correo.',
    'LBL_ONLY_SINCE_YES' => 'Sí.',
    'LBL_PASSWORD' => 'Contraseña',
    'LBL_POP3_SUCCESS' => 'Su prueba de conexión de POP3 tuvo éxito.',
    'LBL_POPUP_TITLE' => 'Comprobar Configuración',
    'LBL_SELECT_SUBSCRIBED_FOLDERS' => 'Seleccionar Carpetas Suscritas',
    'LBL_SELECT_TRASH_FOLDERS' => 'Seleccionar Papelera',
    'LBL_SELECT_SENT_FOLDERS' => 'Seleccionar Carpeta de Elementos Enviados',
    'LBL_DELETED_FOLDERS_LIST' => 'Las siguientes carpetas %s o no existen o han sido eliminadas del servidor',
    'LBL_PORT' => 'Puerto del Servidor de Correo',
    'LBL_REPLY_TO_NAME' => 'Nombre de "Responder A"',
    'LBL_REPLY_TO_ADDR' => 'Dirección de "Responder A"',
    'LBL_SAME_AS_ABOVE' => 'Usando el mismo Nombre/Dirección',
    'LBL_SERVER_OPTIONS' => 'Configuración Avanzada',
    'LBL_SERVER_TYPE' => 'Protocolo del Servidor de Correo',
    'LBL_SERVER_URL' => 'Dirección del Servidor de Correo',
    'LBL_SSL_DESC' => 'Si su servidor de correo soporta conexiones seguras de sockets (SSL), habilitar esta opción forzará conexiones SSL al importar el correo.',
    'LBL_ASSIGN_TO_TEAM_DESC' => 'El equipo seleccionado tiene acceso a la cuenta de correo.',
    'LBL_SSL' => 'Usar SSL',
    'LBL_STATUS' => 'Estado',
    'LBL_SYSTEM_DEFAULT' => 'Por Defecto en el Sistema',
    'LBL_TEST_BUTTON_TITLE' => 'Probar',
    'LBL_TEST_SETTINGS' => 'Probar Configuración',
    'LBL_TEST_SUCCESSFUL' => 'Conexión completada con éxito.',
    'LBL_TEST_WAIT_MESSAGE' => 'Un momento, por favor...',
    'LBL_WARN_IMAP_TITLE' => 'Correo Entrante Deshabilitado',
    'LBL_WARN_IMAP' => 'Avisos:',
    'LBL_WARN_NO_IMAP' => 'El Correo Entrante <b>no puede</b> funcionar sin las librerías de C del cliente de IMAP habilitadas/compiladas en el módulo de PHP.  Por favor, contacte con su administrador para resolver este problema.',

    'LNK_LIST_CREATE_NEW_GROUP' => 'Nueva Cuenta de Correo de Grupo',
    'LNK_LIST_CREATE_NEW_BOUNCE' => 'Nueva Cuenta de Gestión de Rebotes',
    'LNK_LIST_MAILBOXES' => 'Todas las Cuentas de Correo',
    'LNK_LIST_SCHEDULER' => 'Planificadores',
    'LNK_SEED_QUEUES' => 'Crear Cabeza de Serie para Colas de Equipos',
    'LBL_GROUPFOLDER_ID' => 'Id de Carpeta de Grupo',

    'LBL_ALLOW_OUTBOUND_GROUP_USAGE' => 'Permitir que los usuarios envíen correo usando el Nombre y la Dirección del campo "De" como dirección de respuesta',
    'LBL_ALLOW_OUTBOUND_GROUP_USAGE_DESC' => 'Cuando se selecciona esta opción, el Nombre y Dirección del remitente asociados a la cuenta de correo de este grupo aparecerán como una opción para el campo "De" al escribir un correo para los usuarios que tengan acceso a la cuenta de correo del grupo.',
    'LBL_STATUS_ACTIVE' => 'Activo',
    'LBL_STATUS_INACTIVE' => 'Inactivo',
    'LBL_IS_PERSONAL' => 'Personal',
    'LBL_IS_GROUP' => 'grupo',
    'LBL_ENABLE_AUTO_IMPORT' => 'Importar Correos Automáticamente',
    'LBL_WARNING_CHANGING_AUTO_IMPORT' => 'Aviso: Está modificando su configuración de importación automática lo cual puede provocar pérdida de datos.',
    'LBL_WARNING_CHANGING_AUTO_IMPORT_WITH_CREATE_CASE' => 'Aviso: La importación automática debe estar habilitada para la creación automática de casos.',
    'LBL_LIST_TITLE_MY_DRAFTS' => 'Borradores',
    'LBL_LIST_TITLE_MY_INBOX' => 'Bandeja de entrada',
    'LBL_LIST_TITLE_MY_SENT' => 'Email Enviado',
    'LBL_LIST_TITLE_MY_ARCHIVES' => 'Emails Archivados',
    'LNK_MY_DRAFTS' => 'Borradores',
    'LNK_MY_INBOX' => 'Email',
    'LNK_VIEW_MY_INBOX' => 'Ver Email',
    'LNK_QUICK_REPLY' => 'Responder',
    'LNK_SENT_EMAIL_LIST' => 'Emails Enviados',
    'LBL_EDIT_LAYOUT' => 'Editar diseño' /*for 508 compliance fix*/,

    'LBL_MODIFIED_BY' => 'Modificado Por',
    'LBL_SERVICE' => 'Servicio',
    'LBL_STORED_OPTIONS' => 'Opciones Almacenadas',
    'LBL_GROUP_ID' => 'Grupo ID',
    'LBL_REPLY_ASSIGNING_BEHAVIOR' => 'Asignar respuestas a', // PR 6009
    'LBL_REPLY_ASSIGNING_BEHAVIOR_HELP' => 'Cuando un correo electrónico entrante es una respuesta a un correo electrónico enviado desde SuiteCRM, ¿a quién se asigna la respuesta a: <br> <br> <b> no hacer nada: </b> el comportamiento predeterminado. El correo electrónico no está asignado a nadie. <br> <br> <b> respondió al propietario del correo electrónico: </b> el correo electrónico está asignado al propietario de la respuesta al correo electrónico, o el último correo electrónico enviado desde SuiteCRM en el hilo. <br> <br> <b> propietario de registro asociado: </b> el correo electrónico se asigna al propietario del registro que el correo electrónico contestado, o el último correo electrónico enviado desde SuiteCRM en el subproceso, está relacionado con.', // PR 6009

    'LBL_CREATE_CONTACT' => 'Crear contacto desde correo electrónico', // PR 5721
    'LBL_CREATE_CONTACT_HELP' => 'Seleccione para crear automáticamente un registro de contacto en SuiteCRM desde los correos entrantes.', // PR 5721
    'LBL_CONTACT_DEFAULT_LANGUAGE' => 'Idioma de contacto predeterminado', // PR 5721
    'LBL_FILL_CONTACT_NAME' => 'Rellenar el nombre del contacto', // PR 5721 - Escaped required
    'LBL_FILL_CONTACT_NAME_HELP' => 'Seleccione para rellenar automáticamente el nombre y apellido del nuevo contacto, creado desde los correos entrantes.', // PR 5721
    'LBL_CONTACT_DEFAULT_SOURCE' => 'Nueva fuente de contacto', // PR 5721
    'LBL_NEW_CASE_STATUS' => 'Estado del caso creado', // PR 5721
    'LBL_NEW_CASE_PRIORITY' => 'Prioridad del caso creado', // PR 5721
    'LBL_NEW_CASE_TYPE' => 'Tipo para el caso creado', // PR 5721
);