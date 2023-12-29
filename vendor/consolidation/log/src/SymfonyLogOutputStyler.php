<?php
namespace Consolidation\Log;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Style log messages with Symfony\Component\Console\Style\SymfonyStyle.
 * No context variable styling is done.
 *
 * This is the appropriate styler to use if your desire is to replace
 * the use of SymfonyStyle with a Psr-3 logger without changing the
 * appearance of your application's output.
 */
class SymfonyLogOutputStyler implements LogOutputStylerInterface
{
    public function defaultStyles()
    {
        return [];
    }

    public function style($context)
    {
        return $context;
    }

    public function createOutputWrapper(OutputInterface $output)
    {
        // SymfonyStyle & c. contain both input and output functions,
        // but we only need the output methods here. Create a stand-in
        // input object to satisfy the SymfonyStyle constructor.
        return new SymfonyStyle(new StringInput(''), $output);
    }

    public function log($symfonyStyle, $level, $message, $context)
    {
        $symfonyStyle->text($message);
    }

    public function success($symfonyStyle, $level, $message, $context)
    {
        $symfonyStyle->success($message);
    }

    public function error($symfonyStyle, $level, $message, $context)
    {
        $symfonyStyle->error($message);
    }

    public function warning($symfonyStyle, $level, $message, $context)
    {
        $symfonyStyle->warning($message);
    }

    public function note($symfonyStyle, $level, $message, $context)
    {
        $symfonyStyle->note($message);
    }

    public function caution($symfonyStyle, $level, $message, $context)
    {
        $symfonyStyle->caution($message);
    }
}
