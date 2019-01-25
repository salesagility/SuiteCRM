<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


// Bug 57062 ///////////////////////////////
if ((!empty($_REQUEST['spriteNamespace']) && substr_count($_REQUEST['spriteNamespace'], '..') > 0) ||
    (!empty($_REQUEST['imageName']) && substr_count($_REQUEST['imageName'], '..') > 0)) {
    die();
}
// End Bug 57062 ///////////////////////////////


// try to use the user's theme if we can figure it out
if (isset($_REQUEST['themeName']) && SugarThemeRegistry::current()->name != $_REQUEST['themeName']) {
    SugarThemeRegistry::set($_REQUEST['themeName']);
} elseif (isset($_SESSION['authenticated_user_theme'])) {
    SugarThemeRegistry::set($_SESSION['authenticated_user_theme']);
}

while (substr_count($_REQUEST['imageName'], '..') > 0) {
    $_REQUEST['imageName'] = str_replace('..', '.', $_REQUEST['imageName']);
}

if (isset($_REQUEST['spriteNamespace'])) {
    $filename = "cache/sprites/{$_REQUEST['spriteNamespace']}/{$_REQUEST['imageName']}";
    if (! file_exists($filename)) {
        header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
        die;
    }
} else {
    $filename = SugarThemeRegistry::current()->getImageURL($_REQUEST['imageName']);
    if (empty($filename)) {
        header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
        die;
    }
}

$filename_arr = explode('?', $filename);
$filename = $filename_arr[0];
$file_ext = substr($filename, -3);

$extensions = SugarThemeRegistry::current()->imageExtensions;
if (!in_array($file_ext, $extensions)) {
    header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
    die;
}


// try to use the content cached locally if it's the same as we have here.
if (defined('TEMPLATE_URL')) {
    $last_modified_time = time();
} else {
    $last_modified_time = filemtime($filename);
}

$etag = '"'.md5_file($filename).'"';

header("Cache-Control: private");
header("Pragma: dummy=bogus");
header("Etag: $etag");
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));

$ifmod = isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])
    ? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $last_modified_time : null;
$iftag = isset($_SERVER['HTTP_IF_NONE_MATCH'])
    ? $_SERVER['HTTP_IF_NONE_MATCH'] == $etag : null;
if (($ifmod || $iftag) && ($ifmod !== false && $iftag !== false)) {
    header($_SERVER["SERVER_PROTOCOL"].' 304 Not Modified');
    die;
}

header("Last-Modified: ".gmdate('D, d M Y H:i:s \G\M\T', $last_modified_time));

// now send the content
if (substr($filename, -3) == 'gif') {
    header("Content-Type: image/gif");
} elseif (substr($filename, -3) == 'png') {
    header("Content-Type: image/png");
}

if (!defined('TEMPLATE_URL')) {
    if (!file_exists($filename)) {
        sugar_touch($filename);
    }
}

readfile($filename);
