<?php
namespace Consolidation\Log;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\StringInput;

/**
 * Replacement for Symfony\Component\Console\Logger\ConsoleLogger.
 * Each of the different log level messages are routed through the
 * corresponding SymfonyStyle formatting method.  Log messages are
 * always sent to stderr if the provided output object implements
 * ConsoleOutputInterface.
 *
 * Note that this class could extend ConsoleLogger if some methods
 * of that class were declared 'protected' instead of 'private'.
 *
 * @author Greg Anderson <greg.1.anderson@greenknowe.org>
 */
class Logger extends AbstractLogger implements StylableLoggerInterface, SettableLogOutputStreamInterface
{
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @var OutputInterface
     */
    protected $error;
    /**
     * @var LogOutputStylerInterface
     */
    protected $outputStyler;
    /**
     * @var OutputInterface|SymfonyStyle|other
     */
    protected $outputStreamWrapper;
    protected $errorStreamWrapper;

    protected $formatFunctionMap = [
        LogLevel::EMERGENCY => 'error',
        LogLevel::ALERT => 'error',
        LogLevel::CRITICAL => 'error',
        LogLevel::ERROR => 'error',
        LogLevel::WARNING => 'warning',
        LogLevel::NOTICE => 'note',
        LogLevel::INFO => 'note',
        LogLevel::DEBUG => 'note',
        ConsoleLogLevel::SUCCESS => 'success',
    ];

    /**
     * @param OutputInterface $output
     * @param array           $verbosityLevelMap
     * @param array           $formatLevelMap
     * @param array           $formatFunctionMap
     */
    public function __construct(OutputInterface $output, array $verbosityLevelMap = array(), array $formatLevelMap = array(), array $formatFunctionMap = array())
    {
        $this->output = $output;

        $this->verbosityLevelMap = $verbosityLevelMap + $this->verbosityLevelMap;
        $this->formatLevelMap = $formatLevelMap + $this->formatLevelMap;
        $this->formatFunctionMap = $formatFunctionMap + $this->formatFunctionMap;
    }

    public function setLogOutputStyler(LogOutputStylerInterface $outputStyler, array $formatFunctionMap = array())
    {
        $this->outputStyler = $outputStyler;
        $this->formatFunctionMap = $formatFunctionMap + $this->formatFunctionMap;
        $this->outputStreamWrapper = null;
        $this->errorStreamWrapper = null;
    }

    public function getLogOutputStyler()
    {
        if (!isset($this->outputStyler)) {
            $this->outputStyler = new SymfonyLogOutputStyler();
        }
        return $this->outputStyler;
    }

    protected function getOutputStream()
    {
        return $this->output;
    }

    protected function getErrorStream()
    {
        if (!isset($this->error)) {
            $output = $this->getOutputStream();
            if ($output instanceof ConsoleOutputInterface) {
                $output = $output->getErrorOutput();
            }
            $this->error = $output;
        }
        return $this->error;
    }

    public function setOutputStream($output)
    {
        $this->output = $output;
        $this->outputStreamWrapper = null;
    }

    public function setErrorStream($error)
    {
        $this->error = $error;
        $this->errorStreamWrapper = null;
    }

    protected function getOutputStreamWrapper()
    {
        if (!isset($this->outputStreamWrapper)) {
            $this->outputStreamWrapper = $this->getLogOutputStyler()->createOutputWrapper($this->getOutputStream());
        }
        return $this->outputStreamWrapper;
    }

    protected function getErrorStreamWrapper()
    {
        if (!isset($this->errorStreamWrapper)) {
            $this->errorStreamWrapper = $this->getLogOutputStyler()->createOutputWrapper($this->getErrorStream());
        }
        return $this->errorStreamWrapper;
    }

    protected function getOutputStreamForLogLevel($level)
    {
        // Write to the error output if necessary and available.
        // Usually, loggers that log to a terminal should send
        // all log messages to stderr.
        if (array_key_exists($level, $this->formatLevelMap) && ($this->formatLevelMap[$level] !== self::ERROR)) {
            return $this->getOutputStreamWrapper();
        }
        return $this->getErrorStreamWrapper();
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = array())
    {
        // We use the '_level' context variable to allow log messages
        // to be logged at one level (e.g. NOTICE) and formatted at another
        // level (e.g. SUCCESS). This helps in instances where we want
        // to style log messages at a custom log level that might not
        // be available in all loggers. If the logger does not recognize
        // the log level, then it is treated like the original log level.
        if (array_key_exists('_level', $context) && array_key_exists($context['_level'], $this->verbosityLevelMap)) {
            $level = $context['_level'];
        }
        // It is a runtime error if someone logs at a log level that
        // we do not recognize.
        if (!isset($this->verbosityLevelMap[$level])) {
            throw new InvalidArgumentException(sprintf('The log level "%s" does not exist.', $level));
        }

        // Write to the error output if necessary and available.
        // Usually, loggers that log to a terminal should send
        // all log messages to stderr.
        $outputStreamWrapper = $this->getOutputStreamForLogLevel($level);

        // Ignore messages that are not at the right verbosity level
        if ($this->getOutputStream()->getVerbosity() >= $this->verbosityLevelMap[$level]) {
            $this->doLog($outputStreamWrapper, $level, $message, $context);
        }
    }

    /**
     * Interpolate and style the message, and then send it to the log.
     */
    protected function doLog($outputStreamWrapper, $level, $message, $context)
    {
        $formatFunction = 'log';
        if (array_key_exists($level, $this->formatFunctionMap)) {
            $formatFunction = $this->formatFunctionMap[$level];
        }
        $interpolated = $this->interpolate(
            $message,
            $this->getLogOutputStyler()->style($context)
        );
        $this->getLogOutputStyler()->$formatFunction(
            $outputStreamWrapper,
            $level,
            $interpolated,
            $context
        );
    }

    public function success($message, array $context = array())
    {
        $this->log(ConsoleLogLevel::SUCCESS, $message, $context);
    }

    // The functions below could be eliminated if made `protected` intead
    // of `private` in ConsoleLogger

    const INFO = 'info';
    const ERROR = 'error';

    /**
     * @var OutputInterface
     */
    //private $output;
    /**
     * @var array
     */
    private $verbosityLevelMap = [
        LogLevel::EMERGENCY => OutputInterface::VERBOSITY_NORMAL,
        LogLevel::ALERT => OutputInterface::VERBOSITY_NORMAL,
        LogLevel::CRITICAL => OutputInterface::VERBOSITY_NORMAL,
        LogLevel::ERROR => OutputInterface::VERBOSITY_NORMAL,
        LogLevel::WARNING => OutputInterface::VERBOSITY_NORMAL,
        LogLevel::NOTICE => OutputInterface::VERBOSITY_VERBOSE,
        LogLevel::INFO => OutputInterface::VERBOSITY_VERY_VERBOSE,
        LogLevel::DEBUG => OutputInterface::VERBOSITY_DEBUG,
        ConsoleLogLevel::SUCCESS => OutputInterface::VERBOSITY_NORMAL,
    ];

    /**
     * @var array
     *
     * Send all log messages to stderr. Symfony should have the same default.
     * See: https://en.wikipedia.org/wiki/Standard_streams
     *   "Standard error was added to Unix after several wasted phototypesetting runs ended with error messages being typeset instead of displayed on the user's terminal."
     */
    private $formatLevelMap = [
        LogLevel::EMERGENCY => self::ERROR,
        LogLevel::ALERT => self::ERROR,
        LogLevel::CRITICAL => self::ERROR,
        LogLevel::ERROR => self::ERROR,
        LogLevel::WARNING => self::ERROR,
        LogLevel::NOTICE => self::ERROR,
        LogLevel::INFO => self::ERROR,
        LogLevel::DEBUG => self::ERROR,
        ConsoleLogLevel::SUCCESS => self::ERROR,
    ];

    /**
     * Interpolates context values into the message placeholders.
     *
     * @author PHP Framework Interoperability Group
     *
     * @param string $message
     * @param array  $context
     *
     * @return string
     */
    private function interpolate($message, array $context)
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace[sprintf('{%s}', $key)] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
