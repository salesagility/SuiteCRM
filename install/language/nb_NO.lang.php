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
	'LBL_BASIC_SEARCH'					=> 'Grunnleggende søk',
	'LBL_ADVANCED_SEARCH'				=> 'Avansert søk',
	'LBL_BASIC_TYPE'					=> 'Enkel Type',
	'LBL_ADVANCED_TYPE'					=> 'Avansert type',
	'LBL_SYSOPTS_1'						=> 'Velg mellom de følgende systemkonfigurasjonene under.',
    'LBL_SYSOPTS_2'                     => 'Hvilken type database skal bli brukt av SuiteCRM-instansen du installerer?',
	'LBL_SYSOPTS_CONFIG'				=> 'Systemkonfigurasjon',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Oppgi databasetype',
    'LBL_SYSOPTS_DB_TITLE'              => 'Databasetype',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Rett opp i følgende feil før du fortsetter:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Gjør den følgende mappen skrivbar:',
    'ERR_DB_VERSION_FAILURE'			=> 'Kunne ikke sjekke databaseversjon',
	'DEFAULT_CHARSET'					=> 'latin1',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Oppgi brukernavn for SuiteCRM-administratoren.',
	'ERR_ADMIN_PASS_BLANK'				=> 'Oppgi passordet for SuiteCRM-administratoren.',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'Feil har blitt oppdaget under kompatibilitetssjekken. For å kunne installere SuiteCRM skikkelig, gå over problemene i listen under og enten trykk på "Sjekk på nytt" eller prøv å installere SuiteCRM på nytt.',
    'ERR_CHECKSYS_CALL_TIME'            => 'Allow Call Time Pass Reference er slått av (slå det på i php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'Ikke funnet: SuiteCRM Planlegger vill kjøre med begrenset funksjonalitet.',
    'ERR_CHECKSYS_IMAP'					=> 'Ikke funnet: InngåendeEpost og Kampanjer (Epost) krever IMAP-bibliotekene. Hverken av disse to vil virke.',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC kan ikke være på når du bruker MS SQL Server.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Advarsel:',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> '(Sett denne til',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M eller større i din php.ini)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Minimumsversjon 4.1.2 - Funnet:',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Kunne hverken skrive til eller lese fra sesjonsvariabler. Kan ikke fortsette installasjonen.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'Ikke en gyldig mappe',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Advarsel: Ikke skrivbar',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Din versjon av PHP er ikke supportert av Sugar. Du må installere en versjon som er kompatibel med Sugar. Vennligst sjekk Compatibility Matrix i Release Notes for støttede PHP versjoner. Din versjon er',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'Din versjon av IIS er ikke støttet av SuiteCRM. Du må installere en versjon som er kompatibel med SuiteCRM. Se over kompabilitetsmatrisen i versjonsnotatene for støttede IIS-versjoner. Din versjon er',
	'ERR_CHECKSYS_FASTCGI'              => 'Vi oppdaget at du ikke bruker en FastCGI handler mapping for PHP. Du må installere eller konfigurere en versjon er er kompatibel med SuiteCRM. Se over kompabilitetsmatrisen i versjonsnotatene for støttede versjoner. Se også over <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> for flere detaljer.',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Du kan få den optimale oplevelse med IIS/FastCGI sapi ved at angive fastcgi.logging til 0 i filen php.ini.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Denne PHP-versjonen er ikke støttet: ( ver',
    'LBL_DB_UNAVAILABLE'                => 'Database utilgjengelig',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'Databasestøtte ble ikke funnet. Sørg for at du har de nødvendige driverene for en av de støttede databasetypene: MySQL eller MS SQLServer. Det kan være at du blir nødt til å kommentere ut utvidelsen i php.ini, eller rekompilere med den riktige binærfilen, avhengig av din PHP-versjon. Se over PHP Manualen for mer informasjon om hvordan du slår på støtte for databaser.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'Funksjoner assosiert med XML-tolkningsbiblioteker som trengs av SuiteCRM ble ikke funnet. Det kan være at du blir nødt til å ta vekk utkommenteringen av utvidelsen i php.ini, eller rekompilere med den riktige binærfilen, avhengig av din PHP-versjon. Se over PHP Manualen for mer informasjon.',
    'ERR_CHECKSYS_MBSTRING'             => 'Funksjoner assosiert med PHP-utvidelsen for flerbyte-strenger (mbstring) som trengs av SuiteCRM ble ikke funnet. <br /><br />Vanligvis er ikke mbstring-modulen slått på som standard i PHP, og må aktiveres med --enable-mbstring når PHP-binærfilen bygges. Se over PHP Manualen for mer informasjon om hvordan slå på støtte for mbstring.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'Lagringsstien for session.save_path i php-konfigurasjonen din (php.ini) er ikke satt, eller er satt til en mappe som ikke eksisterer. Det kan være at du må endre innstillingen for save_path i php.ini eller dobbeltsjekke at mappen spesifisert i innstillingen eksisterer.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'Innstillingen for session.save_path i php-konfigurasjonen din (php.ini) er satt til en mappe som ikke er skrivbar. Gjør det du må for å sørge for at mappen er skrivbar. <br />Avhengig av operativsystemet ditt, dette kan kreve at du endrer tillatelser ved å kjøre chmod 766, eller at du høyreklikker på mappen, går til innstillinger og tar vekk avkryssningen for skrivebeskyttet.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'Konfigurasjonsfilen eksisterer, men er ikke skrivbar. Gjør det du må for å gjøre filen skrivbar. Avhengig av operativsystemet ditt, dette kan kreve at du endrer tillatelser ved å kjøre chmod 766, eller at du høyreklikker på filen, går til egenskaper og tar vekk avkryssningen for skrivebeskyttet.',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'Overkjøringskonfigurasjonsfilen eksisterer, men er ikke skrivbar. Gjør det du må for å gjøre filen skrivbar. Avhengig av operativsystemet ditt, dette kan kreve at du endrer tillatelser ved å kjøre chmod 766, eller at du høyreklikker på filen, går til egenskaper og tar vekk avkryssningen for skrivebeskyttet.',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'Den tilpassede mappen (Custom Directory) eksisterer, men er ikke skrivbar. Gjør det du må for å gjøre filen skrivbar. Avhengig av operativsystemet ditt, dette kan kreve at du endrer tillatelser ved å kjøre chmod 766, eller at du høyreklikker på mappen, går til egenskaper og tar vekk avkryssningen for skrivebeskyttet.',
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "Filene eller mappene listet opp under er ikke skrivbare, mangler, eller kan ikke bli opprettet. Avhengig av operativsystemet ditt, dette kan kreve at du endrer tillatelser på filene eller opphavsmappen, ved å kjøre chmod 755, eller at du høyreklikker på opphavsmappen, går til egenskaper og tar vekk avkryssningen for skrivebeskyttet.",
    'LBL_CHECKSYS_OVERRIDE_CONFIG' => 'Config override',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode er slått på (Det kan være at du vil slå det av i php.ini)',
    'ERR_CHECKSYS_ZLIB'					=> 'Støtte for ZLib ble ikke funnet: SuiteCRMs ytelse går i taket ved bruk av zlib-kompresjon.',
    'ERR_CHECKSYS_ZIP'					=> 'ZIP-støtte ble ikke funnet: SuiteCRM trenger ZIP-støtte for å kunne prosessere komprimerte arkivfiler.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE-bibliotek ble ikke funnet: SuiteCRM trenger PCRE-biblioteket for å kunne prosessere regulære uttrykk i Perl-stil.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE-bibliotek versjon: SuiteCRM trenger PCRE-biblioteket i versjon 7.0 eller høyere for å kunne prosessere regulære uttrykk i Perl-stil.',
	'ERR_DB_ADMIN'						=> 'Den oppgitte brukernavn/passord-kombinasjonen til databasen er ugyldig, og på grunn av det kunne ikke en tilkobling til databasen bli opprettet. Oppgi et gyldig brukernavn og passord. (Feil: ',
    'ERR_DB_ADMIN_MSSQL'                => 'Den oppgitte brukernavn/passord-kombinasjonen til databasen er ugyldig, og på grunn av det kunne ikke en tilkobling til databasen bli opprettet. Oppgi et gyldig brukernavn og passord.',
	'ERR_DB_EXISTS_NOT'					=> 'Den spesifiserte databasen eksisterer ikke.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'Det finnes alerede en database med konfigurasjonsdata. For å installere med den valgte databasen, kjør installasjonen på nytt og velg "Slett og gjenopprett eksisterende SuiteCRM-tabeller?". For å oppgradere, bruk oppgraderingsveiviseren i administratorkonsollen. Les også over oppgraderingsdokumentasjonen <a href="https://suitecrm.com/" target="_new">her</a>.',
	'ERR_DB_EXISTS'						=> 'Databasenavnet finnes allerede - kan ikke opprette en ny med det samme navnet.',
    'ERR_DB_EXISTS_PROCEED'             => 'Databasenavnet finnes allerede. Du kan <br />1. Klikke på tilbake-knappen og velge et nytt databasenavn. <br />2. Klikke på neste og fortsette, men alle eksisterende tabeller i databasen vil bli slettet. <strong>Dette betyr at all eksisterende data i databasen vil forsvinne og bli borte for godt.</strong>',
	'ERR_DB_HOSTNAME'					=> 'Tjenernavn kan ikke være blankt.',
	'ERR_DB_INVALID'					=> 'Ugyldig databasetype valgt.',
	'ERR_DB_LOGIN_FAILURE'				=> 'Den oppgitte databaseverten, brukernavnet og/eller passordet er ugyldig, og på grunn av det kunne ikke en tilkobling til databasen bli opprettet. Oppgi gyldige verdier for databasevert, brukernavn og passord.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'Den oppgitte databaseverten, brukernavnet og/eller passordet er ugyldig, og på grunn av det kunne ikke en tilkobling til databasen bli opprettet. Oppgi gyldige verdier for databasevert, brukernavn og passord.',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'Den oppgitte databaseverten, brukernavnet og/eller passordet er ugyldig, og på grunn av det kunne ikke en tilkobling til databasen bli opprettet. Oppgi gyldige verdier for databasevert, brukernavn og passord.',
	'ERR_DB_MYSQL_VERSION'				=> 'Din versjon av MySQL (%s) er ikke støttet av SuiteCRM. Du må installere en versjon som er kompatibel med SuiteCRM. Se over kompabilitetsmatrisen i versjonsnotatene for støttede MySQL-versjoner. Din versjon er',
	'ERR_DB_NAME'						=> 'Databasenavnet kan ikke være blankt.',
	'ERR_DB_NAME2'						=> "Databasenavnet kan ikke inneholde  '\\', '/' eller '.'.",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "Databasenavnet kan ikke inneholde  '\\', '/' eller '.'.",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "Databasenavn kan ikke starte med tall, '#' eller '@' og kan ikke inneholde mellomrom, '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', '&', '!', eller '-'.",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "Databasenavn kan bare inneholde alfanumeriske tegn og symbolene '#', '_' eller '$'.",
	'ERR_DB_PASSWORD'					=> 'Passordene oppgitt for SuiteCRM sin databaseadministrator stemmer ikke overens. Skriv inn passordet på nytt, og pass på at du skriver det samme passordet i begge feltene',
	'ERR_DB_PRIV_USER'					=> 'Oppgi en databaseadministratorbruker. Denne brukeren trengs for den første tilkoblingen til databasen.',
	'ERR_DB_USER_EXISTS'				=> 'Brukernavnet for SuiteCRM-databasen finnes allerede - kan ikke opprette en ny med det samme navnet. Skriv inn et nytt brukernavn.',
	'ERR_DB_USER'						=> 'Oppgi brukernavn for SuiteCRM-databaseadministratoren.',
	'ERR_DBCONF_VALIDATION'				=> 'Rett opp i følgende feil før du fortsetter:',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'Passordene oppgitt for SuiteCRM-databasen stemmer ikke overens. Skriv inn passordet på nytt, og pass på at du skriver det samme passordet i begge feltene',
	'ERR_ERROR_GENERAL'					=> 'Følgende feil oppsto:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'Kan ikke slette filen:',
	'ERR_LANG_MISSING_FILE'				=> 'Kan ikke finne filen:',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'Fant ingen språkpakkefiler i include/language i:',
	'ERR_LANG_UPLOAD_1'					=> 'Det oppsto et problem med opplastingen din. Prøv på nytt.',
	'ERR_LANG_UPLOAD_2'					=> 'Språkpakker må være ZIP-arkiver.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP kunne ikke flytte den midlertidige filen til oppgraderingsmappen.',
	'ERR_LICENSE_MISSING'				=> 'Mangler nødvendig informasjon',
	'ERR_LICENSE_NOT_FOUND'				=> 'Lisensfil ble ikke funnet!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'Den oppgitte loggmappen er ikke en gyldig mappe.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'Den oppgitte loggmappen er ikke en skrivbar mappe.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Loggmappe er obligatorisk dersom du ønsker å bruke din egen.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'Kunne ikke prosessere scriptet direkte.',
	'ERR_NO_SINGLE_QUOTE'				=> 'Du kan ikke angive single quotation for ',
	'ERR_PASSWORD_MISMATCH'				=> 'Passordene oppgitt for SuiteCRM-administratoren stemmer ikke overens. Skriv inn passordet på nytt, og pass på at du skriver det samme passordet i begge feltene',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'Kan ikke skrive til <span class=stop>config.php</span>.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Du kan fortsette denne installasjonen manuelt ved å opprette config.php og lime inn konfigurasjonsinnstillingene under inn i config.php. Legg merke til at du <strong>må</strong> opprette config.php før du fortsetter til neste steg.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'Husket du å opprette config.php?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Advarsel: Kunne ikke skrive til config.php. Vennligst sørg for at den eksisterer.',
	'ERR_PERFORM_HTACCESS_1'			=> 'Kan ikke skrive til',
	'ERR_PERFORM_HTACCESS_2'			=> 'filen.',
	'ERR_PERFORM_HTACCESS_3'			=> 'Dersom du vil sikre loggfilene dine mot å være tilgjengelig via en nettleser, opprett en .htaccess-fil i loggmappen din med linjen:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>Vi kunne ikke oppdage en internett-tilkobling.</b> Når du har en internett-tilkobling, besøk <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> for å registrere SuiteCRM. Ved å la oss vite litt om hvordan ditt selskap planlegger å bruke SuiteCRM, kan vi sørge for at vi leverer det produktet du trenger.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'Den oppgitte sesjonsmappen er ikke en gyldig mappe.',
	'ERR_SESSION_DIRECTORY'				=> 'Den oppgitte sesjonsmappen er ikke en skrivbar mappe.',
	'ERR_SESSION_PATH'					=> 'Sesjonssti er obligatorisk dersom du ønsker å bruke din egen.',
	'ERR_SI_NO_CONFIG'					=> 'Du inkluderte ikke config_si.php i dokumentroten, eller så definerte du ikke $sugar_config_si i config.php.',
	'ERR_SITE_GUID'						=> 'Program-ID er obligatorisk dersom du ønsker å oppgi din egen.',
    'ERROR_SPRITE_SUPPORT'              => "Vi kunne ikke finneGD-biblioteket. På grunn av dette vil du ikke kunne bruke CSS-Sprite-funksjonalitet.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Warning: Your PHP configuration should be changed to allow files of at least 6MB to be uploaded.',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Upload File Size',
	'ERR_URL_BLANK'						=> 'Provide the base URL for the SuiteCRM instance.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'Kunne ikke finne installasjonsregistreringen for',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'Den opplastede filen er ikke kompatibel med denne versjonen (Community Edition, Professional, or Enterprise) av SuiteCRM:',
	'ERROR_LICENSE_EXPIRED'				=> "Feil: Din lisens er gått ut på dato",
	'ERROR_LICENSE_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to enter your new license key.  If you do not enter a new license key within 30 days of your license key expiration, you will no longer be able to log in to this application.",
	'ERROR_MANIFEST_TYPE'				=> 'Manifest fil må spesifisere pakke-type.',
	'ERROR_PACKAGE_TYPE'				=> 'Manifest fil spesifiserer en ikke-gjenkjennbar pakke type',
	'ERROR_VALIDATION_EXPIRED'			=> "Feil: Valideringsnøkkelen har gått ut på dato",
	'ERROR_VALIDATION_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a> in the Admin screen to enter your new validation key.  If you do not enter a new validation key within 30 days of your validation key expiration, you will no longer be able to log in to this application.",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'Den opplastede fil er ikke kompatibel med denne versjonen av Sugar Suite: ',

	'LBL_BACK'							=> 'Tilbake',
    'LBL_CANCEL'                        => 'Avbryt',
    'LBL_ACCEPT'                        => 'Jeg aksepterer',
	'LBL_CHECKSYS_1'					=> 'In order for your SuiteCRM installation to function properly, please ensure all of the system check items listed below are green. If any are red, please take the necessary steps to fix them.<BR><BR> For help on these system checks, please visit the <a href="http://www.suitecrm.com" target="_blank">SuiteCRM</a>.',
	'LBL_CHECKSYS_CACHE'				=> 'Skrivbare undermapper for hurtiglager ',
    'LBL_DROP_DB_CONFIRM'               => 'The provided Database Name already exists.<br>You can either:<br>1.  Click on the Cancel button and choose a new database name, or <br>2.  Click the Accept button and continue.  All existing tables in the database will be dropped. <strong>This means that all of the tables and pre-existing data will be blown away.</strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned Off',
    'LBL_CHECKSYS_COMPONENT'			=> 'Komponent',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Optional Components',
	'LBL_CHECKSYS_CONFIG'				=> 'Skrivbar SuiteCRM konfigurasjonsfil (config.php)',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Writable SuiteCRM Configuration File (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'cURL-modul',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Session Save Path Setting',
	'LBL_CHECKSYS_CUSTOM'				=> 'Writeable Custom Directory',
	'LBL_CHECKSYS_DATA'					=> 'Skrivbare dataundermapper',
	'LBL_CHECKSYS_IMAP'					=> 'IMAP-modul',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'MB Strings Module',
	'LBL_CHECKSYS_MEM_OK'				=> 'OK (ingen begrensning)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'OK (ingen begrensning)',
	'LBL_CHECKSYS_MEM'					=> 'PHP Memory Limit',
	'LBL_CHECKSYS_MODULE'				=> 'Skrivbare undermapper og filer for moduler',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'MySQL Version',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'Ikke tilgjengelig',
	'LBL_CHECKSYS_OK'					=> 'OK',
	'LBL_CHECKSYS_PHP_INI'				=> 'Location of your PHP configuration file (php.ini):',
	'LBL_CHECKSYS_PHP_OK'				=> 'OK (ver',
	'LBL_CHECKSYS_PHPVER'				=> 'PHP-versjon',
    'LBL_CHECKSYS_IISVER'               => 'IIS Version',
	'LBL_CHECKSYS_RECHECK'				=> 'Sjekk på nytt',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP sikker modus er slått av',
	'LBL_CHECKSYS_SESSION'				=> 'Skrivbar sesjonslagrings-sti',
	'LBL_CHECKSYS_STATUS'				=> 'Status',
	'LBL_CHECKSYS_TITLE'				=> 'Systemsjekkgodkjennelse',
	'LBL_CHECKSYS_VER'					=> 'Found: ( ver ',
	'LBL_CHECKSYS_XML'					=> 'XML-parsing',
	'LBL_CHECKSYS_ZLIB'					=> 'ZLIB Compression Module',
	'LBL_CHECKSYS_ZIP'					=> 'ZIP Handling Module',
	'LBL_CHECKSYS_PCRE'					=> 'PCRE Library',
	'LBL_CHECKSYS_FIX_FILES'            => 'Please fix the following files or directories before proceeding:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Please fix the following module directories and the files under them before proceeding:',
    'LBL_CHECKSYS_UPLOAD'               => 'Writable Upload Directory',
    'LBL_CLOSE'							=> 'Avslutt',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'Opprettet',
	'LBL_CONFIRM_DB_TYPE'				=> 'Databasetype',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Bekreft innstillingene under. Dersom du vil endre på noen av verdiene, klikk på "Tilbake" for å endre. Dersom det ser greit ut, klikk på "Neste" for å starte installasjonen.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Lisensinformasjon',
	'LBL_CONFIRM_NOT'					=> 'ikke',
	'LBL_CONFIRM_TITLE'					=> 'Bekreft innstillinger',
	'LBL_CONFIRM_WILL'					=> 'vil',
	'LBL_DBCONF_CREATE_DB'				=> 'Opprett database',
	'LBL_DBCONF_CREATE_USER'			=> 'Ny bruker',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Advarsel: All data og informasjon i SuiteCRM<br>vill bli slettet dersom denne boksen er haket av.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Slett og gjenopprett eksisterende SuiteCRM-tabeller?',
    'LBL_DBCONF_DB_DROP'                => 'Drop Tables',
    'LBL_DBCONF_DB_NAME'				=> 'Databasenavn',
	'LBL_DBCONF_DB_PASSWORD'			=> 'SuiteCRM Database User Password',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Re-enter SuiteCRM Database User Password',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM Database User',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM Database User',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Database Administrator Username',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Database Admin Password',
	'LBL_DBCONF_DEMO_DATA'				=> 'Fyll database med demonstrasjonsdata?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Choose Demo Data',
	'LBL_DBCONF_HOST_NAME'				=> 'Tjenernavn',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Host Instance',
	'LBL_DBCONF_HOST_PORT'				=> 'Port',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Vennligst oppgi konfigurasjonsinformasjonen for databasen din under. Dersom du er usikker på hva du skal fylle inn anbefaler vi at du bruker standardverdiene.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Skal vi bruke flerbyte text i demonstrasjonsdata?',
    'LBL_DBCONFIG_MSG2'                 => 'Name of web server or machine (host) on which the database is located ( such as localhost or www.mydomain.com ):',
	'LBL_DBCONFIG_MSG2_LABEL' => 'Tjenernavn',
    'LBL_DBCONFIG_MSG3'                 => 'Name of the database that will contain the data for the SuiteCRM instance you are about to install:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'Databasenavn',
    'LBL_DBCONFIG_B_MSG1'               => 'The username and password of a database administrator who can create database tables and users and who can write to the database is necessary in order to set up the SuiteCRM database.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
    'LBL_DBCONFIG_SECURITY'             => 'For security purposes, you can specify an exclusive database user to connect to the SuiteCRM database.  This user must be able to write, update and retrieve data on the SuiteCRM database that will be created for this instance.  This user can be the database administrator specified above, or you can provide new or existing database user information.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Do it for me',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Provide existing user',
    'LBL_DBCONFIG_CREATE_DD'            => 'Define user to create',
    'LBL_DBCONFIG_SAME_DD'              => 'Same as Admin User',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'Fulltekstsøk.',
    'LBL_FTS_INSTALLED'                 => 'Installert',
    'LBL_FTS_INSTALLED_ERR1'            => 'Full Text Search capability is not installed.',
    'LBL_FTS_INSTALLED_ERR2'            => 'You can still install but will not be able to use Full Text Search functionality.  Please refer to your database server install guide on how to do this, or contact your Administrator.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Priviligert databasebruker passord',
	'LBL_DBCONF_PRIV_USER_2'			=> 'Databasebrukeren over er en priviligiert bruker?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'This privileged database user must have the proper permissions to create a database, drop/create tables, and create a user.  This privileged database user will only be used to perform these tasks as needed during the installation process.  You may also use the same database user as above if that user has sufficient privileges.',
	'LBL_DBCONF_PRIV_USER'				=> 'Priviligiert databasebrukernavn',
	'LBL_DBCONF_TITLE'					=> 'Databasekonfigurasjon',
    'LBL_DBCONF_TITLE_NAME'             => 'Provide Database Name',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Provide Database User Information',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'Bruker',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'SMTP Passord:',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Etter denne endringen har blitt gjort kan du klikke på "Start"-knappen under for å starte installasjonen. <i>Etter installasjonen er fullført vil du endre verdien for \'installer_locked\' til \'true\'.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'Instalasjonen har allerede kjørt en gang. Av sikkerhetshensyn har den blitt forhindret fra å kjøre en gang til. Dersom du er helt sikker på at du vil kjøre den på nytt, åpne config.php og finn fram til (eller legg til) en variabel kalt \'installer_locked\', og sett den til \'false\'. Linjen skal se slik ut:',
	'LBL_DISABLED_HELP_1'				=> 'For installasjonshjelp, besøk SuiteCRM',
    'LBL_DISABLED_HELP_LNK'             => 'http://www.suitecrm.com/forum/index',
	'LBL_DISABLED_HELP_2'				=> 'brukerhjelpforumene',
	'LBL_DISABLED_TITLE_2'				=> 'Installasjon av SuiteCRM har blitt slått av',
	'LBL_DISABLED_TITLE'				=> 'SuiteCRM Installasjon Avslått',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Character Set most commonly used in your locale',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Innstillinger for utadrettede e-post',
    'LBL_EMAIL_CHARSET_CONF'            => 'Character Set for Outbound Email ',
	'LBL_HELP'							=> 'Hjelp',
    'LBL_INSTALL'                       => 'Installer',
    'LBL_INSTALL_TYPE_TITLE'            => 'Installation Options',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Choose Install Type',
    'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>Typical Install</b>',
    'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>Custom Install</b>',
    'LBL_INSTALL_TYPE_MSG1'             => 'The key is required for general application functionality, but it is not required for installation. You do not need to enter the key at this time, but you will need to provide the key after you have installed the application.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Requires minimum information for the installation. Recommended for new users.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Provides additional options to set during the installation. Most of these options are also available after installation in the admin screens. Recommended for advanced users.',
	'LBL_LANG_1'						=> 'To use a language in SuiteCRM other than the default language (US-English), you can upload and install the language pack at this time. You will be able to upload and install language packs from within the SuiteCRM application as well.  If you would like to skip this step, click Next.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Installer',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Fjern',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Avinstaller',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Lad opp',
	'LBL_LANG_NO_PACKS'					=> 'ingen',
	'LBL_LANG_PACK_INSTALLED'			=> 'The following language packs have been installed: ',
	'LBL_LANG_PACK_READY'				=> 'The following language packs are ready to be installed: ',
	'LBL_LANG_SUCCESS'					=> 'The language pack was successfully uploaded.',
	'LBL_LANG_TITLE'			   		=> 'Språkpakke',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Installing SuiteCRM now.  This may take up to a few minutes.',
	'LBL_LANG_UPLOAD'					=> 'Upload a Language Pack',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Lisensgodkjenning',
    'LBL_LICENSE_CHECKING'              => 'Checking system for compatibility.',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Checking Environment',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Verifying DB Credentials.',
    'LBL_LICENSE_CHECK_PASSED'          => 'System passed check for compatibility.',
	'LBL_CREATE_CACHE' => 'Preparing to Install...',
    'LBL_LICENSE_REDIRECT'              => 'Redirecting in ',
	'LBL_LICENSE_DIRECTIONS'			=> 'Dersom du har lisensinformasjon, skriv den inn i feltene under',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Enter Download Key',
	'LBL_LICENSE_EXPIRY'				=> 'Utløpsdato',
	'LBL_LICENSE_I_ACCEPT'				=> 'Jeg aksepterer',
	'LBL_LICENSE_NUM_USERS'				=> 'Antall brukere',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Skriv inn antallet kjøpte frakoblede klienter',
	'LBL_LICENSE_OC_NUM'				=> 'Antall lisenser for Offline-klienter',
	'LBL_LICENSE_OC'					=> 'Frakoblet klientlisenser',
	'LBL_LICENSE_PRINTABLE'				=> 'Utskrivbar visning',
    'LBL_PRINT_SUMM'                    => 'Print Summary',
	'LBL_LICENSE_TITLE_2'				=> 'SuiteCRM lisens',
	'LBL_LICENSE_TITLE'					=> 'Lisensinformasjon',
	'LBL_LICENSE_USERS'					=> 'Lisensierte brukere',

	'LBL_LOCALE_CURRENCY'				=> 'Currency Settings',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Standard valuta',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Valutasymbol',
	'LBL_LOCALE_CURR_ISO'				=> 'Currency Code (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> 'Tusendelsavdeler',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Decimal Separator',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Eksempel',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Significant Digits',
	'LBL_LOCALE_DATEF'					=> 'Default Date Format',
	'LBL_LOCALE_DESC'					=> 'The specified locale settings will be reflected globally within the SuiteCRM instance.',
	'LBL_LOCALE_EXPORT'					=> 'Character Set for Import/Export<br> <i>(Email, .csv, vCard, PDF, data import)</i>',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Export (.csv) Delimiter',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Import/Export Settings',
	'LBL_LOCALE_LANG'					=> 'Default Language',
	'LBL_LOCALE_NAMEF'					=> 'Default Name Format',
	'LBL_LOCALE_NAMEF_DESC'				=> 's = salutation<br />f = first name<br />l = last name',
	'LBL_LOCALE_NAME_FIRST'				=> 'John',
	'LBL_LOCALE_NAME_LAST'				=> 'Doe',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Dr.',
	'LBL_LOCALE_TIMEF'					=> 'Default Time Format',

    'LBL_CUSTOMIZE_LOCALE'              => 'Customize Locale Settings',
	'LBL_LOCALE_UI'						=> 'Brukergrensesnitt',

	'LBL_ML_ACTION'						=> 'Handling',
	'LBL_ML_DESCRIPTION'				=> 'Beskrivelse',
	'LBL_ML_INSTALLED'					=> 'Date Installed',
	'LBL_ML_NAME'						=> 'Navn',
	'LBL_ML_PUBLISHED'					=> 'Publiseringsdato',
	'LBL_ML_TYPE'						=> 'Type',
	'LBL_ML_UNINSTALLABLE'				=> 'Kan ikke innstallere',
	'LBL_ML_VERSION'					=> 'Versjon',
	'LBL_MSSQL'							=> 'SQL Server',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver for PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (mysqli extension)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Neste',
	'LBL_NO'							=> 'Nei',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Sett opp passord for nettsideadministrator',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'Revidér tabell',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Oppretter SuiteCRM konfigurasjonsfi',
	'LBL_PERFORM_CREATE_DB_1'			=> '<b>Creating the database</b> ',
	'LBL_PERFORM_CREATE_DB_2'			=> ' <b>on</b> ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Oppretter databasebruker og passord',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Oppretter standard SuiteCRM-data',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Oppretter databasebruker og passord for localhost',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Oppretter SuiteCRM forholdstabeller',
	'LBL_PERFORM_CREATING'				=> 'oppretter /',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Oppretter standardrapporter',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Oppretter standardjobber for planlegger',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Setter inn standardinnstillinger',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Oppretter standardbrukere',
	'LBL_PERFORM_DEMO_DATA'				=> 'Populating the database tables with demo data (this may take a little while)',
	'LBL_PERFORM_DONE'					=> 'Ferdig<br>',
	'LBL_PERFORM_DROPPING'				=> 'Sletter /',
	'LBL_PERFORM_FINISH'				=> 'Slutt',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Oppdaterer lisensinformasjon',
	'LBL_PERFORM_OUTRO_1'				=> 'Oppsettet av SuiteCRM',
	'LBL_PERFORM_OUTRO_2'				=> ' is now complete!',
	'LBL_PERFORM_OUTRO_3'				=> 'Total tid:',
	'LBL_PERFORM_OUTRO_4'				=> 'sekunder',
	'LBL_PERFORM_OUTRO_5'				=> 'Omtrentlig mengde minne brukt:',
	'LBL_PERFORM_OUTRO_6'				=> 'byte',
	'LBL_PERFORM_OUTRO_7'				=> 'Systemet ditt er nå installert og configurert for bruk.',
	'LBL_PERFORM_REL_META'				=> 'forhold meta ...',
	'LBL_PERFORM_SUCCESS'				=> 'Det gikk bra!',
	'LBL_PERFORM_TABLES'				=> 'Creating SuiteCRM application tables, audit tables and relationship metadata',
	'LBL_PERFORM_TITLE'					=> 'Utfør oppsett',
	'LBL_PRINT'							=> 'Annonsering i avis/magasin',
	'LBL_REG_CONF_1'					=> 'Please complete the short form below to receive product announcements, training news, special offers and special event invitations from SuiteCRM. We do not sell, rent, share or otherwise distribute the information collected here to third parties.',
	'LBL_REG_CONF_2'					=> 'Ditt navn og e-postadresse er de eneste obligatoriske feltene for å registrere deg. Alle andre felt er valgfrie, men veldig hjelpsomme. Vi hverken selger, leier, deler eller distribuerer den innsamlede informasjonen på noen måte til noen tredjepart.',
	'LBL_REG_CONF_3'					=> 'Takk for at du registrerer deg. Klikk på Fullfør for å logge inn på SuiteCRM. Første gang du logger inn bruker du brukernavnet "admin", og passordet du skrev i andre steg.',
	'LBL_REG_TITLE'						=> 'Registrering',
    'LBL_REG_NO_THANKS'                 => 'No Thanks',
    'LBL_REG_SKIP_THIS_STEP'            => 'Skip this Step',
	'LBL_REQUIRED'						=> '* Obligatorisk felt',

    'LBL_SITECFG_ADMIN_Name'            => 'SuiteCRM Application Admin Name',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Re-enter SuiteCRM Admin User Password',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Advarsel: Dette vil overkjøre administratorpassordet fra alle tidligere installasjoner',
	'LBL_SITECFG_ADMIN_PASS'			=> 'SuiteCRM Admin User Password',
	'LBL_SITECFG_APP_ID'				=> 'Program-ID',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'If selected, you must provide an application ID to override the auto-generated ID. The ID ensures that sessions of one SuiteCRM instance are not used by other instances.  If you have a cluster of SuiteCRM installations, they all must share the same application ID.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Oppgi din egen program-ID',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'If selected, you must specify a log directory to override the default directory for the SuiteCRM log. Regardless of where the log file is located, access to it through a web browser will be restricted via an .htaccess redirect.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Bruk en alternativ loggmappe',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'If selected, you must provide a secure folder for storing SuiteCRM session information. This can be done to prevent session data from being vulnerable on shared servers.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Bruk en alternativ øktmappe for SuiteCRM',
	'LBL_SITECFG_DIRECTIONS'			=> 'Vennligst oppgi konfigurasjonsinformasjonen for nettsiden under. Dersom du er usikker på hva du skal fylle inn anbefaler vi at du bruker standardverdiene.',
	'LBL_SITECFG_FIX_ERRORS'			=> '<b>Please fix the following errors before proceeding:</b>',
	'LBL_SITECFG_LOG_DIR'				=> 'Loggmappe',
	'LBL_SITECFG_SESSION_PATH'			=> 'Sti til øktmappe<br>(må være skrivbar)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Select Security Options',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'If selected, the system will periodically check for updated versions of the application.',
	'LBL_SITECFG_SUGAR_UP'				=> 'Automatically Check For Updates?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Oppdateringskonfigurasjon for SuiteCRM',
	'LBL_SITECFG_TITLE'					=> 'Nettsidekonfigurasjon',
    'LBL_SITECFG_TITLE2'                => 'Identify Administration User',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Site Security',
	'LBL_SITECFG_URL'					=> 'URL for denne instansen av SuiteCRM',
	'LBL_SITECFG_USE_DEFAULTS'			=> 'Bruk standardverdier?',
	'LBL_SITECFG_ANONSTATS'             => 'Send Anonymous Usage Statistics?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'If selected, SuiteCRM will send <b>anonymous</b> statistics about your installation to SuiteCRM Inc. every time your system checks for new versions. This information will help us better understand how the application is used and guide improvements to the product.',
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
	'LBL_CHOOSE_LANG'					=> '<b>Choose your language</b>',
	'LBL_STEP'							=> 'Steg',
	'LBL_TITLE_WELCOME'					=> 'Velkommen til SuiteCRM',
	'LBL_WELCOME_1'						=> 'Denne installasjonen oppretter SuiteCRM databasetabellene og oppretter konfigurasjonsvariabler du trenger for å starte. Hele prosessen tar omtrent ti minutter.',
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

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '<b>Choose your language</b>',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Oppsettsveiviser',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Velkommen til SuiteCRM',
	'LBL_WELCOME_TITLE'					=> 'SuiteCRM oppsettsveiviser',
	'LBL_WIZARD_TITLE'					=> 'SuiteCRM Setup Wizard: ',
	'LBL_YES'							=> 'Ja',
    'LBL_YES_MULTI'                     => 'Yes - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Prosesser Arbeidsflytsoppgaver',
	'LBL_OOTB_REPORTS'		=> 'Kjør rapportgenerering på planlagte oppgaver',
	'LBL_OOTB_IE'			=> 'Sjekk innkommende e-post',
	'LBL_OOTB_BOUNCE'		=> 'Kjør nattlige prosesser på returnert kampanje-e-post',
    'LBL_OOTB_CAMPAIGN'		=> 'Kjør nattlige masse-e-post kampanjer',
	'LBL_OOTB_PRUNE'		=> 'Redusér databasen den første i hver måned',
    'LBL_OOTB_TRACKER'		=> 'Prune tracker tables',
    'LBL_OOTB_SUGARFEEDS'   => 'Beskjær SuiteCRM kildetabeller',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Kjør e-postpåminnelser',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Update tracker_sessions table',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Tøm jobbkø',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Fjern dokumenter fra filsystemet',


    'LBL_PATCHES_TITLE'     => 'Install Latest Patches',
    'LBL_MODULE_TITLE'      => 'Install Language Packs',
    'LBL_PATCH_1'           => 'If you would like to skip this step, click Next.',
    'LBL_PATCH_TITLE'       => 'System Patch',
    'LBL_PATCH_READY'       => 'The following patch(es) are ready to be installed:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM relies upon PHP sessions to store important information while connected to this web server.  Your PHP installation does not have the Session information correctly configured.
											<br><br>A common misconfiguration is that the <b>'session.save_path'</b> directive is not pointing to a valid directory.  <br>
											<br> Please correct your <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>PHP configuration</a> in the php.ini file located here below.",
	'LBL_SESSION_ERR_TITLE'				=> 'PHP Sessions Configuration Error',
	'LBL_SYSTEM_NAME'=>'Systemnavn',
    'LBL_COLLATION' => 'Collation Settings',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Provide a System Name for the SuiteCRM instance.',
	'LBL_PATCH_UPLOAD' => 'Select a patch file from your local computer',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Php versjon 5 eller nyere er nødvendig.',
	'LBL_MINIMUM_PHP_VERSION' => 'Minimum Php version required is 5.1.0. Recommended Php version is 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(Din nåværende php versjon er',
	'LBL_RECOMMENDED_PHP_VERSION' =>' Recommended php version is 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'Php Backward Compatibility mode er slått på. Set zend.ze1_compatibility_mode på Av for å fortsette videre.',
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

	'LBL_WIZARD_SMTP_DESC' => 'Oppgi e-postkonto som skal brukes til å sende e-post, for eksempel varsle oppdrag og passord for ny bruker. Brukerne vil motta epost fra Sugar sendt fra den angitte e-postkontoen.',
	'LBL_CHOOSE_EMAIL_PROVIDER'        => 'Velg din e-postleverandør:',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! Mail',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => 'Annen',
	'LBL_MAIL_SMTP_SETTINGS'           => 'SMTP server spesifikasjon',
	'LBL_MAIL_SMTPSERVER'				=> 'SMTP-tjener:',
	'LBL_MAIL_SMTPPORT'					=> 'SMTP Port:',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'Bruke SMTP-autentisering?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => 'Aktiver SMTP over SSL eller TLS?',
	'LBL_GMAIL_SMTPUSER'					=> 'Gmail e-postadresse:',
	'LBL_GMAIL_SMTPPASS'					=> 'Gmail passord:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => 'Tillat brukere å benytte denne kontoen for utgående e-post:',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => 'Når dette alternativet velges kan alle brukere sende e-post fra samme utgående e-post konto som brukes til å sende system-meldinger og -varsler. Hvis alternativet ikke velges, kan brukerne fortsatt benytte den utgående e-postserveren etter å ha lagt inn sin egen kontoinformasjon.',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Yahoo! e-post passord:',
	'LBL_YAHOOMAIL_SMTPUSER'					=> 'Yahoo! e-post ID',

	'LBL_EXCHANGE_SMTPPASS'					=> 'Exchange passord:',
	'LBL_EXCHANGE_SMTPUSER'					=> 'Exchange brukernavn:',
	'LBL_EXCHANGE_SMTPPORT'					=> 'Exchange Serverport:',
	'LBL_EXCHANGE_SMTPSERVER'				=> 'Exchange Server:',


	'LBL_MAIL_SMTPUSER'					=> 'SMTP-brukernavn:',
	'LBL_MAIL_SMTPPASS'					=> 'SMTP-passord:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Merking',
	'LBL_WIZARD_SYSTEM_DESC' => 'Spesifiser organisasjonens navn og logo for å merke din Sugar.',
	'SYSTEM_NAME_WIZARD'=>'Navn:',
	'SYSTEM_NAME_HELP'=>'Dette er navnet som vises i tittellinjen i nettleseren.',
	'NEW_LOGO'=>'Last opp ny logo (212x40)',
	'NEW_LOGO_HELP'=>'The image File format can be either .png or .jpg.<BR>The recommended size is 212x40 px.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'Lad opp',
	'CURRENT_LOGO'=>'Logo i bruk',
    'CURRENT_LOGO_HELP'=>'Denne logoen vises øverst i venstre hjørne i Sugar.',

	// System Local Settings


	'LBL_LOCALE_TITLE' => 'System Locale Settings',
	'LBL_WIZARD_LOCALE_DESC' => 'Angi hvordan du ønsker data i Sugar skal vises, basert på geografisk beliggenhet. Innstillingene du oppgir her vil være standardinnstillingene. Brukerne vil kunne angi sine egne preferanser.',
	'LBL_DATE_FORMAT' => 'Datoformat:',
	'LBL_TIME_FORMAT' => 'Tidsformat:',
		'LBL_TIMEZONE' => 'Tidssone:',
	'LBL_LANGUAGE'=>'Språk:',
	'LBL_CURRENCY'=>'Valuta:',
	'LBL_CURRENCY_SYMBOL'=>'Currency Symbol:',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 Currency Code:',
	'LBL_NUMBER_GROUPING_SEP' => 'Tusendels separator',
	'LBL_DECIMAL_SEP' => 'Desimaltegn',
	'LBL_NAME_FORMAT' => 'Name Format:',
	'UPLOAD_LOGO' => 'Please wait, logo uploading..',
	'ERR_UPLOAD_FILETYPE' => 'File type do not allowed, please upload a jpeg or png.',
	'ERR_LANG_UPLOAD_UNKNOWN' => 'Unknown file upload error occured.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => 'Den oppladede filen overgår den største filstørrelsen som er tillat i php.ini.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => 'Den oppladede filen overgår den største filstørrelsen som ble oppgitt i HTML-formularet.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => 'Den oppladede filen ble bare delvis oppladet.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => 'Ingen filer ble ladet opp.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => 'En tilfeldig mappe mangler.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => 'Mislyktes i å skrive filene til disken.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.',

	'LBL_INSTALL_PROCESS' => 'Install...',

	'LBL_EMAIL_ADDRESS' => 'E-post',
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
