<?php

namespace SuiteCRM\Utility;


use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * /**
 * PSR-3 Compliant logger
 * Class SuiteLogger
 * @package SuiteCRM\Utility
 * @see http://www.php-fig.org/psr/psr-3/
 */
class SuiteLogger extends AbstractLogger implements LoggerInterface
{
    /**
     * @param LogLevel|string $level
     * @param string $message eg 'hello {user}'
     * @param array $context eg array(user => 'joe')
     * @throws InvalidArgumentException
     */
    public function log($level, $message, array $context = array())
    {
        $log = \LoggerManager::getLogger();
        $message = $this->interpolate($message, $context);
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
            default:
                throw new InvalidArgumentException();
        }
    }

    /**
     * build a replacement array with braces around the context keys
     * @param $message
     * @param array $context
     * @return string
     */
    private function interpolate($message, array $context = array())
    {
        $replace = array();

        if(empty($context)) {
            return $message;
        }

        foreach ($context as $key => $val) {
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        return strtr($message, $replace);
    }
}