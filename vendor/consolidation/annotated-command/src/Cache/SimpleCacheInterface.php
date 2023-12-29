<?php
namespace Consolidation\AnnotatedCommand\Cache;

/**
 * Documentation interface.
 *
 * Clients that use AnnotatedCommandFactory::setDataStore()
 * are encouraged to provide a data store that implements
 * this interface.
 *
 * This is not currently required to allow clients to use a generic cache
 * store that does not itself depend on the annotated-command library.
 * This might be required in a future version.
 */
interface SimpleCacheInterface
{
    /**
     * Test for an entry from the cache
     * @param string $key
     * @return boolean
     */
    public function has($key);
    /**
     * Get an entry from the cache
     * @param string $key
     * @return array
     */
    public function get($key);
    /**
     * Store an entry in the cache
     * @param string $key
     * @param array $data
     */
    public function set($key, $data);
}
