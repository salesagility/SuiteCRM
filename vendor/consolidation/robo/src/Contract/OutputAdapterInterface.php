<?php

namespace Robo\Contract;

/**
 * Adapt OutputInterface or other output function to the VerbosityThresholdInterface.
 */
interface OutputAdapterInterface
{
    /**
     * @param int $verbosityThreshold
     *
     * @return bool
     */
    public function verbosityMeetsThreshold($verbosityThreshold);

    /**
     * @param string $message
     */
    public function writeMessage($message);
}
