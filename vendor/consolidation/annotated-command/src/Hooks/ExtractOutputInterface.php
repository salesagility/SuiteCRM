<?php
namespace Consolidation\AnnotatedCommand\Hooks;

/**
 * Extract Output hooks are used to select the particular
 * data elements of the result that should be printed as
 * the command output -- perhaps after being formatted.
 *
 * @see HookManager::addOutputExtractor()
 */
interface ExtractOutputInterface
{
    public function extractOutput($result);
}
