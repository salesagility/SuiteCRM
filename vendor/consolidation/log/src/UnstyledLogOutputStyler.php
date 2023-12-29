<?php
namespace Consolidation\Log;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\OutputStyle;

/**
 * Base class that provides basic unstyled output.
 */
class UnstyledLogOutputStyler implements LogOutputStylerInterface
{
    public function createOutputWrapper(OutputInterface $output)
    {
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function defaultStyles()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function style($context)
    {
        return $context;
    }

    /**
     * {@inheritdoc}
     */
    protected function write($output, $message, $context)
    {
        $output->writeln($message);
    }

    /**
     * {@inheritdoc}
     */
    public function log($output, $level, $message, $context)
    {
        return $this->write($output, $this->formatMessageByLevel($level, $message, $context), $context);
    }

    /**
     * {@inheritdoc}
     */
    public function success($output, $level, $message, $context)
    {
        return $this->write($output, $this->formatMessageByLevel($level, $message, $context), $context);
    }

    /**
     * {@inheritdoc}
     */
    public function error($output, $level, $message, $context)
    {
        return $this->write($output, $this->formatMessageByLevel($level, $message, $context), $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($output, $level, $message, $context)
    {
        return $this->write($output, $this->formatMessageByLevel($level, $message, $context), $context);
    }

    /**
     * {@inheritdoc}
     */
    public function note($output, $level, $message, $context)
    {
        return $this->write($output, $this->formatMessageByLevel($level, $message, $context), $context);
    }

    /**
     * {@inheritdoc}
     */
    public function caution($output, $level, $message, $context)
    {
        return $this->write($output, $this->formatMessageByLevel($level, $message, $context), $context);
    }

    /**
     * Look up the label and message styles for the specified log level,
     * and use the log level as the label for the log message.
     */
    protected function formatMessageByLevel($level, $message, $context)
    {
        return " [$level] $message";
    }
}
