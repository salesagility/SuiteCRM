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
	'LBL_BASIC_SEARCH'					=> 'Základní hledání',
	'LBL_ADVANCED_SEARCH'				=> 'Rozšířené hledání',
	'LBL_BASIC_TYPE'					=> 'Základní typ',
	'LBL_ADVANCED_TYPE'					=> 'Rozšířený typ',
	'LBL_SYSOPTS_1'						=> 'Zvolte z následujících konfikuračních nastavení.',
    'LBL_SYSOPTS_2'                     => 'Jaký typ databáze bude použit pro Sugar instanci, kterou chcete instalovat?',
	'LBL_SYSOPTS_CONFIG'				=> 'Systémová konfigurace',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Určete typ databáze',
    'LBL_SYSOPTS_DB_TITLE'              => 'Typ databáze',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Opravte prosím následující chyby dříve než budete pokračovat.',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Zajistěte práva k zápisu do tohoto adresáře:',
    'ERR_DB_VERSION_FAILURE'			=> 'Nepodařilo se zjistit verzi databáze',
	'DEFAULT_CHARSET'					=> 'UTF-8',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Zadejte uživatelské jméno pro SuiteCRM administrátora.',
	'ERR_ADMIN_PASS_BLANK'				=> 'Vložte heslo pro administrátora Sugaru ',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'Během kontroly kompatibility byly detekovány chyby. Aby Vaše SugarCRM instalace fungovala korektně, proveďte, prosím, kroky potřebné k odstranění problémů a buď stiskněte tlačítko Opakuj kontrolu nebo zkuste opakovat instalaci.',
    'ERR_CHECKSYS_CALL_TIME'            => 'Call Time PassReference je vypnuta (aktivujte v php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'Nenalezeno: Sugar plánovač poběží s omezenou funkcionalitou.',
    'ERR_CHECKSYS_IMAP'					=> 'Nenalezeno: Příchozí emaily a emailové kampaně vyžadují IMAP knihovny. Ani  jedno nebude funkční. ',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magické uvozovky nelze aktivovat při použití MS SQL Serveru.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Varování: ',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> 'Varování: $memory_linit (Je nastaven na ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M nebo vyšší ve vašem php.ini souboru.)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Minimálně verze 4.1.2 - Nalezena: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Chyba zápisu a čtení proměnných relace. Nelze pokračovat v instalaci.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'Nejedná se o platný adresář',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Varování: Nelze zapisovat',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Vaše verze PHP neni Sugarem podporována. Budete muset instalovat verzi, která je kompatibilní se Sugarem. Zkontrolujte, prosím, podporované PHP verze v tabulce kompatibility v Release Notes. Vaše verze je  ',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'Vaše verze IIS není podporována. Pro pokračování je nutné nainstalovat verzi IIS, která je podporována aplikací SuiteCRM. Seznam podporovaných verzí IIS najdete v Compatibility Matrix v Release Notes. Vaše verze je',
	'ERR_CHECKSYS_FASTCGI'              => 'Zjistili jsme, že nepoužíváte FastCGI handler pro mapování na PHP. Musíte nainstalovat/nakonfigurovat verzi, která je kompatibilní s aplikací SuiteCRM. Seznam podporovaných verzí najdete v Compatibility Matrix v Release Notes. Více detailů najdete na <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a>.',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Pro optimální běh pod IIS/FastCGI sapi, nastavte v souboru php.ini hodnotu fastcgi.logging na 0.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Nainstalována nepodporovaná PHP verze: (verze',
    'LBL_DB_UNAVAILABLE'                => 'Databáze není dostupná',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'Databáze nenalezena. Ujistěte se, že používáte nějakou z těchto podporovaných verzí: MySQL nebo MS SQLServer. Možná bude nutné odstranit komentář pro příslušné rozšíření v souboru php.ini, nebo rekompilovat správný binární soubor v závislosti na verzi Vašeho PHP. Jak aktivovat podporu databáze najdete v manuálu k PHP.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'Funkci asociovanou s XML Parser knihovnou, která je nutná pro běh aplikace SuiteCRM aplikace, se nepodařilo najít. Možná bude nutné odstranit komentář pro příslušné rozšíření v souboru php.ini, nebo rekompilovat správný binární soubor v závislosti na verzi Vašeho PHP. Více informací naleznete v PHP manuálu.',
    'ERR_CHECKSYS_MBSTRING'             => 'Functions associated with the Multibyte Strings PHP extension (mbstring) that are needed by the SuiteCRM application were not found. <br/><br/>Generally, the mbstring module is not enabled by default in PHP and must be activated with --enable-mbstring when the PHP binary is built. Please refer to your PHP Manual for more information on how to enable mbstring support.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'The session.save_path setting in your php configuration file (php.ini) is not set or is set to a folder which did not exist. You might need to set the save_path setting in php.ini or verify that the folder sets in save_path exist.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'The session.save_path setting in your php configuration file (php.ini) is set to a folder which is not writeable.  Please take the necessary steps to make the folder writeable.  <br>Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'The config file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'The config override file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'The Custom Directory exists but is not writeable.  You may have to change permissions on it (chmod 766) or right click on it and uncheck the read only option, depending on your Operating System.  Please take the needed steps to make the file writeable.',
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "The files or directories listed below are not writeable or are missing and cannot be created.  Depending on your Operating System, correcting this may require you to change permissions on the files or parent directory (chmod 755), or to right click on the parent directory and uncheck the 'read only' option and apply it to all subfolders.",
    'LBL_CHECKSYS_OVERRIDE_CONFIG' => 'Config override',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode nastaven (zakažte prosím v php.ini)',
    'ERR_CHECKSYS_ZLIB'					=> 'Nenalezeno: SugarCRM ',
    'ERR_CHECKSYS_ZIP'					=> 'ZIP support not found: SuiteCRM needs ZIP support in order to process compressed files.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE library not found: SuiteCRM needs PCRE library in order to process Perl style of regular expression pattern matching.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE library version: SuiteCRM needs PCRE library 7.0 or above to process Perl style of regular expression pattern matching.',
	'ERR_DB_ADMIN'						=> 'The provided database administrator username and/or password is invalid, and a connection to the database could not be established.  Please enter a valid user name and password.  (Error: ',
    'ERR_DB_ADMIN_MSSQL'                => 'The provided database administrator username and/or password is invalid, and a connection to the database could not be established.  Please enter a valid user name and password.',
	'ERR_DB_EXISTS_NOT'					=> 'Zvolená databáze neexistuje.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'Databáze s konfiguračními daty již existuje .   Pro běh a instalaci  s danou databází, prosím zopakujte instalaci a  zvolte: &#034;Smazat a obnovit existující SugarCRM tabulky?&#034;   Pro aktualizaci, využijte aktualizačního průvodce v administrativní konzole.   Přečtěte si, prosím, aktualizační dokumentaci < href=&#034;http://www.sugarforge.org/content/downloads&#034; target=&#034;_new&#034;>zde</a>. ',
	'ERR_DB_EXISTS'						=> 'Zvolené databázové jméno již existuje -- nelze vytvořit další se stejným jménem.',
    'ERR_DB_EXISTS_PROCEED'             => 'The provided Database Name already exists.  You can<br>1.  hit the back button and choose a new database name <br>2.  click next and continue but all existing tables on this database will be dropped.  <strong>This means your tables and data will be blown away.</strong>',
	'ERR_DB_HOSTNAME'					=> 'Host name nemůže být prázdné.',
	'ERR_DB_INVALID'					=> 'Zvolen nesprávný typ databáze.',
	'ERR_DB_LOGIN_FAILURE'				=> 'The provided database host, username, and/or password is invalid, and a connection to the database could not be established.  Please enter a valid host, username and password',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'The provided database host, username, and/or password is invalid, and a connection to the database could not be established.  Please enter a valid host, username and password',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'The provided database host, username, and/or password is invalid, and a connection to the database could not be established.  Please enter a valid host, username and password',
	'ERR_DB_MYSQL_VERSION'				=> 'Your MySQL version (%s) is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported MySQL versions.',
	'ERR_DB_NAME'						=> 'Jméno databáze nemůže být prázdné.',
	'ERR_DB_NAME2'						=> "Jméno databáze nemůže obsahovat &#039;",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "Jméno databáze nemůže obsahovat &#039;",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "Database name cannot begin with a number, '#', or '@' and cannot contain a space, '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', '&', '!', or '-'",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "Database name can only consist of alphanumeric characters and the symbols '#', '_' or '$'",
	'ERR_DB_PASSWORD'					=> 'The passwords provided for the SuiteCRM database administrator do not match.  Please re-enter the same passwords in the password fields.',
	'ERR_DB_PRIV_USER'					=> 'Provide a database administrator user name.  The user is required for the initial connection to the database.',
	'ERR_DB_USER_EXISTS'				=> 'User name for SuiteCRM database user already exists -- cannot create another one with the same name. Please enter a new user name.',
	'ERR_DB_USER'						=> 'Vložte uživatelské jméno databázového administrátora',
	'ERR_DBCONF_VALIDATION'				=> 'Opravte prosím následující chyby dříve než budete pokračovat.',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'The passwords provided for the SuiteCRM database user do not match. Please re-enter the same passwords in the password fields.',
	'ERR_ERROR_GENERAL'					=> 'Následující chyby nalezeny.',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'Soubor nelze smazat: ',
	'ERR_LANG_MISSING_FILE'				=> 'Soubor nenalezen: ',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'Žádný jazykový balíček nebyl nalezen v include/language',
	'ERR_LANG_UPLOAD_1'					=> 'Během nahrávání souboru se vyskytl problém. Zkuste, prosím, znovu.',
	'ERR_LANG_UPLOAD_2'					=> 'Jazykové balíčky musí být v zip archívech.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP nemohlo přemístit dočasný soubor do aktualizačního adresáře.',
	'ERR_LICENSE_MISSING'				=> 'Chybí povinné položky',
	'ERR_LICENSE_NOT_FOUND'				=> 'Licenční soubor nenalezen!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'Název log adresáře není platný.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'Do log adresáře nelze zapisovat.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Název log adresáře je povinný pokud chcete zvolit vlastní.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'Skript nelze provézt přímo.',
	'ERR_NO_SINGLE_QUOTE'				=> 'Nelze použít jednoduchý apostrof pro ',
	'ERR_PASSWORD_MISMATCH'				=> 'The passwords provided for the SuiteCRM admin user do not match.  Please re-enter the same passwords in the password fields.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'Nelze zapisovat do souboru <span class=stop>config.php</span>.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'V instalaci můžete pokračovat tím, že ručně vytvoříte config.php soubor a vložíte konfigurační informace uvedené níže do config.php souboru.   Nicméně, <bold>musíte </bold> vytvořit config.php soubor předtím než přejdete k další kroku.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'Vytvořil jste soubor config.php?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Varování: Do souboru config.php nelze zapisovat. Ujistěte se, prosím, že existuje.',
	'ERR_PERFORM_HTACCESS_1'			=> 'Nelze zapisovat do souboru ',
	'ERR_PERFORM_HTACCESS_2'			=> 'soubor.',
	'ERR_PERFORM_HTACCESS_3'			=> 'Pokud chcete zabezpečit váš log soubor před přístupností přes prohlížeč, vytvořte .htaccess soubor ve vašem log adresáři s řádkem:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>We could not detect an Internet connection.</b> When you do have a connection, please visit <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> to register with SuiteCRM. By letting us know a little bit about how your company plans to use SuiteCRM, we can ensure we are always delivering the right application for your business needs.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'Poskytnutý session adresář není platným adresářem.',
	'ERR_SESSION_DIRECTORY'				=> 'Poskytnutý session adresář není zapisovatelný.',
	'ERR_SESSION_PATH'					=> 'Session cesta  je povinná pokud chcete zvolit vlastní.',
	'ERR_SI_NO_CONFIG'					=> 'Nevložil jste config_si.php do kořene dokumentu nebo jste nedefinoval $sugar_config_si v config.php',
	'ERR_SITE_GUID'						=> 'ID aplikace je povinné pokud chcete zvolit vlastní.',
    'ERROR_SPRITE_SUPPORT'              => "Currently we are not able to locate the GD library, as a result you will not be able to use the CSS Sprite functionality.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Varování: Vaše konfigurace PHP by měla být změněna tak , aby bylo možno nahrát soubory o velikosti alespoň 6MB.',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Velikost pro nahrávání',
	'ERR_URL_BLANK'						=> 'Zvolte základní URL pro Sugar instanci',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'Nelze nalézt instalační záznam od',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'Nahraný soubor není kompatibilní s edicí Sugaru (Community Edition, Professional, or Enterprise): ',
	'ERROR_LICENSE_EXPIRED'				=> "Chyba: Vaše licence vypršela",
	'ERROR_LICENSE_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to enter your new license key.  If you do not enter a new license key within 30 days of your license key expiration, you will no longer be able to log in to this application.",
	'ERROR_MANIFEST_TYPE'				=> 'Manifest soubor musí být specifikován v souboru',
	'ERROR_PACKAGE_TYPE'				=> 'Manifest soubor specifikuje neznámý typ balíčku',
	'ERROR_VALIDATION_EXPIRED'			=> "Error: Your validation key expired",
	'ERROR_VALIDATION_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a> in the Admin screen to enter your new validation key.  If you do not enter a new validation key within 30 days of your validation key expiration, you will no longer be able to log in to this application.",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'Nahraný soubor není kompatibilní s verzí Sugaru: ',

	'LBL_BACK'							=> 'Zpět',
    'LBL_CANCEL'                        => 'Zrušit',
    'LBL_ACCEPT'                        => 'Přijato',
	'LBL_CHECKSYS_1'					=> 'Aby vaše instalace proběhla korektně, ujistěte se, že všechny položky kontroly systému jsou zelené. Pokud je některá červená, učiňte, prosím, kroky nezbytné k opravě.',
	'LBL_CHECKSYS_CACHE'				=> 'Do podadresářů vyrovnávací paměti lze zapisovat',
    'LBL_DROP_DB_CONFIRM'               => 'The provided Database Name already exists.<br>You can either:<br>1.  Click on the Cancel button and choose a new database name, or <br>2.  Click the Accept button and continue.  All existing tables in the database will be dropped. <strong>This means that all of the tables and pre-existing data will be blown away.</strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned Off',
    'LBL_CHECKSYS_COMPONENT'			=> 'Komponenta',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Volitelné komponenty',
	'LBL_CHECKSYS_CONFIG'				=> 'Do SugarCRM konfiguračního souboru (config.php) lze zapisovat',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Writable SuiteCRM Configuration File (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'cURL Modul',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Nastavení cesty pro uložení relace',
	'LBL_CHECKSYS_CUSTOM'				=> 'Zapisovatelný uživatelský adresář',
	'LBL_CHECKSYS_DATA'					=> 'Do datových podadresářů  lze zapisovat',
	'LBL_CHECKSYS_IMAP'					=> 'IMAP Modul',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magické uvozovky GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'MB Strings modul',
	'LBL_CHECKSYS_MEM_OK'				=> 'OK (bez limitu)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'OK (bez limitu)',
	'LBL_CHECKSYS_MEM'					=> 'PHP Memory Limit >= ',
	'LBL_CHECKSYS_MODULE'				=> 'Do podadresářů a souborů modulů lze zapisovat.',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'MySQL verze',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'Není dostupné',
	'LBL_CHECKSYS_OK'					=> 'OK',
	'LBL_CHECKSYS_PHP_INI'				=> '<b>Poznámka:</b> Váš konfigurační soubor (php.ini) se nachází v :',
	'LBL_CHECKSYS_PHP_OK'				=> 'OK (verze ',
	'LBL_CHECKSYS_PHPVER'				=> 'PHP verze',
    'LBL_CHECKSYS_IISVER'               => 'Verze služby IIS',
	'LBL_CHECKSYS_RECHECK'				=> 'Znovu zkontrolovat',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP Safe Mode má nastaveno Off',
	'LBL_CHECKSYS_SESSION'				=> 'Lze zapisovat do Session Save Path (',
	'LBL_CHECKSYS_STATUS'				=> 'Status',
	'LBL_CHECKSYS_TITLE'				=> 'Přijmutí kontroly sytému',
	'LBL_CHECKSYS_VER'					=> 'Nalezeno: (verze ',
	'LBL_CHECKSYS_XML'					=> 'XML Parsing',
	'LBL_CHECKSYS_ZLIB'					=> 'ZLIB Compression Modul',
	'LBL_CHECKSYS_ZIP'					=> 'ZIP Handling Module',
	'LBL_CHECKSYS_PCRE'					=> 'PCRE Library',
	'LBL_CHECKSYS_FIX_FILES'            => 'Před dalším pokračováním, prosím, opravte následující soubory a adresáře:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Pred pokračováním, prosím, opravte následující adresáře modulu a obsažené soubory:',
    'LBL_CHECKSYS_UPLOAD'               => 'Zapisovatelný adresář pro upload',
    'LBL_CLOSE'							=> 'Zavřít',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'bude vytvořeno',
	'LBL_CONFIRM_DB_TYPE'				=> 'Typ databáze',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Potvrďte, prosím, nastavení uvedená níže. Pokud chcete změnit některou z hodnot, klikněte &#034;Zpět&#034;. Pokud chcete spustit instalaci  klikněte na &#034;Další&#034;.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Licenční ujednání',
	'LBL_CONFIRM_NOT'					=> 'ne',
	'LBL_CONFIRM_TITLE'					=> 'Potvrdit nastavení',
	'LBL_CONFIRM_WILL'					=> 'bude',
	'LBL_DBCONF_CREATE_DB'				=> 'Vytvořit databázi',
	'LBL_DBCONF_CREATE_USER'			=> 'vytvořit uživatele',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Varování: Pokud je políčko zaškrtnuto, všechna Sugar data budou vymazána.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Smazat a vytvořit znovu existující Sugar tabulky?',
    'LBL_DBCONF_DB_DROP'                => 'Smazat tabulky',
    'LBL_DBCONF_DB_NAME'				=> 'Jméno databáze',
	'LBL_DBCONF_DB_PASSWORD'			=> 'Heslo pro uživatele Sugar databáze',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Opakovaně vložte heslo pro uživatele Sugar databáze',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM Database User',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM Database User',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Uživatelské jméno pro databázového administrátora',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Heslo databázového administrátora',
	'LBL_DBCONF_DEMO_DATA'				=> 'Naplnit databázi demo daty?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Zvolit demo data',
	'LBL_DBCONF_HOST_NAME'				=> 'Jmého počítače',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Instance hostitele',
	'LBL_DBCONF_HOST_PORT'				=> 'Port',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Vložte, prosím, informace o Vaší databázové konfiguraci. V případě, že si nejste jisti, co má být doplněno, doporučujeme použít výchozí hodnoty.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Použít v demo datech více bytové znaky.',
    'LBL_DBCONFIG_MSG2'                 => 'Jméno webového serveru nebo počítače, kde se databáze nachází:',
	'LBL_DBCONFIG_MSG2_LABEL' => 'Jmého počítače',
    'LBL_DBCONFIG_MSG3'                 => 'Jméno databáze, která bude obsahovat data Sugar instance, kterou se chystáte nainstalovat.:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'Jméno databáze',
    'LBL_DBCONFIG_B_MSG1'               => 'Uživatelské jméno a heslo správce databáze, který může vytvářet databázové tabulky a uživatelů a kteří mohou zapisovat do databáze je nutné nastavit v databázi SuiteCRM.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
    'LBL_DBCONFIG_SECURITY'             => 'Z bezpečnostních důvodů můžete zadat výhradního databázového uživatele pro připojení k databázi SuiteCRM. Tento uživatel musí být schopen zapisovat, aktualizovat a načíst data z databáze SuiteCRM, která bude vytvořena pro tuto instanci.  Tento uživatel může být správce databáze uvedené výše, nebo můžete poskytnout informace o novém nebo existujícím uživateli databáze.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Udělej to pro mne',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Vložit existujícího uživatele',
    'LBL_DBCONFIG_CREATE_DD'            => 'Definovat uživatel pro vytvoření',
    'LBL_DBCONFIG_SAME_DD'              => 'Stejné jako administrátor',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'Full-textové vyhledávání',
    'LBL_FTS_INSTALLED'                 => 'Instalovaný',
    'LBL_FTS_INSTALLED_ERR1'            => 'Funkčnost Full-textového vyhledávání není nainstalována.',
    'LBL_FTS_INSTALLED_ERR2'            => 'You can still install but will not be able to use Full Text Search functionality.  Please refer to your database server install guide on how to do this, or contact your Administrator.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Heslo privilegovaného databázového uživatele',
	'LBL_DBCONF_PRIV_USER_2'			=> 'Je databázový účet uvedený výše privilegovaný uživatel.',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'Privilegovaný databázový uživatel musí mít potřebná práva pro vytvoření databáze, mazání/vytváření tabulek a vytváření uživatelů. Uvedený uživatel bude využit pouze pro vykonání úloh během instalačního procesu. V případě, že má dostatečná práva, můžete využít stejného uživatele jako je uveden výše.',
	'LBL_DBCONF_PRIV_USER'				=> 'Uživatelské jméno privilegovaného uživatele',
	'LBL_DBCONF_TITLE'					=> 'Konfigurace databáze',
    'LBL_DBCONF_TITLE_NAME'             => 'Vložte jméno databáze',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Poskytněte informace o uživateli databáze',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'Uživatel',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'Heslo',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Po provedení této změny, můžete kliknout na tlačítko &#034;Start&#034; a začít s instalací. <i>Po ukončení instalace, budete chtít změnit hodnotu &#039;installer_locked&#039; na &#039;true&#039;.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'Instalátor již byl jednou spuštěn. Kvůli zabezpečení bylo zakázáno spustit jej opakovaně. Pokud jste si opravdu jist, že jej chcete opět spustit, otevřete, prosím, soubor config.php a přidejte/změňte proměnnou &#039;installer_locked&#039;  na &#039;true&#039;. Mělo by to vypadat následovně:',
	'LBL_DISABLED_HELP_1'				=> 'Pro nápovědu, prosím, navštivte SuiteCRM',
    'LBL_DISABLED_HELP_LNK'             => 'http://www.sugarcrm.com/forums/',
	'LBL_DISABLED_HELP_2'				=> 'Fóra podpory',
	'LBL_DISABLED_TITLE_2'				=> 'Instalace SugarCRM byla zakázána ',
	'LBL_DISABLED_TITLE'				=> 'Instalace SugarCRM zakázána ',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Znaková sada běžně užívána ve Vaší lokalizaci.',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Nastavení odesílané pošty',
    'LBL_EMAIL_CHARSET_CONF'            => 'Znaková sada odchozích emailů ',
	'LBL_HELP'							=> 'Nápověda',
    'LBL_INSTALL'                       => 'Instalovat',
    'LBL_INSTALL_TYPE_TITLE'            => 'Možnosti instalace',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Zvolit typ instalace',
    'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>Typická instalace</b>',
    'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>Volitelná instalace</b>',
    'LBL_INSTALL_TYPE_MSG1'             => 'The key is required for general application functionality, but it is not required for installation. You do not need to enter the key at this time, but you will need to provide the key after you have installed the application.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Vyžaduje minimální množství informací.  Doporučeno pro nové uživatele.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Provides additional options to set during the installation. Most of these options are also available after installation in the admin screens. Recommended for advanced users.',
	'LBL_LANG_1'						=> 'To use a language in SuiteCRM other than the default language (US-English), you can upload and install the language pack at this time. You will be able to upload and install language packs from within the SuiteCRM application as well.  If you would like to skip this step, click Next.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Instalovat',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Odstranit',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Odinstalovat',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Načíst',
	'LBL_LANG_NO_PACKS'					=> 'prázdné',
	'LBL_LANG_PACK_INSTALLED'			=> 'Jsou nainstalovány následující jazykové balíčky: ',
	'LBL_LANG_PACK_READY'				=> 'Tyto jazykové balíčky jsou připraveny k instalaci: ',
	'LBL_LANG_SUCCESS'					=> 'Jazykový balíček byl úspěšně nahrán.',
	'LBL_LANG_TITLE'			   		=> 'Jazykový balíček',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Installing SuiteCRM now.  This may take up to a few minutes.',
	'LBL_LANG_UPLOAD'					=> 'Načíst jazykový balíček',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Přijmout licenční ujednání',
    'LBL_LICENSE_CHECKING'              => 'Kontrola kompatibility systému.',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Kontrola prostředí.',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Kontrola DB oprávnění',
    'LBL_LICENSE_CHECK_PASSED'          => 'Systém prošel testem kompatibility.',
	'LBL_CREATE_CACHE' => 'Preparing to Install...',
    'LBL_LICENSE_REDIRECT'              => 'Přesměrování v ',
	'LBL_LICENSE_DIRECTIONS'			=> 'Pokud máte licenční informace, vložte je, prosím, do následujících polí.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Vložit klíč pro stažení',
	'LBL_LICENSE_EXPIRY'				=> 'Expirace',
	'LBL_LICENSE_I_ACCEPT'				=> 'Přijímám',
	'LBL_LICENSE_NUM_USERS'				=> 'Počet uživatelů',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Vložte, prosím, počet offline klientů.',
	'LBL_LICENSE_OC_NUM'				=> 'Počet licenci pro offline klienty',
	'LBL_LICENSE_OC'					=> 'Licence pro offline klienty',
	'LBL_LICENSE_PRINTABLE'				=> 'Tisková verze',
    'LBL_PRINT_SUMM'                    => 'Tisk souhrnu',
	'LBL_LICENSE_TITLE_2'				=> 'SugarCRM licence',
	'LBL_LICENSE_TITLE'					=> 'Licenční ujednání',
	'LBL_LICENSE_USERS'					=> 'Licencovaní uživatelé',

	'LBL_LOCALE_CURRENCY'				=> 'Nastavení měny',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Výchozí měna',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Symbol měny',
	'LBL_LOCALE_CURR_ISO'				=> 'Kód měny (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> 'Oddělovač 1000',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Oddělovač desetinné čárky',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Příklad',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Platné číslice',
	'LBL_LOCALE_DATEF'					=> 'Výchozí formát datumu',
	'LBL_LOCALE_DESC'					=> 'Zvolená lokální nastavení budou aplikována globálně v celé Sugar instanci.',
	'LBL_LOCALE_EXPORT'					=> 'Znaková sada pro Import/Export<br> <i>(Email, .csv, vCard, PDF, data import)</i>',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Oddělovač exportu (.csv)',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Nastavení Importu/Exportu',
	'LBL_LOCALE_LANG'					=> 'Výchozí jazyk',
	'LBL_LOCALE_NAMEF'					=> 'Výchozí formát jména',
	'LBL_LOCALE_NAMEF_DESC'				=> 's = oslovení<br>f = jméno<br>l = příjmení',
	'LBL_LOCALE_NAME_FIRST'				=> 'Karel',
	'LBL_LOCALE_NAME_LAST'				=> 'Novák',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Dr.',
	'LBL_LOCALE_TIMEF'					=> 'Výchozí formát času',

    'LBL_CUSTOMIZE_LOCALE'              => 'Nastavit lokální volby',
	'LBL_LOCALE_UI'						=> 'Uživatelské rozhraní',

	'LBL_ML_ACTION'						=> 'Akce',
	'LBL_ML_DESCRIPTION'				=> 'Popis',
	'LBL_ML_INSTALLED'					=> 'Datum instalace',
	'LBL_ML_NAME'						=> 'Jméno',
	'LBL_ML_PUBLISHED'					=> 'Datum vydání',
	'LBL_ML_TYPE'						=> 'Typ',
	'LBL_ML_UNINSTALLABLE'				=> 'Lze odinstalovat',
	'LBL_ML_VERSION'					=> 'Verze',
	'LBL_MSSQL'							=> 'SQL Server',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver for PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (mysqli extension)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Další',
	'LBL_NO'							=> 'Ne',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Nastavit heslo administrátora webu',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'audit tabulky / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Vytváření Sugar konfiguračního souboru',
	'LBL_PERFORM_CREATE_DB_1'			=> '<b>Vytváření databáze</b> ',
	'LBL_PERFORM_CREATE_DB_2'			=> 'ano ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Vytváření uživatelského jména a hesla ...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Vytváření výchozích Sugar dat',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Vytváření uživatelského jména a hesla pro localhost...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Vytváření Sugar relačních tabulek',
	'LBL_PERFORM_CREATING'				=> '´',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Vytváření výchozích sestav',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Vytváření výchozích úkolů plánovače',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Vkládání výchozích hodnot',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Vytváření výchozích uživatelů',
	'LBL_PERFORM_DEMO_DATA'				=> 'Plnění databáze výchozími daty (může zabrat trochu času)',
	'LBL_PERFORM_DONE'					=> 'dokončeno<br>',
	'LBL_PERFORM_DROPPING'				=> 'odstraňování / ',
	'LBL_PERFORM_FINISH'				=> 'Ukončit',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Aktualizace licenčních informací',
	'LBL_PERFORM_OUTRO_1'				=> 'Nastavení Sugaru',
	'LBL_PERFORM_OUTRO_2'				=> ' je kompletní',
	'LBL_PERFORM_OUTRO_3'				=> 'Čas celkem: ',
	'LBL_PERFORM_OUTRO_4'				=> ' vteřin.',
	'LBL_PERFORM_OUTRO_5'				=> 'Odhad obsazené paměti: ',
	'LBL_PERFORM_OUTRO_6'				=> ' bajtů.',
	'LBL_PERFORM_OUTRO_7'				=> 'Váš systém je nyní nainstalován a nakonfigurován.',
	'LBL_PERFORM_REL_META'				=> 'relační metadata ... ',
	'LBL_PERFORM_SUCCESS'				=> 'Úspěch',
	'LBL_PERFORM_TABLES'				=> 'Vytváření Sugar aplikačních tabulek, audit tabulek, relačních metadat.',
	'LBL_PERFORM_TITLE'					=> 'Spustit setup',
	'LBL_PRINT'							=> 'Tisk',
	'LBL_REG_CONF_1'					=> 'Please complete the short form below to receive product announcements, training news, special offers and special event invitations from SuiteCRM. We do not sell, rent, share or otherwise distribute the information collected here to third parties.',
	'LBL_REG_CONF_2'					=> 'Vaše jméno a emailová adresa jsou jediné povinné položky. Všechna ostatní pole jsou sice volitelná, ale velmi užitečná. Informace zde získané nebudou prodány, zapůjčeny, sdíleny ani jinak předávány třetím stranám.',
	'LBL_REG_CONF_3'					=> 'Děkujeme za registraci. Aby jste se přihlásili do SugarCRM, klikněte na tlačítko &#034;Ukončit&#034;. Poprvé se musíte přihlásit jako uživatel admin a vložit heslo, které jste si zvolili v kroku 2.',
	'LBL_REG_TITLE'						=> 'Registrace',
    'LBL_REG_NO_THANKS'                 => 'Ne děkuji',
    'LBL_REG_SKIP_THIS_STEP'            => 'Skip this Step',
	'LBL_REQUIRED'						=> '* Povinné pole',

    'LBL_SITECFG_ADMIN_Name'            => 'Jméno administrátora Sugar aplikace',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Vložte znova heslo Sugar administrátora',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Varování: Administrátorské heslo z libovolné předchozí instalace bude změněno.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'Heslo administrátora Sugaru',
	'LBL_SITECFG_APP_ID'				=> 'ID Aplikace',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'If selected, you must provide an application ID to override the auto-generated ID. The ID ensures that sessions of one SuiteCRM instance are not used by other instances.  If you have a cluster of SuiteCRM installations, they all must share the same application ID.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Uveďte vlastní ID aplikace',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'If selected, you must specify a log directory to override the default directory for the SuiteCRM log. Regardless of where the log file is located, access to it through a web browser will be restricted via an .htaccess redirect.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Využít zvolený Log adresář',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'If selected, you must provide a secure folder for storing SuiteCRM session information. This can be done to prevent session data from being vulnerable on shared servers.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Využít zvolený Log adresář pro Sugar',
	'LBL_SITECFG_DIRECTIONS'			=> 'Vložte následující informace o konfiguraci webu. Pokud si nejste jisti hodnotou polí, doporučujeme použít výchozí hodnoty.',
	'LBL_SITECFG_FIX_ERRORS'			=> '<b>Před pokračováním, prosím, opravte následující chyby.</b>',
	'LBL_SITECFG_LOG_DIR'				=> 'Log adresář',
	'LBL_SITECFG_SESSION_PATH'			=> 'Cest k Session adresáři<br>(nutné právo zápisu)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Zvolte možnosti zabezpečení',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'Pokud je zaškrtnuto, systém bude pravidelně kontrolovat zdali nejsou dostupné aktualizované verze aplikace.',
	'LBL_SITECFG_SUGAR_UP'				=> 'Automaticky kontrolovat zdali jsou dostupné aktualizace?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Sugar aktualizuje konfiguraci',
	'LBL_SITECFG_TITLE'					=> 'Konfigurace webu',
    'LBL_SITECFG_TITLE2'                => 'Specifikujte Vaší Sugar instanci',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Zabezpečení místa',
	'LBL_SITECFG_URL'					=> 'URL Sugar instance',
	'LBL_SITECFG_USE_DEFAULTS'			=> 'Použít výchozí?',
	'LBL_SITECFG_ANONSTATS'             => 'Zasílat anonymní informace a využití?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'Při  této volbě bude Sugar pravidelně při každé kontole existence aktualizované verze zasílat anonymní statistiky o Vaší instalaci firmě SugarCRM Inc. Tato informace nám pomůže lépe porozumět jak je aplikace využívána a pomůže ve zlepšování produktu.',
    'LBL_SITECFG_URL_MSG'               => 'Enter the URL that will be used to access the SuiteCRM instance after installation. The URL will also be used as a base for the URLs in the SuiteCRM application pages. The URL should include the web server or machine name or IP address.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Enter a name for your system.  This name will be displayed in the browser title bar when users visit the SuiteCRM application.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'After installation, you will need to use the SuiteCRM admin user (default username = admin) to log in to the SuiteCRM instance.  Enter a password for this administrator user. This password can be changed after the initial login.  You may also enter another admin username to use besides the default value provided.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Select collation (sorting) settings for your system. This settings will create the tables with the specific language you use. In case your language doesn\'t require special settings please use default value.',
    'LBL_SPRITE_SUPPORT'                => 'Sprite Support',
	'LBL_SYSTEM_CREDS'                  => 'Systémové přihlašovací údaje',
    'LBL_SYSTEM_ENV'                    => 'Prostředí systému.',
	'LBL_START'							=> 'Začátek',
    'LBL_SHOW_PASS'                     => 'Zobrazit hesla',
    'LBL_HIDE_PASS'                     => 'Skrýt hesla',
    'LBL_HIDDEN'                        => '<i>(skryto)</i>',
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
	'LBL_CHOOSE_LANG'					=> '<b>Zvolte si jazyk</b>',
	'LBL_STEP'							=> 'Krok',
	'LBL_TITLE_WELCOME'					=> 'Vítejte v SuiteCRM  ',
	'LBL_WELCOME_1'						=> 'Instalátor vytvoří SugarCRM databázové tabulky a nastaví konfigurační proměnné, tak aby jste mohli začít. Celý proces by měl zabrat kolem deseti minut.',
	'LBL_WELCOME_2'						=> 'Pro nápovědu, navštivte prosím <a href=&#034;http://www.sugarcrm.com/forums/&#034; target=&#034;_blank&#034;>fóra podpory</a>.',
    //welcome page variables
    'LBL_TITLE_ARE_YOU_READY'            => 'Jste připraveni k instalaci?',
    'REQUIRED_SYS_COMP' => 'Požadované systémové komponenty',
    'REQUIRED_SYS_COMP_MSG' =>
                    'Before you begin, please be sure that you have the supported versions of the following system
                      components:<br>
                      <ul>
                      <li> Database/Database Management System (Examples: MariaDB, MySQL or SQL Server)</li>
                      <li> Web Server (Apache, IIS)</li>
                      </ul>
                      Consult the Compatibility Matrix in the Release Notes for
                      compatible system components for the SuiteCRM version that you are installing.<br>',
    'REQUIRED_SYS_CHK' => 'Úvodní kontrola systému',
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
    'REQUIRED_INSTALLTYPE' => 'Typická nebo volitelná instalace',
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

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '<b>Zvolte si jazyk</b>',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Průvodce instalací',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Vítejte v SuiteCRM ',
	'LBL_WELCOME_TITLE'					=> 'Průvodce instalací SugarCRM',
	'LBL_WIZARD_TITLE'					=> 'Průvodce nastavením Sugaru: ',
	'LBL_YES'							=> 'Ano',
    'LBL_YES_MULTI'                     => 'Ano - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Vykonat úlohy workflow',
	'LBL_OOTB_REPORTS'		=> 'Spustit  plánované úlohy pro generování sestav',
	'LBL_OOTB_IE'			=> 'Zkontrolovat příchozí zprávy',
	'LBL_OOTB_BOUNCE'		=> 'Spustit noční proces omezené emailové kampaně',
    'LBL_OOTB_CAMPAIGN'		=> 'Spustit noční masové emailové kampaně',
	'LBL_OOTB_PRUNE'		=> 'Zmenšit databázi první den v měsíci',
    'LBL_OOTB_TRACKER'		=> 'Prune tracker tables',
    'LBL_OOTB_SUGARFEEDS'   => 'Prune SuiteCRM Feed Tables',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Run Email Reminder Notifications',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Update tracker_sessions table',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Clean Jobs Queue',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Removal of documents from filesystem',


    'LBL_PATCHES_TITLE'     => 'Instalujte poslední záplaty',
    'LBL_MODULE_TITLE'      => 'Stáhnout a nainstalovat jazykové balíčky.',
    'LBL_PATCH_1'           => 'Pokud chcete přeskočit tento krok, klikněte na Další.',
    'LBL_PATCH_TITLE'       => 'Systémová záplata',
    'LBL_PATCH_READY'       => 'Následující záplaty jsou připraveny k instalaci.:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM relies upon PHP sessions to store important information while connected to this web server.  Your PHP installation does not have the Session information correctly configured.
											<br><br>A common misconfiguration is that the <b>'session.save_path'</b> directive is not pointing to a valid directory.  <br>
											<br> Please correct your <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>PHP configuration</a> in the php.ini file located here below.",
	'LBL_SESSION_ERR_TITLE'				=> 'Chyba PHP konfigurace',
	'LBL_SYSTEM_NAME'=>'Systémový název',
    'LBL_COLLATION' => 'Collation Settings',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Zvolte systémové jméno pro Sugar instanci.',
	'LBL_PATCH_UPLOAD' => 'Zvolte ve Vašem počítači soubor se záplatou',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Php verze 5 nebo vyšší je vyžadována.',
	'LBL_MINIMUM_PHP_VERSION' => 'Minimum Php version required is 5.1.0. Recommended Php version is 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(Tvoje php verze is ',
	'LBL_RECOMMENDED_PHP_VERSION' =>' Recommended php version is 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'Tvoje verze PHP není kompatibilní s SugarCRM. Postupuj prosím dle požadovaných parametrů pro systém. Vaše verze je ',
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

	'LBL_WIZARD_SMTP_DESC' => 'Zadejte e-mailový účet, který bude použit k odeslání e-mailů, například přiřazení upozornění a nové heslo uživatele. Uživatelé budou dostávat e-maily ze systému Sugar, odeslané ze zadaného e-mailového účtu.',
	'LBL_CHOOSE_EMAIL_PROVIDER'        => 'Vyberte si Vašeho poskytovatele e-mailu:',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! Mail',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => 'Jiné',
	'LBL_MAIL_SMTP_SETTINGS'           => 'Specifikace serveru SMTP',
	'LBL_MAIL_SMTPSERVER'				=> 'SMTP server:',
	'LBL_MAIL_SMTPPORT'					=> 'SMTP port:',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'Použít SMTP autentifikaci?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => 'Povolit SMTP přes SSL nebo TLS?',
	'LBL_GMAIL_SMTPUSER'					=> 'Gmail e-mailová adresa:',
	'LBL_GMAIL_SMTPPASS'					=> 'Gmail heslo:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => 'Uživatelé mohou používat tento účet pro odchozí e-mail:',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => 'Je-li vybrána tato možnost, budou všichni uživatelé moci posílat e-maily pomocí stejného odchozího poštovníhí účtu, který slouží k odesílání upozornění systému a výstrah.  Pokud není vybrána tato možnost, uživatelé mohou nadále používat server pro odchozí poštu, ale musí zada vlastní přihlašovací údaje.',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Yahoo! Mail heslo:',
	'LBL_YAHOOMAIL_SMTPUSER'					=> 'Yahoo! Mail ID:',

	'LBL_EXCHANGE_SMTPPASS'					=> 'Vyměnit heslo:',
	'LBL_EXCHANGE_SMTPUSER'					=> 'Vyměnit uživatelské jméno:',
	'LBL_EXCHANGE_SMTPPORT'					=> 'Port serveru Exchange:',
	'LBL_EXCHANGE_SMTPSERVER'				=> 'Vyměnit server:',


	'LBL_MAIL_SMTPUSER'					=> 'SMTP uživatelské jméno:',
	'LBL_MAIL_SMTPPASS'					=> 'SMTP heslo:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Brandování',
	'LBL_WIZARD_SYSTEM_DESC' => 'Zadejte jméno a logo vaší organizace pro brandování vašeho Sugar systému.',
	'SYSTEM_NAME_WIZARD'=>'Jméno:',
	'SYSTEM_NAME_HELP'=>'To je název, který se zobrazí v záhlaví prohlížeče.',
	'NEW_LOGO'=>'Načíst nové logo (212x40)',
	'NEW_LOGO_HELP'=>'Formát obrazového souboru může být buď PNG nebo jpg. Maximální výška je 17px, a maximální šířka je 450px. Jakýkoliv větší obrázek v libovolném směru bude zmenšen na tyto maximální rozměry.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'Načíst',
	'CURRENT_LOGO'=>'Nyní používané logo',
    'CURRENT_LOGO_HELP'=>'Toto logo se zobrazí v levém rohu zápatí aplikace Sugar..',

	// System Local Settings


	'LBL_LOCALE_TITLE' => 'System Locale Settings',
	'LBL_WIZARD_LOCALE_DESC' => 'Určete, jak chcete data v Sugar systému zobrazit z ohledem na Vaší geografickou polohu. Zde nastavené nastavení bude použité jako výchozí. Uživatelé si mohou vytvořit vlastní nastavení.',
	'LBL_DATE_FORMAT' => 'Formát datumu:',
	'LBL_TIME_FORMAT' => 'Formát času:',
		'LBL_TIMEZONE' => 'Časové pásmo:',
	'LBL_LANGUAGE'=>'Jazyk:',
	'LBL_CURRENCY'=>'Měna:',
	'LBL_CURRENCY_SYMBOL'=>'Currency Symbol:',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 Currency Code:',
	'LBL_NUMBER_GROUPING_SEP' => 'oddělovač tisíců:',
	'LBL_DECIMAL_SEP' => 'Desetinný oddělovač:',
	'LBL_NAME_FORMAT' => 'Name Format:',
	'UPLOAD_LOGO' => 'Please wait, logo uploading..',
	'ERR_UPLOAD_FILETYPE' => 'File type do not allowed, please upload a jpeg or png.',
	'ERR_LANG_UPLOAD_UNKNOWN' => 'Unknown file upload error occured.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => 'Nahrávaný soubor přesahuje upload_max_filesize direktivu v  php.ini.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => 'Nahrávaný soubor přesahuje MAX_FILE_SIZE direktivu v  HTML formuláři.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => 'Soubor byl nahrán pouze částečně.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => 'Nebyl nahrán soubor.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => 'Chybí dočasný adresář.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => 'Chyba zápisu na disk.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.',

	'LBL_INSTALL_PROCESS' => 'Install...',

	'LBL_EMAIL_ADDRESS' => 'Email:',
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
	'LBL_START' => 'Začátek',


);

?>
