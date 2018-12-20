<?php

/** @noinspection PhpUnhandledExceptionInspection */

namespace SuiteCRM\Search;

use Mockery;
use ReflectionException;
use SuiteCRM\Search\Exceptions\SearchEngineNotFoundException;
use SuiteCRM\StateSaver;

/**
 * Class SearchWrapperTest
 *
 * @see SearchWrapper
 */
class SearchWrapperTest extends SearchTestAbstract
{
    public function testFetchEngine()
    {
        $search = new SearchWrapper();

        try {
            $searchEngine = $this->invokeMethod($search, 'fetchEngine', ['ElasticSearchEngine']);
            $this->assertInstanceOf('ElasticSearchEngine', $searchEngine);
        } catch (ReflectionException $exception) {
            $this->fail("Failed to use reflection!");
        }
    }

    public function testFetchEngineNonExisting()
    {
        $search = new SearchWrapper();
        $this->setValue($search, 'customEnginePath', __DIR__ . '/TestCustomEngines/');

        try {
            $this->invokeMethod($search, 'fetchEngine', ['VeryFakeEngine']);
            $this->fail("Exception should be thrown here!");
        } catch (ReflectionException $exception) {
            $this->fail("Failed to use reflection!");
        } catch (SearchEngineNotFoundException $exception) {
            // All good!
        }
    }

    public function testFetchEngineCustom()
    {
        $search = new SearchWrapper();
        $this->setValue($search, 'customEnginePath', __DIR__ . '/TestCustomEngines/');

        $engine = $this->invokeMethod($search, 'fetchEngine', ['MockSearch']);

        self::assertInstanceOf(SearchEngine::class, $engine);
    }

    public function testFetchEngineCustomBad()
    {
        $search = new SearchWrapper();
        $this->setValue($search, 'customEnginePath', __DIR__ . '/TestCustomEngines/');

        try {
            $this->invokeMethod($search, 'fetchEngine', ['BadMockSearch']);
            $this->fail("Exception should be thrown here!");
        } catch (SearchEngineNotFoundException $exception) {
            echo $exception->getMessage();
        }
    }

    public function testGetEngines()
    {
        $expected = [
            0 => 'ElasticSearchEngine',
            1 => 'BadMockSearch',
            2 => 'MockSearch',
        ];
        $actual = SearchWrapper::getEngines();

        self::assertEquals($actual, $expected);
    }

    public function testSearchAndDisplayCustom()
    {
        $search = new SearchWrapper();
        $this->setValue($search, 'customEnginePath', __DIR__ . '/TestCustomEngines/');

        $query = SearchQuery::fromString('bar', null, null, 'MockSearch');

        ob_start();
        $search::searchAndDisplay($query);
        $output = ob_get_flush();

        self::assertEquals('bar', $output);
    }

    public function testSearchAndDisplayBuiltIn()
    {
        SearchWrapper::addEngine('SearchEngineMock', __DIR__ . '/SearchEngineMock.php');

        $query = SearchQuery::fromString('foo', null, null, 'SearchEngineMock');

        ob_start();
        SearchWrapper::searchAndDisplay($query);
        $output = ob_get_flush();

        self::assertEquals('bar', $output);
    }

    public function testFakeSearch()
    {
        SearchWrapper::addEngine('SearchEngineMock', __DIR__ . '/SearchEngineMock.php');

        $result = SearchWrapper::search('SearchEngineMock', SearchQuery::fromString('foo'));

        self::assertEquals('bar', $result, "Wrong mocked search result!");

        $result = SearchWrapper::search('SearchEngineMock', SearchQuery::fromString('fooz'));

        self::assertEquals('barz', $result, "Wrong mocked search result!");
    }

    public function testSearch2()
    {
        // this time try passing a custom engine
        $mockEngine = Mockery::mock(SearchEngine::class);
        $query = SearchQuery::fromString("Test");

        $mockEngine
            ->shouldReceive('search')
            ->once()
            ->with($query);

        SearchWrapper::search($mockEngine, $query);

        Mockery::close();
    }

    public function testSearch3()
    {
        // this time check if the validation works

        $mockEngine = Mockery::mock(SearchWrapper::class); // just an object that shouldn't be passed
        $query = SearchQuery::fromString("Test");

        try {
            SearchWrapper::search($mockEngine, $query);
            self::fail("Exception should have been thrown!");
        } catch (SearchEngineNotFoundException $exception) {
            // All good!
        }

        Mockery::close();
    }

    public function testGetModules()
    {
        $actual = SearchWrapper::getModules();

        self::assertTrue(is_array($actual));
        self::assertGreaterThan(1, count($actual));
    }

    public function testGetDefaultEngine()
    {
        global $sugar_config;

        $saver = new StateSaver();

        $saver->pushGlobal('sugar_config');

        $sugar_config['search']['defaultEngine'] = 'foo';

        self::assertEquals('foo', SearchWrapper::getDefaultEngine());

        $saver->popGlobal('sugar_config');
    }

    public function testGetController()
    {
        global $sugar_config;

        $saver = new StateSaver();

        $saver->pushGlobal('sugar_config');

        $sugar_config['search']['controller'] = 'foo';

        self::assertEquals('foo', SearchWrapper::getController());

        $saver->popGlobal('sugar_config');
    }
}
