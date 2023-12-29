<?php
namespace Consolidation\AnnotatedCommand\Hooks;

/**
 * A StatusDeterminer maps from a result to a status exit code.
 *
 * @deprecated. Instead of using a Status Determiner hook, commands
 * should simply return their exit code and result data separately
 * using a CommandResult object.
 *
 * @see HookManager::addStatusDeterminer()
 */
interface StatusDeterminerInterface
{
    /**
     * Convert a result object into a status code, if
     * possible. Return null if the result object is unknown.
     *
     * @return null|integer
     */
    public function determineStatusCode($result);
}
