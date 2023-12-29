<?php

namespace Robo\Log;

use Consolidation\Log\Logger;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Robo's default logger
 */
class RoboLogger extends Logger
{
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        // In Robo, we use log level 'notice' for messages that appear all
        // the time, and 'info' for messages that appear only during verbose
        // output. We have no 'very verbose' (-vv) level. 'Debug' is -vvv, as usual.
        $roboVerbosityOverrides = [
            RoboLogLevel::SIMULATED_ACTION => OutputInterface::VERBOSITY_NORMAL, // Default is "verbose"
            LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL, // Default is "verbose"
            LogLevel::INFO => OutputInterface::VERBOSITY_VERBOSE, // Default is "very verbose"
        ];
        parent::__construct($output, $roboVerbosityOverrides);
    }
}
