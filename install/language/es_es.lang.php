<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
	'LBL_SYSOPTS_1'						=> 'Seleccione de las siguientes opciones de configuración del sistema.',
    'LBL_SYSOPTS_2'                     => '¿Qué tipo de base de datos será utilizada para la instancia de SuiteCRM que está a punto de instalar?',
	'LBL_SYSOPTS_CONFIG'				=> 'Configuración del Sistema',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Especifique Tipo de Base de Datos',
    'LBL_SYSOPTS_DB_TITLE'              => 'Tipo de Base de Datos',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Por favor corrija los siguientes errores antes de continuar:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Por favor modifique los permisos de los siguientes directorios para permitir la escritura:',


    'ERR_DB_VERSION_FAILURE'			=> 'No se puede verificar la versión de la base de datos.',


	'DEFAULT_CHARSET'					=> 'UTF-8',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Provea el nombre de usuario para el usuario administrador de SuiteCRM. ',
	'ERR_ADMIN_PASS_BLANK'				=> 'Provea una contraseña para el usuario administrador de SuiteCRM. ',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'Se detectaron errores durante la verificación de compatibilidad.  Para que su instalación de SuiteCRM funcione correctamente, por favor realice los pasos necesarios para corregir los inconvenientes listados más abajo, y vuelva a presionar el botón volver a verificar, o vuelva a intentar realizar la instalación nuevamente.',
    'ERR_CHECKSYS_CALL_TIME'            => 'Allow Call Time Pass Reference está Activado (debería estar en Off en el archivo php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'No encontrado: el planificador de tareas de SuiteCRM se ejecutará con funcionalidad limitada.',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Para una mejor experiencia use IIS/FastCGI sapi, asigne fastcgi.logging en 0 en su archivo php.ini.',
    'ERR_CHECKSYS_IMAP'					=> 'No encontrado: Correo Entrante y Campañas (Email) requieren la librería IMAP. No estarán funcionales.',
    //'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC cannot be turned "On" when using MS SQL Server.',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC no pueden estar activadas cuando se utiliza MS SQL Server.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Advertencia: ',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> ' (Cambie este valor a  ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M o más en su archivo php.ini)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Versión mínima requerida 4.1.2 - Se encontró: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Falló la escritura y lectura de variables de sesión. No se puede avanzar con la instalación.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'No es un directorio válido',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Advertencia: No se puede escribir',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Su versión de PHP no es soportada por SuiteCRM. Deberá instalar una versión que sea compatible con la aplicación SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de la Versión para conocer las versiones de PHP soportadas. Su versión es ',
	'ERR_CHECKSYS_IIS_INVALID_VER'		=> 'Su versión de IIS no es soportada por SuiteCRM. Deberá instalar una versión que sea compatible con la aplicación SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de la Versión para conocer las versiones de IIS soportadas. Su versión es ',
	'ERR_CHECKSYS_FASTCGI'              => 'Detectamos que no está utilizando un FastCGI handler mapping para PHP. Deberá instalar/configurar una versión que sea compatible con SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de la Versión para conocer las versiones soportadas. Vea <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> para más detalles ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Para una mejor experiencia usando IIS/FastCGI sapi, asigne fastcgi.logging en 0 en su archivo php.ini.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Versión de PHP no soportada: ( ver',
    'LBL_DB_UNAVAILABLE'                => 'Base de datos no disponible',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'No se encontró Soporte de Base de Datos. Por favor asegúrese de tener los drivers necesarios para alguna de las siguientes Base de Datos soportadas: MySQL o MS SqlServer. Puede que sea necesario descomentar la extensión correspondiente en el archivo php.ini, o recompilar con el binario correspondiente, dependiendo de su versión de PHP. Por favor consulte el manual de PHP para más información sobre cómo habilitar el Soporte de Base de Datos.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'No se encontraron las funciones de las librerías de XML Parsing necesarias para ejecutar SuiteCRM. Puede que sea necesario descomentar la extensión correspondiente en el archivo php.ini, o recompilar con el binario correspondiente, dependiendo de su versión de PHP. Por favor consulte el manual de PHP para más información.',
    'ERR_CHECKSYS_MBSTRING'             => 'No se encontraron las funciones asociadas con la extensión Multibyte Strings (mbstring) necesaria para ejecutar SuiteCRM. <br/><br/>Generalmente el módulo mbstring no está habilitado por defecto en PHP y debe ser activado con --enable-mbstring al momento de compilar PHP. Por favor consulte el manual de PHP para más información sobre cómo habilitar mbstring.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'El parámetro session.save_path de su archivo de configuración (php.ini) no está correctamente asignado, o está establecido un directorio que no existe. Puede que sea necesario asignar el parámetro save_path en el archivo php.ini o verificar que la carpeta establecida en save_path existe.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'El parámetro de configuración session.save_path en su archivo de configuración (php.ini) está asignado a un directorio que no tiene permisos de escritura. Por favor realice los pasos necesarios para dar permisos de escritura. <br/>Dependiendo de su Sistema Operativo puede llegar a neccesitar cambiar los permisos ejecutando chmod 766, o con click derecho sobre el archivo para acceder al menú propiedades y desactivar la opción "sólo lectura".',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'The config file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'El archivo de configuración existe pero no se puede escribir. Por favor realice los pasos necesarios para dar permisos de escritura. <br/>Dependiendo de su Sistema Operativo puede llegar a neccesitar cambiar los permisos ejecutando chmod 766, o con click derecho sobre el archivo para acceder al menú propiedades y desactivar la opción "sólo lectura".',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'El archivo config override existe pero no se puede escribir. Por favor realice los pasos necesarios para dar permisos de escritura. <br/>Dependiendo de su Sistema Operativo puede llegar a neccesitar cambiar los permisos ejecutando chmod 766, o con click derecho sobre el archivo para acceder al menú propiedades y desactivar la opción "sólo lectura".',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'El directorio Custom existe pero no se puede escribir. Por favor realice los pasos necesarios para dar permisos de escritura. <br/>Dependiendo de su Sistema Operativo puede llegar a neccesitar cambiar los permisos ejecutando chmod 766, o con click derecho sobre el archivo para acceder al menú propiedades y desactivar la opción "sólo lectura".',
    // The files or directories listed below are not writeable or are missing and cannot be created.  Depending on your Operating System, correcting this may require you to change permissions on the files or parent directory (chmod 755), or to right click on the parent directory and uncheck the 'read only' option and apply it to all subfolders.",
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => 'Los archivos o directorios listados más abajo no se pueden escribir. Dependiendo de su Sistema Operativo, corregir esto puede requerir que cambie los permisos de los archivos o directorio padre (chmod 755), o click derecho en la carpeta padre, desactivar la opción "sólo lectura" y aplicarla a todas las subcarpetas. ',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode está activado (puede ser conveniente deshabilitarlo en php.ini)',
    'ERR_CHECKSYS_ZLIB'					=> 'ZLib no se encontró: SuiteCRM alcanza grandes beneficios de performance con la compresión zlib.',
    'ERR_CHECKSYS_ZIP'					=> 'ZIP no se encontró: SuiteCRM necesita soporte ZIP para procesar archivos comprimidos.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE no se encontró: SuiteCRM necesita la librería PCRE para procesar expresiones regulares en el estilo Perl.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE versión de librería: SuiteCRM necesita la versión 7.0 o superior de la librería PCRE para procesar expresiones regulares en el estilo Perl.',
	'ERR_DB_ADMIN'						=> 'El nombre de usuario o contraseña del administrador de base de datos es inválido, y no se puede establecer la conexión con la base de datos. Por favor ingrese un nombre de usuario y contraseña correctos. (Error: ',
    'ERR_DB_ADMIN_MSSQL'                => 'El nombre de usuario o contraseña del administrador de base de datos es inválido, y no se puede establecer la conexión con la base de datos. Por favor ingrese un nombre de usuario y contraseña correctos.',

	'ERR_DB_EXISTS_NOT'					=> 'La base de datos especificada no existe.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'La base de datos ya existe con información de configuración. Para ejecutar una instalación con la base de datos seleccionada vuelva a ejecutar la instalación y seleccione "Eliminar las tablas existentes y volver a crearlas?". Para actualizar utilice el Asistente de Actualizaciones en la Consola de Administración. Por favor lea la documentación de actualización <a href="http://www.suitecrm.com target="_new">aquí</a>',
	'ERR_DB_EXISTS'						=> 'Ya existe una Base de Datos con el nombre provisto -- no se puede crear otra con el mismo nombre.',
	// hit the back button and choose a new database name <br>2.  click next and continue but all existing tables on this database will be dropped.  <strong>This means your tables and data will be blown away.</strong>',
    'ERR_DB_EXISTS_PROCEED'             => 'Ya existe una Base de Datos con el nombre provisto.  Usted puede<br>1.  presionar el botón Atrás y seleccionar un nuevo nombre de base de datos <br>2.  hacer click en Siguiente y continuar, aunque todas las tablas existentes en esta base de datos serán descartadas.  <strong>Esto significa que sus tablas e información serán eliminadas </strong>',
	'ERR_DB_HOSTNAME'					=> 'El nombre de Host no puede ser vacío.',
	'ERR_DB_INVALID'					=> 'Tipo de base de datos seleccionado no válido.',
	'ERR_DB_LOGIN_FAILURE'				=> 'El host, nombre de usuario y/o contraseña provistos no es válido, y no se puede establecer una conexión a la base de datos. Por favor ingrese un host, nombre de usuario y contraseña válidos.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'El host, nombre de usuario y/o contraseña provistos no es válido, y no se puede establecer una conexión a la base de datos. Por favor ingrese un host, nombre de usuario y contraseña válidos.',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'El host, nombre de usuario y/o contraseña provistos no es válido, y no se puede establecer una conexión a la base de datos. Por favor ingrese un host, nombre de usuario y contraseña válidos.',
	'ERR_DB_MYSQL_VERSION'				=> 'Su versión de MySQL (%s) no es soportada por SuiteCRM.  Deberá instalar una versión que sea compatible con SuiteCRM. Por favor consulte la Matriz de Compatibilidad en las Notas de Versión para conocer las versiones soportadas.',
	'ERR_DB_NAME'						=> 'El nombre de base de datos no puede estar vacío.',
	'ERR_DB_NAME2'						=> "El nombre de base de datos no puede contener '\\', '/', o '.'",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "El nombre de base de datos no puede contener '\\', '/', o '.'",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "El nombre de base de datos no puede comenzar con un número, '#', o '@' y no puede contener espacios, '\"', \"'\", '*', '/', '\', '?', ':', '<', '>', '&', '!', o '-'",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "El nombre de base de datos sólo puede estar formado por caracteres alfanuméricos y los símbolos '#', '_' o '$'",
	'ERR_DB_PASSWORD'					=> 'Las contraseñas provistas para el administrador de base de datos no coinciden.  Por favor vuelva a ingresar las mismas contraseñas en los campos.',
	'ERR_DB_PRIV_USER'					=> 'Provea un nombre de usuario administrador de base de datos.  El usuario es requerido para la conexión inicial a la base de datos.',
	'ERR_DB_USER_EXISTS'				=> 'El nombre de usuario para la base de datos ya existe -- no se puede crear otro con el mismo nombre. Por favor ingrese un nuevo nombre de usuario.',
	'ERR_DB_USER'						=> 'Ingrese un nombre de usuario para el administrador de base de datos.',
	'ERR_DBCONF_VALIDATION'				=> 'Por favor corrija los siguientes errores antes de continuar:',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'Las contraseñas provistas para el administrador de base de datos no coinciden.  Por favor vuelva a ingresar las mismas contraseñas en los campos.',
	'ERR_ERROR_GENERAL'					=> 'Se encontraron los siguientes errores:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'No se puede eliminar el archivo: ',
	'ERR_LANG_MISSING_FILE'				=> 'No se encuentra el archivo: ',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'No se encontró archivo de traducción en include/language dentro de: ',
	'ERR_LANG_UPLOAD_1'					=> 'Hubo un problema con su upload.  Por favor vuelva a intentarlo.',
	'ERR_LANG_UPLOAD_2'					=> 'Los paquetes de idioma deben ser archivos ZIP.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP no pudo mover el archivo temporal a la carpeta upgrade.',
	'ERR_LICENSE_MISSING'				=> 'Faltan Campos Obligatorios',
	'ERR_LICENSE_NOT_FOUND'				=> 'No se encontró la licencia!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'El directorio de Log provisto no es un directorio válido.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'El directorio de Log provisto no tiene permisos de escritura.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Se requiere un directorio de Log si usted desea especificar uno.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'No se puede procesar el script de forma directa.',
	'ERR_NO_SINGLE_QUOTE'				=> 'No se puede usar comillas simples para ',
	'ERR_PASSWORD_MISMATCH'				=> 'Las contraseñas provistas para el usuario admin de SuiteCRM no coinciden.  Por favor vuelva a ingresar las mismas contraseñas en los campos.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'No se puede escribir el archivo <span class=stop>config.php</span>.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Puedecontinuar con esta instalación creando manualmente el archivo config.php y pegando la siguiente información de configuración dentro del archivo.  De todos modos, usted <strong>debería </strong>crear el archivo config.php antes de continuar con el siguiente paso.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'Se acordó de crear el archivo config.php?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Advertencia: No se pudo escribir el archivo config.php.  Asegúrese de que existe.',
	'ERR_PERFORM_HTACCESS_1'			=> 'No es puede escribir el archivo ',
	'ERR_PERFORM_HTACCESS_2'			=> ' .',
	'ERR_PERFORM_HTACCESS_3'			=> 'Si desea proteger su archivo de log de ser accedido via navegador, cree un archivo .htaccess en su carpeta log con la línea:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>No hemos podido detectar una conexión a Internet.</b> Cuando tenga una conexión, por favor visite <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> para registrarse con SuiteCRM. Si nos cuenta un poco cómo su compañía planea utilizar SuiteCRM podremos asegurarnos de entregarle la aplicación correcta para las necesidades de su negocio.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'El directorio de Sesión provisto no es un directorio válido.',
	'ERR_SESSION_DIRECTORY'				=> 'El directorio de Sesión provisto no tiene permisos de escritura.',
	'ERR_SESSION_PATH'					=> 'Se requiere una ruta de Sesión, si es que desea especificar una.',
	'ERR_SI_NO_CONFIG'					=> 'No incluyó el archivo config_si.php en el directorio raíz, o no definió la variable $sugar_config_si en config.php',
	'ERR_SITE_GUID'						=> 'Se requiere un ID de Aplicación si es que desea especificar uno.',
    'ERROR_SPRITE_SUPPORT'              => "No hemos podido encontrar la librería GD, como resultado no podrá utilizar la funcionalidad CSS Sprite.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Advertencia: Debe cambiar su configuración de PHP para permitir la subida de archivos de al menos 6MB.',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Tamaño de Subida de Archivos',
	'ERR_URL_BLANK'						=> 'Provea la URL base para su instancia de SuiteCRM.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'No se pudo encontrar el registro de instalación de ',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'El archivo subido no es compatible con esta edición (Community Edition, Professional, o Enterprise) de SuiteCRM: ',
	'ERROR_LICENSE_EXPIRED'				=> "Error: Su licencia expiró hace ",
	//																																																			                                If you do not enter a new license key within 30 days of your license key expiration, you will no longer be able to log in to this application.",
	'ERROR_LICENSE_EXPIRED2'			=> " día(s).   Por favor visite el <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administrador de Licencias\"</a>  en la pantalla de administrador para ingresar la nueva Clave.  Si no ingresa una nueva clave de licencia dentro de los 30 días de expirada, ya no se le permitirá ingresar en la aplicación. ",
	'ERROR_MANIFEST_TYPE'				=> 'El archivo Manifest debe especificar el tipo de paquete.',
	'ERROR_PACKAGE_TYPE'				=> 'El archivo Manifest especifica un tipo de paquete no reconocido',
	'ERROR_VALIDATION_EXPIRED'			=> "Error: Su licencia expiró hace ",
	'ERROR_VALIDATION_EXPIRED2'			=> " día(s).   Por favor visite el <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administrador de Licencias\"</a>  en la pantalla de administrador para ingresar la nueva Clave.  Si no ingresa una nueva clave de licencia dentro de los 30 días de expirada, ya no se le permitirá ingresar en la aplicación. ",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'El archivo subido no es compatible con esta versión de SuiteCRM: ',

	'LBL_BACK'							=> 'Atrás',
    'LBL_CANCEL'                        => 'Cancelar',
    'LBL_ACCEPT'                        => 'Acepto',
	'LBL_CHECKSYS_1'					=> 'Para que su instalación de SuiteCRM funcione correctamente, por favor asegúrese de que todos los items por verificar listados más abajo estén en verde. Si encuentra alguno en rojo, por favor realice los pasos necesarios para solucionarlos.<BR><BR> Para obtener ayuda por estos items, visite <a href="http://www.suitecrm.com" target="_blank">SuiteCRM</a>.',
	'LBL_CHECKSYS_CACHE'				=> 'Sub-Directories de Cache Editables',
	//'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned On',
    'LBL_DROP_DB_CONFIRM'               => 'El nombre de Base de Datos provisto ya existe. <br>Usted puede<br>1.  presionar el botón Atrás y seleccionar un nuevo nombre de base de datos <br>2.  hacer click en Siguiente y continuar, aunque todas las tablas existentes en esta base de datos serán descartadas.  <strong>Esto significa que sus tablas e información serán eliminadas </strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference desactivado',
    'LBL_CHECKSYS_COMPONENT'			=> 'Componente',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Componentes Opcionales',
	'LBL_CHECKSYS_CONFIG'				=> 'Archivo de Configuración editable (config.php)',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Archivo de Configuración editable (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'Módulo cURL',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Ruta del Directorio de Sesión',
	'LBL_CHECKSYS_CUSTOM'				=> 'Directorio Custom editable',
	'LBL_CHECKSYS_DATA'					=> 'Subdirectorios de Data editables',
	'LBL_CHECKSYS_IMAP'					=> 'Módulo IMAP',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'Módulo MB Strings',
	'LBL_CHECKSYS_MEM_OK'				=> 'OK (Sin Límite)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'OK (Ilimitado)',
	'LBL_CHECKSYS_MEM'					=> 'Límite de Memoria PHP',
	'LBL_CHECKSYS_MODULE'				=> 'Subdirectorios y Archivos de módulos editables',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'Versión MySQL',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'No disponible',
	'LBL_CHECKSYS_OK'					=> 'OK',
	'LBL_CHECKSYS_PHP_INI'				=> 'Ubicación de su archivo de configuración PHP (php.ini):',
	'LBL_CHECKSYS_PHP_OK'				=> 'OK (ver ',
	'LBL_CHECKSYS_PHPVER'				=> 'Versión de PHP',
    'LBL_CHECKSYS_IISVER'               => 'Versión de IIS',
    'LBL_CHECKSYS_FASTCGI'              => 'FastCGI',
	'LBL_CHECKSYS_RECHECK'				=> 'Volver a Verificar',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP Safe Mode desactivado',
	'LBL_CHECKSYS_SESSION'				=> 'Directorio de Sesión Editable (',
	'LBL_CHECKSYS_STATUS'				=> 'Estado',
	'LBL_CHECKSYS_TITLE'				=> 'Aceptación de Verificación del Sistema',
	'LBL_CHECKSYS_VER'					=> 'Encontrado: ( ver ',
	'LBL_CHECKSYS_XML'					=> 'XML Parsing',
	'LBL_CHECKSYS_ZLIB'					=> 'Módulo de Compresión ZLIB',
	'LBL_CHECKSYS_ZIP'					=> 'Módulo de manejo de ZIP',
	'LBL_CHECKSYS_PCRE'					=> 'Librería PCRE',
	'LBL_CHECKSYS_FIX_FILES'            => 'Por favor corrija los siguientes archivos o directorios antes de continuar:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Por favor corrija los siguientes directorios de módulos y archivos dentro de ellos antes de continuar:',
    'LBL_CHECKSYS_UPLOAD'               => 'Directorio Upload Editable',
    'LBL_CLOSE'							=> 'Cerrar',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'creada',
	'LBL_CONFIRM_DB_TYPE'				=> 'Tipo de Base de Datos',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Por favor confirme la siguiente configuración.  Se desea cambiar alguno de los valores, haga click en "Atrás" para editar. De lo contrario haga click en "Siguiente" para comenzar la instalación.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Información de la Licencia',
	'LBL_CONFIRM_NOT'					=> 'no',
	'LBL_CONFIRM_TITLE'					=> 'Confirmar configuración',
	'LBL_CONFIRM_WILL'					=> 'será',
	'LBL_DBCONF_CREATE_DB'				=> 'Crear Base de Datos',
	'LBL_DBCONF_CREATE_USER'			=> 'Crear Usuario',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Atención: Toda la información de SuiteCRM será eliminada<br>si se marca esta casilla.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Eliminar las tablas existentes y volver a crearlas?',
    'LBL_DBCONF_DB_DROP'                => 'Eliminar Tablas',
    'LBL_DBCONF_DB_NAME'				=> 'Nombre de Base de Datos',




    
	'LBL_DBCONF_DB_PASSWORD'			=> 'Contraseña del Usuario de Base de Datos',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Vuelva a Ingresar Contraseña del Usuario de Base de Datos',
	'LBL_DBCONF_DB_USER'				=> 'Nombre de Usuario de Base de Datos',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'Nombre de Usuario de Base de Datos',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Nombre de Usuario del Administrador de Base de Datos',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Contraseña del Administrador de Base de Datos',
	'LBL_DBCONF_DEMO_DATA'				=> 'Llenar la Base de Datos con Información de Prueba?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Seleccionar Información de Prueba',
	'LBL_DBCONF_HOST_NAME'				=> 'Nombre del Host',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Instancia del Host',
	'LBL_DBCONF_HOST_PORT'				=> 'Puerto',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Por favor ingrese la información de su configuración a continuación. Si no está seguro de lo que debe completar, le sugerimos que use los valores por defecto.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Usar texto multi-byte en la información de prueba?',
    'LBL_DBCONFIG_MSG2'                 => 'Nombre del Servidor Web o Equipo (Host) en la cual se encuentra la base de datos ( por ejemplo localhost o www.mydomain.com ):',
    'LBL_DBCONFIG_MSG3'                 => 'Nombre de la base de datos que contendrá la información de la instancia de SuiteCRM que está a punto de instalar:',
    'LBL_DBCONFIG_B_MSG1'               => 'The username and password of a database administrator who can create database tables and users and who can write to the database is necessary in order to set up the SuiteCRM database.',
    'LBL_DBCONFIG_B_MSG1'               => 'Para configurar la base de datos de SuiteCRM es necesario el nombre de usuario y contraseña de un administrador de base de datos que pueda crear las tablas, usuarios y escribir en ella.',
    'LBL_DBCONFIG_SECURITY'             => 'Por razones de seguridad, se puede especificar un usuario exclusivo para conectar a la base de datos de SuiteCRM. Este usuario debe ener permisos para escribir, modificar y recuperar información de la base de datos de SuiteCRM que será creada para esta instancia. Este usuario puede ser el administrador de base de datos que se especificó más arriba, usted puede proveer uno nuevo o uno existente.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Hazlo por mi',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Proveer usuario existente',
    'LBL_DBCONFIG_CREATE_DD'            => 'Definir un usuario que se creará',
    'LBL_DBCONFIG_SAME_DD'              => 'El mismo que el Administrador',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'Búsqueda Full-Text',
    'LBL_FTS_INSTALLED'                 => 'Instalado',
    'LBL_FTS_INSTALLED_ERR1'            => 'La característica de Búsqueda Full-Text no está instalada.',
    'LBL_FTS_INSTALLED_ERR2'            => 'Usted puede realizar la instalación, pero no podrá utilizar la funcionalidad de Búsqueda Full-Text. Por favor consulte la guía de instalación de su servidor de base de datos para saber cómo hacer esto, o contacte a su Administrador.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Contraseña del usuario privilegiado de la Base de Datos',

	'LBL_DBCONF_PRIV_USER_2'			=> '¿La cuenta de base de datos de arriba es de un Usuario Privilegiado?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'Este usuario privilegiado de base de datos debe tener los permisos adecuados para crear una base de datos, eliminar/crear tablas, y crear un usuario. Este usuario privilegiado de base de datos sólo será utilizado para realizar las tareas necesarias durante el proceso de instalación. Si este usuario tiene permisos suficientes, también puede utilizarlo como usuario de base de datos.',
	'LBL_DBCONF_PRIV_USER'				=> 'Nombre del Usuario Privilegiado de Base de Datos',
	'LBL_DBCONF_TITLE'					=> 'Configuración de la Base de Datos',
    'LBL_DBCONF_TITLE_NAME'             => 'Provea un Nombre de Base de Datos',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Provea la información del usuario de la base de datos',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Después de realizado este cambio, podrá hacer click en el botón "Comenzar" de abajo para comenzar la instalación. <i>Una vez finalizada la instalación, puede cambiar el valor de \'installer_locked\' a \'true\'.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'La instalación ya se ejecutó una vez. Como medida de seguridad se ha deshabilitado una segunda ejecución. Si está absolutamente seguro de que quiere volver a ejecutarla, por favor vaya a su archivo config.php y encuentre (o agregue) una variable llamada \'installer_locked\' y colóquela en \'false\'. La línea debería quedar así:',

	'LBL_DISABLED_HELP_1'				=> 'Para ayuda con la instalación, por favor visite ',
    'LBL_DISABLED_HELP_LNK'               => 'http://www.suitecrm.com/forums/',
	'LBL_DISABLED_HELP_2'				=> 'foro de soporte de SuiteCRM',

	'LBL_DISABLED_TITLE_2'				=> 'La instalación de SuiteCRM ha sido deshabilitada',
	'LBL_DISABLED_TITLE'				=> 'Instalación de SuiteCRM Deshabilitada',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Juego de Caracteres comunmente usado en su zona',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Configuración de Email Saliente',
    'LBL_EMAIL_CHARSET_CONF'            => 'Juego de Caracteres para el Email Saliente ',
	'LBL_HELP'							=> 'Ayuda',
    'LBL_INSTALL'                       => 'Instalar',
    'LBL_INSTALL_TYPE_TITLE'            => 'Opciones de Instalación',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Seleccione el Tipo de Instalación',
    'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>Instalación Típica</b>',
    'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>Instalación Personalizada</b>',
    'LBL_INSTALL_TYPE_MSG1'             => 'La clave es necesaria para la funcionalidad general de la aplicación, pero no es necesaria para la instalación. No es necesario que ingrese la clave ahora, pero deberá proveerla después de haber instalado la aplicación.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Requiere información mínima para la instalación. Recomendada para usuarios nuevos.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Provee opciones adicionales a establecer durante la instalación. La mayor parte de estas opciones también están disponibles después de la instalación en la pantalla de administración. Recomendada para usuarios avanzados.',
	'LBL_LANG_1'						=> 'Para usar otro idioma diferente al idioma por defecto (US-English), puede subir e instalar un paquete de idioma en este momento. También podrá subir e instalar paquetes de idioma desde adentro de la aplicación. Si quiere omitir este paso, haga click en Siguiente.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Instalar',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Quitar',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Desinstalar',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Subir',
	'LBL_LANG_NO_PACKS'					=> 'ninguno',



	'LBL_LANG_PACK_INSTALLED'			=> 'Se instalaron los siguientes paquetes de idioma: ',
	'LBL_LANG_PACK_READY'				=> 'Los siguientes paquetes de idioma están listos para ser instalados: ',
	'LBL_LANG_SUCCESS'					=> 'Se subió correctamente el paquete de idioma.',
	'LBL_LANG_TITLE'			   		=> 'Paquete de Idioma',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Instalando SuiteCRM.  Este proceso puede tomar unos minutos.',
	'LBL_LANG_UPLOAD'					=> 'Subir un Paquete de Idioma',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Aceptación de Licencia',
    'LBL_LICENSE_CHECKING'              => 'Verificando la compatibilidad del sistema.',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Verificando el entorno',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Verificando las credenciales de BD.',
    'LBL_LICENSE_CHECK_PASSED'          => 'El sistema cumplió los requisitos.',
	'LBL_CREATE_CACHE' => 'Preparando para instalar...',
    'LBL_LICENSE_REDIRECT'              => 'Redireccionando en ',
	'LBL_LICENSE_DIRECTIONS'			=> 'Si tiene la información de su licencia, por favor ingrésela en los siguientes campos.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Ingresar Clave de Descarga',
	'LBL_LICENSE_EXPIRY'				=> 'Fecha de Vencimiento',
	'LBL_LICENSE_I_ACCEPT'				=> 'Acepto',
	'LBL_LICENSE_NUM_USERS'				=> 'Cantidad de Usuarios',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Por favor ingrese la cantidad de clientes offline adquiridos.',
	'LBL_LICENSE_OC_NUM'				=> 'Cantidad de Licencias de Clientes Offline',
	'LBL_LICENSE_OC'					=> 'Licencias de Clientes Offline',
	'LBL_LICENSE_PRINTABLE'				=> ' Versión Imprimible ',
    'LBL_PRINT_SUMM'                    => 'Imprimir Resumen',
	'LBL_LICENSE_TITLE_2'				=> 'Licencia SuiteCRM',
	'LBL_LICENSE_TITLE'					=> 'Información de Licencia',
	'LBL_LICENSE_USERS'					=> 'Licencias de Usuario',

	'LBL_LOCALE_CURRENCY'				=> 'Opciones de Moneda',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Moneda por Defecto',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Símbolo de Moneda',
	'LBL_LOCALE_CURR_ISO'				=> 'Código de Moneda(ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> 'Separador de Miles',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Separador Decimal',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Ejemplo',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Dígitos Significativos',
	'LBL_LOCALE_DATEF'					=> 'Formato de Fecha por Defecto',
	'LBL_LOCALE_DESC'					=> 'La configuración regional se verá reflejada globalmente en la instancia de SuiteCRM.',
	'LBL_LOCALE_EXPORT'					=> 'Juego de Caracteres para Importar/Exportar<br> <i>(Email, .csv, vCard, PDF, importación de datos)</i>',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Delimitador para Exportación (.csv)',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Opciones de Importación/Exportación',
	'LBL_LOCALE_LANG'					=> 'Idioma por Defecto',
	'LBL_LOCALE_NAMEF'					=> 'Formato de Nombre por Defecto',
	'LBL_LOCALE_NAMEF_DESC'				=> 's = saludo<br />f = nombre de pila<br />l = apellido',
	'LBL_LOCALE_NAME_FIRST'				=> 'David',
	'LBL_LOCALE_NAME_LAST'				=> 'Livingstone',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Dr.',
	'LBL_LOCALE_TIMEF'					=> 'Formato de Hora por Defecto',
	'LBL_LOCALE_TITLE'					=> 'Configuración Regional',
    'LBL_CUSTOMIZE_LOCALE'              => 'Personalizar Configuración Regional',
	'LBL_LOCALE_UI'						=> 'Interfaz de Usuario',

	'LBL_ML_ACTION'						=> 'Acción',
	'LBL_ML_DESCRIPTION'				=> 'Descripción',
	'LBL_ML_INSTALLED'					=> 'Fecha de Instalación',
	'LBL_ML_NAME'						=> 'Nombre',
	'LBL_ML_PUBLISHED'					=> 'Fecha de Publicación',
	'LBL_ML_TYPE'						=> 'Tipo',
	'LBL_ML_UNINSTALLABLE'				=> 'Desinstalable',
	'LBL_ML_VERSION'					=> 'Version',
	'LBL_MSSQL'							=> 'SQL Server',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver para PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (extensión mysqli)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Siguiente',
	'LBL_NO'							=> 'No',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Estableciendo password de admin',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'tabla de auditoría / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Creando el archivo de configuración de SuiteCRM',
	'LBL_PERFORM_CREATE_DB_1'			=> '<b>Creando la base de datos</b> ',
	'LBL_PERFORM_CREATE_DB_2'			=> ' <b>en</b> ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Creando nombre de usuario y password de la Base de datos...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Creando información por defecto de SuiteCRM',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Creando nombre de usuario y password de base de datos para localhost...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Creando tablas de relación para suiteCRM',
	'LBL_PERFORM_CREATING'				=> 'creando / ',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Creando reportes por defecto',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Creando tareas planificadas por defecto',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Insertando configuración por defecto',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Creando usuarios por defecto',
	'LBL_PERFORM_DEMO_DATA'				=> 'Llenando las tablas de la base de datos con Información de Prueba (esto puede tomar varios minutos)',
	'LBL_PERFORM_DONE'					=> 'listo<br>',
	'LBL_PERFORM_DROPPING'				=> 'eliminando / ',
	'LBL_PERFORM_FINISH'				=> 'Finalizar',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Actualizando la información de la licencia',
	'LBL_PERFORM_OUTRO_1'				=> 'La configuración de SuiteCRM ',
	'LBL_PERFORM_OUTRO_2'				=> ' ha finalizado!',
	'LBL_PERFORM_OUTRO_3'				=> 'Tiempo total: ',
	'LBL_PERFORM_OUTRO_4'				=> ' segundos.',
	'LBL_PERFORM_OUTRO_5'				=> 'Memoria utilizada (aprox): ',
	'LBL_PERFORM_OUTRO_6'				=> ' bytes.',
	'LBL_PERFORM_OUTRO_7'				=> 'Su sistema ya está instalado y configurado para ser utilizado.',
	'LBL_PERFORM_REL_META'				=> 'metadatos de relaciones ... ',
	'LBL_PERFORM_SUCCESS'				=> 'Éxito!',
	'LBL_PERFORM_TABLES'				=> 'Creando las tablas de la aplicación, tablas de auditoría y metadatos de relaciones',
	'LBL_PERFORM_TITLE'					=> 'Configurar',
	'LBL_PRINT'							=> 'Imprimir',
	'LBL_REG_CONF_1'					=> 'Por favor complete el breve formulario a continuación para recibir anuncios de productos, novedades de capacitaciones, ofertas especiales e invitaciones epeciales a eventos de SuiteCRM. No vendemos, alquilamos, compartimos ni distribuimos de ninguna forma la información recolectada aquí.',
	'LBL_REG_CONF_2'					=> 'Su nombre y dirección de email son los únicos campos requeridos para la registración. El resto de los campos son opcionales, pero de mucha ayuda. No vendemos, alquilamos, compartimos ni distribuimos de ninguna forma la información recolectada aquí.',
	'LBL_REG_CONF_3'					=> 'Gracias por registrarse. Haga click en el botón Finalizar para ingresar a SuiteCRM. Necesitará ingresar por primera vez utilizando el nombre de usuario "admin" y la contraseña que ingresó en el paso 2.',
	'LBL_REG_TITLE'						=> 'Registración',
    'LBL_REG_NO_THANKS'                 => 'No Gracias',
    'LBL_REG_SKIP_THIS_STEP'            => 'Omitir este Paso',
	'LBL_REQUIRED'						=> '* Campo Requerido',

    'LBL_SITECFG_ADMIN_Name'            => 'Nombre del Administrador de SuiteCRM',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Vuelva a Ingresar la Contraseña del Usuario Administrador',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Atención: Esto sobreescribirá la contraseña del administrador de cualquier instalación anterior.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'Contraseña del Usuario Administrador',
	'LBL_SITECFG_APP_ID'				=> 'ID de la Aplicación',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'Si se selecciona, deberá proveer un ID de Aplicación para sobreescribir el ID autogenerado. El ID asegura que las sesiones de una instancia de SuiteCRM no sean usadas por otras instancia. Si tiene un cluster de instalaciones de SuiteCRM, todas deberían compartir el mismo ID de aplicación.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Provea su propio ID de Aplicación',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'Si se selecciona, deberá especificar un directorio de logs para sobreescribir el directorio por defecto del log de SuiteCRM. Sin importar dónde esté ubicado el archivo de log, el acceso a través de navegador se deberá restringir utilizando una redirección .htacces.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Utilizar un Directorio Personalizado para Logs',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'Si se selecciona, deberá proveer un directorio seguro para almacenar la información de sesiones de SuiteCRM. Esto se puede hacer para evitar que la información de la sesión sea vulnerada en servidores compartidos.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Utilizar un Directorio Personalizado para las Sesiones de SuiteCRM',
	'LBL_SITECFG_DIRECTIONS'			=> 'Por favor ingrese la configuración de su sitio a continuación. Si no está seguro de los campos, le sugerimos utilizar los valores por defecto.',
	'LBL_SITECFG_FIX_ERRORS'			=> '<b>Por favor corrija los siguientes errores antes de continuar:</b>',
	'LBL_SITECFG_LOG_DIR'				=> 'Directorio de Log',
	'LBL_SITECFG_SESSION_PATH'			=> 'Ruta del Directorio de Sesiones<br>(debe ser editable)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Seleccionar Opciones de Seguridad',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'Si se selecciona, el sistema periódicamente verificará por actualizaciones de la aplicación.',
	'LBL_SITECFG_SUGAR_UP'				=> '¿Verificar Automáticamente nuevas Actualizaciones?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Configuración de Actualizaciones de SuiteCRM',
	'LBL_SITECFG_TITLE'					=> 'Configuración del Sitio',
    'LBL_SITECFG_TITLE2'                => 'Identificar el Usuario Administrador',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Seguridad del Sitio',
	'LBL_SITECFG_URL'					=> 'URL de la Instancia de SuiteCRM',
	'LBL_SITECFG_USE_DEFAULTS'			=> '¿Utilizar valores por defecto?',
	'LBL_SITECFG_ANONSTATS'             => '¿Enviar estadísticas anónimas de uso?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'Si se selecciona, SuiteCRM enviará estadísticas <b>anónimas</b> acerca de su instalación a SuiteCRM Inc. cada vez que su sistema verifique nuevas versiones. Esta información nos ayudará a mejorar nuestra comprensión de cómo la aplicación es utilizada, y guiará las mejoras del producto.',
    'LBL_SITECFG_URL_MSG'               => 'Ingrese la URL que será utilizada para acceder a la instancia de SuiteCRM después de la instalación. La URL también va a ser utilizada como base para para las URL en las páginas de la aplicación. La URL puede incluir el nombre del servidor web, nombre del equipo o dirección IP.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Ingrese un nombre para su sistema. El nombre se mostrará en la barra de título del navegador cuando los usuarios visiten la aplicación SuiteCRM.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'Después de la instalación, necesitará utilizar el usuario administrador de SuiteCRM (nombre por defecto = admin) para ingresar a la instancia de SuiteCRM. Ingrese  una contraseña para este usuario administrador. Esta contraseña puede ser cambiada después de ingresar por primera vez. También puede ingresar otro nombre de usuario diferente al valor por defecto provisto.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Seleccione la configuración de collation (ordenamiento de los datos) para su sistema. Esta configuración creará las tablas con el idioma específico que usted usa. En caso de que su idioma no requiera una configuración especial, utilice el valor por defecto.',
    'LBL_SPRITE_SUPPORT'                => 'Soporte de Sprite',
	'LBL_SYSTEM_CREDS'                  => 'Credenciales del Sistema',
    'LBL_SYSTEM_ENV'                    => 'Entorno del Sistema',
	'LBL_START'							=> 'Comenzar',
    'LBL_SHOW_PASS'                     => 'Mostrar Contraseñas',
    'LBL_HIDE_PASS'                     => 'Ocultar Contraseñas',
    'LBL_HIDDEN'                        => '<i>(oculto)</i>',
//	'LBL_NO_THANKS'						=> 'Continue to installer',
	'LBL_CHOOSE_LANG'					=> '<b>Seleccione su idioma</b>',
	'LBL_STEP'							=> 'Paso',
	'LBL_TITLE_WELCOME'					=> 'Bienvenido a SuiteCRM ',
	'LBL_WELCOME_1'						=> 'Este instalador crea las tablas de la base de datos de SuiteCRM y establece los valores de configuración que ustede necesita para comenzar. El proceso completo debería tomar aproximadamente diez minutos.',
	'LBL_WELCOME_2'						=> 'Para obtener documentación de la instalación, por favor visite <a href="http://www.SuiteCRM.com/" target="_blank">SuiteCRM</a>.  <BR><BR> También podrá encontrar ayuda de la Comunidad de SuiteCRM en los <a href="http://www.SuiteCRM.com/" target="_blank">Foros de SuiteCRM</a>.',
    //welcome page variables
    'LBL_TITLE_ARE_YOU_READY'            => 'Está listo para instalar?',
    'REQUIRED_SYS_COMP' => 'Componentes de Sistema Requeridos',
    'REQUIRED_SYS_COMP_MSG' =>
                    'Antes de comenzar, por favor asegúrese de que tiene las versiones soportadas de los siguientes componentes del sistema:<br>
                      <ul>
                      <li> Base de Datos/Sistema Manejador de Base de Datos (Ejemplos: MariaDB, MySQL or SQL Server)</li>
                      <li> Servidor Web (Apache, IIS)</li>
                      </ul>
                      Consulte la Matriz de Compatibilidad en las Notas de la Versión para encontrar
                      componentes de sistema compatibles para la versión de SuiteCRM que está instalando<br>',
    'REQUIRED_SYS_CHK' => 'Chequeo Inicial del Sistema',
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
                      <li> <b>URL que será utilizada para acceder a la instancia de SugarCRM</b> después de ser instalada.
                      Esta URL puede incluir el nombre o dirección IP del servidor o equipo.<br><br></li>
                                  <li> [Opcional] <b>Ruta del directorio de sesión</b> si desea utilizar un directorio personalizado para la información de SuiteCRM con el objetivo de evitar vulnerabilidad en servidores compartidos.<br><br></li>
                                  <li> [Opcional] <b>Ruta personalizada del directorio de log</b> si desea sobreescribir el directorio por defecto utilizado para los archivos de log de SuiteCRM.<br><br></li>
                                  <li> [Opcional] <b>ID de Aplicación</b> si desea sobreescribir el ID autogenerado para garantizar que las sesiones de una instancia de SuiteCRM no son utilizadas por otras instancias.<br><br></li>
                                  <li><b>Set de Caracteres</b> comunmente utilizado según su zona.<br><br></li></ul>
                                  Para obtener información más detallada, por favor consulte la Guía de Instalación.
                                ',

    'LBL_WELCOME_PLEASE_READ_BELOW' => 'Por favor lea la siguiente información importante antes de continuar con la instalación . La información le ayudará a determinar si está listo o no para instalar la aplicación en este momento.',

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '<b>Seleccione su idioma</b>',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Asistente de Configuración',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Bienvenido a SuiteCRM ',
	'LBL_WELCOME_TITLE'					=> 'Asistente de Configuración de SuiteCRM',
	'LBL_WIZARD_TITLE'					=> 'Asistente de Configuración de SuiteCRM: ',
	'LBL_YES'							=> 'Sí',
    'LBL_YES_MULTI'                     => 'Sí - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Procesar Tareas de Workflow',
	'LBL_OOTB_REPORTS'		=> 'Ejecutar Generación de Reportes Planificados',
	'LBL_OOTB_IE'			=> 'Verificar el Correo Entrante',
	'LBL_OOTB_BOUNCE'		=> 'Procesar Rebotes de Emails de Campañas',
    'LBL_OOTB_CAMPAIGN'		=> 'Procesar Emails de Campañas',
	'LBL_OOTB_PRUNE'		=> 'Limpiar la Base de Datos el 1er día del Mes',
    'LBL_OOTB_TRACKER'		=> 'Limpiar las Tablas de Seguimiento',
    'LBL_OOTB_SUGARFEEDS'   => 'Limpiar las Tablas de SuiteCRM Feed',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Ejecutar Notificaciones de Recordatorios por Email',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Actualizar la Tabla tracker_sessions',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Limpiar Cola de Tareas',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Quitar Documentos del Filesystem',


    'LBL_PATCHES_TITLE'     => 'Instalar los Ultimos Parches',
    'LBL_MODULE_TITLE'      => 'Instalar Paquetes de Idioma',
    'LBL_PATCH_1'           => 'Si desea omitir este paso, haga click en Siguiente.',
    'LBL_PATCH_TITLE'       => 'Parche del Sistema',
    'LBL_PATCH_READY'       => 'Los siguientes parches están listos para ser instalados:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM depende de las Sesiones de PHP para almacenar información importante mientras se conecta al servidor web. Su instalación de PHP no tiene la información de Sesiones correctamente configurada. 
	<br><br>Un problema común de configuración es que la directiva <b>'session.save_path'</b> no está señalando un directorio válido. <br>
	<br> Por favor corrija su <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>configuración PHP</a> en el archivo php.ini ubicado a continuación.",
	'LBL_SESSION_ERR_TITLE'				=> 'Error de Configuración de Sesiones PHP',
	'LBL_SYSTEM_NAME'=>'Nombre del Sistema',
    'LBL_COLLATION' => 'Configuración de Collation',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Provea un Nombre de Sistema para su instancia SuiteCRM.',
	'LBL_PATCH_UPLOAD' => 'Seleccione un archivo de parche de su equipo local',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Se requiere Php versión 5 o superior.',
	'LBL_MINIMUM_PHP_VERSION' => 'La versión mínima de PHP requerida es 5.1.0. La versión recomendada es 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(Su versión actual es ',
	'LBL_RECOMMENDED_PHP_VERSION' =>' La versión recomendada es 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'El modo Compatibilidad con versiones anteriores de PHP está activado. Establezca zend.ze1_compatibility_mode en Off para poder continuar.',

    'advanced_password_new_account_email' => array(
        'subject' => 'Información de la Nueva Cuenta de Usuario',
        'description' => 'Esta plantilla es utilizada cuando un Administrador de Sistema envía una nueva contraseña a un usuario.',
        'body' => '<div><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width="550" align=\"\&quot;\&quot;center\&quot;\&quot;\"><tbody><tr><td colspan=\"2\"><p>Aquí está su nuevo nombre de usuario y contraseña temporal:</p><p>Nombre de Usuario : $contact_user_user_name </p><p>Contraseña : $contact_user_user_hash </p><br><p>$config_site_url</p><br><p>Después de ingresar utilizando la contraseña de arriba, puede que se le pida cambiar la contraseña por una de su propia elección.</p>   </td>         </tr><tr><td colspan=\"2\"></td>         </tr> </tbody></table> </div>',
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
        'body' => '<div><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width="550" align=\"\&quot;\&quot;center\&quot;\&quot;\"><tbody><tr><td colspan=\"2\"><p>Recientemente ($contact_user_pwd_last_changed) ha requerido reestablecer la contraseña de su cuenta. </p><p>Haga click en el siguiente enlace para reestablecer su contraseña:</p><p> $contact_user_link_guid </p>  </td>         </tr><tr><td colspan=\"2\"></td>         </tr> </tbody></table> </div>',
        'txt_body' =>
'
Recientemente ($contact_user_pwd_last_changed) ha requerido reestablecer la contraseña de su cuenta.

Haga click en el siguiente enlace para reestablecer su contraseña:

$contact_user_link_guid',
        'name' => 'Email de Contraseña Olvidada',
        ),
);

?>
