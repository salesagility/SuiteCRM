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
	'LBL_BASIC_SEARCH'					=> 'Einfache Suche',
	'LBL_ADVANCED_SEARCH'				=> 'Erweiterte Suche',
	'LBL_BASIC_TYPE'					=> 'Basic Type',
	'LBL_ADVANCED_TYPE'					=> 'Advanced Type',
	'LBL_SYSOPTS_1'						=> 'Bitte wählen Sie die folgenden Systemkonfigurations-Optionen.',
    'LBL_SYSOPTS_2'                     => 'What type of database will be used for the SuiteCRM instance you are about to install?',
	'LBL_SYSOPTS_CONFIG'				=> 'Systemkonfiguration',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Datenbank Auswahl',
    'LBL_SYSOPTS_DB_TITLE'              => 'Datenbank Typ',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Bitte beheben Sie die folgenden Fehler bevor Sie weiterfahren.:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Please make the following directory writable:',
    'ERR_DB_VERSION_FAILURE'			=> 'Unable to check database version.',
	'DEFAULT_CHARSET'					=> 'UTF-8',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Provide the user name for the SuiteCRM admin user. ',
	'ERR_ADMIN_PASS_BLANK'				=> 'SugarCRM admin Passwort darf nicht leer sein.',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'Errors have been detected during compatibility check.  In order for your SuiteCRM Installation to function properly, please take the proper steps to address the issues listed below and either press the recheck button, or try installing again.',
    'ERR_CHECKSYS_CALL_TIME'            => 'Allow Call Time Pass Reference ist On (sollte in php.ini auf Off gesetzt sein)',
	'ERR_CHECKSYS_CURL'					=> 'Nicht gefunden: Sugar Zeitplaner wird mit limitierter Funktionalität laufen.',
    'ERR_CHECKSYS_IMAP'					=> 'Nicht gefunden: Eingehende E-Mail und Kampagnen (E-Mails) benötigen die IMAP Bibliotheken. Keines wird funktionieren.',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC darf nicht aktivert sein wenn der MS SQL Server verwendet wird.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Warnung: ',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> '(Setzen Sie es auf ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M oder grösser setzen)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Minimale Version 4.1.2 - Gefunden: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Session Variabeln können nicht geschrieben/gelesen werden. Die Installation kann nicht fortgesetzt werden.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'Kein gültiges Verzeichnis',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Warnung: Keine Schreibrechte',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Unzulässige PHP Version installiert: (ver',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'Your version of IIS is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported IIS Versions. Your version is ',
	'ERR_CHECKSYS_FASTCGI'              => 'We detect that you are not using a FastCGI handler mapping for PHP. You will need to install/configure a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported Versions. Please see <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> for details ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'For optimal experience using IIS/FastCGI sapi, set fastcgi.logging to 0 in your php.ini file.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Nicht unterstützte PHP Version installiert: (ver',
    'LBL_DB_UNAVAILABLE'                => 'Database unavailable',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'Database Support was not found.  Please make sure you have the necessary drivers for one of the following supported Database Types: MySQL or MS SQLServer.  You might need to uncomment the extension in the php.ini file, or recompile with the right binary file, depending on your version of PHP.  Please refer to your PHP Manual for more information on how to enable Database Support.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'Functions associated with XML Parser Libraries that are needed by the SuiteCRM application were not found.  You might need to uncomment the extension in the  php.ini file, or recompile with the right binary file, depending on your version of PHP.  Please refer to your PHP Manual for more information.',
    'ERR_CHECKSYS_MBSTRING'             => 'Nicht gefunden: SugarCRM wird keine mutli-byte Buchstaben verarbeiten können. Das hat Auswirkungen auf E-Mails, die nicht mit dem UTF-8 Set codiert sind.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'The session.save_path setting in your php configuration file (php.ini) is not set or is set to a folder which did not exist. You might need to set the save_path setting in php.ini or verify that the folder sets in save_path exist.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'The session.save_path setting in your php configuration file (php.ini) is set to a folder which is not writeable.  Please take the necessary steps to make the folder writeable.  <br>Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'The config file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'The config override file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'The Custom Directory exists but is not writeable.  You may have to change permissions on it (chmod 766) or right click on it and uncheck the read only option, depending on your Operating System.  Please take the needed steps to make the file writeable.',
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "The files or directories listed below are not writeable or are missing and cannot be created.  Depending on your Operating System, correcting this may require you to change permissions on the files or parent directory (chmod 755), or to right click on the parent directory and uncheck the 'read only' option and apply it to all subfolders.",
    'LBL_CHECKSYS_OVERRIDE_CONFIG' => 'Config override',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode ist On (u. U. in php.ini abschalten)',
    'ERR_CHECKSYS_ZLIB'					=> 'Nicht gefunden: Die zlib Kompression bringt enorme Geschwindigkeitsvorteile.',
    'ERR_CHECKSYS_ZIP'					=> 'ZIP support not found: SuiteCRM needs ZIP support in order to process compressed files.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE library not found: SuiteCRM needs PCRE library in order to process Perl style of regular expression pattern matching.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE library version: SuiteCRM needs PCRE library 7.0 or above to process Perl style of regular expression pattern matching.',
	'ERR_DB_ADMIN'						=> 'Der Datenbank admin Benutzername und/oder Passwort ist falsch (Fehler\' ',
    'ERR_DB_ADMIN_MSSQL'                => 'The provided database administrator username and/or password is invalid, and a connection to the database could not be established.  Please enter a valid user name and password.',
	'ERR_DB_EXISTS_NOT'					=> 'Die angegebene Datenbank existiert nicht.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'Die Datenbank existiert bereits mit config Daten. Um eine Installation mit der gewählten Datenbank durchzuführen starten sie erneut den Installer und wählen Sie: "Drop and recreate existing SugarCRM tables?" Für Upgrades verwenden Sie den Upgrade Wizard im Admin Bereich. Bitte lesen Sie die Upgrade Dokumentation im <a href="http://www.sugarforge.org/content/downloads/" target="_blank">SugarForge</a>.',
	'ERR_DB_EXISTS'						=> 'Eine Datenbank mit dem Namen existiert bereits - es kann keine zweite mit dem gleichen Namen erstellt werden.',
    'ERR_DB_EXISTS_PROCEED'             => 'The provided Database Name already exists.  You can<br>1.  hit the back button and choose a new database name <br>2.  click next and continue but all existing tables on this database will be dropped.  <strong>This means your tables and data will be blown away.</strong>',
	'ERR_DB_HOSTNAME'					=> 'Der Hostname darf nicht leer sein.',
	'ERR_DB_INVALID'					=> 'Ungültiger Datenbank Typ gewählt.',
	'ERR_DB_LOGIN_FAILURE'				=> 'SugarCRM Datenbank Benutzername und/oder Passwort ist nicht korrekt.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'SugarCRM Datenbank Benutzername und/oder Passwort ist nicht korrekt (Fehler ',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'SugarCRM Datenbank Benutzername und/oder Passwort ist nicht korrekt.',
	'ERR_DB_MYSQL_VERSION'				=> 'Your MySQL version (%s) is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported MySQL versions.',
	'ERR_DB_NAME'						=> 'Der Name der Datenbank darf nicht leer sein.',
	'ERR_DB_NAME2'						=> "Database name cannot contain a '\\', '/', or '.'",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "Database name cannot contain a '\\', '/', or '.'",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "Database name cannot begin with a number, '#', or '@' and cannot contain a space, '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', '&', '!', or '-'",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "Database name can only consist of alphanumeric characters and the symbols '#', '_' or '$'",
	'ERR_DB_PASSWORD'					=> 'Passwörter für SugarCRM sind nicht gleich.',
	'ERR_DB_PRIV_USER'					=> 'Datenbank admin Benutzername wird benötigt.',
	'ERR_DB_USER_EXISTS'				=> 'Der Benutzername für SugarCRM existiert bereits - es kann kein zweiter mit dem gleichen Namen erstellt werden.',
	'ERR_DB_USER'						=> 'Der Benutzername für SugarCRM darf nicht leer sein.',
	'ERR_DBCONF_VALIDATION'				=> 'Bitte beheben Sie die folgenden Fehler bevor Sie weiterfahren.:',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'The passwords provided for the SuiteCRM database user do not match. Please re-enter the same passwords in the password fields.',
	'ERR_ERROR_GENERAL'					=> 'Die folgenden Fehler sind aufgetreten:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'Datei kann nicht gelöscht werden: ',
	'ERR_LANG_MISSING_FILE'				=> 'Datei kann nicht gefunden werden: ',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'Keine Sprachpaket-Datei in include/langauge gefunden.: ',
	'ERR_LANG_UPLOAD_1'					=> 'Ein Problem mit dem Upload ist aufgetreten. Bitte versuchen Sie es erneut.',
	'ERR_LANG_UPLOAD_2'					=> 'Sprachpakete müssen ZIP Archive sein.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP konnte die temporäre Datei nicht ins upgrade Verzeichnis verschieben.',
	'ERR_LICENSE_MISSING'				=> 'Benötigte Felder fehlen',
	'ERR_LICENSE_NOT_FOUND'				=> 'Lizenzdatei nicht gefunden!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'Das angegebene Log Verzeichnis ist kein gültiges Verzeichnis.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'Das angegebene Log Verzeichnis ist nicht beschreibbar.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Das Log Verzeichnis muss angegeben werden falls Sie ein eigenes festlegen möchten.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'Script konnte nicht direkt verarbeitet werden.',
	'ERR_NO_SINGLE_QUOTE'				=> 'Hochkomma kann nicht verwendet werden als ',
	'ERR_PASSWORD_MISMATCH'				=> 'Passwörter für SugarCRM admin sind nicht gleich.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'Die Datei config.php ist nicht beschreibbar.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Sie können die Installation fortsetzen in dem Sie die config.php Datei manuell erstellen und die unten stehenden Konfigurationen in die Datei kopieren. Aber, die config.php Datei <b>muss</b> erstellt sein um zum nächsten Schritt gelangen zu können.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'Haben Sie die config.php Datei erstellt?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Warnung: Es konnte nicht in die config.php Datei geschrieben werden. Bitte überprüfen Sie dass die Datei existiert.',
	'ERR_PERFORM_HTACCESS_1'			=> 'Die Datei ',
	'ERR_PERFORM_HTACCESS_2'			=> ' ist nicht beschreibbar.',
	'ERR_PERFORM_HTACCESS_3'			=> 'Falls Sie die Log Datei vor dem Zugriff via Browser schützen möchten, erstellen Sie eine .htaccess Datei im Log Verzeichnis mit der folgenden Zeile:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>Die Internetverbindung wurde nicht erkannt.</b> Falls Sie eine Verbindung haben, besuchen Sie bitte <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> um sich bei SugarCRM zu registrieren. In dem Sie uns ein wenig erzählen wie Ihre Firma SugarCRM zu nutzen plant, können wir sicherstellen, dass wir immer die richtige Applikation für Ihre Geschäftsbedürfnisse liefern.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'Das angegebene Session Verzeichnis ist kein gültiges Verzeichnis.',
	'ERR_SESSION_DIRECTORY'				=> 'Das angegebene Session Verzeichnis ist nicht beschreibbar.',
	'ERR_SESSION_PATH'					=> 'Session Pfad wird benötigt falls Sie einen eigenen definieren möchten.',
	'ERR_SI_NO_CONFIG'					=> 'Entweder haben sie config_si.php nicht im document root inkludiert oder Sie haben $sugar_config_si nicht in der Datei config.php definiert.',
	'ERR_SITE_GUID'						=> 'Applikations ID wird benötigt falls Sie eine eigene definieren möchten.',
    'ERROR_SPRITE_SUPPORT'              => "Currently we are not able to locate the GD library, as a result you will not be able to use the CSS Sprite functionality.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Warnung: Ihre PHP Konfiguration muss geändert werden damit Dateien mit mindestens 6MB hochgeladen werden können.',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Upload File Size',
	'ERR_URL_BLANK'						=> 'URL darf nicht leer sein.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'Installations-Datensatz nicht gefunden für',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'Die hochgeladene Datei ist nicht kompatibel mit dieser  Sugar Suite Edition (Open Source, Professional oder Enterprise).: ',
	'ERROR_LICENSE_EXPIRED'				=> "Fehler: Ihre Lizenz ist abgelaufen ",
	'ERROR_LICENSE_EXPIRED2'			=> "vor Tag(e)n. Bitte gehen Sie zu Lizenzmanagement im Adminbereich zum eingeben des neuen Lizenzschlüssels. Wenn Sie nicht innerhalb 30 Tagen nach Ablauf einen neuen Lizenzschlüssel eingeben, können Sie sich nicht mehr in diese Anwendung einloggen.",
	'ERROR_MANIFEST_TYPE'				=> 'Die Manifest-Datei muss den Typ der Anwendung spezifizieren.',
	'ERROR_PACKAGE_TYPE'				=> 'Manifest-Datei spezifiziert einen unerkannten Anwendungstyp.',
	'ERROR_VALIDATION_EXPIRED'			=> "Fehler: Ihr Validierungsschlüssel ist abgelaufen vor ",
	'ERROR_VALIDATION_EXPIRED2'			=> "Tag(en). Bitte gehen Sie zu Lizenzmanagemen im Adminbereich zum eingeben des neuen Validierungsschlüssels. Wenn Sie nicht innerhalb 30 Tagen nach Ablauf einen neuen Validierungsschlüssel eingeben, können Sie sich nicht mehr an dieser Anwendung anmelden.",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'Die geladene Datei ist mit dieser Version der SugarSuite nicht kompatibel: ',

	'LBL_BACK'							=> 'Zurück',
    'LBL_CANCEL'                        => 'Abbrechen [Alt+X]',
    'LBL_ACCEPT'                        => 'Ich akzeptiere',
	'LBL_CHECKSYS_1'					=> 'Damit Ihre SugarCRM Installation korrekt funktioniert, müssen Sie sicherstellen, dass alle unten aufgeführten Systemtests grün sind. Falls einer rot ist, versuchen Sie das Problem zu lösen.<br><br>Englische Hilfe zu diesen Systemtests finden Sie im <a href="http://www.sugarcrm.com/crm/installation" target="_blank">Sugar Wiki<a>',
	'LBL_CHECKSYS_CACHE'				=> 'Beschreibbare Cache Unterverzeichnisse',
    'LBL_DROP_DB_CONFIRM'               => 'The provided Database Name already exists.<br>You can either:<br>1.  Click on the Cancel button and choose a new database name, or <br>2.  Click the Accept button and continue.  All existing tables in the database will be dropped. <strong>This means that all of the tables and pre-existing data will be blown away.</strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned Off',
    'LBL_CHECKSYS_COMPONENT'			=> 'Komponenten',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Optionale Komponenten',
	'LBL_CHECKSYS_CONFIG'				=> 'Beschreibbare SugarCRM Konfigurationsdatei (config.php)',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Writable SuiteCRM Configuration File (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'cURL Modul',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Session Save Path Setting',
	'LBL_CHECKSYS_CUSTOM'				=> 'Beschreibbares Custom Verzeichnis',
	'LBL_CHECKSYS_DATA'					=> 'Beschreibbare Data Unterverzeichnisse',
	'LBL_CHECKSYS_IMAP'					=> 'IMAP Modul',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'MB Strings Modul',
	'LBL_CHECKSYS_MEM_OK'				=> 'OK (Keine Limiten)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'OK (Unlimitiert)',
	'LBL_CHECKSYS_MEM'					=> 'PHP Memory Limit >= ',
	'LBL_CHECKSYS_MODULE'				=> 'Beschreibbare Modul Unterverzeichnisse und Dateien',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'MySQL Version',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'Nicht verfügbar',
	'LBL_CHECKSYS_OK'					=> 'OK',
	'LBL_CHECKSYS_PHP_INI'				=> '<b>Notiz:<b/> Ihre php Konfigurationsdatei (php.ini) ist hier:',
	'LBL_CHECKSYS_PHP_OK'				=> 'OK (ver ',
	'LBL_CHECKSYS_PHPVER'				=> 'PHP Version',
    'LBL_CHECKSYS_IISVER'               => 'IIS Version',
	'LBL_CHECKSYS_RECHECK'				=> 'Neu überprüfen',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP Safe Mode deaktiviert',
	'LBL_CHECKSYS_SESSION'				=> 'Beschreibbarer Session Speicherpfad (',
	'LBL_CHECKSYS_STATUS'				=> 'Status',
	'LBL_CHECKSYS_TITLE'				=> 'System Check Akzeptanz',
	'LBL_CHECKSYS_VER'					=> 'Gefunden: (ver ',
	'LBL_CHECKSYS_XML'					=> 'XML Parsing',
	'LBL_CHECKSYS_ZLIB'					=> 'ZLIB Kompression Modul',
	'LBL_CHECKSYS_ZIP'					=> 'ZIP Handling Module',
	'LBL_CHECKSYS_PCRE'					=> 'PCRE Library',
	'LBL_CHECKSYS_FIX_FILES'            => 'Please fix the following files or directories before proceeding:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Please fix the following module directories and the files under them before proceeding:',
    'LBL_CHECKSYS_UPLOAD'               => 'Writable Upload Directory',
    'LBL_CLOSE'							=> 'Beenden',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'wird erstellt',
	'LBL_CONFIRM_DB_TYPE'				=> 'Datenbank Typ',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Bitte bestätigten Sie die unteren Einstellungen. Falls Sie einen Wert ändern möchten, klicken Sie bitte auf "Zurück". Andernfalls klicken Sie "Weiter" um die Installation zu starten.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Lizenz Information',
	'LBL_CONFIRM_NOT'					=> 'nicht',
	'LBL_CONFIRM_TITLE'					=> 'Einstellungen bestätigen',
	'LBL_CONFIRM_WILL'					=> 'wird',
	'LBL_DBCONF_CREATE_DB'				=> 'Datenbank erstellen',
	'LBL_DBCONF_CREATE_USER'			=> 'Neuer User',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Vorsicht: Alle Sugar Daten werden gelöscht falls dieses Kästchen aktiviert ist.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Existierende Sugar Tabellen löschen und neu erstellen?',
    'LBL_DBCONF_DB_DROP'                => 'Drop Tables',
    'LBL_DBCONF_DB_NAME'				=> 'Datenbank Name',
	'LBL_DBCONF_DB_PASSWORD'			=> 'Datenbank Passwort',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Datenbank Passwort bestätigen',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM Database User',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM Database User',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Database Administrator Username',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Database Admin Password',
	'LBL_DBCONF_DEMO_DATA'				=> 'Demo Daten in Datenbank importieren?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Choose Demo Data',
	'LBL_DBCONF_HOST_NAME'				=> 'Host Name / Host Instanz',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Host Instance',
	'LBL_DBCONF_HOST_PORT'				=> 'Port',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Bitte geben Sie Ihre Datenbank Konfigurationsinformationen ein. Falls Sie unsicher sind was Sie eingeben müssen, empfehlen wir dass Sie die Standardwerte verwenden.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Multi-byte Text in den Demodaten verwenden?',
    'LBL_DBCONFIG_MSG2'                 => 'Name of web server or machine (host) on which the database is located ( such as localhost or www.mydomain.com ):',
	'LBL_DBCONFIG_MSG2_LABEL' => 'Host Name / Host Instanz',
    'LBL_DBCONFIG_MSG3'                 => 'Name of the database that will contain the data for the SuiteCRM instance you are about to install:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'Datenbank Name',
    'LBL_DBCONFIG_B_MSG1'               => 'The username and password of a database administrator who can create database tables and users and who can write to the database is necessary in order to set up the SuiteCRM database.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
    'LBL_DBCONFIG_SECURITY'             => 'For security purposes, you can specify an exclusive database user to connect to the SuiteCRM database.  This user must be able to write, update and retrieve data on the SuiteCRM database that will be created for this instance.  This user can be the database administrator specified above, or you can provide new or existing database user information.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Do it for me',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Provide existing user',
    'LBL_DBCONFIG_CREATE_DD'            => 'Define user to create',
    'LBL_DBCONFIG_SAME_DD'              => 'Same as Admin User',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'Full Text Search',
    'LBL_FTS_INSTALLED'                 => 'Installed',
    'LBL_FTS_INSTALLED_ERR1'            => 'Full Text Search capability is not installed.',
    'LBL_FTS_INSTALLED_ERR2'            => 'You can still install but will not be able to use Full Text Search functionality.  Please refer to your database server install guide on how to do this, or contact your Administrator.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Passwort des privilegierten Benutzers',
	'LBL_DBCONF_PRIV_USER_2'			=> 'Obiges Datenbank Konto ist ein privilegierter Benutzer?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'Dieser privilegierte Datenbank Benutzer muss die nötigen Rechte haben um Datenbanken zu erstellen, Tabellen zu löschen/erstellen und einen Benutzer zu erstellen. Dieser privilegierte Datenbank Benutzer wird nur verwendet um die während der Installation beöntigen Aufgaben auszuführen. Sie können auch den gleichen Datenbank Benutzer wie oben verwenden, wenn dieser Benutzer genügend Rechte hat.',
	'LBL_DBCONF_PRIV_USER'				=> 'Privilegierter Datenbank Benutzername',
	'LBL_DBCONF_TITLE'					=> 'Datenbank Konfiguration',
    'LBL_DBCONF_TITLE_NAME'             => 'Provide Database Name',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Provide Database User Information',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'Benutzer',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'Passwort',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Nachdem diese Änderung durchgeführt wurde, können Sie auf "Start" klicken um mit der Installation zu starten. <i>Wenn die Installation beendet ist, sollten Sie den Wert von \'installer_locked\' auf \'true\' setzen.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'Der Installer wurde bereits ausgeführt. Aus Sicherheitsgründen kann der Installer kein zweites Mal ausgeführt werden. Falls Sie sicher sind, dass Sie den Installer ein zweites Mal ausführen möchten, müssen Sie die Variabel \'installer_locked\' in der Datei config.php auf \'false\' setzen (oder hinzufügen). Die Zeile sollte wie folgt aussehen:',
	'LBL_DISABLED_HELP_1'				=> 'Für Hilfe zur Installation besuchen Sie bitte SugarCRM',
    'LBL_DISABLED_HELP_LNK'             => 'http://www.suitecrm.com/forum/index',
	'LBL_DISABLED_HELP_2'				=> 'Support Forums',
	'LBL_DISABLED_TITLE_2'				=> 'SugarCRM Installation wurde deaktiviert.',
	'LBL_DISABLED_TITLE'				=> 'SugarCRM Installation ist deaktiviert.',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Setzen Sie dies auf den Zeichensatz, der in Ihrer Region am meisten verwendet wird.',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Zeichensatz für ausgehende E-Mails',
    'LBL_EMAIL_CHARSET_CONF'            => 'Character Set for Outbound Email ',
	'LBL_HELP'							=> 'Hilfe',
    'LBL_INSTALL'                       => 'Installieren',
    'LBL_INSTALL_TYPE_TITLE'            => 'Installation Options',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Choose Install Type',
    'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>Typical Install</b>',
    'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>Custom Install</b>',
    'LBL_INSTALL_TYPE_MSG1'             => 'The key is required for general application functionality, but it is not required for installation. You do not need to enter the key at this time, but you will need to provide the key after you have installed the application.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Requires minimum information for the installation. Recommended for new users.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Provides additional options to set during the installation. Most of these options are also available after installation in the admin screens. Recommended for advanced users.',
	'LBL_LANG_1'						=> 'Hier können Sie ein weiteres Sprachpaket installieren. Andernfalls klicken Sie bitte auf "Weiter" um zum nächsten Schritt zu gelangen.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Installieren',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Entfernen',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Deinstallieren',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Upload',
	'LBL_LANG_NO_PACKS'					=> 'Keine Einträge vorhanden',
	'LBL_LANG_PACK_INSTALLED'			=> 'Die folgenden Sprachpakete wurden installiert: ',
	'LBL_LANG_PACK_READY'				=> 'Die folgenden Sprachpakete sind bereit für die Installation: ',
	'LBL_LANG_SUCCESS'					=> 'Das Sprachpaket wurde erfolgreich hochgeladen.',
	'LBL_LANG_TITLE'			   		=> 'Sprachpaket',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Installing SuiteCRM now.  This may take up to a few minutes.',
	'LBL_LANG_UPLOAD'					=> 'Sprachpaket hochladen',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Lizenz Akzeptanz',
    'LBL_LICENSE_CHECKING'              => 'Checking system for compatibility.',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Checking Environment',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Verifying DB Credentials.',
    'LBL_LICENSE_CHECK_PASSED'          => 'System passed check for compatibility.',
	'LBL_CREATE_CACHE' => 'Preparing to Install...',
    'LBL_LICENSE_REDIRECT'              => 'Redirecting in ',
	'LBL_LICENSE_DIRECTIONS'			=> 'Falls Sie Ihre Lizenzinformationen haben, geben Sie sie bitte in den folgenden Feldern ein.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Download-Schlüssel',
	'LBL_LICENSE_EXPIRY'				=> 'Ablaufdatum',
	'LBL_LICENSE_I_ACCEPT'				=> 'Ich akzeptiere',
	'LBL_LICENSE_NUM_USERS'				=> 'Anzahl Benutzer',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Bitte geben Sie die Anzahl gekaufter Offline Clients ein.',
	'LBL_LICENSE_OC_NUM'				=> 'Anzahl Offline-Client-Lizenzen',
	'LBL_LICENSE_OC'					=> 'Offline Client Lizenzen',
	'LBL_LICENSE_PRINTABLE'				=> 'Druckansicht ',
    'LBL_PRINT_SUMM'                    => 'Print Summary',
	'LBL_LICENSE_TITLE_2'				=> 'SugarCRM Lizenz',
	'LBL_LICENSE_TITLE'					=> 'Lizenz Information',
	'LBL_LICENSE_USERS'					=> 'Lizenzierte Benutzer',

	'LBL_LOCALE_CURRENCY'				=> 'Währungseinstellungen',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Standard Währung',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Währungssymbol',
	'LBL_LOCALE_CURR_ISO'				=> 'Währungscode (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> '1000er Trennzeichen',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Dezimal Trennzeichen',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Beispiel',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Dezimalstellen',
	'LBL_LOCALE_DATEF'					=> 'Standard Datumsformat',
	'LBL_LOCALE_DESC'					=> 'Passen Sie Ihre lokalen SugarCRM Einstellungen an.',
	'LBL_LOCALE_EXPORT'					=> 'Import/Export Zeichensatz (E-Mail, .csv, vCard, PDF, Datenimport)',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Export (.csv) Trennzeichen',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Export Einstellungen',
	'LBL_LOCALE_LANG'					=> 'Standardsprache',
	'LBL_LOCALE_NAMEF'					=> 'Standardformat für Namen',
	'LBL_LOCALE_NAMEF_DESC'				=> '"s" Anrede<br>"f" Vorname<br>"l" Nachname',
	'LBL_LOCALE_NAME_FIRST'				=> 'Hans',
	'LBL_LOCALE_NAME_LAST'				=> 'Muster',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Dr.',
	'LBL_LOCALE_TIMEF'					=> 'Standard Zeitformat',

    'LBL_CUSTOMIZE_LOCALE'              => 'Customize Locale Settings',
	'LBL_LOCALE_UI'						=> 'Benutzer Interface',

	'LBL_ML_ACTION'						=> 'Aktion',
	'LBL_ML_DESCRIPTION'				=> 'Beschreibung',
	'LBL_ML_INSTALLED'					=> 'Installatiert am',
	'LBL_ML_NAME'						=> 'Namen',
	'LBL_ML_PUBLISHED'					=> 'Veröffentlicht am',
	'LBL_ML_TYPE'						=> 'Typ',
	'LBL_ML_UNINSTALLABLE'				=> 'Deinstallierbar',
	'LBL_ML_VERSION'					=> 'Version',
	'LBL_MSSQL'							=> 'SQL Server',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver for PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (mysqli extension)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Weiter',
	'LBL_NO'							=> 'Nein',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Site admin Passwort setzen',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'audit Tabelle / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Sugar Konfigurationsdatei wird erstellt',
	'LBL_PERFORM_CREATE_DB_1'			=> 'Datenbank wird erstellt ',
	'LBL_PERFORM_CREATE_DB_2'			=> 'on ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Datenbank Benutzername und Passwort wird erstellt...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Standard Sugar Daten werden erstellt',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Datenbank Benutzername und Passwort für localhost wird erstellt...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Sugar Beziehnungstabellen werden erstellt',
	'LBL_PERFORM_CREATING'				=> 'erstellen ',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Standardberichte werden erstellt',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Standard Zeitplaner Abläufe werden erstellt',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Standard Einstellungen werden eingefügt',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Standard Benutzer werden erstellt',
	'LBL_PERFORM_DEMO_DATA'				=> 'Die Datenbank wird mit Demo Daten gefüllt (das kann eine Weile dauern)...',
	'LBL_PERFORM_DONE'					=> 'erledigt<br>',
	'LBL_PERFORM_DROPPING'				=> 'löschen ',
	'LBL_PERFORM_FINISH'				=> 'Ende',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Lizenzinformationen aktualisieren',
	'LBL_PERFORM_OUTRO_1'				=> 'Die Installation von Sugar ',
	'LBL_PERFORM_OUTRO_2'				=> ' ist jetzt fertig.',
	'LBL_PERFORM_OUTRO_3'				=> 'Totale Zeit: ',
	'LBL_PERFORM_OUTRO_4'				=> ' sec.',
	'LBL_PERFORM_OUTRO_5'				=> 'Ungefähr benötigter Hauptspeicher: ',
	'LBL_PERFORM_OUTRO_6'				=> ' byte.',
	'LBL_PERFORM_OUTRO_7'				=> 'Ihr System ist jetzt installiert und konfiguriert.',
	'LBL_PERFORM_REL_META'				=> 'Beziehung Meta... ',
	'LBL_PERFORM_SUCCESS'				=> 'Erfolgreich!',
	'LBL_PERFORM_TABLES'				=> 'Sugar Applikationstabellen, Audit Tabellen und Beziehungen Metadaten werden erstellt...',
	'LBL_PERFORM_TITLE'					=> 'Setup ausführen',
	'LBL_PRINT'							=> 'Drucken',
	'LBL_REG_CONF_1'					=> 'Please take a moment to register with SugarCRM by filling out the short form below. By letting us know a little bit about how your company plans to use SugarCRM, we can ensure we are always delivering the right product for your business needs. If you are interested in receiving information about Sugar, please opt-in to our mailing list. We do not sell, rent, share, or otherwise distribute the information collected here to third parties.',
	'LBL_REG_CONF_2'					=> 'Ihr Name und Ihre E-Mail Adresse sind die einzigen Felder die für die Registration benötigt werden. Alle anderen Felder sind optional, aber sehr hilfreich. Wir werden die Informationen, die wir hier sammeln, nicht an dritte Anbieter verkaufen, vermieten oder weiterleiten.',
	'LBL_REG_CONF_3'					=> 'Vielen Dank für die Registration. Klicken Sie auf die Ende Schaltfläche um sich am SugarCRM anzumelden. Das erste Mal müssen Sie sich mit dem Benutzernamen "admin" anmelden und das Passwort von Schritt 2 eingeben.',
	'LBL_REG_TITLE'						=> 'Registration',
    'LBL_REG_NO_THANKS'                 => 'No Thanks',
    'LBL_REG_SKIP_THIS_STEP'            => 'Skip this Step',
	'LBL_REQUIRED'						=> '* Pflichtfelder',

    'LBL_SITECFG_ADMIN_Name'            => 'SuiteCRM Application Admin Name',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Sugar <i>Admin</i> Passwort erneut eingeben',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Vorsicht: Dies überschreibt das admin Passwort  einer früheren Installation.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'Sugar <i>Admin</i> Passwort',
	'LBL_SITECFG_APP_ID'				=> 'Applikations ID',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'Überschreiben Sie die auto-generierte Applikations-ID, dasverhindert, dass Sessions von einer Sugar Instanz von einer anderen Instanz verwendet wird. Falls Sie einen Cluster von Sugar Installationen haben, müssen alle die gleiche Applikations-ID verwenden.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Geben Sie Ihre eigene Applikations ID ein',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'Überschreiben Sie das Standardverzeichnis der Sugar Logs. Der Zugriff zum Verzeichnis via Browser wird mit Hilfe eines .htaccess Redirect verhindert.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Eigenes Log Verzeichnis verwenden',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'Geben Sie ein sicheres Verzeichnis für die Speicherung der Session Informationen an, um zu verhindern, dass Session Daten auf einem Shared Server gefährdet sind.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Eigenes Session Verzeichnis für Sugar verwenden',
	'LBL_SITECFG_DIRECTIONS'			=> 'Bitte geben Sie Ihre Site Konfigurationsinformationen ein. Falls Sie unsicher sind, empfehlen wir, dass Sie die Standardwerte verwenden.',
	'LBL_SITECFG_FIX_ERRORS'			=> 'Bitte beheben Sie die folgenden Fehler bevor Sie weiterfahren.:',
	'LBL_SITECFG_LOG_DIR'				=> 'Log Verzeichnis',
	'LBL_SITECFG_SESSION_PATH'			=> 'Pfad zum Session Verzeichnis<br />(muss beschreibbar sein)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Erweiterte Site Sicherheit',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'Falls aktiviert, wird das System regelmässig nach Updates suchen.',
	'LBL_SITECFG_SUGAR_UP'				=> 'Automatisch nach Updates suchen?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Sugar Update Konfiguration',
	'LBL_SITECFG_TITLE'					=> 'Site Konfiguration',
    'LBL_SITECFG_TITLE2'                => 'Identify Administration User',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Site Security',
	'LBL_SITECFG_URL'					=> 'URL der Sugar Instanz',
	'LBL_SITECFG_USE_DEFAULTS'			=> 'Standardwerte verwenden?',
	'LBL_SITECFG_ANONSTATS'             => 'Anonyme Benutzerstatistiken senden?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'Falls aktiviert, wird das System bei jeder Suche nach Updates anonyme Statistiken über die Installation an SugarCRM Inc. senden. Diese Information wird uns helfen, besser zu verstehen, wie die Applikation genutzt wird.',
    'LBL_SITECFG_URL_MSG'               => 'Enter the URL that will be used to access the SuiteCRM instance after installation. The URL will also be used as a base for the URLs in the SuiteCRM application pages. The URL should include the web server or machine name or IP address.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Enter a name for your system.  This name will be displayed in the browser title bar when users visit the SuiteCRM application.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'After installation, you will need to use the SuiteCRM admin user (default username = admin) to log in to the SuiteCRM instance.  Enter a password for this administrator user. This password can be changed after the initial login.  You may also enter another admin username to use besides the default value provided.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Select collation (sorting) settings for your system. This settings will create the tables with the specific language you use. In case your language doesn\'t require special settings please use default value.',
    'LBL_SPRITE_SUPPORT'                => 'Sprite Support',
	'LBL_SYSTEM_CREDS'                  => 'System Credentials',
    'LBL_SYSTEM_ENV'                    => 'System Environment',
	'LBL_START'							=> 'Start',
    'LBL_SHOW_PASS'                     => 'Show Passwords',
    'LBL_HIDE_PASS'                     => 'Hide Passwords',
    'LBL_HIDDEN'                        => '<i>(hidden)</i>',
	'LBL_STEP1' => 'Step 1 of 2 - Pre-Installation requirements',
	'LBL_STEP2' => 'Step 2 of 2 - Configuration',
//    'LBL_STEP1'                         => 'Step 1 of 8 - Pre-Installation requirements',
//    'LBL_STEP2'                         => 'Step 2 of 8 - License Agreement',
//    'LBL_STEP3'                         => 'Step 3 of 8 - Installation Type',
//    'LBL_STEP4'                         => 'Step 4 of 8 - Database Selection',
//    'LBL_STEP5'                         => 'Step 5 of 8 - Database Configuration',
//    'LBL_STEP6'                         => 'Step 6 of 8 - Site Configuration',
//    'LBL_STEP7'                         => 'Step 7 of 8 - Confirm Settings',
//    'LBL_STEP8'                         => 'Step 8 of 8 - Installation Successful',
//	'LBL_NO_THANKS'						=> 'Continue to installer',
	'LBL_CHOOSE_LANG'					=> 'Wählen Sie Ihre Sprache',
	'LBL_STEP'							=> 'Schritt',
	'LBL_TITLE_WELCOME'					=> 'Willkommen im SugarCRM ',
	'LBL_WELCOME_1'						=> 'Dieser Installer erstellt die SugarCRM Datenbank Tabellen und setzt die Konfigurationsvariabeln die Sie für den Start benötigen. Der gesamte Prozess sollte ca. 10 Minuten dauern.',
	'LBL_WELCOME_2'						=> 'Englische Installationsdokumente finden Sie im <a href="http://www.sugarcrm.com/crm/installation" target="_blank">Sugar Wiki</a>.',
    //welcome page variables
    'LBL_TITLE_ARE_YOU_READY'            => 'Are you ready to install?',
    'REQUIRED_SYS_COMP' => 'Required System Components',
    'REQUIRED_SYS_COMP_MSG' =>
                    'Before you begin, please be sure that you have the supported versions of the following system
                      components:<br>
                      <ul>
                      <li> Database/Database Management System (Examples: MariaDB, MySQL or SQL Server)</li>
                      <li> Web Server (Apache, IIS)</li>
                      </ul>
                      Consult the Compatibility Matrix in the Release Notes for
                      compatible system components for the SuiteCRM version that you are installing.<br>',
    'REQUIRED_SYS_CHK' => 'Initial System Check',
    'REQUIRED_SYS_CHK_MSG' =>
                    'When you begin the installation process, a system check will be performed on the web server on which the SuiteCRM files are located in order to
                      make sure the system is configured properly and has all of the necessary components
                      to successfully complete the installation. <br><br>
                      The system checks all of the following:<br>
                      <ul>
                      <li><b>PHP version</b> &#8211; must be compatible
                      with the application</li>
                                        <li><b>Session Variables</b> &#8211; must be working properly</li>
                                            <li> <b>MB Strings</b> &#8211; must be installed and enabled in php.ini</li>

                      <li> <b>Database Support</b> &#8211; must exist for MariaDB, MySQL or SQL Server</li>

                      <li> <b>Config.php</b> &#8211; must exist and must have the appropriate
                                  permissions to make it writeable</li>
					  <li>The following SuiteCRM files must be writeable:<ul><li><b>/custom</li>
<li>/cache</li>
<li>/modules</li>
<li>/upload</b></li></ul></li></ul>
                                  If the check fails, you will not be able to proceed with the installation. An error message will be displayed, explaining why your system
                                  did not pass the check.
                                  After making any necessary changes, you can undergo the system
                                  check again to continue the installation.<br>',
    'REQUIRED_INSTALLTYPE' => 'Typical or Custom install',
    'REQUIRED_INSTALLTYPE_MSG' =>
                    'After the system check is performed, you can choose either
                      the Typical or the Custom installation.<br><br>
                      For both <b>Typical</b> and <b>Custom</b> installations, you will need to know the following:<br>
                      <ul>
                      <li> <b>Type of database</b> that will house the SuiteCRM data <ul><li>Compatible database
                      types: MariaDB, MySQL or SQL Server.<br><br></li></ul></li>
                      <li> <b>Name of the web server</b> or machine (host) on which the database is located
                      <ul><li>This may be <i>localhost</i> if the database is on your local computer or is on the same web server or machine as your SuiteCRM files.<br><br></li></ul></li>
                      <li><b>Name of the database</b> that you would like to use to house the SuiteCRM data</li>
                        <ul>
                          <li> You might already have an existing database that you would like to use. If
                          you provide the name of an existing database, the tables in the database will
                          be dropped during installation when the schema for the SuiteCRM database is defined.</li>
                          <li> If you do not already have a database, the name you provide will be used for
                          the new database that is created for the instance during installation.<br><br></li>
                        </ul>
                      <li><b>Database administrator user name and password</b> <ul><li>The database administrator should be able to create tables and users and write to the database.</li><li>You might need to
                      contact your database administrator for this information if the database is
                      not located on your local computer and/or if you are not the database administrator.<br><br></ul></li></li>
                      <li> <b>SuiteCRM database user name and password</b>
                      </li>
                        <ul>
                          <li> The user may be the database administrator, or you may provide the name of
                          another existing database user. </li>
                          <li> If you would like to create a new database user for this purpose, you will
                          be able to provide a new username and password during the installation process,
                          and the user will be created during installation. </li>
                        </ul></ul><p>

                      For the <b>Custom</b> setup, you might also need to know the following:<br>
                      <ul>
                      <li> <b>URL that will be used to access the SuiteCRM instance</b> after it is installed.
                      This URL should include the web server or machine name or IP address.<br><br></li>
                                  <li> [Optional] <b>Path to the session directory</b> if you wish to use a custom
                                  session directory for SuiteCRM information in order to prevent session data from
                                  being vulnerable on shared servers.<br><br></li>
                                  <li> [Optional] <b>Path to a custom log directory</b> if you wish to override the default directory for the SuiteCRM log.<br><br></li>
                                  <li> [Optional] <b>Application ID</b> if you wish to override the auto-generated
                                  ID that ensures that sessions of one SuiteCRM instance are not used by other instances.<br><br></li>
                                  <li><b>Character Set</b> most commonly used in your locale.<br><br></li></ul>
                                  For more detailed information, please consult the Installation Guide.
                                ',
    'LBL_WELCOME_PLEASE_READ_BELOW' => 'Please read the following important information before proceeding with the installation.  The information will help you determine whether or not you are ready to install the application at this time.',

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> 'Wählen Sie Ihre Sprache',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Setup Wizard',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Willkommen im SugarCRM ',
	'LBL_WELCOME_TITLE'					=> 'SugarCRM Setup Wizard',
	'LBL_WIZARD_TITLE'					=> 'SugarCRM Setup Wizard: Schritt ',
	'LBL_YES'							=> 'Ja',
    'LBL_YES_MULTI'                     => 'Yes - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Workflow Aufgaben verarbeiten',
	'LBL_OOTB_REPORTS'		=> 'Berichte Aufgaben verarbeiten',
	'LBL_OOTB_IE'			=> 'Eingehende Mailkonten überprüfen',
	'LBL_OOTB_BOUNCE'		=> 'Zurückgekommene Kampagnen E-Mails verarbeiten (Nacht)',
    'LBL_OOTB_CAMPAIGN'		=> 'Kampagnen-Massenmails versenden (Nacht)',
	'LBL_OOTB_PRUNE'		=> 'Datenbank am 1. des Monats säubern',
    'LBL_OOTB_TRACKER'		=> 'Prune tracker tables',
    'LBL_OOTB_SUGARFEEDS'   => 'Prune SuiteCRM Feed Tables',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Run Email Reminder Notifications',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Update tracker_sessions table',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Clean Jobs Queue',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Removal of documents from filesystem',


    'LBL_PATCHES_TITLE'     => 'Aktuellste Patches installieren',
    'LBL_MODULE_TITLE'      => 'Sprachpakete herunterladen & installieren',
    'LBL_PATCH_1'           => 'Falls Sie diesen Schritt überspringen möchten, klicken Sie bitte auf Weiter.',
    'LBL_PATCH_TITLE'       => 'System Patch',
    'LBL_PATCH_READY'       => 'Die folgenden Patches können installiert werden.',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SugarCRM ist darauf angewiesen, dass in PHP Sessions wichtige Informationen gespeichert werden. Ihre PHP Installation ist für Session Informationen nicht korrekt konfiguriert.<br><br>Ein häufig anzutreffender Konfigurationsfehler ist, dass <b>session.save_path</b> nicht auf ein gültiges Verzeichnis zeigt.<br><br>Bitte korrigieren Sie Ihre <a href=\"http://de.php.net/manual/de/ref.session.php\" target=\"_blank\">PHP Konfiguration</a> in der Datei php.ini.",
	'LBL_SESSION_ERR_TITLE'				=> 'PHP Session Konfigurationsfehler',
	'LBL_SYSTEM_NAME'=>'Systemname',
    'LBL_COLLATION' => 'Collation Settings',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Systemname kann nicht leer sein',
	'LBL_PATCH_UPLOAD' => 'Patch hochladen',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Php version 5 or above is required.',
	'LBL_MINIMUM_PHP_VERSION' => 'Minimum Php version required is 5.1.0. Recommended Php version is 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(Your current php version is ',
	'LBL_RECOMMENDED_PHP_VERSION' =>' Recommended php version is 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'Php Backward Compatibility mode is turned on. Set zend.ze1_compatibility_mode to Off for proceeding further',
    'LBL_STREAM' => 'PHP allows to use stream',

    'advanced_password_new_account_email' => array(
        'subject' => 'New account information',
        'description' => 'This template is used when the System Administrator sends a new password to a user.',
        'body' => '<div><table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\" width="550" align=\\"\\&quot;\\&quot;center\\&quot;\\&quot;\\"><tbody><tr><td colspan=\\"2\\"><p>Here is your account username and temporary password:</p><p>Username : $contact_user_user_name </p><p>Password : $contact_user_user_hash </p><br><p>$config_site_url</p><br><p>After you log in using the above password, you may be required to reset the password to one of your own choice.</p>   </td>         </tr><tr><td colspan=\\"2\\"></td>         </tr> </tbody></table> </div>',
        'txt_body' =>
'
Here is your account username and temporary password:
Username : $contact_user_user_name
Password : $contact_user_user_hash

$config_site_url

After you log in using the above password, you may be required to reset the password to one of your own choice.',
        'name' => 'System-generated password email',
        ),
    'advanced_password_forgot_password_email' => array(
        'subject' => 'Reset your account password',
        'description' => "This template is used to send a user a link to click to reset the user's account password.",
        'body' => '<div><table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\" width="550" align=\\"\\&quot;\\&quot;center\\&quot;\\&quot;\\"><tbody><tr><td colspan=\\"2\\"><p>You recently requested on $contact_user_pwd_last_changed to be able to reset your account password. </p><p>Click on the link below to reset your password:</p><p> $contact_user_link_guid </p>  </td>         </tr><tr><td colspan=\\"2\\"></td>         </tr> </tbody></table> </div>',
        'txt_body' =>
'
You recently requested on $contact_user_pwd_last_changed to be able to reset your account password.

Click on the link below to reset your password:

$contact_user_link_guid',
        'name' => 'Forgot Password email',
        ),

	// SMTP settings

	'LBL_WIZARD_SMTP_DESC' => 'Provide the email account that will be used to send emails, such as the assignment notifications and new user passwords. Users will receive emails from SuiteCRM, as sent from the specified email account.',
	'LBL_CHOOSE_EMAIL_PROVIDER'        => 'Choose your Email provider:',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! Mail',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => 'Andere',
	'LBL_MAIL_SMTP_SETTINGS'           => 'SMTP Server Specification',
	'LBL_MAIL_SMTPSERVER'				=> 'SMTP Server:',
	'LBL_MAIL_SMTPPORT'					=> 'SMTP Port:',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'SMTP Authentifizierung benutzen?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => 'Enable SMTP over SSL or TLS?',
	'LBL_GMAIL_SMTPUSER'					=> 'Gmail Email Address:',
	'LBL_GMAIL_SMTPPASS'					=> 'Gmail Password:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => 'Allow users to use this account for outgoing email:',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => 'When this option is selected, all users will be able to send emails using the same outgoing mail account used to send system notifications and alerts.  If the option is not selected, users can still use the outgoing mail server after providing their own account information.',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Yahoo! Mail Password:',
	'LBL_YAHOOMAIL_SMTPUSER'					=> 'Yahoo! Mail ID:',

	'LBL_EXCHANGE_SMTPPASS'					=> 'Exchange Password:',
	'LBL_EXCHANGE_SMTPUSER'					=> 'Exchange Username:',
	'LBL_EXCHANGE_SMTPPORT'					=> 'Exchange Server Port:',
	'LBL_EXCHANGE_SMTPSERVER'				=> 'Exchange Server:',


	'LBL_MAIL_SMTPUSER'					=> 'SMTP User-Name:',
	'LBL_MAIL_SMTPPASS'					=> 'SMTP Passwort:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Branding',
	'LBL_WIZARD_SYSTEM_DESC' => 'Provide your organization\'s name and logo in order to brand your SuiteCRM.',
	'SYSTEM_NAME_WIZARD'=>'Name:',
	'SYSTEM_NAME_HELP'=>'This is the name that displays in the title bar of your browser.',
	'NEW_LOGO'=>'Neues Logo hochladen (212x40 pixel)',
	'NEW_LOGO_HELP'=>'The image file format can be either .png or .jpg. The maximum height is 170px, and the maximum width is 450px. Any image uploaded that is larger in any direction will be scaled to these max dimensions.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'Upload',
	'CURRENT_LOGO'=>'Aktuelles Logo',
    'CURRENT_LOGO_HELP'=>'This logo is displayed in the left-hand corner of the footer of the SuiteCRM application.',

	// System Local Settings


	'LBL_LOCALE_TITLE' => 'System Locale Settings',
	'LBL_WIZARD_LOCALE_DESC' => 'Specify how you would like data in SuiteCRM to be displayed, based on your geographical location. The settings you provide here will be the default settings. Users will be able set their own preferences.',
	'LBL_DATE_FORMAT' => 'Datums-Format:',
	'LBL_TIME_FORMAT' => 'Zeit-Format:',
		'LBL_TIMEZONE' => 'Time Zone:',
	'LBL_LANGUAGE'=>'Sprache:',
	'LBL_CURRENCY'=>'Währung',
	'LBL_CURRENCY_SYMBOL'=>'Currency Symbol:',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 Currency Code:',
	'LBL_NUMBER_GROUPING_SEP' => '1000s separator:',
	'LBL_DECIMAL_SEP' => 'Decimal symbol:',
	'LBL_NAME_FORMAT' => 'Name Format:',
	'UPLOAD_LOGO' => 'Please wait, logo uploading..',
	'ERR_UPLOAD_FILETYPE' => 'File type do not allowed, please upload a jpeg or png.',
	'ERR_LANG_UPLOAD_UNKNOWN' => 'Unknown file upload error occured.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => 'Die hochgeladene Datei ist grösser als upload_max_filesize in php.ini.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => 'Die hochgeladene Datei ist grösser als die MAX_FILE_SIZE Direktive, die im HTML Fomular angegeben wurde.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => 'Die hochgeladene Datei wurde nur teilweise hochgeladen.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => 'Keine Datei wurde hochgeladen.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => 'Ein temporäres Verzeichnis fehlt.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => 'Datei konnte nicht geschrieben werden.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.',

	'LBL_INSTALL_PROCESS' => 'Install...',

	'LBL_EMAIL_ADDRESS' => 'E-Mail:',
	'ERR_ADMIN_EMAIL' => 'Administrator Email Address is incorrect.',
	'ERR_SITE_URL' => 'Site URL is required.',

	'STAT_CONFIGURATION' => 'Configuration relationships...',
	'STAT_CREATE_DB' => 'Create database...',
	//'STAT_CREATE_DB_TABLE' => 'Create database... (table: %s)',
	'STAT_CREATE_DEFAULT_SETTINGS' => 'Create default settings...',
	'STAT_INSTALL_FINISH' => 'Install finish...',
	'STAT_INSTALL_FINISH_LOGIN' => 'Installation process finished, <a href="%s">please log in...</a>',
	'LBL_LICENCE_TOOLTIP' => 'Please accept license first',

	'LBL_MORE_OPTIONS_TITLE' => 'More options',
	'LBL_START' => 'Start',


);

?>
