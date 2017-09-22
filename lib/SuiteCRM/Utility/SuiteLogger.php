<?php

namespace SuiteCRM\Utility;


use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * PSR Complient logger
 * Class SuiteLogger
 * @package SuiteCRM\api\core
 */
class SuiteLogger implements LoggerInterface
{
    /**
     * @param LogLevel|string $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = array())
    {
        $log = \LoggerManager::getLogger();
        switch ($level) {
            case LogLevel::EMERGENCY:
                $log->fatal('[EMERGENCY] ' . $message);
                break;
            case LogLevel::ALERT:
                $log->fatal('[ALERT] ' . $message);
                break;
            case LogLevel::CRITICAL:
                $log->fatal('[CRITICAL] ' . $message);
                break;
            case LogLevel::ERROR:
                $log->fatal('[ERROR] ' . $message);
                break;
            case LogLevel::WARNING:
                $log->warn($message);
                break;
            case LogLevel::NOTICE:
                $log->warn('[NOTICE] ' . $message);
                break;
            case LogLevel::INFO:
                $log->info($message);
                break;
            case LogLevel::DEBUG:
                $log->debug($message);
                break;
        }
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function info($message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }
}