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
	'LBL_BASIC_SEARCH'					=> 'Osnovna Pretraga',
	'LBL_ADVANCED_SEARCH'				=> 'Napredna Pretraga',
	'LBL_BASIC_TYPE'					=> 'Osnovni Tip',
	'LBL_ADVANCED_TYPE'					=> 'Napredni Tip',
	'LBL_SYSOPTS_1'						=> 'Odaberite iz ispod ponuđenih opcija sistemskih konfiguracija.',
    'LBL_SYSOPTS_2'                     => 'Koji tip baze podataka će biti korišten za SuiteCRM instancu koju upravo instalirate?',
	'LBL_SYSOPTS_CONFIG'				=> 'Sistemske Postavke',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Odaberite tip baze podataka',
    'LBL_SYSOPTS_DB_TITLE'              => 'Tip Baze Podataka',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Molimo popravite sljedeće greške prije nego što nastavite sa instalacijom:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Molimo omogućite zapisivanje u sljedeći direktorij:',
    'ERR_DB_VERSION_FAILURE'			=> 'Neuspjela provjera verzije baze podataka.',
	'DEFAULT_CHARSET'					=> 'UTF-8',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Pružite korisničko ime za SuiteCRM administratora.',
	'ERR_ADMIN_PASS_BLANK'				=> 'Pružite lozinku za SuiteCRM adminstratora.',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'Errors have been detected during compatibility check.  In order for your SuiteCRM Installation to function properly, please take the proper steps to address the issues listed below and either press the recheck button, or try installing again.',
    'ERR_CHECKSYS_CALL_TIME'            => 'Allow Call Time Pass Reference is On (this should be set to Off in php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'Nije pronađeno: SuiteCRM raspored pokrenuti će se sa ograničenim funkcionalnostima.',
    'ERR_CHECKSYS_IMAP'					=> 'Nije pronađeno: Dolazna e-pošta i kampanje (e-pošta) zahtjevaju IMAP libraries. Niti jedna neće biti funkcionalna.',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC cannot be turned "On" when using MS SQL Server.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Upozorenje:',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> '(Postavite ovo na',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M ili veće u vašoj php.ini datoteci.)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Minimalna verzija 4.1.2 - pronađeno:',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Failed to write and read session variables.  Unable to proceed with the installation.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'Nije važeći direktorij.',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Warning: Not Writable',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Vaša verzija PHP nije podržana od SuiteCRM. Morati ćete instalirati verziju koja je kompatibilna sa SuiteCRM aplikacijom. Molim konzultirajte se sa Compatibility Matrix u bilješkama za podržane PHP verzije. Vaša verzija je',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'Vaša verzija IIS nije podržana od SuiteCRM. Morati ćete instalirati verziju koja je kompatibilna sa SuiteCRM aplikacijom. Molim konzultirajte se sa Compatibility Matrix u bilješkama za podržane IIS verzije. Vaša verzija je',
	'ERR_CHECKSYS_FASTCGI'              => 'We detect that you are not using a FastCGI handler mapping for PHP. You will need to install/configure a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported Versions. Please see <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> for details ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Za optimalno iskustvo koriteći IIS/FastCGI sapi, postavite fastcgi.logging na 0 u vašoj php.ini datoteci.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Nepodržana PHP verzija instalirana: ( ver',
    'LBL_DB_UNAVAILABLE'                => 'Baza podataka nije dostupna',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'Database Support was not found.  Please make sure you have the necessary drivers for one of the following supported Database Types: MySQL or MS SQLServer.  You might need to uncomment the extension in the php.ini file, or recompile with the right binary file, depending on your version of PHP.  Please refer to your PHP Manual for more information on how to enable Database Support.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'Functions associated with XML Parser Libraries that are needed by the SuiteCRM application were not found.  You might need to uncomment the extension in the  php.ini file, or recompile with the right binary file, depending on your version of PHP.  Please refer to your PHP Manual for more information.',
    'ERR_CHECKSYS_MBSTRING'             => 'Functions associated with the Multibyte Strings PHP extension (mbstring) that are needed by the SuiteCRM application were not found. <br/><br/>Generally, the mbstring module is not enabled by default in PHP and must be activated with --enable-mbstring when the PHP binary is built. Please refer to your PHP Manual for more information on how to enable mbstring support.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'The session.save_path setting in your php configuration file (php.ini) is not set or is set to a folder which did not exist. You might need to set the save_path setting in php.ini or verify that the folder sets in save_path exist.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'The session.save_path setting in your php configuration file (php.ini) is set to a folder which is not writeable.  Please take the necessary steps to make the folder writeable.  <br>Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'The config file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'The config override file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'The Custom Directory exists but is not writeable.  You may have to change permissions on it (chmod 766) or right click on it and uncheck the read only option, depending on your Operating System.  Please take the needed steps to make the file writeable.',
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "The files or directories listed below are not writeable or are missing and cannot be created.  Depending on your Operating System, correcting this may require you to change permissions on the files or parent directory (chmod 755), or to right click on the parent directory and uncheck the 'read only' option and apply it to all subfolders.",
    'LBL_CHECKSYS_OVERRIDE_CONFIG' => 'Config override',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'Sigurnosni način je uključen (možda ćete htjeti isključiti ga u php.ini)',
    'ERR_CHECKSYS_ZLIB'					=> 'ZLib support not found: SuiteCRM reaps enormous performance benefits with zlib compression.',
    'ERR_CHECKSYS_ZIP'					=> 'ZIP podška nije pronađena: SuiteCRM zahtjeva ZIP podršku kako bi procesuirao kompresiranje datoteke.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE library not found: SuiteCRM needs PCRE library in order to process Perl style of regular expression pattern matching.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE library version: SuiteCRM needs PCRE library 7.0 or above to process Perl style of regular expression pattern matching.',
	'ERR_DB_ADMIN'						=> 'The provided database administrator username and/or password is invalid, and a connection to the database could not be established.  Please enter a valid user name and password.  (Error: ',
    'ERR_DB_ADMIN_MSSQL'                => 'The provided database administrator username and/or password is invalid, and a connection to the database could not be established.  Please enter a valid user name and password.',
	'ERR_DB_EXISTS_NOT'					=> 'Označena baza podataka ne postoji.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'Database already exists with config data.  To run an install with the chosen database, please re-run the install and choose: "Drop and recreate existing SuiteCRM tables?"  To upgrade, use the Upgrade Wizard in the Admin Console.  Please read the upgrade documentation located <a href="http://www.suitecrm.com target="_new">here</a>.',
	'ERR_DB_EXISTS'						=> 'The provided Database Name already exists -- cannot create another one with the same name.',
    'ERR_DB_EXISTS_PROCEED'             => 'The provided Database Name already exists.  You can<br>1.  hit the back button and choose a new database name <br>2.  click next and continue but all existing tables on this database will be dropped.  <strong>This means your tables and data will be blown away.</strong>',
	'ERR_DB_HOSTNAME'					=> 'Ime hosta nemože biti prazno.',
	'ERR_DB_INVALID'					=> 'Odabran pogrešan tip baze podataka.',
	'ERR_DB_LOGIN_FAILURE'				=> 'The provided database host, username, and/or password is invalid, and a connection to the database could not be established.  Please enter a valid host, username and password',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'The provided database host, username, and/or password is invalid, and a connection to the database could not be established.  Please enter a valid host, username and password',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'The provided database host, username, and/or password is invalid, and a connection to the database could not be established.  Please enter a valid host, username and password',
	'ERR_DB_MYSQL_VERSION'				=> 'Your MySQL version (%s) is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported MySQL versions.',
	'ERR_DB_NAME'						=> 'Naziv baze podataka ne može biti prazan.',
	'ERR_DB_NAME2'						=> "Naziv baze podataka ne može sadržavati '\\', '/', ili '.'",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "Naziv baze podataka ne može sadržavati '\\', '/', ili '.'",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "Database name cannot begin with a number, '#', or '@' and cannot contain a space, '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', '&', '!', or '-'",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "Database name can only consist of alphanumeric characters and the symbols '#', '_' or '$'",
	'ERR_DB_PASSWORD'					=> 'The passwords provided for the SuiteCRM database administrator do not match.  Please re-enter the same passwords in the password fields.',
	'ERR_DB_PRIV_USER'					=> 'Provide a database administrator user name.  The user is required for the initial connection to the database.',
	'ERR_DB_USER_EXISTS'				=> 'User name for SuiteCRM database user already exists -- cannot create another one with the same name. Please enter a new user name.',
	'ERR_DB_USER'						=> 'Unesite korisničko ime za SuiteCRM administratora baze podataka.',
	'ERR_DBCONF_VALIDATION'				=> 'Molimo popravite sljedeće greške prije nego što nastavite sa instalacijom:',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'The passwords provided for the SuiteCRM database user do not match. Please re-enter the same passwords in the password fields.',
	'ERR_ERROR_GENERAL'					=> 'Sljedeće greške su otkrivene:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'Datoteka se ne može izbrisati:',
	'ERR_LANG_MISSING_FILE'				=> 'Datoteka nije pronađena:',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'No language pack file found at include/language inside: ',
	'ERR_LANG_UPLOAD_1'					=> 'Pojavio se problem sa vašim uploadom. Molim pokušajte ponovo.',
	'ERR_LANG_UPLOAD_2'					=> 'Jezični paketi moraju biti ZIp arhive.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP ne može pomaknuti temp datoteku u direktorij nadogradnje.',
	'ERR_LICENSE_MISSING'				=> 'Nedostaju potrebna polja',
	'ERR_LICENSE_NOT_FOUND'				=> 'Datoteka licence nije pronađena!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'Pruženi direktorij zapisa nije validan direktorij.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'Log directory provided is not a writable directory.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Log directory is required if you wish to specify your own.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'Unable to process script directly.',
	'ERR_NO_SINGLE_QUOTE'				=> 'Ne može se koristiti jednostruki citat za',
	'ERR_PASSWORD_MISMATCH'				=> 'The passwords provided for the SuiteCRM admin user do not match.  Please re-enter the same passwords in the password fields.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'Cannot write to the <span class=stop>config.php</span> file.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'You can continue this installation by manually creating the config.php file and pasting the configuration information below into the config.php file.  However, you <strong>must </strong>create the config.php file before you continue to the next step.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'Jeste li zapamtili kreirati config.php datoteku?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Upozorenje: Ne može se zapisivati u config.php datoteku. Molim provjerite postoji li datoteka.',
	'ERR_PERFORM_HTACCESS_1'			=> 'Ne može se zapisati u',
	'ERR_PERFORM_HTACCESS_2'			=> 'datoteku.',
	'ERR_PERFORM_HTACCESS_3'			=> 'If you want to secure your log file from being accessible via browser, create an .htaccess file in your log directory with the line:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>We could not detect an Internet connection.</b> When you do have a connection, please visit <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> to register with SuiteCRM. By letting us know a little bit about how your company plans to use SuiteCRM, we can ensure we are always delivering the right application for your business needs.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'Session directory provided is not a valid directory.',
	'ERR_SESSION_DIRECTORY'				=> 'Session directory provided is not a writable directory.',
	'ERR_SESSION_PATH'					=> 'Session path is required if you wish to specify your own.',
	'ERR_SI_NO_CONFIG'					=> 'You did not include config_si.php in the document root, or you did not define $sugar_config_si in config.php',
	'ERR_SITE_GUID'						=> 'Application ID is required if you wish to specify your own.',
    'ERROR_SPRITE_SUPPORT'              => "Currently we are not able to locate the GD library, as a result you will not be able to use the CSS Sprite functionality.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Warning: Your PHP configuration should be changed to allow files of at least 6MB to be uploaded.',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Veličina datoteke uploada',
	'ERR_URL_BLANK'						=> 'Pružite bazni URL za SuiteCRM instancu.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'Nije pronađen zapis o instalaciji od',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'Uploadana datoteka nije kompatibilna sa ovim vrstama (Community Edition, Professional, ili Enterprise) SuiteCRM-a.',
	'ERROR_LICENSE_EXPIRED'				=> "Greška: Vaša licenca je istekla",
	'ERROR_LICENSE_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to enter your new license key.  If you do not enter a new license key within 30 days of your license key expiration, you will no longer be able to log in to this application.",
	'ERROR_MANIFEST_TYPE'				=> 'Manifest datoteka mora imati definirani tip paketa.',
	'ERROR_PACKAGE_TYPE'				=> 'Tip paketa definiran u Manifest datoteci nije prepoznat.',
	'ERROR_VALIDATION_EXPIRED'			=> "Greška: Vaša licenca je istekla prije",
	'ERROR_VALIDATION_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a> in the Admin screen to enter your new validation key.  If you do not enter a new validation key within 30 days of your validation key expiration, you will no longer be able to log in to this application.",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'Učitana datoteka nije kompatibilna sa ovom verzijom SuiteCRM-a:',

	'LBL_BACK'							=> 'Natrag',
    'LBL_CANCEL'                        => 'Odustani',
    'LBL_ACCEPT'                        => 'Prihvaćam',
	'LBL_CHECKSYS_1'					=> 'In order for your SuiteCRM installation to function properly, please ensure all of the system check items listed below are green. If any are red, please take the necessary steps to fix them.<BR><BR> For help on these system checks, please visit the <a href="http://www.suitecrm.com" target="_blank">SuiteCRM</a>.',
	'LBL_CHECKSYS_CACHE'				=> 'Writable Cache Sub-Directories',
    'LBL_DROP_DB_CONFIRM'               => 'The provided Database Name already exists.<br>You can either:<br>1.  Click on the Cancel button and choose a new database name, or <br>2.  Click the Accept button and continue.  All existing tables in the database will be dropped. <strong>This means that all of the tables and pre-existing data will be blown away.</strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned Off',
    'LBL_CHECKSYS_COMPONENT'			=> 'Komponenta',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Opcionalne komponente',
	'LBL_CHECKSYS_CONFIG'				=> 'Writable SuiteCRM Configuration File (config.php)',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Writable SuiteCRM Configuration File (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'cURL modul',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Session Save Path Setting',
	'LBL_CHECKSYS_CUSTOM'				=> 'Writeable Custom Directory',
	'LBL_CHECKSYS_DATA'					=> 'Writable Data Sub-Directories',
	'LBL_CHECKSYS_IMAP'					=> 'IMAP modul',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'MB Strings Modul',
	'LBL_CHECKSYS_MEM_OK'				=> 'Ok (Bez granica)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'Ok (neograničeno)',
	'LBL_CHECKSYS_MEM'					=> 'PHP ograničenje memorije',
	'LBL_CHECKSYS_MODULE'				=> 'Writable Modules Sub-Directories and Files',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'MySQL verzija',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'Nije dostupno',
	'LBL_CHECKSYS_OK'					=> 'OK',
	'LBL_CHECKSYS_PHP_INI'				=> 'Lokacija vaše PHP konfiguracijske datoteke (php.ini):',
	'LBL_CHECKSYS_PHP_OK'				=> 'OK (ver ',
	'LBL_CHECKSYS_PHPVER'				=> 'PHP verzija',
    'LBL_CHECKSYS_IISVER'               => 'IIS verzija',
	'LBL_CHECKSYS_RECHECK'				=> 'Ponovo provjeri',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP Safe Mode isključen',
	'LBL_CHECKSYS_SESSION'				=> 'Writable Session Save Path (',
	'LBL_CHECKSYS_STATUS'				=> 'Status',
	'LBL_CHECKSYS_TITLE'				=> 'System Check Acceptance',
	'LBL_CHECKSYS_VER'					=> 'Pronađeno: ( ver ',
	'LBL_CHECKSYS_XML'					=> 'XML Analiza Sintakse',
	'LBL_CHECKSYS_ZLIB'					=> 'ZLIB Modul kompresije',
	'LBL_CHECKSYS_ZIP'					=> 'ZIP modul rukovanja',
	'LBL_CHECKSYS_PCRE'					=> 'PCRE Library',
	'LBL_CHECKSYS_FIX_FILES'            => 'Please fix the following files or directories before proceeding:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Please fix the following module directories and the files under them before proceeding:',
    'LBL_CHECKSYS_UPLOAD'               => 'Writable Upload Directory',
    'LBL_CLOSE'							=> 'Zatvori',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'biti kreirano',
	'LBL_CONFIRM_DB_TYPE'				=> 'Tip Baze Podataka',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Please confirm the settings below.  If you would like to change any of the values, click "Back" to edit.  Otherwise, click "Next" to start the installation.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Informacije o licenci',
	'LBL_CONFIRM_NOT'					=> 'not',
	'LBL_CONFIRM_TITLE'					=> 'Potvrdi postavke',
	'LBL_CONFIRM_WILL'					=> 'will',
	'LBL_DBCONF_CREATE_DB'				=> 'Kreiraj bazu podataka',
	'LBL_DBCONF_CREATE_USER'			=> 'Kreiraj korisnika',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Oprez: Svi SuiteCRM podaci biti će izbrisani<br>ako je ova kućica označena.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Odbaci i ponovo kreiraj postojeće SuiteCRM tablice?',
    'LBL_DBCONF_DB_DROP'                => 'Drop Tables',
    'LBL_DBCONF_DB_NAME'				=> 'Naziv baze podataka',
	'LBL_DBCONF_DB_PASSWORD'			=> 'SuiteCRM lozinka korisnika baze podataka',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Ponovno unesite lozinku korisnika baze podataka',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM Database User',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM Database User',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Administratorsko korisničko ime u bazi podataka',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Administratorska lozinka baze podataka',
	'LBL_DBCONF_DEMO_DATA'				=> 'Popuniti bazu podataka sa demo podacima?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Odaberite demo podatke',
	'LBL_DBCONF_HOST_NAME'				=> 'Host Name',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Host Instance',
	'LBL_DBCONF_HOST_PORT'				=> 'Luka',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Please enter your database configuration information below. If you are unsure of what to fill in, we suggest that you use the default values.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Use multi-byte text in demo data?',
    'LBL_DBCONFIG_MSG2'                 => 'Name of web server or machine (host) on which the database is located ( such as localhost or www.mydomain.com ):',
	'LBL_DBCONFIG_MSG2_LABEL' => 'Host Name',
    'LBL_DBCONFIG_MSG3'                 => 'Name of the database that will contain the data for the SuiteCRM instance you are about to install:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'Naziv baze podataka',
    'LBL_DBCONFIG_B_MSG1'               => 'The username and password of a database administrator who can create database tables and users and who can write to the database is necessary in order to set up the SuiteCRM database.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
    'LBL_DBCONFIG_SECURITY'             => 'For security purposes, you can specify an exclusive database user to connect to the SuiteCRM database.  This user must be able to write, update and retrieve data on the SuiteCRM database that will be created for this instance.  This user can be the database administrator specified above, or you can provide new or existing database user information.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Učini to za mene',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Pruži postojećeg korisnika',
    'LBL_DBCONFIG_CREATE_DD'            => 'Definiraj korisnika za kreirati',
    'LBL_DBCONFIG_SAME_DD'              => 'Isto kao i administratorski korisnik',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'Pretraživanje punog teksta',
    'LBL_FTS_INSTALLED'                 => 'Instalirano',
    'LBL_FTS_INSTALLED_ERR1'            => 'Full Text Search capability is not installed.',
    'LBL_FTS_INSTALLED_ERR2'            => 'You can still install but will not be able to use Full Text Search functionality.  Please refer to your database server install guide on how to do this, or contact your Administrator.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Korisnička lozinka privilegirane baze podataka',
	'LBL_DBCONF_PRIV_USER_2'			=> 'Database Account Above Is a Privileged User?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'This privileged database user must have the proper permissions to create a database, drop/create tables, and create a user.  This privileged database user will only be used to perform these tasks as needed during the installation process.  You may also use the same database user as above if that user has sufficient privileges.',
	'LBL_DBCONF_PRIV_USER'				=> 'Privileged Database User Name',
	'LBL_DBCONF_TITLE'					=> 'Konfiguracija baze podataka',
    'LBL_DBCONF_TITLE_NAME'             => 'Pružite ime baze podataka',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Pružite informaciju korisnika baze podataka',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'Korisnik',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'Lozinka',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Nakon što je ova promjena učinjena, možete kliknuti na "Start" kako bi započeli instalaciju. <i>Nakon što je instalacija dovršena, možda ćete htjeti promijeniti vrijednost za \'installer_locked\' u \'true\'.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'Instalacija je već jednom bila pokrenuta. Kao sigurnosna mjera, onemogućeno je pokretanje instalacije drugi put. Ako ste zaista sigurni želite li ponovno pokrenuti instalaciju, molim idite u vašu config.php datoteku i pronađite (ili dodajte) varijablu naziva \'installer_locked\' i postavite na \'false\'. Redak bi trebao izgledati ovako:',
	'LBL_DISABLED_HELP_1'				=> 'Za pomoć pri instalaciji, molim posjetite SuiteCRM',
    'LBL_DISABLED_HELP_LNK'             => 'http://www.suitecrm.com/forum/index',
	'LBL_DISABLED_HELP_2'				=> 'forume za podršku',
	'LBL_DISABLED_TITLE_2'				=> 'SuiteCRM instalacija je onemogućena',
	'LBL_DISABLED_TITLE'				=> 'SuiteCRM instalacija onemogućena',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Character Set most commonly used in your locale',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Postavke odlazne e-pošte',
    'LBL_EMAIL_CHARSET_CONF'            => 'Skup znakova za odlaznu e-poštu',
	'LBL_HELP'							=> 'Pomoć',
    'LBL_INSTALL'                       => 'Instaliraj',
    'LBL_INSTALL_TYPE_TITLE'            => 'Opcije instalacije',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Odaberite tip instalacije',
    'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>Tipična instalacija</b>',
    'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>Prilagođena instalacija</b>',
    'LBL_INSTALL_TYPE_MSG1'             => 'The key is required for general application functionality, but it is not required for installation. You do not need to enter the key at this time, but you will need to provide the key after you have installed the application.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Zahtjeva minimalne informacije za instalaciju. Preporučeno novim korisnicima.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Provides additional options to set during the installation. Most of these options are also available after installation in the admin screens. Recommended for advanced users.',
	'LBL_LANG_1'						=> 'To use a language in SuiteCRM other than the default language (US-English), you can upload and install the language pack at this time. You will be able to upload and install language packs from within the SuiteCRM application as well.  If you would like to skip this step, click Next.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Instaliraj',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Ukloni',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Deinstaliraj',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Uploadaj',
	'LBL_LANG_NO_PACKS'					=> 'nijedan',
	'LBL_LANG_PACK_INSTALLED'			=> 'Sljedeći jezični paketi su uspješno instalirani:',
	'LBL_LANG_PACK_READY'				=> 'Sljedeći jezični paket spreman je za instalaciju:',
	'LBL_LANG_SUCCESS'					=> 'Jezični paket uspješno uploadan.',
	'LBL_LANG_TITLE'			   		=> 'Jezični paket',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Sada se instalira SuiteCRM. Ovo može potrajati nekoliko minuta.',
	'LBL_LANG_UPLOAD'					=> 'Uploadaj jezični paket',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Prihvaćanje licence',
    'LBL_LICENSE_CHECKING'              => 'Provjeravanje kompatibilnosti sustava,',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Checking Environment',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Provjera DB Credentials.',
    'LBL_LICENSE_CHECK_PASSED'          => 'Sustav je prošao provjeru kompatibilnosti.',
	'LBL_CREATE_CACHE' => 'Preparing to Install...',
    'LBL_LICENSE_REDIRECT'              => 'Preusmjeravanje u',
	'LBL_LICENSE_DIRECTIONS'			=> 'Ako imate informaciju o licenci, molim unesite ju u polja ispod.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Unesite ključ preuzimanja',
	'LBL_LICENSE_EXPIRY'				=> 'Datum isteka',
	'LBL_LICENSE_I_ACCEPT'				=> 'Prihvaćam',
	'LBL_LICENSE_NUM_USERS'				=> 'Broj korisnika',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Molim unesite broj kupljenih offline klijenata.',
	'LBL_LICENSE_OC_NUM'				=> 'Broj offline licenci klijenata',
	'LBL_LICENSE_OC'					=> 'Licence offline klijenata',
	'LBL_LICENSE_PRINTABLE'				=> ' Printable View ',
    'LBL_PRINT_SUMM'                    => 'Rezime ispisa',
	'LBL_LICENSE_TITLE_2'				=> 'SuiteCRM licenca',
	'LBL_LICENSE_TITLE'					=> 'Informacije o licenci',
	'LBL_LICENSE_USERS'					=> 'Licencirani korisnici',

	'LBL_LOCALE_CURRENCY'				=> 'Postavke valute',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Zadana valuta',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Simbol valute',
	'LBL_LOCALE_CURR_ISO'				=> 'Valutni kod (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> '1000s Separator',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Separator decimala',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Primjer',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Značajne znamenke',
	'LBL_LOCALE_DATEF'					=> 'Zadani format datuma',
	'LBL_LOCALE_DESC'					=> 'The specified locale settings will be reflected globally within the SuiteCRM instance.',
	'LBL_LOCALE_EXPORT'					=> 'Skup  znakova za Uvoz/Izvoz<br> <i>(Email, .csv, vCard, PDF, uvoz podataka)</i>',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Export (.csv) Delimiter',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Postavke uvoza/izvoza',
	'LBL_LOCALE_LANG'					=> 'Zadani jezik',
	'LBL_LOCALE_NAMEF'					=> 'Zadani format imena',
	'LBL_LOCALE_NAMEF_DESC'				=> 's = salutation<br />f = first name<br />l = last name',
	'LBL_LOCALE_NAME_FIRST'				=> 'David',
	'LBL_LOCALE_NAME_LAST'				=> 'Livingstone',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Dr.',
	'LBL_LOCALE_TIMEF'					=> 'Zadani format vremena',

    'LBL_CUSTOMIZE_LOCALE'              => 'Prilagodi lokalne postavke',
	'LBL_LOCALE_UI'						=> 'Korisničko sučelje',

	'LBL_ML_ACTION'						=> 'Radnja',
	'LBL_ML_DESCRIPTION'				=> 'Opis',
	'LBL_ML_INSTALLED'					=> 'Datum instalacije',
	'LBL_ML_NAME'						=> 'Ime',
	'LBL_ML_PUBLISHED'					=> 'Datum objavljivanja',
	'LBL_ML_TYPE'						=> 'Tip',
	'LBL_ML_UNINSTALLABLE'				=> 'Ne može se deinstalirati',
	'LBL_ML_VERSION'					=> 'Verzija',
	'LBL_MSSQL'							=> 'SQL Server',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver for PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (mysqli ekstenzija)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Sljedeće',
	'LBL_NO'							=> 'Ne',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Postavljanje lozinke administratora stranice',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'tablica revizije /',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Kreiranje SuiteCRM konfiguracijske datoteke',
	'LBL_PERFORM_CREATE_DB_1'			=> '<b>Kreiranje baze podataka</b> ',
	'LBL_PERFORM_CREATE_DB_2'			=> ' <b>na</b> ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Kreiranje korisničkog imena i lozinke baz podataka...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Kreiranje zadanih SuiteCRM podataka',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Kreiranje korisničkog imena i lozinke baze podataka za localhost...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Kreiranje SuiteCRM tablice veza',
	'LBL_PERFORM_CREATING'				=> 'kreiranje /',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Kreiranje zadanih izvještaja',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Kreiranje zadanih zakazanih poslova',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Umetanje zadanih postavki',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Kreiranje zadanih korisnika',
	'LBL_PERFORM_DEMO_DATA'				=> 'Populating the database tables with demo data (this may take a little while)',
	'LBL_PERFORM_DONE'					=> 'done<br>',
	'LBL_PERFORM_DROPPING'				=> 'odbacivanje /',
	'LBL_PERFORM_FINISH'				=> 'Završi',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Ažuriranje informacije o licenci',
	'LBL_PERFORM_OUTRO_1'				=> 'Podešavanje SuiteCRM',
	'LBL_PERFORM_OUTRO_2'				=> 'je sada dovršeno!',
	'LBL_PERFORM_OUTRO_3'				=> 'Ukupno vrijeme:',
	'LBL_PERFORM_OUTRO_4'				=> 'sekunda.',
	'LBL_PERFORM_OUTRO_5'				=> 'Približno količina korištene memorije:',
	'LBL_PERFORM_OUTRO_6'				=> 'bajtova.',
	'LBL_PERFORM_OUTRO_7'				=> 'Vaš sustav sada je instaliran i konfiguriran za korištenje.',
	'LBL_PERFORM_REL_META'				=> 'relationship meta ... ',
	'LBL_PERFORM_SUCCESS'				=> 'Uspjeh!',
	'LBL_PERFORM_TABLES'				=> 'Kreiranje SuiteCRM aplikacijskih tablica, revizijskih tablica, i meta podataka veza...',
	'LBL_PERFORM_TITLE'					=> 'Izvrši podešavanje',
	'LBL_PRINT'							=> 'Ispis',
	'LBL_REG_CONF_1'					=> 'Please complete the short form below to receive product announcements, training news, special offers and special event invitations from SuiteCRM. We do not sell, rent, share or otherwise distribute the information collected here to third parties.',
	'LBL_REG_CONF_2'					=> 'Your name and email address are the only required fields for registration. All other fields are optional, but very helpful. We do not sell, rent, share, or otherwise distribute the information collected here to third parties.',
	'LBL_REG_CONF_3'					=> 'Thank you for registering. Click on the Finish button to login to SuiteCRM. You will need to log in for the first time using the username "admin" and the password you entered in step 2.',
	'LBL_REG_TITLE'						=> 'Registracija',
    'LBL_REG_NO_THANKS'                 => 'Ne hvala',
    'LBL_REG_SKIP_THIS_STEP'            => 'Preskoči ovaj korak',
	'LBL_REQUIRED'						=> '* Potrebno polje',

    'LBL_SITECFG_ADMIN_Name'            => 'SuiteCRM aplikacija admin ime',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Ponovo unesite SuiteCRM admin korisničku lozinku',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Caution: This will override the admin password of any previous installation.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'SuiteCRM Admin korisnička lozinka',
	'LBL_SITECFG_APP_ID'				=> 'ID aplikacije',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'If selected, you must provide an application ID to override the auto-generated ID. The ID ensures that sessions of one SuiteCRM instance are not used by other instances.  If you have a cluster of SuiteCRM installations, they all must share the same application ID.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Provide Your Own Application ID',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'If selected, you must specify a log directory to override the default directory for the SuiteCRM log. Regardless of where the log file is located, access to it through a web browser will be restricted via an .htaccess redirect.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Koristi prilagođeni direktorij zapisnika',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'If selected, you must provide a secure folder for storing SuiteCRM session information. This can be done to prevent session data from being vulnerable on shared servers.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Use a Custom Session Directory for SuiteCRM',
	'LBL_SITECFG_DIRECTIONS'			=> 'Please enter your site configuration information below. If you are unsure of the fields, we suggest that you use the default values.',
	'LBL_SITECFG_FIX_ERRORS'			=> '<b>Please fix the following errors before proceeding:</b>',
	'LBL_SITECFG_LOG_DIR'				=> 'Direktorij zapisnika',
	'LBL_SITECFG_SESSION_PATH'			=> 'Path to Session Directory<br>(must be writable)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Odaberi sigurnosne opcije',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'If selected, the system will periodically check for updated versions of the application.',
	'LBL_SITECFG_SUGAR_UP'				=> 'Automatski provjeri za ažuriranja?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Konfiguracija SuiteCRM ažuriranja',
	'LBL_SITECFG_TITLE'					=> 'Konfiguracija stranice',
    'LBL_SITECFG_TITLE2'                => 'Identificiraj administracijskog korisnika',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Sigurnost stranice',
	'LBL_SITECFG_URL'					=> 'URL SuiteCRM instance',
	'LBL_SITECFG_USE_DEFAULTS'			=> 'Koristi zadano?',
	'LBL_SITECFG_ANONSTATS'             => 'Pošalji anonimnu statistiku korištenja?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'If selected, SuiteCRM will send <b>anonymous</b> statistics about your installation to SuiteCRM Inc. every time your system checks for new versions. This information will help us better understand how the application is used and guide improvements to the product.',
    'LBL_SITECFG_URL_MSG'               => 'Enter the URL that will be used to access the SuiteCRM instance after installation. The URL will also be used as a base for the URLs in the SuiteCRM application pages. The URL should include the web server or machine name or IP address.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Enter a name for your system.  This name will be displayed in the browser title bar when users visit the SuiteCRM application.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'After installation, you will need to use the SuiteCRM admin user (default username = admin) to log in to the SuiteCRM instance.  Enter a password for this administrator user. This password can be changed after the initial login.  You may also enter another admin username to use besides the default value provided.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Select collation (sorting) settings for your system. This settings will create the tables with the specific language you use. In case your language doesn\'t require special settings please use default value.',
    'LBL_SPRITE_SUPPORT'                => 'Sprite support',
	'LBL_SYSTEM_CREDS'                  => 'System Credentials',
    'LBL_SYSTEM_ENV'                    => 'System Environment',
	'LBL_START'							=> 'Započni',
    'LBL_SHOW_PASS'                     => 'Prikaži lozinke',
    'LBL_HIDE_PASS'                     => 'Sakrij lozinke',
    'LBL_HIDDEN'                        => '<i>(sakriveno)</i>',
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
	'LBL_CHOOSE_LANG'					=> '<b>Odaberite jezik</b>',
	'LBL_STEP'							=> 'Korak',
	'LBL_TITLE_WELCOME'					=> 'Dobrodošli u SuiteCRM',
	'LBL_WELCOME_1'						=> 'This installer creates the SuiteCRM database tables and sets the configuration variables that you need to start. The entire process should take about ten minutes.',
	'LBL_WELCOME_2'						=> 'For installation documentation, please visit the <a href="http://www.SuiteCRM.com/" target="_blank">SuiteCRM</a>.  <BR><BR> You can also find help from the SuiteCRM Community in the <a href="http://www.SuiteCRM.com/" target="_blank">SuiteCRM Forums</a>.',
    //welcome page variables
    'LBL_TITLE_ARE_YOU_READY'            => 'Jeste li spremni za instalaciju?',
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
    'REQUIRED_SYS_CHK' => 'Inicijalna provjera sustava',
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
    'REQUIRED_INSTALLTYPE' => 'Tipična ili prilagođena instalacija',
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

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '<b>Odaberite jezik</b>',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Čarobnjak za postavljanje',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Dobrodošli u SuiteCRM',
	'LBL_WELCOME_TITLE'					=> 'SuiteCRM čarobnjak za postavljanje',
	'LBL_WIZARD_TITLE'					=> 'SuiteCRM čarobnjak za postavljanje:',
	'LBL_YES'							=> 'Da',
    'LBL_YES_MULTI'                     => 'Yes - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Process Workflow Tasks',
	'LBL_OOTB_REPORTS'		=> 'Run Report Generation Scheduled Tasks',
	'LBL_OOTB_IE'			=> 'Check Inbound Mailboxes',
	'LBL_OOTB_BOUNCE'		=> 'Run Nightly Process Bounced Campaign Emails',
    'LBL_OOTB_CAMPAIGN'		=> 'Run Nightly Mass Email Campaigns',
	'LBL_OOTB_PRUNE'		=> 'Prune Database on 1st of Month',
    'LBL_OOTB_TRACKER'		=> 'Prune tracker tables',
    'LBL_OOTB_SUGARFEEDS'   => 'Prune SuiteCRM Feed Tables',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Run Email Reminder Notifications',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Update tracker_sessions table',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Obriši popis poslova',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Removal of documents from filesystem',


    'LBL_PATCHES_TITLE'     => 'Instaliraj najnovije zakrpe',
    'LBL_MODULE_TITLE'      => 'Instaliraj jezične pakete',
    'LBL_PATCH_1'           => 'Ukoliko želite preskočiti ovaj korak, kliknite Sljedeće.',
    'LBL_PATCH_TITLE'       => 'Sistemska zakrpa',
    'LBL_PATCH_READY'       => 'The following patch(es) are ready to be installed:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM relies upon PHP sessions to store important information while connected to this web server.  Your PHP installation does not have the Session information correctly configured.
											<br><br>A common misconfiguration is that the <b>'session.save_path'</b> directive is not pointing to a valid directory.  <br>
											<br> Please correct your <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>PHP configuration</a> in the php.ini file located here below.",
	'LBL_SESSION_ERR_TITLE'				=> 'PHP Sessions Configuration Error',
	'LBL_SYSTEM_NAME'=>'Ime sustava',
    'LBL_COLLATION' => 'Collation Settings',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Provide a System Name for the SuiteCRM instance.',
	'LBL_PATCH_UPLOAD' => 'Odaberite datoteku zakrpe sa vašeg lokalong računala.',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Php verzija 5 ili više je potrebna.',
	'LBL_MINIMUM_PHP_VERSION' => 'Minimalna zahtjevana Php verzija je 5.1.0. Preporučena Php verzija je 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(Vaša trenutna php verzija je',
	'LBL_RECOMMENDED_PHP_VERSION' =>'Preporučena php verzija je 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'Php način unazadne kompatibilnosti je uključen. Podesite zend.ze1_compatibility_mode na Off kako bi nastavili dalje.',
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
	'LBL_CHOOSE_EMAIL_PROVIDER'        => 'Odaberi svog pružatelja E-mail usluga:',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! Mail',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => 'Ostalo',
	'LBL_MAIL_SMTP_SETTINGS'           => 'SMTP Detaljan Opis Servera',
	'LBL_MAIL_SMTPSERVER'				=> 'SMTP Server:',
	'LBL_MAIL_SMTPPORT'					=> 'SMTP Port:',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'Koristiti SMTP provjeru autentičnosti?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => 'Omogući SMTP iznad SSL ili TLS?',
	'LBL_GMAIL_SMTPUSER'					=> 'Gmail E-mail Adresa:',
	'LBL_GMAIL_SMTPPASS'					=> 'Gmail Lozinka:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => 'Dopusti korisnicima da koriste ovaj račun za izlaznu poštu:',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => 'Kada je ova opcija uključena, svi korisnici će moći slati poštu koristeći isti račun za izlaznu poštu koji se koristi za slanje sistemskih upozorenja i obavijesti. Ako ova opcija nije uključena, korisnici će i dalje moći koristiti server izlazne pošte ali nakon što unesu podatke o svom korisničkom računu.',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Yahoo! Mail Lozinka:',
	'LBL_YAHOOMAIL_SMTPUSER'					=> 'Yahoo! Mail ID:',

	'LBL_EXCHANGE_SMTPPASS'					=> 'Exchange Lozinka:',
	'LBL_EXCHANGE_SMTPUSER'					=> 'Exchange Korisničko Ime:',
	'LBL_EXCHANGE_SMTPPORT'					=> 'Exchange Port Servera:',
	'LBL_EXCHANGE_SMTPSERVER'				=> 'Exchange Server:',


	'LBL_MAIL_SMTPUSER'					=> 'SMTP Korisničko Ime:',
	'LBL_MAIL_SMTPPASS'					=> 'SMTP Lozinka:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Branding',
	'LBL_WIZARD_SYSTEM_DESC' => 'Provide your organization\'s name and logo in order to brand your SuiteCRM.',
	'SYSTEM_NAME_WIZARD'=>'Naziv:',
	'SYSTEM_NAME_HELP'=>'Ovo je ime koje se prikazuje na naslovnoj traci Vašeg preglednika.',
	'NEW_LOGO'=>'Odaberi logo:',
	'NEW_LOGO_HELP'=>'The image file format can be either .png or .jpg. The maximum height is 170px, and the maximum width is 450px. Any image uploaded that is larger in any direction will be scaled to these max dimensions.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'Uploadaj',
	'CURRENT_LOGO'=>'Trenutni logo:',
    'CURRENT_LOGO_HELP'=>'This logo is displayed in the left-hand corner of the footer of the SuiteCRM application.',

	// System Local Settings


	'LBL_LOCALE_TITLE' => 'System Locale Settings',
	'LBL_WIZARD_LOCALE_DESC' => 'Specify how you would like data in SuiteCRM to be displayed, based on your geographical location. The settings you provide here will be the default settings. Users will be able set their own preferences.',
	'LBL_DATE_FORMAT' => 'Format datuma:',
	'LBL_TIME_FORMAT' => 'Format vremena:',
		'LBL_TIMEZONE' => 'Vremenska zona:',
	'LBL_LANGUAGE'=>'Jezik:',
	'LBL_CURRENCY'=>'Valuta:',
	'LBL_CURRENCY_SYMBOL'=>'Currency Symbol:',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 Currency Code:',
	'LBL_NUMBER_GROUPING_SEP' => 'Separator 1000ica:',
	'LBL_DECIMAL_SEP' => 'Decimalni simbol:',
	'LBL_NAME_FORMAT' => 'Name Format:',
	'UPLOAD_LOGO' => 'Please wait, logo uploading..',
	'ERR_UPLOAD_FILETYPE' => 'File type do not allowed, please upload a jpeg or png.',
	'ERR_LANG_UPLOAD_UNKNOWN' => 'Unknown file upload error occured.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => 'The uploaded file was only partially uploaded.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => 'No file was uploaded.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => 'Missing a temporary folder.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => 'Neuspješno zapisivanje datoteke na disk.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.',

	'LBL_INSTALL_PROCESS' => 'Install...',

	'LBL_EMAIL_ADDRESS' => 'Adresa e-pošte:',
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
	'LBL_START' => 'Započni',


);

?>
