<?php
/**
 * Created by Adam Jakab.
 * Date: 08/03/16
 * Time: 12.37
 */

namespace SuiteCrm\Install;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Custom implementation of include/SugarLogger/LoggerManager.php
 *
 * This class is inserted in $GLOBALS['log'] during install so
 *
 * Class LoggerManager
 * @package SuiteCrm\Install
 */
class LoggerManager {
    /** @var  OutputInterface */
    protected $cmdOutput;

    /** @var bool */
    protected $logToConsole = TRUE;

    /** @var string */
    protected $defaultLogLevel = 'debug';

    /** @var array */
    private static $logLevelMapping = [
        'debug' => 100,
        'info' => 70,
        'warn' => 50,
        'deprecated' => 40,
        'error' => 25,
        'fatal' => 10,
        'security' => 5,
        'off' => 0,
    ];

    /**
     * @param OutputInterface $cmdOutput
     * @param string          $defaultLogLevel
     */
    public function __construct(OutputInterface $cmdOutput, $defaultLogLevel = 'debug') {
        $this->cmdOutput = $cmdOutput;
        $this->setLevel($defaultLogLevel);
    }

    /**
     * @param string $logLevel
     * @param mixed  $message
     */
    public function __call($logLevel, $message) {
        $logLevel = (!in_array($logLevel, array_keys(self::$logLevelMapping)) ? $this->defaultLogLevel : $logLevel);
        if ($this->wouldLog($logLevel)) {
            $this->log($message, $logLevel);
        }
    }

    /**
     *
     * @todo: implement writeln options for console logging verbosity | silenced
     *
     * @param string $msg
     * @param string $level
     */
    protected function log($msg, $level) {
        if ($this->logToConsole) {
            $msg = is_array($msg) ? implode(" - ", $msg) : $msg;
            $this->cmdOutput->writeln("[$level]: " . $msg);
        }
    }

    /**
     * @param string $logLevel
     * @return bool
     */
    public function wouldLog($logLevel) {
        $logLevel = (!in_array($logLevel, array_keys(self::$logLevelMapping)) ? $this->defaultLogLevel : $logLevel);
        $wouldLog = $logLevel == $this->defaultLogLevel
                    || self::$logLevelMapping[$this->defaultLogLevel] >= self::$logLevelMapping[$logLevel];
        return $wouldLog;
    }

    /**
     * @param string $message
     * @param boolean $condition
     */
    public function assert($message, $condition) {
        //do nothing
    }

    /**
     * @param string $logLevel
     */
    public function setLevel($logLevel) {
        if(in_array($logLevel, array_keys(self::$logLevelMapping))) {
            $this->defaultLogLevel = $logLevel;
        }
    }

    /**
     * @throws \Exception
     */
    public static function getLogger() {
        throw new \Exception("getLogger is not available now!");
    }

    /**
     * @param string $level
     * @param string $logger
     */
    public static function setLogger($level, $logger) {
        //do nothing
    }

    /**
     * @return array
     */
    public static function getAvailableLoggers() {
        return [];
    }

    /**
     * @return array
     */
    public static function getLoggerLevels() {
        return self::$logLevelMapping;
    }

}