<?php

namespace Robo\Contract;

use Robo\Contract\OutputAdapterInterface;

/**
 * Record and determine whether the current verbosity level exceeds the
 * desired threshold level to produce output.
 */
interface VerbosityThresholdInterface
{
    const VERBOSITY_NORMAL = 1;
    const VERBOSITY_VERBOSE = 2;
    const VERBOSITY_VERY_VERBOSE = 3;
    const VERBOSITY_DEBUG = 4;

    /**
     * @param int $verbosityThreshold
     *
     * @return $this
     */
    public function setVerbosityThreshold($verbosityThreshold);

    /**
     * @return int
     */
    public function verbosityThreshold();

    /**
     * @param \Robo\Contract\OutputAdapterInterface $outputAdapter
     */
    public function setOutputAdapter(OutputAdapterInterface $outputAdapter);

    /**
     * @return \Robo\Contract\OutputAdapterInterface
     */
    public function outputAdapter();

    /**
     * @return bool
     */
    public function hasOutputAdapter();

    /**
     * @return int
     */
    public function verbosityMeetsThreshold();

    /**
     * @param string $message
     */
    public function writeMessage($message);
}
