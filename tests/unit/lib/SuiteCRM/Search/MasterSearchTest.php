<?php
/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 21/06/18
 * Time: 16:48
 */

use SuiteCRM\Search\MasterSearch;

class MasterSearchTest extends \SuiteCRM\Search\SearchTestAbstract
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

}
