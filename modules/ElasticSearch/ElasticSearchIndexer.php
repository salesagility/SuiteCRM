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

use Elasticsearch\ClientBuilder;

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 22/06/18
 * Time: 12:33
 */

require_once 'modules/ModuleBuilder/parsers/parser.searchfields.php';

class ElasticSearchIndexer
{
    private $indexName = 'main';
    private $batchSize = 1000;

    public function run()
    {
        $client = $this->getClient();

        try {
            $client->indices()->delete(['index' => '_all']);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (\Elasticsearch\Common\Exceptions\Missing404Exception $ignore) {
            // Index not there, not big deal since we meant to delete it anyway.
        }

        $start = microtime(true);

        $modules = $this->getModulesToIndex();

        foreach ($modules as $module) {
            $this->indexModule($module, $client);
        }

        $end = microtime(true);

        $elapsed = ($end - $start); // seconds?

        echo "Indexed database in $elapsed s";
    }

    /**
     * @return \Elasticsearch\Client
     */
    private function getClient()
    {
        $hosts = ['elasticsearch'];
        $client = ClientBuilder::create()->setHosts($hosts)->build();
        return $client;
    }

    public function getModulesToIndex()
    {
        // TODO
        return ['Accounts', 'Contacts'];
    }

    /**
     * @param $module string
     * @param $client \Elasticsearch\Client
     */
    private function indexModule($module, $client)
    {
        $beans = BeanFactory::getBean($module)->get_full_list();

        $this->indexBatch($module, $beans, $client);
    }

    /**
     * @param $module string
     * @param $beans SugarBean[]
     * @param $client \Elasticsearch\Client
     */
    private function indexBatch($module, $beans, $client)
    {
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
                $responses = $client->bulk($params);

                // erase the old bulk request
                $params = ['body' => []];

                // unset the bulk response when you are done to save memory
                unset($responses);
            }
        }

        // Send the last batch if it exists
        if (!empty($params['body'])) {
            $responses = $client->bulk($params);
            unset($responses);
        }
    }

    public function getFieldsToIndex($module)
    {
        // TODO

        if ($module == 'Contacts')
            return ['first_name', 'last_name'];
        if ($module == 'Accounts')
            return ['name', 'description'];

        // $parsers = new ParserSearchFields($module);
        // $fields = $parsers->getSearchFields();

        return [];
    }

    /**
     * @param $bean
     * @param $fields
     * @return array
     */
    private function makeIndexParamsBodyFromBean($bean, $fields)
    {
        $body = [];

        foreach ($fields as $field) {
            $body[$field] = $bean->$field;
        }

        if ($bean->module_name === 'Contacts') {
            $body['name'] = $bean->first_name . ' ' . $bean->last_name;
        }

        return $body;
    }

    /**
     * @param $client \Elasticsearch\Client
     * @param $bean SugarBean
     * @param $fields array
     */
    private function indexBean($client, $bean, $fields)
    {
        $args = $this->makeIndexParamsFromBean($bean, $fields);

        $client->index($args);
    }

    /**
     * @param $bean SugarBean
     * @param $fields array
     * @return array
     */
    private function makeIndexParamsFromBean($bean, $fields)
    {
        $args = [
            'index' => $this->indexName,
            'type' => $bean->module_name,
            'id' => $bean->id,
            'body' => $this->makeIndexParamsBodyFromBean($bean, $fields),
        ];

        return $args;
    }
}