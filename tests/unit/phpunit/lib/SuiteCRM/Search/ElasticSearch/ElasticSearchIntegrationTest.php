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
use SuiteCRM\Search\Index\Documentify\JsonSerializerDocumentifier;
use SuiteCRM\Search\Index\Documentify\SearchDefsDocumentifier;
use SuiteCRM\Search\SearchQuery;
use SuiteCRM\Search\SearchWrapper;
use SuiteCRM\StateSaver;

/** @noinspection PhpIncludeInspection */
require_once 'lib/Search/ElasticSearch/ElasticSearchEngine.php';

class ElasticSearchIntegrationTest extends SuiteCRM\Search\SearchTestAbstract
{
    const LOCK_FILE = 'cache/ElasticSearchIndex.lock';
    /** @var ElasticSearchIndexer */
    private $indexer;
    /** @var ElasticSearchEngine */
    private $searchEngine;
    /** @var StateSaver */
    private $state;

    protected function setUp()
    {
        parent::setUp();
        echo PHP_EOL;

        $this->indexer = new ElasticSearchIndexer();
        $this->searchEngine = new ElasticSearchEngine();
        $this->state = new StateSaver();

        $this->saveState();

        $GLOBALS['sugar_config']['search']['ElasticSearch']['enabled'] = true;
        $this->searchEngine->setIndex('test');
        $this->indexer->setIndex('test');
        $this->indexer->setModulesToIndex(['Contacts']);
        $this->indexer->setDifferentialIndexing(false);
        $this->indexer->removeIndex();
    }

    /**
     * @throws \SuiteCRM\StateSaverException
     */
    private function saveState()
    {
        $this->state->pushTable('contacts');
        $this->state->pushTable('aod_indexevent');
        $this->state->pushTable('contacts_cstm');
        $this->state->pushTable('sugarfeed');
        $this->state->pushFile(self::LOCK_FILE);
        $this->state->pushGlobals();
    }

    protected function tearDown()
    {
        $this->restore();

        parent::tearDown();
    }

    /**
     * @throws \SuiteCRM\StateSaverException
     */
    private function restore()
    {
        $this->state->popGlobals();
        $this->state->popTable('contacts');
        $this->state->popTable('aod_indexevent');
        $this->state->popTable('contacts_cstm');
        $this->state->popTable('sugarfeed');
        $this->state->popFile(self::LOCK_FILE);
        $this->indexer->removeIndex('test');
    }

    public function testPing()
    {
        $result = $this->indexer->ping();

        self::assertNotFalse($result);
        self::assertTrue(is_numeric($result));
    }

    public function testWithoutSearchdefs()
    {
        $this->indexer->setDocumentifier(new JsonSerializerDocumentifier());
        $this->indexRunner();
    }

    /**
     * Starts indexing using the indexer stored as a field.
     */
    private function indexRunner()
    {
        /** @var Contact $bean */
        $bean = BeanFactory::newBean('Contacts');

        // Create unique test vars
        $firstName = uniqid();
        $lastName = uniqid();
        $full_name_update = md5(time());
        $city = uniqid() . 'City';

        // Assign the vars to the bean
        $bean->first_name = $firstName;
        $bean->last_name = $lastName;
        $bean->primary_address_city = $city;

        // Save the bean to the database and retrieve the new id
        $bean->save();
        $id = $bean->id;

        // Perform a new indexing
        echo PHP_EOL;
        $this->indexer->index();

        $this->waitForIndexing();

        // Attempt to search the newly added bean by full name
        $results = SearchWrapper::search(
            $this->searchEngine,
            SearchQuery::fromString("$firstName $lastName", 1)
        )->getHits();

        self::assertArrayHasKey(
            'Contacts',
            $results,
            'Unable to find by full name!'
        );
        self::assertEquals(
            $id,
            $results['Contacts'][0],
            'Wrong id returned by the search engine.'
        );

        // lets test a more complex query
        // Search by city

        $query = SearchQuery::fromString("address.primary.city:$city", 1);

        $results = SearchWrapper::search(
            $this->searchEngine,
            $query
        )->getHits();

        self::assertArrayHasKey(
            'Contacts',
            $results,
            "Unable to find by city [$city]!"
        );
        self::assertEquals(
            $id,
            $results['Contacts'][0],
            'Wrong id returned by the search engine.'
        );

        $bean = BeanFactory::getBean('Contacts', $id);

        $bean->first_name = $full_name_update;

        // injecting this indexer so that it'll have the same parameters
        /** @noinspection PhpUndefinedFieldInspection */
        $bean->indexer = $this->indexer;

        $bean->save();
        // the hooks should cause another indexing to happen

        $this->waitForIndexing();

        $results = SearchWrapper::search(
            $this->searchEngine,
            SearchQuery::fromString($full_name_update, 1)
        )->getHits();

        self::assertArrayHasKey(
            'Contacts',
            $results,
            "Unable to find by updated username!"
        );
        self::assertEquals(
            $bean->id,
            $results['Contacts'][0],
            "Wrong ID retrieved"
        );

        // remove the bean...
        $this->indexer->removeBean($bean);

        $this->waitForIndexing();

        // make a search query for the deleted bean
        $results = SearchWrapper::search(
            $this->searchEngine,
            SearchQuery::fromString($full_name_update, 1)
        );

        self::assertEmpty($results->getHits(), "The deleted bean should not have been found!");
    }

    /**
     * The indexing on Elasticsearch is scheduled each second.
     * No results will be available before that time.
     **/
    private function waitForIndexing()
    {
        sleep(1);
    }

    public function testWithSearchdefs()
    {
        $this->indexer->setDocumentifier(new SearchDefsDocumentifier());

        $this->indexRunner();
    }

    public function testDifferentialIndexing()
    {
        global $timedate;
        $timedate->allow_cache = false;

        $module = 'Contacts';
        /** @var Contact $bean */
        $bean = BeanFactory::newBean($module);

        // Setting up the indexer
        $this->indexer->setDifferentialIndexing(true);
        $this->indexer->setModulesToIndex([$bean->module_name]);

        // Set up the search engine

        $this->populateContactsTable();

        // DO THE THING
        // Remove the lock file to perform a full index
        if (file_exists(self::LOCK_FILE)) {
            unlink(self::LOCK_FILE);
        }
        // Perform a full search
        $this->indexer->index();
        // Make sure that just one module has been indexed
        $actual = $this->indexer->getIndexedModulesCount();
        self::assertEquals(1, $actual, "Only one module [$module] should have been indexed.");

        // Create a new record in the module
        $firstName = 'Some';
        $lastName = 'Person' . uniqid();

        $this->waitForIndexing(); // precision is down to the second

        $bean->first_name = $firstName;
        $bean->last_name = $lastName;

        $bean->save();

        $id = $bean->id;

        // Run another differential index

        $this->indexer->index();

        // Make sure that one and only one record has been updated;
        $actual = $this->indexer->getIndexedRecordsCount();
        self::assertEquals(1, $actual, "Only one record should have been updated");

        // Perform a search to see if the new record can be found
        // As usual, wait for Elasticsearch to do its magic
        $this->waitForIndexing();
        $results = SearchWrapper::search(
            $this->searchEngine,
            SearchQuery::fromString("$firstName AND $lastName", 1)
        )->getHits();

        self::assertArrayHasKey($module, $results, "No results found");
        self::assertContains($id, $results[$module], "Records not found");

        // Now try to fetch the bean again, edit it and save, and mark as deleted
        $bean = BeanFactory::getBean($module, $id);
        $bean->first_name = 'Same';
        $bean->save();
        $bean->mark_deleted($id);

        // Make another beam
        /** @var Contact $bean2 */
        $bean2 = BeanFactory::getBean($module);
        $firstName2 = 'NotTheSame';
        $bean2->first_name = $firstName2;
        $bean2->last_name = $lastName;

        $bean2->save();
        $id2 = $bean2->id;

        // Perform a differential indexing
        $this->indexer->index();

        // Assert that only one (bean2) has been indexed...
        $actual = $this->indexer->getIndexedRecordsCount();
        self::assertEquals(1, $actual, 'Wrong count of indexed beans');

        // ...and that the right number of beans has been un-indexed
        $actual = $this->indexer->getRemovedRecordsCount();
        self::assertEquals(1, $actual, 'Wrong count for un-indexed beans');

        $this->waitForIndexing();
        $results = SearchWrapper::search(
            $this->searchEngine,
            SearchQuery::fromString("$firstName2 AND $lastName", 1)
        )->getHits();

        self::assertArrayHasKey($module, $results, 'Wrong count of indexed beans');
        self::assertContains($id2, $results[$module], 'Wrong ID found');

        $results = SearchWrapper::search($this->searchEngine, SearchQuery::fromString("$firstName AND $lastName", 1));
        self::assertEmpty($results->getHits(), 'There should be no search results, as the record was deleted');
    }

    private function populateContactsTable()
    {
        /** @var Contact $bean */
        $bean = BeanFactory::newBean('Contacts');
        $bean->first_name = 'Test';
        $bean->last_name = 'Person';

        $sql = DBManagerFactory::getInstance()->truncateTableSQL($bean->table_name);
        DBManagerFactory::getInstance()->query($sql);

        $bean->save();
    }

    public function testMeta()
    {
        $module = "TestModule";
        $meta1 = ['foo' => 'baz'];
        $meta2 = ['foz' => 'bar'];

        $this->indexer->createIndex('test');
        $this->indexer->putMeta($module, $meta1);
        $actual = $this->indexer->getMeta($module);

        self::assertEquals($meta1, $actual);

        $this->indexer->putMeta($module, $meta2);
        $actual = $this->indexer->getMeta($module);

        self::assertEquals($meta2, $actual);
    }
}
