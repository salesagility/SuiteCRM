<?php
/**
 * Created by Adam Jakab.
 * Date: 08/03/16
 * Time: 12.37
 */

namespace SuiteCrm\Install;

use Symfony\Component\Console\Output\OutputInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

/**
 * Custom implementation of include/SugarLogger/LoggerManager.php
 *
 * This class is inserted in $GLOBALS['log'] during installation process so to catch all log
 * messages from application
 *
 * Class LoggerManager
 * @package SuiteCrm\Install
 */
class LoggerManager
{
    /** @var  OutputInterface */
    protected $cmdOutput;

    /** @var string */
    protected $defaultLogLevel = 'debug';

    protected $installLogFile = 'logs/install.log';

    /** @var array */
    private static $sugarLogLevelMapping = [
        'debug' => 100,
        'info' => 70,
        'warn' => 50,
        'deprecated' => 40,
        'error' => 25,
        'fatal' => 10,
        'security' => 5,
        'off' => 0,
    ];

    /** @var array */
    private static $monologLogLevelMapping = [
        'debug' => Logger::DEBUG,
        'info' => Logger::INFO,
        'warn' => Logger::WARNING,
        'deprecated' => Logger::WARNING,
        'error' => Logger::ERROR,
        'fatal' => Logger::CRITICAL,
        'security' => Logger::CRITICAL,
        'off' => Logger::DEBUG,
    ];

    /** @var  Logger */
    protected $fileLogger;



    /**
     * @param OutputInterface $cmdOutput
     * @param string          $defaultLogLevel
     */
    public function __construct(OutputInterface $cmdOutput, $defaultLogLevel = 'debug')
    {
        $this->cmdOutput = $cmdOutput;
        $this->setLevel($defaultLogLevel);

        if(file_exists(PROJECT_ROOT . '/' . $this->installLogFile)) {
            unlink(PROJECT_ROOT . '/' . $this->installLogFile);
        }
        $this->fileLogger = new Logger("INSTALLER");
        $streamHandler = new StreamHandler(PROJECT_ROOT . '/' . $this->installLogFile, Logger::INFO);
        $formatter = new LineFormatter("[%datetime%(%level_name%)]: %message%\n", "Y-m-d H:i:s");
        $streamHandler->setFormatter($formatter);
        $this->fileLogger->pushHandler($streamHandler);
    }

    /**
     * @param string $logLevel
     * @param mixed  $message
     */
    public function __call($logLevel, $message)
    {
        $this->log($message, $logLevel);
    }

    /**
     *
     * @todo: implement writeln options for console logging verbosity | silenced
     *
     * @param string $msg
     * @param string $level
     */
    public function log($msg, $level = 'debug')
    {
        //LOG TO CONSOLE
        $sugarLogLevel = (!in_array($level, array_keys(self::$sugarLogLevelMapping)) ? $this->defaultLogLevel : $level);
        $option = $this->getOutputInterfaceVerbosityOptionForLogLevel($sugarLogLevel);
        $msg = is_array($msg) ? implode(" - ", $msg) : $msg;
        $now = new \DateTime();
        $timestamp = $now->format("Y-m-d H:i:s");
        $this->cmdOutput->writeln("[${timestamp}(${sugarLogLevel})]: ${msg}", $option);

        //LOG TO FILE
        $monologLogLevel = (!in_array($level, array_keys(self::$monologLogLevelMapping)) ? Logger::DEBUG : self::$monologLogLevelMapping[$level]);
        $this->fileLogger->log($monologLogLevel, $msg);
    }

    /**
     * @param string $level
     * @return int
     */
    protected function getOutputInterfaceVerbosityOptionForLogLevel($level)
    {
        $option = OutputInterface::OUTPUT_NORMAL;
        $numericLevel = self::$sugarLogLevelMapping[$level];
        if ($numericLevel == 100) {
            $option = $option | OutputInterface::VERBOSITY_DEBUG;
        }
        else if ($numericLevel >= 70) {
            $option = $option | OutputInterface::VERBOSITY_VERY_VERBOSE;
        }
        else if ($numericLevel >= 50) {
            $option = $option | OutputInterface::VERBOSITY_VERBOSE;
        }
        else {
            $option = $option | OutputInterface::VERBOSITY_NORMAL;
        }
        return $option;
    }

    /**
     * @param string $logLevel
     * @return bool
     */
    public function wouldLog($logLevel)
    {
        $logLevel = (!in_array($logLevel, array_keys(self::$sugarLogLevelMapping)) ? $this->defaultLogLevel : $logLevel);
        $wouldLog = $logLevel == $this->defaultLogLevel
                    || self::$sugarLogLevelMapping[$this->defaultLogLevel] >= self::$sugarLogLevelMapping[$logLevel];
        return $wouldLog;
    }

    /**
     * @param string  $message
     * @param boolean $condition
     */
    public function assert($message, $condition)
    {
        //do nothing
    }

    /**
     * @param string $logLevel
     */
    public function setLevel($logLevel)
    {
        if (in_array($logLevel, array_keys(self::$sugarLogLevelMapping))) {
            $this->defaultLogLevel = $logLevel;
        }
    }

    /**
     * @throws \Exception
     */
    public static function getLogger()
    {
        throw new \Exception("getLogger is not available now!");
    }

    /**
     * @param string $level
     * @param string $logger
     */
    public static function setLogger($level, $logger)
    {
        //do nothing
    }

    /**
     * @return array
     */
    public static function getAvailableLoggers()
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getLoggerLevels()
    {
        return self::$sugarLogLevelMapping;
    }

}