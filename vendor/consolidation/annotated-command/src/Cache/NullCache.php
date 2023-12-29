<?php
namespace Consolidation\AnnotatedCommand\Cache;

/**
 * An empty cache that never stores or fetches any objects.
 */
class NullCache implements SimpleCacheInterface
{
    /**
     * Test for an entry from the cache
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return false;
    }

    /**
     * Get an entry from the cache
     * @param string $key
     * @return array
     */
    public function get($key)
    {
        return [];
    }

    /**
     * Store an entry in the cache
     * @param string $key
     * @param array $data
     */
    public function set($key, $data)
    {
    }
}
