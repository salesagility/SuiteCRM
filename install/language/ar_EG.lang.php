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
	'LBL_BASIC_SEARCH'					=> 'بحث بسيط',
	'LBL_ADVANCED_SEARCH'				=> 'بحث متقدم',
	'LBL_BASIC_TYPE'					=> 'Basic Type',
	'LBL_ADVANCED_TYPE'					=> 'Advanced Type',
	'LBL_SYSOPTS_1'						=> 'Select from the following system configuration options below.',
    'LBL_SYSOPTS_2'                     => 'What type of database will be used for the SuiteCRM instance you are about to install?',
	'LBL_SYSOPTS_CONFIG'				=> 'System Configuration',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'تحديد نوع قاعدة البيانات',
    'LBL_SYSOPTS_DB_TITLE'              => 'نوع قاعدة البيانات',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'من فضلك أصلح أخطاء التشغيل التالية قبل المتابعة:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Please make the following directory writable:',
    'ERR_DB_VERSION_FAILURE'			=> 'Unable to check database version.',
	'DEFAULT_CHARSET'					=> 'UTF-8',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Provide the user name for the SuiteCRM admin user. ',
	'ERR_ADMIN_PASS_BLANK'				=> 'كلمة سر شوجر سي آر إم لا يمكن أن تكون فارغة',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'Errors have been detected during compatibility check.  In order for your SuiteCRM Installation to function properly, please take the proper steps to address the issues listed below and either press the recheck button, or try installing again.',
    'ERR_CHECKSYS_CALL_TIME'            => 'إمكانية Call Time Refrence مغلقة من فضلك نشطها في ملف php.ini',
	'ERR_CHECKSYS_CURL'					=> 'لم يعثر عليه: المنظم الزمني الخاص بشوجار سي آر إم سيشتغل بشكل وظيفي محدود',
    'ERR_CHECKSYS_IMAP'					=> 'لا يوجد: البريد الإلكتروني الداخلي وحملات البريد الإلكتوني تتطلب مكتبات كود IMAP وإلا فلن تعمل',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'علامات Magic Quotes GPC لا يمكن تشغيلها في حالة إستخدام خادم MS SQL ',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'تحذير: ',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> 'تحذير: المتغير  $memory_limit (غير قيمته إلى ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'ميجا أو أكثر في ملف php.ini )',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'لم تنجح كتابة وقراءة متغيرات جلسة الاستخدام. لم يتمكن من متابعة التركيب/التثبيت.: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'فشلت اعملية الكتابة والقراءة لمتغيرات قناة الإتصال. لا يمكن الإستمرار في التثبيت',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'مسار غير صالح',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'تحذير: غير قابل للكتابة',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'نسخة بي إتش بي المركّبة غير صحيحة (ver)',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'Your version of IIS is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported IIS Versions. Your version is ',
	'ERR_CHECKSYS_FASTCGI'              => 'We detect that you are not using a FastCGI handler mapping for PHP. You will need to install/configure a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported Versions. Please see <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> for details ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'For optimal experience using IIS/FastCGI sapi, set fastcgi.logging to 0 in your php.ini file.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'نسخة بي إتش بي المركّبة غير صحيحة (ver)',
    'LBL_DB_UNAVAILABLE'                => 'Database unavailable',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'Database Support was not found.  Please make sure you have the necessary drivers for one of the following supported Database Types: MySQL or MS SQLServer.  You might need to uncomment the extension in the php.ini file, or recompile with the right binary file, depending on your version of PHP.  Please refer to your PHP Manual for more information on how to enable Database Support.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'Functions associated with XML Parser Libraries that are needed by the SuiteCRM application were not found.  You might need to uncomment the extension in the  php.ini file, or recompile with the right binary file, depending on your version of PHP.  Please refer to your PHP Manual for more information.',
    'ERR_CHECKSYS_MBSTRING'             => 'لم يعثر عليه: لن يتمكن شوجار سي آر إم من معالجة العلامات متعددة البيتات. سيؤثر هذا على استقبال الرسائل ذات العلامات من مجموعات الترميز غير \\"UTF-8\\" ',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'The session.save_path setting in your php configuration file (php.ini) is not set or is set to a folder which did not exist. You might need to set the save_path setting in php.ini or verify that the folder sets in save_path exist.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'The session.save_path setting in your php configuration file (php.ini) is set to a folder which is not writeable.  Please take the necessary steps to make the folder writeable.  <br>Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'The config file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'The config override file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'The Custom Directory exists but is not writeable.  You may have to change permissions on it (chmod 766) or right click on it and uncheck the read only option, depending on your Operating System.  Please take the needed steps to make the file writeable.',
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "The files or directories listed below are not writeable or are missing and cannot be created.  Depending on your Operating System, correcting this may require you to change permissions on the files or parent directory (chmod 755), or to right click on the parent directory and uncheck the 'read only' option and apply it to all subfolders.",
    'LBL_CHECKSYS_OVERRIDE_CONFIG' => 'Config override',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'نمط التشغيل الآمن يعمل (من فضلك أوقفه بـ php.ini)',
    'ERR_CHECKSYS_ZLIB'					=> 'لا يوجد: شوجر سي آر إم يؤدي آداءا مثاليا في وجود إمكانية الضغط بإستخدام zlib',
    'ERR_CHECKSYS_ZIP'					=> 'ZIP support not found: SuiteCRM needs ZIP support in order to process compressed files.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE library not found: SuiteCRM needs PCRE library in order to process Perl style of regular expression pattern matching.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE library version: SuiteCRM needs PCRE library 7.0 or above to process Perl style of regular expression pattern matching.',
	'ERR_DB_ADMIN'						=> 'اسم المستخدم و/أو كلمة السر على قاعدة البيانات غير صحيح (خطأ تشغيل) ',
    'ERR_DB_ADMIN_MSSQL'                => 'The provided database administrator username and/or password is invalid, and a connection to the database could not be established.  Please enter a valid user name and password.',
	'ERR_DB_EXISTS_NOT'					=> 'قاعدة البيانات المحددة غير موجودة',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'قاعدة البيانات موجودة بالفعل مع بيانات التحكم. لإجراء التثبيت مع قاعدة البيانات المختارة، من فضلك أعد عملية التثبيت وإختار \\"احذف وأعد إنشاء جداول شوجر سي آر إم\\"  للتحديث، إتبع خطوات التحديث في جزأ الإدارة. من فضلك إقرأ الوثيقة الخاصة بالتحديث',
	'ERR_DB_EXISTS'						=> 'اسم قاعدة البيانات يوجد بالفعل--لا يمكن إنشاء أخرى بنفس الاسم.',
    'ERR_DB_EXISTS_PROCEED'             => 'The provided Database Name already exists.  You can<br>1.  hit the back button and choose a new database name <br>2.  click next and continue but all existing tables on this database will be dropped.  <strong>This means your tables and data will be blown away.</strong>',
	'ERR_DB_HOSTNAME'					=> 'اسم الاستضافة لا يمكن أن يكون فارغا',
	'ERR_DB_INVALID'					=> 'نوع قاعدة البيانات المختار غير صحيح',
	'ERR_DB_LOGIN_FAILURE'				=> 'اسم المستخدم و/أو كلمة السر على قاعدة بيانات شوجار سي آر إم غير صحيح',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'اسم المستخدم و/أو كلمة السر على قاعدة بيانات شوجار سي آر إم غير صحيح (خطأ تشغيل) ',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'اسم المستخدم و/أو كلمة السر على قاعدة بيانات شوجار سي آر إم غير صحيح',
	'ERR_DB_MYSQL_VERSION'				=> 'Your MySQL version (%s) is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported MySQL versions.',
	'ERR_DB_NAME'						=> 'اسم قاعدة البيانات لا يمكن أن يكون فارغا.',
	'ERR_DB_NAME2'						=> "اسم قاعدة البيانات لا يمكن أن يحتوي على / أو \\ أو \\",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "اسم قاعدة البيانات لا يمكن أن يحتوي على / أو \\ أو \\",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "Database name cannot begin with a number, '#', or '@' and cannot contain a space, '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', '&', '!', or '-'",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "Database name can only consist of alphanumeric characters and the symbols '#', '_' or '$'",
	'ERR_DB_PASSWORD'					=> 'كلمات السر الخاصة بشوجار سي آر إم غير متطابقة',
	'ERR_DB_PRIV_USER'					=> 'اسم مستخدم قاعدة البيانات ضروري.',
	'ERR_DB_USER_EXISTS'				=> 'اسم مستخدم شوجار سي آر إم موجود بالفعل--لا يمكن إنشاء آخر بنفس الاسم.',
	'ERR_DB_USER'						=> 'اسم مستخدم شوجار سي آر إم لا يمكن أن يكون فارغا.',
	'ERR_DBCONF_VALIDATION'				=> 'من فضلك أصلح أخطاء التشغيل التالية قبل المتابعة:',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'The passwords provided for the SuiteCRM database user do not match. Please re-enter the same passwords in the password fields.',
	'ERR_ERROR_GENERAL'					=> 'واجهنا أخطاء التشغيل التالية:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'لا يمكن حذف الملف: ',
	'ERR_LANG_MISSING_FILE'				=> 'لا يمكن العثور على الملف: ',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'لا يوجد حزمة لغة على المسار include/language inside: ',
	'ERR_LANG_UPLOAD_1'					=> 'كانت هناك مشكلة في عملية الرفع التي قمت بها. من فضلك حاول مرة أخرى.',
	'ERR_LANG_UPLOAD_2'					=> 'حزم اللغات لابد أن تكون أراشيف مضغوطة بصيغة \\"ZIP\\".',
	'ERR_LANG_UPLOAD_3'					=> 'بي إتش بي لا يمكنها نقل الملف الإحتياطي لمسار الترقية',
	'ERR_LICENSE_MISSING'				=> 'حقول ضرورية ناقصة',
	'ERR_LICENSE_NOT_FOUND'				=> 'ملف الرخصة غير موجود',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'مسارملف التسجيلات المقدم ليس دليلا صحيحا.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'مسار ملف التسجيلات المقدم ليس دليلا قابلا للكتابة.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'مسار ملف التسجيلات ضروري في حالة أنك ترغب في تحديد خاصتك.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'لا يمكن معالجة الكود مباشرة',
	'ERR_NO_SINGLE_QUOTE'				=> 'لا يمكن استخدام علامة التنصيص المفردة ل ',
	'ERR_PASSWORD_MISMATCH'				=> 'كلمات سر شوجار سي آر إم غير متطابقة',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'لا يمكن الكتابة لملف config.php',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'لا يمكنك مواصلة هذا التركيب/التثبيت بإنشاء ملف \\"config.php\\" يدويا ولصق معلومات التعريف أدناه في ملف \\"config.php\\". عموما، لابد أن تنشئ ملف \\"config.php\\" قبل المواصلة للخطوة التالية.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'هل تذكير أن تنشئ ملف \\"config.php\\"؟',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'تحذير: لم يمكن الكتابة لملف \\"config.php\\". من فضلك تأكد أنه موجود.',
	'ERR_PERFORM_HTACCESS_1'			=> 'لم يمكن الكتابة لـ ',
	'ERR_PERFORM_HTACCESS_2'			=> ' ملف',
	'ERR_PERFORM_HTACCESS_3'			=> 'لو  أنك تريد تأمين ملف التسجيلات الخاص بك من إمكانية الوصول عبر المستعرض، أنشئ ملف .htaccess على مسار ملف التسجيلات وبه السطر:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>We could not detect an Internet connection.</b> When you do have a connection, please visit <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a> to register with SuiteCRM. By letting us know a little bit about how your company plans to use SuiteCRM, we can ensure we are always delivering the right application for your business needs.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'مسار متغيرات قناة الإستخدام المزود غير صحيح',
	'ERR_SESSION_DIRECTORY'				=> 'مسار متغيرات قناة الإستخدام المزود غير قابل للكتابة',
	'ERR_SESSION_PATH'					=> 'مسار متغيرات قناة الإستخدام مطلوب لو أنك أردت تحديد خاصتك',
	'ERR_SI_NO_CONFIG'					=> 'لم تحتوي ملف config_si.php  على مسار المستندات، أو أنك لم تعرف المتغير $sugar_config_si  في ملف config.php',
	'ERR_SITE_GUID'						=> 'هوية التطبيق مطلوبة لو أنك تريد تحديد خاصتك',
    'ERROR_SPRITE_SUPPORT'              => "Currently we are not able to locate the GD library, as a result you will not be able to use the CSS Sprite functionality.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'تحذير: إعدادات البي إتش بي خاصتك لابد من تغييرها لكي تسمح برفع ملفات حجمها على الأقل 6 ميجا',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Upload File Size',
	'ERR_URL_BLANK'						=> 'الوصله لا يمكن أن تكون فارغة',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'لا يمكن تحديد سجل التثبيت ل',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'الملف المرفوع غير متطابق مع هذه النسخة (مفتوحة المصدر، متخصصة ، للمؤسسة) من شوجر: ',
	'ERROR_LICENSE_EXPIRED'				=> "خطأ: الترخيص خاصتك منتهي الصلاحية",
	'ERROR_LICENSE_EXPIRED2'			=> " يوم. من فضلك إذهب إلى إدارة الترخيص في شاشة الإدارة لإدخال مفتاح ترخيص جديد. لو أنك لم تدخل مفتاح ترخيص جديد خلال 30 يوم من تاريخ إنتهاء صلاحية الترخيص، فلن تتمكن من الدخول للتطبيق ثانية",
	'ERROR_MANIFEST_TYPE'				=> 'لابد من تحديد نوع الحزمة في ملف Manifest ',
	'ERROR_PACKAGE_TYPE'				=> 'نوع الحزمة غير معروف في ملف Manifest ',
	'ERROR_VALIDATION_EXPIRED'			=> "خطأ مفتاح الإستخدام منتهي الصلاحية",
	'ERROR_VALIDATION_EXPIRED2'			=> " يوم. من فضلك إذهب إلى إدارة الترخيص في شاشة الإدارة لإدخال مفتاح ترخيص جديد. لو أنك لم تدخل مفتاح تحقيق جديد خلال 30 يوم من تاريخ إنتهاء صلاحية مفتاح التحقيق، فلن تتمكن من الدخول للتطبيق ثانية",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'الملفات المرفوعة غير متطابقة مع هذه النسخة من شوجر: ',

	'LBL_BACK'							=> 'رجوع',
    'LBL_CANCEL'                        => 'ألغ [Alt+X]',
    'LBL_ACCEPT'                        => 'أقبل',
	'LBL_CHECKSYS_1'					=> 'لكي يتم تثبيت شوجر سي آر إم بنجاح. من فضلك تأكد أن كل العناصر المسرده بأسفل خضراء. لو أن أي منها أحمر من فضلك إتخذ الإجراءات اللازمة لإصلاحه',
	'LBL_CHECKSYS_CACHE'				=> 'المسارات الفرعية لتجهيز البيانات قابلة للكتابة',
    'LBL_DROP_DB_CONFIRM'               => 'The provided Database Name already exists.<br>You can either:<br>1.  Click on the Cancel button and choose a new database name, or <br>2.  Click the Accept button and continue.  All existing tables in the database will be dropped. <strong>This means that all of the tables and pre-existing data will be blown away.</strong>',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP Allow Call Time Pass Reference Turned Off',
    'LBL_CHECKSYS_COMPONENT'			=> 'مكون',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'مكونات إختيارية',
	'LBL_CHECKSYS_CONFIG'				=> 'ملف تحكم شوجر سي آر إم(config.php) قابل للكتابة ',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Writable SuiteCRM Configuration File (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'وحدة cURL',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Session Save Path Setting',
	'LBL_CHECKSYS_CUSTOM'				=> 'مسار مخصوص قابل للكتابة',
	'LBL_CHECKSYS_DATA'					=> 'المسارات الفرعية للبيانات قابلة للكتابة',
	'LBL_CHECKSYS_IMAP'					=> 'وحدة IMAP',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'وحدة نصوص MB ',
	'LBL_CHECKSYS_MEM_OK'				=> 'حسنا (غير محدود)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'حسنا(محدود)',
	'LBL_CHECKSYS_MEM'					=> 'حدود الذاكرة في بي إتش بي >= ',
	'LBL_CHECKSYS_MODULE'				=> 'المسارات الفرعية للوحدات والملفات قابلة للكتابة',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'نسخة \\"MySQL\\"',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'غير متاح',
	'LBL_CHECKSYS_OK'					=> 'موافق',
	'LBL_CHECKSYS_PHP_INI'				=> 'تم تحديد مكان ملف تعريف بي إتش (php.ini) بي خاصتك في:',
	'LBL_CHECKSYS_PHP_OK'				=> 'موافق (ver) ',
	'LBL_CHECKSYS_PHPVER'				=> 'نسخة بي إتش بي',
    'LBL_CHECKSYS_IISVER'               => 'IIS Version',
	'LBL_CHECKSYS_RECHECK'				=> 'أعد الفحص',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'نمط التشغيل الآمن لبي إتش بي تم إيقافه',
	'LBL_CHECKSYS_SESSION'				=> 'مسارحفظ متغيرات قناة الإستخدام )',
	'LBL_CHECKSYS_STATUS'				=> 'الحالة',
	'LBL_CHECKSYS_TITLE'				=> 'تم قبول فحص النظام',
	'LBL_CHECKSYS_VER'					=> 'تم العثور عليه (ver)',
	'LBL_CHECKSYS_XML'					=> 'معالجة XML ',
	'LBL_CHECKSYS_ZLIB'					=> 'وحدة ضغط البيانات ZLIB',
	'LBL_CHECKSYS_ZIP'					=> 'ZIP Handling Module',
	'LBL_CHECKSYS_PCRE'					=> 'PCRE Library',
	'LBL_CHECKSYS_FIX_FILES'            => 'Please fix the following files or directories before proceeding:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Please fix the following module directories and the files under them before proceeding:',
    'LBL_CHECKSYS_UPLOAD'               => 'Writable Upload Directory',
    'LBL_CLOSE'							=> 'أغلق',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'يكون منشأ',
	'LBL_CONFIRM_DB_TYPE'				=> 'نوع قاعدة البيانات',
	'LBL_CONFIRM_DIRECTIONS'			=> 'من فضلك أكد على الإعدادات/التجهيزات أدناه. إذا كنت ترغب في تغيير أي من القيم، اضغط على \\"رجوع\\" للتحرير. أو اضغط على \\"التالي\\" لبدء التركيب/التثبيت.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'معلومات الترخيص',
	'LBL_CONFIRM_NOT'					=> 'ليس',
	'LBL_CONFIRM_TITLE'					=> 'أكد على الإعدادات',
	'LBL_CONFIRM_WILL'					=> 'سوف',
	'LBL_DBCONF_CREATE_DB'				=> 'أنشئ قاعدة بيانات',
	'LBL_DBCONF_CREATE_USER'			=> 'أنشئ مستخدما',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'تحذير: كل بيانات شوجار سيتم حذفها إذا تم التأشير في هذا المربع',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'حذف جداول شوجار الحالية وأعد إنشاءها',
    'LBL_DBCONF_DB_DROP'                => 'Drop Tables',
    'LBL_DBCONF_DB_NAME'				=> 'اسم قاعدة البيانات',
	'LBL_DBCONF_DB_PASSWORD'			=> 'كلمة سر قاعدة البيانات',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'أعد إدخال كلمة سر قاعدة البيانات',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM Database User',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM Database User',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Database Administrator Username',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Database Admin Password',
	'LBL_DBCONF_DEMO_DATA'				=> 'تسكين قاعدة البيانات ببيانات العرض',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Choose Demo Data',
	'LBL_DBCONF_HOST_NAME'				=> 'اسم الاستضافة / حالة الاستضافة',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Host Instance',
	'LBL_DBCONF_HOST_PORT'				=> 'بورت',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'من فضلك أدخل معلومات تعريف قاعدة البيانات خاصتك. إذا لم تكن متأكدا مم تملأه، نقترح أن تستخدم القيم التلقائية.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'إستخدام النصوص متعددة البايتات في بيانات العرض؟',
    'LBL_DBCONFIG_MSG2'                 => 'Name of web server or machine (host) on which the database is located ( such as localhost or www.mydomain.com ):',
	'LBL_DBCONFIG_MSG2_LABEL' => 'اسم الاستضافة / حالة الاستضافة',
    'LBL_DBCONFIG_MSG3'                 => 'Name of the database that will contain the data for the SuiteCRM instance you are about to install:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'اسم قاعدة البيانات',
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
	'LBL_DBCONF_PRIV_PASS'				=> 'كلمة سر مستخدم قاعدة البيانات صاحب الصلاحية',
	'LBL_DBCONF_PRIV_USER_2'			=> 'هل حساب قاعدة البيانات أعلاه خاص بمستخدم صاحب صلاحية؟',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'مستخدم قاعدة البيانات صاحب الصلاحية هذا لديه التصريحات السليمة لإنشاء قاعدة بيانات، وإسقاط/إنشاء الجداول، وإنشاء مستخدم. سيكون مستخدم قاعدة البيانات صاحب الصلاحية هذا فقط بغرض القيام بهذه المهام كما هو مطلوب أثناء عملية التركيب/التثبيت. يمكنك أن تستخدم أيضا نفس مستخدم قاعدة البيانات كما هو أعلاه لو كان لهذا المستخدم الصلاحيات الكافية.',
	'LBL_DBCONF_PRIV_USER'				=> 'اسم مستخدم قاعدة البيانات صاحب الصلاحية',
	'LBL_DBCONF_TITLE'					=> 'تعريف قاعدة البيانات',
    'LBL_DBCONF_TITLE_NAME'             => 'Provide Database Name',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Provide Database User Information',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'مستخدم',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'كمة سر',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'بعد أن يكون إجراء هذا التغيير قد تم يمكنك الضغط على زر \\"ابدأ\\" أدناه لتبدأ التركيب/التثبيت. بعد أن يكتمل التركيب/التثبيت، ستحتاج تغيير قيمة installer-locked\\"\\" إلى true\\"\\".',
	'LBL_DISABLED_DESCRIPTION'			=> 'برنامج التركيب/التثبيت تم تشغيله فعليا مرة. كإجراء للأمان، فقد أوقِف لعدم تشغيله مرة ثانية. إذا كنت متأكدا تماما من أنك تريد تشغيله ثانية، من فضلك اذهب لملف \\"config.php\\" وحدد موقع (أو أضف) المتغير المسمى \\"installer_locked\\" واضبطه على \\"خطأ\\". سيظهر السطر بهذه الصورة:',
	'LBL_DISABLED_HELP_1'				=> 'للمساعدة في التركيب/التثبيت، من فضلك زر شوجار سي آر إم',
    'LBL_DISABLED_HELP_LNK'             => 'http://www.suitecrm.com/forum/index',
	'LBL_DISABLED_HELP_2'				=> 'منتديات الدعم',
	'LBL_DISABLED_TITLE_2'				=> 'لقد تم إيقاف تركيب شوجار سي آر إم',
	'LBL_DISABLED_TITLE'				=> 'تركيب شوجار سي آر إم موقوف',
	'LBL_EMAIL_CHARSET_DESC'			=> 'اضبط هذا على مجموعة ترميز العلامات الأكثر استخداما في محل إقامتك',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'ترميز البريد الإلكتروني غير ممكن',
    'LBL_EMAIL_CHARSET_CONF'            => 'Character Set for Outbound Email ',
	'LBL_HELP'							=> 'مساعدة',
    'LBL_INSTALL'                       => 'ركّب',
    'LBL_INSTALL_TYPE_TITLE'            => 'Installation Options',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Choose Install Type',
    'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>Typical Install</b>',
    'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>Custom Install</b>',
    'LBL_INSTALL_TYPE_MSG1'             => 'The key is required for general application functionality, but it is not required for installation. You do not need to enter the key at this time, but you will need to provide the key after you have installed the application.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Requires minimum information for the installation. Recommended for new users.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Provides additional options to set during the installation. Most of these options are also available after installation in the admin screens. Recommended for advanced users.',
	'LBL_LANG_1'						=> 'إذا كنت راغبا في تركيب حزمة لغة غير إنجليزية الولايات المتحدة التلقائية، من فضلك افعل ذلك أسفل. أو اضغط \\"التالي\\" لتتابع إلى الخطوة التالية.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'ركّب',
	'LBL_LANG_BUTTON_REMOVE'			=> 'أزِل',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'تراجع عن التركيب',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'ارفع',
	'LBL_LANG_NO_PACKS'					=> 'لا شئ',
	'LBL_LANG_PACK_INSTALLED'			=> 'لقد تم تركيب حزم اللغة التالية: ',
	'LBL_LANG_PACK_READY'				=> 'حزم اللغة التالية جاهزة لتركيبها: ',
	'LBL_LANG_SUCCESS'					=> 'رُفعت حزمة اللغة بنجاح',
	'LBL_LANG_TITLE'			   		=> 'حزمة لغة',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Installing SuiteCRM now.  This may take up to a few minutes.',
	'LBL_LANG_UPLOAD'					=> 'ارفع حزمة لغة',
	'LBL_LICENSE_ACCEPTANCE'			=> 'قبول الرخصة',
    'LBL_LICENSE_CHECKING'              => 'Checking system for compatibility.',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Checking Environment',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Verifying DB Credentials.',
    'LBL_LICENSE_CHECK_PASSED'          => 'System passed check for compatibility.',
	'LBL_CREATE_CACHE' => 'Preparing to Install...',
    'LBL_LICENSE_REDIRECT'              => 'Redirecting in ',
	'LBL_LICENSE_DIRECTIONS'			=> 'إذا كانت لديك معلومات رخصتك، من فضلك أدخلها في الحقول أدناه.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'مفتاح التنزيل',
	'LBL_LICENSE_EXPIRY'				=> 'تاريخ الانتهاء',
	'LBL_LICENSE_I_ACCEPT'				=> 'أقبل',
	'LBL_LICENSE_NUM_USERS'				=> 'عدد المستخدمين',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'من فضلك أدخل عدد النسخ المشتراه دون إتصال',
	'LBL_LICENSE_OC_NUM'				=> 'عدد رخص المتسخدمين غير المتصلين',
	'LBL_LICENSE_OC'					=> 'رخص المتسخدمين غير المتصلين',
	'LBL_LICENSE_PRINTABLE'				=> 'شكل قابل للطباعة ',
    'LBL_PRINT_SUMM'                    => 'Print Summary',
	'LBL_LICENSE_TITLE_2'				=> 'رخصة شوجار سي آر إم',
	'LBL_LICENSE_TITLE'					=> 'معلومات الترخيص',
	'LBL_LICENSE_USERS'					=> 'مستخدمون مرخصون',

	'LBL_LOCALE_CURRENCY'				=> 'إعدادات/تجهيزات العملة',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'العملة الإفتراضية',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'رمز العملة',
	'LBL_LOCALE_CURR_ISO'				=> 'شفرة العملة (منظمة المعايير العالمية أيزو 4217)',
	'LBL_LOCALE_CURR_1000S'				=> 'فاصلة الآلاف',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'الفاصلة العشرية',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'مثال',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'أرقام هامة',
	'LBL_LOCALE_DATEF'					=> 'صيغة التاريخ التلقائية',
	'LBL_LOCALE_DESC'					=> 'اضبط إعداداتك لشوجار سي آر إم الخاصة بالمكان',
	'LBL_LOCALE_EXPORT'					=> 'تصدير/ إستيراد ترميز اللغة  (Email, .csv, vCard, PDF, data import)',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'تصدير بفواصل (.csv)',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'صدّر الإعدادات',
	'LBL_LOCALE_LANG'					=> 'اللغة التلقائية',
	'LBL_LOCALE_NAMEF'					=> 'صيغة الاسم التلقائية',
	'LBL_LOCALE_NAMEF_DESC'				=> '\\"ت\\" لقب التحية    \\"ل\\" الاسم الأول    \\"ر\\" اسم الأخير',
	'LBL_LOCALE_NAME_FIRST'				=> 'ديفيد',
	'LBL_LOCALE_NAME_LAST'				=> 'لفنجستون',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'الدكتور.',
	'LBL_LOCALE_TIMEF'					=> 'صيغة الوقت الإفتراضية',

    'LBL_CUSTOMIZE_LOCALE'              => 'Customize Locale Settings',
	'LBL_LOCALE_UI'						=> 'واجهة المستخدم',

	'LBL_ML_ACTION'						=> 'قرار',
	'LBL_ML_DESCRIPTION'				=> 'وصف',
	'LBL_ML_INSTALLED'					=> 'تاريخ التثبيت',
	'LBL_ML_NAME'						=> 'اسم',
	'LBL_ML_PUBLISHED'					=> 'تاريخ النشر',
	'LBL_ML_TYPE'						=> 'النوع',
	'LBL_ML_UNINSTALLABLE'				=> 'الغاء التثبيت',
	'LBL_ML_VERSION'					=> 'نسخة',
	'LBL_MSSQL'							=> 'خادم SQL',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver for PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (mysqli extension)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'التالي',
	'LBL_NO'							=> 'لا',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'ضبط كلمة سر الإدارة',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'راجع الجدول / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'جاري إنشاء ملف تحكم شوجار',
	'LBL_PERFORM_CREATE_DB_1'			=> 'جاري إنشاء قاعدة البيانات ',
	'LBL_PERFORM_CREATE_DB_2'			=> 'يعمل ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'جاري إنشاء اسم مستخدم وكلمة سر قاعدة البيانات',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'جاري إنشاء بيانات شوجار التلقائية',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'جاري إنشاء اسم مستخدم وكلمة سر قاعدة البيانات للمضيف المحلي',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'جاري إنشاء جداول العلاقات لشوجر',
	'LBL_PERFORM_CREATING'				=> 'جاري إنشاء/ ',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'جاري إنشاء التقارير الإفتراضية',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'جاري إنشاء الجدولة الإفتراضية للمهام',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'جاري تسكين الإعدادات الإفتراضية',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'جاري إنشاء المستخدمين الإفتراضيين',
	'LBL_PERFORM_DEMO_DATA'				=> 'جاري تسكين قاعدة جداول قاعدة البيانات ببيانات للعرض(من الممكن أن يهلك القليل من الوقت)',
	'LBL_PERFORM_DONE'					=> 'تم',
	'LBL_PERFORM_DROPPING'				=> 'جاري الحذف/ ',
	'LBL_PERFORM_FINISH'				=> 'إنتهى',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'جاري تحديث بيانات الترخيص',
	'LBL_PERFORM_OUTRO_1'				=> 'تثبيت شوجر ',
	'LBL_PERFORM_OUTRO_2'				=> ' حاليا مكتمل',
	'LBL_PERFORM_OUTRO_3'				=> 'الوقت الكلي: ',
	'LBL_PERFORM_OUTRO_4'				=> ' ثانية',
	'LBL_PERFORM_OUTRO_5'				=> 'الذاكرة المستخدمة تقريبا: ',
	'LBL_PERFORM_OUTRO_6'				=> ' بايت',
	'LBL_PERFORM_OUTRO_7'				=> 'تم تثبيت نظامك وتجهيزه للإستخدام',
	'LBL_PERFORM_REL_META'				=> 'خصائص العلاقات ',
	'LBL_PERFORM_SUCCESS'				=> 'تم بنجاح !',
	'LBL_PERFORM_TABLES'				=> 'جاري إنشاء جداول التطبيق وجداول المراجعة الحسابية وبيانات العلاقات الخاصة بشوجار...',
	'LBL_PERFORM_TITLE'					=> 'قم بالتجهيز للتركيب',
	'LBL_PRINT'							=> 'اطبع',
	'LBL_REG_CONF_1'					=> 'من فضلك خذ لحظة من وقتك للتسجيل في شوجار سي آر إم. عندما تعرّفنا قليلا عن كيف تخطط شركتك لاستخدام شوجار سي آر إم، يمكننا أن نؤكد أننا نعطي دائما المنتج السليم لاحتياجات عملك.',
	'LBL_REG_CONF_2'					=> 'اسمك وعنوان بريدك الإلكتروني هي الحقول الوحيدة الإجبارية للتسجيل. كل الحقول الأخرى اختيارية ولكنها مفيدة جدا. نحن لا نبيع أو نؤجر أو نتشارك أو نوزع بأي طريقة أخرى ما نجمعه هنا من معلومات إلى أطراف ثالثة.',
	'LBL_REG_CONF_3'					=> 'شكرا لتسجيلك. اضغط على زر إنهاء لتسجل الدخول في شوجار سي آر إم. ستحتاج إلى تسجيل الدخول في المرة الأولى مستخدما اسم المستخدم \\"admin\\" وكلمة السر التي أدخلتها في الخطوة 2.',
	'LBL_REG_TITLE'						=> 'تسجيل',
    'LBL_REG_NO_THANKS'                 => 'No Thanks',
    'LBL_REG_SKIP_THIS_STEP'            => 'Skip this Step',
	'LBL_REQUIRED'						=> 'حقل إجباري*',

    'LBL_SITECFG_ADMIN_Name'            => 'SuiteCRM Application Admin Name',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'أعد إدخال كلمة سر شوجار الخاصة بالإدارة',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'تحذير: سيحل هذا محل كلمة السر في أي تركيب سابق.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'كلمة سر إدارة شوجار',
	'LBL_SITECFG_APP_ID'				=> 'اسم هوية التطبيق',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'الطمث على إسم التطبيق ذاتي الإنشاء سوف يجعل متغيرات قناة الإستخدام المستعملة في نموذج من إستخدامها في نموذج آخر ',
	'LBL_SITECFG_CUSTOM_ID'				=> 'حدد إسم التطبيق خاصتك',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'الطمث على المسار الإفتراضي لملف التسجيلات. سوف يقصر الوصول إليه من خلال المستعرض على الوصول من خلال ملفات .htaccess ',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'إتسخدام مسار مخصوص لملف التسجيلات',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'زود بمسار آمن لتحفظ متغيرات جلسة الإستخدام لمنع بيانات جلسة الإستخدام من الإختراق من الخوادم المشتركة',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'إستخدم مسارمخصوص لمتغيرات جلسة الإستخدام',
	'LBL_SITECFG_DIRECTIONS'			=> 'من فضلك ادخل إعدادات موقع الإنترنت خاصتك بأسفل. لو أنك غير متأكد من الحقول. نقترح أن تترك القيم الإفتراضية',
	'LBL_SITECFG_FIX_ERRORS'			=> 'من فضلك أصلح أخطاء التشغيل التالية قبل المتابعة:',
	'LBL_SITECFG_LOG_DIR'				=> 'ملف التسجيل',
	'LBL_SITECFG_SESSION_PATH'			=> 'مسار ملف جلسات الاستخدام (لابد أن يكون قابلا للكتابة)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'تأمين متقدم للموقع',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'لو تم التأشير عليه. سوف يقوم النظام بتفقد النسخ الجديدة المتاحة من التطبيق',
	'LBL_SITECFG_SUGAR_UP'				=> 'تفقد آلي للتحديثات؟',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'جاري تحديث الإعدادات',
	'LBL_SITECFG_TITLE'					=> 'تعريف الموقع',
    'LBL_SITECFG_TITLE2'                => 'Identify Administration User',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Site Security',
	'LBL_SITECFG_URL'					=> 'وصلة شوجر',
	'LBL_SITECFG_USE_DEFAULTS'			=> 'إستخدم الإفتراضي؟',
	'LBL_SITECFG_ANONSTATS'             => 'إرسال إحصائيات الإستخدام؟',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'لو تم التأشير عليه سوف يقوم شوجر بإرسال إحصائيات عن النسخة المثبتة إلى شركة شوجر سي آر إم. في كل مره سوف يقوم النظام بالتحقق من وجود نسخ جديدة. هذه المعلومات سوف تساعدنا في فهم كيفية إستخدام التطبيق وتكون دليلا لتطوير المنتج.',
    'LBL_SITECFG_URL_MSG'               => 'Enter the URL that will be used to access the SuiteCRM instance after installation. The URL will also be used as a base for the URLs in the SuiteCRM application pages. The URL should include the web server or machine name or IP address.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Enter a name for your system.  This name will be displayed in the browser title bar when users visit the SuiteCRM application.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'After installation, you will need to use the SuiteCRM admin user (default username = admin) to log in to the SuiteCRM instance.  Enter a password for this administrator user. This password can be changed after the initial login.  You may also enter another admin username to use besides the default value provided.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Select collation (sorting) settings for your system. This settings will create the tables with the specific language you use. In case your language doesn\'t require special settings please use default value.',
    'LBL_SPRITE_SUPPORT'                => 'Sprite Support',
	'LBL_SYSTEM_CREDS'                  => 'System Credentials',
    'LBL_SYSTEM_ENV'                    => 'System Environment',
	'LBL_START'							=> 'ابدأ',
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
	'LBL_CHOOSE_LANG'					=> 'إختار اللغة خاصتك',
	'LBL_STEP'							=> 'خطوة',
	'LBL_TITLE_WELCOME'					=> 'مرحبا بك في شوجر سي آر إم ',
	'LBL_WELCOME_1'						=> 'برنامج التثبيت الجاري إستخدامه سوف يقوم بإنشاء قاعدة البيانات والجداول الخاصة بشوجر سي آر إم وإنشاء متغيرات التحكم التي تحتاجها لكي تبدأ. العملية كاملة سوف تستغرق حوالي 10 دقائق.',
	'LBL_WELCOME_2'						=> 'للمساعدة في التثبيت، من فضلك زور<a href=\\"/forums\\">منتديات دعم</a>  شوجر سي آر إم',
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

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> 'إختار اللغة خاصتك',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'حوار التثبيت',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'مرحبا بك في شوجر سي آر إم ',
	'LBL_WELCOME_TITLE'					=> 'حوار تثبيت شوجر سي آر إم',
	'LBL_WIZARD_TITLE'					=> 'حوار تثبيت شوجر سي آر إم: خطوة',
	'LBL_YES'							=> 'نعم',
    'LBL_YES_MULTI'                     => 'Yes - Multibyte',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'مهام سير العملية',
	'LBL_OOTB_REPORTS'		=> 'شغل المهام المجدولة لإنشاؤ التقارير',
	'LBL_OOTB_IE'			=> 'تفقد صندوق البريد المحلي',
	'LBL_OOTB_BOUNCE'		=> 'شغل حملة البريد الإلكتروني ',
    'LBL_OOTB_CAMPAIGN'		=> 'شغل حملات البريد الجماعية الليلية',
	'LBL_OOTB_PRUNE'		=> 'تقليم قاعدة البيانات على اول الشهر',
    'LBL_OOTB_TRACKER'		=> 'Prune tracker tables',
    'LBL_OOTB_SUGARFEEDS'   => 'Prune SuiteCRM Feed Tables',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Run Email Reminder Notifications',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Update tracker_sessions table',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Clean Jobs Queue',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Removal of documents from filesystem',


    'LBL_PATCHES_TITLE'     => 'Install Latest Patches',
    'LBL_MODULE_TITLE'      => 'Install Language Packs',
    'LBL_PATCH_1'           => 'If you would like to skip this step, click Next.',
    'LBL_PATCH_TITLE'       => 'System Patch',
    'LBL_PATCH_READY'       => 'The following patch(es) are ready to be installed:',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM relies upon PHP sessions to store important information while connected to this web server.  Your PHP installation does not have the Session information correctly configured.
											<br><br>A common misconfiguration is that the <b>'session.save_path'</b> directive is not pointing to a valid directory.  <br>
											<br> Please correct your <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>PHP configuration</a> in the php.ini file located here below.",
	'LBL_SESSION_ERR_TITLE'				=> 'PHP Sessions Configuration Error',
	'LBL_SYSTEM_NAME'=>'System Name',
    'LBL_COLLATION' => 'Collation Settings',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Provide a System Name for the SuiteCRM instance.',
	'LBL_PATCH_UPLOAD' => 'Select a patch file from your local computer',
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
	'LBL_SMTPTYPE_OTHER'                  => 'غيره',
	'LBL_MAIL_SMTP_SETTINGS'           => 'SMTP Server Specification',
	'LBL_MAIL_SMTPSERVER'				=> 'خادم \\"SMTP\\":',
	'LBL_MAIL_SMTPPORT'					=> 'منفذ  \\"SMTP\\":',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'استخدم تحقيق صلاحية  \\"SMTP\\"؟',
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


	'LBL_MAIL_SMTPUSER'					=> 'إسم مستخدم \\"SMTP\\":',
	'LBL_MAIL_SMTPPASS'					=> 'كلمة سر  \\"SMTP\\":',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Branding',
	'LBL_WIZARD_SYSTEM_DESC' => 'Provide your organization\'s name and logo in order to brand your SuiteCRM.',
	'SYSTEM_NAME_WIZARD'=>'اسم:',
	'SYSTEM_NAME_HELP'=>'This is the name that displays in the title bar of your browser.',
	'NEW_LOGO'=>'ارفع الشعار الجديد (212x40)',
	'NEW_LOGO_HELP'=>'The image file format can be either .png or .jpg. The maximum height is 170px, and the maximum width is 450px. Any image uploaded that is larger in any direction will be scaled to these max dimensions.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'ارفع',
	'CURRENT_LOGO'=>'الشعار الحالي مستخدم',
    'CURRENT_LOGO_HELP'=>'This logo is displayed in the left-hand corner of the footer of the SuiteCRM application.',

	// System Local Settings


	'LBL_LOCALE_TITLE' => 'System Locale Settings',
	'LBL_WIZARD_LOCALE_DESC' => 'Specify how you would like data in SuiteCRM to be displayed, based on your geographical location. The settings you provide here will be the default settings. Users will be able set their own preferences.',
	'LBL_DATE_FORMAT' => 'صيغة التاريخ:',
	'LBL_TIME_FORMAT' => 'صيغة الوقت:',
		'LBL_TIMEZONE' => 'Time Zone:',
	'LBL_LANGUAGE'=>'لغة:',
	'LBL_CURRENCY'=>'العملة:',
	'LBL_CURRENCY_SYMBOL'=>'Currency Symbol:',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 Currency Code:',
	'LBL_NUMBER_GROUPING_SEP' => '1000s separator:',
	'LBL_DECIMAL_SEP' => 'Decimal symbol:',
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

	'LBL_EMAIL_ADDRESS' => 'بريد الكتروني:',
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
	'LBL_START' => 'ابدأ',


);

?>
