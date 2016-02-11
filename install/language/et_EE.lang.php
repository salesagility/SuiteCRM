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
	'LBL_BASIC_SEARCH'					=> 'Põhiotsing',
	'LBL_ADVANCED_SEARCH'				=> 'Laiendatud otsing',
	'LBL_BASIC_TYPE'					=> 'Põhitüüp',
	'LBL_ADVANCED_TYPE'					=> 'Advanced Type',
	'LBL_SYSOPTS_1'						=> 'Vali järgnevast süsteemist konfiguratsioonisuvandid alljärgnevalt',
    'LBL_SYSOPTS_2'                     => 'Millist tüüp andmebaasi hakatakse kasutama installitava Sugari jaoks?',
	'LBL_SYSOPTS_CONFIG'				=> 'Süsteemi konfiguratsioon',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Täpsusta andmebaasi tüüpi',
    'LBL_SYSOPTS_DB_TITLE'              => 'Andmebaasi tüüp',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Palun paranda järgmised vead enne jätkamist:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Palun muuda järgnev kataloog kirjutatavaks:',
    'ERR_DB_VERSION_FAILURE'			=> 'Unable to check database version.',
	'DEFAULT_CHARSET'					=> 'UTF-8',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Paku kasutajanimi Sugar admin kasutaja jaoks.',
	'ERR_ADMIN_PASS_BLANK'				=> 'Paku parool Sugar admin kasutaja jaoks.',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'Leitud vigu ühilduvuse kontrolli käigus. Kui sinu SugarCRM install funktsioneerib korralikult, palun tee järgmised sammud allpool loetletud probleemide osas ning kas klikka ülekontrolli klahvi või püüa uuesti installida.',
    'ERR_CHECKSYS_CALL_TIME'            => 'Allow Call Time Pass Reference is On (this should be set to Off in php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'Ei leitud: Sugar Scheduler käivitub limiteeritud funktsionaalsusega.',
    'ERR_CHECKSYS_IMAP'					=> 'Ei leitud: Sissetulev e-post ja kampaaniad (E-post) nõuavad IMAP andmekogusid. Need ei pea olema funktsionaalsed.',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC cannot be turned "On" when using MS SQL Server.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Hoiatus:',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> ' (Set this to ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M or larger in your php.ini file)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Minmaalne versioon 4.1.2 - Leitud:',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Ebaõnnestus kirjtuada ja lugeda sessiooni muutujaid. Ei saa jätkata installimist.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'Kehtetu kataloog',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Hoiatus: Ei ole kirjutatav',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Sinu PHP versioon pole Sugari poolt toetatud. Sul on vaja installda versioon, mis Sugariga ühildub. Sinu versioon on',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'Sinu IIS versioon pole Sugari poolt toetatud. Sul on vaja installda versioon, mis Sugariga ühildub. Sinu versioon on',
	'ERR_CHECKSYS_FASTCGI'              => 'We detect that you are not using a FastCGI handler mapping for PHP. You will need to install/configure a version that is compatible with the Sugar application. Please consult the Compatibility Matrix in the Release Notes for supported Versions. Please see http://www.iis.net/php/ for details',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'For optimal experience using IIS/FastCGI sapi, set fastcgi.logging to 0 in your php.ini file.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Installitud mittetoetatud PHP versioon: (vers',
    'LBL_DB_UNAVAILABLE'                => 'Andmebaas pole saadaval',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'Andmebaas tuge ei leitud. Palun veendu, et sul on vajalikud draiverid ühe jätgneva toetatud andmebaasi tüübi jaoks: MySQL, MS SQLServer, või Oracle. Võid vajada php.ini faili laiendust parempoolse binaarse faili jaoks, olenevalt sinu PHP versioonist. Palun loe oma PHP manualist rohkem infot Andmebaas Toe võimaluse kohta.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'Ei leitud XML Parser Andmekogudega seotud funktsioone, mis on Sugari rakendusega vajalikud. Võid vajada php.ini faili laiendust parempoolse binaarse faili jaoks, olenevalt sinu PHP versioonist. Palun loe oma PHP manualist rohkem infot.',
    'ERR_CHECKSYS_MBSTRING'             => 'Ei leitud Multibyte Strings PHP  laiendusega seotud funktsioone (mbstring), mis on Sugari rakenduse jaoks vajalik. Üldiselt, mbstring moobul pole vaikimisi lubatud PHP-s ja peab aktiveerima koos --enable-mbstring when the PHP. Palun loe oma PHP manualist rohkem infot, kuidas lubada mbstring tuge.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'The session.save_path setting in your php configuration file (php.ini) is not set or is set to a folder which did not exist. You might need to set the save_path setting in php.ini or verify that the folder sets in save_path exist.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'The session.save_path setting in your php configuration file (php.ini) is set to a folder which is not writeable.  Please take the necessary steps to make the folder writeable.  <br>Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'The config file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'The config override file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'The Custom Directory exists but is not writeable.  You may have to change permissions on it (chmod 766) or right click on it and uncheck the read only option, depending on your Operating System.  Please take the needed steps to make the file writeable.',
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "The files or directories listed below are not writeable or are missing and cannot be created.  Depending on your Operating System, correcting this may require you to change permissions on the files or parent directory (chmod 755), or to right click on the parent directory and uncheck the 'read only' option and apply it to all subfolders.",
    'LBL_CHECKSYS_OVERRIDE_CONFIG' => 'Config override',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (you may wish to disable in php.ini)',
    'ERR_CHECKSYS_ZLIB'					=> 'ZLib support not found: SuiteCRM reaps enormous performance benefits with zlib compression.',
    'ERR_CHECKSYS_ZIP'					=> 'ZIP support not found: SuiteCRM needs ZIP support in order to process compressed files.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE library not found: SuiteCRM needs PCRE library in order to process Perl style of regular expression pattern matching.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE library version: SuiteCRM needs PCRE library 7.0 or above to process Perl style of regular expression pattern matching.',
	'ERR_DB_ADMIN'						=> 'Pakutud andmebaasi admini kasutajanimi ja/või salasõna on kehtetud, ja ühendust andmebaasiga ei õnnestu saada. Palun sisesta kehtiv kasutajanimi ja salasõna. (Viga:',
    'ERR_DB_ADMIN_MSSQL'                => 'Pakutud andmebaasi admini kasutajanimi ja/või salasõna on kehtetud, ja ühendust andmebaasiga ei õnnestu saada. Palun sisesta kehtiv kasutajanimi ja salasõna',
	'ERR_DB_EXISTS_NOT'					=> 'Täpsustatud andmebaasi ei eksisteeri.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'Database already exists with config data.  To run an install with the chosen database, please re-run the install and choose: "Drop and recreate existing SuiteCRM tables?"  To upgrade, use the Upgrade Wizard in the Admin Console.  Please read the upgrade documentation located <a href="http://www.suitecrm.com target="_new">here</a>.',
	'ERR_DB_EXISTS'						=> 'Pakutud andmebaasi nimi juba eksisteerib -- ei saa luua teist samanimelist.',
    'ERR_DB_EXISTS_PROCEED'             => 'Pakutud andmebaasi nimi juba eksisteerib. Sa saad:<br />1. klikata Tagasi klahvi ja valida uus nimi<br />2. klikata Edasi ja jätkata, kuid kõik olemasolevad tabelid selles andmebaasis kõrvaldatakse. See tähendab, et sinu tabelid ja andmed pühitakse minema.',
	'ERR_DB_HOSTNAME'					=> 'Majutaja nimi ei saa jääda tühjaks:',
	'ERR_DB_INVALID'					=> 'Valitud kehtetu andmebaasi tüübi nimi.',
	'ERR_DB_LOGIN_FAILURE'				=> 'Pakutud andmebaasi majutus ja/või parool on kehtetud ja ühendust andmebaasiga ei saa kindlustada. Palun sisesta kehtiv hosting, kasutajanimi ja parool.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'Pakutud andmebaasi majutus ja/või parool on kehtetud ja ühendust andmebaasiga ei saa kindlustada. Palun sisesta kehtiv hosting, kasutajanimi ja parool.',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'Pakutud andmebaasi majutus ja/või parool on kehtetud ja ühendust andmebaasiga ei saa kindlustada. Palun sisesta kehtiv hosting, kasutajanimi ja parool.',
	'ERR_DB_MYSQL_VERSION'				=> 'Your MySQL version (%s) is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported MySQL versions.',
	'ERR_DB_NAME'						=> 'Andmebaasi nimi ei saa jääda tühjaks.',
	'ERR_DB_NAME2'						=> "Andmebaasi nimi ei saa sisaldada '\\', '/', või '.'",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "Andmebaasi nimi ei saa sisaldada '\\', '/', või '.'",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "Andmebaasi nimi ei saa sisaldada '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', või '-'",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "Database name can only consist of alphanumeric characters and the symbols '#', '_' or '$'",
	'ERR_DB_PASSWORD'					=> 'Sugari andmebaasi admini jaoks pakutud paroolid ei kattu. Palun sisesta uuesti samad paroolid parooli väljadele.',
	'ERR_DB_PRIV_USER'					=> 'Paku andmebaasi admini kasutaja nimi. Kasutajalt on nõutav esialgne ühendus andmebaasiga.',
	'ERR_DB_USER_EXISTS'				=> 'Sugari andmebaasi kasutaja kasutajanimi juba eksisteerib -- ei saa luua uut samanimelist, Palun sisesta uus kasutajanimi.',
	'ERR_DB_USER'						=> 'Sisesta kasutajanimi Sugari andmebaasi administraatori jaoks.',
	'ERR_DBCONF_VALIDATION'				=> 'Palun korrasta järgnevad vead enne jätkamist:',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'Sugari andmebaasi kasutaja jaoks pakutud paroolid ei kattu. Palun sisesta samad paroolid uuesti parooliväljadele.',
	'ERR_ERROR_GENERAL'					=> 'Avaldusid järgmised vead:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'Ei saa kustutada faili:',
	'ERR_LANG_MISSING_FILE'				=> 'Ei leia faili:',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'Keelepaketti ei leitud:',
	'ERR_LANG_UPLOAD_1'					=> 'Üleslaadimisel ilmnesid vead. Palun proovi uuesti.',
	'ERR_LANG_UPLOAD_2'					=> 'Keelepaketid peavad olema ZIP arhiivis.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP could not move the temp file to the upgrade directory.',
	'ERR_LICENSE_MISSING'				=> 'Puuduvad nõutud väljad',
	'ERR_LICENSE_NOT_FOUND'				=> 'Litsentsi faili ei leitud!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'Pakutud logi kataloog on kehtetu.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'Pakutud logi kataloog ei ole kirjutatav kataloog.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Log directory is required if you wish to specify your own.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'Unable to process script directly.',
	'ERR_NO_SINGLE_QUOTE'				=> 'Ei saa kasutada üksikut komamärki',
	'ERR_PASSWORD_MISMATCH'				=> 'Pakutud paroolid Sugari admin kasutaja joaks ei ühti. Palun taassiesta samad paroolid parooli väljadele.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'Ei saa kirjutada config.php faili.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'You can continue this installation by manually creating the config.php file and pasting the configuration information below into the config.php file. However, you must create the config.php file before you continue to the next step.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'On sul meeles luua config.php fail?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Hoiatus: Ei saa kirjutada config.php faili. Palun kontrolli, kas see eksisteerib.',
	'ERR_PERFORM_HTACCESS_1'			=> 'Ei saa kirjutada',
	'ERR_PERFORM_HTACCESS_2'			=> 'faili.',
	'ERR_PERFORM_HTACCESS_3'			=> 'If you want to secure your log file from being accessible via browser, create an .htaccess file in your log directory with the line:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>We could not detect an Internet connection.</b> When you do have a connection, please visit <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> to register with SuiteCRM. By letting us know a little bit about how your company plans to use SuiteCRM, we can ensure we are always delivering the right application for your business needs.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'Session directory provided is not a valid directory.',
	'ERR_SESSION_DIRECTORY'				=> 'Session directory provided is not a writable directory.',
	'ERR_SESSION_PATH'					=> 'Session path is required if you wish to specify your own.',
	'ERR_SI_NO_CONFIG'					=> 'You did not include config_si.php in the document root, or you did not define $sugar_config_si in config.php',
	'ERR_SITE_GUID'						=> 'Rakenduse ID on nõutav, kui soovid sisestada enda oma',
    'ERROR_SPRITE_SUPPORT'              => "Currently we are not able to locate the GD library, as a result you will not be able to use the CSS Sprite functionality.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Warning: Your PHP configuration should be changed to allow files of at least 6MB to be uploaded.',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Upload File Size',
	'ERR_URL_BLANK'						=> 'Provide the base URL for the SuiteCRM instance.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'Could not locate installation record of',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'The uploaded file is not compatible with this flavor (Community Edition, Professional, or Enterprise) of SuiteCRM: ',
	'ERROR_LICENSE_EXPIRED'				=> "Viga: sinu litsents on aegunud",
	'ERROR_LICENSE_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to enter your new license key.  If you do not enter a new license key within 30 days of your license key expiration, you will no longer be able to log in to this application.",
	'ERROR_MANIFEST_TYPE'				=> 'Manifest file must specify the package type.',
	'ERROR_PACKAGE_TYPE'				=> 'Manifest file specifies an unrecognized package type',
	'ERROR_VALIDATION_EXPIRED'			=> "Viga: Teie valideerimine on aegunud",
	'ERROR_VALIDATION_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a> in the Admin screen to enter your new validation key.  If you do not enter a new validation key within 30 days of your validation key expiration, you will no longer be able to log in to this application.",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'Üleslaetud fail ei ühildu selle Sugari versiooniga:',

	'LBL_BACK'							=> 'Tagasi',
    'LBL_CANCEL'                        => 'Tühista',
    'LBL_ACCEPT'                        => 'Aktsepteerin',
	'LBL_CHECKSYS_1'					=> 'In order for your SuiteCRM installation to function properly, please ensure all of the system check items listed below are green. If any are red, please take the necessary steps to fix them.<BR><BR> For help on these system checks, please visit the <a href="http://www.suitecrm.com" target="_blank">SuiteCRM</a>.',
	'LBL_CHECKSYS_CACHE'				=> 'Writable Cache Sub-Directories',
    'LBL_DROP_DB_CONFIRM'               => 'The provided Database Name already exists.<br>You can either:<br>1.  Click on the Cancel button and choose a new database name, or <br>2.  Click the Accept button and continue.  All existing tables in the database will be dropped. <strong>This means that all of the tables and pre-existing data will be blown away.</strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned Off',
    'LBL_CHECKSYS_COMPONENT'			=> 'Komponent',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Valikulised komponendid',
	'LBL_CHECKSYS_CONFIG'				=> 'Writable SuiteCRM Configuration File (config.php)',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Writable SuiteCRM Configuration File (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'cURL moodul',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Session Save Path Setting',
	'LBL_CHECKSYS_CUSTOM'				=> 'Writeable Custom Directory',
	'LBL_CHECKSYS_DATA'					=> 'Writable Data Sub-Directories',
	'LBL_CHECKSYS_IMAP'					=> 'IMAP moodul',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'MB Strings Module',
	'LBL_CHECKSYS_MEM_OK'				=> 'OK (piiranguta)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'OK (Unlimited)',
	'LBL_CHECKSYS_MEM'					=> 'PHP Memory Limit',
	'LBL_CHECKSYS_MODULE'				=> 'Writable Modules Sub-Directories and Files',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'MySQL Version',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'Pole saadaval',
	'LBL_CHECKSYS_OK'					=> 'Ok',
	'LBL_CHECKSYS_PHP_INI'				=> 'Location of your PHP configuration file (php.ini):',
	'LBL_CHECKSYS_PHP_OK'				=> 'OK (ver',
	'LBL_CHECKSYS_PHPVER'				=> 'PHP versioon',
    'LBL_CHECKSYS_IISVER'               => 'IIS Version',
	'LBL_CHECKSYS_RECHECK'				=> 'Ülekontroll',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP Safe Mode Turned Off',
	'LBL_CHECKSYS_SESSION'				=> 'Writable Session Save Path (',
	'LBL_CHECKSYS_STATUS'				=> 'Olek',
	'LBL_CHECKSYS_TITLE'				=> 'System Check Acceptance',
	'LBL_CHECKSYS_VER'					=> 'Leitud: ( ver',
	'LBL_CHECKSYS_XML'					=> 'XML Parsing',
	'LBL_CHECKSYS_ZLIB'					=> 'ZLIB Compression Module',
	'LBL_CHECKSYS_ZIP'					=> 'ZIP Handling Module',
	'LBL_CHECKSYS_PCRE'					=> 'PCRE Library',
	'LBL_CHECKSYS_FIX_FILES'            => 'Palun korrasta järgnevad failid või kataloogid enne jätkamist:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Palun korrasta järgnevad mooduli kataloogid ja nende all olevad failid enne jätkamist:',
    'LBL_CHECKSYS_UPLOAD'               => 'Writable Upload Directory',
    'LBL_CLOSE'							=> 'Sulge',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'on loodud',
	'LBL_CONFIRM_DB_TYPE'				=> 'Andmebaasi tüüp',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Palun kinnita allolevad sätted. Kui soovid mõnda väärtust muuta kliki redigeerimseks "Tagasi". Kliki "Edasi" installimise alustamiseks.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Litsentsi info',
	'LBL_CONFIRM_NOT'					=> 'not',
	'LBL_CONFIRM_TITLE'					=> 'Kinnita sätted',
	'LBL_CONFIRM_WILL'					=> 'will',
	'LBL_DBCONF_CREATE_DB'				=> 'Loo andmebaas',
	'LBL_DBCONF_CREATE_USER'			=> 'Loo kasutaja',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Caution: All SuiteCRM data will be erased<br>if this box is checked.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Drop and Recreate Existing SuiteCRM tables?',
    'LBL_DBCONF_DB_DROP'                => 'Aseta tabelid',
    'LBL_DBCONF_DB_NAME'				=> 'Andmebaasi nimi',
	'LBL_DBCONF_DB_PASSWORD'			=> 'Sugari andmebaasi kasutajaparool',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Sisesta uuesti Sugari andmebaasi kasutajaparool',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM Database User',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM Database User',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Andmebaasi administraatori kasutajanimi',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Andmebaasi admini parool',
	'LBL_DBCONF_DEMO_DATA'				=> 'Populate Database with Demo Data?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Choose Demo Data',
	'LBL_DBCONF_HOST_NAME'				=> 'Hosti nimi',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Host Instance',
	'LBL_DBCONF_HOST_PORT'				=> 'Port',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Palun sisesta alljärgnevalt oma andmebaasi konfiguratsiooni info. Kui sa pole kindel, mida täita, siis soovitame kasutada vaikeväärtuseid.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Use multi-byte text in demo data?',
    'LBL_DBCONFIG_MSG2'                 => 'Name of web server or machine (host) on which the database is located ( such as localhost or www.mydomain.com ):',
	'LBL_DBCONFIG_MSG2_LABEL' => 'Hosti nimi',
    'LBL_DBCONFIG_MSG3'                 => 'Name of the database that will contain the data for the SuiteCRM instance you are about to install:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'Andmebaasi nimi',
    'LBL_DBCONFIG_B_MSG1'               => 'The username and password of a database administrator who can create database tables and users and who can write to the database is necessary in order to set up the SuiteCRM database.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
    'LBL_DBCONFIG_SECURITY'             => 'For security purposes, you can specify an exclusive database user to connect to the Sugar database. This user must be able to write, update and retrieve data on the Sugar database that will be created for this instance. This user can be the database administrator specified above, or you can provide new or existing database user information.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Do it for me',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Paku olemasolevat kasutajat',
    'LBL_DBCONFIG_CREATE_DD'            => 'Määratle kasutaja loomiseks',
    'LBL_DBCONFIG_SAME_DD'              => 'Sama kui adminkasutaja',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'Full Text Search',
    'LBL_FTS_INSTALLED'                 => 'installitud',
    'LBL_FTS_INSTALLED_ERR1'            => 'Full Text Search capability is not installed.',
    'LBL_FTS_INSTALLED_ERR2'            => 'You can still install but will not be able to use Full Text Search functionality.  Please refer to your database server install guide on how to do this, or contact your Administrator.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Privileged Database User Password',
	'LBL_DBCONF_PRIV_USER_2'			=> 'Database Account Above Is a Privileged User?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'This privileged database user must have the proper permissions to create a database, drop/create tables, and create a user.  This privileged database user will only be used to perform these tasks as needed during the installation process.  You may also use the same database user as above if that user has sufficient privileges.',
	'LBL_DBCONF_PRIV_USER'				=> 'Privileged Database User Name',
	'LBL_DBCONF_TITLE'					=> 'Andmebaasi konfiguratsioon',
    'LBL_DBCONF_TITLE_NAME'             => 'Paku andmebaasi nimi',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Paku andmebaasi kasutaja infot',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'Kasutaja',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'Parool',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'After this change has been made, you may click the "Start" button below to begin your installation.  <i>After the installation is complete, you will want to change the value for \'installer_locked\' to \'true\'.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'The installer has already been run once.  As a safety measure, it has been disabled from running a second time.  If you are absolutely sure you want to run it again, please go to your config.php file and locate (or add) a variable called \'installer_locked\' and set it to \'false\'.  The line should look like this:',
	'LBL_DISABLED_HELP_1'				=> 'Installi abi vajaduse korral mine SugarCRM-i.',
    'LBL_DISABLED_HELP_LNK'             => 'http://www.suitecrm.com/forum/index',
	'LBL_DISABLED_HELP_2'				=> 'toe foorumid',
	'LBL_DISABLED_TITLE_2'				=> 'SuiteCRM Installation has been Disabled',
	'LBL_DISABLED_TITLE'				=> 'SuiteCRM Installation Disabled',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Character Set most commonly used in your locale',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Väljamineva e-posti sätted',
    'LBL_EMAIL_CHARSET_CONF'            => 'Character Set for Outbound Email ',
	'LBL_HELP'							=> 'Abi',
    'LBL_INSTALL'                       => 'Installi',
    'LBL_INSTALL_TYPE_TITLE'            => 'Installimissuvandid',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Vali installi tüüp',
    'LBL_INSTALL_TYPE_TYPICAL'          => 'Tüüpiline installimine',
    'LBL_INSTALL_TYPE_CUSTOM'           => 'Custom Install',
    'LBL_INSTALL_TYPE_MSG1'             => 'The key is required for general application functionality, but it is not required for installation. You do not need to enter the key at this time, but you will need to provide the key after you have installed the application.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Requires minimum information for the installation. Recommended for new users.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Provides additional options to set during the installation. Most of these options are also available after installation in the admin screens. Recommended for advanced users.',
	'LBL_LANG_1'						=> 'To use a language in SuiteCRM other than the default language (US-English), you can upload and install the language pack at this time. You will be able to upload and install language packs from within the SuiteCRM application as well.  If you would like to skip this step, click Next.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Installi',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Eemalda',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Deinstalli',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Lae üles',
	'LBL_LANG_NO_PACKS'					=> 'ühtegi',
	'LBL_LANG_PACK_INSTALLED'			=> 'Järgnevad keelepaketid on installitud:',
	'LBL_LANG_PACK_READY'				=> 'Järgnevad keelepaketid on valmis installimiseks:',
	'LBL_LANG_SUCCESS'					=> 'Keelepakett installiti edukalt.',
	'LBL_LANG_TITLE'			   		=> 'Keelepakett',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Sugari installimine. See võib võtta aega mõned minutid.',
	'LBL_LANG_UPLOAD'					=> 'Lae üles keelepakett',
	'LBL_LICENSE_ACCEPTANCE'			=> 'License Acceptance',
    'LBL_LICENSE_CHECKING'              => 'Checking system for compatibility.',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Keskkonna kontrollimine',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Verifying DB Credentials.',
    'LBL_LICENSE_CHECK_PASSED'          => 'System passed check for compatibility.',
	'LBL_CREATE_CACHE' => 'Preparing to Install...',
    'LBL_LICENSE_REDIRECT'              => 'Suunamine',
	'LBL_LICENSE_DIRECTIONS'			=> 'Kui sul on litsentsiinfot, siis palun sisesta see allolevatele väljadele.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Enter Download Key',
	'LBL_LICENSE_EXPIRY'				=> 'Aegumiskuupäev',
	'LBL_LICENSE_I_ACCEPT'				=> 'Aktsepteerin',
	'LBL_LICENSE_NUM_USERS'				=> 'Kasutajate arv',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Please enter the number of purchased offline clients.',
	'LBL_LICENSE_OC_NUM'				=> 'Offline klientide arv',
	'LBL_LICENSE_OC'					=> 'Offline kliendi litsentsid',
	'LBL_LICENSE_PRINTABLE'				=> 'Printvaade',
    'LBL_PRINT_SUMM'                    => 'Print kokkuvõte',
	'LBL_LICENSE_TITLE_2'				=> 'SugarCRM Litsents',
	'LBL_LICENSE_TITLE'					=> 'Litsentsi info',
	'LBL_LICENSE_USERS'					=> 'Litsentsitud kasutajad',

	'LBL_LOCALE_CURRENCY'				=> 'Valuuta sätted',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Vaike valuuta',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Valuuta sümbol',
	'LBL_LOCALE_CURR_ISO'				=> 'Valuuta kood (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> '1000 eraldaja',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Kümnendiku eraldaja',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Näide',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Significant Digits',
	'LBL_LOCALE_DATEF'					=> 'Default Date Format',
	'LBL_LOCALE_DESC'					=> 'The specified locale settings will be reflected globally within the SuiteCRM instance.',
	'LBL_LOCALE_EXPORT'					=> 'Impordi/ekspordi jaoks sätestatud sümbol<br />(Email, .csv, vCard, PDF, andmeimport)',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Export (.csv) Delimiter',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Impordi/ekspordi sätted',
	'LBL_LOCALE_LANG'					=> 'Default Language',
	'LBL_LOCALE_NAMEF'					=> 'Default Name Format',
	'LBL_LOCALE_NAMEF_DESC'				=> 's = salutation<br />f = first name<br />l = last name',
	'LBL_LOCALE_NAME_FIRST'				=> 'David',
	'LBL_LOCALE_NAME_LAST'				=> 'Livingstone',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Dr.',
	'LBL_LOCALE_TIMEF'					=> 'Default Time Format',

    'LBL_CUSTOMIZE_LOCALE'              => 'Customize Locale Settings',
	'LBL_LOCALE_UI'						=> 'Kasutajaliides',

	'LBL_ML_ACTION'						=> 'Tegevus',
	'LBL_ML_DESCRIPTION'				=> 'Kirjeldus',
	'LBL_ML_INSTALLED'					=> 'Installi kuupäev',
	'LBL_ML_NAME'						=> 'Nimi',
	'LBL_ML_PUBLISHED'					=> 'Avaldamiskuupäev',
	'LBL_ML_TYPE'						=> 'Tüüp',
	'LBL_ML_UNINSTALLABLE'				=> 'Mitteinstallitav',
	'LBL_ML_VERSION'					=> 'Versioon',
	'LBL_MSSQL'							=> 'SQL Server',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver for PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (mysqli extension)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Järgmine',
	'LBL_NO'							=> 'Ei',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Saidi admini parooli seadistamine',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'audit table /',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Sugari konfiguratsioonifaili loomine',
	'LBL_PERFORM_CREATE_DB_1'			=> 'Andmebaasi loomine',
	'LBL_PERFORM_CREATE_DB_2'			=> 'on',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Andmebaasi kasutajanime ja parooli loomine',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Creating default SuiteCRM data',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Creating the Database username and password for localhost..',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Creating SuiteCRM relationship tables',
	'LBL_PERFORM_CREATING'				=> 'loomine /',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Vaikearuannete loomine',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Creating default scheduler jobs',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Vaikesätete sisestamine',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Vaikekasutajate loomine',
	'LBL_PERFORM_DEMO_DATA'				=> 'Populating the database tables with demo data (this may take a little while)',
	'LBL_PERFORM_DONE'					=> 'tehtud',
	'LBL_PERFORM_DROPPING'				=> 'asetamine /',
	'LBL_PERFORM_FINISH'				=> 'Lõpeta',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Litsentsiinfo uuendamine',
	'LBL_PERFORM_OUTRO_1'				=> 'Sugari seadistamine',
	'LBL_PERFORM_OUTRO_2'				=> 'on lõpetatud!',
	'LBL_PERFORM_OUTRO_3'				=> 'Aeg kokku:',
	'LBL_PERFORM_OUTRO_4'				=> 'sekundit.',
	'LBL_PERFORM_OUTRO_5'				=> 'Hinnanguline mälukasutus:',
	'LBL_PERFORM_OUTRO_6'				=> 'baite.',
	'LBL_PERFORM_OUTRO_7'				=> 'Sinu süsteem on nüüd installitud ja konfigureeritud kasutamiseks.',
	'LBL_PERFORM_REL_META'				=> 'relationship meta ...',
	'LBL_PERFORM_SUCCESS'				=> 'Läks korda!',
	'LBL_PERFORM_TABLES'				=> 'Sugari rakenduse tabelite, audititabelite ja seoste metaandmete loomine',
	'LBL_PERFORM_TITLE'					=> 'Perform Setup',
	'LBL_PRINT'							=> 'Prindi',
	'LBL_REG_CONF_1'					=> 'Please complete the short form below to receive product announcements, training news, special offers and special event invitations from SuiteCRM. We do not sell, rent, share or otherwise distribute the information collected here to third parties.',
	'LBL_REG_CONF_2'					=> 'Your name and email address are the only required fields for registration. All other fields are optional, but very helpful. We do not sell, rent, share, or otherwise distribute the information collected here to third parties.',
	'LBL_REG_CONF_3'					=> 'Thank you for registering. Click on the Finish button to login to SuiteCRM. You will need to log in for the first time using the username "admin" and the password you entered in step 2.',
	'LBL_REG_TITLE'						=> 'Registreerimine',
    'LBL_REG_NO_THANKS'                 => 'Tänan ei',
    'LBL_REG_SKIP_THIS_STEP'            => 'Jäta see samm vahele',
	'LBL_REQUIRED'						=> '* Kohustuslik väli',

    'LBL_SITECFG_ADMIN_Name'            => 'Sugari rakenduse admini nimi',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Sisesta Sugari admini kasutaja parool uuesti',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Caution: This will override the admin password of any previous installation.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'SuiteCRM Admin User Password',
	'LBL_SITECFG_APP_ID'				=> 'Rakenduse ID',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'If selected, you must provide an application ID to override the auto-generated ID. The ID ensures that sessions of one SuiteCRM instance are not used by other instances.  If you have a cluster of SuiteCRM installations, they all must share the same application ID.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Paku enda rakenduse ID',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'If selected, you must specify a log directory to override the default directory for the SuiteCRM log. Regardless of where the log file is located, access to it through a web browser will be restricted via an .htaccess redirect.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Use a Custom Log Directory',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'If selected, you must provide a secure folder for storing SuiteCRM session information. This can be done to prevent session data from being vulnerable on shared servers.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Use a Custom Session Directory for SuiteCRM',
	'LBL_SITECFG_DIRECTIONS'			=> 'Please enter your site configuration information below. If you are unsure of the fields, we suggest that you use the default values.',
	'LBL_SITECFG_FIX_ERRORS'			=> 'Palun paranda järgnevad vead enne jätkamist:',
	'LBL_SITECFG_LOG_DIR'				=> 'Logi kataloog',
	'LBL_SITECFG_SESSION_PATH'			=> 'Path to Session Directory<br>(must be writable)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Vali turvasuvandid',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'If selected, the system will periodically check for updated versions of the application.',
	'LBL_SITECFG_SUGAR_UP'				=> 'Automatically Check For Updates?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'SuiteCRM Updates Config',
	'LBL_SITECFG_TITLE'					=> 'Saidi konfiguratsioon',
    'LBL_SITECFG_TITLE2'                => 'Identify Administration User',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Saidi turvalisus',
	'LBL_SITECFG_URL'					=> 'URL of SuiteCRM Instance',
	'LBL_SITECFG_USE_DEFAULTS'			=> 'Kasuta vaikeväärtuseid?',
	'LBL_SITECFG_ANONSTATS'             => 'Send Anonymous Usage Statistics?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'If selected, SuiteCRM will send <b>anonymous</b> statistics about your installation to SuiteCRM Inc. every time your system checks for new versions. This information will help us better understand how the application is used and guide improvements to the product.',
    'LBL_SITECFG_URL_MSG'               => 'Enter the URL that will be used to access the SuiteCRM instance after installation. The URL will also be used as a base for the URLs in the SuiteCRM application pages. The URL should include the web server or machine name or IP address.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Enter a name for your system.  This name will be displayed in the browser title bar when users visit the SuiteCRM application.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'After installation, you will need to use the SuiteCRM admin user (default username = admin) to log in to the SuiteCRM instance.  Enter a password for this administrator user. This password can be changed after the initial login.  You may also enter another admin username to use besides the default value provided.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Select collation (sorting) settings for your system. This settings will create the tables with the specific language you use. In case your language doesn\'t require special settings please use default value.',
    'LBL_SPRITE_SUPPORT'                => 'Sprite Support',
	'LBL_SYSTEM_CREDS'                  => 'System Credentials',
    'LBL_SYSTEM_ENV'                    => 'System Environment',
	'LBL_START'							=> 'Alusta',
    'LBL_SHOW_PASS'                     => 'Näita paroole',
    'LBL_HIDE_PASS'                     => 'Peida paroolid',
    'LBL_HIDDEN'                        => '(peidetud)',
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
	'LBL_CHOOSE_LANG'					=> 'Vali oma keel',
	'LBL_STEP'							=> 'Samm',
	'LBL_TITLE_WELCOME'					=> 'Tere tulemast Sugar CRM-i',
	'LBL_WELCOME_1'						=> 'This installer creates the SuiteCRM database tables and sets the configuration variables that you need to start. The entire process should take about ten minutes.',
	'LBL_WELCOME_2'						=> 'For installation documentation, please visit the <a href="http://www.SuiteCRM.com/" target="_blank">SuiteCRM</a>.  <BR><BR> You can also find help from the SuiteCRM Community in the <a href="http://www.SuiteCRM.com/" target="_blank">SuiteCRM Forums</a>.',
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

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> 'Vali oma keel',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Seadista viisard',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Tere tulemast SugarCRM-i',
	'LBL_WELCOME_TITLE'					=> 'SugarCRM seadistuse viisard',
	'LBL_WIZARD_TITLE'					=> 'Sugar seadistuse viisard',
	'LBL_YES'							=> 'Jah',
    'LBL_YES_MULTI'                     => 'Yes - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Töötle töövoo ülesandeid',
	'LBL_OOTB_REPORTS'		=> 'Run Report Generation Scheduled Tasks',
	'LBL_OOTB_IE'			=> 'Kontrolli sissetulevaid postkaste',
	'LBL_OOTB_BOUNCE'		=> 'Run Nightly Process Bounced Campaign Emails',
    'LBL_OOTB_CAMPAIGN'		=> 'Run Nightly Mass Email Campaigns',
	'LBL_OOTB_PRUNE'		=> 'Prune Database on 1st of Month',
    'LBL_OOTB_TRACKER'		=> 'Prune tracker tables',
    'LBL_OOTB_SUGARFEEDS'   => 'Prune SuiteCRM Feed Tables',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Run Email Reminder Notifications',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Uuenda tracker_sessions tabelit',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Clean Jobs Queue',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Removal of documents from filesystem',


    'LBL_PATCHES_TITLE'     => 'Install Latest Patches',
    'LBL_MODULE_TITLE'      => 'Installi keelepaketid',
    'LBL_PATCH_1'           => 'Kui soovid selle sammu vahele jätta, siis kliki Edasi',
    'LBL_PATCH_TITLE'       => 'System Patch',
    'LBL_PATCH_READY'       => 'The following patch(es) are ready to be installed:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM relies upon PHP sessions to store important information while connected to this web server.  Your PHP installation does not have the Session information correctly configured.
											<br><br>A common misconfiguration is that the <b>'session.save_path'</b> directive is not pointing to a valid directory.  <br>
											<br> Please correct your <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>PHP configuration</a> in the php.ini file located here below.",
	'LBL_SESSION_ERR_TITLE'				=> 'PHP sessiooni konfiguratsiooni viga',
	'LBL_SYSTEM_NAME'=>'Süsteemi nimi',
    'LBL_COLLATION' => 'Collation Settings',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Paku süsteeminimi Sugari jaoks.',
	'LBL_PATCH_UPLOAD' => 'Select a patch file from your local computer',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Nõutav php versioon 5 või enam.',
	'LBL_MINIMUM_PHP_VERSION' => 'Minimaalne nõutav Php versioon on 5.1.0. Soovitav Php versioon on 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(Sinu praegune php versioon on',
	'LBL_RECOMMENDED_PHP_VERSION' =>'Soovitatav php versioon on 5.2.x)',
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
	'LBL_CHOOSE_EMAIL_PROVIDER'        => 'Vali oma e-posti teenusepakkuja:',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! Mail',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => 'Teine',
	'LBL_MAIL_SMTP_SETTINGS'           => 'SMTP Server Specification',
	'LBL_MAIL_SMTPSERVER'				=> 'SMTP Server:',
	'LBL_MAIL_SMTPPORT'					=> 'SMTP Port:',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'Kasutada SMTP autentimist?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => 'Luba SMTP üle SSL või TLS-i?',
	'LBL_GMAIL_SMTPUSER'					=> 'Gmaili e-posti aadress:',
	'LBL_GMAIL_SMTPPASS'					=> 'Gmaili salasõna:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => 'Luba kasutajatel seda kontot kasutada väljaminevate e-kirjade jaoks:',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => 'When this option is selected, all users will be able to send emails using the same outgoing mail account used to send system notifications and alerts.  If the option is not selected, users can still use the outgoing mail server after providing their own account information.',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Yahoo! Mail Password',
	'LBL_YAHOOMAIL_SMTPUSER'					=> 'Yahoo! Mail ID',

	'LBL_EXCHANGE_SMTPPASS'					=> 'Exchange parool:',
	'LBL_EXCHANGE_SMTPUSER'					=> 'Exchange kasutajanimi:',
	'LBL_EXCHANGE_SMTPPORT'					=> 'Exchange Server Port:',
	'LBL_EXCHANGE_SMTPSERVER'				=> 'Exchange Server:',


	'LBL_MAIL_SMTPUSER'					=> 'SMTP kasutajanimi:',
	'LBL_MAIL_SMTPPASS'					=> 'SMTP salasõna:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Branding',
	'LBL_WIZARD_SYSTEM_DESC' => 'Provide your organization\'s name and logo in order to brand your SuiteCRM.',
	'SYSTEM_NAME_WIZARD'=>'Nimi',
	'SYSTEM_NAME_HELP'=>'See on nimi, mis kuvatakse sinu brauseri tiitelribal.',
	'NEW_LOGO'=>'Vali logo:',
	'NEW_LOGO_HELP'=>'Pildiformaat saab olla kas .png või .jpg.<br />Soovitatav suurus on 212x40 px.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'Lae üles',
	'CURRENT_LOGO'=>'Praegune logo:',
    'CURRENT_LOGO_HELP'=>'Seda logo kuvatakse Sugari rakenduse ülal vasakpoolses nurgas.',

	// System Local Settings


	'LBL_LOCALE_TITLE' => 'System Locale Settings',
	'LBL_WIZARD_LOCALE_DESC' => 'Specify how you would like data in SuiteCRM to be displayed, based on your geographical location. The settings you provide here will be the default settings. Users will be able set their own preferences.',
	'LBL_DATE_FORMAT' => 'Tarih Formatı:',
	'LBL_TIME_FORMAT' => 'Saat Formatı:',
		'LBL_TIMEZONE' => 'Saat Dilimi:',
	'LBL_LANGUAGE'=>'Keel:',
	'LBL_CURRENCY'=>'Para Birimi',
	'LBL_CURRENCY_SYMBOL'=>'Currency Symbol:',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 Currency Code:',
	'LBL_NUMBER_GROUPING_SEP' => '1000\'ler ayıracı',
	'LBL_DECIMAL_SEP' => 'Ondalık Sembolü',
	'LBL_NAME_FORMAT' => 'Name Format:',
	'UPLOAD_LOGO' => 'Please wait, logo uploading..',
	'ERR_UPLOAD_FILETYPE' => 'File type do not allowed, please upload a jpeg or png.',
	'ERR_LANG_UPLOAD_UNKNOWN' => 'Unknown file upload error occured.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => 'The uploaded file was only partially uploaded.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => 'No file was uploaded.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => 'Missing a temporary folder.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => 'Failed to write file to disk.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.',

	'LBL_INSTALL_PROCESS' => 'Install...',

	'LBL_EMAIL_ADDRESS' => 'E-post:',
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
	'LBL_START' => 'Alusta',


);

?>
