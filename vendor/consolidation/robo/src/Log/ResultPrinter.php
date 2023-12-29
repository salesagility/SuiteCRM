<?php

namespace Robo\Log;

use Consolidation\Log\ConsoleLogLevel;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;
use Robo\Common\ProgressIndicatorAwareTrait;
use Robo\Contract\OutputAwareInterface;
use Robo\Contract\PrintedInterface;
use Robo\Contract\ProgressIndicatorAwareInterface;
use Robo\Contract\VerbosityThresholdInterface;
use Robo\Result;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Log the creation of Result objects.
 */
class ResultPrinter implements LoggerAwareInterface, ProgressIndicatorAwareInterface, OutputAwareInterface
{
    use LoggerAwareTrait;
    use ProgressIndicatorAwareTrait;

    public function setOutput(OutputInterface $output)
    {
        $this->logger->setErrorStream(null);
        $this->logger->setOutputStream($output);
    }

    /**
     * Log the result of a Robo task.
     *
     * Returns 'true' if the message is printed, or false if it isn't.
     *
     * @param \Robo\Result $result
     *
     * @return null|bool
     */
    public function printResult(Result $result)
    {
        $task = $result->getTask();
        if ($task instanceof VerbosityThresholdInterface && !$task->verbosityMeetsThreshold()) {
            return;
        }
        if (!$result->wasSuccessful()) {
            return $this->printError($result);
        } else {
            return $this->printSuccess($result);
        }
    }

    /**
     * Log that we are about to abort due to an error being encountered
     * in 'stop on fail' mode.
     *
     * @param \Robo\Result $result
     */
    public function printStopOnFail($result)
    {
        $this->printMessage(LogLevel::NOTICE, 'Stopping on fail. Exiting....');
        $this->printMessage(LogLevel::ERROR, 'Exit Code: {code}', ['code' => $result->getExitCode()]);
    }

    /**
     * Log the result of a Robo task that returned an error.
     *
     * @param \Robo\Result $result
     *
     * @return bool
     */
    protected function printError(Result $result)
    {
        $task = $result->getTask();
        $context = $result->getContext() + ['timer-label' => 'Time', '_style' => []];
        $context['_style']['message'] = '';

        $printOutput = true;
        if ($task instanceof PrintedInterface) {
            $printOutput = !$task->getPrinted();
        }
        if ($printOutput) {
            $this->printMessage(LogLevel::ERROR, "{message}", $context);
        }
        $this->printMessage(LogLevel::ERROR, 'Exit code {code}', $context);
        return true;
    }

    /**
     * Log the result of a Robo task that was successful.
     *
     * @param \Robo\Result $result
     *
     * @return bool
     */
    protected function printSuccess(Result $result)
    {
        $task = $result->getTask();
        $context = $result->getContext() + ['timer-label' => 'in'];
        $time = $result->getExecutionTime();
        if ($time) {
            $this->printMessage(ConsoleLogLevel::SUCCESS, 'Done', $context);
        }
        return false;
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     */
    protected function printMessage($level, $message, $context = [])
    {
        $inProgress = $this->hideProgressIndicator();
        $this->logger->log($level, $message, $context);
        if ($inProgress) {
            $this->restoreProgressIndicator($inProgress);
        }
    }
}
