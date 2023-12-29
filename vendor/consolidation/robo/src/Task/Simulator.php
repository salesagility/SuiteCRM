<?php

namespace Robo\Task;

use Robo\Contract\WrappedTaskInterface;
use Robo\Exception\TaskException;
use Robo\TaskInfo;
use Robo\Result;
use Robo\Contract\TaskInterface;
use Robo\Contract\SimulatedInterface;
use Robo\Log\RoboLogLevel;
use Robo\Contract\CommandInterface;

class Simulator extends BaseTask implements CommandInterface
{
    /**
     * @var \Robo\Contract\TaskInterface
     */
    protected $task;

    /**
     * @var array
     */
    protected $constructorParameters;

    /**
     * @var array
     */
    protected $stack = [];

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param array $constructorParameters
     */
    public function __construct(TaskInterface $task, $constructorParameters)
    {
        // TODO: If we ever want to convert the simulated task back into
        // an executable task, then we should save the wrapped task.
        $this->task = ($task instanceof WrappedTaskInterface) ? $task->original() : $task;
        $this->constructorParameters = $constructorParameters;
    }

    /**
     * @param string $function
     * @param array $args
     *
     * @return \Robo\Result|$this
     */
    public function __call($function, $args)
    {
        $this->stack[] = array_merge([$function], $args);
        $result = call_user_func_array([$this->task, $function], $args);
        return $result == $this->task ? $this : $result;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $callchain = '';
        foreach ($this->stack as $action) {
            $command = array_shift($action);
            $parameters = $this->formatParameters($action);
            $callchain .= "\n    ->$command(<fg=green>$parameters</>)";
        }
        $context = $this->getTaskContext(
            [
                '_level' => RoboLogLevel::SIMULATED_ACTION,
                'simulated' => TaskInfo::formatTaskName($this->task),
                'parameters' => $this->formatParameters($this->constructorParameters),
                '_style' => ['simulated' => 'fg=blue;options=bold'],
            ]
        );

        // RoboLogLevel::SIMULATED_ACTION
        $this->printTaskInfo(
            "Simulating {simulated}({parameters})$callchain",
            $context
        );

        $result = null;
        if ($this->task instanceof SimulatedInterface) {
            $result = $this->task->simulate($context);
        }
        if (!isset($result)) {
            $result = Result::success($this);
        }

        return $result;
    }

    /**
     * Danger: reach through the simulated wrapper and pull out the command
     * to be executed.  This is used when using a simulated task with another
     * simulated task that runs commands, e.g. the Remote\Ssh task.  Using
     * a simulated CommandInterface task with a non-simulated task may produce
     * unexpected results (e.g. execution!).
     *
     * @return string
     *
     * @throws \Robo\Exception\TaskException
     */
    public function getCommand()
    {
        if (!$this->task instanceof CommandInterface) {
            throw new TaskException($this->task, 'Simulated task that is not a CommandInterface used as a CommandInterface.');
        }
        return $this->task->getCommand();
    }

    /**
     * @param array $action
     *
     * @return string
     */
    protected function formatParameters($action)
    {
        $parameterList = array_map([$this, 'convertParameter'], $action);
        return implode(', ', $parameterList);
    }

    /**
     * @param mixed $item
     *
     * @return string
     */
    protected function convertParameter($item)
    {
        if (is_callable($item)) {
            return 'inline_function(...)';
        }
        if (is_array($item)) {
            return $this->shortenParameter(var_export($item, true));
        }
        if (is_object($item)) {
            return '[' . get_class($item) . ' object]';
        }
        if (is_string($item)) {
            return $this->shortenParameter("'$item'");
        }
        if (is_null($item)) {
            return 'null';
        }
        return $item;
    }

    /**
     * @param string $item
     * @param string $shortForm
     *
     * @return string
     */
    protected function shortenParameter($item, $shortForm = '')
    {
        $maxLength = 80;
        $tailLength = 20;
        if (strlen($item) < $maxLength) {
            return $item;
        }
        if (!empty($shortForm)) {
            return $shortForm;
        }
        $item = trim($item);
        $tail = preg_replace("#.*\n#ms", '', substr($item, -$tailLength));
        $head = preg_replace("#\n.*#ms", '', substr($item, 0, $maxLength - (strlen($tail) + 5)));
        return "$head ... $tail";
    }
}
