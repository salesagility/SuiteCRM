<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */
/**
 * This file adds a custom STIC Logger that extends directly from SugarLogger. 
 * Only necessary variables/functions are overriden.
 * This logger will write messages in a custom file (sinergiacrm.log) with a custom level (stic) 
 * and same SugarLogger rolling functionality.
 */

require_once('include/SugarLogger/LoggerManager.php');
require_once('include/SugarLogger/SugarLogger.php');

class SticLogger extends SugarLogger
{
    // Setting configuration for SticLogger
    protected $logfile = 'sinergiacrm';
    protected $ext = '.log';
    protected $dateFormat = '%F %T';
    protected $logSize = '1MB';
    protected $maxLogs = 10;
    protected $filesuffix = "";
    protected $date_suffix = "";
    protected $log_dir = '.';
    protected $defaultPerms = 0664;

    public function __construct()
    {
        // Initializing the Logger, same as in SugarLogger __construct
        $this->log_dir = './';
        $this->_doInitialization();
        // Setting a new log level
        LoggerManager::setLevelMapping('stic', 12);
        // Setting SticLogger class as the default logger for the "stic" level
        LoggerManager::setLogger('stic', 'SticLogger');
    }
}
