<?php
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



if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

function unzip( $zip_archive, $zip_dir)
{
   return unzip_file($zip_archive, null, $zip_dir);
}

function unzip_file( $zip_archive, $archive_file, $zip_dir)
{
    if( !is_dir( $zip_dir ) ) {
        if (defined('SUGAR_PHPUNIT_RUNNER') || defined('SUGARCRM_INSTALL'))
        {
        	$GLOBALS['log']->fatal("Specified directory '$zip_dir' for zip file '$zip_archive' extraction does not exist.");
        	return false;
        } else {
            die( "Specified directory '$zip_dir' for zip file '$zip_archive' extraction does not exist." );
        }
    }
    
    $zip = new ZipArchive;

    $res = $zip->open(UploadFile::realpath($zip_archive)); // we need realpath here for PHP streams support

    if($res !== TRUE) {
        if (defined('SUGAR_PHPUNIT_RUNNER') || defined('SUGARCRM_INSTALL'))
        {
        	$GLOBALS['log']->fatal(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $zip_archive, $zip_dir));
            return false;
        } else {
        	die(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $zip_archive, $zip_dir));
        }

    }

    if($archive_file !== null) {
        $res = $zip->extractTo(UploadFile::realpath($zip_dir), $archive_file);
    } else {
        $res = $zip->extractTo(UploadFile::realpath($zip_dir));
    }
    
    if($res !== TRUE) {
        if (defined('SUGAR_PHPUNIT_RUNNER') || defined('SUGARCRM_INSTALL'))
        {
        	$GLOBALS['log']->fatal(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $zip_archive, $zip_dir));
            return false;
        } else {
        	die(sprintf("ZIP Error(%d): Status(%s): Arhive(%s): Directory(%s)", $res, $zip->status, $zip_archive, $zip_dir));
        }
    }
    return true;
}

function zip_dir( $zip_dir, $zip_archive )
{
    if( !is_dir( $zip_dir ) ){
        if (!defined('SUGAR_PHPUNIT_RUNNER'))
            die( "Specified directory '$zip_dir' for zip file '$zip_archive' extraction does not exist." );
        return false;
    }
    $zip = new ZipArchive();
    $zip->open(UploadFile::realpath($zip_archive), ZIPARCHIVE::CREATE|ZIPARCHIVE::OVERWRITE); // we need realpath here for PHP streams support
    $path = UploadFile::realpath($zip_dir);
    $chop = strlen($path)+1;
    $dir = new RecursiveDirectoryIterator($path);
    $it = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::SELF_FIRST);
    foreach ($it as $k => $fileinfo) {
        // Bug # 45143
        // ensure that . and .. are not zipped up, otherwise, the
        // CENT OS and others will fail when deploying module
        $fileName = $fileinfo->getFilename();
        if ($fileName == "." || $fileName == "..")
            continue;
        $localname = str_replace("\\", "/",substr($fileinfo->getPathname(), $chop)); // ensure file
        if($fileinfo->isDir()) {
            $zip->addEmptyDir($localname."/");
        } else {
            $zip->addFile($fileinfo->getPathname(), $localname);
        }
    }
}

/**
 * Zip list of files, optionally stripping prefix
 * FIXME: check what happens with streams
 * @param string $zip_file
 * @param array $file_list
 * @param string $prefix Regular expression for the prefix to strip
 */
function zip_files_list($zip_file, $file_list, $prefix = '')
{
    $archive    = new ZipArchive();
    $res = $archive->open(UploadFile::realpath($zip_file), ZipArchive::CREATE|ZipArchive::OVERWRITE); // we need realpath here for PHP streams support
    if($res !== TRUE)
    {
        $GLOBALS['log']->fatal("Unable to open zip file, check directory permissions: $zip_file");
        return FALSE;
    }
    foreach($file_list as $file) {
        if(!empty($prefix) && preg_match($prefix, $file, $matches) > 0) {
            $zipname = substr($file, strlen($matches[0]));
        } else {
            $zipname = $file;
        }
        $archive->addFile($file, $zipname);
    }
    return TRUE;
}
