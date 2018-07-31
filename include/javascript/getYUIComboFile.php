<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

if (empty($_REQUEST)) die();

$yui_path = array(
    "2.9.0" => "include/javascript/yui",
	"2_9_0" => "include/javascript/yui",
	"3.3.0" => "include/javascript/yui3",
	"3_3_0" => "include/javascript/yui3"
);
$types = array(
    "js" => "application/javascript",
	"css" => "text/css",
);
$out = "";

$contentType = "";
$allpath = "";

foreach ($_REQUEST as $param => $val)
{
	//No backtracking in the path
	if (strpos($param, "..") !== false)
        continue;

	$version = explode("/", $param);
	$version = $version[0];
    if (empty($yui_path[$version])) continue;

    $path = $yui_path[$version] . substr($param, strlen($version));

	$extension = substr($path, strrpos($path, "_") + 1);

	//Only allowed file extensions
	if (empty($types[$extension]))
	   continue;

	if (empty($contentType))
    {
        $contentType = $types[$extension];
    }
	//Put together the final filepath
	$path = substr($path, 0, strrpos($path, "_")) . "." . $extension;
	$contents = '';
	if (is_file($path)) {
	   $out .= "/*" . $path . "*/\n";
	   $contents =  file_get_contents($path);
	   $out .= $contents . "\n";
	}
	$path = empty($contents) ? $path : $contents;
	$allpath .= md5($path);
}

$etag = '"'.md5($allpath).'"';

// try to use the content cached locally if it's the same as we have here.
header("Cache-Control: private");
header("Pragma: dummy=bogus");
header("Etag: $etag");
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
header("Content-Type: $contentType");
echo ($out);