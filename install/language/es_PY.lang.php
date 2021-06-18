<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc. ç
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): ______________________________________..
 * *******************************************************************************/

$mod_strings = array(
	'LBL_BASIC_SEARCH'					=> 'Búsqueda Básica',
	'LBL_ADVANCED_SEARCH'				=> 'Búsqueda Avanzada',
	'LBL_BASIC_TYPE'					=> 'Tipo Básico',
	'LBL_ADVANCED_TYPE'					=> 'Tipo Avanzado',
	'LBL_SYSOPTS_1'						=> 'Seleccione las siguientes opciones de configuración del sistema',
	'LBL_SYSOPTS_2'                     => '¿Qué tipo de base de datos será utilizada para la instancia de SuiteCRM que está a punto de instalar?',
	'LBL_SYSOPTS_CONFIG'				=> 'Configuración del Sistema',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Especifique Tipo de Base de Datos',
	'LBL_SYSOPTS_DB_TITLE'              => 'Tipo de Base de Datos',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Por favor, corrija los siguientes errores antes de proceder:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Por favor, de permisos de escritura a los siguientes directorios:',
	'ERR_DB_VERSION_FAILURE'			=> 'No se puede verificar la versión de la base de datos.',
	'DEFAULT_CHARSET'					=> 'UTF-8',
	'ERR_ADMIN_USER_NAME_BLANK'         => 'Provea el nombre de usuario para el usuario administrador de SuiteCRM. ',
	'ERR_ADMIN_PASS_BLANK'				=> 'Provea una contraseña para el usuario administrador de SuiteCRM. ',

	//'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
	'ERR_CHECKSYS'                      => 'Se detectaron errores durante la verificación de compatibilidad.  Para que su instalación de SuiteCRM funcione correctamente, por favor realice los pasos necesarios para corregir los inconvenientes listados más abajo, y vuelva a presionar el botón volver a verificar, o vuelva a intentar realizar la instalación nuevamente.',
	'ERR_CHECKSYS_CALL_TIME'            => '"Allow Call Time Pass Reference" está Habilitado (por favor, establézcalo a Off en php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'No encontrado: el planificador de tareas de SuiteCRM se ejecutará con funcionalidad limitada.',
	'ERR_CHECKSYS_IMAP'					=> 'No encontrado: Correo Entrante y Campañas (Correo Electrónico) requieren las bibliotecas de IMAP. Ninguno será funcional',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC no puede ser activado cuando se usa MS SQL Server',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Aviso:',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> '(Establézcalo a ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M o más en su archivo php.ini)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Versión Mínima 4.1.2 - Encontrada: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Ha ocurrido un error al escribir y leer las variables de sesión.  No se ha podido proceder con la instalación',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'No es un Directorio Válido',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Aviso: No Escribible',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Su versión de PHP no es soportada por SuiteCRM. Deberá instalar una versión que sea compatible con la aplicación SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de la Versión para conocer las versiones de PHP soportadas. Su versión es ',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'Su versión de IIS no es soportada por SuiteCRM. Deberá instalar una versión que sea compatible con la aplicación SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de la Versión para conocer las versiones de IIS soportadas. Su versión es ',
	'ERR_CHECKSYS_FASTCGI'              => 'Detectamos que no está utilizando un FastCGI handler mapping para PHP. Deberá instalar/configurar una versión que sea compatible con SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de la Versión para conocer las versiones soportadas. Vea <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> para más detalles ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Para unos resultados óptimos al utilizar el sapi IIS/FastCGI, establezca fastcgi.logging a 0 en su archivo php.ini',
	'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Versión de PHP Instalada No Soportada: ( ver',
	'LBL_DB_UNAVAILABLE'                => 'Base de datos no disponible',
	'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'No se encontró Soporte de Base de Datos. Por favor asegúrese de tener los drivers necesarios para alguna de las siguientes Base de Datos soportadas: MySQL o MS SqlServer. Puede que sea necesario descomentar la extensión correspondiente en el archivo php.ini, o recompilar con el binario correspondiente, dependiendo de su versión de PHP. Por favor consulte el manual de PHP para más información sobre cómo habilitar el Soporte de Base de Datos.',
	'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'No se encontraron las funciones de las librerías de XML Parsing necesarias para ejecutar SuiteCRM. Puede que sea necesario descomentar la extensión correspondiente en el archivo php.ini, o recompilar con el binario correspondiente, dependiendo de su versión de PHP. Por favor consulte el manual de PHP para más información.',
	'ERR_CHECKSYS_MBSTRING'             => 'No se encontraron las funciones asociadas con la extensión Multibyte Strings (mbstring) necesaria para ejecutar SuiteCRM. <br/><br/>Generalmente el módulo mbstring no está habilitado por defecto en PHP y debe ser activado con --enable-mbstring al momento de compilar PHP. Por favor consulte el manual de PHP para más información sobre cómo habilitar mbstring.',
	'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'La opción session.save_path de su archivo de configuración php (php.ini) no ha sido establecida o ha sido establecida a una carpeta que no existe. Es posible que tenga que establecer la opción save_path setting en php.ini o verificar que existe la carpeta establecida en save_path',
	'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'La opción session.save_path de su archivo de configuración php (php.ini) ha sido establecida a una carpeta que no es escribible.  Por favor, lleve a cabo los pasos necesarios para hacer la carpeta escribible.  <br>Dependiendo de su Sistema Operativo, es posible que tenga que cambiar los permisos usando chmod 766, o hacer clic con el botón derecho del ratón sobre el archivo para acceder a las propiedades y desmarcar la opción de sólo lectura',
	'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'El archivo de configuración (config.php) existe pero no es escribible.  Por favor, lleve a cabo los pasos necesarios para hacerlo escribible.  Dependiendo de su Sistema Operativo, es posible que tenga que cambiar los permisos usando chmod 766, o hacer clic con el botón derecho del ratón sobre el archivo para acceder a las propiedades y desmarcar la opción de sólo lectura',
	'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'El archivo config override existe pero no se puede escribir. Por favor realice los pasos necesarios para dar permisos de escritura. <br/>Dependiendo de su Sistema Operativo puede llegar a neccesitar cambiar los permisos ejecutando chmod 766, o con click derecho sobre el archivo para acceder al menú propiedades y desactivar la opción "sólo lectura".',
	'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'El Directorio Custom existe pero no es escribible.  Es posible que tenga que cambiar sus permisos (chmod 766) o hacer clic con el botón derecho del ratón sobre él y desmarcar la opción de sólo lectura, dependiendo de su Sistema Operativo.  Por favor, lleve a cabo los pasos necesarios para que el archivo sea escribible',
	'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "Los siguientes archivos o directorios no son escribibles o no existen y no pueden ser creados.  Dependiendo de su Sistema Operativo, corregir esto requerirá cambiar los permisos en los archivos o en su directorio padre (chmod 766), o hacer clic con el botón derecho en el directorio padre y desmarcar la opción 'sólo lectura' y aplicarla en todas las subcarpetas.",
	'LBL_CHECKSYS_OVERRIDE_CONFIG' => 'Config override',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'El Modo Seguro está activado (es posible que desee deshabilitarlo en php.ini)',
	'ERR_CHECKSYS_ZLIB'					=> 'ZLib no se encontró: SuiteCRM alcanza grandes beneficios de performance con la compresión zlib.',
	'ERR_CHECKSYS_ZIP'					=> 'ZIP no se encontró: SuiteCRM necesita soporte ZIP para procesar archivos comprimidos.',
	'ERR_CHECKSYS_PCRE'					=> 'PCRE no se encontró: SuiteCRM necesita la librería PCRE para procesar expresiones regulares en el estilo Perl.',
	'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE versión de librería: SuiteCRM necesita la versión 7.0 o superior de la librería PCRE para procesar expresiones regulares en el estilo Perl.',
	'ERR_DB_ADMIN'						=> 'El nombre de usuario o contraseña del administrador de base de datos no son válidos, y la conexión a base de datos no ha podido ser establecida. Por favor, introduzca un nombre de usuario y contraseña válidos. (Error: ',
	'ERR_DB_ADMIN_MSSQL'                => 'El nombre de usuario o contraseña del administrador de base de datos no son válidos, y la conexión a base de datos no ha podido ser establecida. Por favor, introduzca un nombre de usuario y contraseña válidos.',
	'ERR_DB_EXISTS_NOT'					=> 'La base de datos especificada no existe',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'La base de datos ya existe con información de configuración. Para ejecutar una instalación con la base de datos seleccionada vuelva a ejecutar la instalación y seleccione "Eliminar las tablas existentes y volver a crearlas?". Para actualizar utilice el Asistente de Actualizaciones en la Consola de Administración. Por favor lea la documentación de actualización <a href="http://www.suitecrm.com" target="_new">aquí</a>.',
	'ERR_DB_EXISTS'						=> 'El nombre de base de datos suministrado ya existe -- no puede crearse otra con el mismo nombre',
	'ERR_DB_EXISTS_PROCEED'             => 'El nombre de base de datos suministrado ya existe.  Puede<br>1.  pulsar el botón Atrás y elegir un nuevo nombre <br>2.  hacer clic en Siguiente y continuar, pero todas las tablas existentes en esta base de datos serán eliminadas.  <strong>Esto implica que sus tablas y datos serán eliminados permanentemente.</strong>',
	'ERR_DB_HOSTNAME'					=> 'El nombre de equipo no puede estar vacío',
	'ERR_DB_INVALID'					=> 'El tipo de base de datos seleccionado no es válido',
	'ERR_DB_LOGIN_FAILURE'				=> 'El host, nombre de usuario y/o contraseña provistos no es válido, y no se puede establecer una conexión a la base de datos. Por favor ingrese un host, nombre de usuario y contraseña válidos.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'El equipo, nombre de usuario o contraseña de base de datos no son válidos, y la conexión a base de datos no ha podido ser establecida. Por favor, introduzca un equipo, nombre de usuario y contraseña válidos. (Error: ',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'El equipo, nombre de usuario o contraseña de base de datos no son válidos, y la conexión a base de datos no ha podido ser establecida. Por favor, introduzca un equipo, nombre de usuario y contraseña válidos. (Error: ',
	'ERR_DB_MYSQL_VERSION'				=> 'Su versión de MySQL (%s) no es soportada por SuiteCRM.  Deberá instalar una versión que sea compatible con SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de Versión para conocer las versiones soportadas.',
	'ERR_DB_NAME'						=> 'El nombre de base de datos no puede estar vacío',
	'ERR_DB_NAME2'						=> "El nombre de base de datos no puede contener los caracteres '\\', '/', o '.'",
	'ERR_DB_MYSQL_DB_NAME_INVALID'      => "El nombre de base de datos no puede contener '\\', '/', o '.'",
	'ERR_DB_MSSQL_DB_NAME_INVALID'      => "El nombre de base de datos no puede contener los caracteres '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', o '-'",
	'ERR_DB_OCI8_DB_NAME_INVALID'       => "El nombre de base de datos sólo puede estar formado por caracteres alfanuméricos y los símbolos '#', '_' o '$'",
	'ERR_DB_PASSWORD'					=> 'Las contraseñas provistas para el administrador de base de datos no coinciden.  Por favor vuelva a ingresar las mismas contraseñas en los campos.',
	'ERR_DB_PRIV_USER'					=> 'Introduzca un nombre de usuario de base de datos.  El usuario es necesario para la conexión inicial a la base de datos',
	'ERR_DB_USER_EXISTS'				=> 'El nombre de usuario para la base de datos ya existe -- no se puede crear otro con el mismo nombre. Por favor ingrese un nuevo nombre de usuario.',
	'ERR_DB_USER'						=> 'Introduzca un nombre de usuario para el administrador de la base de datos de SuiteCRM.',
	'ERR_DBCONF_VALIDATION'				=> 'Por favor, corrija los siguientes errores antes de continuar:',
	'ERR_DBCONF_PASSWORD_MISMATCH'      => 'Las contraseñas provistas para el administrador de base de datos no coinciden.  Por favor vuelva a ingresar las mismas contraseñas en los campos.',
	'ERR_ERROR_GENERAL'					=> 'Se han encontrado los siguientes errores:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'El archivo no puede ser eliminado: ',
	'ERR_LANG_MISSING_FILE'				=> 'El archivo no ha sido encontrado: ',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'No se ha encontrado un paquete de idioma en include/language dentro de: ',
	'ERR_LANG_UPLOAD_1'					=> 'Ha ocurrido un problema con su subida de archivo.  Por favor, inténtelo de nuevo',
	'ERR_LANG_UPLOAD_2'					=> 'Los paquetes de idioma deben ser archivos ZIP',
	'ERR_LANG_UPLOAD_3'					=> 'PHP no ha podido mover el archivo temporal al directorio de actualizaciones',
	'ERR_LICENSE_MISSING'				=> 'Faltan Campos Requeridos',
	'ERR_LICENSE_NOT_FOUND'				=> 'No se ha encontrado el archivo de licencia',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'El directorio de trazas indicado no es un directorio válido',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'El directorio de trazas indicado no es un directorio escribible',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Se requiere un directorio de trazas si desea indicar uno personalizado',
	'ERR_NO_DIRECT_SCRIPT'				=> 'No se ha podido procesar el script directamente',
	'ERR_NO_SINGLE_QUOTE'				=> 'No puede utilizarse las comillas simples para',
	'ERR_PASSWORD_MISMATCH'				=> 'Las contraseñas provistas para el usuario admin de SuiteCRM no coinciden.  Por favor vuelva a ingresar las mismas contraseñas en los campos.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'No ha podido escribirse en el archivo <span class=stop>config.php</span>',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Puede continuar esta instalación crando manualmente el archivo config.php y pegando la información de configuración indicada a continuación en el archivo config.php.  Sin embargo, <strong>debe </strong>crear el archivo config.php antes de avanzar al siguiente paso',
	'ERR_PERFORM_CONFIG_PHP_3'			=> '¿Recordó crear el archivo config.php?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Aviso: No ha podido escribirse en el archivo config.php.  Por favor, asegúrese de que existe',
	'ERR_PERFORM_HTACCESS_1'			=> 'No ha podido escribirse en el archivo ',
	'ERR_PERFORM_HTACCESS_2'			=> ' archivo.',
	'ERR_PERFORM_HTACCESS_3'			=> 'Si quiere securizar su archivo de trazas, para evitar que sea accesible mediante el navegador web, cree un archivo .htaccess en su directorio de trazas con la línea:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>No hemos podido detectar una conexión a Internet.</b> Cuando tenga una conexión, por favor visite <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> para registrarse con SuiteCRM. Si nos cuenta un poco cómo su compañía planea utilizar SuiteCRM podremos asegurarnos de entregarle la aplicación correcta para las necesidades de su negocio.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'El directorio de sesión indicado no es un directorio válido',
	'ERR_SESSION_DIRECTORY'				=> 'El directorio de sesión indicado no es un directorio escribible',
	'ERR_SESSION_PATH'					=> 'Se requiere un directorio de sesión si desea indicar uno personalizado',
	'ERR_SI_NO_CONFIG'					=> 'No incluyó el archivo config_si.php en el directorio raíz, o no definió la variable $sugar_config_si en config.php',
	'ERR_SITE_GUID'						=> 'Se requiere un ID de Aplicación si desea indicar uno personalizado',
	'ERROR_SPRITE_SUPPORT'              => "No hemos podido encontrar la librería GD, como resultado no podrá utilizar la funcionalidad CSS Sprite.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Aviso: Su configuración de PHP debería ser cambiada para permitir subidas de archivos de al menos 6MB',
	'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Tamaño para Subida de Archivos',
	'ERR_URL_BLANK'						=> 'Provea la URL base para su instancia de SuiteCRM.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'No se ha localizado el registro de instalación de',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'The uploaded file is not compatible with this flavor of SuiteCRM: ',
	'ERROR_LICENSE_EXPIRED'				=> "Error: Su licencia caducó hace ",
	'ERROR_LICENSE_EXPIRED2'			=> " día(s).   Por favor, vaya a la <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administración de Licencias\"</a>, en la pantalla de Administración, para introducir su nueva clave de licencia.  Si no introduce una nueva clave de licencia en 30 días a partir de la caducidad de su clave de licencia, no podrá iniciar la sesión en esta aplicación",
	'ERROR_MANIFEST_TYPE'				=> 'El archivo de manifiesto debe especificar el tipo de paquete',
	'ERROR_PACKAGE_TYPE'				=> 'El archivo de manifiesto debe especifica un tipo de paquete no reconocido',
	'ERROR_VALIDATION_EXPIRED'			=> "Error: Su clave de validación caducó hace ",
	'ERROR_VALIDATION_EXPIRED2'			=> " día(s).   Por favor, vaya a la <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administración de Licencias\"</a>, en la pantalla de Administración, para introducir su nueva clave de validación.  Si no introduce una nueva clave de validación en 30 días a partir de la caducidad de su clave de validación, no podrá iniciar la sesión en esta aplicación",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'El archivo subido no es compatible con esta versión de SuiteCRM: ',

	'LBL_BACK'							=> 'Atrás',
	'LBL_CANCEL'                        => 'Cancelar',
	'LBL_ACCEPT'                        => 'Aceptar',
	'LBL_CHECKSYS_1'					=> 'Para que su instalación de SuiteCRM funcione correctamente, por favor asegúrese de que todos los items por verificar listados más abajo estén en verde. Si encuentra alguno en rojo, por favor realice los pasos necesarios para solucionarlos.<BR><BR> Para obtener ayuda por estos items, visite <a href="http://www.suitecrm.com" target="_blank">SuiteCRM</a>.',
	'LBL_CHECKSYS_CACHE'				=> 'Subdirectorios de Caché Escribibles',
	'LBL_DROP_DB_CONFIRM'               => 'El Nombre de Base de datos suministrado ya existe.<br>Tiene las siguientes opciones:<br>1.  Hacer clic en el botón Cancelar y seleccionar un nuevo nombre de base de datos, o <br>2.  Hacer clic en el botón Aceptar y continuar.  Todas las tablas existentes en la base de datos serán eliminadas. <strong>Esto implica que todas sus tablas y datos actuales desaparecerán.</strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference desactivado',
	'LBL_CHECKSYS_COMPONENT'			=> 'Componente',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Componentes Opcionales',
	'LBL_CHECKSYS_CONFIG'				=> 'Archivo de Configuración de SuiteCRM (config.php) Escribible',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Archivo de Configuración editable (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'Módulo cURL',
	'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Configuración de la Ruta de Almacenamiento de Sesiones',
	'LBL_CHECKSYS_CUSTOM'				=> 'Directorio Personalizado (custom) Escribible',
	'LBL_CHECKSYS_DATA'					=> 'Subdirectorios de Datos Escribibles',
	'LBL_CHECKSYS_IMAP'					=> 'Módulo IMAP',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'Módulo de Cadenas MB',
	'LBL_CHECKSYS_MEM_OK'				=> 'Correcto (Sin Límite)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'Correcto (Sin Límite)',
	'LBL_CHECKSYS_MEM'					=> 'Límite de Memoria PHP >= ',
	'LBL_CHECKSYS_MODULE'				=> 'Subdirectorios y Archivos de Módulos Escribibles',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'Versión de MySQL',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'No disponible',
	'LBL_CHECKSYS_OK'					=> 'Correcto',
	'LBL_CHECKSYS_PHP_INI'				=> '<b>Nota:</b> Su archivo de configuración de PHP (php.ini) está localizado en:',
	'LBL_CHECKSYS_PHP_OK'				=> 'Correcto (ver ',
	'LBL_CHECKSYS_PHPVER'				=> 'Versión de PHP',
	'LBL_CHECKSYS_IISVER'               => 'Versión de IIS',
	'LBL_CHECKSYS_RECHECK'				=> 'Comprobar de nuevo',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'Modo Seguro de PHP Deshabilitado',
	'LBL_CHECKSYS_SESSION'				=> 'Ruta de Almacenamiento de Sesión Escribible (',
	'LBL_CHECKSYS_STATUS'				=> 'Estado',
	'LBL_CHECKSYS_TITLE'				=> 'Aceptación de Comprobaciones del Sistema',
	'LBL_CHECKSYS_VER'					=> 'Encontrado: ( ver ',
	'LBL_CHECKSYS_XML'					=> 'Análisis XML',
	'LBL_CHECKSYS_ZLIB'					=> 'Módulo de Compresión ZLIB',
	'LBL_CHECKSYS_ZIP'					=> 'Módulo de gestión ZIP',
	'LBL_CHECKSYS_PCRE'					=> 'Librería PCRE',
	'LBL_CHECKSYS_FIX_FILES'            => 'Por favor, corrija los siguientes archivos o directorios antes de continuar:',
	'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Por favor, corrija los siguientes directorios de módulos y los archivos en ellos contenidos antes de continuar:',
	'LBL_CHECKSYS_UPLOAD'               => 'Directorio Upload Editable',
	'LBL_CLOSE'							=> 'Cerrar',
	'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'será creado',
	'LBL_CONFIRM_DB_TYPE'				=> 'Tipo de Base de datos',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Por favor, confirme la siguiente configuración.  Si desea cambiar cualquiera de los valores, haga clic en "Atrás" para editarlos.  En otro caso, haga clic en "Siguiente" para iniciar la instalación',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Información de Licencia',
	'LBL_CONFIRM_NOT'					=> 'no',
	'LBL_CONFIRM_TITLE'					=> 'Confirmar Configuración',
	'LBL_CONFIRM_WILL'					=> 'será',
	'LBL_DBCONF_CREATE_DB'				=> 'Crear Base de datos',
	'LBL_DBCONF_CREATE_USER'			=> 'Crear usuario',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Atención: Toda la información de SuiteCRM será eliminada<br>si se marca esta casilla.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> '¿Eliminar las tablas de SuiteCRM actuales y crearlas de nuevo?',
	'LBL_DBCONF_DB_DROP'                => 'Eliminar Tablas',
	'LBL_DBCONF_DB_NAME'				=> 'Nombre de Base de datos',
	'LBL_DBCONF_DB_PASSWORD'			=> 'Contraseña del Usuario de Base de datos de SuiteCRM',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Introduzca de nuevo la Contraseña del Usuario de Base de datos de SuiteCRM',
	'LBL_DBCONF_DB_USER'				=> 'Nombre de Usuario de Base de Datos',
	'LBL_DBCONF_SUGAR_DB_USER'          => 'Nombre de Usuario de Base de Datos',
	'LBL_DBCONF_DB_ADMIN_USER'          => 'Nombre de usuario del Administrador de Base de datos',
	'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Contraseña del Administrador de Base de datos',
	'LBL_DBCONF_DEMO_DATA'				=> '¿Introducir Datos de Demostración en la Base de datos?',
	'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Seleccione los Datos de Demo',
	'LBL_DBCONF_HOST_NAME'				=> 'Nombre de Equipo',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Instancia del Host',
	'LBL_DBCONF_HOST_PORT'				=> 'Puerto',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Por favor, introduzca la información de configuración de su base de datos a continuación. Si no está seguro de qué datos utilizar, le sugerimos que utilice los valores por defecto',
	'LBL_DBCONF_MB_DEMO_DATA'			=> '¿Utilizar texto multi-byte en datos de demostración?',
	'LBL_DBCONFIG_MSG2'                 => 'Nombre del servidor web o máquina (equipo) en el que la base de datos está ubicada ( por ejemplo, localhost o www.midominio.com ):',
	'LBL_DBCONFIG_MSG2_LABEL' => 'Nombre de Equipo',
	'LBL_DBCONFIG_MSG3'                 => 'Nombre de la base de datos que contendrá la información de la instancia de SuiteCRM que está a punto de instalar:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'Nombre de Base de datos',
	'LBL_DBCONFIG_B_MSG1'               => 'Para configurar la base de datos de SuiteCRM es necesario el nombre de usuario y contraseña de un administrador de base de datos que pueda crear las tablas, usuarios y escribir en ella.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
	'LBL_DBCONFIG_SECURITY'             => 'Por razones de seguridad, se puede especificar un usuario exclusivo para conectar a la base de datos de SuiteCRM. Este usuario debe ener permisos para escribir, modificar y recuperar información de la base de datos de SuiteCRM que será creada para esta instancia. Este usuario puede ser el administrador de base de datos que se especificó más arriba, usted puede proveer uno nuevo o uno existente.',
	'LBL_DBCONFIG_AUTO_DD'              => 'Hágalo por mi',
	'LBL_DBCONFIG_PROVIDE_DD'           => 'Introduzca un usuario existente',
	'LBL_DBCONFIG_CREATE_DD'            => 'Defina el usuario a crear',
	'LBL_DBCONFIG_SAME_DD'              => 'El mismo que el usuario Administrador',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
	'LBL_FTS'                           => 'Búsqueda Full-Text',
	'LBL_FTS_INSTALLED'                 => 'Instalado',
	'LBL_FTS_INSTALLED_ERR1'            => 'La característica de Búsqueda Full-Text no está instalada.',
	'LBL_FTS_INSTALLED_ERR2'            => 'Usted puede realizar la instalación, pero no podrá utilizar la funcionalidad de Búsqueda Full-Text. Por favor consulte la guía de instalación de su servidor de base de datos para saber cómo hacer esto, o contacte a su Administrador.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Contraseña de Usuario Privilegiado de Base de datos',
	'LBL_DBCONF_PRIV_USER_2'			=> '¿Corresponde la Cuenta de Base de datos Anterior a un Usuario Privilegiado?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'Este usuario privilegiado de base de datos debe tener los permisos adecuados para crear una base de datos, eliminar/crear tablas, y crear un usuario.  Este usuario privilegiado de base de datos sólo se utilizará para realizar estas tareas según sean necesarias durante el proceso de instalación.  También puede utilizar el mismo usuario de base de datos anterior si tiene los privilegios suficientes',
	'LBL_DBCONF_PRIV_USER'				=> 'Nombre del Usuario Privilegiado de Base de datos',
	'LBL_DBCONF_TITLE'					=> 'Configuración de Base de datos',
	'LBL_DBCONF_TITLE_NAME'             => 'Introduzca el Nombre de Base de Datos',
	'LBL_DBCONF_TITLE_USER_INFO'        => 'Introduzca la Información de Usuario de Base de Datos',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'Usuario',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'Contraseña',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Después de que se haya realizado este cambio, puede hacer clic en el botón "Iniciar" situado abajo, para iniciar su instalación.  <i>Una vez se haya completado la instalación, es probable que desee cambiar el valor para la variable \'installer_locked\' a \'true\'.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'El instalador ya ha sido ejecutado. Como medida de seguridad, se ha deshabilitado para que no sea ejecutado por segunda vez.  Si está totalmente seguro de que desea ejecutarlo de nuevo, por favor vaya a su archivo config.php y localice (o añada) una variable llamada  \'installer_locked\' y establézcala a \'false\'.  La línea debería quedar como lo siguiente:',
	'LBL_DISABLED_HELP_1'				=> 'For installation help, please visit the SuiteCRM',
	'LBL_DISABLED_HELP_LNK'             => 'http://suitecrm.com/forum/',
	'LBL_DISABLED_HELP_2'				=> 'Foros de soporte',
	'LBL_DISABLED_TITLE_2'				=> 'La instalación de SuiteCRM ha sido deshabilitada',
	'LBL_DISABLED_TITLE'				=> 'Instalación de SuiteCRM Deshabilitada',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Juego de caracteres más utilizado en su configuración regional',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Configuración de Correo Saliente',
	'LBL_EMAIL_CHARSET_CONF'            => 'Juego de Caracteres para Correo Saliente',
	'LBL_HELP'							=> 'Ayuda',
	'LBL_INSTALL'                       => 'Instalar',
	'LBL_INSTALL_TYPE_TITLE'            => 'Opciones de Instalación',
	'LBL_INSTALL_TYPE_SUBTITLE'         => 'Seleccione un Tipo de Instalación',
	'LBL_INSTALL_TYPE_TYPICAL'          => '<b>Instalación Típica</b>',
	'LBL_INSTALL_TYPE_CUSTOM'           => '<b>Instalación Personalizada</b>',
	'LBL_INSTALL_TYPE_MSG1'             => 'La clave se requiere para la funcionalidad general de la aplicación, pero no es necesaria para la instalación. No necesita introducir una clave válida en estos momentos, pero deberá introducirla tras la instalación de la aplicación',
	'LBL_INSTALL_TYPE_MSG2'             => 'Requiere la mínima información posible para la instalación. Recomendada para usuarios nóveles',
	'LBL_INSTALL_TYPE_MSG3'             => 'Provee opciones adicionales a establecer durante la instalación. La mayoría de éstas están también disponibles tras la instalación en las pantallas de adminitración. Recomendado para usuarios avanzados',
	'LBL_LANG_1'						=> 'Para usar otro idioma diferente al idioma por defecto (US-English), puede subir e instalar un paquete de idioma en este momento. También podrá subir e instalar paquetes de idioma desde adentro de la aplicación. Si quiere omitir este paso, haga click en Siguiente.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Proceder',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Quitar',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Desinstalar',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Subir',
	'LBL_LANG_NO_PACKS'					=> 'Ninguno',
	'LBL_LANG_PACK_INSTALLED'			=> 'Los siguientes paquetes de idioma han sido instalados: ',
	'LBL_LANG_PACK_READY'				=> 'Los siguientes paquetes de idioma están listos para ser instalados: ',
	'LBL_LANG_SUCCESS'					=> 'El paquete de idioma ha sido subido con éxito',
	'LBL_LANG_TITLE'			   		=> 'Paquete de Idioma',
	'LBL_LAUNCHING_SILENT_INSTALL'     => 'Instalando SuiteCRM.  Este proceso puede tomar unos minutos.',
	'LBL_LANG_UPLOAD'					=> 'Subir un Paquete de Idioma',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Aceptación de Licencia',
	'LBL_LICENSE_CHECKING'              => 'Haciendo comprobaciones de compatibilidad del sistema',
	'LBL_LICENSE_CHKENV_HEADER'         => 'Comprobando Entorno',
	'LBL_LICENSE_CHKDB_HEADER'          => 'Validando Credenciales de BD',
	'LBL_LICENSE_CHECK_PASSED'          => 'El sistema ha pasado las pruebas de compatibilidad',
	'LBL_CREATE_CACHE' => 'Preparando para instalar...',
	'LBL_LICENSE_REDIRECT'              => 'Redirigiendo a ',
	'LBL_LICENSE_DIRECTIONS'			=> 'Si tiene información acerca de su licencia, por favor introdúzcala en los siguientes campos',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Introduzca Clave de Descarga',
	'LBL_LICENSE_EXPIRY'				=> 'Fecha de Caducidad',
	'LBL_LICENSE_I_ACCEPT'				=> 'Acepto',
	'LBL_LICENSE_NUM_USERS'				=> 'Número de Usuarios',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Por favor, introduzca el nombre de clientes desconectados adquiridos',
	'LBL_LICENSE_OC_NUM'				=> 'Número de Licencias de Cliente Desconectado',
	'LBL_LICENSE_OC'					=> 'Licencias de Cliente Desconectado',
	'LBL_LICENSE_PRINTABLE'				=> ' Vista Imprimible ',
	'LBL_PRINT_SUMM'                    => 'Imprimir Resumen',
	'LBL_LICENSE_TITLE_2'				=> 'Licencia SuiteCRM',
	'LBL_LICENSE_TITLE'					=> 'Información de Licencia',
	'LBL_LICENSE_USERS'					=> 'Usuarios con Licencia',

	'LBL_LOCALE_CURRENCY'				=> 'Configuración de Divisa',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Divisa predeterminada',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Símbolo de Divisa',
	'LBL_LOCALE_CURR_ISO'				=> 'Código de Divisa (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> 'Separador de miles',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Separador Decimal',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Ejemplo',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Dígitos Significavos',
	'LBL_LOCALE_DATEF'					=> 'Formato de Fecha Predeterminado',
	'LBL_LOCALE_DESC'					=> 'La configuración regional se verá reflejada globalmente en la instancia de SuiteCRM.',
	'LBL_LOCALE_EXPORT'					=> 'Juego de caracteres de Importación/Exportación <i>(Correo, .csv, vCard, PDF, importación de datos)</i>',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Delimitador para Exportación (.csv)',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Configuración de Importación/Exportación',
	'LBL_LOCALE_LANG'					=> 'Idioma Predeterminado',
	'LBL_LOCALE_NAMEF'					=> 'Formato de Nombre Predeterminado',
	'LBL_LOCALE_NAMEF_DESC'				=> 's Título<br />f Nombre<br />l Apellido',
	'LBL_LOCALE_NAME_FIRST'				=> 'Edward',
	'LBL_LOCALE_NAME_LAST'				=> 'Marti',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Sr.',
	'LBL_LOCALE_TIMEF'					=> 'Formato de Hora por Defecto',
	'LBL_CUSTOMIZE_LOCALE'              => 'Personalizar Configuración Regional',
	'LBL_LOCALE_UI'						=> 'Interfaz de Usuario',

	'LBL_ML_ACTION'						=> 'Acción',
	'LBL_ML_DESCRIPTION'				=> 'Descripción',
	'LBL_ML_INSTALLED'					=> 'Fecha de Instalación',
	'LBL_ML_NAME'						=> 'Nombre',
	'LBL_ML_PUBLISHED'					=> 'Fecha de Publicación',
	'LBL_ML_TYPE'						=> 'Tipo',
	'LBL_ML_UNINSTALLABLE'				=> 'No desinstalable',
	'LBL_ML_VERSION'					=> 'Versión',
	'LBL_MSSQL'							=> 'SQL Server',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver para PHP)',
	'LBL_MYSQL'							=> 'MySQL',
	'LBL_MYSQLI'						=> 'MySQL (extensión mysqli)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Siguiente',
	'LBL_NO'							=> 'No',
	'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Estableciendo la contraseña del admin del sitio',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'tabla de auditoría / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Creando el archivo de configuración de SuiteCRM',
	'LBL_PERFORM_CREATE_DB_1'			=> '<b>Creando la base de datos</b> ',
	'LBL_PERFORM_CREATE_DB_2'			=> '<b>en</b>',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Creando el usuario y la contraseña de Base de datos...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Creando información por defecto de SuiteCRM',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Creando el usuario y la contraseña de Base de datos para localhost...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Creando tablas de relación para suiteCRM',
	'LBL_PERFORM_CREATING'				=> 'creando /',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Creando informes predefinidos',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Creando trabajos del planificador por defecto',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Insertando configuración por defecto',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Creando usuarios por defecto',
	'LBL_PERFORM_DEMO_DATA'				=> 'Insertando en las tablas de base de datos datos de demostración (esto puede llevar un rato)',
	'LBL_PERFORM_DONE'					=> 'hecho<br>',
	'LBL_PERFORM_DROPPING'				=> 'eliminando /',
	'LBL_PERFORM_FINISH'				=> 'Finalizado',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Actualizando información de licencia',
	'LBL_PERFORM_OUTRO_1'				=> 'La configuración de SuiteCRM ',
	'LBL_PERFORM_OUTRO_2'				=> ' ha sido completada',
	'LBL_PERFORM_OUTRO_3'				=> 'Tiempo total:',
	'LBL_PERFORM_OUTRO_4'				=> ' segundos.',
	'LBL_PERFORM_OUTRO_5'				=> 'Memoria utilizada aproximadamente:',
	'LBL_PERFORM_OUTRO_6'				=> 'bytes',
	'LBL_PERFORM_OUTRO_7'				=> 'Su sistema ha sido instalado y configurado para su uso',
	'LBL_PERFORM_REL_META'				=> 'metadatos de relaciones ... ',
	'LBL_PERFORM_SUCCESS'				=> '¡Éxito!',
	'LBL_PERFORM_TABLES'				=> 'Creando las tablas de la aplicación, tablas de auditoría y metadatos de relaciones',
	'LBL_PERFORM_TITLE'					=> 'Realizar instalación',
	'LBL_PRINT'							=> 'Imprimir',
	'LBL_REG_CONF_1'					=> 'Por favor complete el breve formulario a continuación para recibir anuncios de productos, novedades de capacitaciones, ofertas especiales e invitaciones epeciales a eventos de SuiteCRM. No vendemos, alquilamos, compartimos ni distribuimos de ninguna forma la información recolectada aquí.',
	'LBL_REG_CONF_2'					=> 'Su nombre y dirección de correo electrónico son los únicos campos requeridos para el registro. El resto de campos son opcionales, pero de mucho valor. No vendemos, alquilamos, compartimos, o distribuimos en modo alguno la información aquí recogida a terceros',
	'LBL_REG_CONF_3'					=> 'Gracias por registrarse. Haga click en el botón Finalizar para ingresar a SuiteCRM. Necesitará ingresar por primera vez utilizando el nombre de usuario "admin" y la contraseña que ingresó en el paso 2.',
	'LBL_REG_TITLE'						=> 'Registro',
	'LBL_REG_NO_THANKS'                 => 'No gracias',
	'LBL_REG_SKIP_THIS_STEP'            => 'Saltar este paso',
	'LBL_REQUIRED'						=> 'Campo requerido',

	'LBL_SITECFG_ADMIN_Name'            => 'Nombre del Administrador de SuiteCRM',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Vuelva a Ingresar la Contraseña del Usuario Administrador',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Precaución: Esto substituirá la contraseña de admin de cualquier instalación previa',
	'LBL_SITECFG_ADMIN_PASS'			=> 'Contraseña del Usuario Administrador',
	'LBL_SITECFG_APP_ID'				=> 'ID de Aplicación',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'Si se selecciona, deberá proveer un ID de Aplicación para sobreescribir el ID autogenerado. El ID asegura que las sesiones de una instancia de SuiteCRM no sean usadas por otras instancia. Si tiene un cluster de instalaciones de SuiteCRM, todas deberían compartir el mismo ID de aplicación.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Proveer Su Propio ID de Aplicación',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'Si se selecciona, deberá especificar un directorio de logs para sobreescribir el directorio por defecto del log de SuiteCRM. Sin importar dónde esté ubicado el archivo de log, el acceso a través de navegador se deberá restringir utilizando una redirección .htacces.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Usar un Directorio Personalizado de Trazas',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'Si se selecciona, deberá proveer un directorio seguro para almacenar la información de sesiones de SuiteCRM. Esto se puede hacer para evitar que la información de la sesión sea vulnerada en servidores compartidos.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Utilizar un Directorio Personalizado para las Sesiones de SuiteCRM',
	'LBL_SITECFG_DIRECTIONS'			=> 'Por favor, introduzca la información de configuración de su sitio a continuación. Si no está seguro del significado de los campos, le sugerimos que utilice los valores por defecto',
	'LBL_SITECFG_FIX_ERRORS'			=> '<b>Por favor, corrija los siguientes errores antes de continuar:</b>',
	'LBL_SITECFG_LOG_DIR'				=> 'Directorio de Trazas',
	'LBL_SITECFG_SESSION_PATH'			=> 'Ruta al Directorio de Sesiones<br>(debe ser escribible)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Seleccione Opciones de Seguridad',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'Si está seleccionado, el sistema comprobará periódicamente si hay disponibles versiones actualizadas de la aplicación',
	'LBL_SITECFG_SUGAR_UP'				=> '¿Comprobar Automáticamente Actualizaciones?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Configuración de Actualizaciones de SuiteCRM',
	'LBL_SITECFG_TITLE'					=> 'Configuración del Sitio',
	'LBL_SITECFG_TITLE2'                => 'Identificar el Usuario Administrador',
	'LBL_SITECFG_SECURITY_TITLE'        => 'Seguridad del Sitio',
	'LBL_SITECFG_URL'					=> 'URL de la Instancia de SuiteCRM',
	'LBL_SITECFG_USE_DEFAULTS'			=> '¿Usar valores por defecto?',
	'LBL_SITECFG_ANONSTATS'             => '¿Enviar Estadísticas de Uso Anónimas?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'Si se selecciona, SuiteCRM enviará estadísticas <b>anónimas</b> acerca de su instalación a SuiteCRM Inc. cada vez que su sistema verifique nuevas versiones. Esta información nos ayudará a mejorar nuestra comprensión de cómo la aplicación es utilizada, y guiará las mejoras del producto.',
	'LBL_SITECFG_URL_MSG'               => 'Ingrese la URL que será utilizada para acceder a la instancia de SuiteCRM después de la instalación. La URL también va a ser utilizada como base para para las URL en las páginas de la aplicación. La URL puede incluir el nombre del servidor web, nombre del equipo o dirección IP.',
	'LBL_SITECFG_SYS_NAME_MSG'          => 'Ingrese un nombre para su sistema. El nombre se mostrará en la barra de título del navegador cuando los usuarios visiten la aplicación SuiteCRM.',
	'LBL_SITECFG_PASSWORD_MSG'          => 'Después de la instalación, necesitará utilizar el usuario administrador de SuiteCRM (nombre por defecto = admin) para ingresar a la instancia de SuiteCRM. Ingrese  una contraseña para este usuario administrador. Esta contraseña puede ser cambiada después de ingresar por primera vez. También puede ingresar otro nombre de usuario diferente al valor por defecto provisto.',
	'LBL_SITECFG_COLLATION_MSG'         => 'Seleccione la configuración de collation (ordenamiento de los datos) para su sistema. Esta configuración creará las tablas con el idioma específico que usted usa. En caso de que su idioma no requiera una configuración especial, utilice el valor por defecto.',
	'LBL_SPRITE_SUPPORT'                => 'Soporte de Sprite',
	'LBL_SYSTEM_CREDS'                  => 'Credenciales del Sistema',
	'LBL_SYSTEM_ENV'                    => 'Entorno del Sistema',
	'LBL_START'							=> 'Iniciar',
	'LBL_SHOW_PASS'                     => 'Mostrar Contraseñas',
	'LBL_HIDE_PASS'                     => 'Ocultar Contraseñas',
	'LBL_HIDDEN'                        => '<i>(oculto)</i>',
	'LBL_STEP1' => 'Paso 1 de 2 - Requisitos de preinstalación',
	'LBL_STEP2' => 'Paso 2 de 2 - Configuración',
//    'LBL_STEP1'                         => 'Step 1 of 8 - Pre-Installation requirements',
//    'LBL_STEP2'                         => 'Step 2 of 8 - License Agreement',
//    'LBL_STEP3'                         => 'Step 3 of 8 - Installation Type',
//    'LBL_STEP4'                         => 'Step 4 of 8 - Database Selection',
//    'LBL_STEP5'                         => 'Step 5 of 8 - Database Configuration',
//    'LBL_STEP6'                         => 'Step 6 of 8 - Site Configuration',
//    'LBL_STEP7'                         => 'Step 7 of 8 - Confirm Settings',
//    'LBL_STEP8'                         => 'Step 8 of 8 - Installation Successful',
//	'LBL_NO_THANKS'						=> 'Continue to installer',
	'LBL_CHOOSE_LANG'					=> '<b>Elija su idioma</b>',
	'LBL_STEP'							=> 'Paso',
	'LBL_TITLE_WELCOME'					=> 'Bienvenido a SuiteCRM ',
	'LBL_WELCOME_1'						=> 'Este instalador crea las tablas de la base de datos de SuiteCRM y establece los valores de configuración que ustede necesita para comenzar. El proceso completo debería tomar aproximadamente diez minutos.',
	'LBL_WELCOME_2'						=> 'For installation documentation, please visit the <a href="http://www.suitecrm.com/" target="_blank">SuiteCRM</a>.  <BR><BR> You can also find help from the SuiteCRM Community in the <a href="http://www.suitecrm.com/" target="_blank">SuiteCRM Forums</a>.',
	//welcome page variables
	'LBL_TITLE_ARE_YOU_READY'            => '¿Está listo para proceder con la instalación?',
	'REQUIRED_SYS_COMP' => 'Componentes del Sistema Requeridos',
	'REQUIRED_SYS_COMP_MSG' =>
		'Antes de comenzar, por favor asegúrese de que tiene las versiones soportadas de los siguientes componentes del sistema:<br>
                      <ul>
                      <li> Base de Datos/Sistema Manejador de Base de Datos (Ejemplos: MariaDB, MySQL or SQL Server)</li>
                      <li> Servidor Web (Apache, IIS)</li>
                      </ul>
                      Consulte la Matriz de Compatibilidad en las Notas de la Versión para encontrar
                      componentes de sistema compatibles para la versión de SuiteCRM que está instalando<br>',
	'REQUIRED_SYS_CHK' => 'Comprobación inicial del sistema',
	'REQUIRED_SYS_CHK_MSG' =>
		'Al comenzar el proceso de instalacion, se realizará un chequeo de sistema en el servidor web en el cual están ubicados los archivos de SuiteCRM con el objetivo de asegurar que el sistema está correctamente configurado y que tiene todos los componentes necesarios para completar la instalación exitosamente. <br><br>
                      El sistema chequea todo lo siguiente:<br>
                      <ul>
                      <li><b>Versión de PHP</b> &#8211; debe ser compatible con la aplicación</li>
                                        <li><b>Variables de Sesión</b> &#8211; deben funcionar correctamente</li>
                                            <li> <b>MB Strings</b> &#8211; debe estar instalada y habilitada en php.ini</li>

                      <li> <b>Soporte de Base de Datos</b> &#8211; debe existir para MariaDB, MySQL o SQL Server</li>

                      <li> <b>Config.php</b> &#8211; debe existir y debe tener los permisos apropiados para ser editable</li>
					  <li>Los siguientes archivos de SuiteCRM deben ser editables:<ul><li><b>/custom</li>
<li>/cache</li>
<li>/modules</li>
<li>/upload</b></li></ul></li></ul>
                                  Si la verificación falla, no podrá continuar con la instalación. Se le mostrará un mensaje de error, explicando por qué su sistema no pasó la verificación.
                                  Después de hacer los cambios necesarios, podrá realizar nuevamente la verificación del sistema para continuar con la instalación.<br>',
	'REQUIRED_INSTALLTYPE' => 'Instalación Típica o Personalizada',
	'REQUIRED_INSTALLTYPE_MSG' =>
		'Después de realizado el chequeo del sistema, puede seleccionar entre instalación Típica o Personalizada..<br><br>
                      Para ambas <b>Típica</b> y <b>Personalizada</b>, necesitará saber lo siguiente:<br>
                      <ul>
                      <li> <b>Tipo de Base de Datos</b> que albergará la información de SuiteCRM <ul><li>Tipos de Base de Datos Compatibles: MariaDB, MySQL o SQL Server.<br><br></li></ul></li>
                      <li> <b>Nombre del servidor web</b> o equipo (host) en el cual se encuentra la base de datos
                      <ul><li>Puede ser <i>localhost</i> si la base de datos se encuentra en su equipo local, o en el mismo servidor web o equipo que los archivos de SuiteCRM.<br><br></li></ul></li>
                      <li><b>Nombre de la base de datos</b> que desea utilizar para albergar la información de SuiteCRM</li>
                        <ul>
                          <li> Quizás usted ya tenga una base de datos existente que desearía utilizar. Si usted provee el nombre de una base de datos existente, se eliminarán las tablas existentes de la base de datos durante la instalación cuando se defina el nuevo esquema para la base de datos de SuiteCRM.</li>
                          <li> Si todavía no posee una base de datos, el nombre que usted provea será utilizado durante la instalación para la nueva base de datos que sea creada para la instancia..<br><br></li>
                        </ul>
                      <li><b>Nombre y contraseña del administrador de la base de datos</b> <ul><li>El administrador de baes de datos debería tener permisos para crear tablas, usuarios y escribir en la base de datos.</li><li>Puede que sea necesario contactar a su administrador de base de datos para que le provea esta información si la base de datos no se encuentra en su equipo local y/o si usted no es el administrador de base de datos.<br><br></ul></li></li>
                      <li> <b>Nombre de usuario de base de datos y contraseña</b>
                      </li>
                        <ul>
                          <li> El usuario puede ser el administrador de la base de datos, o puede proveer el nombre de otro usuario existente de la base de datos. </li>
                          <li> Si desea crear un nuevo usuario de base de datos para este propósito, deberá proveer un nuevo nombre de usuario y contraseña, y el usuario será creado durante la instalación. </li>
                        </ul></ul><p>

                      Para la configuración <b>Personalizada</b>, también deberá saber lo siguiente:<br>
                      <ul>
                      <li> <b>URL que será utilizada para acceder a la instancia de SuiteCRM</b> después de ser instalada.
                      Esta URL puede incluir el nombre o dirección IP del servidor o equipo.<br><br></li>
                                  <li> [Opcional] <b>Ruta del directorio de sesión</b> si desea utilizar un directorio personalizado para la información de SuiteCRM con el objetivo de evitar vulnerabilidad en servidores compartidos.<br><br></li>
                                  <li> [Opcional] <b>Ruta personalizada del directorio de log</b> si desea sobreescribir el directorio por defecto utilizado para los archivos de log de SuiteCRM.<br><br></li>
                                  <li> [Opcional] <b>ID de Aplicación</b> si desea sobreescribir el ID autogenerado para garantizar que las sesiones de una instancia de SuiteCRM no son utilizadas por otras instancias.<br><br></li>
                                  <li><b>Set de Caracteres</b> comunmente utilizado según su zona.<br><br></li></ul>
                                  Para obtener información más detallada, por favor consulte la Guía de Instalación.
                                ',
	'LBL_WELCOME_PLEASE_READ_BELOW' => 'Por favor, lea la siguiente información importante antes de proceder con la instalación.  La información le ayudará a determinar si está o no preparado en estos momentos para instalar la aplicación',

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '<b>Seleccione su idioma</b>',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Asistente de Instalación',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Bienvenido a SuiteCRM ',
	'LBL_WELCOME_TITLE'					=> 'Asistente de Configuración de SuiteCRM',
	'LBL_WIZARD_TITLE'					=> 'Asistente de Configuración de SuiteCRM: ',
	'LBL_YES'							=> 'Sí',
	'LBL_YES_MULTI'                     => 'Sí - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Procesar Tareas de Workflow',
	'LBL_OOTB_REPORTS'		=> 'Ejecutar Tareas Programadas de Generación de Informes',
	'LBL_OOTB_IE'			=> 'Comprobar Bandejas de Entrada',
	'LBL_OOTB_BOUNCE'		=> 'Ejecutar Proceso Nocturno de Correos de Campaña Rebotados',
	'LBL_OOTB_CAMPAIGN'		=> 'Ejecutar Proceso Nocturno de Campañas de Correo Masivo',
	'LBL_OOTB_PRUNE'		=> 'Truncar Base de datos al Inicio del Mes',
	'LBL_OOTB_TRACKER'		=> 'Limpiar Tablas de Monitorización',
	'LBL_OOTB_SUGARFEEDS'   => 'Limpiar las Tablas de SuiteCRM Feed',
	'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Ejecutar Notificaciones de Recordatorios por Email',
	'LBL_UPDATE_TRACKER_SESSIONS' => 'Actualizar tabla tracker_sessions',
	'LBL_OOTB_CLEANUP_QUEUE' => 'Limpiar Cola de Tareas',
	'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Quitar Documentos del Filesystem',


	'LBL_PATCHES_TITLE'     => 'Instalar Últimos Parches',
	'LBL_MODULE_TITLE'      => 'Descargar e Instalar Paquetes de Idioma',
	'LBL_PATCH_1'           => 'Si desea saltar este paso, haga clic en Siguiente',
	'LBL_PATCH_TITLE'       => 'Parche del Sistema',
	'LBL_PATCH_READY'       => 'Los siguientes parches están listos para ser instalados:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM depende de las Sesiones de PHP para almacenar información importante mientras se conecta al servidor web. Su instalación de PHP no tiene la información de Sesiones correctamente configurada. 
	<br><br>Un problema común de configuración es que la directiva <b>'session.save_path'</b> no está señalando un directorio válido. <br>
	<br> Por favor corrija su <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>configuración PHP</a> en el archivo php.ini ubicado a continuación.",
	'LBL_SESSION_ERR_TITLE'				=> 'Error de Configuración de Sesiones PHP',
	'LBL_SYSTEM_NAME'=>'Nombre del Sistema',
	'LBL_COLLATION' => 'Configuración de Collation',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Provea un Nombre de Sistema para su instancia SuiteCRM.',
	'LBL_PATCH_UPLOAD' => 'Seleccione un archivo con un parche de su equipo local',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Se requiere la versión de PHP 5 o superior',
	'LBL_MINIMUM_PHP_VERSION' => 'La versión mínima requerida de PHP es la 5.1.0. Se recomienda usar la versión de PHP 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(Su versión actual de PHP es ',
	'LBL_RECOMMENDED_PHP_VERSION' =>' La versión recomendada de PHP es la 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'El modo de compatibilidad hacia atrás de PHP está habilitado. Establezca zend.ze1_compatibility_mode a Off antes de continuar',
	'LBL_STREAM' => 'PHP permite el uso de streaming',

	'advanced_password_new_account_email' => array(
		'subject' => 'Información de la Nueva Cuenta de Usuario',
		'description' => 'Esta plantilla es utilizada cuando un Administrador de Sistema envía una nueva contraseña a un usuario.',
		'body' => '<div><table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\" width="550" align=\\"\\&quot;\\&quot;center\\&quot;\\&quot;\\"><tbody><tr><td colspan=\\"2\\"><p>Aquí está su nuevo nombre de usuario y contraseña temporal:</p><p>Nombre de Usuario : $contact_user_user_name </p><p>Contraseña : $contact_user_user_hash </p><br><p>$config_site_url</p><br><p>Después de ingresar utilizando la contraseña de arriba, puede que se le pida cambiar la contraseña por una de su propia elección.</p>   </td>         </tr><tr><td colspan=\\"2\\"></td>         </tr> </tbody></table> </div>',
		'txt_body' =>
			'
Aquí está su nuevo nombre de usuario y contraseña temporal:
Nombre de Usuario : $contact_user_user_name
Contraseña : $contact_user_user_hash

$config_site_url

Después de ingresar utilizando la contraseña de arriba, puede que se le pida cambiar la contraseña por una de su propia elección.',
		'name' => 'Email de contraseña generada por el sistema',
	),
	'advanced_password_forgot_password_email' => array(
		'subject' => 'Reestablecer su contraseña',
		'description' => "Esta plantilla es utilizada para enviarle un enlace al usuario que al cliquearse reestablece la contraseña de la cuenta del usuario.",
		'body' => '<div><table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\" width="550" align=\\"\\&quot;\\&quot;center\\&quot;\\&quot;\\"><tbody><tr><td colspan=\\"2\\"><p>Recientemente ($contact_user_pwd_last_changed) ha requerido reestablecer la contraseña de su cuenta. </p><p>Haga click en el siguiente enlace para reestablecer su contraseña:</p><p> $contact_user_link_guid </p>  </td>         </tr><tr><td colspan=\\"2\\"></td>         </tr> </tbody></table> </div>',
		'txt_body' =>
			'
Recientemente ($contact_user_pwd_last_changed) ha requerido reestablecer la contraseña de su cuenta.

Haga click en el siguiente enlace para reestablecer su contraseña:

$contact_user_link_guid',
		'name' => 'Email de Contraseña Olvidada',
	),

	// SMTP settings

	'LBL_WIZARD_SMTP_DESC' => 'Proporcione la cuenta de correo que se utilizará para enviar correos, como las notificaciones de asignación y las contraseñas de nuevos usuarios. Los usuarios recibirán correos de SuiteCRM, como si hubieran sido enviados desde la cuenta de correo especificada.',
	'LBL_CHOOSE_EMAIL_PROVIDER'        => 'Elija su proveedor de e-Mail:',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Correo Yahoo',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => 'Otro',
	'LBL_MAIL_SMTP_SETTINGS'           => 'Especificación del servidor SMTP',
	'LBL_MAIL_SMTPSERVER'				=> 'Servidor SMTP:',
	'LBL_MAIL_SMTPPORT'					=> 'Puerto SMTP:',
	'LBL_MAIL_SMTPAUTH_REQ'				=> '¿Usar autenticación SMTP?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => '¿Habilitar SMTP sobre SSL o TLS?',
	'LBL_GMAIL_SMTPUSER'					=> 'Nombre de usuario Gmail:',
	'LBL_GMAIL_SMTPPASS'					=> 'Contraseña Gmail:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => 'Permitir a los usuarios emplear esta cuenta para enviar e-Mails:',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => 'Cuando esta opción esta seleccionada, todos los usuarios serán capaz de enviar e-Mails usando la misma cuenta de e-Mail saliente usada para enviar notificaciones y alertas del sistema.  Si la opción no está seleccionada, los usuarios podrán usar el servidor de e-Mail saliente después de proveer la información de su propia cuenta',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Contraseña de Yahoo! Mail:',
	'LBL_YAHOOMAIL_SMTPUSER'					=> 'ID de Yahoo! Mail:',

	'LBL_EXCHANGE_SMTPPASS'					=> 'Contraseña de Exchange:',
	'LBL_EXCHANGE_SMTPUSER'					=> 'Nombre de usuario Exchange:',
	'LBL_EXCHANGE_SMTPPORT'					=> 'Puerto del servidor Exchange:',
	'LBL_EXCHANGE_SMTPSERVER'				=> 'Servidor Exchange:',


	'LBL_MAIL_SMTPUSER'					=> 'Usuario SMTP:',
	'LBL_MAIL_SMTPPASS'					=> 'Contraseña SMTP:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Personalizando',
	'LBL_WIZARD_SYSTEM_DESC' => 'Proporcione el nombre y logo de su organización para establecer la imagen de su marca en SuiteCRM.',
	'SYSTEM_NAME_WIZARD'=>'Nombre:',
	'SYSTEM_NAME_HELP'=>'Este es el nombre que se muestra en la barra de título de su navegador',
	'NEW_LOGO'=>'Seleccionar nuevo logo:',
	'NEW_LOGO_HELP'=>'El formato del archivo de imagen puede ser tanto .png como .jpg. La altura máxima es 170px, y la anchura máxima es 450px. Cualquier imagen cargada que se sobrepase en alguna de las medidas será modificada al tamaño indicado, según la medida que exceda.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'Subir',
	'CURRENT_LOGO'=>'Logo actual:',
	'CURRENT_LOGO_HELP'=>'Este logo se muestra en la esquina superior izquierda de la aplicación SuiteCRM.',


	//Scenario selection of modules
	'LBL_WIZARD_SCENARIO_TITLE' => 'Scenario Selection',
	'LBL_WIZARD_SCENARIO_DESC' => 'This is to allow tailoring of the displayed modules based on your requirements.  Each of the modules can be enabled after install using the administration page.',
	'LBL_WIZARD_SCENARIO_EMPTY'=> 'There are no scenarios currently set in the configuration file (config.php)',



	// System Local Settings


	'LBL_LOCALE_TITLE' => 'Configuración Regional del Sistema',
	'LBL_WIZARD_LOCALE_DESC' => 'Especifique cómo desea que los datos sean mostrados en SuiteCRM, basándose en su ubicación geográfica. La configuración que proporcione aquí será la utiliza por defecto. Los usuarios podrán establecer sus propias preferências.',
	'LBL_DATE_FORMAT' => 'Formato de fecha:',
	'LBL_TIME_FORMAT' => 'Formato de hora:',
	'LBL_TIMEZONE' => 'Zona horaria:',
	'LBL_LANGUAGE'=>'Idioma:',
	'LBL_CURRENCY'=>'Divisa:',
	'LBL_CURRENCY_SYMBOL'=>'Símbolo de moneda:',
	'LBL_CURRENCY_ISO4217' => 'Código de moneda ISO 4217:',
	'LBL_NUMBER_GROUPING_SEP' => 'Separador de miles',
	'LBL_DECIMAL_SEP' => 'Símbolo decimal',
	'LBL_NAME_FORMAT' => 'Formato de Nombre:',
	'UPLOAD_LOGO' => 'Por favor espere, cargando logo..',
	'ERR_UPLOAD_FILETYPE' => 'Tipo de archivo no permitido, por favor cargue un jpg o png.',
	'ERR_LANG_UPLOAD_UNKNOWN' => 'Ocurrió un error desconocido de cargue de archivo.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => 'El archivo subido excede el límite definido por la directiva upload_max_filesize en php.ini',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => 'El archivo subido excede el límite definido por la directiva MAX_FILE_SIZE especificada en el formulario HTML',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => 'El archivo ha sido sólo parcialmente subido',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => 'No se ha subido ningún archivo',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => 'Falta una carpeta temporal',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => 'Error al escribir el archivo',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.',

	'LBL_INSTALL_PROCESS' => 'Install...',

	'LBL_EMAIL_ADDRESS' => 'e-Mail:',
	'ERR_ADMIN_EMAIL' => 'Administrator Email Address is incorrect.',
	'ERR_SITE_URL' => 'Site URL is required.',

	'STAT_CONFIGURATION' => 'Configuration relationships...',
	'STAT_CREATE_DB' => 'Create database...',
	//'STAT_CREATE_DB_TABLE' => 'Create database... (table: %s)',
	'STAT_CREATE_DEFAULT_SETTINGS' => 'Create default settings...',
	'STAT_INSTALL_FINISH' => 'Install finish...',
	'STAT_INSTALL_FINISH_LOGIN' => 'Installation process finished, <a href="%s">please log in...</a>',
	'LBL_LICENCE_TOOLTIP' => 'Por favor acepte la licencia primero',

	'LBL_MORE_OPTIONS_TITLE' => 'Más opciones',
	'LBL_START' => 'Iniciar',
	'LBL_DB_CONN_ERR' => 'Database error'


);

?>
