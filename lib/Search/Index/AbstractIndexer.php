<?php
/**
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

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 05/07/18
 * Time: 11:09
 */

namespace SuiteCRM\Search\Index;


use InvalidArgumentException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use ReflectionClass;
use SuiteCRM\Search\Index\Documentify\AbstractDocumentifier;
use SuiteCRM\Search\Index\Documentify\JsonSerializerDocumentifier;

abstract class AbstractIndexer
{
    /** @var bool */
    protected $echoLogsEnabled = false;
    /** @var bool */
    protected $differentialIndexingEnabled = false;
    /** @var AbstractDocumentifier * */
    protected $documentifier = null;
    /** @var string[] */
    protected $modulesToIndex = [
        'Accounts', 'Contacts', 'Users', 'Opportunities',
        'Leads', 'Emails', 'Calls', 'Meetings',
        'Tasks', 'Spots', 'Surveys',
        'Cases', 'Documents', 'Notes'
    ];
    /** @var Logger Monolog instance to log on a separate file */
    protected $logger;
    /** @var string where the log files are going to be stored */
    protected $logFile = 'search_index.log';

    public function __construct()
    {
        $this->documentifier = new JsonSerializerDocumentifier();
        $this->logger = new Logger($this->getIndexerName());

        try {
            $this->logger->pushHandler(new StreamHandler($this->logFile));
        } catch (\Exception $e) {
            $GLOBALS['log']->error('Failed to create indexer log stream handler.');
            $GLOBALS['log']->error($e);
        }
    }

    /**
     * Returns the short name (class name, without namespace) of the current Indexer.
     *
     * @return string
     */
    public function getIndexerName()
    {
        return $this->getObjectClassName($this);
    }

    /**
     * @param $obj
     * @return string
     */
    private function getObjectClassName($obj)
    {
        try {
            $reflect = new ReflectionClass($obj);
            return $reflect->getShortName();
        } catch (\ReflectionException $e) {
            return get_class($obj);
        }
    }

    /**
     * Used to log actions and errors performed by the indexer.
     *
     * They are displayed to the console if `echoLogsEnabled` is `true`;
     *
     * It will also attempt to save the output on a separate log file.
     *
     * @param $type string @ = debug, - = info, * = warning, ! = error
     * @param $message string the message to log
     */
    public function log($type, $message)
    {
        $level = Logger::DEBUG;

        switch ($type) {
            case '@':
                $type = "\033[32m$type\033[0m";
                break;
            case '-':
                $type = "\033[92m$type\033[0m";
                $level = Logger::INFO;
                break;
            case '*':
                $type = "\033[33m$type\033[0m";
                $level = Logger::WARNING;
                break;
            case '!':
                $type = "\033[31m$type\033[0m";
                $level = Logger::ERROR;
                break;
        }

        try {
            $this->logger->log($level, $message);
        } catch (\Exception $e) {
            $GLOBALS['log']->error('Failed to log indexer info with Monolog.');
            $GLOBALS['log']->error($e);
        }

        if ($this->echoLogsEnabled)
            echo " [$type] ", $message, PHP_EOL;
    }

    abstract function run();

    abstract function indexModule($module);

    abstract function indexBean($bean);

    abstract function indexBeans($module, $beans);

    abstract function removeBean($bean);

    abstract function removeBeans($bean);

    abstract function removeIndex();

    /**
     * @return bool
     */
    public function isEchoLogsEnabled()
    {
        return $this->echoLogsEnabled;
    }

    /**
     * @param bool $echoLogsEnabled
     */
    public function setEchoLogsEnabled($echoLogsEnabled)
    {
        $this->echoLogsEnabled = boolval($echoLogsEnabled);
    }

    /**
     * @return bool
     */
    public function isDifferentialIndexingEnabled()
    {
        return $this->differentialIndexingEnabled;
    }

    /**
     * @param bool $differentialIndexingEnabled
     */
    public function setDifferentialIndexingEnabled($differentialIndexingEnabled)
    {
        $this->differentialIndexingEnabled = boolval($differentialIndexingEnabled);
    }

    /**
     * @return AbstractDocumentifier
     */
    public function getDocumentifier()
    {
        return $this->documentifier;
    }

    /**
     * @param AbstractDocumentifier $documentifier
     */
    public function setDocumentifier($documentifier)
    {
        $this->documentifier = $documentifier;
    }

    /**
     * Returns the short (not fully qualified) name of the selected documentifier, i.e. the class name.
     *
     * @return string
     */
    public function getDocumentifierName()
    {
        return $this->getObjectClassName($this->documentifier);
    }

    /**
     * @return string[]
     */
    public function getModulesToIndex()
    {
        return $this->modulesToIndex;
    }

    /**
     * @param $modules string[]
     */
    public function setModulesToIndex($modules)
    {
        $this->modulesToIndex = $modules;
    }

    /**
     * @param $modules string|string[]
     */
    public function addModulesToIndex($modules)
    {
        if (is_array($modules)) {
            $this->modulesToIndex = array_merge($this->modulesToIndex, $modules);
        } elseif (is_string($modules)) {
            $this->modulesToIndex[] = $modules;
        } else {
            throw new InvalidArgumentException("Wrong type provided to AddModulesToIndex");
        }
    }
}