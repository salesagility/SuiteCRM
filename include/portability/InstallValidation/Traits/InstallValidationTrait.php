<?php

/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */


trait InstallValidationTrait
{
    public function noInstallScript(): bool
    {
        global $install_script;

        return empty($install_script);
    }

    public function fastCgi(): bool
    {
        return !(PHP_SAPI !== 'cgi-fcgi');
    }

    /**
     * @return bool
     */
    public function fastCgiLogging(): bool
    {
        return !(ini_get('fastcgi.logging') === '0');
    }

    public function iisVersion(): void
    {
        $server_software = $_SERVER["SERVER_SOFTWARE"] ?? '';
        if (strpos($server_software, 'Microsoft-IIS') !== false && preg_match_all("/^.*\/(\d+\.?\d*)$/",
                $server_software, $out)) {
            $iis_version = $out[1][0];

            $value = $iis_version;
            $status = 'success';

            if (check_iis_version() === -1) {
                $status = 'error';
            }

            $this->setData($status, $value);
        }
    }

    public function phpVersion()
    {
        $value = constant('PHP_VERSION');
        $status = 'success';

        if (check_php_version() === -1) {
            $status = 'error';
        }

        $this->setData($status, $value);
    }

    public function PCREVersion()
    {
        $value = constant('PCRE_VERSION');
        $status = 'success';

        if (!defined('PCRE_VERSION') || version_compare(PCRE_VERSION, '7.0') < 0) {
            $status = 'error';
        }
        $this->setData($status, $value);
    }

    public function functionExists()
    {
        $value = '';
        $status = 'success';
        if (!function_exists($this->name)) {
            $status = 'error';
        }
        $this->setData($status, $value);
    }

    public function classExists()
    {
        $value = '';
        $status = 'success';
        if (!class_exists($this->name)) {
            $status = 'error';
        }
        $this->setData($status, $value);
    }

    public function writableFile($file)
    {
        return !file_exists($file) || is_writable($file) || make_writable($file);
    }

    public function IsWritableConfig()
    {
        $value = '';
        $status = 'success';
        if (!$this->writableFile(getcwd() . '/config.php')) {
            $status = 'error';
        }
        $this->setData($status, $value);
    }

    public function IsWritableConfigOverride()
    {
        $value = '';
        $status = 'success';
        if (!$this->writableFile(getcwd() . '/config_override.php')) {
            $status = 'error';
        }
        $this->setData($status, $value);
    }

    public function IsWritableCustomDir()
    {
        $value = '';
        $status = 'success';
        if (!$this->writableDir('./custom')) {
            $status = 'error';
        }
        $this->setData($status, $value);
    }

    public function IsWritableUploadDir()
    {
        $value = '';
        $status = 'success';
        if (!$this->writableDir('./upload')) {
            $status = 'error';
        }
        $this->setData($status, $value);
    }

    public function IsWritableCacheDir(): void
    {
        $value = '';

        // cache dir
        $cache_files[] = '';
        $cache_files[] = 'images';
        $cache_files[] = 'layout';
        $cache_files[] = 'pdf';
        $cache_files[] = 'xml';
        $cache_files[] = 'include/javascript';

        $data = [];
        foreach ($cache_files as $c_file) {
            $dirname = sugar_cached($c_file);
            if (!$this->writableDir($dirname)) {
                $data[] = getcwd() . "/$dirname";
            }
        }
        $status = !empty($data) ? 'error' : 'success';
        $this->setData($status, $value, $data);
    }

    public function writableDir($dirname)
    {
        $writable = false;

        // set permissions to restrictive -
        // use make_writable to change in a standard way to the required permissions

        if ((is_dir($dirname)) || @sugar_mkdir($dirname, 0755, true)) {
            $writable = make_writable($dirname);
        }

        return $writable;
    }

    public function IsWritableModDir()
    {
        $value = '';
        $data = [];

        $_SESSION['unwriteable_module_files'] = array();

        recursive_make_writable('./modules');

        if (!empty($_SESSION['unwriteable_module_files']['failed'])) {
            foreach ($_SESSION['unwriteable_module_files'] as $key => $file) {
                if ($key !== '.' && $key !== 'failed') {
                    $data[] = $file;
                }
            }
        }

        $status = !empty($data) ? 'error' : 'success';
        $this->setData($status, $value, $data);
    }

    public function memoryLimit()
    {
        $memory_limit = ini_get('memory_limit');
        if (empty($memory_limit)) {
            $memory_limit = "-1";
        }
        if (!defined('SUGARCRM_MIN_MEM')) {
            define('SUGARCRM_MIN_MEM', 64 * 1024 * 1024);
        }

        if ($memory_limit == "") {
            $this->setData('success', 'LBL_CHECKSYS_MEM_OK');
        } elseif ($memory_limit == "-1") {
            $this->setData('success', 'LBL_CHECKSYS_MEM_UNLIMITED');
        } else {
            preg_match('/^\s*([0-9.]+)\s*([KMGTPE])B?\s*$/i', $memory_limit, $matches);
            $num = (float)$matches[1];
            // Don't break so that it falls through to the next case.
            switch (strtoupper($matches[2])) {
                case 'G':
                    $num = $num * 1024;
                // no break
                case 'M':
                    $num = $num * 1024;
                // no break
                case 'K':
                    $num = $num * 1024;
            }
            $memory_limit_int = (int)$num;

            if ($memory_limit_int < constant('SUGARCRM_MIN_MEM')) {
                $min_mem_in_megs = constant('SUGARCRM_MIN_MEM') / (1024 * 1024);

                $this->setData('error', $memory_limit.'/'.$min_mem_in_megs);
            } else {
                $this->setData('success', $memory_limit);
            }
        }
    }

    public function imapCheck(): void
    {
        $value = '';
        $status = 'success';
        include_once './include/Imap/ImapHandlerFactory.php';
        $imapFactory = new ImapHandlerFactory();
        $imap = $imapFactory->getImapHandler();

        if (!$imap->isAvailable()) {
            $status = 'error';
        }

        $this->setData($status, $value);
    }

    public function uploadLimit(): void
    {
        $upload_max_filesize = ini_get('upload_max_filesize');
        $upload_max_filesize_bytes = return_bytes($upload_max_filesize);
        if (!defined('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES')) {
            define('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES', 6 * 1024 * 1024);
        }
        $value = '';
        $status = 'success';
        if ($upload_max_filesize_bytes <= constant('SUGARCRM_MIN_UPLOAD_MAX_FILESIZE_BYTES')) {
            $status = 'error';
        }
        $this->setData($status, $value);
    }
}
