<?php
namespace Consolidation\AnnotatedCommand;

/**
 * Return a CommandError as the result of a command to pass a status
 * code and error message to be displayed.
 *
 * @package Consolidation\AnnotatedCommand
 */
class CommandError implements ExitCodeInterface, OutputDataInterface
{
    protected $message;
    protected $exitCode;

    public function __construct($message = null, $exitCode = 1)
    {
        $this->message = $message;
        // Ensure the exit code is non-zero. The exit code may have
        // come from an exception, and those often default to zero if
        // a specific value is not provided.
        $this->exitCode = $exitCode == 0 ? 1 : $exitCode;
    }
    public function getExitCode()
    {
        return $this->exitCode;
    }

    public function getOutputData()
    {
        return $this->message;
    }
}
