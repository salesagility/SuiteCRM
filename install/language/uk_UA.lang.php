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
	'LBL_BASIC_SEARCH'					=> 'Базовий пошук',
	'LBL_ADVANCED_SEARCH'				=> 'Розширений пошук',
	'LBL_BASIC_TYPE'					=> 'Basic Type',
	'LBL_ADVANCED_TYPE'					=> 'Advanced Type',
	'LBL_SYSOPTS_1'						=> 'Встановіть параметри конфігурації.',
    'LBL_SYSOPTS_2'                     => 'Який тип бази даних буде використовуватися в системі?',
	'LBL_SYSOPTS_CONFIG'				=> 'Конфігурація системи',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> 'Вкажіть тип бази даних',
    'LBL_SYSOPTS_DB_TITLE'              => 'Тип бази даних',
	'LBL_SYSOPTS_ERRS_TITLE'			=> 'Будь ласка, виправте наступні помилки перед тим, як продовжити:',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => 'Такі папки повинні бути доступні для запису:',
    'ERR_DB_VERSION_FAILURE'			=> 'Unable to check database version.',
	'DEFAULT_CHARSET'					=> 'UTF-8',
    'ERR_ADMIN_USER_NAME_BLANK'         => 'Введіть логін адміністратора Sugar.',
	'ERR_ADMIN_PASS_BLANK'				=> 'Введіть пароль адміністратора Sugar.',

    //'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
    'ERR_CHECKSYS'                      => 'У процесі перевірки сумісності були виявлені помилки. Для того, щоб ваша система функціонувала правильно, будь ласка, виконайте необхідні дії над пунктами, вказаними нижче, і повторіть перевірку, або почати установку заново.',
    'ERR_CHECKSYS_CALL_TIME'            => 'Allow Call Time Pass Reference включена (вимкніть цю опцію у php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'Не знайдено: Планувальник Sugar буде запущений з обмеженою функціональністю.',
    'ERR_CHECKSYS_IMAP'					=> 'Не знайдено: для нормальної роботи вхідної пошти і кампаній необхідна наявність сервера IMAP бібліотек',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC не можна включити при використанні MS SQL Server',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> 'Увага:',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> '(Встановіть значення на',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M або більше в php.ini)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Мінімальна версія 4.1.2 - Знайдена:',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Помилка читання і запису сесійних змінних. Продовження встановлення неможливе.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'Недійсна директорія',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Увага: Недоступно для запису',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Ваша версія PHP не підтримується в Sugar. Вам необхідно буде встановити версію, яка підтримується додатком Sugar. Будь ласка, зверніться до Матриці Сумісності в примітках до Версії, щоб дізнатися, які версії PHP підтримуються. Ваша поточна версія:',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'Ваша версія IIS не підтримується в Sugar. Вам необхідно буде встановити версію, яка підтримується додатком Sugar. Будь ласка, зверніться до Матриці Сумісності в примітках до Версії, щоб дізнатися, які версії IIS підтримуються. Ваша поточна версія:',
	'ERR_CHECKSYS_FASTCGI'              => 'Було помічено, що ви не використовуєте FastCGI handler mapping для PHP. Вам необхідно буде встановити версію, яка підтримується додатком Sugar. Будь ласка, зверніться до Матриці Сумісності в примітках до Версії, щоб дізнатися, які версії підтримуються. Будь ласка, пройдіть за посиланням <a href="http://www.iis.net/php/">http://www.iis.net/php/</a>, щоб отримати більше інформації.',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'Для оптимального використання IIS / FastCGI SAPI, встановіть параметр fastcgi.logging файл php.ini рівним 0.',
    'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Встановлена версія PHP, яка не підтримується: (вер',
    'LBL_DB_UNAVAILABLE'                => 'База даних недоступна',
    'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => 'Підтримка бази даних не виявлено. Переконайтеся, що у вас є необхідні драйвера для одного з наступних типів БД: MySQL, MS SQLServer або Oracle. Ймовірно, вам необхідно розкоментувати відповідне розширення файлу php.ini, або перекомпілювати бінарний файл у відповідності з вашою версією PHP. Будь ласка, зверніться до посібника користувача PHP за більш докладною інформацією про підтримку вашого типу БД.',
    'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'Функції для роботи з XML-парсером не виявлені. Ймовірно, вам необхідно розкоментувати відповідне розширення файлу php.ini, або перекомпілювати бінарний файл у відповідності з вашою версією PHP. Будь ласка, зверніться до посібника користувача PHP за більш детальною інформацією.',
    'ERR_CHECKSYS_MBSTRING'             => 'Не знайдено функцію, пов&#039;язану із розширенням MBSTRING. <br /><br />Зазвичай модуль MBSTRING не включений за умовчанням в PHP і повинен бути активований шляхом додавання опції --enable-mbstring при зборці PHP. Будь ласка, зверніться до посібника користувача PHP за більш детальною інформацією.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'Параметр session.save_path в файлі php.ini не встановлений або він посилається на неіснуючу папку. Вам необхідно встановити save_path setting в php.ini або переконатися в існуванні вказаної папки.',
    'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'Параметр session.save_path в файлі php.ini посилається на папку, яка не доступна для запису. Будь ласка, виконайте необхідні кроки для того, щоб зробити її доступною для запису. Залежно від типу вашої операційної системи вам знадобиться або змінити права доступу до файлу, шляхом виконання команди &quot;chmod 766&quot;, або, натиснувши правою кнопкою на файлі, отримати доступ до властивостей файлу і зняти позначку з пункту &quot;read only&quot;.',
    'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'Файл конфігурації існує, але він не доступний для запису. Будь ласка, виконайте необхідні кроки для того, щоб зробити його доступним для запису. Залежно від типу вашої операційної системи вам знадобиться або змінити права доступу до файлу, шляхом виконання команди &quot;chmod 766&quot;, або, натиснувши правою кнопкою на файлі, отримати доступ до властивостей файлу і зняти позначку з пункту &quot;read only&quot;',
    'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'The config override file exists but is not writeable.  Please take the necessary steps to make the file writeable.  Depending on your Operating system, this might require you to change the permissions by running chmod 766, or to right click on the filename to access the properties and uncheck the read only option.',
    'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => 'Користувацький каталог існує, але не доступний для запису. Можливо, вам знадобиться або змінити права доступу до теки, шляхом виконання команди &quot;chmod 766&quot;, або, натиснувши на папку правою кнопкою миші, отримати доступ до її властивостям і зняти позначку з пункту &quot;read only&quot;, в залежності від вашої операційної системи. Будь ласка, виконайте необхідні кроки для того, щоб зробити його доступним для запису.',
    'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "Перераховані файли та папки не доступні для запису або відсутні і не можуть бути створені. Залежно від типу вашої операційної системи для виправлення ситуації вам знадобиться або змінити права доступу до файлу чи батьківської теки шляхом виконання команди &quot;chmod 766&quot;, або, натиснувши на папку правою кнопкою миші, отримати доступ до властивостей папки і зняти позначку з пункту &quot;read only&quot;, застосувавши дану дію до всіх підпапках.",
    'LBL_CHECKSYS_OVERRIDE_CONFIG' => 'Config override',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'Безпечний режим включений (вимкнути цю опцію можна у php.ini)',
    'ERR_CHECKSYS_ZLIB'					=> 'Не знайдено: модуль zlib, що дозволяє підвищити продуктивність SugarCRM при використанні zlib-стиснення.',
    'ERR_CHECKSYS_ZIP'					=> 'Не знайдена підтримка ZIP. SugarCRM потрібна підтримка ZIP-архівів для обробки стислих файлів.',
    'ERR_CHECKSYS_PCRE'					=> 'PCRE library not found: SuiteCRM needs PCRE library in order to process Perl style of regular expression pattern matching.',
    'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE library version: SuiteCRM needs PCRE library 7.0 or above to process Perl style of regular expression pattern matching.',
	'ERR_DB_ADMIN'						=> 'Ім&#039;я адміністратора бази даних і/або пароль неправильні. Неможливо з&#039;єднатися з базою даних. Будь ласка, введіть коректні логін і пароль. (Помилка:',
    'ERR_DB_ADMIN_MSSQL'                => 'Ім&#039;я адміністратора бази даних і/або пароль неправильні. Неможливо з&#039;єднатися з базою даних. Будь ласка, введіть коректні логін і пароль.',
	'ERR_DB_EXISTS_NOT'					=> 'Ця база даних не існує.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'База даних вже існує. Щоб встановити систему з обраної базою даних, перезапустіть процес установки і виберіть пункт "Видалити і створити заново існуючі таблиці SugarCRM?". Для оновлення системи використовуйте Майстер Оновлень в панелі адміністратора. Більш детальну інформацію про процес оновлення Ви можете отримати <a href="http://www.sugarforge.org/content/downloads/" target="_new">тут</a>.',
	'ERR_DB_EXISTS'						=> 'База даних з таким ім&#039;ям вже існує, не можна створити ще одну базу з таким же ім&#039;ям.',
    'ERR_DB_EXISTS_PROCEED'             => 'База даних з таким ім&#039;ям вже існує. Ви можете: <br />1. натиснути на кнопку &quot;Назад&quot; і вказати інше ім&#039;я бази даних<br />2. натиснути на кнопку &quot;Далі&quot; і продовжити установку, але в цьому випадку <strong> всі таблиці в цій базі даних будуть видалені.</strong>',
	'ERR_DB_HOSTNAME'					=> 'Ім&#039;я хоста не може бути порожнім.',
	'ERR_DB_INVALID'					=> 'Обраний неправильний тип бази даних',
	'ERR_DB_LOGIN_FAILURE'				=> 'Наданий сервер бази даних, логін і пароль неправильні, та з&#039;єднання з базою даних не було встановлено. Будь ласка, введіть дійсні сервер бази даних, логін і пароль.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'Наданий сервер бази даних, логін і пароль неправильні, та з&#039;єднання з базою даних не було встановлено. Будь ласка, введіть дійсні сервер бази даних, логін і пароль.',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'Наданий сервер бази даних, логін і пароль неправильні, та з&#039;єднання з базою даних не було встановлено. Будь ласка, введіть дійсні сервер бази даних, логін і пароль.',
	'ERR_DB_MYSQL_VERSION'				=> 'Your MySQL version (%s) is not supported by SuiteCRM.  You will need to install a version that is compatible with the SuiteCRM application.  Please consult the Compatibility Matrix in the Release Notes for supported MySQL versions.',
	'ERR_DB_NAME'						=> 'Назва бази даних не повинна бути порожньою.',
	'ERR_DB_NAME2'						=> "Ім&#039;я бази даних не може містити &#039;\\&#039;, &#039;/&#039; або &#039;.&#039;",
    'ERR_DB_MYSQL_DB_NAME_INVALID'      => "Ім&#039;я бази даних не може містити &#039;\\&#039;, &#039;/&#039; або &#039;.&#039;",
    'ERR_DB_MSSQL_DB_NAME_INVALID'      => "Ім&#039;я бази даних не може містити наступні символи: &#039;&quot;&#039;, &quot;&#039;&quot;, &#039;*&#039;, &#039;/&#039;, &#039;\\&#039;, &#039;?&#039;, &#039;:&#039;, &#039;<&#039;, &#039;>&#039;, &#039;-&#039;",
    'ERR_DB_OCI8_DB_NAME_INVALID'       => "Ім&#039;я бази даних може складатися лише з літер, цифр і символів&#39;#&#39;, &#39;_&#39; або &#39;$&#39;",
	'ERR_DB_PASSWORD'					=> 'Паролі адміністратора бази даних SugarCRM не збігаються. Будь ласка, введіть їх ще раз.',
	'ERR_DB_PRIV_USER'					=> 'Необхідний логін адміністратора.',
	'ERR_DB_USER_EXISTS'				=> 'Користувач із вказаним ім&#039;ям вже існує в базі даних Sugar. Не можна створити ще одного користувача з таким же ім&#039;ям. Будь ласка, введіть нове ім&#039;я користувача.',
	'ERR_DB_USER'						=> 'Будь ласка, введіть логін адміністратора бази даних Sugar.',
	'ERR_DBCONF_VALIDATION'				=> 'Будь ласка, виправте наступні помилки:',
    'ERR_DBCONF_PASSWORD_MISMATCH'      => 'Паролі користувача бази даних Sugar не збігаються. Будь ласка, введіть їх ще раз.',
	'ERR_ERROR_GENERAL'					=> 'Були виявлені наступні помилки:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'Неможливо видалити файл:',
	'ERR_LANG_MISSING_FILE'				=> 'Не вдається знайти файл:',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'Не знайдено мовний файл у include/language:',
	'ERR_LANG_UPLOAD_1'					=> 'Завантаження не вдалася. Будь ласка, спробуйте ще раз.',
	'ERR_LANG_UPLOAD_2'					=> 'Мовні пакети повинні бути ZIP-архівами.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP не може перенести тимчасовий файл у папку оновлення.',
	'ERR_LICENSE_MISSING'				=> 'Пропущені обов&#039;язкові поля',
	'ERR_LICENSE_NOT_FOUND'				=> 'Файл ліцензії не знайдено.',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'Вказана неправильна папка.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'Вказана тека недоступна для запису.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Якщо ви вирішили вказати власну папку для записів - вкажіть її розташування.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'Не вдалося обробити скрипт.',
	'ERR_NO_SINGLE_QUOTE'				=> 'Не можна використовувати одинарні лапки для',
	'ERR_PASSWORD_MISMATCH'				=> 'Паролі адміністратора для SugarCRM не збігаються. Будь ласка, введіть паролі ще раз.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'Неможливо записати в файл config.php.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Ви можете продовжити установку, створивши файл config.php вручну і скопіювавши туди нижченаведену інформацію по конфігурації. Але переконайтеся, що config.php файл створений до переходу до наступного кроку.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'Ви не забули створити файл config.php?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Попередження: неможливо записати в файл config.php. Будь ласка, переконайтеся, що файл існує.',
	'ERR_PERFORM_HTACCESS_1'			=> 'Не можу записати в',
	'ERR_PERFORM_HTACCESS_2'			=> 'файл.',
	'ERR_PERFORM_HTACCESS_3'			=> 'Якщо Ви хочете захистити ваш файл записів від читання його браузером, створіть файл .htaccess з наступного рядком:',
	'ERR_PERFORM_NO_TCPIP'				=> 'Неможливо підключитися до інтернету. Коли з&#039;єднання буде доступне, будь ласка, зареєструйтеся в SugarCRM за посиланням: <a href="http://www.suitecrm.com/">http://www.suitecrm.com/</a>.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'Вказана неправильна папка для файлів сесій.',
	'ERR_SESSION_DIRECTORY'				=> 'Вказана тека сесій недоступна для запису.',
	'ERR_SESSION_PATH'					=> 'Якщо Ви вирішили вказати власну папку для файлів сесій - вкажіть її розташування.',
	'ERR_SI_NO_CONFIG'					=> 'Ви не помістили файл config_si.php в кореневу папку або ж не визначили змінну $sugar_config_si у файлі config.php',
	'ERR_SITE_GUID'						=> 'Якщо Ви вирішили вказати власний код додатка - вкажіть його',
    'ERROR_SPRITE_SUPPORT'              => "Currently we are not able to locate the GD library, as a result you will not be able to use the CSS Sprite functionality.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Попередження: конфігурація PHP повинна бути змінена, щоб дозволити завантаження файлів розміром більше 6 МБ.',
    'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => 'Максимальний розмір завантажуваного файлу',
	'ERR_URL_BLANK'						=> 'URL до Sugar не може бути порожнім.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'Неможливо визначити інсталяційний запис для',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'Завантажений файл не сумісний з встановленою версією Sugar Suite (Community Edition, Professional або Enterprise):',
	'ERROR_LICENSE_EXPIRED'				=> "Помилка: ваша ліцензія закінчилася",
	'ERROR_LICENSE_EXPIRED2'			=> "днів тому. Будь ласка, перейдіть в <a href=\"index.php?action=LicenseSettings&module=Administration\">\"License Management\"</a> в панель адміністратора для введення нового ліцензійного ключа. Якщо ви не введете новий ключ протягом 30 днів з моменту закінчення ліцензії, то ви не зможете увійти в систему.",
	'ERROR_MANIFEST_TYPE'				=> 'У Manifest-файлі повинен бути вказаний тип пакету.',
	'ERROR_PACKAGE_TYPE'				=> 'У Manifest-файлі вказано невідомий тип пакету',
	'ERROR_VALIDATION_EXPIRED'			=> "Помилка: Термін дії ліцензійного ключа закінчився",
	'ERROR_VALIDATION_EXPIRED2'			=> "днів тому. Будь ласка, перейдіть в <a href=\"index.php?action=LicenseSettings&module=Administration\">\"License Management\"</a> в панель адміністратора для введення нового ліцензійного ключа. Якщо ви не введете новий ключ протягом 30 днів з моменту закінчення ліцензії, то ви не зможете увійти в систему.",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'Завантажуваний файл не сумісний з встановленою версією Sugar:',

	'LBL_BACK'							=> 'Назад',
    'LBL_CANCEL'                        => 'Скасування',
    'LBL_ACCEPT'                        => 'Приймаю',
	'LBL_CHECKSYS_1'					=> 'Для того, щоб установка SugarCRM працювала правильно, будь ласка, переконайтеся, що всі розташовані нижче пункти пофарбовані в зелений колір. Якщо в списку присутні пункти, пофарбовані в червоний колір, будь ласка, виконайте необхідні дії для усунення зазначених помилок.<br / > За додатковою довідкою з цього питання Ви можете звернутися до <a href="http://www.sugarcrm.com/crm/installation" target="_blank">Sugar Wiki</a>.',
	'LBL_CHECKSYS_CACHE'				=> 'Доступні для запису підпапки папки Cache.',
    'LBL_DROP_DB_CONFIRM'               => 'База даних вже існує. Ви хочете продовжити і видалити поточні таблиці? Будуть знищені всі існуючі дані.',
	'LBL_CHECKSYS_CALL_TIME'			=> 'Call Time Pass Reference вимкнено.',
    'LBL_CHECKSYS_COMPONENT'			=> 'Основні компоненти',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Додаткові компоненти',
	'LBL_CHECKSYS_CONFIG'				=> 'Доступний для запису файл налаштування config.php',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'Writable SuiteCRM Configuration File (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'Модуль cURL',
    'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'Налаштування шляху збереження сесій',
	'LBL_CHECKSYS_CUSTOM'				=> 'Доступна для запису користувача директорія',
	'LBL_CHECKSYS_DATA'					=> 'Доступні для запису підпапки папки Data',
	'LBL_CHECKSYS_IMAP'					=> 'Модуль IMAP',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'Модуль MB Strings',
	'LBL_CHECKSYS_MEM_OK'				=> 'ОК (немає обмеження)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'ОК (немає обмеження)',
	'LBL_CHECKSYS_MEM'					=> 'Ліміт пам&#039;яті PHP',
	'LBL_CHECKSYS_MODULE'				=> 'Доступні для запису підпапки та файли модулів',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'Версія MySQL',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'Не доступно',
	'LBL_CHECKSYS_OK'					=> 'OK',
	'LBL_CHECKSYS_PHP_INI'				=> 'Розташування файлу конфігурації PHP (php.ini)',
	'LBL_CHECKSYS_PHP_OK'				=> 'OK (ver',
	'LBL_CHECKSYS_PHPVER'				=> 'Версія PHP',
    'LBL_CHECKSYS_IISVER'               => 'Версія IIS',
	'LBL_CHECKSYS_RECHECK'				=> 'Перевірити знову',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP Safe Mode вимкнено',
	'LBL_CHECKSYS_SESSION'				=> 'Доступна для запису папка для збереження файлів сесій (',
	'LBL_CHECKSYS_STATUS'				=> 'Статус',
	'LBL_CHECKSYS_TITLE'				=> 'Перевірка системних вимог',
	'LBL_CHECKSYS_VER'					=> 'Знайдено: (версія',
	'LBL_CHECKSYS_XML'					=> 'XML-парсинг',
	'LBL_CHECKSYS_ZLIB'					=> 'Модуль ZLIB',
	'LBL_CHECKSYS_ZIP'					=> 'Модуль обробки архівів ZIP -',
	'LBL_CHECKSYS_PCRE'					=> 'PCRE Library',
	'LBL_CHECKSYS_FIX_FILES'            => 'Будь ласка, налаштуйте права доступу до наступних файлів/папок:',
    'LBL_CHECKSYS_FIX_MODULE_FILES'     => 'Будь ласка, налаштуйте права доступу до наступних модулів і в файлах, які вони містять:',
    'LBL_CHECKSYS_UPLOAD'               => 'Writable Upload Directory',
    'LBL_CLOSE'							=> 'Закрити',
    'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> 'буде створена',
	'LBL_CONFIRM_DB_TYPE'				=> 'Тип бази даних',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Будь ласка, перевірте зазначені параметри. Якщо Ви хочете виправити який небудь параметр, натисніть кнопку &quot;Назад&quot;, якщо все в порядку - натисніть кнопку &quot;Далі&quot; для початку процесу установки.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Ліцензійна інформація',
	'LBL_CONFIRM_NOT'					=> 'не',
	'LBL_CONFIRM_TITLE'					=> 'Підтвердити налаштування',
	'LBL_CONFIRM_WILL'					=> 'буде',
	'LBL_DBCONF_CREATE_DB'				=> 'Створити базу даних',
	'LBL_DBCONF_CREATE_USER'			=> 'Створити користувача',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Обережно: всі дані Sugar будуть видалені, <br / > якщо встановити цей параметр.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> 'Видалити і створити заново таблиці Sugar?',
    'LBL_DBCONF_DB_DROP'                => 'Видалення таблиць',
    'LBL_DBCONF_DB_NAME'				=> 'Назва бази даних',
	'LBL_DBCONF_DB_PASSWORD'			=> 'Пароль користувача бази даних',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Повтор пароля користувача бази даних',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM Database User',
    'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM Database User',
    'LBL_DBCONF_DB_ADMIN_USER'          => 'Логін Адміністратора бази даних',
    'LBL_DBCONF_DB_ADMIN_PASSWORD'      => 'Пароль Адміністратора бази даних',
	'LBL_DBCONF_DEMO_DATA'				=> 'Заповнити базу даних демонстраційними даними?',
    'LBL_DBCONF_DEMO_DATA_TITLE'        => 'Вибрати демонстраційні дані',
	'LBL_DBCONF_HOST_NAME'				=> 'Ім&#039;я сервера',
	'LBL_DBCONF_HOST_INSTANCE'			=> 'Host Instance',
	'LBL_DBCONF_HOST_PORT'				=> 'Порт',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Будь ласка, налаштуйте вашу базу даних. Якщо ви не впевнені у даних, що вводяться, то ми радимо вам залишити значення за замовчуванням.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Використовувати мультибайтові символи в демонстраційних даних?',
    'LBL_DBCONFIG_MSG2'                 => 'Введіть назву сервера, на якому розташована ваша база даних (localhost або www.mydomain.com ) .',
	'LBL_DBCONFIG_MSG2_LABEL' => 'Ім&#039;я сервера',
    'LBL_DBCONFIG_MSG3'                 => 'Вкажіть назву бази даних, яка буде містити дані для Sugar, яку Ви встановлюєте:',
	'LBL_DBCONFIG_MSG3_LABEL' => 'Назва бази даних',
    'LBL_DBCONFIG_B_MSG1'               => 'Введіть логін та пароль адміністратора бази даних. Адміністратор повинен мати відповідні права на створення і запис у базі даних SugarCRM.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
    'LBL_DBCONFIG_SECURITY'             => 'В цілях безпеки, необхідний користувач з ексклюзивними правами адміністратора доступу до бази даних SugarCRM. Цей користувач повинен мати права вносити і змінювати дані в базі даних Sugar. Він може бути створений зараз або ж ви можете вказати вже існуючого користувача або ж вибрати адміністратора, зазначеного вище.',
    'LBL_DBCONFIG_AUTO_DD'              => 'Автоматична конфігурація',
    'LBL_DBCONFIG_PROVIDE_DD'           => 'Вказати існуючого користувача',
    'LBL_DBCONFIG_CREATE_DD'            => 'Створити користувача',
    'LBL_DBCONFIG_SAME_DD'              => 'Створити з Адміністратора',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
    'LBL_FTS'                           => 'Full Text Search',
    'LBL_FTS_INSTALLED'                 => 'встановлено',
    'LBL_FTS_INSTALLED_ERR1'            => 'Full Text Search capability is not installed.',
    'LBL_FTS_INSTALLED_ERR2'            => 'You can still install but will not be able to use Full Text Search functionality.  Please refer to your database server install guide on how to do this, or contact your Administrator.',
	'LBL_DBCONF_PRIV_PASS'				=> 'Пароль привілейованого користувача БД',
	'LBL_DBCONF_PRIV_USER_2'			=> 'Введений вище логін - це привілейований користувач БД?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'Адміністратор (або привілейований користувач повинен мати права на створення баз даних, видалення і створення таблиць, створення користувачів. Цей користувач буде використаний тільки для виконання зазначених завдань в процесі установки. Ви також можете вказати іншого користувача, якщо він має достатні привілеї.',
	'LBL_DBCONF_PRIV_USER'				=> 'Ім&#039;я адміністратора (привілейованого користувача)',
	'LBL_DBCONF_TITLE'					=> 'Конфігурація бази даних',
    'LBL_DBCONF_TITLE_NAME'             => 'Введіть назву бази даних',
    'LBL_DBCONF_TITLE_USER_INFO'        => 'Інформація про користувача бази даних',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => 'Користувач',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => 'SMTP-пароль:',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Після того, як всі зміни були зроблені, ви можете натиснути на кнопку &quot;Пуск&quot; для початку процесу установки. По закінченні встановлення значення змінної &#039;installer_locked&#039; повинно бути рівним &#039;true&#039;.',
	'LBL_DISABLED_DESCRIPTION'			=> 'Інсталятор вже був одного разу запущений. В цілях безпеки можливість повторного запуску інсталятора відключена. Якщо ви абсолютно впевнені, що хочете запустити його ще раз, будь ласка, у файлі config.php встановіть значення змінної &#039; installer_locked&#039; в &#039; false&#039;. Рядок повинен виглядати наступним чином:',
	'LBL_DISABLED_HELP_1'				=> 'За додатковою інформацією про процесі установки звертайтеся на сайт SugarCRM',
    'LBL_DISABLED_HELP_LNK'             => 'http://www.sugarcrm.com/forums/',
	'LBL_DISABLED_HELP_2'				=> 'Форуми підтримки',
	'LBL_DISABLED_TITLE_2'				=> 'Установка SugarCRM призупинена',
	'LBL_DISABLED_TITLE'				=> 'Можливість установки SugarCRM відключена',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Встановіть кодування, яке використовується частіше всього',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Налаштування вихідної пошти',
    'LBL_EMAIL_CHARSET_CONF'            => 'Кодування вихідної пошти',
	'LBL_HELP'							=> 'Довідка',
    'LBL_INSTALL'                       => 'Встановити',
    'LBL_INSTALL_TYPE_TITLE'            => 'Параметри встановлення',
    'LBL_INSTALL_TYPE_SUBTITLE'         => 'Виберіть тип установки',
    'LBL_INSTALL_TYPE_TYPICAL'          => 'Звичайна установка',
    'LBL_INSTALL_TYPE_CUSTOM'           => 'Вибіркове встановлення',
    'LBL_INSTALL_TYPE_MSG1'             => 'Для використання загального функціоналу програми потрібен ключ, однак для установки він не потрібний. Вам не потрібно вводити ключ зараз, проте ключ буде необхідний після установки програми.',
    'LBL_INSTALL_TYPE_MSG2'             => 'Для установки потрібно мінімум інформації. Рекомендується для нових користувачів.',
    'LBL_INSTALL_TYPE_MSG3'             => 'Надає можливість додаткових установок під час установки. Більшість цих опцій доступно також і після встановлення з екрану адміністратора. Рекомендується для просунутих користувачів.',
	'LBL_LANG_1'						=> 'Для використання в Sugar мови, відмінного від мови за замовчуванням (US-English), Ви можете завантажити та встановити зараз мовний пакет. Ви також зможете завантажити і встановити мовний пакет з-під додатка Sugar. Якщо бажаєте пропустити цей крок, натисніть &quot;Далі&quot;.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Встановити',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Видалити',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Деінсталяція',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Завантажити',
	'LBL_LANG_NO_PACKS'					=> 'немає',
	'LBL_LANG_PACK_INSTALLED'			=> 'Були встановлені наступні мовні пакети:',
	'LBL_LANG_PACK_READY'				=> 'Наступні мовні пакети готові до установки:',
	'LBL_LANG_SUCCESS'					=> 'Мовні пакети були завантажені успішно.',
	'LBL_LANG_TITLE'			   		=> 'Мовний пакет',
    'LBL_LAUNCHING_SILENT_INSTALL'     => 'Йде установка Sugar. Це може зайняти кілька хвилин.',
	'LBL_LANG_UPLOAD'					=> 'Завантажити мовний пакет',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Прийняття ліцензії',
    'LBL_LICENSE_CHECKING'              => 'Перевірка сумісності системи',
    'LBL_LICENSE_CHKENV_HEADER'         => 'Перевірка оточення',
    'LBL_LICENSE_CHKDB_HEADER'          => 'Перевірка прав доступу до бази даних',
    'LBL_LICENSE_CHECK_PASSED'          => 'Система пройшла перевірку на сумісність',
	'LBL_CREATE_CACHE' => 'Preparing to Install...',
    'LBL_LICENSE_REDIRECT'              => 'Перенаправлення в',
	'LBL_LICENSE_DIRECTIONS'			=> 'Якщо у Вас є інформація про ліцензію, введіть її в поле нижче.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Введіть ключ завантаження',
	'LBL_LICENSE_EXPIRY'				=> 'Термін дії',
	'LBL_LICENSE_I_ACCEPT'				=> 'Приймаю',
	'LBL_LICENSE_NUM_USERS'				=> 'Кількість користувачів',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Введіть, будь ласка, кількість придбаних Оффлайн клієнтів.',
	'LBL_LICENSE_OC_NUM'				=> 'Кількість ліцензій Оффлайн клієнта',
	'LBL_LICENSE_OC'					=> 'Ліцензії Оффлайн клієнта',
	'LBL_LICENSE_PRINTABLE'				=> 'Друкарський вигляд',
    'LBL_PRINT_SUMM'                    => 'Роздрукувати звіт',
	'LBL_LICENSE_TITLE_2'				=> 'Ліцензія SugarCRM',
	'LBL_LICENSE_TITLE'					=> 'Ліцензійна інформація',
	'LBL_LICENSE_USERS'					=> 'Кількість користувачів',

	'LBL_LOCALE_CURRENCY'				=> 'Налаштування валюти',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Валюта за замовчуванням',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Символ валюти',
	'LBL_LOCALE_CURR_ISO'				=> 'Код валюти (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> 'Символ роздільника розрядів',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Десятковий розділювач',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Приклад',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Значимі розряди',
	'LBL_LOCALE_DATEF'					=> 'Формат дати за замовчуванням',
	'LBL_LOCALE_DESC'					=> 'Позначені локальні установки будуть відображені глобально всередині екземпляра Sugar.',
	'LBL_LOCALE_EXPORT'					=> 'Набір символів для Імпорту/Експорту <br />(E-mail, .csv, vCard, PDF, імпорт даних)',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Обмежувач експорту (.csv)',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Імпорт/експорт налаштування',
	'LBL_LOCALE_LANG'					=> 'Мова за замовчуванням',
	'LBL_LOCALE_NAMEF'					=> 'Формат імені за замовчуванням',
	'LBL_LOCALE_NAMEF_DESC'				=> 's = звернення<br />f = ім&#039;я<br />l = прізвище',
	'LBL_LOCALE_NAME_FIRST'				=> 'Петро',
	'LBL_LOCALE_NAME_LAST'				=> 'Петров',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Д-р',
	'LBL_LOCALE_TIMEF'					=> 'Формат часу за замовчуванням',

    'LBL_CUSTOMIZE_LOCALE'              => 'Змінити регіональні налаштування',
	'LBL_LOCALE_UI'						=> 'Інтерфейс користувача',

	'LBL_ML_ACTION'						=> 'Дія',
	'LBL_ML_DESCRIPTION'				=> 'Описання',
	'LBL_ML_INSTALLED'					=> 'Дата установки',
	'LBL_ML_NAME'						=> 'Назва',
	'LBL_ML_PUBLISHED'					=> 'Дата публікації',
	'LBL_ML_TYPE'						=> 'Тип',
	'LBL_ML_UNINSTALLABLE'				=> 'Деінсталяція',
	'LBL_ML_VERSION'					=> 'Версія',
	'LBL_MSSQL'							=> 'SQL сервер',
	'LBL_MSSQL2'                        => 'Сервер SQL (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL Server (Microsoft SQL Server Driver for PHP)',
	'LBL_MYSQL'							=> 'MySQL',
    'LBL_MYSQLI'						=> 'MySQL (mysqli extension)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> 'Далі',
	'LBL_NO'							=> 'Ні',
    'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Установка пароля адміністратора сайту',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'таблиця аудиту /',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Створення файлу конфігурації Sugar',
	'LBL_PERFORM_CREATE_DB_1'			=> 'Створення бази даних',
	'LBL_PERFORM_CREATE_DB_2'			=> 'на',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Створення імені користувача та пароля для бази даних...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Створення даних Sugar за замовчуванням',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Створення імені користувача і пароля бази даних для localhost...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Створення таблиць відносин Sugar',
	'LBL_PERFORM_CREATING'				=> 'створення /',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Створення звітів за замовчуванням',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Створення запланованих завдань за замовчуванням',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Вставка параметрів за замовчуванням',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Створення користувачів за замовчуванням',
	'LBL_PERFORM_DEMO_DATA'				=> 'Заповнення таблиць бази даних демонстраційними даними (це може зайняти деякий час)',
	'LBL_PERFORM_DONE'					=> 'готово',
	'LBL_PERFORM_DROPPING'				=> 'скидання /',
	'LBL_PERFORM_FINISH'				=> 'Готово',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Оновлення інформації про ліцензію',
	'LBL_PERFORM_OUTRO_1'				=> 'Налаштування Sugar',
	'LBL_PERFORM_OUTRO_2'				=> 'завершена!',
	'LBL_PERFORM_OUTRO_3'				=> 'Загальний час:',
	'LBL_PERFORM_OUTRO_4'				=> 'секунд.',
	'LBL_PERFORM_OUTRO_5'				=> 'Приблизна кількість використаної пам&#039;яті:',
	'LBL_PERFORM_OUTRO_6'				=> 'байт.',
	'LBL_PERFORM_OUTRO_7'				=> 'Тепер Ваша система встановлена і налаштована для використання.',
	'LBL_PERFORM_REL_META'				=> 'мета відносин ...',
	'LBL_PERFORM_SUCCESS'				=> 'Успішно!',
	'LBL_PERFORM_TABLES'				=> 'Створення таблиць додатків Sugar, таблиць аудиту та метаданих відносин',
	'LBL_PERFORM_TITLE'					=> 'Налаштування',
	'LBL_PRINT'							=> 'Друк',
	'LBL_REG_CONF_1'					=> 'Будь ласка, заповніть коротку форму нижче, щоб отримувати інформацію про продукти, новини про тренінги, спеціальні пропозиції та запрошення на спеціальні події від SugarCRM. Ми не продаємо, не даємо в використання і не розповсюджуємо будь-яким іншим чином інформацію, отриману від третіх сторін.',
	'LBL_REG_CONF_2'					=> 'Єдині поля, необхідні для реєстрації - це ваші ім&#039;я та адреса електронної пошти. Інші поля заповнюються за бажанням, але їх заповнення нам дуже допоможе. Ми не продаємо, не даємо в використання і не розповсюджуємо будь-яким іншим чином інформацію, отриману від третіх сторін.',
	'LBL_REG_CONF_3'					=> 'Дякуємо за реєстрацію. Натисніть кнопку &quot;Завершити&quot; для входу в SugarCRM. В перший раз вам потрібно увійти в систему, використовуючи ім&#039;я користувача &quot;admin&quot; і пароль, який ви вибрали в Кроці 2.',
	'LBL_REG_TITLE'						=> 'Реєстрація',
    'LBL_REG_NO_THANKS'                 => 'Ні, спасибі',
    'LBL_REG_SKIP_THIS_STEP'            => 'Пропустити цей крок',
	'LBL_REQUIRED'						=> '* Обов&#039;язкове поле',

    'LBL_SITECFG_ADMIN_Name'            => 'Ім&#039;я адміністратора додатку Sugar',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Введіть пароль адміністратора Sugar ще раз',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Попередження: Це скасує пароль адміністратора в усіх попередніх установках.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'Пароль адміністратора Sugar',
	'LBL_SITECFG_APP_ID'				=> 'ID додатка',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'У разі вибору, Вам необхідно надати ID додатка замість автоматично згенерованого ID. ID підтверджує, що сесії даного екземпляра Sugar не використовуються іншими екземплярами. Якщо у Вас є кластер встановлених Sugar, у них у всіх повинен бути один і той же ID додатка.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Введіть свій власний ID додатка',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'У разі вибору, Вам необхідно позначити папку логів замість папки за промовчанням для логів Sugar. Не залежно від того, де знаходиться файл логів, доступ до нього через веб-браузер буде обмежений через перенаправлення .htaccess.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Використовувати Індивідуальну папку логів',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'У разі вибору, Вам необхідно буде вказати захищену папку для зберігання інформації про сесії Sugar. Це може бути зроблено для запобігання незахищеності даних на загальних серверах.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Використовувати Індивідуальну папку сесій для Sugar',
	'LBL_SITECFG_DIRECTIONS'			=> 'Будь ласка, введіть інформацію про налаштування вашого сайту нижче. Якщо Ви не впевнені у значеннях полів, ми пропонуємо Вам використовувати значення за замовчуванням.',
	'LBL_SITECFG_FIX_ERRORS'			=> 'Будь ласка, виправте наступні помилки перед тим, як продовжити:',
	'LBL_SITECFG_LOG_DIR'				=> 'Папка логів',
	'LBL_SITECFG_SESSION_PATH'			=> 'Шлях до Папки сесій <br />(повинен бути дійсним)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Виберіть опції безпеки',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'У разі вибору, система періодично перевірятиме наявність оновлень для додатка.',
	'LBL_SITECFG_SUGAR_UP'				=> 'Автоматично перевіряти наявність оновлень?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Конфігурація оновлень Sugar',
	'LBL_SITECFG_TITLE'					=> 'Конфігурація сайту',
    'LBL_SITECFG_TITLE2'                => 'Встановити користувача з правами адміністратора',
    'LBL_SITECFG_SECURITY_TITLE'        => 'Безпека сайту',
	'LBL_SITECFG_URL'					=> 'URL для заданого зразка Sugar',
	'LBL_SITECFG_USE_DEFAULTS'			=> 'Використовувати значення за замовчуванням?',
	'LBL_SITECFG_ANONSTATS'             => 'Відправляти анонімну статистику про використання?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => 'У разі вибору, Sugar буде відправляти анонімну статистику про Ваш екземпляр Sugar в SugarCRM Inc. кожен раз, коли система перевіряє наявність нових версій. Ця інформація допоможе нам краще зрозуміти, як використовується додаток і допоможе поліпшити продукт.',
    'LBL_SITECFG_URL_MSG'               => 'Введіть URL, який буде використовуватися для доступу до даного екземпляра Sugar після установки. Цей URL так само буде використаний як основа для адрес сторінок додатків Sugar. URL повинен включати в себе веб сервер, назва комп&#039;ютера або IP-адреса.',
    'LBL_SITECFG_SYS_NAME_MSG'          => 'Введіть ім&#039;я Вашої системи. Це ім&#039;я буде відображатися в заголовку сторінки браузера коли користувачі будуть заходити на сторінки додатків Sugar.',
    'LBL_SITECFG_PASSWORD_MSG'          => 'Після установки, для входу в систему Вам необхідно буде використовувати користувача-адміністратора Sugar (ім&#039;я користувача за замовчуванням = admin). Введіть пароль для цього користувача з правами адміністратора. Цей пароль може бути змінений після першого входу. Ви так само можете використовувати інше ім&#039;я адміністратора, крім того, що надається за замовчуванням.',
    'LBL_SITECFG_COLLATION_MSG'         => 'Select collation (sorting) settings for your system. This settings will create the tables with the specific language you use. In case your language doesn\'t require special settings please use default value.',
    'LBL_SPRITE_SUPPORT'                => 'Sprite Support',
	'LBL_SYSTEM_CREDS'                  => 'Системні повноваження',
    'LBL_SYSTEM_ENV'                    => 'Системне оточення',
	'LBL_START'							=> 'Початок',
    'LBL_SHOW_PASS'                     => 'Показати паролі',
    'LBL_HIDE_PASS'                     => 'Приховати паролі',
    'LBL_HIDDEN'                        => '(прихований)',
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
	'LBL_CHOOSE_LANG'					=> 'Виберіть мову',
	'LBL_STEP'							=> 'Крок',
	'LBL_TITLE_WELCOME'					=> 'Ласкаво просимо в SuiteCRM ',
	'LBL_WELCOME_1'						=> 'Цей установщик створює базу даних SugarCRM і встановлює конфігурацію змінних, які необхідні для початку. Весь процес займе близько 10 хвилин.',
	'LBL_WELCOME_2'						=> 'Документації з установки знаходяться на <a href="http://www.sugarcrm.com/crm/installation" target="_blank">Sugar Wiki</a>. <br /><br />Для зв&#039;язку зі службою підтримки SugarCRM з питань установки увійдіть на Портал підтримки SugarCRM і зробіть звернення на підтримку.',
    //welcome page variables
    'LBL_TITLE_ARE_YOU_READY'            => 'Ви готові до установки?',
    'REQUIRED_SYS_COMP' => 'Необхідні компоненти системи',
    'REQUIRED_SYS_COMP_MSG' =>
                    'Перед початком, будь ласка, переконайтеся, що у Вас встановлені підтримувані версії наступних системних компонентів: <br / > * БД/СУБД (Приклади: MySQL, SQL Server, Oracle)<br / > * Веб-сервер (Apache, IIS)<br /><br />Інформацію про сумісність встановлюваною версії Sugar з системними компонентами можна знайти в Матриці сумісності в Release Notes.',
    'REQUIRED_SYS_CHK' => 'Початкова перевірка системи',
    'REQUIRED_SYS_CHK_MSG' =>
                    'На початку процесу установки буде проведена перевірка системи на сервері, де розташовуються файли Sugar, щоб упевнитися, що система правильно налаштована і має всі необхідні компоненти для успішного завершення процесу встановлення.<br /><br />Система перевіряється за наступними параметрами:<br /><br / > # Версія PHP - повинна бути сумісна з додатком<br / > # Змінні сесії - повинні працювати правильно<br / > # MB Strings - повинно бути встановлено і задіяно в php.ini<br / > # Підтримка баз даних - повинна існувати для MySQL, SQL Server або Oracle<br / > # Config.php - файл повинен існувати і мати відповідні дозволи на запис у нього даних<br /><br />Наступні файли Sugar повинні бути доступні для запису:<br / > * /custom<br / > * /cache<br / > * /modules<br /><br />Якщо перевірка не буде пройдена, Ви не зможете продовжити установку. Буде виведено повідомлення про помилку, що пояснює, чому ваша система не пройшла перевірку. Після внесення необхідних змін Ви зможете запустити перевірку ще раз і, пройшовши її, продовжити установку.',
    'REQUIRED_INSTALLTYPE' => 'Типове або Вибіркове встановлення',
    'REQUIRED_INSTALLTYPE_MSG' =>
                    'Після завершення перевірки системи Ви можете вибрати Звичайний або Вибірковий варіанти установки. В обох випадках Вам слід знати наступне:
<ul>
<li> <b>Тип бази даних</b>, який буде використовуватися для даних Sugar
<ul><li>Сумісні типи БД: MySQL, MS SQL Server, Oracle.</li></ul></li>

<li> <b>Ім&#039;я веб-сервера або комп&#039;ютера</b>, на якому знаходиться база даних
Це може бути локальний якщо база даних знаходиться на Вашому ком&#039;ютері або на тому ж комп&#039;ютері, що і файли Sugar.</li></ul></li>

<li><b>Ім&#039;я бази даних</b>, яку Ви хочете використовувати для зберігання даних Sugar</li>
<ul><li>Можливо, у Вас вже є існуюча база даних, яку Ви хочете використовувати. В цьому випадку під час установки, коли визначається база даних Sugar, таблиці вже існуючої бази даних будуть видалені.</li>
<li>Якщо у Вас немає існуючої бази даних, введене ім&#039;я буде використано для створення нової бази даних в процесі установки.</li></ul>

<li><b>Ім&#039;я користувача і пароль адміністратора бази даних</b> <ul><li>
У адміністратора бази даних є можливість створювати таблиці, користувачів і змінювати вміст бази даних.
</li><li> Можливо, для отримання цієї інформації вам доведеться зв&#039;язатися з адміністратором бази даних, якщо база даних не знаходиться на вашому комп&#039;ютері та/або якщо Ви не є адміністратором бази даних.</ul></li></li>

<li> <b>Ім&#039;я користувача і пароль доступу до бази даних Sugar</b>
</li><ul><li>Користувач може бути адміністратором бази даних або Ви можете ввести ім&#039;я іншого існуючого користувача бази даних.</li>
<li>Якщо Ви бажаєте створити нового користувача, у Вас буде можливість задати нові ім&#039;я користувача та пароль і користувач буде створений під час установки.</li></ul></ul>

Для <b>вибіркової</b> установки Вам також слід знати, що:

<ul><li> <b>URL-адресу</b>, яку буде використано для доступу до примірника Sugar після завершення установки. Цей URL повинен включати в себе назву веб-сервера або комп&#039;ютера або IP-адресу.</li>

<li>[Вибірково] <b>Шлях до папки сесій</b> якщо Ви хочете використовувати індивідуальну папку сесій цукру для захисту даних сесій від уразливості на загальних серверах.</li>

<li>[Вибірково] <b>Шлях до індивідуальної папки логів</b> якщо Ви хочете використовувати її замість папки логів Sugar за замовчуванням.</li>

<li>[Вибірково] <b>ID додатка</b> якщо Ви хочете використовувати його замість автоматично згенерованого ID додатку. Цей ID засвідчує, що сесії даного примірника Sugar не використовуються іншими екземплярами.</li>

<li><b>Набір символів</b>, найбільш часто використовуваних у Вашому регіоні.</li></ul>


Більш детальну інформацію Ви можете знайти у Посібнику по установці.',
    'LBL_WELCOME_PLEASE_READ_BELOW' => 'Прочитайте, будь ласка, наступну важливу інформацію перед продовженням встановлення. Ця інформація допоможе Вам визначити, чи готові Ви до установки програми.',

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> 'Виберіть мову',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Майстер налаштування',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Ласкаво просимо в SuiteCRM ',
	'LBL_WELCOME_TITLE'					=> 'Майстер налаштування SugarCRM',
	'LBL_WIZARD_TITLE'					=> 'Майстер налаштування системи:',
	'LBL_YES'							=> 'Так',
    'LBL_YES_MULTI'                     => 'Так - Мультибайт',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Обробити завдання Робочого процесу',
	'LBL_OOTB_REPORTS'		=> 'Виконувати заплановані завдання створення звітів',
	'LBL_OOTB_IE'			=> 'Перевіряти вхідні листи',
	'LBL_OOTB_BOUNCE'		=> 'Запускати вночі перевірку поштових скриньок для листів, що повертаються',
    'LBL_OOTB_CAMPAIGN'		=> 'Запускати вночі масову розсилку листів',
	'LBL_OOTB_PRUNE'		=> 'Стискати базу даних першого числа кожного місяця',
    'LBL_OOTB_TRACKER'		=> 'Очищати історію останніх переглядів першого числа кожного місяця',
    'LBL_OOTB_SUGARFEEDS'   => 'Prune SuiteCRM Feed Tables',
    'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> 'Run Email Reminder Notifications',
    'LBL_UPDATE_TRACKER_SESSIONS' => 'Оновити таблицю tracker_sessions',
    'LBL_OOTB_CLEANUP_QUEUE' => 'Clean Jobs Queue',
    'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => 'Removal of documents from filesystem',


    'LBL_PATCHES_TITLE'     => 'Встановити останні доповнення',
    'LBL_MODULE_TITLE'      => 'Встановити мовні пакети',
    'LBL_PATCH_1'           => 'Натисніть "Далі" якщо хочете пропустити цей крок.',
    'LBL_PATCH_TITLE'       => 'Системні доповнення',
    'LBL_PATCH_READY'       => 'Наступні доповнення готові до установки',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SugarCRM використовує PHP-сесії для зберігання важливої інформації під час з&#039;єднання з цим веб сервером. У версії PHP, встановленої у Вас, інформація про сесіях неправильно налаштована. <br /><br />Часта помилка в конфігурації - параметр &#039;session.save_path&#039; не вказує на діючий каталог. <br /><br />Будь ласка, виправте <a target=\"_new\" href=\"http://us2.php.net/manual/en/ref.session.php\">конфігурацію PHP</a> в файлі php.ini, розташованому нижче.",
	'LBL_SESSION_ERR_TITLE'				=> 'Помилка конфігурації PHP сесій',
	'LBL_SYSTEM_NAME'=>'Назва системи',
    'LBL_COLLATION' => 'Collation Settings',
	'LBL_REQUIRED_SYSTEM_NAME'=>'Введіть назву системи для даного екземпляра Sugar',
	'LBL_PATCH_UPLOAD' => 'Виберіть файл доповнення до Вашого локального комп&#039;ютера',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Вимагається PHP версії 5 або вище.',
	'LBL_MINIMUM_PHP_VERSION' => 'Мінімальна необхідна версія PHP - 5.1.0. Рекомендовано - 5.2.x.',
	'LBL_YOUR_PHP_VERSION' => 'Поточна версія PHP на Вашому комп&#039;ютері',
	'LBL_RECOMMENDED_PHP_VERSION' =>'Рекомендована версія PHP - 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'Включений режим зворотної сумісності PHP. Для продовження вимкніть параметр zend.ze1_compatibility_mode',
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

	'LBL_WIZARD_SMTP_DESC' => 'Обліковий запис вихідної пошти буде використовуватися для відправки вихідної пошти, в тому числі для повідомлень про призначення записів і завдань, та листів з інформацією про новий пароль. Електронна адреса даного облікового запису буде фігурувати в листах в якості відправника.',
	'LBL_CHOOSE_EMAIL_PROVIDER'        => 'Виберіть поштову службу:',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! Mail',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => 'Інший',
	'LBL_MAIL_SMTP_SETTINGS'           => 'Налаштування SMTP-сервера',
	'LBL_MAIL_SMTPSERVER'				=> 'Сервер вихідної пошти',
	'LBL_MAIL_SMTPPORT'					=> 'SMTP-порт',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'Використовувати SMTP-аутентифікацію?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => 'Enable SMTP over SSL or TLS?',
	'LBL_GMAIL_SMTPUSER'					=> 'Gmail - Emai-адреса:',
	'LBL_GMAIL_SMTPPASS'					=> 'Gmail - пароль:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => 'Дозволити користувачам використовувати цей обліковий запис для вихідних повідомлень:',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => 'При виборі даної опції всі користувачі зможуть надсилати електронну пошту (включаючи автоматичні повідомлення про призначення записів та системні повідомлення) з використанням вказаного тут стандартного сервера вихідної пошти. В іншому випадку кожному користувачу при налаштуванні облікового запису електронної пошти необхідно вручну ввести налаштування сервера вихідної пошти.',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Yahoo! Mail - пароль:',
	'LBL_YAHOOMAIL_SMTPUSER'					=> 'Yahoo! Mail ID:',

	'LBL_EXCHANGE_SMTPPASS'					=> 'Exchange - пароль:',
	'LBL_EXCHANGE_SMTPUSER'					=> 'Exchange - логін:',
	'LBL_EXCHANGE_SMTPPORT'					=> 'Exchange - порт серверу:',
	'LBL_EXCHANGE_SMTPSERVER'				=> 'Exchange - сервер:',


	'LBL_MAIL_SMTPUSER'					=> 'SMTP-логін',
	'LBL_MAIL_SMTPPASS'					=> 'SMTP-пароль:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => 'Налаштування логотипу',
	'LBL_WIZARD_SYSTEM_DESC' => 'Вкажіть назву вашої організації і виберіть логотип.',
	'SYSTEM_NAME_WIZARD'=>'Назва:',
	'SYSTEM_NAME_HELP'=>'Дана назва відображається в заголовку браузера.',
	'NEW_LOGO'=>'Вибрати логотип:',
	'NEW_LOGO_HELP'=>'Допустимі наступні формати логотипів: PNG або JPG.<br />Рекомендований розмір логотипів - 212x40 пікселів.',
	'COMPANY_LOGO_UPLOAD_BTN' => 'Завантажити',
	'CURRENT_LOGO'=>'Поточний логотип:',
    'CURRENT_LOGO_HELP'=>'Даний логотип відображається у верхньому лівому куті додатку Sugar.',

	// System Local Settings


	'LBL_LOCALE_TITLE' => 'System Locale Settings',
	'LBL_WIZARD_LOCALE_DESC' => 'Вкажіть, яким чином повинні бути представлені дані в системі, грунтуючись на Вашому географічному положенні. Вказані тут параметри будуть параметрами за замовчуванням. Надалі користувачі зможуть змінити параметри на свій розсуд.',
	'LBL_DATE_FORMAT' => 'Формат дати',
	'LBL_TIME_FORMAT' => 'Формат часу:',
		'LBL_TIMEZONE' => 'Часовий пояс:',
	'LBL_LANGUAGE'=>'Мова:',
	'LBL_CURRENCY'=>'Валюта',
	'LBL_CURRENCY_SYMBOL'=>'Currency Symbol:',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 Currency Code:',
	'LBL_NUMBER_GROUPING_SEP' => 'Символ роздільника розрядів',
	'LBL_DECIMAL_SEP' => 'Символ десяткового роздільника',
	'LBL_NAME_FORMAT' => 'Name Format:',
	'UPLOAD_LOGO' => 'Please wait, logo uploading..',
	'ERR_UPLOAD_FILETYPE' => 'File type do not allowed, please upload a jpeg or png.',
	'ERR_LANG_UPLOAD_UNKNOWN' => 'Unknown file upload error occured.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => 'Завантажений файл більше, ніж зазначено в upload_max_filesize в php.ini.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => 'Завантажений файл більше, ніж зазначено в MAX_FILE_SIZE в HTML формі.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => 'Файл був тільки частково завантажений.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => 'Файл не був заружен.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => 'Тимчасова папка не була створена.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => 'Не вдалося записати файл на диск.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.',

	'LBL_INSTALL_PROCESS' => 'Install...',

	'LBL_EMAIL_ADDRESS' => 'Адреса електронної пошти:',
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
	'LBL_START' => 'Початок',


);

?>
