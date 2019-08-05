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

use SuiteCRM\Search\ElasticSearch\ElasticSearchClientBuilder;
use SuiteCRM\Search\SearchTestAbstract;
use SuiteCRM\StateSaver;

class ElasticSearchClientBuilderTest extends SearchTestAbstract
{
    public function testGetClient()
    {
        $client = ElasticSearchClientBuilder::getClient();

        self::assertInstanceOf(\Elasticsearch\Client::class, $client);
    }

    public function testLoadConfig()
    {
        $builder = new ElasticSearchClientBuilder();
        $config = self::invokeMethod($builder, 'loadFromFile', [__DIR__ . '/TestData/ElasticsearchServerConfig.json']);
        $expected = [
            [
                'host' => 'foo.com',
                'port' => '9200',
                'scheme' => 'https',
                'user' => 'username',
                'pass' => 'password!#$?*abc'
            ],
            [
                'host' => 'localhost'
            ]
        ];

        self::assertEquals($expected, $config);
    }

    // Tests if the default configs are returned when the config file is not found
    public function testLoadConfigFileNotThere()
    {
        $builder = new ElasticSearchClientBuilder();
        $config = self::invokeMethod($builder, 'loadFromFile', [__DIR__ . '/TestData/NopeNotHere.json']);
        $expected = [
            ['host' => '127.0.0.1']
        ];

        self::assertEquals($expected, $config);
    }

    public function testLoadSugarConfig()
    {
        global $sugar_config;

        $stateSave = new StateSaver();
        $stateSave->pushGlobals();

        $sugar_config['search']['ElasticSearch']['host'] = '127.0.0.1';
        $sugar_config['search']['ElasticSearch']['user'] = 'foo';
        $sugar_config['search']['ElasticSearch']['pass'] = 'bar';

        $actual = $this->loadFromSugarConfig();
        $expected = [
            [
                'host' => '127.0.0.1',
                'user' => 'foo',
                'pass' => 'bar'
            ]
        ];

        self::assertEquals($expected, $actual);

        $stateSave->popGlobals();
    }

    public function testLoadSugarConfig2()
    {
        global $sugar_config;

        $stateSave = new StateSaver();
        $stateSave->pushGlobals();

        $sugar_config['search']['ElasticSearch']['host'] = 'localhost';
        $sugar_config['search']['ElasticSearch']['user'] = 'bar';
        $sugar_config['search']['ElasticSearch']['pass'] = '';

        $actual = $this->loadFromSugarConfig();
        $expected = [
            [
                'host' => 'localhost',
                'user' => 'bar',
                'pass' => ''
            ]
        ];

        self::assertEquals($expected, $actual);

        $stateSave->popGlobals();
    }

    public function testLoadSugarConfig3()
    {
        global $sugar_config;

        $stateSave = new StateSaver();
        $stateSave->pushGlobals();

        $sugar_config['search']['ElasticSearch']['host'] = 'www.example.com';
        $sugar_config['search']['ElasticSearch']['user'] = '';
        $sugar_config['search']['ElasticSearch']['pass'] = '';

        $actual = $this->loadFromSugarConfig();

        $expected = [
            ['host' => 'www.example.com']
        ];

        self::assertEquals($expected, $actual);

        $stateSave->popGlobals();
    }

    private function loadFromSugarConfig()
    {
        $builder = new ElasticSearchClientBuilder();
        return self::invokeMethod($builder, 'loadFromSugarConfig');
    }

    private function sanitizeHost(array $host)
    {
        $builder = new ElasticSearchClientBuilder();
        return self::invokeMethod($builder, 'sanitizeHost', [$host]);
    }

    public function testUrlParser1()
    {
        $data = [
            'host' => 'www.example.com'
        ];

        $expected = [
            'host' => 'www.example.com'
        ];

        $actual = $this->sanitizeHost($data);

        self::assertEquals($expected, $actual);
    }

    public function testUrlParser2()
    {
        $data = [
            'host' => 'https://www.example.com',
            'user' => 'foo'
        ];

        $expected = [
            'host' => 'www.example.com',
            'user' => 'foo',
            'scheme' => 'https'
        ];

        $actual = $this->sanitizeHost($data);

        self::assertEquals($expected, $actual);
    }

    public function testUrlParser3()
    {
        $data = [
            'host' => 'https://www.example.com:42',
            'user' => 'foo',
            'pass' => 'bar'
        ];

        $expected = [
            'host' => 'www.example.com',
            'user' => 'foo',
            'pass' => 'bar',
            'scheme' => 'https',
            'port' => 42
        ];

        $actual = $this->sanitizeHost($data);

        self::assertEquals($expected, $actual);
    }

    public function testUrlParser4()
    {
        $data = [
            'host' => 'bar:pass@mydomain.server.com:9201',
            'user' => 'foo',
        ];

        $expected = [
            'host' => 'mydomain.server.com',
            'user' => 'bar',
            'pass' => 'pass',
            'port' => 9201
        ];

        $actual = $this->sanitizeHost($data);

        self::assertEquals($expected, $actual);
    }

    public function testUrlParser5()
    {
        $data = [
            'user' => 'foo',
        ];

        try {
            $this->sanitizeHost($data);
        } catch (InvalidArgumentException $e) {
            return;
        }

        $this->fail('Exception not thrown!');
    }

    public function testUrlParser6()
    {
        $data = [
            'host' => 0.5,
            'user' => 'foo',
        ];

        try {
            $this->sanitizeHost($data);
        } catch (InvalidArgumentException $e) {
            return;
        }
    }

    public function testUrlParserBadUrls()
    {
        $url1 = ['host' => 'http:///example.com'];
        $url2 = ['host' => 'http://:80'];
        $url3 = ['host' => 'http://user@:80'];

        try {
            $this->sanitizeHost($url1);
            $this->fail('Exception not thrown!');
        } catch (InvalidArgumentException $e) {
        }

        try {
            $this->sanitizeHost($url2);
            $this->fail('Exception not thrown!');
        } catch (InvalidArgumentException $e) {
        }

        try {
            $this->sanitizeHost($url3);
            $this->fail('Exception not thrown!');
        } catch (InvalidArgumentException $e) {
        }
    }
}
