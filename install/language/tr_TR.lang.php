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
	'LBL_BASIC_SEARCH'					=> 'Basit Arama',
	'LBL_ADVANCED_SEARCH'				=> 'Detaylı Arama',
	'LBL_BASIC_TYPE'					=> 'Temel türü',
	'LBL_ADVANCED_TYPE'					=> 'Gelişmiş tür',
	'LBL_SYSOPTS_1'						=> 'Aşağıdaki sistem ayarları seçeneklerini  seç',
    'LBL_SYSOPTS_2'                     => 'Kurmakta olduğunuz SuiteCRM için hangi türde bir veritabanı kullanacaksınız ?',
	'LBL_SYSOPTS_CONFIG'				=> 'Sistem Ayarları',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Veritabanı Tipi Belirleme',
    'LBL_SYSOPTS_DB_TITLE'              => 'Veritabanı Tipi',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Lütfen başlamadan önce aşağıdaki hataları giderin',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Lütfen aşağıdaki dizinleri yazılabilir hale getirin :',
    'ERR_DB_VERSION_FAILURE'			=> 'Veritabanı sürümü tespit edilemiyor.',
	'DEFAULT_CHARSET'					=> 'ISO-8859-9',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'SuiteCRM yöneticisi için kullanıcı adını belirtiniz.',
	'ERR_ADMIN_PASS_BLANK'				=> 'SuiteCRM admin kullanıcısu için şifre belirleyin.',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'Uyumluluk kontrolü sırasında hatalar bulundu.SuiteCrm kurulumunuzun düzgün çalışabilmesi için, lütfen aşağıda listede belirtilen adımları dikkate alın, tekrar kontrol et tuşuna tıklayabilir ya da kurulumu tekrar başlatabilirsiniz.',
    'ERR_CHECKSYS_CALL_TIME'            => 'Allow Call Time Pass Reference is On (this should be set to Off in php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'Bulunamadı: SuiteCRM zaman çizelgesi kısıtlı olarak çalışabilecektir.',
    'ERR_CHECKSYS_IMAP'					=> 'Bulunmadı: Gelen e-posta ve kampanyalar(E-posta) IMAP kütüphaneleri gerektirir. ',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC cannot be turned "On" when using MS SQL Server.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Uyarı: ',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> ' (Set this to ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M or larger in your php.ini file)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Minimum Version 4.1.2 - Found: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Failed to write and read session variables.  Unable to proceed with the installation.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'Geçersiz dizin',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Uyarı: Yazılabilir değil',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'PHP sürümüz SuiteCRM tarafından desteklenmiyor. SuiteCRM uygulaması ile uyumlu bir PHP sürümü yüklemeniz gereklidir. Lütfen yayım notlarındaki uyumluluk matrisinden desteklenen PHP sürümlerine bakın.PHP sürümüz ',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'Your version of IIS is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported IIS Versions. Your version is ',
	'ERR_CHECKSYS_FASTCGI'              => 'We detect that you are not using a FastCGI handler mapping for PHP. You will need to install/configure a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported Versions. Please see <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> for details ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'IIS/FastCGI sapı kullanarak en iyi deneyimi için fastcgi.logging php.ini dosyasında 0 olarak ayarlayın.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Desteklenmeyen PHP sürümü kurulu: ( ver',
    'LBL_DB_UNAVAILABLE'                => 'Veritabanı mevcut değil',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'Veritabanı desteği bulunamadı. Desteklenen veritbanı türleri için gerekli sürücülerden en azından birine sahip olup olmadığınızı kontrol edin. ( MySQL, MS SQLServer ya da  Oracle).  php.ini dosyasından uzantıyı etkinleştirmek ya da PHP  sürümünümüze bağlı olarak, doğru binary dosyayı yeniden derlemeniz gerekbilir.  Veritabanı desteğinin nasıl aktif geleceği ile ilgili olarak, lütfen PHP el kitaplarına başvurun.',
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
	'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode açık  (php.ini dosyasında etkisizleştirmek isteyebilirsiniz.)',
    'ERR_CHECKSYS_ZLIB'					=> 'ZLib support not found: SuiteCRM reaps enormous performance benefits with zlib compression.',
    'ERR_CHECKSYS_ZIP'					=> 'ZIP support not found: SuiteCRM needs ZIP support in order to process compressed files.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE library not found: SuiteCRM needs PCRE library in order to process Perl style of regular expression pattern matching.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE library version: SuiteCRM needs PCRE library 7.0 or above to process Perl style of regular expression pattern matching.',
	'ERR_DB_ADMIN'						=> 'Veritabanı yöneticisi için girilen kullanıcı ve/veya şifre geçersiz ve veritabanı ile bağlantı kurulamadı. Lütfen geçerli bir kullanıcı ve şifre giriniz.(Error: ',
    'ERR_DB_ADMIN_MSSQL'                => 'Veritabanı yöneticisi için girilen kullanıcı ve/veya şifre geçersiz ve veritabanı ile bağlantı kurulamadı. Lütfen geçerli bir kullanıcı ve şifre giriniz.',
	'ERR_DB_EXISTS_NOT'					=> 'Belirtilen veritabanı mevcut değil.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'Database already exists with config data.  To run an install with the chosen database, please re-run the install and choose: "Drop and recreate existing SuiteCRM tables?"  To upgrade, use the Upgrade Wizard in the Admin Console.  Please read the upgrade documentation located <a href="http://www.suitecrm.com target="_new">here</a>.',
	'ERR_DB_EXISTS'						=> 'Girilen veritabanı adı zaten mevcut -- aynı isimle yeni bir tane veritabanı oluşturulamaz.',
    'ERR_DB_EXISTS_PROCEED'             => 'Girilen veritabanı adı zaten mevcut. Yapabilecekleriniz: <br>1.  Geri tuşuna basın ve yeni bir isim girin <br>2. sonraki tuşuna basabilir ve varolan veritabanı ve tabloları silebilirsiniz.  <strong>Dikkat varolan verilerinizi kaybedeceksiniz</strong>',
	'ERR_DB_HOSTNAME'					=> 'Host adı boş olamaz.',
	'ERR_DB_INVALID'					=> 'Geçersiz veritabanı tipi seçili.',
	'ERR_DB_LOGIN_FAILURE'				=> 'Veritabanı yöneticisi için girilen kullanıc ve/veya şifre geçersiz ve veritabanı ile bağlantı kurulamadı. Lütfen geçerli bir kullanıcı ve şifre giriniz.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'Veritabanı yöneticisi için girilen kullanıc ve/veya şifre geçersiz ve veritabanı ile bağlantı kurulamadı. Lütfen geçerli bir kullanıcı ve şifre giriniz.',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'Veritabanı yöneticisi için girilen kullanıc ve/veya şifre geçersiz ve veritabanı ile bağlantı kurulamadı. Lütfen geçerli bir kullanıcı ve şifre giriniz.',
	'ERR_DB_MYSQL_VERSION'				=> 'Your MySQL version (%s) is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported MySQL versions.',
	'ERR_DB_NAME'						=> 'Veritbanı adı boş olamaz',
	'ERR_DB_NAME2'						=> "Veritabanı ismi  '', '/', or '.' karakterlerini içeremez.",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "Veritabanı ismi  '', '/', or '.' karakterlerini içeremez.",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "Database name cannot begin with a number, '#', or '@' and cannot contain a space, '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', '&', '!', or '-'",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "Database name can only consist of alphanumeric characters and the symbols '#', '_' or '$'",
	'ERR_DB_PASSWORD'					=> 'SuiteCRM veritabanı yöneticisi için girilen şifre uyumsuz.Lütfen şifre alanında şifreleri tekrar giriniz. ',
	'ERR_DB_PRIV_USER'					=> 'Bir veritabanı yöneticisi girin. Bu kullanıcı  veritabanına ilk bağlantıyı yapmak için gereklidir. ',
	'ERR_DB_USER_EXISTS'				=> 'SuiteCRM veritabanı kullanıcısı zaten mevcut --aynı isimle yeni bir tane oluşturulamaz. Lütfen yeni bri isim belirleyin.',
	'ERR_DB_USER'						=> 'SuiteCRM veritabanı yöneticisi için bir kullanıcı adı girin',
	'ERR_DBCONF_VALIDATION'				=> 'Lütfen başlamadan önce aşağıdaki hataları giderin',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'SuiteCRM veritabanı yöneticisi için girilen şifre uyumsuz.Lütfen şifre alanında şifreleri tekrar giriniz. ',
	'ERR_ERROR_GENERAL'					=> 'Aşağıdkai hatalar oluştu:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'Dosya silinemiyor:',
	'ERR_LANG_MISSING_FILE'				=> 'Dosya bulunamıyor:',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'include/language dizininde dil paketi yok: ',
	'ERR_LANG_UPLOAD_1'					=> 'Yüklemenizde hata oluştu, lütfen tekrar deneyin.',
	'ERR_LANG_UPLOAD_2'					=> 'Dil paketleri Zip arşiv dosyası olamk zorundadır.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP could not move the temp file to the upgrade directory.',
	'ERR_LICENSE_MISSING'				=> 'Doldurulmamış Zorunlu Alanlar',
	'ERR_LICENSE_NOT_FOUND'				=> 'Lisans dosyası bulunamadı!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'Girilen günlük dizini geçersiz.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'Girilen günlük dizini yazılabilir değil.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Eğer kendiniz bir günlük dizini istiyorsanız, belirtmeniz gerekir.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'Betiğin doğrudan işlenmesi mümkün değil.',
	'ERR_NO_SINGLE_QUOTE'				=> 'Tek parça iþaret için kullanýlmaz',
	'ERR_PASSWORD_MISMATCH'				=> 'SuiteCRM veritabanı yöneticisi için girilen şifre uyumsuz.Lütfen şifre alanında şifreleri tekrar giriniz. ',
	'ERR_PERFORM_CONFIG_PHP_1'			=> '<span class=stop>config.php</span> dosyasına yazılamıyor.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Kuruluma el ile config.php dosyası oluşturup , ardından aşağıdkai ayar bilgilerini config.php dosyasına kopyalayarak devam edebilirsiniz.  Sonraki adıma geçmek için <strong> mutlaka ve mutlaka </strong> config.php dosyası oluşturmalısınız.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'config.php  dosyasını oluşturduğunuzu hatırladınız mı?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Uyarı:  config.php dosyasına yazılamadı. Varolduğundan emin olmak için kontrol ediniz.',
	'ERR_PERFORM_HTACCESS_1'			=> 'yazılamıyor',
	'ERR_PERFORM_HTACCESS_2'			=> 'dosya.',
	'ERR_PERFORM_HTACCESS_3'			=> 'Eğer tarayıcı tarafından günlük dosyasına erişimi engellemek istiyorsanız, günlük dizininizde aşağıdaki satırı içeren bir  .htaccess dosyası oluşturun:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>We could not detect an Internet connection.</b> When you do have a connection, please visit <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> to register with SuiteCRM. By letting us know a little bit about how your company plans to use SuiteCRM, we can ensure we are always delivering the right application for your business needs.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'Girilen oturum dizini geçersiz.',
	'ERR_SESSION_DIRECTORY'				=> 'Girilen oturum dizini yazılabilir değil.',
	'ERR_SESSION_PATH'					=> 'Session path is required if you wish to specify your own.',
	'ERR_SI_NO_CONFIG'					=> 'You did not include config_si.php in the document root, or you did not define $sugar_config_si in config.php',
	'ERR_SITE_GUID'						=> 'Application ID is required if you wish to specify your own.',
    'ERROR_SPRITE_SUPPORT'              => "Currently we are not able to locate the GD library, as a result you will not be able to use the CSS Sprite functionality.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Warning: Your PHP configuration should be changed to allow files of at least 6MB to be uploaded.',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Yüklenecek Dosya Büyüklüğü',
	'ERR_URL_BLANK'						=> 'Provide the base URL for the SuiteCRM instance.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'Kurma kaydı bulunamıyor:',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'Yüklenen dosya, mevcut SuiteCRM sürümü ile uyumlu değil.',
	'ERROR_LICENSE_EXPIRED'				=> "Hata: Lisansınızın geçerlilik süresi sona erdi.",
	'ERROR_LICENSE_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to enter your new license key.  If you do not enter a new license key within 30 days of your license key expiration, you will no longer be able to log in to this application.",
	'ERROR_MANIFEST_TYPE'				=> 'Bildirim dosyası paket türü belirtmelisiniz.',
	'ERROR_PACKAGE_TYPE'				=> 'Bildirim dosyası, tanınmayan bir paket türünü belirtiyor.',
	'ERROR_VALIDATION_EXPIRED'			=> "Error: Your validation key expired ",
	'ERROR_VALIDATION_EXPIRED2'			=> " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a> in the Admin screen to enter your new validation key.  If you do not enter a new validation key within 30 days of your validation key expiration, you will no longer be able to log in to this application.",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'Yüklenen dosya, mevcut SuiteCRM sürümü ile uyumlu değil.',

	'LBL_BACK'							=> 'Geri',
    'LBL_CANCEL'                        => 'Vazgeç',
    'LBL_ACCEPT'                        => 'Kabul ediyorum',
	'LBL_CHECKSYS_1'					=> 'In order for your SuiteCRM installation to function properly, please ensure all of the system check items listed below are green. If any are red, please take the necessary steps to fix them.<BR><BR> For help on these system checks, please visit the <a href="http://www.suitecrm.com" target="_blank">SuiteCRM</a>.',
	'LBL_CHECKSYS_CACHE'				=> 'Writable Cache Sub-Directories',
    'LBL_DROP_DB_CONFIRM'               => 'The provided Database Name already exists.<br>You can either:<br>1.  Click on the Cancel button and choose a new database name, or <br>2.  Click the Accept button and continue.  All existing tables in the database will be dropped. <strong>This means that all of the tables and pre-existing data will be blown away.</strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned Off',
    'LBL_CHECKSYS_COMPONENT'			=> 'Bileşen',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Seçimlik Bileşenler',
	'LBL_CHECKSYS_CONFIG'				=> 'Yazılabilir  SuiteCRM Ayar Dosyası (config.php)',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Writable SuiteCRM Configuration File (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'cURL Modülü',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Session Save Path Setting',
	'LBL_CHECKSYS_CUSTOM'				=> 'Yazılabilir Özel Dizin',
	'LBL_CHECKSYS_DATA'					=> 'Yaazılabilir Veri Altdizinleri',
	'LBL_CHECKSYS_IMAP'					=> 'IMAP Module',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'MB Strings Module',
	'LBL_CHECKSYS_MEM_OK'				=> 'Tamam (Sınır yok)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'Tamam (Sınırsız)',
	'LBL_CHECKSYS_MEM'					=> 'PHP Memory Limit >= ',
	'LBL_CHECKSYS_MODULE'				=> 'Writable Modules Sub-Directories and Files',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'MySQL Sürümü',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'Mevcut değil',
	'LBL_CHECKSYS_OK'					=> 'Tamam',
	'LBL_CHECKSYS_PHP_INI'				=> 'Not: php ayar dosyası (php.ini) lokasyonu:',
	'LBL_CHECKSYS_PHP_OK'				=> 'Tamam(ver ',
	'LBL_CHECKSYS_PHPVER'				=> 'PHP Sürümü',
    'LBL_CHECKSYS_IISVER'               => 'IIS sürümü',
	'LBL_CHECKSYS_RECHECK'				=> 'Tekrar Kontrol',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP Safe Mode Kapalı',
	'LBL_CHECKSYS_SESSION'				=> 'Writable Session Save Path (',
	'LBL_CHECKSYS_STATUS'				=> 'Durum',
	'LBL_CHECKSYS_TITLE'				=> 'System Check Acceptance',
	'LBL_CHECKSYS_VER'					=> 'Bulundu: ( ver ',
	'LBL_CHECKSYS_XML'					=> 'XML Parsing',
	'LBL_CHECKSYS_ZLIB'					=> 'ZLIB Sıkıştırma Modülü',
	'LBL_CHECKSYS_ZIP'					=> 'ZIP Handling Module',
	'LBL_CHECKSYS_PCRE'					=> 'PCRE Kütüphanesi',
	'LBL_CHECKSYS_FIX_FILES'            => 'Please fix the following files or directories before proceeding:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Please fix the following module directories and the files under them before proceeding:',
    'LBL_CHECKSYS_UPLOAD'               => 'Writable Upload Directory',
    'LBL_CLOSE'							=> 'Kapat',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'oluşturulacak',
	'LBL_CONFIRM_DB_TYPE'				=> 'Veritabanı Tipi',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Please confirm the settings below.  If you would like to change any of the values, click "Back" to edit.  Otherwise, click "Next" to start the installation.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Lisans Bilgisi',
	'LBL_CONFIRM_NOT'					=> 'değil',
	'LBL_CONFIRM_TITLE'					=> 'Ayaları Onayla',
	'LBL_CONFIRM_WILL'					=> 'will',
	'LBL_DBCONF_CREATE_DB'				=> 'Veritabanı oluştur',
	'LBL_DBCONF_CREATE_USER'			=> 'Kullanıcı Oluştur',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Uyarı : Eğer bu kutu işaretli ise <br> tüm SuiteCRM verileri silinecektir.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Mevcust SuiteCRM tabloları silinip yeniden oluşturulsun mu?',
    'LBL_DBCONF_DB_DROP'                => 'Tabloları Sil',
    'LBL_DBCONF_DB_NAME'				=> 'Veritabanı Adı',
	'LBL_DBCONF_DB_PASSWORD'			=> 'SuiteCRM Veritabanı Kullanıcı Şifresi',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'SuiteCRM Veritabanı Kullanıcı Şifresi tekrar gir',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM Database User',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM Database User',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'SuiteCRM Veritabanı Yönetici Kullanıcı',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Veritabanı yönetici şifresi',
	'LBL_DBCONF_DEMO_DATA'				=> 'Veritabanı demo verileri ile mi oluşturulsun?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Demo verisi seç',
	'LBL_DBCONF_HOST_NAME'				=> 'Host Adı',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Host Instance',
	'LBL_DBCONF_HOST_PORT'				=> 'Port',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Please enter your database configuration information below. If you are unsure of what to fill in, we suggest that you use the default values.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Use multi-byte text in demo data?',
    'LBL_DBCONFIG_MSG2'                 => 'Veritabanının bulunduğu web sunucusu ya da bilgisayarın (host) adı:',
	'LBL_DBCONFIG_MSG2_LABEL' => 'Host Adı',
    'LBL_DBCONFIG_MSG3'                 => 'SuiteCRM kurulumunuzun verilerinin yer alacağı veritabanının adı:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'Veritabanı Adı',
    'LBL_DBCONFIG_B_MSG1'               => 'The username and password of a database administrator who can create database tables and users and who can write to the database is necessary in order to set up the SuiteCRM database.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
    'LBL_DBCONFIG_SECURITY'             => 'For security purposes, you can specify an exclusive database user to connect to the SuiteCRM database.  This user must be able to write, update and retrieve data on the SuiteCRM database that will be created for this instance.  This user can be the database administrator specified above, or you can provide new or existing database user information.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Bunu benim için yap',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Mevcut Kullanıcı Belirt',
    'LBL_DBCONFIG_CREATE_DD'            => 'Oluşturulacak Kullanıcı Tanımla',
    'LBL_DBCONFIG_SAME_DD'              => 'Yönetici kullanıcısı ile aynı',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'Full Text Search',
    'LBL_FTS_INSTALLED'                 => 'Kurulmuş',
    'LBL_FTS_INSTALLED_ERR1'            => 'Full Text Search capability is not installed.',
    'LBL_FTS_INSTALLED_ERR2'            => 'You can still install but will not be able to use Full Text Search functionality.  Please refer to your database server install guide on how to do this, or contact your Administrator.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Privileged Database User Password',
	'LBL_DBCONF_PRIV_USER_2'			=> 'Database Account Above Is a Privileged User?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'This privileged database user must have the proper permissions to create a database, drop/create tables, and create a user.  This privileged database user will only be used to perform these tasks as needed during the installation process.  You may also use the same database user as above if that user has sufficient privileges.',
	'LBL_DBCONF_PRIV_USER'				=> 'Privileged Database User Name',
	'LBL_DBCONF_TITLE'					=> 'Veritabanı  Ayarları',
    'LBL_DBCONF_TITLE_NAME'             => 'Veritabanı Adı Girişi',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Veritabanı Kullanıcısı Bilgi Girişi',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'Atama',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'SMTP Şifresi:',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'After this change has been made, you may click the "Start" button below to begin your installation.  <i>After the installation is complete, you will want to change the value for \'installer_locked\' to \'true\'.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'The installer has already been run once.  As a safety measure, it has been disabled from running a second time.  If you are absolutely sure you want to run it again, please go to your config.php file and locate (or add) a variable called \'installer_locked\' and set it to \'false\'.  The line should look like this:',
	'LBL_DISABLED_HELP_1'				=> 'Kurulum yardımı için, lütfen ziyaret edin SuiteCRM',
    'LBL_DISABLED_HELP_LNK'             => 'http://www.suitecrm.com/forum/index',
	'LBL_DISABLED_HELP_2'				=> 'destek forumları',
	'LBL_DISABLED_TITLE_2'				=> 'SuiteCRM Kurulumu etkisizleştirildi.',
	'LBL_DISABLED_TITLE'				=> 'SuiteCRM Kurulumu etkisizleşti.',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Character Set most commonly used in your locale',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Giden E-posta Ayarları',
    'LBL_EMAIL_CHARSET_CONF'            => 'Giden e-postalar için karakter seti',
	'LBL_HELP'							=> 'Yardım',
    'LBL_INSTALL'                       => 'Kur',
    'LBL_INSTALL_TYPE_TITLE'            => 'Kurulum Seçenekleri',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Kurulum tipi seç',
    'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>Normal Kurulum</b>',
    'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>Özel Kurulum</b>',
    'LBL_INSTALL_TYPE_MSG1'             => 'The key is required for general application functionality, but it is not required for installation. You do not need to enter the key at this time, but you will need to provide the key after you have installed the application.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Requires minimum information for the installation. Recommended for new users.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Provides additional options to set during the installation. Most of these options are also available after installation in the admin screens. Recommended for advanced users.',
	'LBL_LANG_1'						=> 'To use a language in SuiteCRM other than the default language (US-English), you can upload and install the language pack at this time. You will be able to upload and install language packs from within the SuiteCRM application as well.  If you would like to skip this step, click Next.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Kur',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Sil',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Kaldır',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Upload',
	'LBL_LANG_NO_PACKS'					=> 'boş',
	'LBL_LANG_PACK_INSTALLED'			=> 'Aşağıdaki dil paketleri yüklendi:',
	'LBL_LANG_PACK_READY'				=> 'Aşağıdaki dil paketleri yüklemeye hazur:',
	'LBL_LANG_SUCCESS'					=> 'Dil paketi başarı ile yüklendi.',
	'LBL_LANG_TITLE'			   		=> 'Dil Paketi',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Installing SuiteCRM now.  This may take up to a few minutes.',
	'LBL_LANG_UPLOAD'					=> 'Dil Paketi Yükle',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Lisans Kabulü',
    'LBL_LICENSE_CHECKING'              => 'Uygunluk için sistem kontrolü',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Ortamı kontrol ediliyor',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Verifying DB Credentials.',
    'LBL_LICENSE_CHECK_PASSED'          => 'Sistem uygunluk testini geçti.',
	'LBL_CREATE_CACHE' => 'Preparing to Install...',
    'LBL_LICENSE_REDIRECT'              => 'Redirecting in ',
	'LBL_LICENSE_DIRECTIONS'			=> 'If you have your license information, please enter it in the fields below.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Enter Download Key',
	'LBL_LICENSE_EXPIRY'				=> 'Son Geçerlilik Tarihi',
	'LBL_LICENSE_I_ACCEPT'				=> 'Kabul ediyorum',
	'LBL_LICENSE_NUM_USERS'				=> 'Kullanıcı Sayısı',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Lütfen satın alınan offline istemci sayısını girin',
	'LBL_LICENSE_OC_NUM'				=> 'Offline İstemci Sayısı',
	'LBL_LICENSE_OC'					=> 'Offline İstemci Lisansları ',
	'LBL_LICENSE_PRINTABLE'				=> 'Yadirabilir Görünüm',
    'LBL_PRINT_SUMM'                    => 'Özet Yazdır',
	'LBL_LICENSE_TITLE_2'				=> 'SuiteCRM Lisansı',
	'LBL_LICENSE_TITLE'					=> 'Lisans Bilgisi',
	'LBL_LICENSE_USERS'					=> 'Lisanslı Kullanıcılar',

	'LBL_LOCALE_CURRENCY'				=> 'Para Birimi ayarları',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Varsayılan Para Birimi',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Para Birimi Sembolü',
	'LBL_LOCALE_CURR_ISO'				=> 'Para Birimi Kodu (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> '1000 lik ayraç',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Ondalık ayraç',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Örnek',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Significant Digits',
	'LBL_LOCALE_DATEF'					=> 'Varsayılan Tarih Formatı',
	'LBL_LOCALE_DESC'					=> 'The specified locale settings will be reflected globally within the SuiteCRM instance.',
	'LBL_LOCALE_EXPORT'					=> 'İçeri /Dışarı Aktarma için  Karakter Seti<br> <i>(E-posta, .csv, vCard, PDF, veri içeri aktarma)</i>',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Dışa Aktarma (.csv) Ayracı',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'İçe/Dışa Aktar Ayarları',
	'LBL_LOCALE_LANG'					=> 'Varsayılan Dil',
	'LBL_LOCALE_NAMEF'					=> 'Varsayılan İsim Formatı',
	'LBL_LOCALE_NAMEF_DESC'				=> 's = salutation<br />f = Adı<br />l = Soyadı',
	'LBL_LOCALE_NAME_FIRST'				=> 'John',
	'LBL_LOCALE_NAME_LAST'				=> 'Doe',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Dr.',
	'LBL_LOCALE_TIMEF'					=> 'Varsayılan Saat Formatı',

    'LBL_CUSTOMIZE_LOCALE'              => 'Customize Locale Settings',
	'LBL_LOCALE_UI'						=> 'Kullanıcı Arayüzü',

	'LBL_ML_ACTION'						=> 'Action',
	'LBL_ML_DESCRIPTION'				=> 'Tanım',
	'LBL_ML_INSTALLED'					=> 'Kurulum Tarihi',
	'LBL_ML_NAME'						=> 'İsim',
	'LBL_ML_PUBLISHED'					=> 'Yayın Tarihi',
	'LBL_ML_TYPE'						=> 'Türü:',
	'LBL_ML_UNINSTALLABLE'				=> 'Kaldırılabilir değil',
	'LBL_ML_VERSION'					=> 'Sürüm',
	'LBL_MSSQL'							=> 'SQL  Sunucusu',
	'LBL_MSSQL2'                        => 'SQL Sunucusu (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver for PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (mysqli extension)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Sonraki',
	'LBL_NO'							=> 'Hayır',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Site yönetici şifresi belirleme',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'tablo denetle / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'SuiteCRM ayar dosyası oluşturuluyor',
	'LBL_PERFORM_CREATE_DB_1'			=> '<b>Veritabanı oluşturuluyor</b> ',
	'LBL_PERFORM_CREATE_DB_2'			=> ' <b>on</b> ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Veritabanı kullanıcı ve şifresi oluşturuluyor...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Varsayılan SuiteCRM verileri oluşturuluyor',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Localhost için veritabanı kullanıcı ve şifresi oluşturuluyor...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'SuiteCRM ilişki tabloları oluşturluyor',
	'LBL_PERFORM_CREATING'				=> 'oluşturuluyor / ',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Varsayılan raporlar oluşturuluyor',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Varsayılan zamanlanmış iler oluşturuluyor',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Varsayılan ayarlar ekleniyor',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Varsayılan kullanıcılar oluşturuluyor',
	'LBL_PERFORM_DEMO_DATA'				=> 'Populating the database tables with demo data (this may take a little while)',
	'LBL_PERFORM_DONE'					=> 'tamamlandı<br>',
	'LBL_PERFORM_DROPPING'				=> 'siliniyor / ',
	'LBL_PERFORM_FINISH'				=> 'Bitir',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Lisans bilgisi güncelleniyor',
	'LBL_PERFORM_OUTRO_1'				=> 'SuiteCRM Kurulum Ayarları',
	'LBL_PERFORM_OUTRO_2'				=> 'şimdi tamamlandı!',
	'LBL_PERFORM_OUTRO_3'				=> 'Toplam süre:',
	'LBL_PERFORM_OUTRO_4'				=> 'sn.',
	'LBL_PERFORM_OUTRO_5'				=> 'Tahmini kullanılan hafıza:',
	'LBL_PERFORM_OUTRO_6'				=> ' bytes.',
	'LBL_PERFORM_OUTRO_7'				=> 'Sisteminiz kuruldu, kullanım için ayarları yapıldı.',
	'LBL_PERFORM_REL_META'				=> 'relationship meta ... ',
	'LBL_PERFORM_SUCCESS'				=> 'Başarılı!',
	'LBL_PERFORM_TABLES'				=> 'SuiteCRM uygulama tabloları, denetleme tabloları ve ilişki  metaverileri oluşturuluyor.',
	'LBL_PERFORM_TITLE'					=> 'Setup Gerçekleştir',
	'LBL_PRINT'							=> 'Yazdır',
	'LBL_REG_CONF_1'					=> 'Please complete the short form below to receive product announcements, training news, special offers and special event invitations from SuiteCRM. We do not sell, rent, share or otherwise distribute the information collected here to third parties.',
	'LBL_REG_CONF_2'					=> 'İsminiz ve e-posta adresiniz kayıt için mutlaka gerekli olan alanlardır. Diğer alanlar zorunlu değildir, fakat  çok fazla yardımcıdırlar. .Burada topladığımız bilgileri, kesinlikle üçüncü şahıslara satılmaz, kiralanmaz ya da dağıtılmaz.',
	'LBL_REG_CONF_3'					=> 'Thank you for registering. Click on the Finish button to login to SuiteCRM. You will need to log in for the first time using the username "admin" and the password you entered in step 2.',
	'LBL_REG_TITLE'						=> 'Kayıt',
    'LBL_REG_NO_THANKS'                 => 'Hayır teşekkürler',
    'LBL_REG_SKIP_THIS_STEP'            => 'Skip this Step',
	'LBL_REQUIRED'						=> '* Zorunlu Alan',

    'LBL_SITECFG_ADMIN_Name'            => 'Suag Uygulama Yöneticisi Adı',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Suag Uygulama Yöneticisi Adı (Tekrar)',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Caution: This will override the admin password of any previous installation.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'SUgar yönetici şifresi',
	'LBL_SITECFG_APP_ID'				=> 'Uygulama ID',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'If selected, you must provide an application ID to override the auto-generated ID. The ID ensures that sessions of one SuiteCRM instance are not used by other instances.  If you have a cluster of SuiteCRM installations, they all must share the same application ID.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Kendi Uygulama ID\'nizi belirleyin',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'If selected, you must specify a log directory to override the default directory for the SuiteCRM log. Regardless of where the log file is located, access to it through a web browser will be restricted via an .htaccess redirect.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Özel günlük dizini kullan',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'If selected, you must provide a secure folder for storing SuiteCRM session information. This can be done to prevent session data from being vulnerable on shared servers.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Use a Custom Session Directory for SuiteCRM',
	'LBL_SITECFG_DIRECTIONS'			=> 'Please enter your site configuration information below. If you are unsure of the fields, we suggest that you use the default values.',
	'LBL_SITECFG_FIX_ERRORS'			=> '<b>Please fix the following errors before proceeding:</b>',
	'LBL_SITECFG_LOG_DIR'				=> 'Günlük Dizini',
	'LBL_SITECFG_SESSION_PATH'			=> 'Path to Session Directory<br>(must be writable)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Güvenlik seçenekleri seç',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'If selected, the system will periodically check for updated versions of the application.',
	'LBL_SITECFG_SUGAR_UP'				=> 'Güncellemeler otomatik olarak kontrol edilsin mi?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'SuiteCRM Güncelleme Ayarı',
	'LBL_SITECFG_TITLE'					=> 'Site Ayarları',
    'LBL_SITECFG_TITLE2'                => 'Identify Administration User',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Site Güvenliği',
	'LBL_SITECFG_URL'					=> 'SuiteCRM URL  Adresi',
	'LBL_SITECFG_USE_DEFAULTS'			=> 'Varsayılanlar kullanılsın mı ',
	'LBL_SITECFG_ANONSTATS'             => 'Anonim kullanım istatistikleri gönderilsin mi ?  ',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'If selected, SuiteCRM will send <b>anonymous</b> statistics about your installation to SuiteCRM Inc. every time your system checks for new versions. This information will help us better understand how the application is used and guide improvements to the product.',
    'LBL_SITECFG_URL_MSG'               => 'Enter the URL that will be used to access the SuiteCRM instance after installation. The URL will also be used as a base for the URLs in the SuiteCRM application pages. The URL should include the web server or machine name or IP address.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Enter a name for your system.  This name will be displayed in the browser title bar when users visit the SuiteCRM application.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'After installation, you will need to use the SuiteCRM admin user (default username = admin) to log in to the SuiteCRM instance.  Enter a password for this administrator user. This password can be changed after the initial login.  You may also enter another admin username to use besides the default value provided.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Select collation (sorting) settings for your system. This settings will create the tables with the specific language you use. In case your language doesn\'t require special settings please use default value.',
    'LBL_SPRITE_SUPPORT'                => 'Sprite Support',
	'LBL_SYSTEM_CREDS'                  => 'System Credentials',
    'LBL_SYSTEM_ENV'                    => 'Sistem Ortamı',
	'LBL_START'							=> 'Başla',
    'LBL_SHOW_PASS'                     => 'Şifreleri Göster',
    'LBL_HIDE_PASS'                     => 'Şifreleri Gizle',
    'LBL_HIDDEN'                        => '<i>(gizli)</i>',
	'LBL_STEP1' => 'Adım 1 / 2 - Kurulum öncesi gereksinimler',
	'LBL_STEP2' => 'Adım 2 / 2 - Yapılandırma',
//    'LBL_STEP1'                         => 'Step 1 of 8 - Pre-Installation requirements',
//    'LBL_STEP2'                         => 'Step 2 of 8 - License Agreement',
//    'LBL_STEP3'                         => 'Step 3 of 8 - Installation Type',
//    'LBL_STEP4'                         => 'Step 4 of 8 - Database Selection',
//    'LBL_STEP5'                         => 'Step 5 of 8 - Database Configuration',
//    'LBL_STEP6'                         => 'Step 6 of 8 - Site Configuration',
//    'LBL_STEP7'                         => 'Step 7 of 8 - Confirm Settings',
//    'LBL_STEP8'                         => 'Step 8 of 8 - Installation Successful',
//	'LBL_NO_THANKS'						=> 'Continue to installer',
	'LBL_CHOOSE_LANG'					=> '<b>Dilinizi seçin</b>',
	'LBL_STEP'							=> 'Adım',
	'LBL_TITLE_WELCOME'					=> 'SuiteCRM\' e hoşgeldiniz',
	'LBL_WELCOME_1'						=> 'This installer creates the SuiteCRM database tables and sets the configuration variables that you need to start. The entire process should take about ten minutes.',
	'LBL_WELCOME_2'						=> 'For installation documentation, please visit the <a href="http://www.SuiteCRM.com/" target="_blank">SuiteCRM</a>.  <BR><BR> You can also find help from the SuiteCRM Community in the <a href="http://www.SuiteCRM.com/" target="_blank">SuiteCRM Forums</a>.',
    //welcome page variables
    'LBL_TITLE_ARE_YOU_READY'            => 'Kuruluma hazır mısınız? ',
    'REQUIRED_SYS_COMP' => 'Gerekli Sistem Bileşenleri',
    'REQUIRED_SYS_COMP_MSG' =>
                    'Before you begin, please be sure that you have the supported versions of the following system
                      components:<br>
                      <ul>
                      <li> Database/Database Management System (Examples: MariaDB, MySQL or SQL Server)</li>
                      <li> Web Server (Apache, IIS)</li>
                      </ul>
                      Consult the Compatibility Matrix in the Release Notes for
                      compatible system components for the SuiteCRM version that you are installing.<br>',
    'REQUIRED_SYS_CHK' => 'Temel sistem kontrolü',
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
    'REQUIRED_INSTALLTYPE' => 'Basit ya da Özel Kurulum',
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

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '<b>Dilinizi seçin</b>',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Kurulum Sihirbazı',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'SuiteCRM\' e hoşgeldiniz',
	'LBL_WELCOME_TITLE'					=> 'SuiteCRM  Kurulum Sihirbazı',
	'LBL_WIZARD_TITLE'					=> 'SuiteCRM Kurulum Sihirbazı: ',
	'LBL_YES'							=> 'Evet',
    'LBL_YES_MULTI'                     => 'Evet - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'İş Akışı Görevlerini Gerçekleştir',
	'LBL_OOTB_REPORTS'		=> 'Rapor Üretimi Planlanmış Görevleri Çalıştırın',
	'LBL_OOTB_IE'			=> 'Check Inbound Mailboxes',
	'LBL_OOTB_BOUNCE'		=> 'Gecelik Çalışan Geri Dönen Kampanya E-Postaları',
    'LBL_OOTB_CAMPAIGN'		=> 'Kitlesel e-posta kampanyaları gece çalışsın',
	'LBL_OOTB_PRUNE'		=> 'Ayın 1\'inde Veritabanındaki fazla kısımları atın',
    'LBL_OOTB_TRACKER'		=> 'Prune tracker tables',
    'LBL_OOTB_SUGARFEEDS'   => 'Prune SuiteCRM Feed Tables',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'E-posta hatırlatma bildirimlerini çalıştır',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Update tracker_sessions table',
    'LBL_OOTB_CLEANUP_QUEUE' => 'İş sırasını temizle',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Dosya sistemi belgelerden kaldırma',


    'LBL_PATCHES_TITLE'     => 'Install Latest Patches',
    'LBL_MODULE_TITLE'      => 'Dil Paketleri İndir & Kur',
    'LBL_PATCH_1'           => 'Bu adımı atlamak için Sonraki düğmesıne tıklayın',
    'LBL_PATCH_TITLE'       => 'System Patch',
    'LBL_PATCH_READY'       => 'The following patch(es) are ready to be installed:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM relies upon PHP sessions to store important information while connected to this web server.  Your PHP installation does not have the Session information correctly configured.
											<br><br>A common misconfiguration is that the <b>'session.save_path'</b> directive is not pointing to a valid directory.  <br>
											<br> Please correct your <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>PHP configuration</a> in the php.ini file located here below.",
	'LBL_SESSION_ERR_TITLE'				=> 'PHP Sessions Configuration Error',
	'LBL_SYSTEM_NAME'=>'Sistem Adı',
    'LBL_COLLATION' => 'Collation Settings',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Provide a System Name for the SuiteCRM instance.',
	'LBL_PATCH_UPLOAD' => 'Select a patch file from your local computer',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Php versiyon 5 veya üstü gerekmekte.',
	'LBL_MINIMUM_PHP_VERSION' => 'Minimum Php version required is 5.1.0. Recommended Php version is 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(Mevut php versiyonunuz',
	'LBL_RECOMMENDED_PHP_VERSION' =>' Recommended php version is 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'Php Geri Uyumluluk modu açık. Devam etmek için zend.ze1_compatibility_mod\'u kapalı duruma getirin',
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

	'LBL_WIZARD_SMTP_DESC' => 'Atama bildirileri ve yeni kullanıcı şifresi gibi E-postaların gönderilmesi için kullanılacak e-posta hesabı temin edin. Kullanıcılar belirli bir e-posta hesabından gönderilmiş gibi Sugar\'dan e-posta alacaklar.',
	'LBL_CHOOSE_EMAIL_PROVIDER'        => 'E-Posta servis sağlayıcınızı seçiniz',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! posta',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => 'Diğer',
	'LBL_MAIL_SMTP_SETTINGS'           => 'SMTP Sunucu Özellikleri',
	'LBL_MAIL_SMTPSERVER'				=> 'SMTP Sunucusu:',
	'LBL_MAIL_SMTPPORT'					=> 'SMTP Portu',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'SMTP Kimlik Doğrulaması Kullanılsın mı?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => 'SMTP SSL ya da TLS etkinleştirilsin mi?',
	'LBL_GMAIL_SMTPUSER'					=> 'Gmail E-Posta Adresi:',
	'LBL_GMAIL_SMTPPASS'					=> 'Gmail Şifresi:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => 'Giden E-Postalar için kullanıcıların bu hesabı kullanmasına izin ver:',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => 'Bu seçenek seçildiğinde, tüm kullanıcılar sistem bildiri ve uyarılarını göndermek için kullanılan giden posta hesabını kullarak e-postalarını gönderebilecek. Eğer bu seçenek seçilmezse, kullanıcılar kendi hesap bilgilerini girdikten sonra giden mesaj sunucusunu kullanmaya devam edebilirler',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Yahoo! E-Posta Şifresi:',
	'LBL_YAHOOMAIL_SMTPUSER'					=> 'Yahoo! E-Posta ID:',

	'LBL_EXCHANGE_SMTPPASS'					=> 'Exchange Şifresi:',
	'LBL_EXCHANGE_SMTPUSER'					=> 'Exchange Kullanıcı Adı:',
	'LBL_EXCHANGE_SMTPPORT'					=> 'Exchange Sunucu Portu:',
	'LBL_EXCHANGE_SMTPSERVER'				=> 'Exchange Sunucusu:',


	'LBL_MAIL_SMTPUSER'					=> 'SMTP Kullanıcı adı:',
	'LBL_MAIL_SMTPPASS'					=> 'SMTP Şifresi:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Markala',
	'LBL_WIZARD_SYSTEM_DESC' => 'Sugar\'ınızı markalamak için organizsayonunuzun ismini ve logosunu temin ediniz.',
	'SYSTEM_NAME_WIZARD'=>'İsim:',
	'SYSTEM_NAME_HELP'=>'Tarayıcınızın başlık çubuğunda görünen isim budur.',
	'NEW_LOGO'=>'Logo seç:',
	'NEW_LOGO_HELP'=>'Dosya formatı ya jpg ya da .png olabilir. Önerilen boyut 212x40 pikseldir.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'Upload',
	'CURRENT_LOGO'=>'Mevcut Logo:',
    'CURRENT_LOGO_HELP'=>'Bu logo Sugar uygulamasının en üst sol köşesinde görünür.',

	// System Local Settings


	'LBL_LOCALE_TITLE' => 'System Locale Settings',
	'LBL_WIZARD_LOCALE_DESC' => 'Coğrafik lokasyonunuza bağlı olarak verinin Sugar\'da nasıl görünmesini istediğinizi belirleyin. Burada gerçekleştirdiğiniz ayarlar varsayılan ayarlar olacaktır. Kullanıcılar kendi tercihlerini ayarlayacaklardır.',
	'LBL_DATE_FORMAT' => 'Tarih Formatı:',
	'LBL_TIME_FORMAT' => 'Saat Formatı:',
		'LBL_TIMEZONE' => 'Saat Dilimi:',
	'LBL_LANGUAGE'=>'Dil',
	'LBL_CURRENCY'=>'Para Birimi:',
	'LBL_CURRENCY_SYMBOL'=>'Currency Symbol:',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 Currency Code:',
	'LBL_NUMBER_GROUPING_SEP' => '1000\'ler ayıracı',
	'LBL_DECIMAL_SEP' => 'Ondalık Sembolü',
	'LBL_NAME_FORMAT' => 'Name Format:',
	'UPLOAD_LOGO' => 'Please wait, logo uploading..',
	'ERR_UPLOAD_FILETYPE' => 'File type do not allowed, please upload a jpeg or png.',
	'ERR_LANG_UPLOAD_UNKNOWN' => 'Unknown file upload error occured.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => 'Yüklenen dosya php.ini\'de belirtilen upload_max_filesize direktifini geçiyor.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => 'Yüklenen dosya, HTML formunda belirtilen MAX_FILE_SIZE direktifini geçiyor.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => 'Yüklenen dosyanın sadece birkısmı yüklenebildi.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => 'Herhangi bir dosya yüklenmedi.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => 'Geçici bir dosya yok.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => 'Dosyanın diske yazılması başarısız.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.',

	'LBL_INSTALL_PROCESS' => 'Install...',

	'LBL_EMAIL_ADDRESS' => 'E-Posta Adresi:',
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
	'LBL_START' => 'Başla',


);

?>
