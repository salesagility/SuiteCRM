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
        'Tasks', 'Spots', 'Surveys'
    ];

    public function __construct()
    {
        $this->documentifier = new JsonSerializerDocumentifier();
    }

    abstract function run();

    abstract function indexModule($module);

    abstract function indexBean($bean);

    abstract function indexBeans($module, $beans);

    abstract function removeBean($bean);

    abstract function removeBeans($bean);

    abstract function removeAllIndices();

    /**
     * Used to log actions and errors performed by the indexer.
     *
     * They are displayed to the console if `echoLogsEnabled` is `true`;
     *
     * @param $type string @ = info, * = warning, ! = error
     * @param $message string the message to log
     */
    public function log($type, $message)
    {
        if (!$this->echoLogsEnabled) return;

        switch ($type) {
            case '@':
                $type = "\033[32m$type\033[0m";
                break;
            case '*':
                $type = "\033[33m$type\033[0m";
                break;
            case '!':
                $type = "\033[31m$type\033[0m";
                break;
        }

        echo " [$type] ", $message, PHP_EOL;
    }

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
     * Returns the name of the selected documentifier.
     *
     * @return string
     */
    public function getDocumentifierName()
    {
        try {
            $reflect = new ReflectionClass($this->documentifier);
            return $reflect->getShortName();
        } catch (\ReflectionException $e) {
            return get_class($this->documentifier);
        }
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