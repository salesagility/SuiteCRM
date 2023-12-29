<?php
namespace Consolidation\AnnotatedCommand;

/**
 * Return a CommandResult as the result of a command to pass both an exit
 * code and result data from a command.
 *
 * Usage:
 *
 *      return CommandResult::dataWithExitCode(new RowsOfFields($rows), 1);
 *
 * The CommandResult can also be used to unambiguously return just
 * an exit code or just output data.
 *
 * Exit code only:
 *
 *      return CommandResult::dataWithExitCode(1);
 *
 * Data only:
 *
 *      return CommandResult::data(new RowsOfFields($rows));
 *
 * Historically, it has always been possible to return an integer to indicate
 * that the result is an exit code, and other return types (typically array
 * / ArrayObjects) indicating actual data with an implicit exit code of 0.
 * Using a CommandResult is preferred, though, as it allows the result of the
 * function to be unambiguously specified without type-based interpretation.
 *
 * @package Consolidation\AnnotatedCommand
 */
class CommandResult implements ExitCodeInterface, OutputDataInterface
{
    protected $data;
    protected $exitCode;

    protected function __construct($data = null, $exitCode = 0)
    {
        $this->data = $data;
        $this->exitCode = $exitCode;
    }

    public static function exitCode($exitCode)
    {
        return new static(null, $exitCode);
    }

    public static function data($data)
    {
        return new static($data);
    }

    public static function dataWithExitCode($data, $exitCode)
    {
        return new static($data, $exitCode);
    }

    public function getExitCode()
    {
        return $this->exitCode;
    }

    public function getOutputData()
    {
        return $this->data;
    }

    public function setOutputData($data)
    {
        $this->data = $data;
    }
}
