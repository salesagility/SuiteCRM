<?php /** @noinspection PhpUnhandledExceptionInspection */

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

use SuiteCRM\Search\ElasticSearch\ElasticSearchIndexer;
use SuiteCRM\Search\MasterSearch;
use SuiteCRM\Search\SearchQuery;

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 22/06/18
 * Time: 12:37
 */
class ElasticSearchIntegrationTest extends SuiteCRM\Search\SearchTestAbstract
{
    public function testWithoutSearchdefs()
    {
        // Make a new Indexer instance
        $indexer = new ElasticSearchIndexer();
        $indexer->setOutput(true);
        $indexer->setUseSearchDefs(false);

        $this->indexRunner($indexer);
    }

    /**
     * @param $indexer ElasticSearchIndexer
     * @throws \SuiteCRM\StateSaverException
     */
    public function indexRunner($indexer)
    {
        /** @var Contact $bean */
        $bean = BeanFactory::newBean('Contacts');

        // Save the system state for later recovery
        $state = new \SuiteCRM\StateSaver();
        $state->pushTable($bean->getTableName());
        $state->pushGlobals();

        try {
            // Create unique test vars
            $firstName = uniqid();
            $lastName = uniqid();
            $full_name_update = md5(time());
            $city = uniqid() . 'City';

            // Delete the previous indexes
            $indexer->deleteAllIndexes();

            // Assign the vars to the bean
            $bean->first_name = $firstName;
            $bean->last_name = $lastName;
            $bean->primary_address_city = $city;

            // Save the bean to the database and retrieve the new id
            $bean->save();
            $id = $bean->id;

            // Perform a new indexing
            echo PHP_EOL;
            ElasticSearchIndexer::_run($indexer->isOutput(), $indexer->isUseSearchDefs());

            $this->waitForIndexing();

            // Attempt to search the newly added bean by full name
            $results = MasterSearch::search(
                'ElasticSearchEngine',
                SearchQuery::fromString("$firstName $lastName", 1));

            self::assertArrayHasKey(
                'Contacts',
                $results,
                'Unable to find by full name!');
            self::assertEquals(
                $id,
                $results['Contacts'][0],
                'Wrong id returned by the search engine.'
            );

            // lets test a more complex query
            // Search by city

            $query = $indexer->isUseSearchDefs()
                ? SearchQuery::fromString("address_city.primary_address_city:$city", 1)
                : SearchQuery::fromString("address.primary.city:$city", 1);
            $results = MasterSearch::search(
                'ElasticSearchEngine',
                $query
            );

            self::assertArrayHasKey(
                'Contacts',
                $results,
                "Unable to find by city [$city]!");
            self::assertEquals(
                $id,
                $results['Contacts'][0],
                'Wrong id returned by the search engine.'
            );

            $bean = BeanFactory::getBean('Contacts', $id);

            $bean->first_name = $full_name_update;

            // injecting this indexer so that it'll have the same parameters
            $bean->indexer = $indexer;

            $bean->save();
            // the hooks should cause another indexing to happen

            $this->waitForIndexing();

            $results = MasterSearch::search(
                'ElasticSearchEngine',
                SearchQuery::fromString($full_name_update, 1)
            );

            self::assertArrayHasKey(
                'Contacts',
                $results,
                "Unable to find by updated username!");
            self::assertEquals(
                $bean->id,
                $results['Contacts'][0],
                "Wrong ID retrieved"
            );

            // remove the bean...
            $indexer->removeBean($bean);

            $this->waitForIndexing();

            // make a search query for the deleted bean
            $results = MasterSearch::search(
                'ElasticSearchEngine',
                SearchQuery::fromString($full_name_update, 1)
            );

            self::assertEmpty($results, "The deleted bean should not have been found!");

            $state->popGlobals();
            $state->popTable($bean->getTableName());
        } catch (Exception $e) {
            $state->popGlobals();
            $state->popTable($bean->getTableName());

            throw $e;
        }
    }

    /** The indexing on Elasticsearch is scheduled each second.
     * No results will be available before that time.
     **/
    private function waitForIndexing()
    {
        sleep(1);
    }

    public function testWithSearchdefs()
    {
        // Make a new Indexer instance
        $indexer = new ElasticSearchIndexer();
        $indexer->setOutput(true);
        $indexer->setUseSearchDefs(true);
        $indexer->setBatchSize(1);

        $this->indexRunner($indexer);
    }


}
