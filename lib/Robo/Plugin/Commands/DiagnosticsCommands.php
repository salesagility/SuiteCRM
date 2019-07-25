<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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
namespace SuiteCRM\Robo\Plugin\Commands;

use SuiteCRM\Utility\OperatingSystem;
use SuiteCRM\Utility\Paths;

class DiagnosticsCommands extends \Robo\Tasks
{
    use \SuiteCRM\Robo\Traits\RoboTrait;

    /**
     * Print diagnostic information about SuiteCRM.
     * Useful for reporting issues.
     */
    public function diagnostics() {
        $this->io()->title('SuiteCRM Diagnostics');

        $this->io()->section('Versions');

        $versionList = [];

        $versionList["Operating System"] = $this->getOperatingSystem();
        $versionList["SuiteCRM"] = $this->getSuiteCrmVersion();
        $versionList["PHP"] = $this->getPhpVersion();
        $versionList["Composer"] = $this->getComposerVersion();
        $versionList["Apache"] = $this->getApacheVersion();
        $versionList["Database"] = $this->getDatabaseVersion();

        foreach ($versionList as $key => $value) {
            $versionListing[] = "{$key}: {$value}";
        }

        $this->io()->listing($versionListing);

        $this->io()->section('PHP/SuiteCRM Files');

        $fileList = [];

        $fileList["SuiteCRM Directory"] = $this->getSuiteCrmDirectory();
        $fileList["SuiteCRM Config"] = $this->getSuiteCrmConfig();
        $fileList["SuiteCRM Log"] = $this->getSuiteCrmLog();
        $fileList["PHP INI"] = $this->getPhpIniFile();
        $fileList["PHP Errors"] = $this->getPhpErrorsFile();
        $fileList["PHP Binary"] = $this->getPhpBinary();

        foreach ($fileList as $key => $value) {
            $fileListing[] = "{$key}: {$value}";
        }

        $this->io()->listing($fileListing);

        $this->say('Diagnostics Complete');
    }

    /**
     * Returns the current operating system.
     * @return String
     */
    protected function getOperatingSystem() {
        $os = new OperatingSystem();
        if ($os->isOsWindows()) {
            return 'Windows';
        } elseif ($os->isOsLinux()) {
            return 'Linux';
        } elseif ($os->isOsMacOSX()) {
            return 'macOS';
        } elseif ($os->isOsBSD()) {
            return 'BSD';
        } elseif ($os->isOsSolaris()) {
            return 'Solaris';
        } elseif ($os->isOsUnknown()) {
            return 'Unknown operating system';
        } else {
            return 'Unable to detect operating system';
        }
    }

    /**
     * Returns the current SuiteCRM version.
     * @return String
     */
    protected function getSuiteCrmVersion() {
        require_once('suitecrm_version.php');
        return $suitecrm_version;
    }

    /**
     * Returns the current PHP version.
     * TODO: Make sure this returns the PHP version of the CRM and not the PHP CLI version.
     * @return String
     */
    protected function getPhpVersion() {
        return phpversion();
    }

    /**
     * Returns the current Composer version.
     * @return String
     */
    protected function getComposerVersion() {
        return 'Not implemented.';
    }

    /**
     * Returns the current Apache version.
     * @return String
     */
    protected function getApacheVersion() {
        return 'Not implemented.';
    }

    /**
     * Returns the current database type and version.
     * @return String
     */
    protected function getDatabaseVersion() {
        return 'Not implemented.';
    }

    /**
     * Returns the path for the root of the SuiteCRM instance.
     * @return String
     */
    protected function getSuiteCrmDirectory() {
        return $this->getBasePath();
    }
    
    /**
     * Returns the path for the SuiteCRM config.php.
     * TODO: Is it possible to set the config file to be somewhere else?
     * @return String
     */
    protected function getSuiteCrmConfig() {
        return $this->getBasePath() . DIRECTORY_SEPARATOR . 'config.php';
    }
    
    /**
     * Returns the path for the suitecrm.log.
     * @return String
     */
    protected function getSuiteCrmLog() {
        global $sugar_config;
        if ($sugar_config['log_dir'] === '.') {
            return $this->getBasePath() . DIRECTORY_SEPARATOR . $sugar_config['log_file'];
        } else {
            return $this->getBasePath() . DIRECTORY_SEPARATOR . $sugar_config['log_dir'] . $sugar_config['log_file'];
        }
    }
    
    /**
     * Returns the path for the php.ini.
     * @return String
     */
    protected function getPhpIniFile() {
        return php_ini_loaded_file();
    }
    
    /**
     * Returns the path for the PHP errors.log.
     * @return String
     */
    protected function getPhpErrorsFile() {
        // If the directory starts with `.` it's relative to the base path.
        // Otherwise, just print whatever it returns.
        $errorDir = pathinfo(ini_get('error_log'), PATHINFO_DIRNAME);
        if (substr($errorDir, 0, strlen('.')) === '.') {
            return $this->getBasePath() . DIRECTORY_SEPARATOR . ini_get('error_log');
        } else {
            return ini_get('error_log');
        }
    }
    
    /**
     * Returns the path for the PHP binary.
     * @return String
     */
    protected function getPhpBinary() {
        return PHP_BINARY;
    }

    /**
     * Returns the absolute path of the CRM root directory.
     * @return String
     */
    protected function getBasePath() {
        $os = new OperatingSystem();
        $paths = new Paths();
        return $os->toOsPath($paths->getProjectPath());
    }
}
