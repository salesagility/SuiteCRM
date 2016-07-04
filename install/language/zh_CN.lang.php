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
	'LBL_BASIC_SEARCH'					=> '基本搜索',
	'LBL_ADVANCED_SEARCH'				=> '高级搜索',
	'LBL_BASIC_TYPE'					=> '基本类型',
	'LBL_ADVANCED_TYPE'					=> '高级类型',
	'LBL_SYSOPTS_1'						=> '从下面的系统配置选项中选择。',
	'LBL_SYSOPTS_2'                     => '选择安装 SuiteCRM 实例的数据库类型。',
	'LBL_SYSOPTS_CONFIG'				=> '系统配置',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> '指定数据库类型',
	'LBL_SYSOPTS_DB_TITLE'              => '数据库类型',
	'LBL_SYSOPTS_ERRS_TITLE'			=> '在继续执行前请修复以下错误：',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => '请设置以下目录为可写入目录：',
	'ERR_DB_VERSION_FAILURE'			=> '无法检测数据库版本。',
	'DEFAULT_CHARSET'					=> 'UTF-8',
	'ERR_ADMIN_USER_NAME_BLANK'         => '请设置 SuiteCRM 管理员用户名。',
	'ERR_ADMIN_PASS_BLANK'				=> '请设置 SuiteCRM 管理员密码。',

	//'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
	'ERR_CHECKSYS'                      => '在兼容性检查过程中检测到错误。 为了使您的 SuiteCRM 正常安装使用，请采取适当的步骤解决下面列出的问题，并重新检查或重新进行安装。',
	'ERR_CHECKSYS_CALL_TIME'            => '当前 allow_call_time_pass_reference = off，请修改 php.ini 配置文件或通过其他途径启用此选项。',
	'ERR_CHECKSYS_CURL'					=> '未找到 CURL 支持：SuiteCRM 任务计划功能将受限。',
	'ERR_CHECKSYS_IMAP'					=> '未找到 IMAP 库：邮件接收和营销活动邮件需要 IMAP 库，否则将不能正常工作。',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> '在使用MS SQL数据库时,智能报价GPC不能设置为"开启".',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> '警告：',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> '修改 php.ini 配置文件或通过其他途径设置 memory_limit = ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M 或更大',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> '最低 MySQL 版本4.1.2 - 当前：',
	'ERR_CHECKSYS_NO_SESSIONS'			=> '读写 PHP session 变量失败，无法继续安装。',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> '不是有效的目录',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> '警告：无法写入',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'SuiteCRM 不支持您的 PHP 版本。您需要安装与 SuiteCRM 兼容的版本。当前 PHP 版本：',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'SuiteCRM 不支持您的 IIS 版本。您需要安装与 SuiteCRM 兼容的版本。当前 IIS 版本：',
	'ERR_CHECKSYS_FASTCGI'              => '我们检测到您使用的不是的FastCGI的处理PHP程序。您需要安装/配置来与SuiteCRM应用程序兼容。请向为支持版本的发行说明兼容性矩阵。详情请参阅 <a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => '如果使用 IIS/FastCGI sapi 建议在 php.ini 文件中设置 fastcgi.logging = 0 。',
	'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> '不支持当前 PHP 版本：( ver',
	'LBL_DB_UNAVAILABLE'                => '数据库不可用',
	'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => '没有支持的数据库可用。请确保您有下列其中一项必要的驱动程序支持的数据库类型：MySQL和MS SQL Server或Oracle的。您可能需要取消注释在php.ini文件中的PHP扩展，或者重新编译正确的二进制文件，这取决于你的PHP版本。请参阅有关如何启用数据库信息，支持您的PHP手册。',
	'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => '使用XML解析器，它是由SuiteCRM库相关应用程序所需的功能并没有发现。您可能需要取消注释在php.ini文件中的扩展名，或者重新编译二进制文件的权利，这取决于你的PHP版本。有关详细信息，请参阅您的PHP手册。',
	'ERR_CHECKSYS_MBSTRING'             => '与多字节字符串PHP扩展（mbstring说明），它们被SuiteCRM应用程序所需的相关的功能没有被发现。<br/><br/>般情况下，PHP默认不启用mbstring，要激活了 可以使用参数- enable - mbstring,当PHP编译的时候。请参阅更多关于如何启用mbstring说明信息，支持您的PHP手册。',
	'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => '在php.ini中配置的session.save_path路径不是一个文件夹,或者路径不存在.你需要在php.ini中设置一个有效的save_path.',
	'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => '在你的PHP配置文件（php.ini）中session.save_path的设置被设置到一个文件夹这是不写。请采取必要的步骤，以使该文件夹可写。<br>您的操作系统而定，这可能需要更改运行搭配chmod 766的权限，或右键点击文件名来访问属性并取消只读选项。',
	'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => '配置文件存在但无法写入，请设置适当的文件权限。',
	'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => '配置重写文件存在但无法写入，请设置适当的文件权限。',
	'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => '自定义目录存在，但不写。您可能必须改变它它（运行命令chmod 766）或右击权限，并取消只读选项，具体取决于您的操作系统。请采取必要步骤，以使文件可写。',
	'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "下面列出的文件或目录无法写入或丢失，无法创建。根据您的操作系统，纠正这可能需要更改的文件或文件的父目录（运行命令chmod 766）权限，或右键点击父目录和取消的'只读'选项并将其应用到所有子文件夹。",
	'LBL_CHECKSYS_OVERRIDE_CONFIG' => '配置重写',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> '安全模式开启（可在 php.ini 中设置关闭）',
	'ERR_CHECKSYS_ZLIB'					=> '未找到 zlib 支持：SuiteCRM 使用 zlib 压缩以提升性能。',
	'ERR_CHECKSYS_ZIP'					=> '未找到 zip 支持：SuiteCRM 需要 zip 支持来处理压缩的文件。',
	'ERR_CHECKSYS_PCRE'					=> '未找到 PCRE 库：SuiteCRM 需要 PCRE 库来处理 Perl 风格的正则表达式匹配。',
	'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE 库版本过低：SuiteCRM 需要 PCRE 库 7.0 及以上版本来处理 Perl 风格的正则表达式匹配。',
	'ERR_DB_ADMIN'						=> '所提供的数据库管理员用户名和/或密码无效，以及对数据库连接不能建立。请输入有效的用户名和密码。 （错误：',
	'ERR_DB_ADMIN_MSSQL'                => '所提供的数据库管理员用户名和/或密码无效，以及对数据库连接不能建立。请输入有效的用户名和密码。',
	'ERR_DB_EXISTS_NOT'					=> '指定的数据库不存在。',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> '数据库已存在的配置数据。要使用所选的数据库进行安装，请重新运行安装程序并选择：“删除并重新创建现有 SuiteCRM 表？”如果需要升级系统，请在管理控制台中使用更新向导。',
	'ERR_DB_EXISTS'						=> '所提供的数据库名称已经存在 - 无法创建另一个具有相同的名称。',
	'ERR_DB_EXISTS_PROCEED'             => '所提供的数据库名称已经存在。你可以<br>1.点击后退按钮，并选择一个新的数据库名称<br>2. 点击下一步并继续，但在这个数据库中的所有现有表将被删除。这意味着你的表和数据都将被不再存在。',
	'ERR_DB_HOSTNAME'					=> '主机名不能为空。',
	'ERR_DB_INVALID'					=> '选择的数据库类型无效。',
	'ERR_DB_LOGIN_FAILURE'				=> '所提供的资料库主机，用户名和/或密码无效，以及对数据库连接不能建立。请输入一个有效的主机，用户名和密码',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> '所提供的资料库主机，用户名和/或密码无效，以及对数据库连接不能建立。请输入一个有效的主机，用户名和密码',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> '所提供的资料库主机，用户名和/或密码无效，以及对数据库连接不能建立。请输入一个有效的主机，用户名和密码',
	'ERR_DB_MYSQL_VERSION'				=> 'SuiteCRM 不支持您的 MySQL 版本。您需要安装与 SuiteCRM 兼容的版本。当前 MySQL 版本：(%s)',
	'ERR_DB_NAME'						=> '数据名不能为空。',
	'ERR_DB_NAME2'						=> "数据库名不能包含 '\\', '/', 或 '.'",
	'ERR_DB_MYSQL_DB_NAME_INVALID'      => "数据库名不能包含 '\\', '/', 或 '.'",
	'ERR_DB_MSSQL_DB_NAME_INVALID'      => "数据库名不能以数字 '#', o或 '@' 开头，并且也不能包含空格, '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', '&', '!', or '-'",
	'ERR_DB_OCI8_DB_NAME_INVALID'       => "数据名只能由文字数字式字符以及'#', '_' 或 '$'符号组成。",
	'ERR_DB_PASSWORD'					=> '输入的SuiteCRM数据库管理员密码不匹配，请重新在密码栏里输入一致的密码。',
	'ERR_DB_PRIV_USER'					=> '请提供一个数据库管理员用户名.此用户用于初始化数据库连接.',
	'ERR_DB_USER_EXISTS'				=> '数据库用户名已存在--不能创建同名数据库用户.请输入一个新的用户名.',
	'ERR_DB_USER'						=> '请为SuiteCRM数据库管理员输入用户名。',
	'ERR_DBCONF_VALIDATION'				=> '在继续执行前请修复以下错误：',
	'ERR_DBCONF_PASSWORD_MISMATCH'      => '用于SuiteCRM数据库用户提供的密码不匹配。请重新输入密码字段相同的密码',
	'ERR_ERROR_GENERAL'					=> '遭遇以下错误：',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> '无法删除文件：',
	'ERR_LANG_MISSING_FILE'				=> '不存在的文件：',
	'ERR_LANG_NO_LANG_FILE'			 	=> '没有在include/language inside找到语言包：',
	'ERR_LANG_UPLOAD_1'					=> '上传出错，请重试。',
	'ERR_LANG_UPLOAD_2'					=> '语言包必须是 .zip 格式的压缩包。',
	'ERR_LANG_UPLOAD_3'					=> 'PHP无法移动临时文件到升级目录。',
	'ERR_LICENSE_MISSING'				=> '缺少必填字段',
	'ERR_LICENSE_NOT_FOUND'				=> '没有找到授权文件！',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> '提供的日志目录无效。',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> '提供的日志目录无法写入。',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> '如果您想要自定义，需要指定日志目录。',
	'ERR_NO_DIRECT_SCRIPT'				=> '无法直接进行脚本。',
	'ERR_NO_SINGLE_QUOTE'				=> '不可以使用单引号',
	'ERR_PASSWORD_MISMATCH'				=> '密码不匹配。',
	'ERR_PERFORM_CONFIG_PHP_1'			=> '无法定入<span class=stop>config.php</span>文件。',
	'ERR_PERFORM_CONFIG_PHP_2'			=> '您可以通过手动创建的 config.php 文件进行安装。<strong>必须</strong>将下面的配置信息粘贴到站点根目录的 config.php 文件中，然后再继续下一个步骤。',
	'ERR_PERFORM_CONFIG_PHP_3'			=> '是否忘记创建config.php文件？',
	'ERR_PERFORM_CONFIG_PHP_4'			=> '警告：无法写入config.php文件。 请确认此文件是否存在。',
	'ERR_PERFORM_HTACCESS_1'			=> '无法写入',
	'ERR_PERFORM_HTACCESS_2'			=> '文件。',
	'ERR_PERFORM_HTACCESS_3'			=> '如果你要保护被通过浏览器访问您的日志文件，在你的日志目录中创建一个.htaccess文件：',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>无法检测到互联网连接。</b>当连接到互联网时，请访问 <a href="http://www.suitecrm.com/">http://www.suitecrm.com</a> 注册。我们很高兴您能告知我们关于您使用 SuiteCRM 的计划及相关情况，以确保我们总能为您的业务提供最适合的产品。',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> '提供的会话目录是无效的目录',
	'ERR_SESSION_DIRECTORY'				=> '提供的会话目录为不可写入目录。',
	'ERR_SESSION_PATH'					=> '如需自定，需要会话路径。',
	'ERR_SI_NO_CONFIG'					=> '你没有包含在文档根config_si.php，或您没有在config.php 中定义sugar_config_si',
	'ERR_SITE_GUID'						=> '需要程序ID如您想自定。',
	'ERROR_SPRITE_SUPPORT'              => "当前未找到 GD 库，因此无法使用 CSS Sprite 功能。",
	'ERR_UPLOAD_MAX_FILESIZE'			=> '警告：你的PHP的配置应改为允许至少6MB的文件被上传。',
	'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => '上传文件大小',
	'ERR_URL_BLANK'						=> '请提供了SuiteCRM实例的基URL。',
	'ERR_UW_NO_UPDATE_RECORD'			=> '不能定位安装记录',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> '上传的文件和当前 SuiteCRM 版本不兼容：',
	'ERROR_LICENSE_EXPIRED'				=> "错误：您的许可过期 ",
	'ERROR_LICENSE_EXPIRED2'			=> " 天数已过.  请到 <a href='index.php?action=LicenseSettings&module=Administration'>'\"许可管理\"</a>  在管理员屏幕输入您的新许可关键字. 如果您在您的许可关键字到期30天内不输入新许可关键字，您将不能在登陆到这个应用中.",
	'ERROR_MANIFEST_TYPE'				=> 'manifest.php 文件必须指定程序包的类型。',
	'ERROR_PACKAGE_TYPE'				=> 'manifest.php 文件指定了无法识别的类型',
	'ERROR_VALIDATION_EXPIRED'			=> "错误：您验证的关键字过期 ",
	'ERROR_VALIDATION_EXPIRED2'			=> " 天数已过.  请到 <a href='index.php?action=LicenseSettings&module=Administration'>'\"许可管理\"</a> 在管理员界面输入您新的验证关键字.  如果您不在30天关键字验证有效期内输入新验证关键字, 您将不再能登陆这个应用.",
	'ERROR_VERSION_INCOMPATIBLE'		=> '上传的文件和当前 SuiteCRM 版本不兼容：',

	'LBL_BACK'							=> '返回',
	'LBL_CANCEL'                        => '取消',
	'LBL_ACCEPT'                        => '我接受',
	'LBL_CHECKSYS_1'					=> '为了使您的 SuiteCRM 安装并正常使用，请确保下面列出的所有的系统检查项目都是绿色的推荐设置。如果有任何红色的设置，请通过必要的设置来解决这些问题。<br /><br />有关这些系统检查的帮助，请访问 <a href="http://www.suitecrm.com"target="_blank"> SuiteCRM</a>。',
	'LBL_CHECKSYS_CACHE'				=> 'cache 子目录可写',
	'LBL_DROP_DB_CONFIRM'               => '所提供的数据库名称已经存在。<br>您可以：<br>1。点击取消按钮，然后选择一个新的数据库名称，或<br>2。点击接受按钮，然后继续。在数据库中的所有现有表将被删除。这意味着，该表和预先存在的数据都将被清除。',
	'LBL_CHECKSYS_CALL_TIME'			=> 'allow_call_time_pass_reference = off',
	'LBL_CHECKSYS_COMPONENT'			=> '组件',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> '可选组件',
	'LBL_CHECKSYS_CONFIG'				=> 'config.php 配置文件可写',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> 'config_override.php 配置文件可写',
	'LBL_CHECKSYS_CURL'					=> 'cURL 模块',
	'LBL_CHECKSYS_SESSION_SAVE_PATH'    => 'session 路径设置',
	'LBL_CHECKSYS_CUSTOM'				=> 'custom 目录可写',
	'LBL_CHECKSYS_DATA'					=> 'data 子目录可写',
	'LBL_CHECKSYS_IMAP'					=> 'IMAP 模块',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'mbstring 模块',
	'LBL_CHECKSYS_MEM_OK'				=> 'OK (No Limit)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'OK (Unlimited)',
	'LBL_CHECKSYS_MEM'					=> 'PHP 内存限制',
	'LBL_CHECKSYS_MODULE'				=> 'modules 子目录及文件可写',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'MySQL 版本',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> '不可用',
	'LBL_CHECKSYS_OK'					=> 'OK',
	'LBL_CHECKSYS_PHP_INI'				=> 'php.ini 配置文件路径：',
	'LBL_CHECKSYS_PHP_OK'				=> 'OK (ver ',
	'LBL_CHECKSYS_PHPVER'				=> 'PHP 版本',
	'LBL_CHECKSYS_IISVER'               => 'IIS 版本',
	'LBL_CHECKSYS_RECHECK'				=> '重新检查',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP 安全模式已关闭',
	'LBL_CHECKSYS_SESSION'				=> 'session 路径可写(',
	'LBL_CHECKSYS_STATUS'				=> '状态',
	'LBL_CHECKSYS_TITLE'				=> '系统检查验收',
	'LBL_CHECKSYS_VER'					=> '当前：( ver',
	'LBL_CHECKSYS_XML'					=> 'XML 解析',
	'LBL_CHECKSYS_ZLIB'					=> 'zlib 压缩模块',
	'LBL_CHECKSYS_ZIP'					=> 'zip 处理模块',
	'LBL_CHECKSYS_PCRE'					=> 'pcre 库',
	'LBL_CHECKSYS_FIX_FILES'            => '请修复下列文件或目录：',
	'LBL_CHECKSYS_FIX_MODULE_FILES'     => '请修复下列文件或目录：',
	'LBL_CHECKSYS_UPLOAD'               => '上传目录可写',
	'LBL_CLOSE'							=> '关闭',
	'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> '被创建',
	'LBL_CONFIRM_DB_TYPE'				=> '数据库类型',
	'LBL_CONFIRM_DIRECTIONS'			=> '请确认以下设置。如果你想改变任何值，点击“返回”编辑。否则，按“下一步”开始安装。',
	'LBL_CONFIRM_LICENSE_TITLE'			=> '授权信息',
	'LBL_CONFIRM_NOT'					=> '不',
	'LBL_CONFIRM_TITLE'					=> '确认设置',
	'LBL_CONFIRM_WILL'					=> '会',
	'LBL_DBCONF_CREATE_DB'				=> '创建数据库',
	'LBL_DBCONF_CREATE_USER'			=> '创建用户',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> '警告：如勾选此选项，所有数据将会被抹除。',
	'LBL_DBCONF_DB_DROP_CREATE'			=> '删除后重新创建已存在的SuiteCRM表格？',
	'LBL_DBCONF_DB_DROP'                => '删除表',
	'LBL_DBCONF_DB_NAME'				=> '数据库名称',
	'LBL_DBCONF_DB_PASSWORD'			=> 'SuiteCRM 数据库密码',
	'LBL_DBCONF_DB_PASSWORD2'			=> '重新输入SuiteCRM数据库用户密码',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM 数据库用户',
	'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM 数据库用户',
	'LBL_DBCONF_DB_ADMIN_USER'          => '数据库管理员用户名',
	'LBL_DBCONF_DB_ADMIN_PASSWORD'      => '数据库管理员密码',
	'LBL_DBCONF_DEMO_DATA'				=> '安装带示例数据的数据库',
	'LBL_DBCONF_DEMO_DATA_TITLE'        => '选择示例数据',
	'LBL_DBCONF_HOST_NAME'				=> '主机名称',
	'LBL_DBCONF_HOST_INSTANCE'			=> '主机实例',
	'LBL_DBCONF_HOST_PORT'				=> '端口',
	'LBL_DBCONF_INSTRUCTIONS'			=> '请输入您的数据库配置信息。如果不确定如何配置，我们建议您使用默认值。',
	'LBL_DBCONF_MB_DEMO_DATA'			=> '使用多字节的示例数据',
	'LBL_DBCONFIG_MSG2'                 => '数据库所在的网络服务器或计算机名称（主机)（如localhost或www.mydomain.com ）：',
	'LBL_DBCONFIG_MSG2_LABEL' => '主机名称',
	'LBL_DBCONFIG_MSG3'                 => '数据库的名称将包含用于SuiteCRM实例数据，你将要安装：',
	'LBL_DBCONFIG_MSG3_LABEL' => '数据库名称',
	'LBL_DBCONFIG_B_MSG1'               => '用户名和数据库管理员谁可以创建数据库表和用户，谁可以写入数据库密码是必要的，以便建立SuiteCRM数据库。',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
	'LBL_DBCONFIG_SECURITY'             => '为了安全起见，您可以指定一个独家数据库用户连接到数据库的SuiteCRM。此用户必须是能写，更新和检索数据库的SuiteCRM将用于该实例创建的数据。该用户可以是上面指定的数据库管理员，也可以提供新的或现有的数据库用户的信息。',
	'LBL_DBCONFIG_AUTO_DD'              => '请帮我执行',
	'LBL_DBCONFIG_PROVIDE_DD'           => '提供已存在的用户',
	'LBL_DBCONFIG_CREATE_DD'            => '定义或创建用户',
	'LBL_DBCONFIG_SAME_DD'              => '和管理用户相同',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
	'LBL_FTS'                           => '纯文本搜索',
	'LBL_FTS_INSTALLED'                 => '已安装',
	'LBL_FTS_INSTALLED_ERR1'            => '纯文本搜索功能未被安装。',
	'LBL_FTS_INSTALLED_ERR2'            => '您可以继续安装，但会无法使用纯文本搜索功能。 请在数据库服务器安装向导查询如何操作，或联系管理员。',
	'LBL_DBCONF_PRIV_PASS'				=> '特权数据库用户密码',
	'LBL_DBCONF_PRIV_USER_2'			=> '以上数据库账户是一个特权用户？',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> '这种特权的数据库用户必须具有适当的权限来创建一个数据库，删除/创建表，并创建一个用户。这种特权的数据库用户将只用于执行期间安装过程中需要完成这些任务。你也可以使用上述如果该用户具有足够的权限相同的数据库用户。',
	'LBL_DBCONF_PRIV_USER'				=> '高级数据库用户名',
	'LBL_DBCONF_TITLE'					=> '数据库安装',
	'LBL_DBCONF_TITLE_NAME'             => '提供数据库名称',
	'LBL_DBCONF_TITLE_USER_INFO'        => '提供数据库用户信息',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => '负责人',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => '密码',
	'LBL_DISABLED_DESCRIPTION_2'		=> '在此之后改变了一些进展，您可以点击“开始”下面的按钮，开始安装。安装完成后，你会想改变\'installer_locked\'的值\'true\'。',
	'LBL_DISABLED_DESCRIPTION'			=> '安装程序已运行一次。作为一项安全措施，它已被禁用运行第二次。如果你绝对确定要再次运行它，请到你的config.php文件，然后找到（或添加）一个变量叫\'installer_locked\'，并将其设置为\'false\'。该行应该是这样的：',
	'LBL_DISABLED_HELP_1'				=> '获取安装帮助，请访问SuiteCRM',
	'LBL_DISABLED_HELP_LNK'             => 'http://www.suitecrm.com/forum/index',
	'LBL_DISABLED_HELP_2'				=> '支持论坛',
	'LBL_DISABLED_TITLE_2'				=> 'SuiteCRM安装已被禁止',
	'LBL_DISABLED_TITLE'				=> 'SuiteCRM安装被禁止',
	'LBL_EMAIL_CHARSET_DESC'			=> '字符集最常用的语言环境',
	'LBL_EMAIL_CHARSET_TITLE'			=> '发件箱设置',
	'LBL_EMAIL_CHARSET_CONF'            => '外发电子邮件字符集',
	'LBL_HELP'							=> '帮助',
	'LBL_INSTALL'                       => '安装',
	'LBL_INSTALL_TYPE_TITLE'            => '安装选项',
	'LBL_INSTALL_TYPE_SUBTITLE'         => '选择安装类型',
	'LBL_INSTALL_TYPE_TYPICAL'          => '典型安装',
	'LBL_INSTALL_TYPE_CUSTOM'           => '自定义安装',
	'LBL_INSTALL_TYPE_MSG1'             => '密钥是必须的以用一般应用程序的功能，但它不是安装所必需的。你并不需要输入此时的密钥，但你需要提供的密钥在您安装该应用程序。',
	'LBL_INSTALL_TYPE_MSG2'             => '最低要求的信息进行安装。推荐新用户。',
	'LBL_INSTALL_TYPE_MSG3'             => '提供额外的选项来设置在安装过程中。这些选项后，大多也可以在管理屏幕的安装。建议高级用户使用。',
	'LBL_LANG_1'						=> '要在 SuiteCRM 中使用除默认语言（美国英语）之外的其他语言，您可以在此时上传并安装语言包。在安装完成后，您也可以通过 SuiteCRM 系统管理中的模块加载器上载并安装语言包。如果您想跳过此步骤，请点击 下一步 。',
	'LBL_LANG_BUTTON_COMMIT'			=> '安装',
	'LBL_LANG_BUTTON_REMOVE'			=> '移除',
	'LBL_LANG_BUTTON_UNINSTALL'			=> '删除',
	'LBL_LANG_BUTTON_UPLOAD'			=> '上传',
	'LBL_LANG_NO_PACKS'					=> '无',
	'LBL_LANG_PACK_INSTALLED'			=> '已安装',
	'LBL_LANG_PACK_READY'				=> '准备安装',
	'LBL_LANG_SUCCESS'					=> '语言包已成功上传。',
	'LBL_LANG_TITLE'			   		=> '语言包',
	'LBL_LAUNCHING_SILENT_INSTALL'     => '正在安装SuiteCRM。 可能需要几分钟。',
	'LBL_LANG_UPLOAD'					=> '上传语言包',
	'LBL_LICENSE_ACCEPTANCE'			=> '接受许可协议',
	'LBL_LICENSE_CHECKING'              => '查询系统兼容性。',
	'LBL_LICENSE_CHKENV_HEADER'         => '查询环境',
	'LBL_LICENSE_CHKDB_HEADER'          => '数据库身份验证',
	'LBL_LICENSE_CHECK_PASSED'          => '系统通过兼容性查询。',
	'LBL_CREATE_CACHE' => '正在准备安装...',
	'LBL_LICENSE_REDIRECT'              => '重定向到',
	'LBL_LICENSE_DIRECTIONS'			=> '请在下面的栏框里输入您已持有的授权信息。',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> '输入下载钥匙',
	'LBL_LICENSE_EXPIRY'				=> '到期日期',
	'LBL_LICENSE_I_ACCEPT'				=> '我接受',
	'LBL_LICENSE_NUM_USERS'				=> '用户数',
	'LBL_LICENSE_OC_DIRECTIONS'			=> '请输入已购买的线下客户端的数量',
	'LBL_LICENSE_OC_NUM'				=> '离线客户端许可证数',
	'LBL_LICENSE_OC'					=> '线下客户授权',
	'LBL_LICENSE_PRINTABLE'				=> '请在以下栏里输入您持有的授权信息。',
	'LBL_PRINT_SUMM'                    => '打印总结',
	'LBL_LICENSE_TITLE_2'				=> 'SuiteCRM 授权',
	'LBL_LICENSE_TITLE'					=> '授权信息',
	'LBL_LICENSE_USERS'					=> '授权用户',

	'LBL_LOCALE_CURRENCY'				=> '货币设置',
	'LBL_LOCALE_CURR_DEFAULT'			=> '默认货币',
	'LBL_LOCALE_CURR_SYMBOL'			=> '货币符号',
	'LBL_LOCALE_CURR_ISO'				=> 'ISO 4217 货币代码',
	'LBL_LOCALE_CURR_1000S'				=> '千分符',
	'LBL_LOCALE_CURR_DECIMAL'			=> '小数分隔符(十进制)',
	'LBL_LOCALE_CURR_EXAMPLE'			=> '示例',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> '精确度',
	'LBL_LOCALE_DATEF'					=> '默认日期格式',
	'LBL_LOCALE_DESC'					=> '-`指定的区域设置将反映在全局范围内SuiteCRM的实例。',
	'LBL_LOCALE_EXPORT'					=> '字符导入/导出设置<br> <i>(Email, .csv, vCard, PDF, 数据导入)</i>',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> '导出（.csv）的分隔符',
	'LBL_LOCALE_EXPORT_TITLE'			=> '导入/导出 设置',
	'LBL_LOCALE_LANG'					=> '默认语言',
	'LBL_LOCALE_NAMEF'					=> '默认名称格式',
	'LBL_LOCALE_NAMEF_DESC'				=> 's =称呼<br />f =名字<br />l=姓氏',
	'LBL_LOCALE_NAME_FIRST'				=> '大卫',
	'LBL_LOCALE_NAME_LAST'				=> '李文斯顿',
	'LBL_LOCALE_NAME_SALUTATION'		=> '博士',
	'LBL_LOCALE_TIMEF'					=> '默认时间格式',
	'LBL_CUSTOMIZE_LOCALE'              => '自定义区域设置',
	'LBL_LOCALE_UI'						=> '用户界面',

	'LBL_ML_ACTION'						=> '动作',
	'LBL_ML_DESCRIPTION'				=> '说明',
	'LBL_ML_INSTALLED'					=> '安装日期',
	'LBL_ML_NAME'						=> '名称',
	'LBL_ML_PUBLISHED'					=> '公布日期',
	'LBL_ML_TYPE'						=> '类型',
	'LBL_ML_UNINSTALLABLE'				=> '可卸载',
	'LBL_ML_VERSION'					=> '版本',
	'LBL_MSSQL'							=> 'SQL 服务器',
	'LBL_MSSQL2'                        => 'SQL 服务器 (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL 服务器 (微软 SQL 服务器 PHP 驱动)',
	'LBL_MYSQL'							=> 'MySQL',
	'LBL_MYSQLI'						=> 'MySQL (mysqli 扩展)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> '下页',
	'LBL_NO'							=> '否',
	'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> '设置网站管理员密码',
	'LBL_PERFORM_AUDIT_TABLE'			=> '审计表格 /',
	'LBL_PERFORM_CONFIG_PHP'			=> '创建SuiteCRM安装文件',
	'LBL_PERFORM_CREATE_DB_1'			=> '创建数据库进行中',
	'LBL_PERFORM_CREATE_DB_2'			=> '开启',
	'LBL_PERFORM_CREATE_DB_USER'		=> '创建数据库用户名和密码。。。',
	'LBL_PERFORM_CREATE_DEFAULT'		=> '创建默认SuiteCRM数据',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> '创建本地主机数据库用户名和密码。。。',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> '创建SuiteCRM关系图表',
	'LBL_PERFORM_CREATING'				=> '创建 /',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> '创建默认报告',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> '创建默认调度程序任务进行中',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> '嵌入默认设置',
	'LBL_PERFORM_DEFAULT_USERS'			=> '创建默认用户',
	'LBL_PERFORM_DEMO_DATA'				=> '创建数据库表和示例数据进行中(需要一些时间)',
	'LBL_PERFORM_DONE'					=> '完成',
	'LBL_PERFORM_DROPPING'				=> '删除 /',
	'LBL_PERFORM_FINISH'				=> '完成',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> '更新授权信息',
	'LBL_PERFORM_OUTRO_1'				=> 'SuiteCRM 安装',
	'LBL_PERFORM_OUTRO_2'				=> '已完成',
	'LBL_PERFORM_OUTRO_3'				=> '总时间：',
	'LBL_PERFORM_OUTRO_4'				=> '秒',
	'LBL_PERFORM_OUTRO_5'				=> '内存使用：',
	'LBL_PERFORM_OUTRO_6'				=> '字节',
	'LBL_PERFORM_OUTRO_7'				=> '您的系统已经安装并配置完成。',
	'LBL_PERFORM_REL_META'				=> '关系无数据...',
	'LBL_PERFORM_SUCCESS'				=> '成功！',
	'LBL_PERFORM_TABLES'				=> 'SuiteCRM创建应用程序表，审计表和元数据的关系',
	'LBL_PERFORM_TITLE'					=> '实行安装',
	'LBL_PRINT'							=> '打印',
	'LBL_REG_CONF_1'					=> '请填写下面的表单以收取SuiteCRM的产品发布，培训新闻，特别优惠和特别活动的邀请。我们不会出售，出租，共享或以其他方式分发所收集的信息在这里给第三方。',
	'LBL_REG_CONF_2'					=> '你的名字和电子邮件地址只需要在注册过程中的字段。所有其他字段都是可选的，但非常有帮助。我们不会出售，出租，共享，分发或以其他方式所收集的信息在这里给第三方。',
	'LBL_REG_CONF_3'					=> '感谢您的注册。点击完成按钮登录到SuiteCRM的。您需要登录首次使用用户名“admin”和密码您在步骤2中输入。',
	'LBL_REG_TITLE'						=> '注册',
	'LBL_REG_NO_THANKS'                 => '谢绝',
	'LBL_REG_SKIP_THIS_STEP'            => '跳过此步骤',
	'LBL_REQUIRED'						=> '* 必填字段',

	'LBL_SITECFG_ADMIN_Name'            => '设置管理员名称',
	'LBL_SITECFG_ADMIN_PASS_2'			=> '重新输入SuiteCRM管理用户密码',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> '注意：从前安装的任何管理员密码都将被覆盖。',
	'LBL_SITECFG_ADMIN_PASS'			=> 'SuiteCRM管理用户密码',
	'LBL_SITECFG_APP_ID'				=> '程序ID',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> '如果选择，你必须提供一个应用程序ID来覆盖自动生成的ID。该ID确保会议的一个SuiteCRM实例不被其他一些情况。如果你有一个SuiteCRM安装群集，它们都必须共享相同的应用程序ID。',
	'LBL_SITECFG_CUSTOM_ID'				=> '提供您自己的程序ID',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> '如果选中，你必须指定一个日志目录覆盖用于SuiteCRM日志的默认目录。无论在何处的日志文件的位置，可以通过一个Web浏览器将被限制通过的.htaccess重定向。',
	'LBL_SITECFG_CUSTOM_LOG'			=> '使用自定义日志目录',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> '如果选择，你必须提供一个用于存储信息的安全文件夹中SuiteCRM会话。这可以做，以防止在共享服务器脆弱的会话数据。',
	'LBL_SITECFG_CUSTOM_SESSION'		=> '为SuiteCRM使用自定义会话目录',
	'LBL_SITECFG_DIRECTIONS'			=> '请输入您的站点配置信息。如果不确定如何配置，我们建议您使用默认值。',
	'LBL_SITECFG_FIX_ERRORS'			=> '在继续执行前请修复以下错误：',
	'LBL_SITECFG_LOG_DIR'				=> '日志目录',
	'LBL_SITECFG_SESSION_PATH'			=> '会话目录路径<br>(必须为可写入)',
	'LBL_SITECFG_SITE_SECURITY'			=> '选择安全选项',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> '如果选择，系统将定期检查应用程序的更新版本。',
	'LBL_SITECFG_SUGAR_UP'				=> '自动查询更新？',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'SuiteCRM更新配置',
	'LBL_SITECFG_TITLE'					=> '网页安装',
	'LBL_SITECFG_TITLE2'                => '识别管理用户',
	'LBL_SITECFG_SECURITY_TITLE'        => '站点安全',
	'LBL_SITECFG_URL'					=> 'SuiteCRM实例的URL',
	'LBL_SITECFG_USE_DEFAULTS'			=> '使用默认？',
	'LBL_SITECFG_ANONSTATS'             => '发送匿名使用统计？',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => '如果选择，SuiteCRM会发送有关您安装SuiteCRM公司每一次新版本的系统检查，匿名的统计数字。这些信息将有助于我们更好地了解应用程序如何使用和指导改进产品。',
	'LBL_SITECFG_URL_MSG'               => '输入将被用来访问安装后SuiteCRM实例的URL。该网址也将被用来作为网址中的SuiteCRM应用程序页的基础。该网址应包括网络服务器或计算机名称或IP地址。',
	'LBL_SITECFG_SYS_NAME_MSG'          => '输入您的系统名称。设置用户访问 SuiteCRM 时，在浏览器标题栏显示的名称。',
	'LBL_SITECFG_PASSWORD_MSG'          => '安装后，您将需要使用SuiteCRM管理员用户（默认用户名=管理员）登录到SuiteCRM的实例。输入此管理员用户的密码。此密码可以更改后的最初登录。您也可以输入另一个管理员使用的用户名，除了提供默认值。',
	'LBL_SITECFG_COLLATION_MSG'         => '请选择您系统的数据库排序规则。如果您不需要特殊设置，请使用默认值。中文推荐使用 utf8_general_ci 。',
	'LBL_SPRITE_SUPPORT'                => 'Sprite 支持',
	'LBL_SYSTEM_CREDS'                  => '系统证书',
	'LBL_SYSTEM_ENV'                    => '系统环境',
	'LBL_START'							=> '首页',
	'LBL_SHOW_PASS'                     => '显示密码',
	'LBL_HIDE_PASS'                     => '隐藏密码',
	'LBL_HIDDEN'                        => '（隐藏）',
	'LBL_STEP1' => '步骤 1：安装要求',
	'LBL_STEP2' => '步骤 2：配置',
//    'LBL_STEP1'                         => 'Step 1 of 8 - Pre-Installation requirements',
//    'LBL_STEP2'                         => 'Step 2 of 8 - License Agreement',
//    'LBL_STEP3'                         => 'Step 3 of 8 - Installation Type',
//    'LBL_STEP4'                         => 'Step 4 of 8 - Database Selection',
//    'LBL_STEP5'                         => 'Step 5 of 8 - Database Configuration',
//    'LBL_STEP6'                         => 'Step 6 of 8 - Site Configuration',
//    'LBL_STEP7'                         => 'Step 7 of 8 - Confirm Settings',
//    'LBL_STEP8'                         => 'Step 8 of 8 - Installation Successful',
//	'LBL_NO_THANKS'						=> 'Continue to installer',
	'LBL_CHOOSE_LANG'					=> '<b>选择您的语言</b>',
	'LBL_STEP'							=> '步骤',
	'LBL_TITLE_WELCOME'					=> '欢迎使用SuiteCRM',
	'LBL_WELCOME_1'						=> '安装程序将创建 SuiteCRM 数据表并设置配置信息。整个过程大概需要几分钟。',
	'LBL_WELCOME_2'						=> '安装帮助，请访问 SuiteCRM <a href="http://suitecrm.com/index.php/forum/index"target="_blank">支持论坛</a>。',
	//welcome page variables
	'LBL_TITLE_ARE_YOU_READY'            => '已准备好安装？',
	'REQUIRED_SYS_COMP' => '需求系统组件',
	'REQUIRED_SYS_COMP_MSG' =>
		'在开始之前，请确保您有以下系统组件所支持的版本：
数据库/数据库管理系统（如：MySQL中，SQL服务器，Oracle）
网页服务器（Apache，IIS）的
在咨询用于SuiteCRM版本，您正在安装兼容的系统部件的发行说明兼容性矩阵。<br>',
	'REQUIRED_SYS_CHK' => '初始系统检查',
	'REQUIRED_SYS_CHK_MSG' =>
		'当您开始安装过程中，将进行系统检查在Web服务器上的文件位于SuiteCRM，以确保系统的正确配置，具有所有必要的组件安装成功完成。
该系统将检查以下所有：
PHP版本 - 必须与应用程序兼容
会话变量 - 必须正常工作
MB的字符串 - 必须安装并在php.ini中启用
数据库支持 - 必须存在于MySQL，SQL Server或Oracle
config.php文件 - 必须存在，必须具有相应的权限，使其可写
下面的SuiteCRMf文件必须可写：
/自定义
/高速缓存
/模块
如果检查失败，您将无法继续进行安装。错误信息会被显示，解释为什么你的系统没有通过检查。作出任何必要的修改后，你可以进行系统检查再次以继续安装。',
	'REQUIRED_INSTALLTYPE' => '精简或自定义安装',
	'REQUIRED_INSTALLTYPE_MSG' =>
		'在系统执行检查，你可以选择典型或自定义安装。
对于这两种典型和自定义安装，你需要了解以下信息：
类型的数据库，将容纳SuiteCRM数据
兼容的数据库类型：MySQL中，微软SQL服务器，Oracle。
在Web服务器或机器名（主机）上的数据库所在
这可能是本地主机如果数据库是在本地计算机上或在同一个Web服务器或文件作为SuiteCRM文件。
数据库的名称，你想用SuiteCRM来容纳数据
您可能已经有一个现有的数据库，你会喜欢用。如果您提供的现有数据库的名称，在数据库中的表将被删除时，在安装过程中SuiteCRM数据库的架构定义。
如果你不已经有一个数据库，您提供的名称将用于新的数据库资源，对安装过程中创建的实例。
数据库管理员用户名和密码
数据库管理员应该能够创建表和用户写入数据库。
你可能需要联系此信息数据库，如果数据库管理员不位于您的本地计算机和/或如果您不是数据库管理员。
SuiteCRM数据库用户名和密码
用户可能是数据库管理员，或者您可能提供的另一个现有的数据库用户名。
如果你想创建一个新的数据库用于此目的的用户，您将能够提供一个新的用户名和密码在安装过程中，用户将在安装时创建的。
对于自定义设置，您可能还需要了解以下信息：
网址将被用于访问SuiteCRM安装后的实例。此网址应包括网络服务器或计算机名称或IP地址。
[可选]会话目录的路径，如果你想使用一个自定义会话SuiteCRM信息目录，以防止在共享服务器脆弱的会话数据。
[可选]路径的自定义日志目录，如果你想覆盖用于SuiteCRM日志的默认目录。
[可选]申请ID，如果你想覆盖自动生成的ID，即确保会议的一个SuiteCRM实例不被其他一些情况。
字符集最常用的语言环境。
如需详细资料，请参阅安装指南',
	'LBL_WELCOME_PLEASE_READ_BELOW' => '在安装前请阅读以下重要信息，这些信息将帮助您确定是否已准备好安装。',

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '选择您的语言',
	'LBL_WELCOME_SETUP_WIZARD'			=> '安装向导',
	'LBL_WELCOME_TITLE_WELCOME'			=> '欢迎使用 SuiteCRM',
	'LBL_WELCOME_TITLE'					=> 'SuiteCRM 安装向导',
	'LBL_WIZARD_TITLE'					=> 'SuiteCRM 安装向导：',
	'LBL_YES'							=> '是',
	'LBL_YES_MULTI'                     => '确定 - 多字节',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> '使工作流程任务进行',
	'LBL_OOTB_REPORTS'		=> '为计划任务产生报表',
	'LBL_OOTB_IE'			=> '检查收件箱',
	'LBL_OOTB_BOUNCE'		=> '每晚处理营销活动退信邮件',
	'LBL_OOTB_CAMPAIGN'		=> '每晚批量发送营销活动邮件',
	'LBL_OOTB_PRUNE'		=> '每月1号精简数据库',
	'LBL_OOTB_TRACKER'		=> '删除用户历史表',
	'LBL_OOTB_SUGARFEEDS'   => '修剪 SuiteCRM Feed 数据库表',
	'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> '运行邮件提醒通知',
	'LBL_UPDATE_TRACKER_SESSIONS' => '更新 tracker_sessions 表',
	'LBL_OOTB_CLEANUP_QUEUE' => '清理任务队列',
	'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => '从文件系统的文件删除',


	'LBL_PATCHES_TITLE'     => '安装最新补丁',
	'LBL_MODULE_TITLE'      => '安装语言包',
	'LBL_PATCH_1'           => '点击下一步来跳过此步骤。',
	'LBL_PATCH_TITLE'       => '系统补丁',
	'LBL_PATCH_READY'       => '准备安装',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "当前的 PHP 未正确配置会话信息。SuiteCRM 依靠 PHP 会话来存储客户端连接到此服务器的重要信息。<br /><br />常见的错误配置是 <b>'session.save_path‘</b> 参数未设置有效的目录。<br /><br />请可通过修改 php.ini 配置文件或其他方式进行配置，具体请参阅<a target=_new href='http://us2.php.net/manual/en/ref.session.php'>官方手册</a>。",
	'LBL_SESSION_ERR_TITLE'				=> 'PHP session 配置错误',
	'LBL_SYSTEM_NAME'=>'系统名称',
	'LBL_COLLATION' => '排序规则设置',
	'LBL_REQUIRED_SYSTEM_NAME'=>'设置 SuiteCRM 的系统名称。',
	'LBL_PATCH_UPLOAD' => '从您的本地计算机选择一个补丁',
	'LBL_INCOMPATIBLE_PHP_VERSION' => '需要Php5或以上版本.',
	'LBL_MINIMUM_PHP_VERSION' => '最低PHP版本要求5.1.0。推荐PHP版本为5.2.x.',
	'LBL_YOUR_PHP_VERSION' => '(您当前的PHP版本是 ',
	'LBL_RECOMMENDED_PHP_VERSION' =>'php version 推荐版本为 5.2.x)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'Php向后兼容模式已打开. 如果想关闭请将zend.ze1_compatibility_mode设置成off.',
	'LBL_STREAM' => 'PHP 允许使用 stream',

	'advanced_password_new_account_email' => array(
		'subject' => '欢迎使用 SuiteCRM',
		'description' => '此模板用于系统管理员给新用户发送密码。',
		'body' => '<div><table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\" width="550" align=\\"\\&quot;\\&quot;center\\&quot;\\&quot;\\"><tbody><tr><td colspan=\\"2\\"><p>Here is your account username and temporary password:</p><p>Username : $contact_user_user_name </p><p>Password : $contact_user_user_hash </p><br><p>$config_site_url</p><br><p>After you log in using the above password, you may be required to reset the password to one of your own choice.</p>   </td>         </tr><tr><td colspan=\\"2\\"></td>         </tr> </tbody></table> </div>',
		'txt_body' =>
			'
Here is your account username and temporary password:
Username : $contact_user_user_name
Password : $contact_user_user_hash

$config_site_url

After you log in using the above password, you may be required to reset the password to one of your own choice.',
		'name' => '欢迎使用 SuiteCRM',
	),
	'advanced_password_forgot_password_email' => array(
		'subject' => '重置密码',
		'description' => "该模板用于给用户发送密码重置链接。 ",
		'body' => '<div><table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\" width="550" align=\\"\\&quot;\\&quot;center\\&quot;\\&quot;\\"><tbody><tr><td colspan=\\"2\\"><p>您选择重新设置 CRM 登陆密码。</p><p>请点击下面链接来重新设置您的密码。</p><p> $contact_user_link_guid </p>  </td>         </tr><tr><td colspan=\\"2\\"></td>         </tr> </tbody></table> </div>',
		'txt_body' =>
			'您选择重新设置 CRM 登陆密码。

请点击下面链接来重新设置您的密码。

$contact_user_link_guid
',
		'name' => '密码找回邮件',
	),

	// SMTP settings

	'LBL_WIZARD_SMTP_DESC' => '提供用来收发分配提示以及新用户密码的邮件。当邮件由指定的邮件账户发送时，用户将会从SuiteCRM接收邮件。',
	'LBL_CHOOSE_EMAIL_PROVIDER'        => '请选择您的邮件提供商',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! Mail',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => '其它',
	'LBL_MAIL_SMTP_SETTINGS'           => 'SMTP 设置',
	'LBL_MAIL_SMTPSERVER'				=> '服务器地址',
	'LBL_MAIL_SMTPPORT'					=> '端口',
	'LBL_MAIL_SMTPAUTH_REQ'				=> '需要身份验证',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => '使用 SSL 或 TLS',
	'LBL_GMAIL_SMTPUSER'					=> '用户名',
	'LBL_GMAIL_SMTPPASS'					=> '密码',
	'LBL_ALLOW_DEFAULT_SELECTION'           => '允许用户使用该帐号作为外发电子邮件帐号：',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => '选择此选项时，所有用户将通过发送系统提示以及警告相同的邮件账户发送对外邮件。 如不选此选项，用户只能使用提供用户自己账户信息后的对外邮件服务器 。',

	'LBL_YAHOOMAIL_SMTPPASS'					=> '密码',
	'LBL_YAHOOMAIL_SMTPUSER'					=> '用户名',

	'LBL_EXCHANGE_SMTPPASS'					=> '密码',
	'LBL_EXCHANGE_SMTPUSER'					=> '用户名',
	'LBL_EXCHANGE_SMTPPORT'					=> '端口',
	'LBL_EXCHANGE_SMTPSERVER'				=> '服务器地址',


	'LBL_MAIL_SMTPUSER'					=> '用户名',
	'LBL_MAIL_SMTPPASS'					=> '密码',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => '商标',
	'LBL_WIZARD_SYSTEM_DESC' => '为了打洛您的SuiteCRM，请提供您的组织名称与商标。',
	'SYSTEM_NAME_WIZARD'=>'名称',
	'SYSTEM_NAME_HELP'=>'设置在浏览器标题栏显示的名称。',
	'NEW_LOGO'=>'上传新标识(212x40)',
	'NEW_LOGO_HELP'=>'图像文件格式可以是 .jpg 或 .png。最大高度 170px，最大宽度 450px。任何上传的图像大于最大尺寸将自动缩放。',
	'COMPANY_LOGO_UPLOAD_BTN' => '上传',
	'CURRENT_LOGO'=>'当前使用的标识',
	'CURRENT_LOGO_HELP'=>'Logo 会在左下角显示。',


	//Scenario selection of modules
	'LBL_WIZARD_SCENARIO_TITLE' => '场景选择',
	'LBL_WIZARD_SCENARIO_DESC' => '根据您的需求定制显示的模块，您也可以在安装后通过 系统管理 页面对每个模块进行设置。',
	'LBL_WIZARD_SCENARIO_EMPTY'=> 'config.php 当前未配置任何场景',



	// System Local Settings


	'LBL_LOCALE_TITLE' => '系统区域设置',
	'LBL_WIZARD_LOCALE_DESC' => '基于您的地域位置来指定数据在SuiteCRM中的显示。 您提供的设置会成为默认设置，用户可以设置自己的参数选择。',
	'LBL_DATE_FORMAT' => '日期格式:',
	'LBL_TIME_FORMAT' => '时间格式',
	'LBL_TIMEZONE' => '时区',
	'LBL_LANGUAGE'=>'语言:',
	'LBL_CURRENCY'=>'货币',
	'LBL_CURRENCY_SYMBOL'=>'货币符号',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 货币代码',
	'LBL_NUMBER_GROUPING_SEP' => '千分符',
	'LBL_DECIMAL_SEP' => '小数点符号',
	'LBL_NAME_FORMAT' => '姓名格式',
	'UPLOAD_LOGO' => '正在上传 Logo...',
	'ERR_UPLOAD_FILETYPE' => '文件类型不允许，请上传 jpeg 或 png 格式的文件。',
	'ERR_LANG_UPLOAD_UNKNOWN' => '文件上传时出现未知错误。',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => '上传文件大小超出了php.ini文件中变量upload_max_filesize指定的值。',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => '上传文件大小超出了HTML表单中变量MAX_FILE_SIZE指定的值。',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => '只上传了部分文件。',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => '没有上传文件。',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => '缺少临时文件夹。',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => '写入磁盘文件错误。',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => '一个 PHP 扩展阻止了文件上传。PHP 无法确定哪个扩展阻止了文件上传。',

	'LBL_INSTALL_PROCESS' => '安装...',

	'LBL_EMAIL_ADDRESS' => '邮件地址',
	'ERR_ADMIN_EMAIL' => '管理员电子邮件地址不正确。',
	'ERR_SITE_URL' => '网站的 URL 地址是必需的。',

	'STAT_CONFIGURATION' => '配置关系...',
	'STAT_CREATE_DB' => '创建数据库...',
	//'STAT_CREATE_DB_TABLE' => 'Create database... (table: %s)',
	'STAT_CREATE_DEFAULT_SETTINGS' => '创建默认设置...',
	'STAT_INSTALL_FINISH' => '安装完成...',
	'STAT_INSTALL_FINISH_LOGIN' => '安装已完成，<a href="%s"> 请登录</a>',
	'LBL_LICENCE_TOOLTIP' => '请先接受许可协议',

	'LBL_MORE_OPTIONS_TITLE' => '更多选项',
	'LBL_START' => '首页',
	'LBL_DB_CONN_ERR' => '数据库链接错误'


);

?>
