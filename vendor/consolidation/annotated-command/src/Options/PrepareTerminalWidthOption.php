<?php
namespace Consolidation\AnnotatedCommand\Options;

use Symfony\Component\Console\Application;
use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\OutputFormatters\Options\FormatterOptions;

class PrepareTerminalWidthOption implements PrepareFormatter
{
    /** var Application */
    protected $application;

    protected $terminal;

    /** var int */
    protected $defaultWidth;

    /** var int */
    protected $maxWidth = PHP_INT_MAX;

    /** var int */
    protected $minWidth = 0;

    /* var boolean */
    protected $shouldWrap = true;

    public function __construct($defaultWidth = 0)
    {
        $this->defaultWidth = $defaultWidth;
    }

    public function setApplication(Application $application)
    {
        $this->application = $application;
    }

    public function setTerminal($terminal)
    {
        $this->terminal = $terminal;
    }

    public function getTerminal()
    {
        if (!$this->terminal && class_exists('\Symfony\Component\Console\Terminal')) {
            $this->terminal = new \Symfony\Component\Console\Terminal();
        }
        return $this->terminal;
    }

    public function enableWrap($shouldWrap)
    {
        $this->shouldWrap = $shouldWrap;
    }

    public function prepare(CommandData $commandData, FormatterOptions $options)
    {
        $width = $this->getTerminalWidth();
        if (!$width) {
            $width = $this->defaultWidth;
        }

        // Enforce minimum and maximum widths
        $width = min($width, $this->getMaxWidth($commandData));
        $width = max($width, $this->getMinWidth($commandData));

        $options->setWidth($width);
    }

    protected function getTerminalWidth()
    {
        // Don't wrap if wrapping has been disabled.
        if (!$this->shouldWrap) {
            return 0;
        }

        $terminal = $this->getTerminal();
        if ($terminal) {
            return $terminal->getWidth();
        }

        return $this->getTerminalWidthViaApplication();
    }

    protected function getTerminalWidthViaApplication()
    {
        if (!$this->application) {
            return 0;
        }
        $dimensions = $this->application->getTerminalDimensions();
        if ($dimensions[0] == null) {
            return 0;
        }

        return $dimensions[0];
    }

    protected function getMaxWidth(CommandData $commandData)
    {
        return $this->maxWidth;
    }

    protected function getMinWidth(CommandData $commandData)
    {
        return $this->minWidth;
    }
}
