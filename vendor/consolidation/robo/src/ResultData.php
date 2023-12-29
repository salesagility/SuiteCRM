<?php

namespace Robo;

use Consolidation\AnnotatedCommand\ExitCodeInterface;
use Consolidation\AnnotatedCommand\OutputDataInterface;
use Robo\State\Data;

class ResultData extends Data implements ExitCodeInterface, OutputDataInterface
{
    /**
     * @var int
     */
    protected $exitCode;

    const EXITCODE_OK = 0;
    const EXITCODE_ERROR = 1;
    /** Symfony Console handles these conditions; Robo returns the status
    code selected by Symfony. These are here for documentation purposes. */
    const EXITCODE_MISSING_OPTIONS = 2;
    const EXITCODE_COMMAND_NOT_FOUND = 127;

    /** The command was aborted because the user chose to cancel it at some prompt.
    This exit code is arbitrarily the same as EX_TEMPFAIL in sysexits.h, although
    note that shell error codes are distinct from C exit codes, so this alignment
    not particularly meaningful. */
    const EXITCODE_USER_CANCEL = 75;

    /**
     * @param int $exitCode
     * @param string $message
     * @param array $data
     */
    public function __construct($exitCode = self::EXITCODE_OK, $message = '', $data = [])
    {
        $this->exitCode = $exitCode;
        parent::__construct($message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     *
     * @return static
     */
    public static function message($message, $data = [])
    {
        return new self(self::EXITCODE_OK, $message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     *
     * @return static
     */
    public static function cancelled($message = '', $data = [])
    {
        return new ResultData(self::EXITCODE_USER_CANCEL, $message, $data);
    }

    /**
     * @return int
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * @return null|string
     */
    public function getOutputData()
    {
        if (!empty($this->message) && !isset($this['already-printed']) && isset($this['provide-outputdata'])) {
            return $this->message;
        }
    }

    /**
     * Indicate that the message in this data has already been displayed.
     */
    public function alreadyPrinted()
    {
        $this['already-printed'] = true;
    }

    /**
     * Opt-in to providing the result message as the output data
     */
    public function provideOutputdata()
    {
        $this['provide-outputdata'] = true;
    }

    /**
     * @return bool
     */
    public function wasSuccessful()
    {
        return $this->exitCode === self::EXITCODE_OK;
    }

    /**
     * @return bool
     */
    public function wasCancelled()
    {
        return $this->exitCode == self::EXITCODE_USER_CANCEL;
    }
}
