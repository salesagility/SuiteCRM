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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use SuiteCRM\Search\ElasticSearch\ElasticSearchClientBuilder;
use SuiteCRM\Search\Exceptions\SearchInvalidRequestException;
use SuiteCRM\Search\SearchEngine;
use SuiteCRM\Search\SearchQuery;
use SuiteCRM\Search\SearchResults;

/**
 * SearchEngine that use Elasticsearch index for performing almost real-time search.
 */
class ElasticSearchEngine extends SearchEngine
{
    /** @var Client */
    private $client;
    /** @var string */
    private $index = 'main';

    /**
     * ElasticSearchEngine constructor.
     *
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = empty($client) ? ElasticSearchClientBuilder::getClient() : $client;
    }

    /**
     * @inheritdoc
     */
    public function search(SearchQuery $query)
    {
        $this->validateQuery($query);
        $params = $this->createSearchParams($query);
        $start = microtime(true);
        $hits = $this->runElasticSearch($params);
        $results = $this->parseHits($hits);
        $end = microtime(true);
        $searchTime = ($end - $start);
        return new SearchResults($results, true, $searchTime, $hits['hits']['total']);
    }

    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param string $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @param SearchQuery $query
     */
    protected function validateQuery(SearchQuery &$query)
    {
        $query->trim();
        $query->convertEncoding();
    }

    /**
     * Generates the parameter array for the Elasticsearch API from a SearchQuery.
     *
     * @param SearchQuery $query
     *
     * @return array
     */
    private function createSearchParams($query)
    {
        $params = [
            'index' => $this->index,
            'body' => [
                'stored_fields' => [],
                'from' => $query->getFrom(),
                'size' => $query->getSize(),
                'query' => [
                    'query_string' => [
                        'query' => $query->getSearchString(),
                        'fields' => ['name.*^5', '_all'],
                        'analyzer' => 'standard',
                        'default_operator' => 'OR',
                        'minimum_should_match' => '66%',
                    ],
                ],
            ],
        ];

        return $params;
    }

    /**
     * Calls the Elasticsearch API.
     *
     * @param array $params
     *
     * @return array
     */
    private function runElasticSearch($params)
    {
        try {
            $results = $this->client->search($params);
        } /** @noinspection PhpRedundantCatchClauseInspection */ catch (BadRequest400Exception $exception) {
            throw new SearchInvalidRequestException('The query was not valid.');
        }

        return $results;
    }

    /**
     * Reads the array returned from the Elasticsearch API
     * and converts it into an associative array of ids, grouped by Module.
     *
     * @param array $hits
     *
     * @return array
     */
    private function parseHits($hits)
    {
        $hitsArray = $hits['hits']['hits'];

        $results = [];

        foreach ($hitsArray as $hit) {
            $results[$hit['_type']][] = $hit['_id'];
        }

        return $results;
    }
}
