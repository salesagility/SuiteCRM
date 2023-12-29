<?php
namespace Consolidation\AnnotatedCommand\Cache;

/**
 * Make a generic cache object conform to our expected interface.
 */
class CacheWrapper implements SimpleCacheInterface
{
    protected $dataStore;

    public function __construct($dataStore)
    {
        $this->dataStore = $dataStore;
    }

    /**
     * Test for an entry from the cache
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        if (method_exists($this->dataStore, 'has')) {
            return $this->dataStore->has($key);
        }
        $test = $this->dataStore->get($key);
        return !empty($test);
    }

    /**
     * Get an entry from the cache
     * @param string $key
     * @return array
     */
    public function get($key)
    {
        return (array) $this->dataStore->get($key);
    }

    /**
     * Store an entry in the cache
     * @param string $key
     * @param array $data
     */
    public function set($key, $data)
    {
        $this->dataStore->set($key, $data);
    }
}
