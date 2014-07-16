<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:  Defines the Spanish language pack for the base application.
 * Portions created by REDK Ingeniería del Software S.L..
 * All Rights Reserved.
 * Contributor(s): REDK Software Engineering (www.redk.net)
 ********************************************************************************/
 
$mod_strings = array (
  'LBL_RE' => 'RE:',
  'ERR_BAD_LOGIN_PASSWORD' => 'Usuario o contraseña incorrecta',
  'ERR_BODY_TOO_LONG' => '\\rEl texto del cuerpo es demasiado largo para capturar el email COMPLETO. Truncado.',
  'ERR_INI_ZLIB' => 'No pudo deshabilitarse la compresión Zlib temporalmente.  Puede que "Comprobar Configuración" falle.',
  'ERR_MAILBOX_FAIL' => 'No se pudo recuperar ninguna cuenta de correo.',
  'ERR_NO_IMAP' => 'No se han encontrado las librerías de IMAP.  Por favor, resuelva esto antes de continuar con la configuración de correo entrante',
  'ERR_NO_OPTS_SAVED' => 'No se han guardado valores óptimos con su cuenta de correo entrante.  Por favor, revise la configuración',
  'ERR_TEST_MAILBOX' => 'Por favor, compruebe su configuración e inténtelo de nuevo.',
  'LBL_APPLY_OPTIMUMS' => 'Aplicar Valores Óptimos',
  'LBL_ASSIGN_TO_USER' => 'Asignar a Usuario',
  'LBL_AUTOREPLY_OPTIONS' => 'Opciones de Respuesta Automática',
  'LBL_AUTOREPLY' => 'Plantilla de Respuesta Automática',
  'LBL_AUTOREPLY_HELP' => 'Seleccione una respuesta automática para notificar a los remitentes de correo que su respuesta ha sido recibida.',
  'LBL_BASIC' => 'Información de la Cuenta de Correo',
  'LBL_CASE_MACRO' => 'Macro de Casos',
  'LBL_CASE_MACRO_DESC' => 'Establece la macro que será analizada y utilizada para vincular el email importado a un Caso.',
  'LBL_CASE_MACRO_DESC2' => 'Establezca ésto a cualquier valor que desee, pero preserve el <b>"%1"</b>.',
  'LBL_CERT_DESC' => 'Fozar la validación del Certificado de Seguridad del servidor - no utilizar en certificados no firmados por una autoridad raíz reconocida.',
  'LBL_CERT' => 'Validar Certificado',
  'LBL_CLOSE_POPUP' => 'Cerrar Ventana',
  'LBL_CREATE_NEW_GROUP' => '--Crear Grupo al Guardar--',
  'LBL_CREATE_TEMPLATE' => 'Crear',
  'LBL_SUBSCRIBE_FOLDERS' => 'Suscribirse a Carpetas',
  'LBL_DEFAULT_FROM_ADDR' => 'Por defecto:',
  'LBL_DEFAULT_FROM_NAME' => 'Por defecto:',
  'LBL_DELETE_SEEN' => 'Eliminar Emails Leídos Tras Importación',
  'LBL_EDIT_TEMPLATE' => 'Editar',
  'LBL_EMAIL_OPTIONS' => 'Opciones de Gestión de Correo',
  'LBL_EMAIL_BOUNCE_OPTIONS' => 'Opciones de Gestión de Rebotes',
  'LBL_FILTER_DOMAIN_DESC' => 'Especificar un dominio al cual no se enviarán respuestas automáticas.',
  'LBL_ASSIGN_TO_GROUP_FOLDER_DESC' => 'Seleccione esta opción para se creen automáticamente registros de correo en Sugar para todos los correos entrantes.',
  'LBL_POSSIBLE_ACTION_DESC' => 'Para usar la opción Nuevo Caso, debe seleccionar una Carpeta de Grupo',
  'LBL_FILTER_DOMAIN' => 'No enviar Respuestas Automáticas a este Dominio',
  'LBL_FIND_OPTIMUM_KEY' => 'f',
  'LBL_FIND_OPTIMUM_MSG' => '<br>Buscando variables óptimas de conexión.',
  'LBL_FIND_OPTIMUM_TITLE' => 'Buscar Configuración Óptima',
  'LBL_FIND_SSL_WARN' => '<br>La comprobación de SSL puede durar bastante tiempo.  Por favor, tenga paciencia.<br>',
  'LBL_FORCE_DESC' => 'Algunos servidores IMAP/POP3 requieren opciones especiales. Marque para forzar una opción negativa al conectar (ej., /notls)',
  'LBL_FORCE' => 'Forzar Negativo',
  'LBL_FOUND_MAILBOXES' => 'Se han encontrado las siguientes carpetas utilizables.<br>Haga clic en una para seleccionarla:',
  'LBL_FOUND_OPTIMUM_MSG' => '<br>Opciones óptimas encontradas.	Presiones el siguiente botón para aplicarlas a su cuenta de correo.',
  'LBL_FROM_ADDR' => 'Dirección del remitente',
  'LBL_FROM_ADDR_DESC' => 'La dirección de correo electrónico puesta aquí no aparezca en el campo &#39;De&#39; dirección del correo electrónico del remitente debido a las restricciones impuestas por el proveedor de servicios de correo electrónico. En estas circunstancias, la dirección de correo electrónico que se define es la del servidor de correo saliente que esta configurado.',
  'LBL_FROM_NAME_ADDR' => 'Nombre/Correo del Remitente',
  'LBL_FROM_NAME' => 'Nombre del remitente',
  'LBL_GROUP_QUEUE' => 'Asignar a Grupo',
  'LBL_HOME' => 'Inicio',
  'LBL_LIST_MAILBOX_TYPE' => 'Utilización de la Cuenta de Correo',
  'LBL_LIST_NAME' => 'Nombre:',
  'LBL_LIST_GLOBAL_PERSONAL' => 'Tipo',
  'LBL_LIST_SERVER_URL' => 'Servidor de Correo',
  'LBL_LIST_STATUS' => 'Estado',
  'LBL_LOGIN' => 'Nombre de Usuario',
  'LBL_MAILBOX_DEFAULT' => 'INBOX',
  'LBL_MAILBOX_SSL_DESC' => 'Usar SSL en la conexión. Si no funciona, compruebe que su instalación de PHP incluye "--with-imap-ssl" en la configuración.',
  'LBL_MAILBOX_SSL' => 'Usar SSL',
  'LBL_MAILBOX_TYPE' => 'Acciones Posibles',
  'LBL_DISTRIBUTION_METHOD' => 'Método de Distribución',
  'LBL_CREATE_CASE_REPLY_TEMPLATE' => 'Nueva Plantilla de Respuesta Automática para Caso',
  'LBL_CREATE_CASE_REPLY_TEMPLATE_HELP' => 'Seleccione una respuesta automática para notificar a los remitentes de correo que se ha creado un nuevo caso. El correo contiene el número de caso en la línea de Asunto acorde con la configuración de la Macro de Caso.  Esta respuesta sólo se enviará cuando se reciba el primer correo de un remitente.',
  'LBL_MAILBOX' => 'Carpetas Monitorizadas',
  'LBL_TRASH_FOLDER' => 'Papelera',
  'LBL_GET_TRASH_FOLDER' => 'Obtener Papelera',
  'LBL_SENT_FOLDER' => 'Elementos Enviados',
  'LBL_GET_SENT_FOLDER' => 'Obtener Elementos Eliminados',
  'LBL_SELECT' => 'Seleccionar',
  'LBL_MARK_READ_DESC' => 'Importar y marcar mensajes como leídos en el servidor de correo; no borrar.',
  'LBL_MARK_READ_NO' => 'Email marcado como borrado tras importación',
  'LBL_MARK_READ_YES' => 'Email dejado en el servidor tras importación',
  'LBL_MARK_READ' => 'Dejar mensajes en el servidor',
  'LBL_MAX_AUTO_REPLIES' => 'Número de respuestas automáticas',
  'LBL_MAX_AUTO_REPLIES_DESC' => 'Establece el máximo número de respuestas automáticas a enviar a una única dirección de correo durante un período de 24 horas.',
  'LBL_PERSONAL_MODULE_NAME' => 'Cuenta de Correo Personal',
  'LBL_CREATE_CASE' => 'Crear Caso desde Correo',
  'LBL_CREATE_CASE_HELP' => 'Seleccione esta opción para crear automáticamente registros de casos en Sugar a partir de correos entrantes.',
  'LBL_MODULE_NAME' => 'Cuenta de Correo de Grupo',
  'LBL_BOUNCE_MODULE_NAME' => 'Bandeja de Gestión de Correo Rebotado',
  'LBL_MODULE_TITLE' => 'Correo Entrante',
  'LBL_NAME' => 'Nombre',
  'LBL_NONE' => 'Ninguno',
  'LBL_NO_OPTIMUMS' => 'No se han encontrado valores óptimos.  Por favor, compruebe su configuración e inténtelo de nuevo.',
  'LBL_ONLY_SINCE_DESC' => 'Al usar POP3, PHP no se pueden realizar filtros en mesajes Nuevos/No leídos.  Esta opción permite que se soliciten mensajes desde la última vez que la bandeja fue consultada.  Esto mejorará significativamente el rendimiento si su servidor de correo no soporta IMAP.',
  'LBL_ONLY_SINCE_NO' => 'No. Comprobar contra todos los correos en el servidor de correo.',
  'LBL_ONLY_SINCE_YES' => 'Sí.',
  'LBL_ONLY_SINCE' => 'Importar sólo desde la última comprobación',
  'LBL_OUTBOUND_SERVER' => 'Servidor de Correo Saliente',
  'LBL_PASSWORD_CHECK' => 'Comprobar Contraseña',
  'LBL_PASSWORD' => 'Contraseña',
  'LBL_POP3_SUCCESS' => 'Su prueba de conexión de POP3 tuvo éxito.',
  'LBL_POPUP_FAILURE' => 'Prueba de conexión fallida. El error es el siguiente:',
  'LBL_POPUP_SUCCESS' => 'Prueba de conexión exitosa.  Su configuración funciona.',
  'LBL_POPUP_TITLE' => 'Comprobar Configuración',
  'LBL_GETTING_FOLDERS_LIST' => 'Obteniendo Lista de Carpetas',
  'LBL_SELECT_SUBSCRIBED_FOLDERS' => 'Seleccionar Carpetas Suscritas',
  'LBL_SELECT_TRASH_FOLDERS' => 'Seleccionar Papelera',
  'LBL_SELECT_SENT_FOLDERS' => 'Seleccionar Carpeta de Elementos Enviados',
  'LBL_DELETED_FOLDERS_LIST' => 'Las siguientes carpetas %s o no existen o han sido eliminadas del servidor',
  'LBL_PORT' => 'Puerto del Servidor de Correo',
  'LBL_QUEUE' => 'Cola de la Cuenta de Correo',
  'LBL_REPLY_NAME_ADDR' => 'Responder a Nombre/Correo',
  'LBL_REPLY_TO_NAME' => 'Nombre de "Responder A"',
  'LBL_REPLY_TO_ADDR' => 'Dirección de "Responder A"',
  'LBL_SAME_AS_ABOVE' => 'Usando el mismo Nombre/Dirección',
  'LBL_SAVE_RAW' => 'Guardar Código Fuente Original',
  'LBL_SAVE_RAW_DESC_1' => 'Seleccione "Sí" si quiere preservar el código fuente original para cada email importado.',
  'LBL_SAVE_RAW_DESC_2' => 'Los archivos adjuntos grandes pueden producir erroror en bases de datos configuradas de forma restringida o incorrecta.',
  'LBL_SERVER_OPTIONS' => 'Configuración Avanzada',
  'LBL_SERVER_TYPE' => 'Protocolo del Servidor de Correo',
  'LBL_SERVER_URL' => 'Dirección del Servidor de Correo',
  'LBL_SSL_DESC' => 'Si su servidor de correo soporta conexiones seguras de sockets (SSL), habilitar esta opción forzará conexiones SSL al importar el correo.',
  'LBL_ASSIGN_TO_TEAM_DESC' => 'El equipo seleccionado tiene acceso a la cuenta de correo.',
  'LBL_SSL' => 'Usar SSL',
  'LBL_STATUS' => 'Estado',
  'LBL_SYSTEM_DEFAULT' => 'Por Defecto en el Sistema',
  'LBL_TEST_BUTTON_KEY' => 't',
  'LBL_TEST_BUTTON_TITLE' => 'Probar [Alt+T]',
  'LBL_TEST_SETTINGS' => 'Probar Configuración',
  'LBL_TEST_SUCCESSFUL' => 'Conexión completada con éxito.',
  'LBL_TEST_WAIT_MESSAGE' => 'Un momento, por favor...',
  'LBL_TLS_DESC' => 'Usar Transport Layer Security para conectarse al servidor de correo - sólo use ésto si su servidor de correo soporta este protocolo.',
  'LBL_TLS' => 'Usar TLS',
  'LBL_WARN_IMAP_TITLE' => 'Correo Entrante Deshabilitado',
  'LBL_WARN_IMAP' => 'Avisos:',
  'LBL_WARN_NO_IMAP' => 'El Correo Entrante <b>no puede</b> funcionar sin las librerías de C del cliente de IMAP habilitadas/compiladas en el módulo de PHP.  Por favor, contacte con su administrador para resolver este problema.',
  'LNK_CREATE_GROUP' => 'Crear Nuevo Grupo',
  'LNK_LIST_CREATE_NEW_GROUP' => 'Nueva Cuenta de Correo de Grupo',
  'LNK_LIST_CREATE_NEW_BOUNCE' => 'Nueva Cuenta de Gestión de Rebotes',
  'LNK_LIST_MAILBOXES' => 'Todas las Cuentas de Correo',
  'LNK_LIST_QUEUES' => 'Todas las Colas',
  'LNK_LIST_SCHEDULER' => 'Planificadores',
  'LNK_LIST_TEST_IMPORT' => 'Probar Importación de Correo',
  'LNK_NEW_QUEUES' => 'Crear Nueva Cola',
  'LNK_SEED_QUEUES' => 'Crear Cabeza de Serie para Colas de Equipos',
  'LBL_IS_PERSONAL' => 'personal',
  'LBL_GROUPFOLDER_ID' => 'Id de Carpeta de Grupo',
  'LBL_ASSIGN_TO_GROUP_FOLDER' => 'Asignar a Carpeta de Grupo',
  'LBL_ALLOW_OUTBOUND_GROUP_USAGE' => 'Permitir que los usuarios envíen correo usando el Nombre y la Dirección del campo "De" como dirección de respuesta',
  'LBL_ALLOW_OUTBOUND_GROUP_USAGE_DESC' => 'Cuando se selecciona esta opción, el Nombre y Dirección del remitente asociados a la cuenta de correo de este grupo aparecerán como una opción para el campo "De" al escribir un correo para los usuarios que tengan acceso a la cuenta de correo del grupo.',
  'LBL_STATUS_ACTIVE' => 'Activo',
  'LBL_STATUS_INACTIVE' => 'Inactivo',
  'LBL_IS_GROUP' => 'grupo',
  'LBL_ENABLE_AUTO_IMPORT' => 'Importar Correos Automáticamente',
  'LBL_WARNING_CHANGING_AUTO_IMPORT' => 'Aviso: Está modificando su configuración de importación automática lo cual puede provocar pérdida de datos.',
  'LBL_WARNING_CHANGING_AUTO_IMPORT_WITH_CREATE_CASE' => 'Aviso: La importación automática debe estar habilitada para la creación automática de casos.',
  'LBL_EDIT_LAYOUT' => 'Editar diseño',
);