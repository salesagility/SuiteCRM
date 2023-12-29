<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo, "Supercharged by SuiteCRM" logo and “Nonprofitized by SinergiaCRM” logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, 
 * the Appropriate Legal Notices must display the words "Powered by SugarCRM", 
 * "Supercharged by SuiteCRM" and “Nonprofitized by SinergiaCRM”. 
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    /*'ADMIN_EXPORT_ONLY'=>'Admin export only',*/
    'ADVANCED' => 'Avançat',
    'DEFAULT_CURRENCY_ISO4217' => 'Codi de moneda ISO 4217',
    'DEFAULT_CURRENCY_NAME' => 'Nom de moneda',
    'DEFAULT_CURRENCY_SYMBOL' => 'Símbol de moneda',
    'DEFAULT_DATE_FORMAT' => 'Format de data predeterminat',
    'DEFAULT_DECIMAL_SEP' => 'Símbol decimal',
    'DEFAULT_LANGUAGE' => 'Idioma predeterminat',
    'DEFAULT_SYSTEM_SETTINGS' => 'Interfície d\'Usuari',
    'DEFAULT_THEME' => 'Tema predeterminat',
    'DEFAULT_TIME_FORMAT' => 'Format d\'hora predeterminat',
    'DISPLAY_RESPONSE_TIME' => 'Mostrar els temps de resposta del servidor',
    'IMAGES' => 'Logotips',
    'LBL_ALLOW_USER_TABS' => 'Permetre que els usuaris puguin ocultar pestanyes',
    'LBL_CONFIGURE_SETTINGS_TITLE' => 'Configuració del Sistema',
    'LBL_LOGVIEW' => 'Mostra registre',
    'LBL_MAIL_SMTPAUTH_REQ' => 'Usar Autentificació SMTP?',
    'LBL_MAIL_SMTPPASS' => 'Clau de pas SMTP:',
    'LBL_MAIL_SMTPPORT' => 'Port SMTP:',
    'LBL_MAIL_SMTPSERVER' => 'Servidor SMTP:',
    'LBL_MAIL_SMTPUSER' => 'Usuari SMTP:',
    'LBL_MAIL_SMTP_SETTINGS' => 'Especificació del servidor SMTP',
    'LBL_CHOOSE_EMAIL_PROVIDER' => 'Triï el seu proveïdor de correu electrònic:',
    'LBL_YAHOOMAIL_SMTPPASS' => 'Contrasenya de Yahoo! Mail:',
    'LBL_YAHOOMAIL_SMTPUSER' => 'Id de Yahoo! Mail:',
    'LBL_GMAIL_SMTPPASS' => 'Contrasenya de Gmail:',
    'LBL_GMAIL_SMTPUSER' => 'Adreça de correu electrònic de Gmail:',
    'LBL_EXCHANGE_SMTPPASS' => 'Contrasenya d&#39;Exchange:', // Excepció d'escapat 
    'LBL_EXCHANGE_SMTPUSER' => 'Nom d&#39;usuari d&#39;Exchange:', // Excepció d'escapat 
    'LBL_EXCHANGE_SMTPPORT' => 'Port del servidor d&#39;Exchange:', // Excepció d'escapat 
    'LBL_EXCHANGE_SMTPSERVER' => 'Servidor d&#39;Exchange:', // Excepció d'escapat 
    'LBL_ALLOW_DEFAULT_SELECTION' => 'Permet als usuaris utilitzar aquesta compta per a correu electrònic de sortida:',
    'LBL_ALLOW_DEFAULT_SELECTION_HELP' => 'Quan aquesta opció està seleccionada, tots els usuaris podran enviar correus electrònics utilitzant la mateixa compta de correu de sortida per a l\'enviament de notificacions del sistema i avisos. Si la opció no està seleccionada, els usuaris poden utilitzar el servidor de correu de sortida després de proporcionar la informació de la seva pròpia compta.',
    'LBL_MAILMERGE' => 'Combinar Correspondència',
    'LBL_MIN_AUTO_REFRESH_INTERVAL' => 'Interval mínim de l\'actualització automàtica del Dashlet',
    'LBL_MIN_AUTO_REFRESH_INTERVAL_HELP' => 'Aquest és el valor mínim que un pot triar per a l\'actualització automàtica dels dashlets. Ajustar a \'Mai\' desactiva que s\'actualitzin automàticament els dashlets.',
    'LBL_MODULE_FAVICON' => 'Mostrar la icona del mòdul com a favicon ',
    'LBL_MODULE_FAVICON_HELP' => 'Si està a un mòdul amb icona, utilitza la icona del mòdul com a favicon, en comptes del favicon del tema, a la pestanya del navegador.',
    'LBL_MODULE_NAME' => 'Configuració del Sistema',
    'LBL_MODULE_ID' => 'Configurador',
    'LBL_MODULE_TITLE' => 'Interfície d\'Usuari',
    'LBL_NOTIFY_FROMADDRESS' => 'Adreça "De":',
    'LBL_NOTIFY_SUBJECT' => 'Assumpte de correu electrònic:',
    'LBL_PROXY_AUTH' => 'Autentificació?',
    'LBL_PROXY_HOST' => 'Servidor Proxy',
    'LBL_PROXY_ON_DESC' => 'Configura l\'adreça del servidor proxy i la configuració de l\'autentificació',
    'LBL_PROXY_ON' => 'Utilitzar servidor proxy?',
    'LBL_PROXY_PASSWORD' => 'Clau de pas',
    'LBL_PROXY_PORT' => 'Port',
    'LBL_PROXY_TITLE' => 'Configuració del Proxy',
    'LBL_PROXY_USERNAME' => "Nom d\'Usuari", // STIC-Custom 2020/08/07 - Escaping exception. Do not touch. STIC#49
    'LBL_RESTORE_BUTTON_LABEL' => 'Restaurar',
    'LBL_SYSTEM_SETTINGS' => 'Configuració',
    'LBL_USE_REAL_NAMES' => 'Mostrar nom complet (no id usuari)',
    'LBL_USE_REAL_NAMES_DESC' => 'Mostra el nom complert d\'un usuario enlloc del seu identificador',
    'LBL_DISALBE_CONVERT_LEAD' => 'Deshabilitar l\'acció de convertir clients potencials per a clients potencials convertits',
    'LBL_DISALBE_CONVERT_LEAD_DESC' => 'Si un client potencial ja ha estat convertit, activant aquesta opció no es permetrà tornar-lo a convertir en client potencial.',
    'LBL_ENABLE_ACTION_MENU' => 'Mostrar accions a dins dels menús',
    'LBL_ENABLE_ACTION_MENU_DESC' => 'Seleccioni per a mostrar la vista detallada i el quadre d\'accions a dins d\'un menú desplegable. Si no es selecciona, les accions es mostraran com a botons separats.',
    'LBL_ENABLE_INLINE_EDITING_LIST' => 'Habilitar l\'editor de línia en aquesta vista',
    'LBL_ENABLE_INLINE_EDITING_LIST_DESC' => 'Seleccionar per habilitar l\'edició en línia dels camps de la vista de detalls. Si no està seleccionada l\'edició en línia, aquesta serà deshabilitada en la llista de la vista.',
    'LBL_ENABLE_INLINE_EDITING_DETAIL' => 'Habilitar l\'edició de línia en la vista',
    'LBL_ENABLE_INLINE_EDITING_DETAIL_DESC' => 'Sel·leccionar per habilitar l\'edició en línia dels camps de detalls de la vista. Si no està sel·leccionada l\'edició en línia, aquesta serà deshabilitada.',
    'LBL_HIDE_SUBPANELS' => 'Subpanells col·lapsats',
    'LIST_ENTRIES_PER_LISTVIEW' => 'Elements per pàgina per llistes',
    'LIST_ENTRIES_PER_SUBPANEL' => 'Elements per pàgina per subpanells',
    'LOG_MEMORY_USAGE' => 'Registrar utilització de memòria',
    'LOG_SLOW_QUERIES' => 'Registrar consultes lentas',
    'CURRENT_LOGO' => 'Logo actual',
    'CURRENT_LOGO_HELP' => 'Aquest logotip es mostra al centre de la pantalla d’inici de sessió de l’aplicació SuiteCRM.',
    'NEW_LOGO' => 'Pujar nou logo',
    'NEW_LOGO_HELP' => 'El format d\'arxiu d\'imatge pot ser .png o .jpg. L\'alçada màxima ha de ser de 170px i l\'amplada màxima, de 450px. Qualsevol imatge carregada que sigui més gran en qualsevol dimensió serà modificada per respectar aquestes dimensions màximes.',
    'NEW_LOGO_HELP_NO_SPACE' => 'El format d\'arxiu d\'imatge pot ser .png o .jpg. L\'alçada màxima ha de ser de 170px i l\'amplada màxima, de 450px. Qualsevol imatge carregada que sigui més gran en qualsevol dimensió serà modificada per respectar aquestes dimensions màximes.',
    'SLOW_QUERY_TIME_MSEC' => 'Temps umbral per consultes lentes (ms)',
    'STACK_TRACE_ERRORS' => 'Mostrar traça de la pila d\'errors',
    'UPLOAD_MAX_SIZE' => 'Tamany màxim per pujada d\'arxius',
    'VERIFY_CLIENT_IP' => 'Validar adreça IP de l\'usuari',
    'LOCK_HOMEPAGE' => 'No permetre el disseny personalitzat de la Pàgina d\'Inici',
    'LOCK_SUBPANELS' => 'No permetre el disseny personalitzat dels subpanells',
    'MAX_DASHLETS' => 'Nombre màxim de Dashlets de SuiteCRM a la pàgina d\'inici',
    'SYSTEM_NAME' => 'Nom del Sistema',
    'SYSTEM_NAME_WIZARD' => 'Nom:',
    'SYSTEM_NAME_HELP' => 'Aquest és el nom que es mostrarà al títol de la barra del seu navegador.',
    'LBL_LDAP_TITLE' => 'Suport d\'Autentificació LDAP',
    'LBL_LDAP_ENABLE' => 'Habilitar LDAP',
    'LBL_LDAP_SERVER_HOSTNAME' => 'Servidor:',
    'LBL_LDAP_SERVER_PORT' => 'Número de Port:',
    'LBL_LDAP_ADMIN_USER' => 'Nom d\'Usuari:',
    'LBL_LDAP_ADMIN_USER_DESC' => '
S\'utilitza per cercar l\'usuari LDAP. És possible que hagi d\'estar completament qualificat.',
    'LBL_LDAP_ADMIN_PASSWORD' => 'Contrasenya:',
    'LBL_LDAP_AUTHENTICATION' => 'Autentificació:',
    'LBL_LDAP_AUTHENTICATION_DESC' => '
Enllaçar al servidor LDAP utilitzant credencials d\'usuaris específiques. Es vincularà de forma anònima si no es proporciona.',
    'LBL_LDAP_AUTO_CREATE_USERS' => 'Crear Usuaris Automàticament:',
    'LBL_LDAP_USER_DN' => 'DN d\'usuari: ',
    'LBL_LDAP_GROUP_DN' => 'DN de grup: ',
    'LBL_LDAP_GROUP_DN_DESC' => 'Exemple: <em>ou=groups,dc=example,dc=com</em>',
    'LBL_LDAP_USER_FILTER' => 'Filtre d\'usuaris:',
    'LBL_LDAP_GROUP_MEMBERSHIP' => 'Pertinença a grups:',
    'LBL_LDAP_GROUP_MEMBERSHIP_DESC' => 'Els usuaris han de ser membres d\'un grup específic',
    'LBL_LDAP_GROUP_USER_ATTR' => 'Atribut d\'usuari:',
    'LBL_LDAP_GROUP_USER_ATTR_DESC' => 'L\'identificador únic de persona que serà utilitzat per a comprovar si són membres d\'un grup. Exemple: <em>uid</em>',
    'LBL_LDAP_GROUP_ATTR_DESC' => 'L\'atribut del grup serà utilitzat com a filtre sobre l\'atribut d\'usuari. Exemple: <em>memberUid</em>',
    'LBL_LDAP_GROUP_ATTR' => 'Atribut de grup:',
    'LBL_LDAP_USER_FILTER_DESC' => 'Qualsevol filtre addicional de paràmetres per aplicar quan autentica els usuaris, per exemple <em>is_suitecrm_user=1 or (is_suitecrm_user=1)(is_sales=1)</em>',
    'LBL_LDAP_LOGIN_ATTRIBUTE' => 'Atribut de Login:',
    'LBL_LDAP_BIND_ATTRIBUTE' => 'Atribut de Bind:',
    'LBL_LDAP_BIND_ATTRIBUTE_DESC' => 'Exemples per enllaçar amb l\'usuari LDAP:[<b>AD:</b>&nbsp;userPrincipalName] [<b>openLDAP:</b>&nbsp;dn] [<b>Mac&nbsp;OS&nbsp;X:</b>&nbsp;uid] ',
    'LBL_LDAP_LOGIN_ATTRIBUTE_DESC' => 'Exemples per cercar l\'usuari de LDAP:[<b>AD:</b>&nbsp;userPrincipalName] [<b>openLDAP:</b>&nbsp;cn] [<b>Mac&nbsp;OS&nbsp;X:</b>&nbsp;dn] ',
    'LBL_LDAP_SERVER_HOSTNAME_DESC' => 'Exemple: ldap.example.com',
    'LBL_LDAP_SERVER_PORT_DESC' => 'Exemple: 389',
    'LBL_LDAP_GROUP_NAME' => 'Nom del Grup:',
    'LBL_LDAP_GROUP_NAME_DESC' => 'Exemple <em>cn=suitecrm</em>',
    'LBL_LDAP_USER_DN_DESC' => 'Exemple: <em>ou=people,dc=example,dc=com</em>',
    'LBL_LDAP_AUTO_CREATE_USERS_DESC' => 'Si un usuari autentificat no existeix se\'n crearà un.',
    'LBL_LDAP_ENC_KEY' => 'Clau d\'Encriptació:',
    'DEVELOPER_MODE' => 'Manera Desenvolupador',

    'SHOW_DOWNLOADS_TAB' => 'Mostrar la pestanya de descarregues',
    'SHOW_DOWNLOADS_TAB_HELP' => 'Quan es selecciona, la pestanya de Baixada apareixerà en la configuració d\'usuari i proporcionarà als usuaris amb accés per SuiteCRM plug-ins i uns altres arxius disponibles',
    'LBL_LDAP_ENC_KEY_DESC' => 'Per l\'autentificació SOAP al usar LDAP.',
    'LDAP_ENC_KEY_NO_FUNC_DESC' => 'L\'extensió php_mcrypt ha d\'estar habilitada en el seu arxiu php.ini.',
    'LDAP_ENC_KEY_NO_FUNC_OPENSSL_DESC' => 'L\'extensió openssl es pot habilitar al vostre fitxer php.ini.',
    'LBL_ALL' => 'Tot',
    'LBL_MARK_POINT' => 'Marcar Punt',
    'LBL_NEXT_' => 'Següent>>',
    'LBL_REFRESH_FROM_MARK' => 'Actualitzar Desde Marca',
    'LBL_SEARCH' => 'Cercar:',
    'LBL_REG_EXP' => 'Exp. Reg.:',
    'LBL_IGNORE_SELF' => 'Ignorar dades Pròpies:',
    'LBL_MARKING_WHERE_START_LOGGING' => 'Marcant des d\'on iniciar el registre',
    'LBL_DISPLAYING_LOG' => 'Mostrant registre',
    'LBL_YOUR_PROCESS_ID' => 'El seu ID de procés',
    'LBL_YOUR_IP_ADDRESS' => 'La vostra adreça IP es',
    'LBL_IT_WILL_BE_IGNORED' => ' Serà ignorat ',
    'LBL_LOG_NOT_CHANGED' => 'El registre no ha canviat',
    'LBL_ALERT_JPG_IMAGE' => 'El format d\'arxiu de la imatge ha de ser JPEG. Pugeu un nou arxiu l\'extensió del qual sigui .jpg.',
    'LBL_ALERT_TYPE_IMAGE' => 'El format d\'arxiu de la imatge ha de ser JPEG o PNG. Pugeu un nou arxiu l\'extensió del qual sigui .jpg o .png.',
    'LBL_ALERT_SIZE_RATIO' => 'La relació d\'aspecte de la imatge hauria de ser entre 1:1 i 10:1. La imatge serà redimensionada.',
    'ERR_ALERT_FILE_UPLOAD' => 'Error en pujar la imatge.',
    'LBL_LOGGER' => 'Configuració de registre',
    'LBL_LOGGER_FILENAME' => 'Nom del fitxer de registre',
    'LBL_LOGGER_FILE_EXTENSION' => 'Extensió',
    'LBL_LOGGER_MAX_LOG_SIZE' => 'Mida màxima del registre',
    'LBL_LOGGER_DEFAULT_DATE_FORMAT' => 'Format de data per defecte',
    'LBL_LOGGER_LOG_LEVEL' => 'Nivell de registre',
    'LBL_LEAD_CONV_OPTION' => 'Opcions de conversa de client potencial',
    'LEAD_CONV_OPT_HELP' => "<b>Copy</b> - crea i fa còpies de totes les activitats de la iniciativa a registres nous que són seleccionats per l'usuari durant la conversió. Les còpies són creades per a cadascun dels registres seleccionats. <br><br><b>Move</b> - totes les activitats de la iniciativa es traslladen a un nou rècord que és seleccionat per l'usuari durant la conversió. <br> <br><b>Do Nothing</b> - no fa res amb activitats de la iniciativa durant la conversió. Les activitats queden relacionades només amb el Potencial.",
    'LBL_CONFIG_AJAX' => 'Configurar la interfície d\'usuari AJAX',
    'LBL_CONFIG_AJAX_DESC' => 'Activar o desactivar l\'ús de la interfície d\'usuari d\'AJAX per a mòduls específics.',
    'LBL_LOGGER_MAX_LOGS' => 'Número màxim de traçes (abans de rotació)',
    'LBL_LOGGER_FILENAME_SUFFIX' => 'Afegir després el nom d\'arxiu',
    'LBL_VCAL_PERIOD' => 'Període de Temps per Actualizacions vCal:',
    'LBL_IMPORT_MAX_RECORDS' => 'Importar - Màxim nombre de registres:',
    'LBL_IMPORT_MAX_RECORDS_HELP' => 'Especificar quants registres es permeten dins dels arxius d\'importació.<br>Si el nombre de registres en un arxiu d\'importació excedeix aquest nombre, l\'usuari serà avisat.<br>Si no s\'entra cap nombre s\'acceptarà un nombre il·limitat de registres.',
    'vCAL_HELP' => 'Faci servir aquesta opció per determinar el número de mesos per endavant sobre la data actual amb la que es pública la informació relativa al estat de Disponible/Ocupat sobre trucades i reunions.</BR>Per desactivar la publicació del estat Disponible/Ocupat, posi "0".  El mínim es 1 mes; el màxim 12.',
    'LBL_PDFMODULE_NAME' => 'Configuració PDF',
    'SUITEPDF_BASIC_SETTINGS' => 'Propietats del document',
    'SUITEPDF_ADVANCED_SETTINGS' => 'Configuració avançada',
    'SUITEPDF_LOGO_SETTINGS' => 'Imatges',

    'PDF_AUTHOR' => 'Autor',
    'PDF_AUTHOR_INFO' => 'L\'autor apareix a les propietat del document.',

    'PDF_HEADER_LOGO' => 'Per a documents PDF de pressupostos',
    'PDF_HEADER_LOGO_INFO' => 'Aquesta imatge apareix a la capçalera per defecte dels documents PDF de pressupostos.',

    'PDF_NEW_HEADER_LOGO' => 'Seleccioni una nova imatge per als pressupostos',
    'PDF_NEW_HEADER_LOGO_INFO' => 'El format de l\'arxiu pot ser .jpg o .ong (Solament .jpg per EZPDF)<BR> La mida recomanada és 867x60 px.',

    'PDF_SMALL_HEADER_LOGO' => 'Per a documents PDF d\'informes',
    'PDF_SMALL_HEADER_LOGO_INFO' => 'Aquesta imatge apareix a la capçalera per defecte en els documents PDF d\'informes. <br> Aquesta imatge també apareix a la cantonada superior esquerra de l\'aplicació SuiteCRM.',

    'PDF_NEW_SMALL_HEADER_LOGO' => 'Seleccionar nova imatge pels informes',
    'PDF_NEW_SMALL_HEADER_LOGO_INFO' => 'El format de l\'arxiu por ser .jpg o .png (Solament .jpg per EZPDF)<BR>La grandaria recomanada es 212x40 px.',

    'PDF_FILENAME' => 'Nom de fitxer per defecte',
    'PDF_FILENAME_INFO' => 'Nom per defecte pels fitxers PDF generats',

    'PDF_TITLE' => 'Títol',
    'PDF_TITLE_INFO' => 'El títol apareix a les propietats del document.',

    'PDF_SUBJECT' => 'Assumpte',
    'PDF_SUBJECT_INFO' => 'L\'assumpte apareix a les propietats del document.',

    'PDF_KEYWORDS' => 'Paraula/es clau',
    'PDF_KEYWORDS_INFO' => 'Associar les paraules clau amb el document, generalment de la forma "paraula1 paraula2..."',

    'PDF_COMPRESSION' => 'Compressió',
    'PDF_COMPRESSION_INFO' => 'Activa o desactiva la compressió de pàgina. <br>Quan s\'activa, la representació interna de cada pàgina es comprimeix, arribant a ratis de compressió d\'aproximadament 2.',

    'PDF_JPEG_QUALITY' => 'Qualitat JPEG (1-100)',
    'PDF_JPEG_QUALITY_INFO' => 'Establir la qualitat de compressió JPEG per defecte (1-100)',

    'PDF_PDF_VERSION' => 'Versió PDF',
    'PDF_PDF_VERSION_INFO' => 'Establir la versió PDF (consulti la referència PDF per a valors vàlids).',

    'PDF_PROTECTION' => 'Protecció del document',
    'PDF_PROTECTION_INFO' => 'Estableix la protecció de document <br>- copiar: copiar text i imatges al porta-retalls <br>- imprimir: imprimir el document <br>- modificar: modificar el document (excepte les anotacions i formularis) <br>- anot.-forms: afegir anotacions i formularis <br> Nota: la protecció davant la modificació és per a gent que posseeix el producte Acrobat complet.',

    'PDF_USER_PASSWORD' => 'Contrasenya d\'usuari',
    'PDF_USER_PASSWORD_INFO' => 'Si no estableix cap contrasenya, el document s\'obrirà com de costum. <br> Si estableix una contrasenya d\'usuari, el visor PDF es la sol·licitarà abans de mostrar el document. <br> Si la contrasenya mestra és diferent de la de usuari podrà utilitzar-la per accedir complet.',

    'PDF_OWNER_PASSWORD' => 'Contrasenya del propietari',
    'PDF_OWNER_PASSWORD_INFO' => 'Si no estableix cap contrasenya, el document s\'obrirà com de costum. <br> Si estableix una contrasenya d\'usuari, el visor PDF es la sol·licitarà abans de mostrar el document. <br> Si la contrasenya mestra és diferent de la de usuari podrà utilitzar-la per accedir complet.',

    'PDF_ACL_ACCESS' => 'Control d\'accés',
    'PDF_ACL_ACCESS_INFO' => 'Control d\'accés per defecte per a la generació de PDFs.',

    'K_CELL_HEIGHT_RATIO' => 'Rati d\'altura de la cel·la',
    'K_CELL_HEIGHT_RATIO_INFO' => 'Si l\'alçada d\'una cel·la és més petita que (l\'alçada de la lletra pela ràtio de l\'alçada de la cel·la), llavors (l\'alçada de la lletra pela ràtio de l\'alçada de la cel·la) s\'utilitza com alçada de la cel·la.<br>
(L\'alçada de la lletra pela ràtio de l\'alçada de la cel·la) també és utilitzada com a alçada de la cel·la quant l\'alçada no està definida.',

    'K_SMALL_RATIO' => 'Factor de lletra petita',
    'K_SMALL_RATIO_INFO' => 'Coeficient de reducció per a fonts petites.',

    'PDF_IMAGE_SCALE_RATIO' => 'Ràtio d\'escalat d\'imatge',
    'PDF_IMAGE_SCALE_RATIO_INFO' => 'Rati utilitzat per a escalar les imatges',

    'PDF_UNIT' => 'Unitat',
    'PDF_UNIT_INFO' => 'unitat de mesura del document',
    'PDF_GD_WARNING' => 'No ha instal·lat la llibreria GD per a PHP. Sense la llibreria GD instal·lada, només es poden mostrar logos JPEG als documents PDF.',
    'ERR_EZPDF_DISABLE' => 'Avís: La classe EZPDF està deshabilitada a la taula de configuració i està establerta com a classe PDF. Si us plau, "Desi" aquest formulari per a establir TCPDF com la classe PDF i torni a un estat estable.',
    'LBL_IMG_RESIZED' => "(redimensionat per a ser mostrat)",


    'LBL_FONTMANAGER_BUTTON' => 'Administrador de fonts PDF',
    'LBL_FONTMANAGER_TITLE' => 'Administrador de fonts PDF',
    'LBL_FONT_BOLD' => 'Negreta',
    'LBL_FONT_ITALIC' => 'Cursiva',
    'LBL_FONT_BOLDITALIC' => 'Negreta/Cursiva',
    'LBL_FONT_REGULAR' => 'Normal',

    'LBL_FONT_TYPE_CID0' => 'CID-0',
    'LBL_FONT_TYPE_CORE' => 'Nucli',
    'LBL_FONT_TYPE_TRUETYPE' => 'TrueType',
    'LBL_FONT_TYPE_TYPE1' => 'Tipus1',
    'LBL_FONT_TYPE_TRUETYPEU' => 'TrueTypeUnicode',

    'LBL_FONT_LIST_NAME' => 'Nom',
    'LBL_FONT_LIST_FILENAME' => 'Nom del fitxer',
    'LBL_FONT_LIST_TYPE' => 'Tipus',
    'LBL_FONT_LIST_STYLE' => 'Estil',
    'LBL_FONT_LIST_STYLE_INFO' => 'Estil de la font',
    'LBL_FONT_LIST_ENC' => 'Codificació',
    'LBL_FONT_LIST_EMBEDDED' => 'Incrustat',
    'LBL_FONT_LIST_EMBEDDED_INFO' => 'Marqui aquesta opció per incrustar la font al fitxer PDF',
    'LBL_FONT_LIST_CIDINFO' => 'Informació CID',
    'LBL_FONT_LIST_CIDINFO_INFO' => 'Per exemples i més ajuda: www.tcpdf.org',
    'LBL_FONT_LIST_FILESIZE' => 'Mida de la font (KB)',
    'LBL_ADD_FONT' => 'Afegir una font',
    'LBL_BACK' => 'Enrere',
    'LBL_REMOVE' => 'Eliminar',
    'LBL_JS_CONFIRM_DELETE_FONT' => 'Està segur que vol eliminar aquesta font?',

    'LBL_ADDFONT_TITLE' => 'Afegir una font PDF',
    'LBL_PDF_ENCODING_TABLE' => 'Taula de codificació',
    'LBL_PDF_ENCODING_TABLE_INFO' => 'Nom de la taula de codificació. <br> Aquesta opció s\'ignora per TrueType Unicode, OpenType Unicode i fonts de símbols.<br> La codificació defineix l\'associació entre un codi (de 0 a 255) i un caràcter continguda en la font.<br> A La primera 128 són fixos i corresponen a ASCII.',
    'LBL_PDF_FONT_FILE' => 'Fitxer de la font',
    'LBL_PDF_FONT_FILE_INFO' => 'fitxer .ttf o .otf o .pbf',
    'LBL_PDF_METRIC_FILE' => 'Fitxer de mètrica',
    'LBL_PDF_METRIC_FILE_INFO' => 'fitxer .afm o .ufm',
    'LBL_ADD_FONT_BUTTON' => 'Afegir',
    'JS_ALERT_PDF_WRONG_EXTENSION' => 'Aquest arxiu no té una extensió vàlida.',

    'ERR_MISSING_CIDINFO' => 'El camp d\'informació CID no pot estar buit.',
    'LBL_ADDFONTRESULT_TITLE' => 'Resultat del procés d\'afegir una font',
    'LBL_STATUS_FONT_SUCCESS' => 'ÉXIT: La font s\'ha afegit a SuiteCRM.',
    'LBL_STATUS_FONT_ERROR' => 'ERROR: La font no s\'ha afegit. Consulti el registre a continuació.',

// Font manager
    'ERR_PDF_NO_UPLOAD' => 'Error durant la pujada del fitxer de font o de mètriques.',

// Wizard
    //Wizard Scenarios
    'LBL_WIZARD_SCENARIOS' => 'Els seus escenaris',
    'LBL_WIZARD_SCENARIOS_EMPTY_LIST' => 'No s\'han configurat escenaris',
    'LBL_WIZARD_SCENARIOS_DESC' => 'Triar quins escenaris són apropiats per a la seva instal·lació.  Aquestes opcions es poden canviar post-instal·lació.',

    'LBL_WIZARD_TITLE' => 'Assistent d\'administració',
    'LBL_WIZARD_WELCOME_TAB' => 'Benvingut',
    'LBL_WIZARD_WELCOME_TITLE' => 'Benvingut a SuiteCRM!',
    'LBL_WIZARD_WELCOME' => 'Feu clic a <b> Següent </ b> localitzar i configurar SuiteCRM ara. Si voleu configurar SuiteCRM després, feu clic a <b> Saltar </ b>.',
    'LBL_WIZARD_NEXT_BUTTON' => 'Següent',
    'LBL_WIZARD_BACK_BUTTON' => 'Enrera',
    'LBL_WIZARD_SKIP_BUTTON' => 'Saltar',
    'LBL_WIZARD_CONTINUE_BUTTON' => 'Continuar',
    'LBL_WIZARD_FINISH_TITLE' => 'S\'ha completat la configuració bàsica del sistema',
    'LBL_WIZARD_SYSTEM_TITLE' => 'Imatge de marca',
    'LBL_WIZARD_SYSTEM_DESC' => 'Proporcioni el nom i logotip de la seva organització per a establir la imatge de la seva marca a SuiteCRM.',
    'LBL_WIZARD_LOCALE_DESC' => 'Especifiqui com desitja que les dades siguin mostrades a SuiteCRM, basant-se en la seva ubicació geogràfica. La configuració que proporcioni aquí serà utilitzada per defecte. Els usuaris podran establir les seves pròpies preferències.',
    'LBL_WIZARD_SMTP_DESC' => 'Proporcioni el compte de correu electrònic que s\'utilitzarà per a enviar missatges de correu electrònic, com les notificacions d\'assignació i noves contrasenyes d\'usuari. Els usuaris rebran correus electrònics de SuiteCRM, com si s\'haguessin enviat des del compte de correu electrònic especificat.',
    'LBL_LOADING' => 'Carregant...' /*for 508 compliance fix*/,
    'LBL_DELETE' => 'Eliminar' /*for 508 compliance fix*/,
    'LBL_WELCOME' => 'Benvingut' /*for 508 compliance fix*/,
    'LBL_LOGO' => 'Logotip' /*for 508 compliance fix*/,
    'LBL_ENABLE_HISTORY_CONTACTS_EMAILS' => 'Mosta els correus electrònics relacionats a l\'historial subpanell per mòduls',

    // Google auth PR 6146
    'LBL_GOOGLE_AUTH_TITLE' => 'Autenticació de Google',
    'LBL_GOOGLE_AUTH_JSON' => 'Fitxer JSON',
    'LBL_GOOGLE_AUTH_JSON_HELP' => 'Carrega el fitxer JSON que has descarregat de la consola de desenvolupadors de Google.',

);
