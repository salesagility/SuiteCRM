<?php

namespace Robo\Common;

use Robo\Robo;
use Robo\TaskInfo;
use Robo\Contract\OutputAdapterInterface;
use Robo\Contract\VerbosityThresholdInterface;
use Consolidation\Log\ConsoleLogLevel;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;
use Robo\Contract\ProgressIndicatorAwareInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Task input/output methods.  TaskIO is 'used' in BaseTask, so any
 * task that extends this class has access to all of the methods here.
 * printTaskInfo, printTaskSuccess, and printTaskError are the three
 * primary output methods that tasks are encouraged to use.  Tasks should
 * avoid using the IO trait output methods.
 */
trait VerbosityThresholdTrait
{
    /**
     * @var \Robo\Contract\OutputAdapterInterface
     */
    protected $outputAdapter;

    /**
     * @var int
     */
    protected $verbosityThreshold = 0;

    /**
     * Required verbosity level before any TaskIO output will be produced.
     * e.g. OutputInterface::VERBOSITY_VERBOSE
     *
     * @param int $verbosityThreshold
     *
     * @return $this
     */
    public function setVerbosityThreshold($verbosityThreshold)
    {
        $this->verbosityThreshold = $verbosityThreshold;
        return $this;
    }

    /**
     * @return int
     */
    public function verbosityThreshold()
    {
        return $this->verbosityThreshold;
    }

    public function setOutputAdapter(OutputAdapterInterface $outputAdapter)
    {
        $this->outputAdapter = $outputAdapter;
    }

    /**
     * @return \Robo\Contract\OutputAdapterInterface
     */
    public function outputAdapter()
    {
        return $this->outputAdapter;
    }

    /**
     * @return bool
     */
    public function hasOutputAdapter()
    {
        return isset($this->outputAdapter);
    }

    /**
     * @return bool
     */
    public function verbosityMeetsThreshold()
    {
        if ($this->hasOutputAdapter()) {
            return $this->outputAdapter()->verbosityMeetsThreshold($this->verbosityThreshold());
        }
        return true;
    }

    /**
     * Print a message if the selected verbosity level is over this task's
     * verbosity threshold.
     *
     * @param string $message
     */
    public function writeMessage($message)
    {
        if (!$this->verbosityMeetsThreshold()) {
            return;
        }
        $this->outputAdapter()->writeMessage($message);
    }
}
