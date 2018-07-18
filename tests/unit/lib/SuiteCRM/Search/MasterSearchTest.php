<?php

namespace SuiteCRM\Search;

use Mockery;
use ReflectionException;
use RuntimeException;

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 21/06/18
 * Time: 16:48
 */
class MasterSearchTest extends SearchTestAbstract
{

    public function testFetchEngine()
    {
        $search = new MasterSearch();

        try {
            $SearchEngine = $this->invokeMethod($search, 'fetchEngine', ['ElasticSearchEngine']);
            $this->assertInstanceOf('ElasticSearchEngine', $SearchEngine);
        } catch (ReflectionException $e) {
            $this->fail("Failed to use reflection!");
        }

    }

    public function testFetchNonExistingEngine()
    {
        $search = new MasterSearch();

        try {
            $this->invokeMethod($search, 'fetchEngine', ['VeryFakeEngine']);
            $this->fail("Exception should be thrown here!");
        } catch (ReflectionException $e) {
            $this->fail("Failed to use reflection!");
        } catch (RuntimeException $e) {
            // All good!
        }
    }

    public function testFakeSearch()
    {
        MasterSearch::addEngine('SearchEngineMock', 'tests/unit/lib/SuiteCRM/Search/SearchEngineMock.php');

        $result = MasterSearch::searchAndView('SearchEngineMock', new SearchQuery(['searchstring' => 'foo']));

        self::assertEquals('bar', $result, "Wrong mocked search result!");

        $result = MasterSearch::searchAndView('SearchEngineMock', new SearchQuery(['searchstring' => 'fooz']));

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

        MasterSearch::search($mockEngine, $query);

        Mockery::close();
    }

    public function testSearch3()
    {
        // this time check if the validation works

        $mockEngine = Mockery::mock(MasterSearch::class); // just an object that shouldn't be passed
        $query = SearchQuery::fromString("Test");

        try {
            MasterSearch::search($mockEngine, $query);
            self::fail("Exception should have been thrown!");
        } catch (\InvalidArgumentException $e) {
            // All good!
        }

        Mockery::close();
    }


}
