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

use BeanFactory;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Elasticsearch\Client;
use JsonSchema\Exception\RuntimeException;
use SugarBean;
use SuiteCRM\Search\Index\AbstractIndexer;

class ElasticSearchIndexer extends AbstractIndexer
{
    /**
     * @var string File containing a timestamp of the last (complete or differential) indexing.
     */
    const LOCK_FILE = 'cache/ElasticSearchIndex.lock';
    /**
     * @var string The name of the Elasticsearch index to use.
     */
    private $indexName = 'main';
    /**
     * @var Client
     */
    private $client = null;

    /**
     * Without search defs the indexing is faster and more reliable with known data,
     * but it is not yet customisable by the user. *
     */
    private $batchSize = 1000;

    // stats
    private $indexedModulesCount;
    private $indexedRecordsCount;
    private $indexedFieldsCount;
    private $removedRecordsCount;
    /** @var bool|Carbon */
    private $lastRunTimestamp = false;

    /**
     * ElasticSearchIndexer constructor.
     * @param Client|null $client
     */
    public function __construct($client = null)
    {
        parent::__construct();

        if (!empty($client))
            $this->client = $client;
        else
            $this->client = ElasticSearchClientBuilder::getClient();
    }

    public function run()
    {
        $this->log('@', 'Starting indexing procedures');

        $this->indexedModulesCount = 0;
        $this->indexedRecordsCount = 0;
        $this->indexedFieldsCount = 0;
        $this->removedRecordsCount = 0;

        $this->log('@', 'Indexing is performed using ' . $this->getDocumentifierName());

        if ($this->differentialIndexingEnabled) {
            $this->lastRunTimestamp = $this->readLockFile();
        }

        if ($this->differentialIndexing()) {
            $this->log('@', 'A differential indexing will be performed');
        } else {
            $this->log('@', 'A full indexing will be performed');
            $this->removeAllIndices();
        }

        $modules = $this->getModulesToIndex();

        $start = microtime(true);

        foreach ($modules as $module) {
            $this->indexModule($module);
        }

        $end = microtime(true);

        if ($this->differentialIndexingEnabled)
            $this->writeLockFile();

        $this->statistics($end, $start);

        $this->log('@', "Done!");
    }

    /**
     * Reads the lock file and returns a Carbon timestamp or `null` if the fail could not be found.
     *
     * @return bool|Carbon
     */
    private function readLockFile()
    {
        $this->log('@', "Reading lock file " . self::LOCK_FILE);
        if (file_exists(self::LOCK_FILE)) {
            $data = file_get_contents(self::LOCK_FILE);
            $data = intval($data);
            $carbon = Carbon::createFromTimestamp($data);

            $this->log('@', sprintf("Last logged indexing performed on %s (%s)", $carbon->toDateTimeString(), $carbon->diffForHumans()));

            return $carbon;
        } else {
            $this->log('@', "Lock file not found");
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
     * Removes all the indexes from Elasticsearch, effectively nuking all data.
     */
    public function removeAllIndices()
    {
        $this->log('@', "Deleting all indices");
        try {
            $this->client->indices()->delete(['index' => '_all']);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (\Elasticsearch\Common\Exceptions\Missing404Exception $ignore) {
            // Index not there, not big deal since we meant to delete it anyway.
            $this->log('*', 'Index not found, no index has been deleted.');
        }
    }

    /**
     * @param $module string
     */
    public function indexModule($module)
    {
        $seed = BeanFactory::getBean($module);
        $table_name = $seed->table_name;

        if ($this->differentialIndexing()) {
            $datetime = $this->lastRunTimestamp->toDateTimeString();
            $where = "$table_name.date_modified > '$datetime' OR $table_name.date_entered > '$datetime'";
            $showDeleted = -1;
        } else {
            $where = "";
            $showDeleted = 0;
        }

        try {
            $beans = $seed->get_full_list("", $where, false, $showDeleted);
        } catch (RuntimeException $e) {
            $this->log('!', "Failed to index module $module because of $e");
            return;
        }

        if ($beans === null) {
            if (!$this->differentialIndexing())
                $this->log('*', sprintf('Skipping %s because $beans was null. The table is probably empty', $module));
            return;
        } else {
            $this->log('@', sprintf('Indexing module %s...', $module));
            $this->indexBeans($module, $beans);
            $this->indexedModulesCount++;
        }
    }

    /**
     * @param $module string
     * @param $beans SugarBean[]
     */
    public function indexBeans($module, $beans)
    {
        if (!is_array($beans)) {
            $this->log('!', "Non-array type found while indexing $module. "
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
        $type = $total === $diff ? '@' : '*';
        $this->log($type, sprintf('Indexed %d/%d %s', $diff, $total, $module));
    }

    /**
     * @param $module string
     * @param $beans SugarBean[]
     */
    private function indexBatch($module, $beans)
    {
        $params = ['body' => []];

        foreach ($beans as $key => $bean) {
            $head = ['_index' => $this->indexName, '_type' => $module, '_id' => $bean->id];

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
     * @param $bean SugarBean
     * @return array
     */
    private function makeIndexParamsBodyFromBean($bean)
    {
        return $this->documentifier->documentify($bean);
    }

    /**
     * @param $params
     */
    private function sendBatch(&$params)
    {
        // sends the batch over to the server
        $responses = $this->client->bulk($params);

        if ($responses['errors'] === true) {
            // logs the errors
            foreach ($responses['items'] as $item) {
                $action = array_keys($item)[0];
                $type = $item[$action]['error']['type'];
                $reason = $item[$action]['error']['reason'];
                $this->log('!', "[$action] [$type] $reason");
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

    private function writeLockFile()
    {
        $this->log('@', "Writing lock file to " . self::LOCK_FILE);
        file_put_contents(self::LOCK_FILE, Carbon::now()->timestamp);
    }

    /**
     * @param $end
     * @param $start
     */
    private function statistics($end, $start)
    {
        if ($this->removedRecordsCount) {
            $this->log('@', sprintf('%s records have been removed', $this->removedRecordsCount));
        }

        if ($this->indexedRecordsCount != 0) {
            $elapsed = ($end - $start); // seconds
            $estimation = $elapsed / $this->indexedRecordsCount * 200000;
            CarbonInterval::setLocale('en');
            $estimationString = CarbonInterval::seconds(intval(round($estimation)))->cascade()->forHumans(true);
            $this->log('@', sprintf('%d modules, %d records and %d fields indexed in %01.3F s', $this->indexedModulesCount, $this->indexedRecordsCount, $this->indexedFieldsCount, $elapsed));
            $this->log('@', "It would take ~$estimationString for 200,000 records, assuming a linear expansion");
        } else {
            $this->log('@', 'No record has been indexed');
        }
    }

    /**
     * @param $bean SugarBean
     */
    public function indexBean($bean)
    {
        $args = $this->makeIndexParamsFromBean($bean);

        $this->client->index($args);
    }

    /**
     * @param $bean SugarBean
     * @return array
     */
    private function makeIndexParamsFromBean($bean)
    {
        $args = $this->makeParamsHeaderFromBean($bean);
        $args['body'] = $this->makeIndexParamsBodyFromBean($bean);
        return $args;
    }

    /**
     * @param $bean SugarBean
     * @return array
     */
    private function makeParamsHeaderFromBean($bean)
    {
        $args = [
            'index' => $this->indexName,
            'type' => $bean->module_name,
            'id' => $bean->id,
        ];

        return $args;
    }

    /**
     * @return int
     */
    public function getRemovedRecordsCount()
    {
        return $this->removedRecordsCount;
    }

    /**
     * @return int
     */
    public function getIndexedRecordsCount()
    {
        return $this->indexedRecordsCount;
    }

    /**
     * @return int
     */
    public function getIndexedFieldsCount()
    {
        return $this->indexedFieldsCount;
    }

    /**
     * @return int
     */
    public function getIndexedModulesCount()
    {
        return $this->indexedModulesCount;
    }

    /**
     * @return int
     */
    public function getBatchSize()
    {
        return $this->batchSize;
    }

    /**
     * @param int $batchSize
     */
    public function setBatchSize($batchSize)
    {
        $this->batchSize = $batchSize;
    }

    /**
     * @return string
     */
    public function getIndexName()
    {
        return $this->indexName;
    }

    /**
     * @param string $indexName
     */
    public function setIndexName($indexName)
    {
        $this->indexName = $indexName;
    }

    /**
     * @param $bean SugarBean
     */
    public function removeBean($bean)
    {
        $args = $this->makeParamsHeaderFromBean($bean);
        $this->client->delete($args);
    }

    /**
     * Removes a set of beans from the index.
     *
     * @param $beans SugarBean[]
     * @param bool $ignore404 deleting something that is not there won't throw an error
     */
    public function removeBeans($beans, $ignore404 = true)
    {
        $params = [];

        if ($ignore404)
            $params['client']['ignore'] = [404];

        foreach ($beans as $bean) {
            $params['body'][] = ['delete' => $this->makeParamsHeaderFromBean($bean)];
        }

        $this->sendBatch($params);
    }

    public function removeIndex($index = null)
    {
        if (empty($index)) {
            $index = $this->indexName;
        }

        $params = ['index' => $index];
        $this->client->indices()->delete($params);
    }
}