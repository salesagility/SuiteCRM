<?php

namespace SuiteCRM\Search;

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
        MasterSearch::addEngine('TestSearchEngine', 'tests/unit/lib/SuiteCRM/Search/TestSearchEngine.php');

        $result = MasterSearch::searchAndView('TestSearchEngine', new SearchQuery(['searchstring' => 'foo']));

        self::assertEquals('bar', $result, "Wrong mocked search result!");

        $result = MasterSearch::searchAndView('TestSearchEngine', new SearchQuery(['searchstring' => 'fooz']));

        self::assertEquals('barz', $result, "Wrong mocked search result!");
    }

}
