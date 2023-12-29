<?php

namespace Robo\Task;

use Robo\Common\ExecCommand;
use Robo\Contract\PrintedInterface;
use Robo\Result;
use Robo\Contract\CommandInterface;
use Robo\Exception\TaskException;
use Robo\Common\CommandReceiver;

abstract class CommandStack extends BaseTask implements CommandInterface, PrintedInterface
{
    use ExecCommand;
    use CommandReceiver;

    /**
     * @var string
     */
    protected $executable;

    /**
     * @var \Robo\Result
     */
    protected $result;

    /**
     * @var string[]
     */
    protected $exec = [];

    /**
     * @var bool
     */
    protected $stopOnFail = false;

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        $commands = [];
        foreach ($this->exec as $command) {
            $commands[] = $this->receiveCommand($command);
        }

        return implode(' && ', $commands);
    }

    /**
     * @param string $executable
     *
     * @return $this
     */
    public function executable($executable)
    {
        $this->executable = $executable;
        return $this;
    }

    /**
     * @param string|string[]|CommandInterface $command
     *
     * @return $this
     */
    public function exec($command)
    {
        if (is_array($command)) {
            $command = implode(' ', array_filter($command));
        }

        if (is_string($command)) {
            $command = $this->executable . ' ' . $this->stripExecutableFromCommand($command);
            $command = trim($command);
        }

        $this->exec[] = $command;

        return $this;
    }

    /**
     * @param bool $stopOnFail
     *
     * @return $this
     */
    public function stopOnFail($stopOnFail = true)
    {
        $this->stopOnFail = $stopOnFail;
        return $this;
    }

    public function result($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @param string $command
     *
     * @return string
     */
    protected function stripExecutableFromCommand($command)
    {
        $command = trim($command);
        $executable = $this->executable . ' ';
        if (strpos($command, $executable) === 0) {
            $command = substr($command, strlen($executable));
        }
        return $command;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (empty($this->exec)) {
            throw new TaskException($this, 'You must add at least one command');
        }
        // If 'stopOnFail' is not set, or if there is only one command to run,
        // then execute the single command to run.
        if (!$this->stopOnFail || (count($this->exec) == 1)) {
            $this->printTaskInfo('{command}', ['command' => $this->getCommand()]);
            return $this->executeCommand($this->getCommand());
        }

        // When executing multiple commands in 'stopOnFail' mode, run them
        // one at a time so that the result will have the exact command
        // that failed available to the caller. This is at the expense of
        // losing the output from all successful commands.
        $data = [];
        $message = '';
        $result = null;
        foreach ($this->exec as $command) {
            $this->printTaskInfo("Executing {command}", ['command' => $command]);
            $result = $this->executeCommand($command);
            $result->accumulateExecutionTime($data);
            $message = $result->accumulateMessage($message);
            $data = $result->mergeData($data);
            if (!$result->wasSuccessful()) {
                return $result;
            }
        }

        return $result;
    }
}
