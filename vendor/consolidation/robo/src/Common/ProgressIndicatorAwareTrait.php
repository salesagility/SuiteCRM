<?php

namespace Robo\Common;

use Robo\Contract\ProgressIndicatorAwareInterface;
use Robo\Contract\VerbosityThresholdInterface;

trait ProgressIndicatorAwareTrait
{
    use Timer;

    /**
     * @var null|\Robo\Common\ProgressIndicator
     */
    protected $progressIndicator;

    /**
     * @return int
     */
    public function progressIndicatorSteps()
    {
        return 0;
    }

    /**
     * @param null|\Robo\Common\ProgressIndicator $progressIndicator
     *
     * @return $this
     */
    public function setProgressIndicator($progressIndicator)
    {
        $this->progressIndicator = $progressIndicator;

        return $this;
    }

    /**
     * @return null|bool
     */
    protected function hideProgressIndicator()
    {
        if (!$this->progressIndicator) {
            return;
        }
        return $this->progressIndicator->hideProgressIndicator();
    }

    protected function showProgressIndicator()
    {
        if (!$this->progressIndicator) {
            return;
        }
        $this->progressIndicator->showProgressIndicator();
    }

    /**
     * @param bool $visible
     */
    protected function restoreProgressIndicator($visible)
    {
        if (!$this->progressIndicator) {
            return;
        }
        $this->progressIndicator->restoreProgressIndicator($visible);
    }

    /**
     * @return int
     */
    protected function getTotalExecutionTime()
    {
        if (!$this->progressIndicator) {
            return 0;
        }
        return $this->progressIndicator->getExecutionTime();
    }

    protected function startProgressIndicator()
    {
        $this->startTimer();
        if ($this instanceof VerbosityThresholdInterface
            && !$this->verbosityMeetsThreshold()
        ) {
            return;
        }
        if (!$this->progressIndicator) {
            return;
        }
        $totalSteps = $this->progressIndicatorSteps();
        $this->progressIndicator->startProgressIndicator($totalSteps, $this);
    }

    /**
     * @return bool
     */
    protected function inProgress()
    {
        if (!$this->progressIndicator) {
            return false;
        }
        return $this->progressIndicator->inProgress();
    }

    protected function stopProgressIndicator()
    {
        $this->stopTimer();
        if (!$this->progressIndicator) {
            return;
        }
        $this->progressIndicator->stopProgressIndicator($this);
    }

    protected function disableProgressIndicator()
    {
        $this->stopTimer();
        if (!$this->progressIndicator) {
            return;
        }
        $this->progressIndicator->disableProgressIndicator();
    }

    protected function detatchProgressIndicator()
    {
        $this->setProgressIndicator(null);
    }

    /**
     * @param int $steps
     */
    protected function advanceProgressIndicator($steps = 1)
    {
        if (!$this->progressIndicator) {
            return;
        }
        $this->progressIndicator->advanceProgressIndicator($steps);
    }
}
