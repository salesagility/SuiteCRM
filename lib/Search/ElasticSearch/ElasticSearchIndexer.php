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
 * Date: 22/06/18
 * Time: 12:33
 */

namespace SuiteCRM\Search\ElasticSearch;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use BeanFactory;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Elasticsearch\Client;
use JsonSchema\Exception\RuntimeException;
use Monolog\Logger;
use SugarBean;
use SuiteCRM\Search\Index\AbstractIndexer;
use SuiteCRM\Search\Index\Documentify\AbstractDocumentifier;

class ElasticSearchIndexer extends AbstractIndexer
{
    /** @var string File containing a timestamp of the last (complete or differential) indexing. */
    const LOCK_FILE = 'cache/ElasticSearchIndex.lock';
    /** @var string The name of the Elasticsearch index to use. */
    private $index = 'main';
    /** @var Client */
    private $client = null;
    /** @var int the size of the batch to be sent to the Elasticsearch while batch indexing */
    private $batchSize = 1000;

    // stats
    /** @var int number of modules indexed */
    private $indexedModulesCount;
    /** @var int number of records (beans) indexed */
    private $indexedRecordsCount;
    /** @var int number of record fields indexed */
    private $indexedFieldsCount;
    /** @var int number of records (beans) removed */
    private $removedRecordsCount;
    /** @var Carbon|false the timestamp of the last indexing. false if unknown */
    private $lastRunTimestamp = false;

    /**
     * ElasticSearchIndexer constructor.
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        parent::__construct();

        $this->client = !empty($client) ? $client : ElasticSearchClientBuilder::getClient();
    }

    /** @inheritdoc */
    public function run()
    {
        $this->logger->debug('Starting indexing procedures');

        $this->resetCounts();

        $this->logger->debug('Indexing is performed using ' . $this->getDocumentifierName());

        if ($this->differentialIndexingEnabled) {
            $this->lastRunTimestamp = $this->readLockFile();
        }

        if ($this->differentialIndexing()) {
            $this->logger->debug('A differential indexing will be performed');
        } else {
            $this->logger->debug('A full indexing will be performed');
            $this->removeIndex();
            $this->createIndex($this->index, $this->getDefaultMapParams());
        }

        $modules = $this->getModulesToIndex();

        $start = microtime(true);

        foreach ($modules as $module) {
            try {
                $this->indexModule($module);
            } catch (\Exception $e) {
                $message = "Failed to index module $module! Exception details follow";
                $this->logger->error($message);
                $this->logger->error($e);
            }
        }

        $end = microtime(true);

        if ($this->differentialIndexingEnabled) {
            $this->writeLockFile();
        }

        $this->statistics($end, $start);

        $this->logger->info("Indexing complete");
    }

    /**
     * Reads the lock file.
     *
     * Returns a Carbon timestamp or `false` if the file could not be found.
     *
     * @return Carbon|false
     */
    private function readLockFile()
    {
        $this->logger->debug("Reading lock file " . self::LOCK_FILE);
        if (file_exists(self::LOCK_FILE)) {
            $data = file_get_contents(self::LOCK_FILE);
            $data = intval($data);

            if (empty($data)) {
                $this->logger->warn('Failed to read lock file. Returning \'false\'.');
                return false;
            }

            $carbon = Carbon::createFromTimestamp($data);

            $this->logger->debug(sprintf("Last logged indexing performed on %s (%s)", $carbon->toDateTimeString(), $carbon->diffForHumans()));

            return $carbon;
        } else {
            $this->logger->debug("Lock file not found");
            return false;
        }
    }

    /**
     * Returns true if differentialIndexing is enabled and a previous run timestamp was found.
     *
     * @return bool
     */
    private function differentialIndexing()
    {
        return $this->differentialIndexingEnabled && $this->lastRunTimestamp !== false;
    }

    /**
     * {@inheritdoc}
     *
     * The current index (this::getIndex()) is removed if no index is specified.
     *
     * @param null $index
     */
    public function removeIndex($index = null)
    {
        if (empty($index)) {
            $index = $this->index;
        }

        $params = ['index' => $index];
        $params['client'] = ['ignore' => [404]];

        $this->client->indices()->delete($params);

        $this->logger->debug("Removed index '$index'");
    }

    /**
     * Creates a new index in the Elasticsearch server.
     *
     * The optional $body can be used to set up the index settings, mappings, etc.
     *
     * @param $index string name of the index
     * @param array|null $body options of the index
     */
    public function createIndex($index, array $body = null)
    {
        $params = ['index' => $index];

        if (!empty($body) && is_array($body)) {
            $params['body'] = $body;
        }

        $this->client->indices()->create($params);

        $this->logger->debug("Created new index '$index'");
    }

    /**
     * Retrieves the default params to set up an optimised default index for Elasticsearch.
     *
     * @return array
     */
    private function getDefaultMapParams()
    {
        $fields = [
            "keyword" => [
                "type" => "keyword",
                "ignore_above" => 256
            ]
        ];

        // TODO map dates?

        return [
            'mappings' => [
                '_default_' => [
                    'properties' => [
                        'name' => [
                            'properties' => [
                                'name' => [
                                    'type' => 'text',
                                    'copy_to' => 'named',
                                    'fields' => $fields
                                ],
                                'first' => [
                                    'type' => 'text',
                                    'copy_to' => 'named',
                                    'fields' => $fields
                                ],
                                'last' => [
                                    'type' => 'text',
                                    'copy_to' => 'named',
                                    'fields' => $fields
                                ]
                            ]
                        ],
                        'named' => [
                            'type' => 'text',
                            'fields' => $fields
                        ],
                    ]
                ]
            ]
        ];
    }

    /** @inheritdoc */
    public function indexModule($module)
    {
        $seed = BeanFactory::getBean($module);
        $table_name = $seed->table_name;
        $differentialIndexing = $this->differentialIndexing();

        $where = "";
        $showDeleted = 0;

        if ($differentialIndexing) {
            try {
                $datetime = $this->getModuleLastIndexed($module);
                $where = "$table_name.date_modified > '$datetime' OR $table_name.date_entered > '$datetime'";
                $showDeleted = -1;
            } catch (\Exception $e) {
                $this->logger->notice("Time metadata not found for $module, performing full index for this module");
                $differentialIndexing = false;
            }
        }

        try {
            $beanTime = Carbon::now()->toDateTimeString();
            $beans = $seed->get_full_list("", $where, false, $showDeleted);
        } catch (RuntimeException $e) {
            $this->logger->error("Failed to index module $module");
            $this->logger->error($e);
            return;
        }

        if ($beans === null) {
            if (!$differentialIndexing) {
                $this->logger->notice(sprintf('Skipping %s because $beans was null. The table is probably empty', $module));
            }
            return;
        }

        $this->logger->debug(sprintf('Indexing module %s...', $module));
        $this->indexBeans($module, $beans);
        $this->putMeta($module, ['last_index' => $beanTime]);
        $this->indexedModulesCount++;
    }

    /** @inheritdoc */
    public function indexBeans($module, array $beans)
    {
        if (!is_array($beans)) {
            $this->logger->error("Non-array type found while indexing $module. "
                . gettype($beans)
                . ' found instead. Skipping this module!');
            return;
        }

        $oldCount = $this->indexedRecordsCount;
        $oldRemCount = $this->removedRecordsCount;
        $this->indexBatch($module, $beans);
        $diff = $this->indexedRecordsCount - $oldCount;
        $remDiff = $this->removedRecordsCount - $oldRemCount;
        $total = count($beans) - $remDiff;
        $type = $total === $diff ? Logger::DEBUG : Logger::WARNING;
        $this->logger->log($type, sprintf('Indexed %d/%d %s', $diff, $total, $module));
    }

    /**
     * Creates a batch indexing request for Elasticsearch.
     *
     * The size of the batch is defined by `this::batchSize`.
     *
     * Additionally, Beans marked as deleted will be remove from the index.
     *
     * @param $module string
     * @param $beans SugarBean[]
     * @see batchSize
     */
    private function indexBatch($module, array $beans)
    {
        $params = ['body' => []];

        foreach ($beans as $key => $bean) {
            $head = ['_index' => $this->index, '_type' => $module, '_id' => $bean->id];

            if ($bean->deleted) {
                $params['body'][] = ['delete' => $head];
                $this->removedRecordsCount++;
            } else {
                $body = $this->makeIndexParamsBodyFromBean($bean);
                $params['body'][] = ['index' => $head];
                $params['body'][] = $body;
                $this->indexedRecordsCount++;
                $this->indexedFieldsCount += count($body);
            }

            // Send a batch of $this->batchSize elements to the server
            if ($key % $this->batchSize == 0) {
                $this->sendBatch($params);
            }
        }

        // Send the last batch if it exists
        if (!empty($params['body'])) {
            $this->sendBatch($params);
        }
    }

    /**
     * Creates the body of a Elasticsearch request for a given bean.
     *
     * It uses a Documentifier to make a document out of a SugarBean.
     *
     * @param $bean SugarBean
     * @return array
     * @see AbstractDocumentifier
     */
    private function makeIndexParamsBodyFromBean(SugarBean $bean)
    {
        return $this->documentifier->documentify($bean);
    }

    /**
     * Sends a batch request with the given params.
     *
     * Sends the requests and attempts to parse errors and fix the number of indexed records in case of errors.
     *
     * @param $params array
     */
    private function sendBatch(array &$params)
    {
        // sends the batch over to the server
        $responses = $this->client->bulk($params);

        if ($responses['errors'] === true) {
            // logs the errors
            foreach ($responses['items'] as $item) {
                $action = array_keys($item)[0];
                $type = $item[$action]['error']['type'];
                $reason = $item[$action]['error']['reason'];
                $this->logger->error("[$action] [$type] $reason");
                if ($action === 'index') {
                    $this->indexedRecordsCount--;
                } else if ($action === 'delete') {
                    $this->removedRecordsCount--;
                }
            }
        }

        // erase the old bulk request
        $params = ['body' => []];

        // unset the bulk response when you are done to save memory
        unset($responses);
    }

    /** Writes the lock file with the current timestamp to the default location */
    private function writeLockFile()
    {
        $this->logger->debug('Writing lock file to ' . self::LOCK_FILE);

        try {
            $result = file_put_contents(self::LOCK_FILE, Carbon::now()->timestamp);

            if ($result === false) {
                throw new \RuntimeException('Failed to write lock file!');
            }
        } catch (\Exception $e) {
            $this->logger->error('Error while writing lock file');
            $this->logger->error($e);
        }
    }

    /**
     * Shows statistics for the past run.
     *
     * @param $end float
     * @param $start float
     */
    private function statistics($end, $start)
    {
        if ($this->removedRecordsCount) {
            $this->logger->debug(sprintf('%s records have been removed', $this->removedRecordsCount));
        }

        if ($this->indexedRecordsCount != 0) {
            $elapsed = ($end - $start); // seconds
            $estimation = $elapsed / $this->indexedRecordsCount * 200000;
            CarbonInterval::setLocale('en');
            $estimationString = CarbonInterval::seconds(intval(round($estimation)))->cascade()->forHumans(true);
            $this->logger->debug(sprintf('%d modules, %d records and %d fields indexed in %01.3F s', $this->indexedModulesCount, $this->indexedRecordsCount, $this->indexedFieldsCount, $elapsed));

            if ($this->indexedRecordsCount > 100) {
                $this->logger->debug("It would take ~$estimationString for 200,000 records, assuming a linear expansion");
            }
        } else {
            $this->logger->debug('No record has been indexed');
        }
    }

    /** Removes all the indexes from Elasticsearch, effectively nuking all data. */
    public function removeAllIndices()
    {
        $this->logger->debug("Deleting all indices");
        try {
            $this->client->indices()->delete(['index' => '_all']);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (\Elasticsearch\Common\Exceptions\Missing404Exception $ignore) {
            // Index not there, not big deal since we meant to delete it anyway.
            $this->logger->warn('Index not found, no index has been deleted.');
        }
    }

    /** @inheritdoc */
    public function indexBean(SugarBean $bean)
    {
        $this->logger->debug("Indexing {$bean->module_name}($bean->name)");

        $args = $this->makeIndexParamsFromBean($bean);

        $this->client->index($args);
    }

    /**
     * Generates the params for indexing a bean from the bean itself.
     *
     * @param $bean SugarBean
     * @return array
     */
    private function makeIndexParamsFromBean(SugarBean $bean)
    {
        $args = $this->makeParamsHeaderFromBean($bean);
        $args['body'] = $this->makeIndexParamsBodyFromBean($bean);
        return $args;
    }

    /**
     * Generates the headers for indexing a bean from the bean itself.
     *
     * @param $bean SugarBean
     * @return array
     */
    private function makeParamsHeaderFromBean(SugarBean $bean)
    {
        $args = [
            'index' => $this->index,
            'type' => $bean->module_name,
            'id' => $bean->id,
        ];

        return $args;
    }

    /** @return int */
    public function getRemovedRecordsCount()
    {
        return $this->removedRecordsCount;
    }

    /** @return int */
    public function getIndexedRecordsCount()
    {
        return $this->indexedRecordsCount;
    }

    /** @return int */
    public function getIndexedFieldsCount()
    {
        return $this->indexedFieldsCount;
    }

    /** @return int */
    public function getIndexedModulesCount()
    {
        return $this->indexedModulesCount;
    }

    /** @return int */
    public function getBatchSize()
    {
        return $this->batchSize;
    }

    /** @param int $batchSize */
    public function setBatchSize($batchSize)
    {
        $this->batchSize = $batchSize;
    }

    /** @return string */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Sets the name of the Elasticsearch index to send requests to.
     *
     * @param string $index
     */
    public function setIndex($index)
    {
        $this->logger->debug("Setting index to $index");
        $this->index = $index;
    }

    /** @inheritdoc */
    public function removeBean(SugarBean $bean)
    {
        $this->logger->debug("Removing {$bean->module_name}($bean->name)");

        $args = $this->makeParamsHeaderFromBean($bean);
        $this->client->delete($args);
    }

    /**
     * @inheritdoc
     *
     * @param bool $ignore404 deleting something that is not there won't throw an error
     */
    public function removeBeans(array $beans, $ignore404 = true)
    {
        $params = [];

        if ($ignore404) {
            $params['client']['ignore'] = [404];
        }

        foreach ($beans as $bean) {
            $params['body'][] = ['delete' => $this->makeParamsHeaderFromBean($bean)];
        }

        $this->sendBatch($params);
    }

    /**
     * Attempts to contact the Elasticsearch server and perform a simple request.
     *
     * Returns `false` in case of failure or the time it took to perform the operation in microseconds.
     *
     * @return int|false
     */
    public function ping()
    {
        $start = Carbon::now()->micro;
        $status = $this->client->ping();
        $elapsed = Carbon::now()->micro - $start;

        if ($status === false) {
            $this->logger->error("Failed to ping server");
            return false;
        } else {
            $this->logger->debug("Ping performed in $elapsed µs");
            return $elapsed;
        }
    }

    /**
     * Writes the metadata fields for one index type.
     *
     * @param $module string name of the module/type
     * @param $meta array an associative array with the fields to populate
     */
    public function putMeta($module, $meta)
    {
        $params = [
            'index' => $this->index,
            'type' => $module,
            'body' => ['_meta' => $meta]
        ];

        $this->client->indices()->putMapping($params);
    }

    /**
     * Returns the metadata fields for one index type.
     *
     * @param $module string name of the module/type
     * @return array an associative array with the metadata
     */
    public function getMeta($module)
    {
        $params = ['index' => $this->index, 'filter_path' => "$this->index.mappings.$module._meta"];
        $results = $this->client->indices()->getMapping($params);
        if (isset($results[$this->index])) {
            $meta = $results[$this->index]['mappings'][$module]['_meta'];
            return $meta;
        } else {
            return null;
        }
    }

    /**
     * Retrieves the last time a module was indexed from a metadata stored in the Elasticsearch index.
     *
     * @param $module string
     * @return string a datetime string
     */
    private function getModuleLastIndexed($module)
    {
        $meta = $this->getMeta($module);

        if (isset($meta['last_index'])) {
            return $meta['last_index'];
        } else {
            throw new RuntimeException("Last index metadata not found.");
        }
    }

    /**
     * Returns whether the Elasticsearch is enabled by user configuration or not.
     *
     * @return bool
     */
    public static function isEnabled()
    {
        global $sugar_config;

        try {
            return $sugar_config['search']['ElasticSearch']['enabled'];
        } catch (\Exception $e) {
            \LoggerManager::getLogger()->fatal("Failed to retrieve ElasticSearch options");
            return false;
        }
    }

    /** Resets the counters to zero. */
    private function resetCounts()
    {
        $this->indexedModulesCount = 0;
        $this->indexedRecordsCount = 0;
        $this->indexedFieldsCount = 0;
        $this->removedRecordsCount = 0;
    }

    /**
     * Scheduler job method.
     *
     * @return bool
     */
    public static function schedulerJob()
    {
        if (self::isEnabled() === false) {
            return true;
        }

        $i = new self();
        $i->getLogger()->debug('Starting scheduled job');

        try {
            $i->setDifferentialIndexingEnabled(true);
            $i->run();
        } catch (\Exception $e) {
            $i->getLogger()->error('An error has occurred while running a scheduled indexing');
            $i->getLogger()->error($e);
            return false;
        }

        $i->getLogger()->debug('Scheduler has finished');

        return true;
    }
}