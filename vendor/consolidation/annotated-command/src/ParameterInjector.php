<?php
namespace Consolidation\AnnotatedCommand;

/**
 * Provide an object for the specified interface or class name.
 */
interface ParameterInjector
{
    public function get(CommandData $commandData, $interfaceName);
}
