<?php

namespace Robo\Log;

class RoboLogLevel extends \Consolidation\Log\ConsoleLogLevel
{
    /**
     * Command did something in simulated mode.
     * Displayed at VERBOSITY_NORMAL.
     */
    const SIMULATED_ACTION = 'simulated';
}
