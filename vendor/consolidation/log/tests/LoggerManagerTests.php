<?php
namespace Consolidation\Log;

use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class LoggerManagerTests extends TestCase
{
  protected $output;
  protected $logger;

  function testLoggerManager()
  {
    $fallbackOutput = new BufferedOutput();
    $fallbackOutput->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
    $fallbackLogger = new Logger($fallbackOutput);
    $fallbackLogger->notice('This is the fallback logger');

    $primaryOutput = new BufferedOutput();
    $primaryOutput->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
    $primaryLogger = new Logger($primaryOutput);
    $primaryLogger->notice('This is the primary logger');

    $replacementOutput = new BufferedOutput();
    $replacementOutput->setVerbosity(OutputInterface::VERBOSITY_DEBUG);
    $replacementLogger = new Logger($replacementOutput);
    $replacementLogger->notice('This is the replacement logger');

    $logger = new LoggerManager();

    $logger->notice('Uninitialized logger.');
    $logger->fallbackLogger($fallbackLogger);
    $logger->notice('Logger with fallback.');
    $logger->add('default', $primaryLogger);
    $logger->notice('Primary logger');
    $logger->add('default', $replacementLogger);
    $logger->notice('Replaced logger');
    $logger->reset();
    $logger->notice('Reset loggers');

    $fallbackActual = rtrim($fallbackOutput->fetch());
    $primaryActual = rtrim($primaryOutput->fetch());
    $replacementActual = rtrim($replacementOutput->fetch());

    $actual = "Fallback:\n====\n$fallbackActual\nPrimary:\n====\n$primaryActual\nReplacement:\n====\n$replacementActual";

    $actual = preg_replace('#\r\n#ms', "\n", $actual);
    $actual = preg_replace('# *$#ms', '', $actual);
    $actual = preg_replace('#^ *$\n#ms', '', $actual);

    $expected = <<< __EOT__
Fallback:
====
 ! [NOTE] This is the fallback logger
 ! [NOTE] Logger with fallback.
 ! [NOTE] Reset loggers
Primary:
====
 ! [NOTE] This is the primary logger
 ! [NOTE] Primary logger
Replacement:
====
 ! [NOTE] This is the replacement logger
 ! [NOTE] Replaced logger
__EOT__;

    $expected = preg_replace('#\r\n#ms', "\n", $expected);
    $this->assertEquals($expected, $actual);
  }
}
