<?php
/** @noinspection PhpMethodParametersCountMismatchInspection */
/** @noinspection PhpUnhandledExceptionInspection */

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

use Mockery as m;
use SuiteCRM\Search\ElasticSearch\ElasticSearchIndexer;
use SuiteCRM\Search\ElasticSearch\ElasticSearchIndexer as i;
use SuiteCRM\Utility\BeanJsonSerializerTestData\SaltBean;

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 22/06/18
 * Time: 12:37
 */
class ElasticSearchIndexerTest extends SuiteCRM\Search\SearchTestAbstract
{
    public function testGetModulesToIndex()
    {
        $indexer = new ElasticSearchIndexer();

        $modules = $indexer->getModulesToIndex();

        self::assertTrue(is_array($modules), "Result is not an array.");

        self::assertTrue(count($modules) > 0, "The array is empty.");

        self::assertTrue(in_array('Contacts', $modules), "Contacts was not found in the list of modules to index");
    }

    public function testIndexBeans()
    {
        $client = m::mock('\Elasticsearch\Client');

        $client
            ->shouldReceive('bulk')
            ->times(5);

        $mockedModule = 'MockedModule';

        $mockedBeans = [
            (object)array("id" => 1, "fetched_row" => ['name' => 'name 1'], "fetched_rel_row" => [], "deleted" => false, "module_name" => $mockedModule),
            (object)array("id" => 2, "fetched_row" => ['name' => 'name 2'], "fetched_rel_row" => [], "deleted" => false, "module_name" => $mockedModule),
            (object)array("id" => 3, "fetched_row" => ['name' => 'name 3'], "fetched_rel_row" => [], "deleted" => false, "module_name" => $mockedModule),
            (object)array("id" => 4, "fetched_row" => ['name' => 'name 4'], "fetched_rel_row" => [], "deleted" => false, "module_name" => $mockedModule),
            (object)array("id" => 5, "fetched_row" => ['name' => 'name 5'], "fetched_rel_row" => [], "deleted" => false, "module_name" => $mockedModule),
            (object)array("id" => 6, "fetched_row" => ['name' => 'name 6'], "fetched_rel_row" => [], "deleted" => true, "module_name" => $mockedModule),
            (object)array("id" => 7, "fetched_row" => ['name' => 'name 7', "opt" => 'ciao'], "fetched_rel_row" => [], "deleted" => false, "module_name" => $mockedModule),
            (object)array("id" => 8, "fetched_row" => ['name' => 'name 8', "opt" => 'ciao'], "fetched_rel_row" => [], "deleted" => false, "module_name" => $mockedModule),
        ];

        $i = new i($client);

        $i->setBatchSize(2);

        $i->indexBeans($mockedModule, $mockedBeans);

        self::assertEquals(1, $i->getRemovedRecordsCount());
        self::assertEquals(7, $i->getIndexedRecordsCount());
        self::assertEquals(9, $i->getIndexedFieldsCount());
    }

    public function testGettersAndSetters()
    {
        $batchSize = 20;
        $index = 'test1';
        $i = new i();

        $i->setBatchSize($batchSize);
        $i->setIndexName($index);
        self::assertEquals($batchSize, $i->getBatchSize());
        self::assertEquals($index, $i->getIndexName());

        $i = new i();
        $batchSize = 50;
        $index = 'test2';

        $i->setBatchSize($batchSize);
        $i->setIndexName($index);
        self::assertEquals($batchSize, $i->getBatchSize());
        self::assertEquals($index, $i->getIndexName());
    }

    public function testIndexBean()
    {
        $bean = $this->getTestBean();
        $client = m::mock('\Elasticsearch\Client');

        $client
            ->shouldReceive('index')
            ->once();

        $indexer = new ElasticSearchIndexer($client);

        $indexer->indexBean($bean);
    }

    /**
     * @return SugarBean
     */
    private function getTestBean()
    {
        /** @var SugarBean $bean */
        $bean = new SaltBean('Contacts', __DIR__ . '/../../Utility/BeanJsonSerializerTestData/ContactBean.json');
        return $bean;
    }

    public function testMakeIndexParamsFromBean()
    {
        $bean = $this->getTestBean();
        $expected = $this->getExpectedHeader();
        $expected['body'] = $this->getExpectedBody();

        $indexer = new ElasticSearchIndexer();

        $actual = self::invokeMethod($indexer, 'makeIndexParamsFromBean', [$bean]);

        self::assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    private function getExpectedHeader()
    {
        $expected = [
            'index' => 'main',
            'type' => 'Contacts',
            'id' => '00000000-0000-0000-0000-000000000000',
        ];
        return $expected;
    }

    /**
     * @return array
     */
    private function getExpectedBody()
    {
        $expected = [
            'meta' =>
                [
                    'created' =>
                        [
                            'date' => '2018-06-12 11:01:34',
                            'user_id' => '1',
                            'user_name' => 'Administrator',
                        ],
                    'modified' =>
                        [
                            'date' => '2018-06-12 11:01:34',
                            'user_id' => '1',
                            'user_name' => 'Administrator',
                        ],
                    'assigned' =>
                        [
                            'user_id' => 'seed_max_id',
                            'user_name' => 'Max Jensen',
                        ],
                ],
            'name' =>
                [
                    'salutation' => 'Ms.',
                    'first' => 'Cindy',
                    'last' => 'Espana',
                ],
            'account' =>
                [
                    'title' => 'Director Operations',
                    'department' => 'Genetics',
                    'name' => 'Start Over Trust',
                    'id' => '39363e96-5eed-0221-9889-5b1fa86ebb52',
                ],
            'phone' =>
                [
                    'home' => '4451633872',
                    'mobile' => '9788363300',
                    'work' => '7111123512',
                ],
            'address' =>
                [
                    'primary' =>
                        [
                            'street' => '345 Sugar Blvd.',
                            'city' => 'Salt Lake City',
                            'state' => 'CA',
                            'postalcode' => '58821',
                            'country' => 'USA',
                        ],
                ],
            'lead_source' => 'Web Site',
            'email' =>
                [
                    0 => 'kid79@example.co.jp',
                ],
        ];
        return $expected;
    }

    public function testMakeIndexParamsBodyFromBean1()
    {
        $bean = $this->getTestBean();
        $indexer = new ElasticSearchIndexer();
        $expected = $this->getExpectedBody();

        $actual = self::invokeMethod($indexer, 'makeIndexParamsBodyFromBean', [$bean]);
        self::assertEquals($expected, $actual);
    }

    public function testMakeIndexParamsBodyFromBean2()
    {
        self::markTestIncomplete("TODO");
    }

    public function testRemoveBeans()
    {
        $mock = m::mock('Elasticsearch\Client');
        $beans = [$this->getTestBean(), $this->getTestBean()];

        $params = [
            'client' => [
                'ignore' => [404],
            ],
            'body' => [
                ['delete' => ['index' => 'main', 'type' => 'Contacts', 'id' => '00000000-0000-0000-0000-000000000000',]],
                ['delete' => ['index' => 'main', 'type' => 'Contacts', 'id' => '00000000-0000-0000-0000-000000000000',]],
            ]
        ];

        $mock
            ->shouldReceive('bulk')
            ->once()
            ->with($params);

        $indexer = new ElasticSearchIndexer($mock);

        $indexer->removeBeans($beans, true);
    }

    public function testRemoveBean()
    {
        $mock = m::mock('Elasticsearch\Client');
        $bean = $this->getTestBean();

        $params = [
            'index' => 'main',
            'type' => 'Contacts',
            'id' => '00000000-0000-0000-0000-000000000000',
        ];

        $mock
            ->shouldReceive('delete')
            ->once()
            ->with($params);

        $indexer = new ElasticSearchIndexer($mock);

        $indexer->removeBean($bean);
    }

    public function testMakeParamsHeaderFromBean()
    {
        /** @var SugarBean $bean */
        $bean = $this->getTestBean();
        $expected = $this->getExpectedHeader();

        $indexer = new ElasticSearchIndexer();

        $actual = self::invokeMethod($indexer, 'makeParamsHeaderFromBean', [$bean]);

        self::assertEquals($expected, $actual);
    }

    public function testRemoveIndex()
    {
        list($mockClient, $mockIndices) = $this->getMockIndices();

        $mockIndices
            ->shouldReceive('delete')
            ->once()
            ->with(['index' => 'main', 'client' => ['ignore' => [404]]]);

        $indexer = new ElasticSearchIndexer($mockClient);

        $indexer->removeIndex();
    }

    /**
     * @return array
     */
    public function getMockIndices()
    {
        $mockClient = m::mock('Elasticsearch\Client');
        $mockIndices = m::mock('Elasticsearch\Namespaces\IndicesNamespace');

        $mockClient
            ->shouldReceive('indices')
            ->once()
            ->withNoArgs()
            ->andReturn($mockIndices);
        return [$mockClient, $mockIndices];
    }

    public function testRemoveIndex2()
    {
        $index = uniqid();
        list($mockClient, $mockIndices) = $this->getMockIndices();

        $mockIndices
            ->shouldReceive('delete')
            ->once()
            ->with(['index' => $index, 'client' => ['ignore' => [404]]]);

        $indexer = new ElasticSearchIndexer($mockClient);
        $indexer->removeIndex($index);
    }

    public function testDeleteAllIndexes()
    {
        list($mockClient, $mockIndices) = $this->getMockIndices();

        $mockIndices
            ->shouldReceive('delete')
            ->once()
            ->with(['index' => '_all']);

        $indexer = new ElasticSearchIndexer($mockClient);
        $indexer->removeAllIndices();
    }

    public function testDeleteAllIndexes2()
    {
        list($mockClient, $mockIndices) = $this->getMockIndices();

        $mockIndices
            ->shouldReceive('delete')
            ->once()
            ->with(['index' => '_all'])
            ->andThrow('\Elasticsearch\Common\Exceptions\Missing404Exception');

        $indexer = new ElasticSearchIndexer($mockClient);
        $indexer->removeAllIndices();

        // no exception should appear here, as the 404 has to be caught.
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }
}
