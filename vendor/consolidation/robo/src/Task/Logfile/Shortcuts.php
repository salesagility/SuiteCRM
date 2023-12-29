<?php

namespace Robo\Task\Logfile;

use Robo\Result;

trait Shortcuts
{
    /**
     * @param string|string[] $logfile
     *
     * @return \Robo\Result
     */
    protected function _rotateLog($logfile): Result
    {
        return $this->taskRotateLog($logfile)->run();
    }

    /**
     * @param string|string[] $logfile
     *
     * @return \Robo\Result
     */
    protected function _truncateLog($logfile): Result
    {
        return $this->taskTruncateLog($logfile)->run();
    }
}
