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
use ParserSearchFields;
use SugarBean;
use SuiteCRM\Utility\BeanJsonSerializer;

class ElasticSearchIndexer
{
    private $indexName = 'main';
    // 70% slower without using search defs
    // but better quality indexing
    private $useSearchDefs = false;
    private $output = false;
    private $batchSize = 1000;
    private $indexedRecords;
    private $indexedFields;

    /**
     * @var \Elasticsearch\Client
     */
    private $client = null;

    /**
     * ElasticSearchIndexer constructor.
     * @param \Elasticsearch\Client|null $client
     */
    public function __construct($client = null)
    {
        if (!empty($client))
            $this->client = $client;
        else
            $this->client = ElasticSearchClientBuilder::getClient();
    }

    /**
     * Allows static launch of an indexing.
     *
     * @param bool $output shows logging on the output stream
     * @param bool $useSearchDefs uses searchdefs.php files to understand what to index. Uses BeanJsonSerializer otherwise.
     */
    public static function _run($output = false, $useSearchDefs = false)
    {
        $indexer = new self();

        $indexer->output = $output;
        $indexer->useSearchDefs = $useSearchDefs;

        $indexer->run();
    }

    /**
     * Allows static launch of an indexing.
     *
     */
    public function run()
    {
        $this->log('@', 'Starting indexing procedures');

        $this->indexedRecords = 0;
        $this->indexedFields = 0;

        if ($this->useSearchDefs) {
            $this->log('@', 'Indexing is performed using Searchdefs');
        } else {
            $this->log('@', 'Indexing is performed using BeanJsonSerializer');
        }

        $this->deleteAllIndexes();

        $start = microtime(true);

        $modules = $this->getModulesToIndex();

        foreach ($modules as $module) {
            $this->indexModule($module);
        }

        $end = microtime(true);
        $elapsed = ($end - $start); // seconds
        $estimation = $elapsed / $this->indexedRecords * 200000;

        $this->log('@', sprintf("%d modules, %d records and %d fields indexed in %01.3F s", count($modules), $this->indexedRecords, $this->indexedFields, $elapsed));
        $this->log('@', sprintf("It would take ~%d min for 200,000 records, assuming a linear expansion", $estimation / 60));
        $this->log('@', "Done!");
    }

    private function log($type, $message)
    {
        if (!$this->output) return;

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
     * Removes all the indexes from Elasticsearch, effectively nuking all data.
     */
    public function deleteAllIndexes()
    {
        try {
            $this->client->indices()->delete(['index' => '_all']);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (\Elasticsearch\Common\Exceptions\Missing404Exception $ignore) {
            // Index not there, not big deal since we meant to delete it anyway.
            $this->log('*', 'Index not found, no index has been deleted.');
        }
    }

    /**
     * @return string[]
     */
    public function getModulesToIndex()
    {
        // TODO get them from either the search defs or the add a white/blacklist
        return ['Accounts', 'Contacts', 'Users'];
    }

    /**
     * @param $module string
     */
    public function indexModule($module)
    {
        $beans = BeanFactory::getBean($module)->get_full_list();

        if ($beans === null) {
            $this->log('*', sprintf('Skipping %s because $beans was null. The table is probably empty', $module));
            return;
        } else {
            $this->log('@', sprintf('Indexing module %s...', $module));
            $this->indexBeans($module, $beans);
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

        $oldCount = $this->indexedRecords;
        $this->indexBatch($module, $beans);
        $diff = $this->indexedRecords - $oldCount;
        $total = count($beans);
        $type = $total === $diff ? '@' : '*';
        $this->log($type, sprintf('Indexed %d/%d %s', $diff, $total, $module));
    }

    /**
     * @param $module string
     * @param $beans SugarBean[]
     */
    private function indexBatch($module, $beans)
    {
        if ($this->useSearchDefs)
            $fields = $this->getFieldsToIndex($module);

        $params = ['body' => []];

        foreach ($beans as $key => $bean) {

            $params['body'][] = [
                'index' => [
                    '_index' => $this->indexName,
                    '_type' => $module,
                    '_id' => $bean->id
                ]
            ];

            $params['body'][] = $this->makeIndexParamsBodyFromBean($bean, $fields);

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
     * @param $module string
     * @param ParserSearchFields|null $parser
     * @return string[]
     */
    public function getFieldsToIndex($module, $parser = null)
    {
        if (empty($parser)) {
            require_once 'modules/ModuleBuilder/parsers/parser.searchfields.php';
            $parser = new ParserSearchFields($module);
        }

        $fields = $parser->getSearchFields()[$module];

        $parsedFields = [];

        foreach ($fields as $key => $field) {
            if (isset($field['query_type']) && $field['query_type'] != 'default') {
                $this->log('*', "[$module]->$key is not a supported query type!");
                continue;
            };

            if (!empty($field['operator'])) {
                $this->log('*', "[$module]->$key has an operator!");
                continue;
            }

            if (strpos($key, 'range_date') !== false) {
                continue;
            }

            if (!empty($field['db_field'])) {
                foreach ($field['db_field'] as $db_field) {
                    $parsedFields[$key][] = $db_field;
                }
            } else {
                $parsedFields[] = $key;
            }
        }

        return $parsedFields;
    }

    /**
     * Note: it removes not found fields from the `$fields` argument.
     * @param $bean SugarBean
     * @param $fields array
     * @return array
     */
    private function makeIndexParamsBodyFromBean($bean, &$fields = null)
    {
        $results
            = $this->useSearchDefs
            ? $this->makeIndexParamsBodyFromBeanSearchDefs($bean, $fields)
            : $this->makeIndexParamsBodyFromBeanSerializer($bean);

        return $results;
    }

    /**
     * @param $bean
     * @param $fields
     * @return array
     */
    private function makeIndexParamsBodyFromBeanSearchDefs($bean, &$fields)
    {
        if (empty($fields))
            throw new \InvalidArgumentException("Mandatory argument \$fields is empty.");

        $body = [];

        foreach ($fields as $key => $field) {
            if (is_array($field)) {
                foreach ($field as $subfield) {
                    if ($this->hasField($bean, $subfield)) {
                        $body[$key][$subfield] = mb_convert_encoding($bean->$subfield, "UTF-8", "HTML-ENTITIES");
                    }
                }
            } else {
                if ($this->hasField($bean, $field)) {
                    $body[$field] = mb_convert_encoding($bean->$field, "UTF-8", "HTML-ENTITIES");
                }
            }
        }

        $this->indexedFields += count($body);

        return $body;
    }

    /**
     * @param $bean
     * @param $field
     * @return bool
     */
    private function hasField($bean, $field)
    {
        if (!isset($bean->$field)) {
            $this->log('!', "{$bean->module_name}->$field does not exist!");

            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $bean
     * @return array
     */
    private function makeIndexParamsBodyFromBeanSerializer($bean)
    {
        $values = BeanJsonSerializer::toArray($bean);

        unset($values['id']);

        $this->indexedFields += count($values);

        return $values;
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
                $type = $item['index']['error']['type'];
                $reason = $item['index']['error']['reason'];
                $this->log('!', "[$type] $reason");
            }
        } else {
            // if successful increase the count for statistics
            $this->indexedRecords += count($params['body']) / 2;
        }


        // erase the old bulk request
        $params = ['body' => []];

        // unset the bulk response when you are done to save memory
        unset($responses);
    }

    /**
     * @return bool
     */
    public function isUseSearchDefs()
    {
        return $this->useSearchDefs;
    }

    /**
     * @param bool $useSearchDefs
     */
    public function setUseSearchDefs($useSearchDefs)
    {
        $this->useSearchDefs = $useSearchDefs;
    }

    /**
     * @return bool
     */
    public function isOutput()
    {
        return $this->output;
    }

    /**
     * @param bool $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @param $bean SugarBean
     * @param $fields array|null
     */
    public function indexBean($bean, $fields = null)
    {
        if ($this->useSearchDefs && empty($fields)) {
            $fields = $this->getFieldsToIndex($bean->module_name);
        }

        $args = $this->makeIndexParamsFromBean($bean, $fields);

        $this->client->index($args);
    }

    /**
     * @param $bean SugarBean
     * @param $fields array|null
     * @return array
     */
    private function makeIndexParamsFromBean($bean, $fields = null)
    {
        $args = $this->makeParamsHeaderFromBean($bean);
        $args['body'] = $this->makeIndexParamsBodyFromBean($bean, $fields);
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
     * @return mixed
     */
    public function getIndexedRecords()
    {
        return $this->indexedRecords;
    }

    /**
     * @return mixed
     */
    public function getIndexedFields()
    {
        return $this->indexedFields;
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
     * @param $bean SugarBean
     */
    public function removeBean($bean)
    {
        $args = $this->makeParamsHeaderFromBean($bean);
        $this->client->delete($args);
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