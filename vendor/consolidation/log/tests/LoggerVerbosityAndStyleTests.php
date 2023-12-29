<?php
namespace Consolidation\Log;

use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

use Consolidation\TestUtils\TestDataPermuter;

class LoggerVerbosityAndStyleTests extends TestCase
{
  protected $output;
  protected $logger;

  function setup(): void {
    $this->output = new BufferedOutput();
    //$this->output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
    $this->logger = new Logger($this->output);
  }

  public static function logTestValues()
  {
    /**
     * Use TEST_ALL_LOG_LEVELS to ensure that output is the same
     * in instances where the output does not vary by log level.
     */
    $TEST_ALL_LOG_LEVELS = [
      OutputInterface::VERBOSITY_DEBUG,
      OutputInterface::VERBOSITY_VERY_VERBOSE,
      OutputInterface::VERBOSITY_VERBOSE,
      OutputInterface::VERBOSITY_NORMAL
    ];

    // Tests that return the same value for multiple inputs
    // may use the expandProviderDataArrays method, and list
    // repeated scalars as array values.  All permutations of
    // all array items will be calculated, and one test will
    // be generated for each one.
    return TestDataPermuter::expandProviderDataArrays([
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        $TEST_ALL_LOG_LEVELS,
        LogLevel::EMERGENCY,
        'The planet is melting. Consume less.',
        ' [emergency] The planet is melting. Consume less.',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        $TEST_ALL_LOG_LEVELS,
        LogLevel::ALERT,
        'Masks required.',
        ' [alert] Masks required.',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        $TEST_ALL_LOG_LEVELS,
        LogLevel::CRITICAL,
        'Reactor meltdown imminent.',
        ' [critical] Reactor meltdown imminent.',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        $TEST_ALL_LOG_LEVELS,
        LogLevel::ERROR,
        'Do not enter - wrong way.',
        ' [error] Do not enter - wrong way.',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        $TEST_ALL_LOG_LEVELS,
        LogLevel::WARNING,
        'Steep grade.',
        ' [warning] Steep grade.',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        [
          OutputInterface::VERBOSITY_DEBUG,
          OutputInterface::VERBOSITY_VERY_VERBOSE,
          OutputInterface::VERBOSITY_VERBOSE,
        ],
        LogLevel::NOTICE,
        'No loitering.',
        ' [notice] No loitering.',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        OutputInterface::VERBOSITY_NORMAL,
        LogLevel::NOTICE,
        'No loitering.',
        '',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        OutputInterface::VERBOSITY_DEBUG,
        LogLevel::INFO,
        'Scenic route.',
        ' [info] Scenic route.',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        OutputInterface::VERBOSITY_DEBUG,
        LogLevel::DEBUG,
        'Counter incremented.',
        ' [debug] Counter incremented.',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        [
          OutputInterface::VERBOSITY_VERY_VERBOSE,
          OutputInterface::VERBOSITY_VERBOSE,
          OutputInterface::VERBOSITY_NORMAL
        ],
        LogLevel::DEBUG,
        'Counter incremented.',
        '',
      ],
      [
        '\Consolidation\Log\UnstyledLogOutputStyler',
        $TEST_ALL_LOG_LEVELS,
        ConsoleLogLevel::SUCCESS,
        'It worked!',
        ' [success] It worked!',
      ],
      [
        '\Consolidation\Log\LogOutputStyler',
        OutputInterface::VERBOSITY_NORMAL,
        ConsoleLogLevel::SUCCESS,
        'It worked!',
        ' [success] It worked!',
      ],
      [
        '\Consolidation\Log\SymfonyLogOutputStyler',
        OutputInterface::VERBOSITY_DEBUG,
        LogLevel::WARNING,
        'Steep grade.',
        "\n [WARNING] Steep grade.",
      ],
      [
        '\Consolidation\Log\SymfonyLogOutputStyler',
        OutputInterface::VERBOSITY_DEBUG,
        LogLevel::NOTICE,
        'No loitering.',
        "\n ! [NOTE] No loitering.",
      ],
      [
        '\Consolidation\Log\SymfonyLogOutputStyler',
        OutputInterface::VERBOSITY_DEBUG,
        LogLevel::INFO,
        'Scenic route.',
        "\n ! [NOTE] Scenic route.",
      ],
      [
        '\Consolidation\Log\SymfonyLogOutputStyler',
        OutputInterface::VERBOSITY_DEBUG,
        LogLevel::DEBUG,
        'Counter incremented.',
        "\n ! [NOTE] Counter incremented.",
      ],
      [
        '\Consolidation\Log\SymfonyLogOutputStyler',
        OutputInterface::VERBOSITY_NORMAL,
        ConsoleLogLevel::SUCCESS,
        'It worked!',
        "\n [OK] It worked!",
      ],
    ]);
  }

  /**
   * This is our only test method. It accepts all of the
   * permuted data from the data provider, and runs one
   * test on each one.
   *
   * @dataProvider logTestValues
   */
  function testLogging($styleClass, $verbocity, $level, $message, $expected) {
    $logStyler = new $styleClass;
    $this->logger->setLogOutputStyler($logStyler);
    $this->output->setVerbosity($verbocity);
    $this->logger->log($level, $message);
    $outputText = rtrim($this->output->fetch(), "\n\r\t ");
    $outputText = preg_replace('#\r\n#ms', "\n", $outputText);
    $expected = preg_replace('#\r\n#ms', "\n", $expected);
    $this->assertEquals($expected, $outputText);
  }
}
