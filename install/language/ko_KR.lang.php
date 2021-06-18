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
	'LBL_BASIC_SEARCH'					=> '기본 검색',
	'LBL_ADVANCED_SEARCH'				=> '고급 검색',
	'LBL_BASIC_TYPE'					=> '기본 유형',
	'LBL_ADVANCED_TYPE'					=> '고급 유형',
	'LBL_SYSOPTS_1'						=> '아래에서 구성옵션을 선택하세요',
	'LBL_SYSOPTS_2'                     => '어떤 종류의 데이터베이스가 설치하려고하는 SuiteCRM 사례에 사용될 것입니까?',
	'LBL_SYSOPTS_CONFIG'				=> '시스템 구성',
	'LBL_SYSOPTS_DB_TYPE'				=> '',
	'LBL_SYSOPTS_DB'					=> '데이터베이스 형식 지정',
	'LBL_SYSOPTS_DB_TITLE'              => '데이터베이스 유형',
	'LBL_SYSOPTS_ERRS_TITLE'			=> '진행하기 전에 다음의 에러들을 수정해주세요',
	'LBL_MAKE_DIRECTORY_WRITABLE'      => '쓸 수 있는 디렉토리를 확인하세요',
	'ERR_DB_VERSION_FAILURE'			=> '데이터베이스 버전을 확인할 수 없습니다.',
	'DEFAULT_CHARSET'					=> 'UTF-8',
	'ERR_ADMIN_USER_NAME_BLANK'         => 'SuiteCRM 관리자 사용자의 유저 Id를 입력하십시오. ',
	'ERR_ADMIN_PASS_BLANK'				=> 'SuiteCRM 관리자 사용자의 암호를 제공 합니다. ',

	//'ERR_CHECKSYS_CALL_TIME'			=> 'Allow Call Time Pass Reference is Off (please enable in php.ini)',
	'ERR_CHECKSYS'                      => '호환성검사를 하는 동안 오류가 발견되었습니다. SuiteCRM을 설치하려면 아래의 리스트에따라 수행하시길 바랍니다. 그리고 재확인 버튼을 누르시거나 다시 설치해주시길 바랍니다.',
	'ERR_CHECKSYS_CALL_TIME'            => '함수 호출시 참조에 의한 전달 허용(allow_call_time_pass_reference)이 On (이 설정은 php.ini 에서 Off로 설정해야 합니다.)',
	'ERR_CHECKSYS_CURL'					=> '찾을 수 없습니다: SuiteCRM 스케줄러는 제한된 기능으로 실행 됩니다.',
	'ERR_CHECKSYS_IMAP'					=> '찾을 수 없습니다: 인바운드메일과 캠페인(이메일) 은 IMAP 라이브러리가 필요합니다. 어느것도 작동되지 않을 것입니다.',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'MS SQL 서버를 사용할 경우에는, Magic Quotes GPC는 On으로 할 수 없습니다.',
	'ERR_CHECKSYS_MEM_LIMIT_0'			=> '경고: ',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> ' (Set this to ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'php.ini 파일에서 M 또는 그 이상으로 설정)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> '최소 버전 4.1.2-발견: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> '세션값을 쓰거나 읽지 못했습니다. 설치를 계속할 수 없습니다.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> '유효한 디렉토리가 아닙니다.',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> '경고: 쓸 수 없습니다.',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'PHP버전이 SuiteCRM에 지원되지 않습니다. SuiteCRM에 맞는 버전을 설치해주세요. PHP버전에 지원되는 릴리즈정보에 호환성 매트릭스를 참조하세요. 버전은 ',
	'ERR_CHECKSYS_IIS_INVALID_VER'      => 'IIS버전이 SuiteCRM에 지원되지 않습니다. SuiteCRM에 맞는 버전을 설치해야 합니다. ISS버전에 지원되는 릴리즈정보에 호환성매트릭스를 참조하세요. ',
	'ERR_CHECKSYS_FASTCGI'              => 'PHP의 FastCGI handler mapping이 되어있지 않음을 확인하였습니다. SuiteCRM 어플리케이션은 이 호환되는 버전의 FastCGI handler mapping설치 및 설정이 필요합니다. 호환되는 버전은 매트릭스에 릴리즈 노트에서 확인하세요. 상세한 내용은<a href="http://www.iis.net/php/" target="_blank">http://www.iis.net/php/</a> 에서 확인 할 수 있습니다 ',
	'ERR_CHECKSYS_FASTCGI_LOGGING'      => 'IIS/FastCGI sapi을 최적으로 사용하기 위해서, php.ini file 안에 fastcgi.logging 값을 0으로 설정하세요.',
	'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> '지원되지 않는 PHP버전이 설치되었습니다:(ver',
	'LBL_DB_UNAVAILABLE'                => '데이터베이스를 사용할 수 없음',
	'LBL_CHECKSYS_DB_SUPPORT_NOT_AVAILABLE' => '데이터베이스 지원을 찾을 수 없습니다. MySQL 또는 MS SQLServer에서 필요한 드라이브를 찾으세요. 당신의 PHP버전에 기반하여,  php.ini file의 확장을 언급할 필요가 없고 확실한 2진법의 파일도 다시 컵파일하면 됩니다. 더 많은 정보를 얻으려면 PHP 매뉴얼을 참조해주세요.',
	'LBL_CHECKSYS_XML_NOT_AVAILABLE'        => 'SuiteCRM 응용프로그램에 필요한  XML Parser Libraries에 연관된 기능들을 찾을 수 없습니다.  당신의 PHP버전에 기반하여,  php.ini file의 확장을 언급할 필요가 없고 확실한 2진법의 파일도 다시 컵파일하면 됩니다. 더 많은 정보를 얻으려면 PHP 매뉴얼을 참조해주세요.',
	'ERR_CHECKSYS_MBSTRING'             => 'SuiteCRM에 필요한 Multibyte Strings PHP확장(mbstring) 에 연관된 기능을 발견하지 못했습니다. 일반적으로 mbstring 모듈은 PHP에 피폴트가 불가능하고 PHP 바이너리가 빌드될 때 mbstring을 활성화할 수 있습니다. mbstring 지원을 실행하는 방법에 대해 더 많은 정보를 얻으려면 PHP 매뉴얼을 확인해보세요.',
	'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_SET'       => 'Php설정파일(php.ini)의 session.save_path가 설정되지 않거나 존재하지 않는 폴더로 설정되었습니다. php.ini의 save_path을 설정이 필요합니다. 그리고 save_path exist에서 폴더 세팅을 명시해야 합니다.',
	'ERR_CHECKSYS_SESSION_SAVE_PATH_NOT_WRITABLE'  => 'Php 설정 파일에서  session.save_path이 쓸수 없게 하는 폴더를 설정할 수 있습니다. 쓰기 가능한 폴더를 만드려면 필요한 단계를 밟아야 합니다. 작동 시스템에 의거하여, chmod 766을 실행하는 권한을 변경할 수 있습니다.  오른쪽 파일 이름을 누르고,  읽기 전용옵션을 해제할 수 있습니다.',
	'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'  => 'Config 파일이 존재하지만 쓸 수 없습니다. 파일을 쓰려면 필요한 단계를 밟아야 합니다. 작동 시스템에 의거하여, chmod 766을 실행하는 권한을 변경할 수 있습니다.  오른쪽 파일 이름을 누르고,  읽기 전용옵션을 해제할 수 있습니다.',
	'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'  => 'Config override 파일이 존재하지만 쓸 수 없습니다. 쓰기 위해서는 필요한 단계를 밟아야 합니다. 작동 시스템에 의거하여, chmod 766을 실행하는 권한을 변경할 수 있습니다.  오른쪽 파일 이름을 누르고,  읽기 전용옵션을 해제할 수 있습니다.',
	'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'  => '사용자 지정 디렉토리가 존재하지만 쓸 수 없습니다. chmod 766의 허가를 변경하여 오른쪽을 클릭한 후 읽기전용 옵션을 해제해주세요. 작동시스템에 의거하여, 쓰기가능한 파일을 만드려면 필요한 단계를 밟으세요.',
	'ERR_CHECKSYS_FILES_NOT_WRITABLE'   => "아래 리스트에 있는 파일이나 디렉토리가 쓸수 없거나 누락되거나 만들어지지 않았습니다. 작동시스템에 의거하여, 파일이나 부모디렉토리(chmod 755) 의 허가를 변경할 수 있습니다. 부모디렉토리의 오른쪽 버튼을 눌러 읽기전용 옵션을 해제하고 모든 하위 폴더에 적용시켜주세요.",
	'LBL_CHECKSYS_OVERRIDE_CONFIG' => '구성 오버라이드',
	//'ERR_CHECKSYS_SAFE_MODE'			=> 'Safe Mode is On (please disable in php.ini)',
	'ERR_CHECKSYS_SAFE_MODE'			=> '안전모드가 켜있습니다.(php,ini에서 해제할 수 있습니다.)',
	'ERR_CHECKSYS_ZLIB'					=> 'ZLib 지원을 찾을 수 없습니다. SuiteCRM은 zlib압축과 함께 엄청난 이익을 가져올 것입니다.',
	'ERR_CHECKSYS_ZIP'					=> 'ZIP 지원 찾을 수 없습니다: SuiteCRM은 압축된 파일을 처리 하려면 ZIP 지원 필요합니다.',
	'ERR_CHECKSYS_PCRE'					=> 'PCRE 라이브러리를 찾을 수 없습니다: SuiteCRM은 패턴매치의 정규 표현의 스타일을 진행하려면 PCRE library가 필요합니다.',
	'ERR_CHECKSYS_PCRE_VER'				=> 'PCRE 라이브러리 버전: SuiteCRM은 패턴매치의 정규 표현의 펄 스타일을 진행하려면 PCRE 라이브러리 7.0 이상이 필요합니다.',
	'ERR_DB_ADMIN'						=> '제공된 데이터베이스 관리자 아이디, 패스워드가 잘못되었습니다. 정확한 아이디와 비밀번호를 눌러주세요.(Error: ',
	'ERR_DB_ADMIN_MSSQL'                => '제공된 데이터베이스 관리자 아이디, 비밀번호가 유효하지 않습니다. 정확한 아이디와 비밀번호를 입력해주세요.',
	'ERR_DB_EXISTS_NOT'					=> '지정된 데이터베이스가 존재하지 않습니다.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> '구성 데이터가 있는 데이터베이스가 이미 존재합니다. 선택한 데이터베이스로 설치를 실행하시려면, 설치를 다시 실행하시고 "기존의 SuiteCRM 테이블을 드롭하고 재생성합니까?" 를 선택해 주십시오. 업그레이드를 하려면, 관리 콘솔의 업그레이드 마법사를 사용하십시오. <a href="http://www.suitecrm.com" target="_new">여기</a> 에 있는 업그레이드 문서를 참조하십시오.',
	'ERR_DB_EXISTS'						=> '제공된 데이터베이스 이름이 이미 존재합니다. 같은 이름을 사용할 수 없습니다.',
	'ERR_DB_EXISTS_PROCEED'             => '제공된 데이터베이스 이름이 이미 존재합니다. 뒤로가기 버튼을 누르고 새로운 데이터베이스 이름을 선택하세요. 다음 버튼과 계속 버튼을 눌러주세요. 다음과 계속버튼을 누르면 데이터베이스에 있는 모든 테이블이 삭제됩니다.',
	'ERR_DB_HOSTNAME'					=> '호스트 이름은 빈칸이 있으면 안됩니다.',
	'ERR_DB_INVALID'					=> '잘못된 데이터베이스입니다.',
	'ERR_DB_LOGIN_FAILURE'				=> '제공된 데이터베이스 호스트, 아이디, 비밀번호는 잘못되었습니다. 그리고 정확한 호스트, 아이디, 비밀번호를 눌러주세요.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> '제공된 데이터베이스 호스트, 아이디, 비밀번호는 잘못되었습니다. 정확한 호스트, 아이디, 비밀번호를 눌러주세요.',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> '제공된 데이터베이스 호스트, 아이디, 비밀번호는 잘못되었습니다. 정확한 호스트, 아이디, 비밀번호를 눌러주세요.',
	'ERR_DB_MYSQL_VERSION'				=> 'MySQL 버전(%s) 이 SuiteCRM에 지원되지 않습니다.  SuiteCRM에 맞는 버전을 설치해주세요. MySQL에 맞는 릴리즈정보에 호환성 매트릭스를 참조하세요.',
	'ERR_DB_NAME'						=> '데이터베이스 아이디는 빈칸이 있으면 안됩니다.',
	'ERR_DB_NAME2'						=> "데이터베이트 아이디는 '\\', '/', or '.'를 사용할 수 없습니다.",
	'ERR_DB_MYSQL_DB_NAME_INVALID'      => "데이터베이스 아이디는 '\\', '/', or '.'를 사용할 수 없습니다.",
	'ERR_DB_MSSQL_DB_NAME_INVALID'      => "데이터베이스 아이디는 숫자,'#', or '@'로 시작할 수 없고, 빈칸, '\"', \"'\", '*', '/', '\\', '?', ':', '<', '>', '&', '!', or '-'를 포함할 수 없습니다.",
	'ERR_DB_OCI8_DB_NAME_INVALID'       => "아이디는 오직 글자, 숫자, '#', '_' or '$'로 만들어야 합니다.",
	'ERR_DB_PASSWORD'					=> '비밀번호가 맞지 않습니다. 알맞은 비밀번호를 눌러주세요.',
	'ERR_DB_PRIV_USER'					=> '데이터베이스 사용자 아이드를 제공합니다.  데이터베이스에 처음 접속할때 필요합니다.',
	'ERR_DB_USER_EXISTS'				=> 'SuiteCRM 에 맞는 아이디가 이미 존재합니다. 새로운 아이디를 입력하세요.',
	'ERR_DB_USER'						=> 'SuiteCRM 데이터베이스 관리자 아이디를 입력하세요.',
	'ERR_DBCONF_VALIDATION'				=> '진행하기 전에 다음의 에러들을 수정해주세요',
	'ERR_DBCONF_PASSWORD_MISMATCH'      => 'SuiteCRM 비밀번호가 틀립니다. 알맞은 비밀번호를 눌러주세요.',
	'ERR_ERROR_GENERAL'					=> '오류가 발생했습니다.',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> '삭제할 수 없는 파일: ',
	'ERR_LANG_MISSING_FILE'				=> '파일을 찾을 수 없습니다: ',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'Include/language 안에 언어 팩이 없습니다: ',
	'ERR_LANG_UPLOAD_1'					=> '업로드에 문제가 있었습니다.  다시 시도 하십시오.',
	'ERR_LANG_UPLOAD_2'					=> '언어 팩에는 ZIP 보관 파일 이어야합니다.',
	'ERR_LANG_UPLOAD_3'					=> '임시 파일을 PHP 업그레이드 디렉토리에 이동 할 수 없습니다',
	'ERR_LICENSE_MISSING'				=> '필수 항목 누락',
	'ERR_LICENSE_NOT_FOUND'				=> '라이센스 파일을 찾을 수 없습니다!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> '제공된 로그 디렉토리가 유요한 디렉토리가 아닙니다.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> '제공된 로그 디렉토리가 쓸 수 있는 디렉토리가 아닙니다.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> '당신의 것으로 명시하려면 로그 디렉토리가 필요합니다.',
	'ERR_NO_DIRECT_SCRIPT'				=> '직접 스크립트를 처리할 수 없습니다.',
	'ERR_NO_SINGLE_QUOTE'				=> '작은 따옴표를 사용할 수 없습니다',
	'ERR_PASSWORD_MISMATCH'				=> 'SuiteCRM 관리자 비밀번호가 틀립니다. 비밀번호 필드에서 같은 비밀번호를 재입력해주세요.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'Config.php파일을 읽을 수 없습니다.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Config.php파일을 수동적으로 설치 및  config.php 파일  아래에 구성정보를 붙여넣기하여 설치를 할 수 있습니다. 그러나 다음 단계를 진행하기 전에 config,php파일을 만들어야 합니다.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> 'Config.php file 생성을 기억하십니까?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> '경고: config.php을 읽을 수 없습니다. 존재하는지 확인해주세요.',
	'ERR_PERFORM_HTACCESS_1'			=> '쓸 수 없습니다. ',
	'ERR_PERFORM_HTACCESS_2'			=> ' 파일.',
	'ERR_PERFORM_HTACCESS_3'			=> '브라우저를 통해 접근할 수 있는 로그파일을 보안하려면 .htaccess 파일을 고르 디렉토리에 만들어야 합니다.',
	'ERR_PERFORM_NO_TCPIP'				=> '인터넷 접속을 탐지하지 못했습니다. 연결할때 http://www.suitecrm.com를 방문하여 SuiteCRM를 등록해주세요. 귀하의 회사가 어떻게 SuiteCRM를 사용하는지 알면, 우리는 언제나 귀하의 회사가 원하는 어플리케이션이 될 수 있게 제공하겠습니다.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> '제공된 세션디렉토리는 유효한 디렉토리가 아닙니다.',
	'ERR_SESSION_DIRECTORY'				=> '제공된 세션디렉토리는 쓸수 있는 디렉토리가 아닙니다.',
	'ERR_SESSION_PATH'					=> '당신의 것을 명시하려면 세션 경로가 필요합니다.',
	'ERR_SI_NO_CONFIG'					=> '문서 루트에 config_si.php를 포함하지 않았거나, config.php안에 $sugar_config_si를 정의하지 않았습니다.',
	'ERR_SITE_GUID'						=> '당신의 것을 명시하려면 어플리케이션 아이디가 필요합니다.',
	'ERROR_SPRITE_SUPPORT'              => "현재 GD라이브러리를 찾을 수 없어서, CSS Sprite 기능을 사용할 수 없습니다.",
	'ERR_UPLOAD_MAX_FILESIZE'			=> '경고: PHP 방식이 적어도 6MB의 파일을 업로드할 수 있게 변경되어야 합니다.',
	'LBL_UPLOAD_MAX_FILESIZE_TITLE'     => '업로드 파일 크기',
	'ERR_URL_BLANK'						=> 'SuiteCRM에 대한 기본 URL을 제공합니다.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'Could not locate installation record of',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'The uploaded file is not compatible with this flavor of SuiteCRM: ',
	'ERROR_LICENSE_EXPIRED'				=> "오류: 라이센스가 만료되었습니다. ",
	'ERROR_LICENSE_EXPIRED2'			=> " ~일 전입니다. 새로운 라이센스 키를 입력하는 관리자 화면에서 \"라이센스 관리\"에 들어가세요. 30일안에 새로운 라이센스 키를 입력하지 않으면 이 어플리케이션을 더이상 사용할 수 없습니다.",
	'ERROR_MANIFEST_TYPE'				=> '매니페스트 파일은 반드시 패키지 형식을 명시해야 합니다.',
	'ERROR_PACKAGE_TYPE'				=> '매니페스트 파일이 지정되지 않은 패키지 유형으로 명시합니다.',
	'ERROR_VALIDATION_EXPIRED'			=> "오류: 유효성 검사 키 만료 ",
	'ERROR_VALIDATION_EXPIRED2'			=> " ~일 전입니다. 새로운 확인 키를 입력하는 관리자 화면에서 \"라이센스 관리\"에 들어가세요. 30일안에 새로운 확인키를 입력하지 않으면 이 어플리케이션을 더이상 사용할 수 없습니다.",
	'ERROR_VERSION_INCOMPATIBLE'		=> '업로드 된 파일이 SuiteCRM의 버전과 호환 되지 않습니다. ',

	'LBL_BACK'							=> '이전',
	'LBL_CANCEL'                        => '취소 [Alt+X]',
	'LBL_ACCEPT'                        => '승인',
	'LBL_CHECKSYS_1'					=> 'SuiteCRM을 제대로 작동하려면, 아래 리스트에 있는 시스템 체크를 녹색으로 체크해야 합니다. 빨간색의 체크가 잇다면 고쳐주세요. 시스템 체크에 대한 도움말은 "http://www.suitecrm.com"에 방문해서 확인해주세요.',
	'LBL_CHECKSYS_CACHE'				=> '쓸 수 있는 캐시 하위 디렉토리',
	'LBL_DROP_DB_CONFIRM'               => '제공된 데이터베이스 이름은 이미 존재합니다. 취소버튼을 누르고 새 데이터베이스 이름을 선택하거나, 동의 버튼을 눌러 주세요. 데이터베이스에 존재하는 모든 테이블은 삭제될 것입니다. 테이블 및 기존 데이터 모두 삭제될 것입니다.',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP의 Allow Call Time Pass Reference가 Off',
	'LBL_CHECKSYS_COMPONENT'			=> '구성 요소',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> '선택적 구성 요소',
	'LBL_CHECKSYS_CONFIG'				=> '쓸 수 있는 SuiteCRM 구성 파일 (config.php)',
	'LBL_CHECKSYS_CONFIG_OVERRIDE'		=> '쓸 수 있는 SuiteCRM 구성 파일 (config_override.php)',
	'LBL_CHECKSYS_CURL'					=> 'cURL 모듈',
	'LBL_CHECKSYS_SESSION_SAVE_PATH'    => '세션 경로 설정 저장',
	'LBL_CHECKSYS_CUSTOM'				=> '쓸 수 있는 사용자 지정 디렉터리',
	'LBL_CHECKSYS_DATA'					=> '쓸 수 있는 데이터 하위 디렉토리',
	'LBL_CHECKSYS_IMAP'					=> 'IMAP 모듈',
	'LBL_CHECKSYS_FASTCGI'             => 'FastCGI',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'MB Strings Module',
	'LBL_CHECKSYS_MEM_OK'				=> '확인 (제한 없음)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> '확인 (무제한)',
	'LBL_CHECKSYS_MEM'					=> 'PHP 메모리 제한',
	'LBL_CHECKSYS_MODULE'				=> '쓸 수 있는 하위 디렉터리 및 파일 모듈',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'MySQL 버전',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> '사용할 수 없음',
	'LBL_CHECKSYS_OK'					=> 'OK',
	'LBL_CHECKSYS_PHP_INI'				=> 'PHP 설정 위치 (php.ini):',
	'LBL_CHECKSYS_PHP_OK'				=> '확인(버전 ',
	'LBL_CHECKSYS_PHPVER'				=> 'PHP 버전',
	'LBL_CHECKSYS_IISVER'               => 'IIS 버전',
	'LBL_CHECKSYS_RECHECK'				=> '다시 확인',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'PHP 안전 모드 해제',
	'LBL_CHECKSYS_SESSION'				=> '쓸 수있는 세션 저장 경로(',
	'LBL_CHECKSYS_STATUS'				=> '상태',
	'LBL_CHECKSYS_TITLE'				=> '시스템 검사 승인',
	'LBL_CHECKSYS_VER'					=> '발견: (ver ',
	'LBL_CHECKSYS_XML'					=> 'XML Parsing',
	'LBL_CHECKSYS_ZLIB'					=> 'ZLIB 압축 모듈',
	'LBL_CHECKSYS_ZIP'					=> '우편 처리 모듈',
	'LBL_CHECKSYS_PCRE'					=> 'PCRE 라이브러리',
	'LBL_CHECKSYS_FIX_FILES'            => '다음과 같은 파일 또는 디렉터리를 계속 하기 전에 수정 하시기 바랍니다.',
	'LBL_CHECKSYS_FIX_MODULE_FILES'     => '진행하기 전에 모듈 디텍토리와 파일을 수정해주세요.',
	'LBL_CHECKSYS_UPLOAD'               => '쓸 수 있는 업로드 디렉토리',
	'LBL_CLOSE'							=> '종료',
	'LBL_THREE'                         => '3',
	'LBL_CONFIRM_BE_CREATED'			=> '생성됨',
	'LBL_CONFIRM_DB_TYPE'				=> '데이터베이스 유형',
	'LBL_CONFIRM_DIRECTIONS'			=> '아래의 설정을 확인해주세요. 값을 수정하려면 "뒤로" 버튼을 누르세요. 아니면 설치하기위해 "다음"을 눌러주세요.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> '라이선스 정보',
	'LBL_CONFIRM_NOT'					=> 'not',
	'LBL_CONFIRM_TITLE'					=> '설정 확인',
	'LBL_CONFIRM_WILL'					=> 'will',
	'LBL_DBCONF_CREATE_DB'				=> '데이터 베이스 생성',
	'LBL_DBCONF_CREATE_USER'			=> '유저 생성',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> '주의: 체크되었다면 모든 SuiteCRM 데이터는 삭제할 수 없습니다.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> '존재하는 SuiteCRM 테이블을 삭제하고 다시 만드시겠습니까?',
	'LBL_DBCONF_DB_DROP'                => '테이블 삭제',
	'LBL_DBCONF_DB_NAME'				=> '데이터 베이스 아이디',
	'LBL_DBCONF_DB_PASSWORD'			=> 'SuiteCRM 비밀번호',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'SuiteCRM 비밀번호를 다시 입력해주세요.',
	'LBL_DBCONF_DB_USER'				=> 'SuiteCRM 아이디',
	'LBL_DBCONF_SUGAR_DB_USER'          => 'SuiteCRM 아이디',
	'LBL_DBCONF_DB_ADMIN_USER'          => '데이터베이스 관리자 아이디',
	'LBL_DBCONF_DB_ADMIN_PASSWORD'      => '데이터베이스 관리자 비밀번호',
	'LBL_DBCONF_DEMO_DATA'				=> '데모 데이터를 사용하시겠습니까?',
	'LBL_DBCONF_DEMO_DATA_TITLE'        => '데모 데이터를 선택해 주세요.',
	'LBL_DBCONF_HOST_NAME'				=> '호스트 명',
	'LBL_DBCONF_HOST_INSTANCE'			=> '호스트 인스턴스',
	'LBL_DBCONF_HOST_PORT'				=> '포트',
	'LBL_DBCONF_INSTRUCTIONS'			=> '아래의 데이터베이스 구성정보를 입력해주세요. 모든 칸을 채우셔야 합니다.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> '데모 데이터에 멀티바이트 텍스트를 사용하시겠습니까?',
	'LBL_DBCONFIG_MSG2'                 => '데이터베이스 호스트의 이름(예: localhost 또는 www.mydomain.com) :',
	'LBL_DBCONFIG_MSG2_LABEL' => '호스트 명',
	'LBL_DBCONFIG_MSG3'                 => 'SuiteCRM 데이터를 저장 할 데이터 베이스의 이름:',
	'LBL_DBCONFIG_MSG3_LABEL' => '데이터 베이스 아이디',
	'LBL_DBCONFIG_B_MSG1'               => 'SuiteCRM의 데이터베이스를 셋업하려면, 데이터베이스 테이블과 유저의 작성 및 데이터베이스에 쓰기가 가능한 권한을 가진 관리자 유저의 유저명과 비밀번호가 필요합니다.',
	'LBL_DBCONFIG_B_MSG1_LABEL' => '',
	'LBL_DBCONFIG_SECURITY'             => '보안을 위해 SuiteCRM 데이터베이스에 연결 하는 전용 데이터베이스 사용자를 지정할 수 있습니다. 사용자는 SuiteCRM 데이터베이스에 있는 데이터를 쓰고 업데이트하고 복원할 수 있습니다. 사용자는 위에 명시된 데이터베이스관리자가 될 수 있고 새로운 또는 존재하는 데이터베이스 사용장 정보를 제공할 수 있습니다.',
	'LBL_DBCONFIG_AUTO_DD'              => '자신을 위해 하세요.',
	'LBL_DBCONFIG_PROVIDE_DD'           => '기존 사용자에게 제공합니다.',
	'LBL_DBCONFIG_CREATE_DD'            => '사용자 생성을 정의합니다.',
	'LBL_DBCONFIG_SAME_DD'              => '관리자 사용자와 동일합니다.',
	//'LBL_DBCONF_I18NFIX'              => 'Apply database column expansion for varchar and char types (up to 255) for multi-byte data?',
	'LBL_FTS'                           => '전체 텍스트 검색',
	'LBL_FTS_INSTALLED'                 => '설치됨',
	'LBL_FTS_INSTALLED_ERR1'            => '전체 텍스트 검색 기능이 설치 되지 않습니다.',
	'LBL_FTS_INSTALLED_ERR2'            => '설치할 수 있지만 전체 텍스트 검색 기능을 사용할 수 없습니다. 데이터 서버에 있는 인스톨가이드를 참조하거나 관리자에게 문의해보세요.',
	'LBL_DBCONF_PRIV_PASS'				=> '권한이 있는 데이터베이스 사용자 암호',
	'LBL_DBCONF_PRIV_USER_2'			=> '위의 데이터베이스 계정은 특정권한을 가진 사용자인가요?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> '권한이 있는 데이터베이스 사용자는 데이터베이스를 만들거나, 테이블를 삭제/만들거나, 사용자를 만들 수 있는 적절한 권한이 있습니다. 권한이 있는 데이터베이스 사용자는 설치 과정에서 필요한 작업을 수행하는 경우에만 사용됩니다. 위에 처럼 사용자가 동일한 권한을 가지고 있는다면, 당신은 또한 데이터베이스 사용자가 될 수 있습니다.',
	'LBL_DBCONF_PRIV_USER'				=> '권한이 있는 데이터베이스 사용자 이름',
	'LBL_DBCONF_TITLE'					=> '데이터베이스 구성',
	'LBL_DBCONF_TITLE_NAME'             => '데이터베이스 이름을 제공',
	'LBL_DBCONF_TITLE_USER_INFO'        => '데이터베이스 사용자 정보 제공',
	'LBL_DBCONF_TITLE_USER_INFO_LABEL' => '유저',
	'LBL_DBCONF_TITLE_PSWD_INFO_LABEL' => '패스워드:',
	'LBL_DISABLED_DESCRIPTION_2'		=> '변경이 끝나면, "시작"버튼을 눌러 아래의 설치를 시작할 수 있습니다. 설치가 끝나면 \'installer_locked\'을 \'true\'로 바꿀 수 있습니다.',
	'LBL_DISABLED_DESCRIPTION'			=> '프로그램이 이미 한번 설치되었습니다. 안전 조치로써 두번째 설치는 실행하지 않았습니다. 재설치가 확실하다면, config.php file로 가서 \'installer_locked\' 변수 값을 \'false;로 바꿔주세요.',
	'LBL_DISABLED_HELP_1'				=> '철치에 대한 도움이 피룡하면 SuiteCRM을 방문해주세요.',
	'LBL_DISABLED_HELP_LNK'             => 'http://www.suitecrm.com/forum/index',
	'LBL_DISABLED_HELP_2'				=> '지원 포럼',
	'LBL_DISABLED_TITLE_2'				=> 'SuiteCRM 설치가 비활성화 되었습니다.',
	'LBL_DISABLED_TITLE'				=> 'SuiteCRM 설치가 비활성화 되었습니다.',
	'LBL_EMAIL_CHARSET_DESC'			=> '문자 집함은 대두분 공통적으로 로케일에서 사용됩니다.',
	'LBL_EMAIL_CHARSET_TITLE'			=> '아웃바운드 이메일 설정',
	'LBL_EMAIL_CHARSET_CONF'            => '아웃바운드 이메일의 문자 설정 ',
	'LBL_HELP'							=> '도움말',
	'LBL_INSTALL'                       => '설치',
	'LBL_INSTALL_TYPE_TITLE'            => '설치 옵션',
	'LBL_INSTALL_TYPE_SUBTITLE'         => '설치 유형을 선택해 주세요.',
	'LBL_INSTALL_TYPE_TYPICAL'          => ' <b>일반적인 설치</b>',
	'LBL_INSTALL_TYPE_CUSTOM'           => ' <b>사용자 정의 설치</b>',
	'LBL_INSTALL_TYPE_MSG1'             => '키는 일반적인 어플리케이션에서 기능적으로 사용되지만 설치에 필요한 것은 아닙니다. 이번에는 키를 입력할 필요는 없지만 어플리케이션을 설치한 후에, 키를 제공할 필요가 있습니다.',
	'LBL_INSTALL_TYPE_MSG2'             => '설치하는데 최소한의 정봐만 필요합니다. 새 사용자에게 권합니다.',
	'LBL_INSTALL_TYPE_MSG3'             => '설치하는 동안 추가 옵션을 제공합니다. 대부분의 옵션들은 유용합니다. 고급사용자에게 권합니다.',
	'LBL_LANG_1'						=> '지정된 언어(영어) 가아닌  SuiteCRM에서 다른 언어를 새용하려면 언어 팩에서 설치할 수 있습니다. 마찬가지로 SuiteCRM  어플리케이션에서 언어팩을 설치하고 업로드할 수 있습니다.  이 단계를 넘어가려면 NEXT버튼을 눌러주세요.',
	'LBL_LANG_BUTTON_COMMIT'			=> '설치',
	'LBL_LANG_BUTTON_REMOVE'			=> '삭제',
	'LBL_LANG_BUTTON_UNINSTALL'			=> '제거',
	'LBL_LANG_BUTTON_UPLOAD'			=> '업로드',
	'LBL_LANG_NO_PACKS'					=> '없음',
	'LBL_LANG_PACK_INSTALLED'			=> '다음의 언어팩이 설치되었습니다. ',
	'LBL_LANG_PACK_READY'				=> '다음의 언어팩이 설치할 준비가 되었습니다. ',
	'LBL_LANG_SUCCESS'					=> '언어 팩 성공적으로 업로드 되었습니다.',
	'LBL_LANG_TITLE'			   		=> '언어 팩',
	'LBL_LAUNCHING_SILENT_INSTALL'     => '지금 SuiteCRM를 설치합니다. 몇분이 걸릴 수 있습니다.',
	'LBL_LANG_UPLOAD'					=> '언어 팩 업로드',
	'LBL_LICENSE_ACCEPTANCE'			=> '라이센스 동의',
	'LBL_LICENSE_CHECKING'              => '호환성 검사',
	'LBL_LICENSE_CHKENV_HEADER'         => '환경 검사',
	'LBL_LICENSE_CHKDB_HEADER'          => 'DB 자격 증명을 확인합니다.',
	'LBL_LICENSE_CHECK_PASSED'          => '시스템 호환성 검사를 통과 합니다.',
	'LBL_CREATE_CACHE' => '설치 준비중...',
	'LBL_LICENSE_REDIRECT'              => 'Redirecting in ',
	'LBL_LICENSE_DIRECTIONS'			=> '라이센스 정보가 있으면 아래에 입력해주세요.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> '다운로드 키를 눌러주세요.',
	'LBL_LICENSE_EXPIRY'				=> '만료일',
	'LBL_LICENSE_I_ACCEPT'				=> '승인',
	'LBL_LICENSE_NUM_USERS'				=> '유저 수',
	'LBL_LICENSE_OC_DIRECTIONS'			=> '구입한 오프 라인 고객의 번호를 입력 하십시오.',
	'LBL_LICENSE_OC_NUM'				=> '오프라인 고객 라이센스의 수',
	'LBL_LICENSE_OC'					=> '오프 라인 클라이언트 라이선스',
	'LBL_LICENSE_PRINTABLE'				=> ' 인쇄 보기 ',
	'LBL_PRINT_SUMM'                    => '요약 인쇄',
	'LBL_LICENSE_TITLE_2'				=> 'SuiteCRM 라이센스',
	'LBL_LICENSE_TITLE'					=> '라이선스 정보',
	'LBL_LICENSE_USERS'					=> '라이센스 사용자',

	'LBL_LOCALE_CURRENCY'				=> '통화 설정',
	'LBL_LOCALE_CURR_DEFAULT'			=> '기본 통화',
	'LBL_LOCALE_CURR_SYMBOL'			=> '통화 기호',
	'LBL_LOCALE_CURR_ISO'				=> '통화 코드 (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> '1000 단위 구분 기호',
	'LBL_LOCALE_CURR_DECIMAL'			=> '소수점 기호',
	'LBL_LOCALE_CURR_EXAMPLE'			=> '예제',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> '유효 자릿수',
	'LBL_LOCALE_DATEF'					=> '기본 날짜 형식',
	'LBL_LOCALE_DESC'					=> '지정된 로캘 설정은 SuiteCRM 인스턴스 내에서 세계적으로 반영 됩니다.',
	'LBL_LOCALE_EXPORT'					=> '문자 집합 가져오기/내보내기(이메일, .csv, vCard, PDF, 데이터 가져오기)',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> '내보내기 (.csv) 구분',
	'LBL_LOCALE_EXPORT_TITLE'			=> '가져오기/내보내기 설정',
	'LBL_LOCALE_LANG'					=> '기본 언어',
	'LBL_LOCALE_NAMEF'					=> '기본 이름 형식',
	'LBL_LOCALE_NAMEF_DESC'				=> 's = 인사말 f = 이름 l = 성',
	'LBL_LOCALE_NAME_FIRST'				=> '종근',
	'LBL_LOCALE_NAME_LAST'				=> '윤',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Doctor.',
	'LBL_LOCALE_TIMEF'					=> '기본 시간 형식',
	'LBL_CUSTOMIZE_LOCALE'              => '로캘 설정을 사용자 지정',
	'LBL_LOCALE_UI'						=> '사용자 인터페이스',

	'LBL_ML_ACTION'						=> '액션',
	'LBL_ML_DESCRIPTION'				=> '상세',
	'LBL_ML_INSTALLED'					=> '설치 날짜',
	'LBL_ML_NAME'						=> '이름',
	'LBL_ML_PUBLISHED'					=> '게시 날짜',
	'LBL_ML_TYPE'						=> '종류',
	'LBL_ML_UNINSTALLABLE'				=> '설치할 수 없는',
	'LBL_ML_VERSION'					=> '버전',
	'LBL_MSSQL'							=> 'SQL 서버',
	'LBL_MSSQL2'                        => 'SQL Server (FreeTDS)',
	'LBL_MSSQL_SQLSRV'				    => 'SQL 서버(PHP Microsoft SQL 서버 드라이버)',
	'LBL_MYSQL'							=> 'MySQL',
	'LBL_MYSQLI'						=> 'MySQL (mysqli 확장)',
	'LBL_IBM_DB2'						=> 'IBM DB2',
	'LBL_NEXT'							=> '다음',
	'LBL_NO'							=> 'No',
	'LBL_ORACLE'						=> '오라클',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> '설정 사이트 관리자 비밀 번호',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'audit table / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'SuiteCRM 구성 파일 만들기',
	'LBL_PERFORM_CREATE_DB_1'			=> '데이터베이스 만들기 ',
	'LBL_PERFORM_CREATE_DB_2'			=> ' on ',
	'LBL_PERFORM_CREATE_DB_USER'		=> '데이터베이스 사용자 이름과 비밀번호를 만드는 중...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> '기본 SuiteCRM 데이터 만들기',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> '로컬호스트에 필요한 데이터 베이스 이름과 비밀번호를 만드는 중...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'SuiteCRM 관계 테이블 만들기',
	'LBL_PERFORM_CREATING'				=> '만들기 / ',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> '기본 보고서 만들기',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> '기본 스케줄러 작업 만들기',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> '기본 설정 삽입',
	'LBL_PERFORM_DEFAULT_USERS'			=> '기본 사용자 만들기',
	'LBL_PERFORM_DEMO_DATA'				=> '데모 데이터로 데이터베이스 테이블 채우기(잠시 동안 걸릴 수 있습니다)',
	'LBL_PERFORM_DONE'					=> '완료',
	'LBL_PERFORM_DROPPING'				=> '삭제 ',
	'LBL_PERFORM_FINISH'				=> '종료',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> '라이센스 정보 업데이트',
	'LBL_PERFORM_OUTRO_1'				=> 'SuiteCRM의 설치 ',
	'LBL_PERFORM_OUTRO_2'				=> ' 이제 완료 되었습니다!',
	'LBL_PERFORM_OUTRO_3'				=> '총 시간: ',
	'LBL_PERFORM_OUTRO_4'				=> ' 초.',
	'LBL_PERFORM_OUTRO_5'				=> '대략적인 메모리 사용: ',
	'LBL_PERFORM_OUTRO_6'				=> ' 바이트.',
	'LBL_PERFORM_OUTRO_7'				=> '시스템이 지금 설치되었고 사용하실 수있습니다.',
	'LBL_PERFORM_REL_META'				=> '관계 메타... ',
	'LBL_PERFORM_SUCCESS'				=> '성공!',
	'LBL_PERFORM_TABLES'				=> 'SuiteCRM 어플리케이션 데이블, 감사 테이블, 관레 메타데이터 만들기',
	'LBL_PERFORM_TITLE'					=> '설치 수행',
	'LBL_PRINT'							=> '프린트',
	'LBL_REG_CONF_1'					=> '제품 발표, 교육 뉴스, 특별 행사, 특별이벤트 초청에 필요한 간단한 양식을 작성해 주세요. 우리는 팔거나 빌리거나 공유하거나 제 3자에게 정보를 제공하지 않습니다.',
	'LBL_REG_CONF_2'					=> '당신의 이름과 이메일 주소는 등록할 때에만 사용됩니다. 다른 모든 필드는 선택사항이지만 유용합니다. 우리는 제공받은 정보를 팔거나 빌려주거나 공유하거나 제 3자에게 배포하지 않습니다.',
	'LBL_REG_CONF_3'					=> '등록해주셔서 감사합니다. SuiteCRM를 시작하려면 끝내기버튼을 눌러주세요. 2단계에서 사용자 이름 "admin\'와 비밀번호가 처음에 필요할 것입니다.',
	'LBL_REG_TITLE'						=> '등록',
	'LBL_REG_NO_THANKS'                 => '아니오, 괜찮습니다.',
	'LBL_REG_SKIP_THIS_STEP'            => '이 단계 건너뛰기',
	'LBL_REQUIRED'						=> '* 필수 필드',

	'LBL_SITECFG_ADMIN_Name'            => 'SuiteCRM 응용 프로그램 관리자 아이디',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'SuiteCRM 비밀번호를 다시 입력해주세요.',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> '주의: 이전의 설치에 사용됐던 관리자 비밀번호를 무시합니다.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'SuiteCRM 비밀번호',
	'LBL_SITECFG_APP_ID'				=> '응용 프로그램 ID',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> '섵택하면, 자동적으로 생성된 ID를 제저의 하는 어플리케이션 아이디를 제공 할 수 있습니다. ID는 확실히 SuiteCRM 인스턴스의 세션이 다른 인스턴스에 사용되지 않았습니다. 그르 모두는 같은 어플리케이션 ID를 공유할 것입니다.',
	'LBL_SITECFG_CUSTOM_ID'				=> '당신만의 어플리케이션 ID를 제공합니다.',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> '선택하면, SuiteCRM 로그를 위한 기본 디렉토리를 무시하고 새로운 디렉토리를 지정해야 합니다. 어디에 로그파일이 있건 상관없이, 웹 브라우저를 통한 접속은 .htaccess 를 통한 것보다 제한적일 수 있습니다.',
	'LBL_SITECFG_CUSTOM_LOG'			=> '사용자 지정 로그 디렉터리를 사용',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> '선택하면, SuiteCRM 세션 정보를 저장하는 안전한 폴더를 제공해야 합니다. 공유서버에서 취약하지 않도록 세션데이터를 보호할 수 있습니다.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'SuiteCRM의 사용자 세션 디렉토리 사용',
	'LBL_SITECFG_DIRECTIONS'			=> '아래에 사이트 구성정보를 입력하세요. 필드가 확실하지 않다면, 기본 값 사용하기를 권합니다.',
	'LBL_SITECFG_FIX_ERRORS'			=> '진행하기 전에 오류를 수정해주세요.',
	'LBL_SITECFG_LOG_DIR'				=> '로그 디렉터리',
	'LBL_SITECFG_SESSION_PATH'			=> '세션 디렉토리 경로(쓸 수 있어야 함)',
	'LBL_SITECFG_SITE_SECURITY'			=> '보안 옵션 선택',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> '선택하면, 시스템은 정기적으로 어플리케이션의 업데이트 버전을 점검할 것입니다.',
	'LBL_SITECFG_SUGAR_UP'				=> '자동으로 업데이트를 체크할까요?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'SuiteCRM 업데이트 구성',
	'LBL_SITECFG_TITLE'					=> '사이트 구성',
	'LBL_SITECFG_TITLE2'                => '관리 사용자를 식별',
	'LBL_SITECFG_SECURITY_TITLE'        => '사이트 보안',
	'LBL_SITECFG_URL'					=> 'SuiteCRM 인스턴스의 URL',
	'LBL_SITECFG_USE_DEFAULTS'			=> '기본값을 사용할까요?',
	'LBL_SITECFG_ANONSTATS'             => '익명의 사용 통계를 보낼까요?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'  => '선택하면, SuiteCRM은 SuiteCRM Inc. 로 새로운 버전의 시스템을 설치할 때마다익명의 통계를 보낼 것입니다. 이 정보는 얼마다 어플리키이션이 잘 사용되는지 그리고 제품을 발전시킬수 있는 가이드를 이해하는데 도움이 될 것입니다.',
	'LBL_SITECFG_URL_MSG'               => '설치 후 SuiteCRM 인스턴스에 접속하는데 사용되는 URL을 입력하세요. URL은 SuiteCRM 어플리케이션 페이지에서 URL의 기초로 사용될 것입니다. URLs는 반드시 웹 서버, 컴퓨터 이름, 또는 IP주소를 포함해야 합니다.',
	'LBL_SITECFG_SYS_NAME_MSG'          => '시스템 이름이 입력하세요. 이 이름은 SuiteCRM을 방문할 때, 브라우저 제목에 표시될 것입니다.',
	'LBL_SITECFG_PASSWORD_MSG'          => '설치후, SuiteCRM 인스턴스에 로그인 하려면 SuiteCRM 관리자 아이디(기본 아이디 = 관리자) 를 사용해야 합니다. 관리자 비밀번호를 눌러주세요. 비밀번호는 초기 로그인 후 변경할 수 있습니다. 또한  제공하는 기본값을 사용하여, 다른 관리자이름도 입력해야 합니다.',
	'LBL_SITECFG_COLLATION_MSG'         => '시스템에 대한 데이터 정렬 (분류) 설정을 선택 합니다. 이 설정을 당신이 사용 하는 특정 언어와 테이블을 생성 합니다. 당신의 언어가 특별한 세팅을 요구하지 않으면 기본 값을 사용하세요.',
	'LBL_SPRITE_SUPPORT'                => '스프라이트 지원',
	'LBL_SYSTEM_CREDS'                  => '시스템 자격 증명',
	'LBL_SYSTEM_ENV'                    => '시스템 환경',
	'LBL_START'							=> '최초',
	'LBL_SHOW_PASS'                     => '비밀번호 보이기',
	'LBL_HIDE_PASS'                     => '암호 숨기기',
	'LBL_HIDDEN'                        => '<i>(hidden)</i>',
	'LBL_STEP1' => '2-1: 사전 설치 요구 사항',
	'LBL_STEP2' => '2-1: 구성',
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
	'LBL_STEP'							=> '단계',
	'LBL_TITLE_WELCOME'					=> 'SuiteCRM에 오신 것을 환영 합니다. ',
	'LBL_WELCOME_1'						=> '이 설치 프로그램은 SuiteCRM 데이터베이스 테이블을 만들고 시작할 때 필요한 구성변수를 설정합니다. 전체 프로세스는 약 10분이 걸릴 것입니다.',
	'LBL_WELCOME_2'						=> 'For installation documentation, please visit the <a href="http://www.suitecrm.com/" target="_blank">SuiteCRM</a>.  <BR><BR> You can also find help from the SuiteCRM Community in the <a href="http://www.suitecrm.com/" target="_blank">SuiteCRM Forums</a>.',
	//welcome page variables
	'LBL_TITLE_ARE_YOU_READY'            => '설치 준비가 되셨나요?',
	'REQUIRED_SYS_COMP' => '필수 시스템 구성 요소',
	'REQUIRED_SYS_COMP_MSG' =>
		'Before you begin, please be sure that you have the supported versions of the following system
                      components:<br>
                      <ul>
                      <li> Database/Database Management System (Examples: MariaDB, MySQL or SQL Server)</li>
                      <li> Web Server (Apache, IIS)</li>
                      </ul>
                      Consult the Compatibility Matrix in the Release Notes for
                      compatible system components for the SuiteCRM version that you are installing.<br>',
	'REQUIRED_SYS_CHK' => '초기 시스템 검사',
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
	'REQUIRED_INSTALLTYPE' => '일반 또는 사용자 지정 설치',
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
                                  For more detailed information, please consult the Installation Guide.                                ',
	'LBL_WELCOME_PLEASE_READ_BELOW' => '설치하기 전에 다음의 중요 정보를 읽어보세요. 정보는 이 시점에서 어플리케이션을 설치할 준비 여부를 결정하는데 도움을 줄 것입니다.',

	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> '<b>Choose your language</b>',
	'LBL_WELCOME_SETUP_WIZARD'			=> '설치 마법사',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'SuiteCRM에 오신 것을 환영 합니다. ',
	'LBL_WELCOME_TITLE'					=> 'SuiteCRM 설치 마법사',
	'LBL_WIZARD_TITLE'					=> 'SuiteCRM 설치 마법사: ',
	'LBL_YES'							=> 'Yes',
	'LBL_YES_MULTI'                     => '예-멀티 바이트',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> '워크플로우 작업으로 진행',
	'LBL_OOTB_REPORTS'		=> '보고서 생성 예약 업무 실행',
	'LBL_OOTB_IE'			=> '인바운드 사서함 확인',
	'LBL_OOTB_BOUNCE'		=> '야간 과정에 실행된 캠페인 이메일 실행',
	'LBL_OOTB_CAMPAIGN'		=> '캠페인 이메일 대량 송신을 야간에 실행',
	'LBL_OOTB_PRUNE'		=> '달의 첫번 째 Prune Database',
	'LBL_OOTB_TRACKER'		=> 'Tracker tables 간단히 하기',
	'LBL_OOTB_SUGARFEEDS'   => 'SuiteCRM 피드 테이블 정리',
	'LBL_OOTB_SEND_EMAIL_REMINDERS'	=> '이메일 미리 알림 실행',
	'LBL_UPDATE_TRACKER_SESSIONS' => 'Tracker_sessions table 업데이트',
	'LBL_OOTB_CLEANUP_QUEUE' => 'Jobs Queue 지우기',
	'LBL_OOTB_REMOVE_DOCUMENTS_FROM_FS' => '파일시스템의 파일 삭제',


	'LBL_PATCHES_TITLE'     => '최신 패치를 설치',
	'LBL_MODULE_TITLE'      => '언어 팩 설치',
	'LBL_PATCH_1'           => '이 단계를 생략하려면 \'다음\'을 눌러주세요.',
	'LBL_PATCH_TITLE'       => '시스템 패치',
	'LBL_PATCH_READY'       => '다음 패치가 설치할 준비가 되었습니다.',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SuiteCRM relies upon PHP sessions to store important information while connected to this web server.  Your PHP installation does not have the Session information correctly configured.
											<br><br>A common misconfiguration is that the <b>'session.save_path'</b> directive is not pointing to a valid directory.  <br>
											<br> Please correct your <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>PHP configuration</a> in the php.ini file located here below.",
	'LBL_SESSION_ERR_TITLE'				=> 'PHP 세션 구성 오류',
	'LBL_SYSTEM_NAME'=>'시스템 이름',
	'LBL_COLLATION' => '조합 설정',
	'LBL_REQUIRED_SYSTEM_NAME'=>'SuiteCRM 인스턴스에 대한 시스템 이름을 제공 합니다.',
	'LBL_PATCH_UPLOAD' => '로컬 컴퓨터에 패치 파일을 선택하세요',
	'LBL_INCOMPATIBLE_PHP_VERSION' => 'Php 버전 5 또는 그 이상이 필요합니다.',
	'LBL_MINIMUM_PHP_VERSION' => '최소 php 버전은 5.1입니다. 권장 버전은 5.2.x입니다.',
	'LBL_YOUR_PHP_VERSION' => '(현재 php 버전은 ',
	'LBL_RECOMMENDED_PHP_VERSION' =>' 권장 버전은 5.2.x입니다.)',
	'LBL_BACKWARD_COMPATIBILITY_ON' => 'Php 하위 호환성이 작동됩니다. 진행을 할 수 있도록 \'zend.ze1_compatibility_mode\'를 \'off\'로 바꿔주세요.',
	'LBL_STREAM' => 'PHP은 스트림을 사용할 수 있습니다.',

	'advanced_password_new_account_email' => array(
		'subject' => '새로운 계정 정보',
		'description' => '이 파일은 시스템 관리자가 새로운 비밀번호를 보낼 때 사용됩니다.',
		'body' => '<div><table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\" width="550" align=\\"\\&quot;\\&quot;center\\&quot;\\&quot;\\"><tbody><tr><td colspan=\\"2\\"><p>Here is your account username and temporary password:</p><p>Username : $contact_user_user_name </p><p>Password : $contact_user_user_hash </p><br><p>$config_site_url</p><br><p>After you log in using the above password, you may be required to reset the password to one of your own choice.</p>   </td>         </tr><tr><td colspan=\\"2\\"></td>         </tr> </tbody></table> </div>',
		'txt_body' =>
			'
Here is your account username and temporary password:
Username : $contact_user_user_name
Password : $contact_user_user_hash

$config_site_url

After you log in using the above password, you may be required to reset the password to one of your own choice.',
		'name' => '시스템에서 생성 된 비밀 번호 이메일',
	),
	'advanced_password_forgot_password_email' => array(
		'subject' => '비밀번호 재설정',
		'description' => "이 템플릿은 사용자 계정 비밀번호를 재설정하기 위한 사용자에게 보내는데 사용됩니다.",
		'body' => '<div><table border=\\"0\\" cellspacing=\\"0\\" cellpadding=\\"0\\" width="550" align=\\"\\&quot;\\&quot;center\\&quot;\\&quot;\\"><tbody><tr><td colspan=\\"2\\"><p>You recently requested on $contact_user_pwd_last_changed to be able to reset your account password. </p><p>Click on the link below to reset your password:</p><p> $contact_user_link_guid </p>  </td>         </tr><tr><td colspan=\\"2\\"></td>         </tr> </tbody></table> </div>',
		'txt_body' =>
			'
최근에 요청한 \'$contact_user_pwd_last_changed\' 가 계정 비밀번호를 재설정할 수 있습니다.

아래 링크를 따라 비밀번호를 재설정하세요.

$contact_user_link_guid',
		'name' => '이메일 비밀번호 분실',
	),

	// SMTP settings

	'LBL_WIZARD_SMTP_DESC' => '제공합니다. 할당 알림과 새로운 사용자 비밀번호같은 메일을 보내는 이메일 계정을 재공합니다. 사용자는 특별한 이메일 계정을 보내는 SuiteCRM으로부터 메일을 받을 수 있습니다.',
	'LBL_CHOOSE_EMAIL_PROVIDER'        => '이메일 제공 업체를 선택 합니다.',

	'LBL_SMTPTYPE_GMAIL'                    => 'Gmail',
	'LBL_SMTPTYPE_YAHOO'                    => 'Yahoo! Mail',
	'LBL_SMTPTYPE_EXCHANGE'                 => 'Microsoft Exchange',
	'LBL_SMTPTYPE_OTHER'                  => '기타:',
	'LBL_MAIL_SMTP_SETTINGS'           => 'SMTP 서버 사양',
	'LBL_MAIL_SMTPSERVER'				=> 'SMTP 서버:',
	'LBL_MAIL_SMTPPORT'					=> 'SMTP 포트:',
	'LBL_MAIL_SMTPAUTH_REQ'				=> 'SMTP 인증 사용?',
	'LBL_EMAIL_SMTP_SSL_OR_TLS'         => 'SSL 또는 TLS를 통해 SMTP 사용?',
	'LBL_GMAIL_SMTPUSER'					=> 'Gmail 이메일 주소:',
	'LBL_GMAIL_SMTPPASS'					=> 'Gmail 비밀 번호:',
	'LBL_ALLOW_DEFAULT_SELECTION'           => '사용자가 외부메일 사용을 허락',
	'LBL_ALLOW_DEFAULT_SELECTION_HELP'          => '옵션을 선택할 때, 모든 사용자는 시스템 알람과 경로를 보내는데 외부 메일 계정에 사용되는 이메일을 보내 수 있습니다. 만약 옵션이 선택되지 않으면, 외부 메일 계정정보를 제공한 후에 사용자는 외부 메일 서버를 사용할 수 있습니다.',

	'LBL_YAHOOMAIL_SMTPPASS'					=> 'Yahoo! 메일 암호:',
	'LBL_YAHOOMAIL_SMTPUSER'					=> '야후 메일 ID:',

	'LBL_EXCHANGE_SMTPPASS'					=> '비밀번호 변경:',
	'LBL_EXCHANGE_SMTPUSER'					=> '사용자 이름 변경:',
	'LBL_EXCHANGE_SMTPPORT'					=> '서버 포트 변경:',
	'LBL_EXCHANGE_SMTPSERVER'				=> '서버 변경:',


	'LBL_MAIL_SMTPUSER'					=> 'SMTP 사용자 이름:',
	'LBL_MAIL_SMTPPASS'					=> 'SMTP 비밀 번호:',

	// Branding

	'LBL_WIZARD_SYSTEM_TITLE' => '브랜딩',
	'LBL_WIZARD_SYSTEM_DESC' => '브랜드를 SuiteCRM 위해 귀사의 이름 및 로고를 제공 합니다.',
	'SYSTEM_NAME_WIZARD'=>'명칭:',
	'SYSTEM_NAME_HELP'=>'브라우저의 제목 표시줄에 표시 되는 이름입니다.',
	'NEW_LOGO'=>'로고 선택:',
	'NEW_LOGO_HELP'=>'이미지 파일 포맷은 .png 또는 .jpg로 할 수 있습니다. 최대 높이는 170px, 최대 너비는 450px입니다. 이것보다 크게 올리면 최대 사이즈에 맞게 수정될 것입니다.',
	'COMPANY_LOGO_UPLOAD_BTN' => '업로드',
	'CURRENT_LOGO'=>'현재 로고:',
	'CURRENT_LOGO_HELP'=>'이 로고는 SuiteCRM 응용 프로그램의 바닥글의 왼쪽 모서리에 표시 됩니다.',


	//Scenario selection of modules
	'LBL_WIZARD_SCENARIO_TITLE' => 'Scenario Selection',
	'LBL_WIZARD_SCENARIO_DESC' => 'This is to allow tailoring of the displayed modules based on your requirements.  Each of the modules can be enabled after install using the administration page.',
	'LBL_WIZARD_SCENARIO_EMPTY'=> 'There are no scenarios currently set in the configuration file (config.php)',



	// System Local Settings


	'LBL_LOCALE_TITLE' => '시스템 로캘 설정',
	'LBL_WIZARD_LOCALE_DESC' => 'Specify how you would like data in SuiteCRM to be displayed, based on your geographical location. The settings you provide here will be the default settings. Users will be able set their own preferences.',
	'LBL_DATE_FORMAT' => '일자표시형식:',
	'LBL_TIME_FORMAT' => '시간표시형식:',
	'LBL_TIMEZONE' => '시간대',
	'LBL_LANGUAGE'=>'언어:',
	'LBL_CURRENCY'=>'통화:',
	'LBL_CURRENCY_SYMBOL'=>'통화 기호:',
	'LBL_CURRENCY_ISO4217' => 'ISO 4217 통화 코드:',
	'LBL_NUMBER_GROUPING_SEP' => '1000 단위 구분 기호:',
	'LBL_DECIMAL_SEP' => '소수점 기호:',
	'LBL_NAME_FORMAT' => '이름 형식:',
	'UPLOAD_LOGO' => '기다려 주세요, 로고 업로드 중입니다.',
	'ERR_UPLOAD_FILETYPE' => '파일 형식 허용 되지 않습니다, jpeg 또는 png로 업로드 하시기 바랍니다.',
	'ERR_LANG_UPLOAD_UNKNOWN' => '알 수 없는 파일이 오류가 발생 했습니다.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_INI_SIZE' => '업로드된 파일이 최대 파일사이즈를 초과하였습니다.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_FORM_SIZE' => '업로드된 파일이 html 형식에 최대 사이즈를 초과했습니다.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_PARTIAL' => '경고: 부분적으로 파일이 업로드 되었습니다.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_FILE' => '어떠한 파일도 업로드되지 않았습니다.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_NO_TMP_DIR' => '임시 폴더 누락 되었습니다.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_CANT_WRITE' => '디스크에 파일을 읽지 못했습니다.',
	'ERR_UPLOAD_FILE_UPLOAD_ERR_EXTENSION' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop.',

	'LBL_INSTALL_PROCESS' => '설치...',

	'LBL_EMAIL_ADDRESS' => '이메일:',
	'ERR_ADMIN_EMAIL' => '관리자 이메일 주소 올바르지 않습니다.',
	'ERR_SITE_URL' => '사이트 URL이 필요 합니다.',

	'STAT_CONFIGURATION' => '관계 설정...',
	'STAT_CREATE_DB' => '데이터 베이스 생성',
	//'STAT_CREATE_DB_TABLE' => 'Create database... (table: %s)',
	'STAT_CREATE_DEFAULT_SETTINGS' => '기본 설정 만들기...',
	'STAT_INSTALL_FINISH' => '설치 완료...',
	'STAT_INSTALL_FINISH_LOGIN' => '설치가 끝났습니다..<a href="%s">로그인해주세요</a>',
	'LBL_LICENCE_TOOLTIP' => '먼저 라이센스를 받아 주시기 바랍니다',

	'LBL_MORE_OPTIONS_TITLE' => '더 많은 옵션',
	'LBL_START' => '최초',
	'LBL_DB_CONN_ERR' => '데이터베이스 오류'


);

?>
