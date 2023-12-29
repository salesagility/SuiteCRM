<?php

namespace Robo;

use Robo\Common\InflectionTrait;
use Robo\Common\OutputAwareTrait;
use Robo\Contract\InflectionInterface;
use Robo\Contract\OutputAwareInterface;
use Robo\Contract\TaskInterface;
use Robo\Exception\TaskExitException;
use Robo\Log\ResultPrinter;
use Robo\State\Data;

class Result extends ResultData implements OutputAwareInterface, InflectionInterface
{
    use InflectionTrait;
    use OutputAwareTrait;

    /**
     * @var bool
     */
    public static $stopOnFail = false;

    /**
     * @var \Robo\Contract\TaskInterface
     */
    protected $task;

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param int $exitCode
     * @param string $message
     * @param array $data
     */
    public function __construct(TaskInterface $task, $exitCode, $message = '', $data = [])
    {
        parent::__construct($exitCode, $message, $data);
        $this->task = $task;
        $this->inflect($task);
        $this->printResult();

        if (self::$stopOnFail) {
            $this->stopOnFail();
        }
    }

    /**
     * Tasks should always return a Result. However, they are also
     * allowed to return NULL or an array to indicate success.
     *
     * @param \Robo\Contract\TaskInterface $task
     * @param \Robo\Result|\Robo\State\Data|\Robo\ResultData|array|null
     *
     * @return static
     */
    public static function ensureResult($task, $result)
    {
        if ($result instanceof Result) {
            return $result;
        }
        if (!isset($result)) {
            return static::success($task);
        }
        if ($result instanceof Data) {
            return static::success($task, $result->getMessage(), $result->getData());
        }
        if ($result instanceof ResultData) {
            return new Result($task, $result->getExitCode(), $result->getMessage(), $result->getData());
        }
        if (is_array($result)) {
            return static::success($task, '', $result);
        }
        throw new \Exception(sprintf('Task %s returned a %s instead of a \Robo\Result.', get_class($task), get_class($result)));
    }

    protected function printResult()
    {
        // For historic reasons, the Result constructor is responsible
        // for printing task results.
        // TODO: Make IO the responsibility of some other class. Maintaining
        // existing behavior for backwards compatibility. This is undesirable
        // in the long run, though, as it can result in unwanted repeated input
        // in task collections et. al.
        $resultPrinter = $this->resultPrinter();
        if ($resultPrinter) {
            if ($resultPrinter->printResult($this)) {
                $this->alreadyPrinted();
            }
        }
    }

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param string $extension
     * @param string $service
     *
     * @return static
     */
    public static function errorMissingExtension(TaskInterface $task, $extension, $service)
    {
        $messageTpl = 'PHP extension required for %s. Please enable %s';
        $message = sprintf($messageTpl, $service, $extension);

        return self::error($task, $message);
    }

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param string $class
     * @param string $package
     *
     * @return static
     */
    public static function errorMissingPackage(TaskInterface $task, $class, $package)
    {
        $messageTpl = 'Class %s not found. Please install %s Composer package';
        $message = sprintf($messageTpl, $class, $package);

        return self::error($task, $message);
    }

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param string $message
     * @param array $data
     *
     * @return static
     */
    public static function error(TaskInterface $task, $message, $data = [])
    {
        return new self($task, self::EXITCODE_ERROR, $message, $data);
    }

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param \Exception $e
     * @param array $data
     *
     * @return static
     */
    public static function fromException(TaskInterface $task, \Exception $e, $data = [])
    {
        $exitCode = $e->getCode();
        if (!$exitCode) {
            $exitCode = self::EXITCODE_ERROR;
        }
        return new self($task, $exitCode, $e->getMessage(), $data);
    }

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param string $message
     * @param array $data
     *
     * @return static
     */
    public static function success(TaskInterface $task, $message = '', $data = [])
    {
        return new self($task, self::EXITCODE_OK, $message, $data);
    }

    /**
     * Return a context useful for logging messages.
     *
     * @return array
     */
    public function getContext()
    {
        $task = $this->getTask();

        return TaskInfo::getTaskContext($task) + [
            'code' => $this->getExitCode(),
            'data' => $this->getArrayCopy(),
            'time' => $this->getExecutionTime(),
            'message' => $this->getMessage(),
        ];
    }

    /**
     * Add the results from the most recent task to the accumulated
     * results from all tasks that have run so far, merging data
     * as necessary.
     *
     * @param int|string $key
     * @param \Robo\Result $taskResult
     */
    public function accumulate($key, Result $taskResult)
    {
        // If the task is unnamed, then all of its data elements
        // just get merged in at the top-level of the final Result object.
        if (static::isUnnamed($key)) {
            $this->merge($taskResult);
        } elseif (isset($this[$key])) {
            // There can only be one task with a given name; however, if
            // there are tasks added 'before' or 'after' the named task,
            // then the results from these will be stored under the same
            // name unless they are given a name of their own when added.
            $current = $this[$key];
            $this[$key] = $taskResult->merge($current);
        } else {
            $this[$key] = $taskResult;
        }
    }

    /**
     * We assume that named values (e.g. for associative array keys)
     * are non-numeric; numeric keys are presumed to simply be the
     * index of an array, and therefore insignificant.
     *
     * @param int|string $key
     *
     * @return bool
     */
    public static function isUnnamed($key)
    {
        return is_numeric($key);
    }

    /**
     * @return \Robo\Contract\TaskInterface
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return \Robo\Contract\TaskInterface
     */
    public function cloneTask()
    {
        $reflect  = new \ReflectionClass(get_class($this->task));
        return $reflect->newInstanceArgs(func_get_args());
    }

    /**
     * @return bool
     *
     * @deprecated since 1.0.
     *
     * @see wasSuccessful()
     */
    public function __invoke()
    {
        trigger_error(__METHOD__ . ' is deprecated: use wasSuccessful() instead.', E_USER_DEPRECATED);
        return $this->wasSuccessful();
    }

    /**
     * @return $this
     */
    public function stopOnFail()
    {
        if (!$this->wasSuccessful()) {
            $resultPrinter = $this->resultPrinter();
            if ($resultPrinter) {
                $resultPrinter->printStopOnFail($this);
            }
            $this->exitEarly($this->getExitCode());
        }
        return $this;
    }

    /**
     * @return ResultPrinter
     */
    protected function resultPrinter()
    {
        if (isset($this->output)) {
            // @todo: Stop using logger in ResultPrinter and we won't need this.
            $logger = Robo::logger();
            $resultPrinter = new ResultPrinter();
            $resultPrinter->setLogger($logger);
            $resultPrinter->setOutput($this->output);
            return $resultPrinter;
        }
        // @deprecated: In the future, Tasks will be required to extend BaseTask
        return Robo::resultPrinter();
    }

    public function injectDependencies($child)
    {
        if ($child instanceof OutputAwareInterface) {
            $child->setOutput($this->output);
        }
    }

    /**
     * @param int $status
     *
     * @throws \Robo\Exception\TaskExitException
     */
    private function exitEarly($status)
    {
        throw new TaskExitException($this->getTask(), $this->getMessage(), $status);
    }
}
