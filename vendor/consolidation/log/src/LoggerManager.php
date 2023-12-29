<?php
namespace Consolidation\Log;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * LoggerManager is a PSR-3 logger that can delegate
 * log messages to other loggers. This is ideal if
 * you need to inject a logger into various objects
 * in your application, but need to change the way that
 * the application logs later.
 *
 * @author Greg Anderson <greg.1.anderson@greenknowe.org>
 */
class LoggerManager extends AbstractLogger implements StylableLoggerInterface, SettableLogOutputStreamInterface
{
    /** @var LoggerInterface[] */
    protected $loggers = [];
    /** @var LoggerInterface */
    protected $fallbackLogger = null;
    /** @var LogOutputStylerInterface */
    protected $outputStyler;
    /** @var array */
    protected $formatFunctionMap = [];
    /** @var OutputInterface */
    protected $outputStream;
    /** @var OutputInterface */
    protected $errorStream;

    /**
     * reset removes all loggers from the manager.
     */
    public function reset()
    {
        $this->loggers = [];
        return $this;
    }

    /**
     * setLogOutputStyler will remember a style that
     * should be applied to every stylable logger
     * added to this manager.
     */
    public function setLogOutputStyler(LogOutputStylerInterface $outputStyler, array $formatFunctionMap = array())
    {
        $this->outputStyler = $outputStyler;
        $this->formatFunctionMap = $this->formatFunctionMap;

        foreach ($this->getLoggers() as $logger) {
            if ($logger instanceof StylableLoggerInterface) {
                $logger->setLogOutputStyler($this->outputStyler, $this->formatFunctionMap);
            }
        }
    }

    /**
     * setOutputStream will remember an output stream that should be
     * applied to every logger added to this manager.
     */
    public function setOutputStream($output)
    {
        $this->outputStream = $output;
        foreach ($this->getLoggers() as $logger) {
            if ($logger instanceof SettableLogOutputStreamInterface) {
                $logger->setOutputStream($this->outputStream);
            }
        }
    }

    /**
     * setErrorStream will remember an error stream that should be
     * applied to every logger added to this manager.
     */
    public function setErrorStream($error)
    {
        $this->errorStream = $error;
        foreach ($this->getLoggers() as $logger) {
            if ($logger instanceof SettableLogOutputStreamInterface) {
                $logger->setErrorStream($this->errorStream);
            }
        }
    }

    /**
     * add adds a named logger to the manager,
     * replacing any logger of the same name.
     *
     * @param string $name Name of logger to add
     * @param LoggerInterface $logger Logger to send messages to
     */
    public function add($name, LoggerInterface $logger)
    {
        // If this manager has been given a log style,
        // and the logger being added accepts a log
        // style, then copy our style to the logger
        // being added.
        if ($this->outputStyler && $logger instanceof StylableLoggerInterface) {
            $logger->setLogOutputStyler($this->outputStyler, $this->formatFunctionMap);
        }
        if ($logger instanceof SettableLogOutputStreamInterface) {
            if ($this->outputStream) {
                $logger->setOutputStream($this->outputStream);
            }
            if ($this->errorStream) {
                $logger->setErrorStream($this->errorStream);
            }
        }
        $this->loggers[$name] = $logger;
        return $this;
    }

    /**
     * remove a named logger from the manager.
     *
     * @param string $name Name of the logger to remove.
     */
    public function remove($name)
    {
        unset($this->loggers[$name]);
        return $this;
    }

    /**
     * fallbackLogger provides a logger that will
     * be used only in instances where someone logs
     * to the logger manager at a time when there
     * are no other loggers registered. If there is
     * no fallback logger, then the log messages
     * are simply dropped.
     *
     * @param LoggerInterface $logger Logger to use as the fallback logger
     */
    public function fallbackLogger(LoggerInterface $logger)
    {
        $this->fallbackLogger = $logger;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = array())
    {
        foreach ($this->getLoggers() as $logger) {
            $logger->log($level, $message, $context);
        }
    }

    /**
     * Return either the list of registered loggers,
     * or a single-element list containing only the
     * fallback logger.
     */
    protected function getLoggers()
    {
        if (!empty($this->loggers)) {
            return $this->loggers;
        }
        if (isset($this->fallbackLogger)) {
            return [ $this->fallbackLogger ];
        }
        return [];
    }
}
