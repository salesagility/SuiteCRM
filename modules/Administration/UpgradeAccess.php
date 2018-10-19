<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $mod_strings;
global $sugar_config;

$ignoreCase = (substr_count(strtolower($_SERVER['SERVER_SOFTWARE']), 'apache/2') > 0) ? '(?i)' : '';
$htaccess_file = getcwd() . "/.htaccess";
$contents = '';
$basePath = parse_url($sugar_config['site_url'], PHP_URL_PATH);
if (empty($basePath)) {
    $basePath = '/';
}

$restrict_str = <<<EOQ
# BEGIN SUGARCRM RESTRICTIONS
RedirectMatch 403 {$ignoreCase}.*\.log$
RedirectMatch 403 {$ignoreCase}/+not_imported_.*\.txt
RedirectMatch 403 {$ignoreCase}/+(soap|cache|xtemplate|data|examples|include|log4php|metadata|modules)/+.*\.(php|tpl)
RedirectMatch 403 {$ignoreCase}/+emailmandelivery\.php
RedirectMatch 403 {$ignoreCase}/+upload
RedirectMatch 403 {$ignoreCase}/+cache/+diagnostic
RedirectMatch 403 {$ignoreCase}/+files\.md5\$
<IfModule mod_rewrite.c>
    Options +SymLinksIfOwnerMatch
    RewriteEngine On
    RewriteBase {$basePath}
    RewriteRule ^cache/jsLanguage/(.._..).js$ index.php?entryPoint=jslang&modulename=app_strings&lang=$1 [L,QSA]
    RewriteRule ^cache/jsLanguage/(\w*)/(.._..).js$ index.php?entryPoint=jslang&modulename=$1&lang=$2 [L,QSA]
    RewriteRule ^cache/jsLanguage/(.._..).js$ index.php?entryPoint=jslang&module=app_strings&lang=$1 [L,QSA]
    RewriteRule ^cache/jsLanguage/(\w*)/(.._..).js$ index.php?entryPoint=jslang&module=$1&lang=$2 [L,QSA]
    
    # --------- DEPRECATED --------
    RewriteRule ^api/(.*?)$ lib/API/public/index.php/$1 [L]
    RewriteRule ^api/(.*)$ - [env=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    # -----------------------------
    
    RewriteRule ^Api/access_token$ Api/index.php/access_token [L]
    RewriteRule ^Api/V8/(.*?)$ Api/index.php/V8/$1 [L]
    RewriteRule ^Api/(.*)$ - [env=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
</IfModule>
# END SUGARCRM RESTRICTIONS
EOQ;

if (file_exists($htaccess_file)) {
    $fp = fopen($htaccess_file, 'r');
    $skip = false;
    while ($line = fgets($fp)) {
        if (preg_match('/\s*#\s*BEGIN\s*SUGARCRM\s*RESTRICTIONS/i', $line)) {
            $skip = true;
        }
        if (!$skip) {
            $oldcontents .= $line;
        }
        if (preg_match('/\s*#\s*END\s*SUGARCRM\s*RESTRICTIONS/i', $line)) {
            $skip = false;
        }
    }
}
if (substr($contents, -1) != "\n") {
    $restrict_str = "\n" . $restrict_str;
}
$status = file_put_contents($htaccess_file, $contents . $restrict_str);

if (!$status) {
    echo '<p>' . $mod_strings['LBL_HT_NO_WRITE'] . "<span class=stop>{$htaccess_file}</span></p>\n";
    echo '<p>' . $mod_strings['LBL_HT_NO_WRITE_2'] . "</p>\n";
    echo "{$redirect_str}\n";
}

// new content should be prepended to the file
file_put_contents($htaccess_file, $oldcontents, FILE_APPEND);

// cn: bug 9365 - security for filesystem
$uploadDir = '';
$uploadHta = '';

if (empty($GLOBALS['sugar_config']['upload_dir'])) {
    $GLOBALS['sugar_config']['upload_dir'] = 'upload/';
}

$uploadHta = "upload://.htaccess";

$denyAll = <<<eoq
	Order Deny,Allow
	Deny from all
eoq;

if (file_exists($uploadHta) && filesize($uploadHta)) {
    // file exists, parse to make sure it is current
    if (is_writable($uploadHta)) {
        $oldHtaccess = file_get_contents($uploadHta);
        // use a different regex boundary b/c .htaccess uses the typicals
        if (strstr($oldHtaccess, $denyAll) === false) {
            $oldHtaccess .= "\n";
            $oldHtaccess .= $denyAll;
        }
        if (!file_put_contents($uploadHta, $oldHtaccess)) {
            $htaccess_failed = true;
        }
    } else {
        $htaccess_failed = true;
    }
} else {
    // no .htaccess yet, create a fill
    if (!file_put_contents($uploadHta, $denyAll)) {
        $htaccess_failed = true;
    }
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'UpgradeAccess') {
    // only display message in the repair tool and not during the upgrade process
    echo "\n" . $mod_strings['LBL_HT_DONE'] . "<br />\n";
}
