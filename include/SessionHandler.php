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

namespace SuiteCRM;

use LoggerManager;
use SessionHandlerInterface;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class SessionHandler implements SessionHandlerInterface
{
    private $savePath;

    public function __construct()
    {
        global $sugar_config;

        ini_set('session.gc_probability', 1);
        ini_set('session.gc_divisor', 100);

        $sessionDir = (empty($sugar_config['session_dir'])) ? null : $sugar_config['session_dir'];
        $this->savePath = session_save_path($sessionDir);

        session_set_save_handler($this, true);
        session_start();
    }

    /**
     * @param string $savePath
     * @param string $sessionName
     * @return bool
     */
    public function open($savePath = '', $sessionName = '')
    {
        LoggerManager::getLogger()->info('Session Open: save path: ' . $savePath . ' and session name: ' . $sessionName);

        if (!is_dir($this->savePath) && 
            !mkdir($concurrentDirectory = $this->savePath, 0777) && 
            !is_dir($concurrentDirectory)
        ) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        return true;
    }

    /**
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * @param string $identifier
     * @return string
     */
    public function read($identifier)
    {
        $validID = $this->validateID($identifier);
        if ($validID) {
            return file_get_contents("$this->savePath/sess_$validID");
        }

        return false;
    }

    /**
     * @param string $identifier
     * @param string $data
     * @return bool
     */
    public function write($identifier, $data)
    {
        $validID = $this->validateID($identifier);
        if ($validID) {
            return file_put_contents("$this->savePath/sess_$validID", $data) !== false;
        }

        return false;
    }

    /**
     * @param string $identifier
     * @return bool
     */
    public function destroy($identifier)
    {
        $validID = $this->validateID($identifier);
        if ($validID) {
            $file = "$this->savePath/sess_$validID";
            if (file_exists($file)) {
                unlink($file);
            }

            return true;
        }

        return false;
    }

    /**
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime)
    {
        foreach (glob("$this->savePath/sess_*", GLOB_NOSORT) as $file) {
            if (file_exists($file) && filemtime($file) + $maxlifetime < time()) {
                unlink($file);
            }
        }

        return true;
    }

    /**
     * @param string $identifier
     * @return bool|false|int
     */
    public function validateID($identifier)
    {
        if (is_string($identifier) && preg_match('/^[0-9a-zA-Z,-]{22,40}$/', $identifier)) {
            return $identifier;
        }

        LoggerManager::getLogger()->fatal('Invalid session ID: ' . $identifier);

        return false;
    }
}
