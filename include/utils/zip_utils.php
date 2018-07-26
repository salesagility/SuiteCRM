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

if (!class_exists("ZipArchive")) {
    require_once('include/pclzip/pclzip.lib.php');
    if (isset($GLOBALS['log']) && class_implements($GLOBALS['log'], 'LoggerTemplate')) {
        $GLOBALS['log']->deprecated('Use of PCLZip has been deprecated. Please enable the zip extension in your PHP install ( see http://www.php.net/manual/en/zip.installation.php for more details ).');
    }
    function unzip($zip_archive, $zip_dir, $forceOverwrite = false)
    {
        if (!is_dir($zip_dir)) {
            if (!defined('SUITE_PHPUNIT_RUNNER')) {
                die("Specified directory '$zip_dir' for zip file '$zip_archive' extraction does not exist.");
            }
            return false;
        }

        $archive = new PclZip($zip_archive);

        if ($forceOverwrite) {
            if ($archive->extract(PCLZIP_OPT_PATH, $zip_dir, PCLZIP_OPT_REPLACE_NEWER) == 0) {
                if (!defined('SUITE_PHPUNIT_RUNNER')) {
                    die("Error: " . $archive->errorInfo(true));
                }
                return false;
            }
        } else {
            if ($archive->extract(PCLZIP_OPT_PATH, $zip_dir) == 0) {
                if (!defined('SUITE_PHPUNIT_RUNNER')) {
                    die("Error: " . $archive->errorInfo(true));
                }
                return false;
            }
        }
    }

    function unzip_file($zip_archive, $archive_file, $to_dir, $forceOverwrite = false)
    {
        if (!is_dir($to_dir)) {
            if (!defined('SUITE_PHPUNIT_RUNNER')) {
                die("Specified directory '$to_dir' for zip file '$zip_archive' extraction does not exist.");
            }

            return false;
        }

        $archive = new PclZip($zip_archive);
        if ($forceOverwrite) {
            if ($archive->extract(
                    PCLZIP_OPT_BY_NAME,
                    $archive_file,
                    PCLZIP_OPT_PATH,
                    $to_dir,
                    PCLZIP_OPT_REPLACE_NEWER
                ) == 0
            ) {
                if (!defined('SUITE_PHPUNIT_RUNNER')) {
                    die("Error: " . $archive->errorInfo(true));
                }

                return false;
            }
        } else {
            if ($archive->extract(
                    PCLZIP_OPT_BY_NAME,
                    $archive_file,
                    PCLZIP_OPT_PATH,
                    $to_dir
                ) == 0
            ) {
                if (!defined('SUITE_PHPUNIT_RUNNER')) {
                    die("Error: " . $archive->errorInfo(true));
                }

                return false;
            }
        }
    }

    function zip_dir($zip_dir, $zip_archive)
    {
        $archive = new PclZip($zip_archive);
        $v_list = $archive->create($zip_dir);
        if ($v_list == 0) {
            if (!defined('SUITE_PHPUNIT_RUNNER')) {
                die("Error: " . $archive->errorInfo(true));
            }
            return false;
        }
    }

    /**
     * Zip list of files, optionally stripping prefix
     * @param string $zip_file
     * @param array $file_list
     * @param string $prefix Regular expression for the prefix to strip
     * @return bool
     */
    function zip_files_list($zip_file, $file_list, $prefix = '')
    {
        $archive = new PclZip($zip_file);
        foreach ($file_list as $file) {
            if (!empty($prefix) && preg_match($prefix, $file, $matches) > 0) {
                $remove_path = $matches[0];
                $archive->add($file, PCLZIP_OPT_REMOVE_PATH, $prefix);
            } else {
                $archive->add($file);
            }
        }
        return true;
    }
} else {
    require_once('include/utils/php_zip_utils.php');
}
