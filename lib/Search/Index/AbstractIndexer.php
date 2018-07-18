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
use SuiteCRM\SugarLogger\SugarLoggerMonologHandler;

/**
 * This class defines common methods and fields for a search indexer.
 *
 * A search indexer is a component with the task of creating an index to improve search efficiency.
 * This is usually achieved by creating a copy of the sql database in an external service.
 *
 * It also offers logging facilities on a separate file using Monolog, and also colored console output if configured.
 *
 * @see \SuiteCRM\Search\ElasticSearch\ElasticSearchIndexer
 */
abstract class AbstractIndexer
{
    /** @var bool when enabled only beans changed after the last indexing should be indexed */
    protected $differentialIndexingEnabled = false;
    /** @var AbstractDocumentifier determines how a bean is converted into a document */
    protected $documentifier = null;
    /** @var string[] The modules that have to be indexed. This should be made customisable */
    protected $modulesToIndex = [
        'Accounts', 'Contacts', 'Users',
        'Opportunities', 'Leads', 'Emails',
        'Calls', 'Meetings', 'Tasks',
        'Surveys', 'Cases', 'Documents',
        'Notes'
    ];
    /** @var Logger Monolog instance to log on a separate file */
    protected $logger;
    /** @var string where the log files are going to be stored */
    protected $logFile = 'search_index.log';

    public function __construct()
    {
        $this->documentifier = new JsonSerializerDocumentifier();
        $this->logger = new Logger($this->getIndexerName());

        // Set up SugarLog handler (this will forward messages to the default logging)
        $this->logger->pushHandler(new SugarLoggerMonologHandler());

        // Set up Monolog logfile logger
        try {
            $this->logger->pushHandler(new StreamHandler($this->logFile));
        } catch (\Exception $e) {
            $this->logger->error('Failed to create indexer log stream handler.');
            $this->logger->error($e);
        }

        // Set up Monolog CLI handler
        try {
            $this->logger->pushHandler(new CliLoggerHandler());
        } catch (\Exception $e) {
            $this->logger->error('Failed to create CLI logger handler.');
            $this->logger->error($e);
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
     * Method to retrieve the (short) class name of an object.
     *
     * @param $obj object
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
     * Performs the indexing procedures for the whole database.
     *
     * All modules specified in `getModulesToIndex()` must be indexed.
     * This method should adhere to the options set in the indexer, such as partial indexing.
     *
     * @see AbstractIndexer:getModulesToIndex
     * @return void
     */
    abstract function run();

    /**
     * Indexes a single module.
     *
     * If `$differentialIndexingEnabled` is set to `false` all beans in that module must be indexed.
     *
     * If `$differentialIndexingEnabled` is set to `true`, it should only perform indexing on beans
     *  that have been created/modified/deleted after the last indexing run.
     *  Additionally, beans that have been removed must be removed from the index too.
     *
     * @param $module string the name of the module, e.g. Accounts, Contacts, etc.
     * @return void
     */
    abstract function indexModule($module);

    /**
     * Indexes a single bean.
     *
     * @param $bean \SugarBean
     * @return void
     */
    abstract function indexBean(\SugarBean $bean);

    /**
     * Indexes an array of SugarBeans.
     *
     * This should not take in account of the differential indexing.
     *
     * @param $module string name of the module, e.g. Accounts, Contacts, etc.
     * @param $beans \SugarBean[]
     * @return void
     */
    abstract function indexBeans($module, array $beans);

    /**
     * Removes a bean from the index.
     *
     * @param \SugarBean $bean
     * @return void
     */
    abstract function removeBean(\SugarBean $bean);

    /**
     * Removes an array of beans from the index.
     *
     * @param array $beans
     * @return void
     */
    abstract function removeBeans(array $beans);

    /**
     * Deletes all the records from the index.
     *
     * @return void
     */
    abstract function removeIndex();

    /**
     * Returns whether the next indexing should be performed differentially or not.
     *
     * If it is set to `true`, the next indexing should only be performed on beans
     *  that have been created/modified/deleted after the last indexing run.
     *  Additionally, beans that have been removed must be removed from the index too.
     *
     * @return bool
     */
    public function isDifferentialIndexingEnabled()
    {
        return $this->differentialIndexingEnabled;
    }

    /**
     * Sets whether the next indexing should be performed differentially or not.
     *
     * @param bool $differentialIndexingEnabled
     * @see isDifferentialIndexingEnabled()
     */
    public function setDifferentialIndexingEnabled($differentialIndexingEnabled)
    {
        $this->differentialIndexingEnabled = boolval($differentialIndexingEnabled);
    }

    /**
     * Returns the currently set Documentifier.
     *
     * @return AbstractDocumentifier
     */
    public function getDocumentifier()
    {
        return $this->documentifier;
    }

    /**
     * Sets the documentifier to use for the future index runs.
     *
     * The documentifier converts a SugarBean into a index-friendly document.
     *
     * @param AbstractDocumentifier $documentifier
     */
    public function setDocumentifier(AbstractDocumentifier $documentifier)
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
     * Returns the modules that have to be indexed.
     *
     * This can be overridden in subclasses to index different modules.
     *
     * @return string[]
     */
    public function getModulesToIndex()
    {
        return $this->modulesToIndex;
    }

    /**
     * Overrides the list of modules that have to be indexed for the next indexing runs.
     *
     * @param $modules string[]
     */
    public function setModulesToIndex(array $modules)
    {
        $this->modulesToIndex = $modules;
    }

    /**
     * Adds one or more module to index for the next indexing runs.
     *
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

    /**
     * Retrieves the Monolog instance. This can be used to provide additional logging in the Indexer channel.
     *
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }
}