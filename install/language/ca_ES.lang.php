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
	'LBL_BASIC_SEARCH'					=> 'Cerca bàsica',
	'LBL_ADVANCED_SEARCH'				=> 'Cerca avançada',
	'LBL_BASIC_TYPE'					=> 'Tipus bàsic',
	'LBL_ADVANCED_TYPE'					=> 'Tipus avançat',
	'LBL_SYSOPTS_1'						=> 'Seleccioni les següents opcions de configuració del sistema.',
    'LBL_SYSOPTS_2'                     => 'Quin tipus de base de dades es farà servir per a la instància de Sugar que instal·larà?',
	'LBL_SYSOPTS_CONFIG'				=> 'Configuració del Sistema',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Selecció de Base de Dades',
    'LBL_SYSOPTS_DB_TITLE'              => 'Tipus de Base de Dades',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Si us plau, corregeixi els següents errors abans de procedir:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Si us plau, modifiqui els permisos dels següents directoris per a permetre la escriptura:',
    'ERR_DB_VERSION_FAILURE'			=> 'No és pot verificar la versió de la base de dades.',
	'DEFAULT_CHARSET'					=> 'UTF-8',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Especifiqui el nom d\'usuari de l\'administrador de SuiteCRM.',
	'ERR_ADMIN_PASS_BLANK'				=> 'Introdueixi la contrasenya d\'admin de Sugar.',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'S\'han detectat errors durant les comprovacions de compatibilitat. Perquè la seva Instal·lació de SugarCRM funcioni correctament, du a terme els següents passos per corregir els problemes llistats a continuació i faci clic al botó comprovar de nou, o iniciï de nou la instal·lació, si us plau.',
    'ERR_CHECKSYS_CALL_TIME'            => '"Allow Call Time Pass Reference" està Deshabilitat (si us plau, l\'habiliti en php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'No trobat: El Planificador de Sugar tindrà funcionalitat limitada.',
    'ERR_CHECKSYS_IMAP'					=> 'No trobat: Correu electrònic entrant i Campanyes (Correu electrònic) requereixen les biblioteques d\'IMAP. Cap no serà funcional .',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC no pot ser activat quan s\'usa  MS SQL Server.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Avís: ',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> ' (Estableixi-ho a ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M o més al seu arxiu your php.ini)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Versió Mínima 4.1.2 - Trobada: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Ha ocorregut un error en escriure i llegir les variables de sessió. No s\'ha pogut procedir amb la instal·lació.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'No és un Directori Vàlid',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Avís: No és pot Escriure',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'La seva versió de PHP no està suportada per SuiteCRM. Ha d\'instal·lar una versió que sigui compatible amb l\'aplicació SuiteCRM. Si us plau, consulti la Matriu de Compatibilitat en les Notes de Llançament per a més informació sobre les versions de PHP suportades. La seva versió és ',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'La seva d\'ISS no es suportada per SuiteCRM. Haurà d\'instal·lar una versió que sigui compatible amb l\'aplicació SuiteCRM. Si us plau, consulti la llista de versions d\'ISS compatibles a les notes de la versió. La seva versió és',
	'ERR_CHECKSYS_FASTCGI'              => 'Hem detectat que no utilitza un FastCGI handler mapping per a PHP. Haurà d\'instal·lar/configurar una versió que sigui compatible amb SuiteCRM. Si us plau, consulti la llista de versions compatibles a les notes de la versió. Veure <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> per més detalls ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Per a una millor experiència amb ISS/FastCGI sapi, configuri el valor de fastcgi.logging a 0 al fitxer php.ini',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Versió de PHP Instalada No Suportada: ( veure',
    'LBL_DB_UNAVAILABLE'                => 'Base de dades no disponible',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'No s\'ha trobat el suport de base de dades. Si us plau, asseguri\'s que té els controladors necessaris per a algun dels següents tipus de Base de Dades: MySQL, MS SQLServer, o Oracle. És possible que hagi de desconectar l\'extensió a l\'arxiu php.ini, o recompilar-lo amb l\'arxiu binari apropiat, depenent de la versió de PHP. Si us plau, consulti el manual de PHP per a més informació sobre com habilitar el Suport de Base de Dades.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'Les funcions associades amb les Biblioteques d\'Anàlisi de l\'XML que són requerides per l\'aplicació Sugar no han estat trobades. És possible que hagi de descomentar l\'extensió a l\'arxiu php.ini, o recompilar-lo amb l\'arxiu binari apropiat, depenent de la versió de PHP. Si us plau, consulti el manual de PHP per a més informació.',
    'ERR_CHECKSYS_MBSTRING'             => 'Les funcions associades amb l\'extensió de PHP per a Cadenes Multibyte (mbstring) que són requerides per l\'aplicació Sugar no han estat trobades. <Br/><br/> Normalment, el mòdul mbstring no està habilitat per defecte en PHP i ha de ser activat amb --enable-mbstring en la compilació de PHP. Si us plau, consulti el manual de PHP per a més informació sobre com habilitar el suport de mbstring.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'L\'opció session.save_path del seu arxiu de configuració php (php.ini) no ha estat establerta o ha estat establerta a una carpeta que no existeix. És possible que hagi d\'establir l\'opció save_path setting en php.ini o verificar que existeix la carpeta establerta en save_path.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'L\'opció session.save_path del seu arxiu|arxivament de configuració php (php.ini) ha estat establerta a una carpeta que no és escribible. Si us plau, dugui a terme els passos necessaris per fer la carpeta escribible. < br>Dependiendo del seu Sistema Operatiu, és possible que hagi de canviar els permisos usant chmod 766, o fer clic amb el botó dret del ratolí sobre l\'arxiu per accedir a les propietats i desmarcar l\'opció de només lectura.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'El fitxer de configuració existeix però no és escribible. Si us plau, dugui a terme els passos necessaris per fer-lo escribible. Depenent del seu Sistema Operatiu, és possible que hagi de canviar els permisos usant chmod 766, o fer clic amb el botó dret del ratolí sobre l\'arxiu per accedir a les propietats i desmarcar l\'opció de només lectura.',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'L\'arxiu ha de configuració és substituïble, però no es pot escriure. Si us plau, prengui les mesures necessàries perquè el permís d\'escriptura d\'arxius. Depenent del seu sistema operatiu, això podria requerir que vostè canviï els permisos amb chmod 766, o fer clic dret sobre el nom del fitxer per accedir a les propietats i desactivi l\'opció de només lectura.',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'El Directori Custom existeix però no és escribible. És possible que hagi de canviar els seus permisos (chmod 766) o fer clic amb el botó dret del ratolí sobre ell i desmarcar l\'opció de només lectura, depenent del seu Sistema Operatiu. Si us plau, dugui a terme els passos necessaris perquè l\'arxiu sigui escribible.',
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "Els següents arxius o directoris no són escribibles o no existeixen i no poden ser creats. Depenent del seu Sistema Operatiu, corregir això requerirà canviar els permisos als arxius o en el seu directori pare (chmod 766), o fer clic amb el botó dret en el directori pare i desmarcar l'opció 'només lectura' i aplicar-la a totes les subcarpetes.",
    'LBL_CHECKSYS_OVERRIDE_CONFIG' => 'Sobreescriure configuració',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'La Manera Segura està activada (si us plau, deshabiliti\'l en php.ini)',
    'ERR_CHECKSYS_ZLIB'					=> 'No trobat: SugarCRM obté grans beneficis de rendiment amb compressió zlib. ',
    'ERR_CHECKSYS_ZIP'					=> 'No s\'ha trobat suport ZIP: SuiteCRM necessita suport ZIP per a poder processar els arxius comprimits.',
    'ERR_CHECKSYS_PCRE'					=> 'No s\'ha trobat la llibreria PCRE: SuiteCRM necessita la llibreria PCRE per a poder processar expressions regulars en format Perl.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'Versió de llibreria PCRE: SuiteCRM necessita la versió 7.0 o més gran, per a poder processar expressions regulars en format Perl.',
	'ERR_DB_ADMIN'						=> 'El nom d\'usuari o contrasenya de l\'administrador de base de dades no són vàlids, i la connexió a base de dades no ha pogut ser establerta. Si us plau, introdueixi un nom d\'usuari i contrasenya vàlids. (Error: ',
    'ERR_DB_ADMIN_MSSQL'                => 'El nom d\'usuari o contrasenya de l\'administrador de base de dades no són vàlids, i la connexió a base de dades no ha pogut ser establerta. Si us plau, introdueixi un nom d\'usuari i contrasenya vàlids.',
	'ERR_DB_EXISTS_NOT'					=> 'La base de dades especificada no existeix.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'La base de dades ja existeix i conté dades de configuració. Per executar una instal·lació amb la base de dades elegida, si us plau, executi de nou la instal·lació i seleccioni: " Esborrar i crear de nou les taules|posts de SugarCRM? " Per actualitzar, utilitzi l\'Assistent d\'Actualitzacions a la Consola d\'Administració. Si us plau, llegeixi la documentació referent a actualitzacions < a href="http://www.sugarforge.org/content/downloads/" target="_new">aquí</a >.',
	'ERR_DB_EXISTS'						=> 'El nom de base de dades subministrat ja existeix -- no pot crear-se\'n cap altra amb el mateix nom.',
    'ERR_DB_EXISTS_PROCEED'             => 'El nom de base de dades subministrat ja existeix. Pot<br>1. prémer el botó Enrera i triar un nou nom < br>2. fer clic a Següent i continuar, però totes les taules|posts existents en aquesta base de dades seran eliminades. <strong>Això implica que les seves taules|posts i dades seran eliminades permanentemente.</strong >',
	'ERR_DB_HOSTNAME'					=> 'El nom d\'equip no pot ser buit.',
	'ERR_DB_INVALID'					=> 'El tipus de base de dades seleccionada no és vàlida.',
	'ERR_DB_LOGIN_FAILURE'				=> 'El nom d\'usuari o contrasenya de base de dades no són vàlids, i la connexió a base de dades no ha pogut ser establerta. Si us plau, introdueixi un nom d\'usuari i contrasenya vàlids. (Error: ',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'El nom d\'usuari o contrasenya de base de dades no són vàlids, i la connexió a base de dades no ha pogut ser establerta. Si us plau, introdueixi un nom d\'usuari i contrasenya vàlids. (Error: ',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'El nom d\'usuari o contrasenya de base de dades no són vàlids, i la connexió a base de dades no ha pogut ser establerta. Si us plau, introdueixi un nom d\'usuari i contrasenya vàlids. (Error: ',
	'ERR_DB_MYSQL_VERSION'				=> 'La seva versió de MySQL (%s) no és suportada per SuiteCRM. Haurà d\'instal·lar una versió que sigui compatible. SI us plau, consulti el llistat de versions compatibles a les notes de la versió.',
	'ERR_DB_NAME'						=> 'El nom de base de dades no pot ser buit.',
	'ERR_DB_NAME2'						=> "El nom de base de dades no pot contenir els caràcters '\\', / ', o '. '",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "El nom de base de dades no pot contenir els caràcters '\\', / ', o '. '",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "El nom de la base de dades no pot començar amb un número, '#', or '@' i no pot contenir espais, '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', '&', '!', or '-'",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "El nom de la base de dades només pot estar format per caràcters alfanumèrics i els símbols '#', '_' or '$'",
	'ERR_DB_PASSWORD'					=> 'Les contrasenyes introduïdes per a l\'administrador de base de dades de Sugar no coincideixen. Si us plau, introdueixi de nou la mateixa contrasenya en els camps de contrasenya.',
	'ERR_DB_PRIV_USER'					=> 'Introdueixi un nom d\'usuari de base de dades. L\'usuari és necessari per a la connexió inicial a la base de dades.',
	'ERR_DB_USER_EXISTS'				=> 'El nom d\'usuari per a la base de dades de Sugar ja existeix -- no és possible crear-ne un altre amb el mateix nom. Si us plau, introdueixi un nou nom d\'usuari.',
	'ERR_DB_USER'						=> 'Introdueixi un nom d\'usuari per a l\'administrador de la base de dades de Sugar.',
	'ERR_DBCONF_VALIDATION'				=> 'Si us plau, corregeixi els següents errors abans de continuar:',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'Les contrasenyes introduïdes per a l\'usuari de base de dades de Sugar no coincideixen. Si us plau, introdueixi de nou la mateixa contrasenya en els camps de contrasenya.',
	'ERR_ERROR_GENERAL'					=> 'S\'han trobat els següents errors:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'L\'arxiu no pot ser eliminat: ',
	'ERR_LANG_MISSING_FILE'				=> 'L\'arxiu no pot ser eliminat: ',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'No s\'ha trobat un paquet de llenguatge en include/language dins de: ',
	'ERR_LANG_UPLOAD_1'					=> 'Ha ocorregut un problema amb la seva pujada d\'arxiu. Si us plau, intenti-ho de nou.',
	'ERR_LANG_UPLOAD_2'					=> 'Els paquets de llenguatge han de ser arxius ZIP.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP no ha pogut moure l\'arxiu temporal al directori d\'actualitzacions.',
	'ERR_LICENSE_MISSING'				=> 'Falten Camps Requerits',
	'ERR_LICENSE_NOT_FOUND'				=> 'No s\'ha trobat l\'arxiu de llicència!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'El directori de traces indicat no és un directori vàlid.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'El directori de traces indicat no és un directori escribible.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Es requereix un directori de traces si desitja indicar-ne un de personalitzat.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'No s\'ha pogut processar el script directament.',
	'ERR_NO_SINGLE_QUOTE'				=> 'No pot utilitzar-se les cometes simples per a ',
	'ERR_PASSWORD_MISMATCH'				=> 'Les claus de pas introduïdes per a l\'usuari administrador de Sugar no coincideixen. Si us plau, introdueixi de nou la mateixa contrasenya en els camps de contrasenya.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'No ha pogut escriure\'s a l\'arxiu <span class=stop>config.php</span >.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Pot continuar aquesta instal·lació creant manualment l\'arxiu config.php i pegant la informació de configuració indicada a continuació a l\'arxiu config.php. Sense embargament, < strong>te que </strong>crear l\'arxiu config.php abans d\'avançar al següent pas.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'Va recordar crear l\'arxiu config.php?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Avís: No ha pogut escriure\'s a l\'arxiu config.php. Si us plau, asseguri\'s que existeix.',
	'ERR_PERFORM_HTACCESS_1'			=> 'No ha pogut escriure\'s a l\'arxiu ',
	'ERR_PERFORM_HTACCESS_2'			=> ' .',
	'ERR_PERFORM_HTACCESS_3'			=> 'Si vol securitzar el seu arxiu de traces, per evitar que sigui accessible mitjançant el navegador web, crei un arxiu .htaccess en el seu directori de traces amb la línia:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>No s\'ha pogut detectar una connexió a internet.</b>Si us plau, quan en disposi d\'una, visiti <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> per registrarse amb SugarCRM. Permetent-nos saber una mica sobre els plans de la seva companyia per utilitzar SugarCRM, podem assegurar-nos que sempre estem subministrant el producte adequat per a les necessitats del seu negoci.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'El directori de sessió indicat no és un directori vàlid.',
	'ERR_SESSION_DIRECTORY'				=> 'El directori de sessió indicat no és un directori escribible.',
	'ERR_SESSION_PATH'					=> 'Es requereix un directori de sessió si desitja indicar-ne un de personalitzat.',
	'ERR_SI_NO_CONFIG'					=> 'No ha inclòs config_si.php a la carpeta arrel de documents, o no ha definit $sugar_config_si en config.php',
	'ERR_SITE_GUID'						=> 'Es requereix un ID d\'Aplicació si desitja indicar-ne un personalitzat.',
    'ERROR_SPRITE_SUPPORT'              => "No hem pogut trobar la llibreria GD, en conseqüència no es podrà utilitzar la funcionalitat CSS Sprite.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Avís: La seva configuració de PHP hauria de ser canviada per permetre pujades d\'arxius d\'almenys 6 MB .',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Mida per a Pujada d\'Arxius',
	'ERR_URL_BLANK'						=> 'Introdueix l\'URL base per a la instància de Sugar.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'No s\'ha localitzat el registre d\'instal·lació de',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'L\'arxiu pujat no és compatible amb aquesta edició (Community Edition, Professional, o Enterprise) de Sugar: ',
	'ERROR_LICENSE_EXPIRED'				=> "Error: La seva llicència va caducar fa ",
	'ERROR_LICENSE_EXPIRED2'			=> " dia(s). Si us plau, vagi a la <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administració de Llicències\"</a >, a la pantalla d'Administració, per introduir la seva nova clau de llicència. Si no introdueix una nova clau de llicència en 30 dies a partir de la caducitat de la seva clau de llicència, no podrà iniciar la sessió en aquesta aplicació.",
	'ERROR_MANIFEST_TYPE'				=> 'L\'arxiu de manifest ha d\'especificar el tipus de paquet.',
	'ERROR_PACKAGE_TYPE'				=> 'L\'arxiu de manifest deu especificar un tipus de paquet no reconegut',
	'ERROR_VALIDATION_EXPIRED'			=> "Error: La seva clau de validació va caducar fa ",
	'ERROR_VALIDATION_EXPIRED2'			=> " dia(s). Si us plau, vagi a la <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administració de Llicències\"</a >, a la pantalla d'Administració, per introduir la seva nova clau de validació. Si no introdueix una nova clau de validació en 30 dies a partir de la caducitat de la seva clau de validació, no podrà iniciar la sessió en aquesta aplicació.",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'L\'arxiu pujat no és compatible amb aquesta versió de ',

	'LBL_BACK'							=> 'Enrere',
    'LBL_CANCEL'                        => 'Cancel·lar',
    'LBL_ACCEPT'                        => 'Accepto',
	'LBL_CHECKSYS_1'					=> 'Perquè la seva instal·lació de SugarCRM funcioni correctament, s\'asseguri que tots els elements de comprovació llistats a continuació estan en verd. Si algun està en vermell|roig, si us plau, realitzi els passos necessaris per corregir-los. < BR><BR > Per trobar ajut sobre aquestes comprovacions del sistema, si us plau visiti el <a href="http://www.sugarcrm.com/crm/installation" target="_blank">Sugar Wiki</a >',
	'LBL_CHECKSYS_CACHE'				=> 'Subdirectoris de Caché Escribibles',
    'LBL_DROP_DB_CONFIRM'               => 'El Nom de Base de dades subministrat ja existeix.<br>Te les següents opcions:<br>1. Fer clic al botó Cancelar i seleccionar un nou nom de base de dades, o < br>2. Fer clic al botó Acceptar i continuar. Totes les taules|posts existents en la base de dades seran eliminades. < strong>Això implica que totes les seves taules|posts i dades actuals desapareixeran.</strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned Off',
    'LBL_CHECKSYS_COMPONENT'			=> 'Component',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Components Opcionals',
	'LBL_CHECKSYS_CONFIG'				=> 'Arxiu de Configuració de SugarCRM (config.php) Escribible',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Fitxer modificable de configuració de SuiteCRM (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'Mòdul cURL',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Configuració de la Ruta d\'Emmagatzemament de Sessions',
	'LBL_CHECKSYS_CUSTOM'				=> 'Directori Personalizat (custom) Escribible',
	'LBL_CHECKSYS_DATA'					=> 'Subdirectoris de Dades Escribibles',
	'LBL_CHECKSYS_IMAP'					=> 'Mòdul IMAP',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'Mòdulo de Cadenes MB',
	'LBL_CHECKSYS_MEM_OK'				=> 'Correcte (Sense Límit)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'Correcte (Sense Límit)',
	'LBL_CHECKSYS_MEM'					=> 'Límit de Memòria PHP >= ',
	'LBL_CHECKSYS_MODULE'				=> 'Subdirectoris i Arxius de Mòduls Escribibles',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'Versió de MySQL',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'No Disponible',
	'LBL_CHECKSYS_OK'					=> 'Correcte',
	'LBL_CHECKSYS_PHP_INI'				=> '<b>Nota:</b> ﻿El seu arxiu de configuració de PHP (php.ini) està',
	'LBL_CHECKSYS_PHP_OK'				=> 'Correcte (veure ',
	'LBL_CHECKSYS_PHPVER'				=> 'Versió de PHP',
    'LBL_CHECKSYS_IISVER'               => 'Versió d\'ISS',
	'LBL_CHECKSYS_RECHECK'				=> 'Comprovar de nou',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'Manera Segura de PHP Deshabilitat',
	'LBL_CHECKSYS_SESSION'				=> 'Ruta d\'Emmagatzemament de Sessió Escribible (',
	'LBL_CHECKSYS_STATUS'				=> 'Estat',
	'LBL_CHECKSYS_TITLE'				=> 'Acceptació de Comprovacions del Sistema',
	'LBL_CHECKSYS_VER'					=> 'Trobat: ( veure ',
	'LBL_CHECKSYS_XML'					=> 'Anàlisis XML',
	'LBL_CHECKSYS_ZLIB'					=> 'Mòdul de Compressió ZLIB',
	'LBL_CHECKSYS_ZIP'					=> 'Módul de manipulació de ZIP',
	'LBL_CHECKSYS_PCRE'					=> 'Llibreria PCRE',
	'LBL_CHECKSYS_FIX_FILES'            => 'Si us plau, corregeixi els següents arxius o directoris abans de continuar:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Si us plau, corregeixi els següents directoris de mòduls i els arxius en ells continguts abans de continuar: ',
    'LBL_CHECKSYS_UPLOAD'               => 'Directori de pujades amb permisos d\'escriptura',
    'LBL_CLOSE'							=> 'Tancar',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'serà creat',
	'LBL_CONFIRM_DB_TYPE'				=> 'Tipus de Base de Dades',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Si us plau, confirmi la següent configuració. Si desitja canviar qualsevol dels valors, faci clic en "Enrere" per editar-los. En un altre cas, faci clic en "Següent" per iniciar la instal·lació.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Informació de Llicència',
	'LBL_CONFIRM_NOT'					=> 'no',
	'LBL_CONFIRM_TITLE'					=> 'Confirmar Configuració',
	'LBL_CONFIRM_WILL'					=> 'serà',
	'LBL_DBCONF_CREATE_DB'				=> 'Crear Base de dades',
	'LBL_DBCONF_CREATE_USER'			=> 'Crear Usuari',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Advertència: Tots les dades de Sugar seran eliminados<br>si es marca aquesta opció.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Esborrar les taules de Sugar actuals i crear-les de nou?',
    'LBL_DBCONF_DB_DROP'                => 'Esborrar Taules',
    'LBL_DBCONF_DB_NAME'				=> 'Nom de Base de dades',
	'LBL_DBCONF_DB_PASSWORD'			=> 'Contrasenya de l\'Usuari de Base de dades de Sugar',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Introdueixi de nou la Clau de Pas de l\'Usuari de Base de dades de Sugar',
	'LBL_DBCONF_DB_USER'				=> 'Usuari de la base de dades de SuiteCRM',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'Usuari de la base de dades de SuiteCRM',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Nom d´usuari de l´Administrador de Base de Dades',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Contrasenya del Administrador de Base de dades',
	'LBL_DBCONF_DEMO_DATA'				=> 'Introduir Dades de Demostració en la Base de Dades?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Seleccioni les Dades de Demo',
	'LBL_DBCONF_HOST_NAME'				=> 'Nom de Equip',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'instancia del host',
	'LBL_DBCONF_HOST_PORT'				=> 'Port',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Si us plau, introdueixi la informació de configuració de la seva base de dades a continuació. Si no està segur de quines dades utilitzar, li suggerim que utilitzi els valors per defecte.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Utilitzar text multibyte en dades de demostració?',
    'LBL_DBCONFIG_MSG2'                 => 'Nom del servidor web o màquina (equip) en el qual la base de dades està ubicada:',
	'LBL_DBCONFIG_MSG2_LABEL' => 'Nom de Equip',
    'LBL_DBCONFIG_MSG3'                 => 'Nom de la base de dades que acollirà les dades de la instància de SuiteCRM que instal·larà:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'Nom de Base de dades',
    'LBL_DBCONFIG_B_MSG1'               => 'Per configurar la base de dades de Sugar, és necessari el nom d\'usuari i contrasenya de l\'administrador de base de dades que pot crear taules|posts de base de dades i usarios i que pot escriure a la base de dades.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
    'LBL_DBCONFIG_SECURITY'             => 'Per motius de seguretat, pot especificar un usuari de base de dades exclusiu per connectar-se a la base de dades de Sugar. Aquest usuari ha de ser capaç d\'escriure, actualitzar i recuparar dades en la base de dades de Sugar que serà creada per a aquesta instància. Aquest usuari pot ser l\'administrador de base de dades anteriorment especificat, o pot introduir la informació d\'un usuari de base de dades nou o existent.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Ho faci per mi',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Introdueixi un usuari existent',
    'LBL_DBCONFIG_CREATE_DD'            => 'Defineixi l\'usuari a crear',
    'LBL_DBCONFIG_SAME_DD'              => 'El mateix que l\'usuari Administrador',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'Cerca de text complet',
    'LBL_FTS_INSTALLED'                 => 'Instal·lat',
    'LBL_FTS_INSTALLED_ERR1'            => 'La cerca de text complet no està instal·lada.',
    'LBL_FTS_INSTALLED_ERR2'            => 'Pot realitzar la instal·lació, però no podrà utilitzar la cerca de text complet. Si us plau, consulti la guia d\'instal·lació o contacti amb el seu Administrador.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Contrasenya d\'Usuari Privilegiat de Base de dades',
	'LBL_DBCONF_PRIV_USER_2'			=> 'Correspon al Compte de Base de dades Anterior a un Usuari Privilegiat?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'Aquest usuari privilegiat de base de dades ha de tenir els permisos adequats per crear una base de dades, eliminar/crear taules|posts, i crear un usuari. Aquest usuari privilegiat de base de dades només s\'utilitzarà per realitzar aquestes tasques segons siguin necessàries durant el procés d\'instal·lació. També pot utilitzar el mateix usuari de base de dades anterior si té els privilegis suficients.',
	'LBL_DBCONF_PRIV_USER'				=> 'Nom de l\'Usuari Privilegiat de Base de dades',
	'LBL_DBCONF_TITLE'					=> 'Configuració de Base de dades',
    'LBL_DBCONF_TITLE_NAME'             => 'Introdueixi el Nom de Base de Dades',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Introdueixi la Informació d\'Usuari de Base de Dades',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'Usuari',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'Clau de pas',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Després que s\'hagi realitzat aquest canvi, pot fer clic al botó "Iniciar" situat a baix, per iniciar la seva instal·lació. < i>Una vegada s\'hagi completat la instal·lació, és probable que desitgi canviar el valor per a la variable \'installer_locked\' a \'true\'.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'L\'instal·lador ja ha estat executat. Com a mesura de seguretat, s\'ha deshabilitat perquè no sigui executat per segona vegada. Si està totalment segur que desitja executar-lo de nou, si us plau vagi al seu arxiu config.php i localitzi (o afegeixi) una variable cridada \'installer_locked\' i l\'estableixi a \'false\'. La línia hauria de quedar com el següent:',
	'LBL_DISABLED_HELP_1'				=> 'Per a ajut sobre la instal·lació, si us plau visiti els fòrums de suport de SugarCRM',
    'LBL_DISABLED_HELP_LNK'             => 'http://www.sugarcrm.com/forums/',
	'LBL_DISABLED_HELP_2'				=> 'forum de suport',
	'LBL_DISABLED_TITLE_2'				=> 'La Instal·lació de SugarCRM ha estat Deshabilitada',
	'LBL_DISABLED_TITLE'				=> 'Instal·lació de SugarCRM Deshabilitada',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Joc de caràcters més utilitzat en la seva configuració regional',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Configuració de correu electrònic sortint',
    'LBL_EMAIL_CHARSET_CONF'            => 'Joc de caràcters per correu electrònic sortint',
	'LBL_HELP'							=> 'Ajuda',
    'LBL_INSTALL'                       => 'Instal·lar',
    'LBL_INSTALL_TYPE_TITLE'            => 'Opcions d\'instal·lació',
    'LBL_INSTALL_TYPE_SUBTITLE'         => '﻿Seleccioni un Tipus d\'Instal·lació',
    'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>Instal·lació Típica</b>',
    'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>Instal·lació Personalitzada</b>',
    'LBL_INSTALL_TYPE_MSG1'             => 'La clau es requereix per a la funcionalitat general de l\'aplicació, però no és necessària per a la instal·lació. No necessita introduir una clau vàlida en aquests moments, però haurà d\'introduir-la després de la instal·lació de l\'aplicació.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Requereix la mínima informació possible per a la instal·lació. Recomanada per a usuaris faci una novació de ells.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Proveeix opcions addicionals a establir durant la instal·lació. La majoria d\'aquestes estan també disponibles després de la instal·lació a les pantalles d\'adminitración. Recomanat per a usuaris avançats.',
	'LBL_LANG_1'						=> 'Per utilitzar un llenguatge a Sugar diferent al del llenguatge per defecte (Anglès EUA), pot pujar i instal·lar ara el paquet de llenguatge. També podrà pujar i instal·lar paquets de llenguatge des de l\'aplicació Sugar. Si vol saltar-se aquest pas, faci clic a Següent.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Procedir',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Treure',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Desinstal·lar',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Pujar',
	'LBL_LANG_NO_PACKS'					=> 'cap',
	'LBL_LANG_PACK_INSTALLED'			=> 'Els següents paquets de llenguatge han estat instal·lats: ',
	'LBL_LANG_PACK_READY'				=> 'Els següents paquets de llenguatge són llestos per ser instal·lats: ',
	'LBL_LANG_SUCCESS'					=> 'El paquet de llenguatge ha estat pujat amb èxit.',
	'LBL_LANG_TITLE'			   		=> 'Paquet de Llenguatge',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Instal·lant SuiteCRM. Aquest procés pot tardar uns minuts.',
	'LBL_LANG_UPLOAD'					=> 'Pujar un Paquet de Llenguatge',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Aceptació de Llicència',
    'LBL_LICENSE_CHECKING'              => 'Fent comprobacions de compatibilitat del sistema.',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Comprovant Entorn',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Validant Credenciales de BD.',
    'LBL_LICENSE_CHECK_PASSED'          => 'El sistema ha pasat les proves de compatibilitat.',
	'LBL_CREATE_CACHE' => 'Preparant per a instal·lar...',
    'LBL_LICENSE_REDIRECT'              => 'Redirigint a ',
	'LBL_LICENSE_DIRECTIONS'			=> 'Si té informació sobre el seu llicència, si us plau introdueixi-la en els següents camps.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Introdueixi clau de descàrrega',
	'LBL_LICENSE_EXPIRY'				=> 'Data de Caducitat',
	'LBL_LICENSE_I_ACCEPT'				=> 'Accepto',
	'LBL_LICENSE_NUM_USERS'				=> 'Nùmero d\'Usuaris',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Si us plau, introdueixi el nom de clients desconnectats adquirits.',
	'LBL_LICENSE_OC_NUM'				=> 'Nombre de Llicències de Client Desconnectat',
	'LBL_LICENSE_OC'					=> 'Llicències de Client Desconectat',
	'LBL_LICENSE_PRINTABLE'				=> ' Vista Imprimible ',
    'LBL_PRINT_SUMM'                    => 'Imprimir Resum',
	'LBL_LICENSE_TITLE_2'				=> 'Llicència de SugarCRM',
	'LBL_LICENSE_TITLE'					=> 'Informació de Llicència',
	'LBL_LICENSE_USERS'					=> 'Usuaris amb Llicència',

	'LBL_LOCALE_CURRENCY'				=> 'Configuració de Moneda',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Moneda per Defecte',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Símbol de Moneda',
	'LBL_LOCALE_CURR_ISO'				=> 'Codi de moneda (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> 'Separador de milers',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Separador Decimal',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Exemple',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Dígits Significaus',
	'LBL_LOCALE_DATEF'					=> 'Format de Data per Defecte',
	'LBL_LOCALE_DESC'					=> 'Les opcions de configuració regional especificades es reflectirà a nivell global en la instància de Sugar.',
	'LBL_LOCALE_EXPORT'					=> 'Joc de caràcters d\'Importació/Exportació < i>(Correu electrònic, .csv, vCard, PDF, importació de dades)</i >',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Delimitador per a Exportació (.csv)',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Configuració d\'Importació/Exportació',
	'LBL_LOCALE_LANG'					=> 'Llenguatge per Defecte',
	'LBL_LOCALE_NAMEF'					=> 'Format de Nom per Defecte',
	'LBL_LOCALE_NAMEF_DESC'				=> 's Títol<br />f Nom<br />l Cognom',
	'LBL_LOCALE_NAME_FIRST'				=> 'Joan',
	'LBL_LOCALE_NAME_LAST'				=> 'Pérez',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Sr.',
	'LBL_LOCALE_TIMEF'					=> 'Format d\'Hora per Defecte',

    'LBL_CUSTOMIZE_LOCALE'              => 'Personalizar Configuració Regional',
	'LBL_LOCALE_UI'						=> 'Interfície d\'Usuari',

	'LBL_ML_ACTION'						=> 'Acció',
	'LBL_ML_DESCRIPTION'				=> 'Descripció',
	'LBL_ML_INSTALLED'					=> 'Data d\'Instal·lació',
	'LBL_ML_NAME'						=> 'Nom',
	'LBL_ML_PUBLISHED'					=> 'Data de Publicació',
	'LBL_ML_TYPE'						=> 'Tipus',
	'LBL_ML_UNINSTALLABLE'				=> 'No desinstalable',
	'LBL_ML_VERSION'					=> 'Versió',
	'LBL_MSSQL'							=> 'Servidor SQL',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver per a PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (extensió mysqli)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Següent',
	'LBL_NO'							=> 'No',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Establint la clau de pas de l\'admin del lloc',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'taula d\'auditoria / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Creant l\'arxiu de configuració de Sugar',
	'LBL_PERFORM_CREATE_DB_1'			=> '<b>Creant la base de dades</b> ',
	'LBL_PERFORM_CREATE_DB_2'			=> ' <b>a</b> ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Creant l\'usuari i la clau de pas de Base de Dades...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Creant dades de Sugar predeterminats',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Creant l\'usuari i la contrasenya de Base de Dades per a localhost...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Creant taules de relacions de Sugar',
	'LBL_PERFORM_CREATING'				=> 'creant / ',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Creant informes predefinits',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Creant treballs del planificador per defecte',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Inserint configuració per defecte',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Creant usuaris per defecte',
	'LBL_PERFORM_DEMO_DATA'				=> 'Inserint a les taules de base de dades dades de demostració (això pot portar una estona)',
	'LBL_PERFORM_DONE'					=> 'fet<br>',
	'LBL_PERFORM_DROPPING'				=> 'esborrant / ',
	'LBL_PERFORM_FINISH'				=> 'Finalitzat',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Actualizant informació de llicència',
	'LBL_PERFORM_OUTRO_1'				=> 'La instal·lació de Sugar ',
	'LBL_PERFORM_OUTRO_2'				=> ' ha estat completada.',
	'LBL_PERFORM_OUTRO_3'				=> 'Temps total: ',
	'LBL_PERFORM_OUTRO_4'				=> ' segons.',
	'LBL_PERFORM_OUTRO_5'				=> 'Memòria utilitza aproximadament: ',
	'LBL_PERFORM_OUTRO_6'				=> ' bytes.',
	'LBL_PERFORM_OUTRO_7'				=> 'El seu sistema ha estat instal·lat i configurat per al seu ús.',
	'LBL_PERFORM_REL_META'				=> 'metadades de relacions ... ',
	'LBL_PERFORM_SUCCESS'				=> '¡Èxit!',
	'LBL_PERFORM_TABLES'				=> 'Creant les tables d\'aplicació de Sugar, taules|posts d\'auditoria, i metadades de relacions',
	'LBL_PERFORM_TITLE'					=> 'Realitzar Instal·lació',
	'LBL_PRINT'							=> 'Imprimir',
	'LBL_REG_CONF_1'					=> 'Si us plau, completi el següent breu formulari per rebre anuncis sobre el producte, notícies sobre formació, ofertes especials i invitacions especials a esdeveniments de SugarCRM. No venem, lloguem, compartim, o distribuïm de cap altra manera a terceres parts la informació aquí recollida.',
	'LBL_REG_CONF_2'					=> 'El seu nom i direcció de correu electrònic són els únics camps requerits per al registre. La resta de camps són opcionals, però de molt valor. No venem, lloguem, compartim, o en distribuïm en manera algun la informació aquí recollida a tercers.',
	'LBL_REG_CONF_3'					=> 'Gràcies per registrar-se. Faci clic al botó Finalitzar per iniciar una sessió en SugarCRM. Necessitarà iniciar la sessió per primera vegada utilitzant el nom d\'usuari "admin" i la contrasenya que va introduir al pas 2.',
	'LBL_REG_TITLE'						=> 'Registre',
    'LBL_REG_NO_THANKS'                 => 'No Gràcies',
    'LBL_REG_SKIP_THIS_STEP'            => 'Saltar aquest Pas',
	'LBL_REQUIRED'						=> '* Camp requerit',

    'LBL_SITECFG_ADMIN_Name'            => 'Nom del Administrador de la Aplicació Sugar',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Introdueixi de nou la Contrasenya de l\'Usuari Admin de Sugar',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Precaució: Això substituirà la contrasenya d\'admin de qualsevol instal·lació prèvia.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'Clau de pas del Usuari Admin de Sugar',
	'LBL_SITECFG_APP_ID'				=> 'ID d\'Aplicació',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'Si està seleccionat, ha d\'introduir un ID d\'aplicació per substituir a l\'ID autogenerat. L\'ID assegura que les sessions d\'una instància de Sugar no són utilitzades per altres instàncies. Si té un clúster|grup de sectors d\'instal·lacions Sugar, totes han de compartir el mateix ID d\'aplicació.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Proveir el Seu Propi ID d\'Aplicació',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'Si està seleccionat, ha d\'especificar un directori de registre per substituir al directori per defecte de registre de Sugar. Independentment d\'on resideixi l\'arxiu de registre, l\'accés al mateix a través del navegador serà restringit mitjançant una redirecció definida en un arxiu .htaccess.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Usar un Directori Personalitzat de Traces',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'Si està seleccionat, ha d\'especificar una carpeta segura per emmagatzemar la informació de les sessions de Sugar. Això es fa per evitar que les dades de la sessió siguin vulnerables en servidors compartits.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Utilitzar un Directori Personalitzat de Sessions per a Sugar',
	'LBL_SITECFG_DIRECTIONS'			=> 'Si us plau, introdueixi la informació de configuració del seu lloc a continuació. Si no està segur del significat dels camps, li suggerim que utilitzi els valors per defecte.',
	'LBL_SITECFG_FIX_ERRORS'			=> '<b>Si us plau, corregeixi els següents errors abans de continuar:</b>',
	'LBL_SITECFG_LOG_DIR'				=> 'Directori de Traces',
	'LBL_SITECFG_SESSION_PATH'			=> 'Ruta al Directori de Sessions<br>(te que ser escribible)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Seleccioni Opcions de Seguretat',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'Si està seleccionat, el sistema comprovarà periòdicament si hi ha disponibles versions actualitzades de l\'aplicació.',
	'LBL_SITECFG_SUGAR_UP'				=> 'Comprovar Automáticament Actualizacions?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Configuració d\'Actualizacions de Sugar',
	'LBL_SITECFG_TITLE'					=> 'Configuració del Lloc',
    'LBL_SITECFG_TITLE2'                => 'Identifiqui la seva Instància de Sugar',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Seguretat del Lloc',
	'LBL_SITECFG_URL'					=> 'URL de la Instància de Sugar',
	'LBL_SITECFG_USE_DEFAULTS'			=> 'Usar valors per defecte?',
	'LBL_SITECFG_ANONSTATS'             => 'Enviar Estadístiques d\'Ús Anònimes?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'Si està seleccionat, Sugar enviarà estadístiques anònimes sobre la seva instal·lació a SugarCRM Inc. cada vegada que el seu sistema comprovi l\'existència de noves versions. Aquesta informació ens ajudarà a entendre millor com l\'aplicació és usada i guiar així les millores al producte.',
    'LBL_SITECFG_URL_MSG'               => 'Introdueixi l\'URL que serà utilitzat per accedir a la instància de Sugar després de la instal·lació. Aquest URL també s\'usarà com a base per als URLs de les pàgines de l\'aplicació Sugar. L\'URL hauria d\'incloure el nom de servidor web o màquina, o el seu direcció IP.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Introdueixi un nom per al seu sistema. Aquest nom es mostrarà a la barra de títol del navegador quan els usuaris visitin l\'aplicació Sugar.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'Després de la instal·lació, necessitarà usar l\'usuari administrador de Sugar (nom d\'usuari = admin) per iniciar la sessió en la instància de Sugar. Introdueixi una contrasenya per a aquest usuari administrador. Aquesta contrasenya pot ser canviada després de l\'inici de sessió inicial.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Select collation (sorting) settings for your system. This settings will create the tables with the specific language you use. In case your language doesn\'t require special settings please use default value.',
    'LBL_SPRITE_SUPPORT'                => 'Suport d\'Sprite',
	'LBL_SYSTEM_CREDS'                  => 'Credencials del Sistema',
    'LBL_SYSTEM_ENV'                    => 'Entorn del Sistema',
	'LBL_START'							=> 'Iniciar',
    'LBL_SHOW_PASS'                     => 'Mostrar Contrasenyes',
    'LBL_HIDE_PASS'                     => 'Amagar Contrasenyes',
    'LBL_HIDDEN'                        => '<i>(ocult)</i>',
	'LBL_STEP1' => 'Pas 1 de 2 - Requisits previs a la instal·lació',
	'LBL_STEP2' => 'Pas 2 de 2 - Configuració',
//    'LBL_STEP1'                         => 'Step 1 of 8 - Pre-Installation requirements',
//    'LBL_STEP2'                         => 'Step 2 of 8 - License Agreement',
//    'LBL_STEP3'                         => 'Step 3 of 8 - Installation Type',
//    'LBL_STEP4'                         => 'Step 4 of 8 - Database Selection',
//    'LBL_STEP5'                         => 'Step 5 of 8 - Database Configuration',
//    'LBL_STEP6'                         => 'Step 6 of 8 - Site Configuration',
//    'LBL_STEP7'                         => 'Step 7 of 8 - Confirm Settings',
//    'LBL_STEP8'                         => 'Step 8 of 8 - Installation Successful',
//	'LBL_NO_THANKS'						=> 'Continue to installer',
	'LBL_CHOOSE_LANG'					=> '<b>Triï el seu idioma</b>',
	'LBL_STEP'							=> 'Pas',
	'LBL_TITLE_WELCOME'					=> 'Benvingut a SugarCRM ',
	'LBL_WELCOME_1'						=> 'Aquest instal·lador crea les taules de base de dades de SugarCRM i estableix les variables de configuració necessàries per iniciar. El procés complet hauria de tardar uns deu minuts.',
	'LBL_WELCOME_2'						=> 'Per trobar documentació sobre la instal·lació, si us plau visiti el < a href="http://www.sugarcrm.com/crm/installation" target="_blank">Sugar Wiki</a >. < BR><BR > També pot trobar ajut de la Comunitat Sugar en els <a href="http://www.sugarcrm.com/forums/" target="_blank">Sugar Forums</a>.',
    //welcome page variables
    'LBL_TITLE_ARE_YOU_READY'            => 'Està llest per procedir amb la instal·lació?',
    'REQUIRED_SYS_COMP' => 'Components del Sistema Requerits',
    'REQUIRED_SYS_COMP_MSG' =>
                    'Abans de començar, si us plau asseguri\'s que té les versions suportades dels següents components
                     del sistema:<br>
                      <ul>
                      <li> Base de dades/Sistema de Gestió de Base de Dades (Exemples: MySQL, SQL Server, Oracle)</li>
                      <li> Servidor Web (Apache, IIS)</li>
                      </ul>
                      Consulti la Matriu de Compatibilitat en les Notes de Llançament per a
                      els components del sistema compatibles per a la versió de Sugar que està instal·lant.<br>',
    'REQUIRED_SYS_CHK' => 'Comprobació Inicial del Sistema',
    'REQUIRED_SYS_CHK_MSG' =>
                    'Quan iniciï el procés d\'instal·lació, es realitzarà una comprovació del sistema al servidor web en el qual els arxius de Sugar estan localitzats per a
                      assegurar que el sistema està degudament configurat i té tots els components necessaris
                      per completar la instal·lació amb èxit. <br><br>
                      El sistema comprova el següent:<br>
                      <ul>
                      <li>Que la <b>versió de PHP</b> &#8211; sigui compatible 
                      amb la aplicació</li>
                                        <li><b>Les Variables de Sessió</b> &#8211; tenen que funcionar adecuadament</li>
                                            <li> <b>Las Cadenes MB</b> &#8211; tenen que estar instal·lades i habilitades en php.ini</li>

                      <li> <b>El Suport de Base de Dades</b> &#8211; te que existir per MySQL, SQL
                      Server u Oracle</li>

                      <li> <b>Config.php</b> &#8211; te que existir i te que tenir els permisos
                                  adequats perquè sigui escribible</li>
					  <li>Els següents arxius de Sugar tenen que ser escribibles:<ul><li><b>/custom</li>
<li>/cache</li>
<li>/modules</b></li></ul></li></ul>
                                  Si la comprobació falla, no podrá continuar amb la instal·lació. Un missatge d\'error es mostrarà, explicant-lo per què el seu sistema
                                   no ha passat les comprovacions.
                                   Després de realitzar els canvis necessaris, pot realitzar les comprovacions
                                   del sistema de nou per continuar amb la instal·lació. <br>',
    'REQUIRED_INSTALLTYPE' => 'Instalació Típica o Personalitzada',
    'REQUIRED_INSTALLTYPE_MSG' =>
                    'Després de la comprovació del sistema, pot triar entre la
                      instal·lació Típica o la Personalizada.<br><br>
                      Tant per a la instal·lació < b>Típica</b > com per a la < b>Personalizada</b >, necessitarà saber el següent:<br>
                      <ul>
                      <li> <b>Tipus de base de dades</b > que emmagatzemarà les dades de Sugar < ul><li>Tipus de base de dades compatibles: 
                      MySQL, MS SQL Server, Oracle.<br><br></li></ul></li>
                      <li> <b>Nom del servidor web</b> o màquina (equipo) en el que la base de dades serà ubicada
                      <ul><li>Això pot ser < i>localhost</i > si la base de dades està en el seu equip local o en al mateix servidor web o màquina que els seus arxius Sugar.<br><br></li></ul></li>
                      <li><b>Nom de la base de dades</b > que desitja utilitzar per emmagatzemar les dades de Sugar</li>
                        <ul>
                          <li> Pot ser que ja disposi d\'una base de dades que vulgui utilitzar. Si proporciona
                               el nom d\'una base de dades existent, les taules de la base de dades seran eliminades
                               durant la instal·lació, quan es defineixi l\'esquema per a la base de dades de Sugar.</li>
                          <li> Si no té una base de dades, el nom que proporcioni s\'utilitzarà per a la nova
                               base de dades que serà creada per a l\'instacia durant la instal·lació.<br><br></li>
                        </ul>
                      <li><b>Nom i contrasenya de l\'usuari administrador de Base de dades</b > < ul><li>El administrador de base de dades hauria de ser capaç de crear taules i usuaris i d\'escriure en base de dades.</li><li>Pot ser que necessiti
                      contactar amb el seu administrador de base de dades perquè li proporcioni aquesta informació si la base de dades no està
                      ubicada en el seu equip local i/o si vostè no és l\'administrador de base de dades.<br><br></ul></li></li>
                      <li> <b>Nom y contrasenya del usuari de base de dades de Sugar</b>
                      </li>
                        <ul>
                          <li> L\'usuari pot ser l\'administrador de base de dades, o pot proporcionar el nom de
                          un altre usuari de base de dades existent. </li>
                          <li> Si vol crear un nou usuari de base de dades per a aquest propòsit, podrà
                          proporcionar un nou nom d\'usuari i contrasenya durant el procés d\'instal·lació,
                          i l\'usuari serà creat durant la instal·lació. </li>
                        </ul></ul><p>

                      Per la instal·lació <b>Personalitzada</b>, també necessitarà coneixer el següent:<br>
                      <ul>
                      <li> <b>L\'URL que s\'utilitzarà per accedir a la instància de Sugar</b > després de la seva instal·lació.
                      Aquest URL hauria d\'incloure el nom del servidor web o de màquina, o la seva direcció IP.<br><br></li>
                                  <li> [Opcional] <b>Ruta al directori de sesions</b > si desitja utilitzar un directori
                                  de sessions personalitzat per a la informació de Sugar per tal d\'evitar que les dades de les sessions
                                  siguin vulnerables en servidors compartits.<br><br></li>
                                  <li> [Opcional] <b>Ruta a un directori personalitzat de traces</b > si desitja substituir el directori per defecte per les traces de Sugar.<br><br></li>
                                  <li> [Opcional] <b>ID d\'Aplicació</b> si desitja substituir l\'ID autogenerat
                                  que assegura que les sessions d\'una instància de Sugar no siguin utilitzades per altres instàncies.<br><br></li>
                                  <li><b>Joc de Caracteres</b > més comunament usat en la seva configuració regional.<br><br></li></ul >
                                  Per a informació més detallada, si us plau consulti la Guia d\'Instal·lació. 
                                ',
    'LBL_WELCOME_PLEASE_READ_BELOW' => 'Si us plau, llegeixi la següent informació important abans de procedir amb la instal·lació. La informació li ajudarà a determinar si està o no preparat en aquests moments per instal·lar l\'aplicació.',

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '<b>Seleccioni el seu llenguatge</b>',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Assistent de Instal·lació',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Benvingut a SugarCRM ',
	'LBL_WELCOME_TITLE'					=> 'Assistent de Instal·lació de SugarCRM',
	'LBL_WIZARD_TITLE'					=> 'Assistent de Instal·lació de Sugar: ',
	'LBL_YES'							=> 'Si',
    'LBL_YES_MULTI'                     => 'Sí - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Processar Tasques de Workflow',
	'LBL_OOTB_REPORTS'		=> 'Executar Tasques Programades de Generació d\'Informes',
	'LBL_OOTB_IE'			=> 'Comprovar Safata d\'Entrada',
	'LBL_OOTB_BOUNCE'		=> 'Executar procés nocturn de correus electrònics de campanya rebotats',
    'LBL_OOTB_CAMPAIGN'		=> 'Executar procés nocturn de campanyes de correu electrònic masiu',
	'LBL_OOTB_PRUNE'		=> 'Truncar Base de dades al Inici del Mes',
    'LBL_OOTB_TRACKER'		=> 'Netejar la Taula de Històrial d\'Usuari a primer de Mes',
    'LBL_OOTB_SUGARFEEDS'   => 'Prune SuiteCRM Feed Tables',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Executar les notificacions de recordatori per correu electrònic',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Actualitzar taula tracker_sessions',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Netejar la cua de tasques',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Eliminar documents del sistema de fitxers',


    'LBL_PATCHES_TITLE'     => 'Instal·lar Últims Pegats',
    'LBL_MODULE_TITLE'      => 'Descargar e Instal·lar Paquets de Llenguatge',
    'LBL_PATCH_1'           => 'Si desitja saltar aquest pas, faci clic a Següent.',
    'LBL_PATCH_TITLE'       => 'Pegat del Sistema',
    'LBL_PATCH_READY'       => 'Els següents pegats són llestos per ser instal·lats:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SugarCRM depèn de les sessions de PHP per emmagatzemar informació important mentre que està connectat al seu servidor web. La seva instal·lació de PHP no té la informació de Sessió correctament configurada.  
											<br><br>Un error de configuració bastant comun és que la directiva < b>'session.save_path'</b > no apunti a un directori vàlid.  <br>
											<br> Si us plau, corregeixi seu <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>configuración PHP</a> a l'arxiu php.ini localitzat on s'indica a continuació.",
	'LBL_SESSION_ERR_TITLE'				=> 'Error de Configuració de Sesions PHP',
	'LBL_SYSTEM_NAME'=>'Nom del Sistema',
    'LBL_COLLATION' => 'Configuració de Collation',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Introdueixi un Nom de Sistema per a la instància de Sugar.',
	'LBL_PATCH_UPLOAD' => 'Seleccioni un arxiu amb un pegat del seu equip local',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Es requereix la versió de PHP 5 o superior.',
	'LBL_MINIMUM_PHP_VERSION' => 'La versió mínima requerida de PHP és la 5.1.0. Es recomana usar la versió de PHP 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(La seva versió actual de PHP és ',
	'LBL_RECOMMENDED_PHP_VERSION' =>' La versió recomanada de PHP és la 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'La manera de compatibilitat cap a enrere de PHP està habilitada. Estableixi zend.ze1_compatibility_mode a Off abans de continuar ',
    'LBL_STREAM' => 'PHP permet utilitzar stream',

    'advanced_password_new_account_email' => array(
        'subject' => 'Nova informació del compte',
        'description' => 'Aquesta plantilla s\'utilitza quan l\'administrador envia una contrasenya nova a un usuari.',
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
        'subject' => 'Restablir la contrasenya del compte',
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

	'LBL_WIZARD_SMTP_DESC' => 'Indiqui la compta de correu electrònic que s\'utilitzarà per a enviar correus electrònics, com les notificacions d\'assignació i les contrasenyes dels nous usuaris. Els usuaris rebran correus de Sugar, com si haguesin estat enviats des de la compta de correu especificada.',
	'LBL_CHOOSE_EMAIL_PROVIDER'        => 'Triï el seu proveïdor de correu electrònic:',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! Mail',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => 'Altre',
	'LBL_MAIL_SMTP_SETTINGS'           => 'Especificació del servidor SMTP',
	'LBL_MAIL_SMTPSERVER'				=> 'Servidor SMTP:',
	'LBL_MAIL_SMTPPORT'					=> 'Port SMTP:',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'Fer servir Autentificació SMTP?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => 'Habilitar SMTP sobre SSL o TLS?',
	'LBL_GMAIL_SMTPUSER'					=> 'Direcció de correu electrònic de Gmail:',
	'LBL_GMAIL_SMTPPASS'					=> 'Contrasenya de Gmail:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => 'Permet als usuaris utilitzar aquesta compta per a correu electrònic sortint:',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => 'Quan aquesta opció està seleccionada, tots els usuaris podran enviar correus electrònics utilitzant la mateixa compta de correu de sortida per a l\'enviament de notificacions del sistema i avisos. Si la opció no està seleccionada, els usuaris poden utilitzar el servidor de correu de sortida després de proporcionar la informació de la seva pròpia compta.',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Contrasenya de Yahoo! Mail:',
	'LBL_YAHOOMAIL_SMTPUSER'					=> 'Id de Yahoo! Mail:',

	'LBL_EXCHANGE_SMTPPASS'					=> 'Contrasenya d\'Exchange:',
	'LBL_EXCHANGE_SMTPUSER'					=> 'Nom d\'usuari d\'Exchange:',
	'LBL_EXCHANGE_SMTPPORT'					=> 'Port del servidor d\'Exchange:',
	'LBL_EXCHANGE_SMTPSERVER'				=> 'Servidor d\'Exchange:',


	'LBL_MAIL_SMTPUSER'					=> 'Usuari SMTP:',
	'LBL_MAIL_SMTPPASS'					=> 'Clau de pas SMTP:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Imatge de marca',
	'LBL_WIZARD_SYSTEM_DESC' => 'Proporcioni el nom i el logotip de la seva organització per tal d\'establir la imatge de la seva marca a Sugar.',
	'SYSTEM_NAME_WIZARD'=>'Nom:',
	'SYSTEM_NAME_HELP'=>'Aquest és el nom que es mostrarà al títol de la barra del seu navegador.',
	'NEW_LOGO'=>'Pujar nou logo',
	'NEW_LOGO_HELP'=>'El format d\'arxiu d\'imatge pot ser .png o .jpg. L\'alçada màxima és de 17px, i l\'amplada màxima és de 450px. Qualsevol imatge carregada que és més gran en qualsevol direcció serà modificada perquè aquestes dimensions màximes.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'Pujar',
	'CURRENT_LOGO'=>'Logo actual',
    'CURRENT_LOGO_HELP'=>'Aquest logotip es mostra a la cantonada superior esquerra de l\'aplicació Sugar.',

	// System Local Settings


	'LBL_LOCALE_TITLE' => 'Configuració Regional del Sistema',
	'LBL_WIZARD_LOCALE_DESC' => 'Especifiqui com vol que siguin mostrades les dades a Sugar, basant-se en la seva ubicació geogràfica. La configuració que proporcioni aquí serà utilitzada per defecte. Els usuaris podran establir les seves pròpies preferències.',
	'LBL_DATE_FORMAT' => 'Format de Data:',
	'LBL_TIME_FORMAT' => 'Format d\'Hora:',
		'LBL_TIMEZONE' => 'Zona Horària:',
	'LBL_LANGUAGE'=>'Llenguatge:',
	'LBL_CURRENCY'=>'Moneda:',
	'LBL_CURRENCY_SYMBOL'=>'Símbol de la moneda:',
	'LBL_CURRENCY_ISO4217' => 'Codi de moneda ISO 4217:',
	'LBL_NUMBER_GROUPING_SEP' => 'Separador de milers',
	'LBL_DECIMAL_SEP' => 'Símbol Decimal',
	'LBL_NAME_FORMAT' => 'Nom del format:',
	'UPLOAD_LOGO' => 'Si us plau, espereu mentre es puja el logotip...',
	'ERR_UPLOAD_FILETYPE' => 'Tipus de fitxer no permès, si us plau, pugi un fitxer de format jpeg o png.',
	'ERR_LANG_UPLOAD_UNKNOWN' => 'Ha ocorregut un error de pujada desconegut.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => 'L\'arxiu pujat supera el límit definit per la directiva upload_max_filesize a php.ini.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => 'L\'arxiu pujat supera el límit definit per la directiva MAX_FILE_SIZE especificada al formulari HTML.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => 'L\'arxiu ha estat només parcialment pujat.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => 'No s\'ha pujat cap arxiu.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => 'Falta una carpeta temporal.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => 'Error al escriure l\'arxiu.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'Una extensió de PHP ha aturat la pujada del fitxer. PHP no ofereix medis per conèixer la raó que ha provocat aquest fet.',

	'LBL_INSTALL_PROCESS' => 'Instal·lar...',

	'LBL_EMAIL_ADDRESS' => 'Direcció de correu electrònic:',
	'ERR_ADMIN_EMAIL' => 'L\'adreça de correu electrònic de l\'administrador és incorrecta.',
	'ERR_SITE_URL' => 'La direcció URL del lloc és requerida.',

	'STAT_CONFIGURATION' => 'Configurant relacions...',
	'STAT_CREATE_DB' => 'Crear base de dades...',
	//'STAT_CREATE_DB_TABLE' => 'Create database... (table: %s)',
	'STAT_CREATE_DEFAULT_SETTINGS' => 'Crear opcions per defecte...',
	'STAT_INSTALL_FINISH' => 'Instal·lació finalitzada...',
	'STAT_INSTALL_FINISH_LOGIN' => 'S\'ha finalitzat el procés d\'instal·lació, <a href="%s">si us plau, identifiquis...</a>',
	'LBL_LICENCE_TOOLTIP' => 'Si us plau, accepti la llicència primer',

	'LBL_MORE_OPTIONS_TITLE' => 'Més opcions',
	'LBL_START' => 'Iniciar',


);

?>
