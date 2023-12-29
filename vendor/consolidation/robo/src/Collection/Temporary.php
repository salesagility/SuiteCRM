<?php

namespace Robo\Collection;

/**
 * The temporary collection keeps track of the global collection of
 * temporary cleanup tasks in instances where temporary-generating
 * tasks are executed directly via their run() method, rather than
 * as part of a collection.
 *
 * In general, temporary-generating tasks should always be run in
 * a collection, as the cleanup functions registered with the
 * Temporary collection will not run until requested.
 *
 * Since the results could be undefined if cleanup functions were called
 * at arbitrary times during a program's execution, cleanup should only
 * be done immeidately prior to program termination, when there is no
 * danger of cleaning up after some unrelated task.
 *
 * An application need never use Temporary directly, save to
 * call Temporary::wrap() inside Tasks or Shortcuts, and
 * to call Temporary::complete() immediately prior to terminating.
 * This is recommended, but not required; this function will be
 * registered as a shutdown function, and called on termination.
 */
class Temporary
{

    /**
     * @var \Robo\Collection\Collection
     */
    private static $collection;

    /**
     * Provides direct access to the collection of temporaries, if necessary.
     *
     * @return \Robo\Collection\Collection
     */
    public static function getCollection()
    {
        if (!static::$collection) {
            static::$collection = \Robo\Robo::getContainer()->get('collection');
            register_shutdown_function(function () {
                static::complete();
            });
        }

        return static::$collection;
    }

    /**
     * Call the complete method of all of the registered objects.
     */
    public static function complete()
    {
        // Run the collection of tasks. This will also run the
        // completion tasks.
        $collection = static::getCollection();
        $collection->run();
        // Make sure that our completion functions do not run twice.
        $collection->reset();
    }
}
