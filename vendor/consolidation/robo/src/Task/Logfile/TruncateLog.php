<?php

namespace Robo\Task\Logfile;

use Robo\Result;

/**
 * Truncates a log (or any other) file
 *
 * ``` php
 * <?php
 * $this->taskTruncateLog(['logfile.log'])->run();
 * // or use shortcut
 * $this->_truncateLog(['logfile.log']);
 *
 * ?>
 * ```
 */
class TruncateLog extends BaseLogfile
{
    /**
     * {@inheritdoc}
     */
    public function run(): Result
    {
        foreach ($this->logfiles as $logfile) {
            $this->filesystem->dumpFile($logfile, false);
            if ($this->chmod) {
                $this->filesystem->chmod($logfile, $this->chmod);
            }
            $this->printTaskInfo("Truncated {logfile}", ['logfile' => $logfile]);
        }

        return Result::success($this);
    }
}
