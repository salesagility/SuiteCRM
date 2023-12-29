<?php

namespace Robo\Contract;

/**
 * Any Robo task that uses the Timer trait and
 * implements ProgressIndicatorAwareInterface will
 * display a progress bar while the timer is running.
 * Call advanceProgressIndicator to advance the indicator.
 *
 * Interface ProgressIndicatorAwareInterface
 * @package Robo\Contract
 */
interface ProgressIndicatorAwareInterface
{
    /**
     * @return int
     */
    public function progressIndicatorSteps();

    /**
     * @param \Robo\Common\ProgressIndicator $progressIndicator
     */
    public function setProgressIndicator($progressIndicator);
}
