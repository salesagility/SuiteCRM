<?php

namespace Robo\Collection;

use Robo\Exception\AbortTasksException;
use Robo\Result;
use Robo\State\Data;
use Psr\Log\LogLevel;
use Robo\Contract\TaskInterface;
use Robo\Task\StackBasedTask;
use Robo\Task\BaseTask;
use Robo\TaskInfo;
use Robo\Contract\WrappedTaskInterface;
use Robo\Exception\TaskException;
use Robo\Exception\TaskExitException;
use Robo\Contract\CommandInterface;
use Robo\Contract\InflectionInterface;
use Robo\State\StateAwareInterface;
use Robo\State\StateAwareTrait;

/**
 * Group tasks into a collection that run together. Supports
 * rollback operations for handling error conditions.
 *
 * This is an internal class. Clients should use a CollectionBuilder
 * rather than direct use of the Collection class.  @see CollectionBuilder.
 *
 * Below, the example FilesystemStack task is added to a collection,
 * and associated with a rollback task.  If any of the operations in
 * the FilesystemStack, or if any of the other tasks also added to
 * the task collection should fail, then the rollback function is
 * called. Here, taskDeleteDir is used to remove partial results
 * of an unfinished task.
 */
class Collection extends BaseTask implements CollectionInterface, CommandInterface, StateAwareInterface
{
    use StateAwareTrait;

    /**
     * @var \Robo\Collection\Element[]
     */
    protected $taskList = [];

    /**
     * @var \Robo\Contract\TaskInterface[]
     */
    protected $rollbackStack = [];

    /**
     * @var \Robo\Contract\TaskInterface[]
     */
    protected $completionStack = [];

    /**
     * @var \Robo\Collection\CollectionInterface
     */
    protected $parentCollection;

    /**
     * @var callable[]
     */
    protected $deferredCallbacks = [];

    /**
     * @var string[]
     */
    protected $messageStoreKeys = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->resetState();
    }

    /**
     * @param int $interval
     */
    public function setProgressBarAutoDisplayInterval($interval)
    {
        if (!$this->progressIndicator) {
            return;
        }
        return $this->progressIndicator->setProgressBarAutoDisplayInterval($interval);
    }

    /**
     * {@inheritdoc}
     */
    public function add(TaskInterface $task, $name = self::UNNAMEDTASK)
    {
        $task = new CompletionWrapper($this, $task);
        $this->addToTaskList($name, $task);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addCode(callable $code, $name = self::UNNAMEDTASK)
    {
        return $this->add(new CallableTask($code, $this), $name);
    }

    /**
     * {@inheritdoc}
     */
    public function addIterable($iterable, callable $code)
    {
        $callbackTask = (new IterationTask($iterable, $code, $this))->inflect($this);
        return $this->add($callbackTask);
    }

    /**
     * {@inheritdoc}
     */
    public function rollback(TaskInterface $rollbackTask)
    {
        // Rollback tasks always try as hard as they can, and never report failures.
        $rollbackTask = $this->ignoreErrorsTaskWrapper($rollbackTask);
        return $this->wrapAndRegisterRollback($rollbackTask);
    }

    /**
     * {@inheritdoc}
     */
    public function rollbackCode(callable $rollbackCode)
    {
        // Rollback tasks always try as hard as they can, and never report failures.
        $rollbackTask = $this->ignoreErrorsCodeWrapper($rollbackCode);
        return $this->wrapAndRegisterRollback($rollbackTask);
    }

    /**
     * {@inheritdoc}
     */
    public function completion(TaskInterface $completionTask)
    {
        $collection = $this;
        $completionRegistrationTask = new CallableTask(
            function () use ($collection, $completionTask) {

                $collection->registerCompletion($completionTask);
            },
            $this
        );
        $this->addToTaskList(self::UNNAMEDTASK, $completionRegistrationTask);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function completionCode(callable $completionTask)
    {
        $completionTask = new CallableTask($completionTask, $this);
        return $this->completion($completionTask);
    }

    /**
     * {@inheritdoc}
     */
    public function before($name, $task, $nameOfTaskToAdd = self::UNNAMEDTASK)
    {
        return $this->addBeforeOrAfter(__FUNCTION__, $name, $task, $nameOfTaskToAdd);
    }

    /**
     * {@inheritdoc}
     */
    public function after($name, $task, $nameOfTaskToAdd = self::UNNAMEDTASK)
    {
        return $this->addBeforeOrAfter(__FUNCTION__, $name, $task, $nameOfTaskToAdd);
    }

    /**
     * {@inheritdoc}
     */
    public function progressMessage($text, $context = [], $level = LogLevel::NOTICE)
    {
        $context += ['name' => 'Progress'];
        $context += TaskInfo::getTaskContext($this);
        return $this->addCode(
            function () use ($level, $text, $context) {
                $context += $this->getState()->getData();
                $this->printTaskOutput($level, $text, $context);
            }
        );
    }

    /**
     * @param \Robo\Contract\TaskInterface $rollbackTask
     *
     * @return $this
     */
    protected function wrapAndRegisterRollback(TaskInterface $rollbackTask)
    {
        $collection = $this;
        $rollbackRegistrationTask = new CallableTask(
            function () use ($collection, $rollbackTask) {
                $collection->registerRollback($rollbackTask);
            },
            $this
        );
        $this->addToTaskList(self::UNNAMEDTASK, $rollbackRegistrationTask);
        return $this;
    }

    /**
     * Add either a 'before' or 'after' function or task.
     *
     * @param string $method
     * @param string $name
     * @param callable|\Robo\Contract\TaskInterface $task
     * @param string $nameOfTaskToAdd
     *
     * @return $this
     */
    protected function addBeforeOrAfter($method, $name, $task, $nameOfTaskToAdd)
    {
        if (is_callable($task)) {
            $task = new CallableTask($task, $this);
        }
        $existingTask = $this->namedTask($name);
        $fn = [$existingTask, $method];
        call_user_func($fn, $task, $nameOfTaskToAdd);
        return $this;
    }

    /**
     * Wrap the provided task in a wrapper that will ignore
     * any errors or exceptions that may be produced.  This
     * is useful, for example, in adding optional cleanup tasks
     * at the beginning of a task collection, to remove previous
     * results which may or may not exist.
     *
     * TODO: Provide some way to specify which sort of errors
     * are ignored, so that 'file not found' may be ignored,
     * but 'permission denied' reported?
     *
     * @param \Robo\Contract\TaskInterface $task
     *
     * @return \Robo\Collection\CallableTask
     */
    public function ignoreErrorsTaskWrapper(TaskInterface $task)
    {
        // If the task is a stack-based task, then tell it
        // to try to run all of its operations, even if some
        // of them fail.
        if ($task instanceof StackBasedTask) {
            $task->stopOnFail(false);
        }
        $ignoreErrorsInTask = function () use ($task) {
            $data = [];
            try {
                $result = $this->runSubtask($task);
                $message = $result->getMessage();
                $data = $result->getData();
                $data['exitcode'] = $result->getExitCode();
            } catch (AbortTasksException $abortTasksException) {
                throw $abortTasksException;
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }

            return Result::success($task, $message, $data);
        };
        // Wrap our ignore errors callable in a task.
        return new CallableTask($ignoreErrorsInTask, $this);
    }

    /**
     * @param callable $task
     *
     * @return \Robo\Collection\CallableTask
     */
    public function ignoreErrorsCodeWrapper(callable $task)
    {
        return $this->ignoreErrorsTaskWrapper(new CallableTask($task, $this));
    }

    /**
     * Return the list of task names added to this collection.
     *
     * @return string[]
     */
    public function taskNames()
    {
        return array_keys($this->taskList);
    }

    /**
     * Test to see if a specified task name exists.
     * n.b. before() and after() require that the named
     * task exist; use this function to test first, if
     * unsure.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasTask($name)
    {
        return array_key_exists($name, $this->taskList);
    }

    /**
     * Find an existing named task.
     *
     * @param string $name
     *   The name of the task to insert before.  The named task MUST exist.
     *
     * @return \Robo\Collection\Element
     *   The task group for the named task. Generally this is only
     *   used to call 'before()' and 'after()'.
     */
    protected function namedTask($name)
    {
        if (!$this->hasTask($name)) {
            throw new \RuntimeException("Could not find task named $name");
        }
        return $this->taskList[$name];
    }

    /**
     * Add a list of tasks to our task collection.
     *
     * @param \Robo\Contract\TaskInterface[] $tasks
     *   An array of tasks to run with rollback protection
     *
     * @return $this
     */
    public function addTaskList(array $tasks)
    {
        foreach ($tasks as $name => $task) {
            $this->add($task, $name);
        }
        return $this;
    }

    /**
     * Add the provided task to our task list.
     *
     * @param string $name
     * @param \Robo\Contract\TaskInterface $task
     *
     * @return $this
     */
    protected function addToTaskList($name, TaskInterface $task)
    {
        // All tasks are stored in a task group so that we have a place
        // to hang 'before' and 'after' tasks.
        $taskGroup = new Element($task);
        return $this->addCollectionElementToTaskList($name, $taskGroup);
    }

    /**
     * @param int|string $name
     * @param \Robo\Collection\Element $taskGroup
     *
     * @return $this
     */
    protected function addCollectionElementToTaskList($name, Element $taskGroup)
    {
        // If a task name is not provided, then we'll let php pick
        // the array index.
        if (Result::isUnnamed($name)) {
            $this->taskList[] = $taskGroup;
            return $this;
        }
        // If we are replacing an existing task with the
        // same name, ensure that our new task is added to
        // the end.
        $this->taskList[$name] = $taskGroup;
        return $this;
    }

    /**
     * Set the parent collection. This is necessary so that nested
     * collections' rollback and completion tasks can be added to the
     * top-level collection, ensuring that the rollbacks for a collection
     * will run if any later task fails.
     *
     * @param \Robo\Collection\NestedCollectionInterface $parentCollection
     *
     * @return $this
     */
    public function setParentCollection(NestedCollectionInterface $parentCollection)
    {
        $this->parentCollection = $parentCollection;
        return $this;
    }

    /**
     * Get the appropriate parent collection to use
     *
     * @return \Robo\Collection\CollectionInterface|$this
     */
    public function getParentCollection()
    {
        return $this->parentCollection ? $this->parentCollection : $this;
    }

    /**
     * Register a rollback task to run if there is any failure.
     *
     * Clients are free to add tasks to the rollback stack as
     * desired; however, usually it is preferable to call
     * Collection::rollback() instead.  With that function,
     * the rollback function will only be called if all of the
     * tasks added before it complete successfully, AND some later
     * task fails.
     *
     * One example of a good use-case for registering a callback
     * function directly is to add a task that sends notification
     * when a task fails.
     *
     * @param \Robo\Contract\TaskInterface $rollbackTask
     *   The rollback task to run on failure.
     *
     * @return null
     */
    public function registerRollback(TaskInterface $rollbackTask)
    {
        if ($this->parentCollection) {
            return $this->parentCollection->registerRollback($rollbackTask);
        }
        if ($rollbackTask) {
            array_unshift($this->rollbackStack, $rollbackTask);
        }
    }

    /**
     * Register a completion task to run once all other tasks finish.
     * Completion tasks run whether or not a rollback operation was
     * triggered. They do not trigger rollbacks if they fail.
     *
     * The typical use-case for a completion function is to clean up
     * temporary objects (e.g. temporary folders).  The preferred
     * way to do that, though, is to use Temporary::wrap().
     *
     * On failures, completion tasks will run after all rollback tasks.
     * If one task collection is nested inside another task collection,
     * then the nested collection's completion tasks will run as soon as
     * the nested task completes; they are not deferred to the end of
     * the containing collection's execution.
     *
     * @param \Robo\Contract\TaskInterface $completionTask
     *   The completion task to run at the end of all other operations.
     *
     * @return null
     */
    public function registerCompletion(TaskInterface $completionTask)
    {
        if ($this->parentCollection) {
            return $this->parentCollection->registerCompletion($completionTask);
        }
        if ($completionTask) {
            // Completion tasks always try as hard as they can, and never report failures.
            $completionTask = $this->ignoreErrorsTaskWrapper($completionTask);
            $this->completionStack[] = $completionTask;
        }
    }

    /**
     * Return the count of steps in this collection
     *
     * @return int
     */
    public function progressIndicatorSteps()
    {
        $steps = 0;
        foreach ($this->taskList as $name => $taskGroup) {
            $steps += $taskGroup->progressIndicatorSteps();
        }
        return $steps;
    }

    /**
     * A Collection of tasks can provide a command via `getCommand()`
     * if it contains a single task, and that task implements CommandInterface.
     *
     * @return string
     *
     * @throws \Robo\Exception\TaskException
     */
    public function getCommand()
    {
        if (empty($this->taskList)) {
            return '';
        }

        if (count($this->taskList) > 1) {
            // TODO: We could potentially iterate over the items in the collection
            // and concatenate the result of getCommand() from each one, and fail
            // only if we encounter a command that is not a CommandInterface.
            throw new TaskException($this, "getCommand() does not work on arbitrary collections of tasks.");
        }

        $taskElement = reset($this->taskList);
        $task = $taskElement->getTask();
        $task = ($task instanceof WrappedTaskInterface) ? $task->original() : $task;
        if ($task instanceof CommandInterface) {
            return $task->getCommand();
        }

        throw new TaskException($task, get_class($task) . " does not implement CommandInterface, so can't be used to provide a command");
    }

    /**
     * Run our tasks, and roll back if necessary.
     *
     * @return \Robo\Result
     */
    public function run()
    {
        $result = $this->runWithoutCompletion();
        $this->complete();
        return $result;
    }

    /**
     * @return \Robo\Result
     */
    private function runWithoutCompletion()
    {
        $result = Result::success($this);

        if (empty($this->taskList)) {
            return $result;
        }

        $this->startProgressIndicator();
        if ($result->wasSuccessful()) {
            foreach ($this->taskList as $name => $taskGroup) {
                $taskList = $taskGroup->getTaskList();
                $result = $this->runTaskList($name, $taskList, $result);
                if (!$result->wasSuccessful()) {
                    $this->fail();
                    return $result;
                }
            }
            $this->taskList = [];
        }
        $this->stopProgressIndicator();
        $result['time'] = $this->getExecutionTime();

        return $result;
    }

    /**
     * Run every task in a list, but only up to the first failure.
     * Return the failing result, or success if all tasks run.
     *
     * @param string $name
     * @param \Robo\Contract\TaskInterface[] $taskList
     * @param \Robo\Result $result
     *
     * @return \Robo\Result
     *
     * @throws \Robo\Exception\TaskExitException
     */
    private function runTaskList($name, array $taskList, Result $result)
    {
        try {
            foreach ($taskList as $taskName => $task) {
                $taskResult = $this->runSubtask($task);
                $this->advanceProgressIndicator();
                // If the current task returns an error code, then stop
                // execution and signal a rollback.
                if (!$taskResult->wasSuccessful()) {
                    return $taskResult;
                }
                // We accumulate our results into a field so that tasks that
                // have a reference to the collection may examine and modify
                // the incremental results, if they wish.
                $key = Result::isUnnamed($taskName) ? $name : $taskName;
                $result->accumulate($key, $taskResult);
                // The result message will be the message of the last task executed.
                $result->setMessage($taskResult->getMessage());
            }
        } catch (TaskExitException $exitException) {
            $this->fail();
            throw $exitException;
        } catch (\Exception $e) {
            // Tasks typically should not throw, but if one does, we will
            // convert it into an error and roll back.
            return Result::fromException($task, $e, $result->getData());
        }
        return $result;
    }

    /**
     * Force the rollback functions to run
     *
     * @return $this
     */
    public function fail()
    {
        $this->disableProgressIndicator();
        $this->runRollbackTasks();
        $this->complete();
        return $this;
    }

    /**
     * Force the completion functions to run
     *
     * @return $this
     */
    public function complete()
    {
        $this->detatchProgressIndicator();
        $this->runTaskListIgnoringFailures($this->completionStack);
        $this->reset();
        return $this;
    }

    /**
     * Reset this collection, removing all tasks.
     *
     * @return $this
     */
    public function reset()
    {
        $this->taskList = [];
        $this->completionStack = [];
        $this->rollbackStack = [];
        return $this;
    }

    /**
     * Run all of our rollback tasks.
     *
     * Note that Collection does not implement RollbackInterface, but
     * it may still be used as a task inside another task collection
     * (i.e. you can nest task collections, if desired).
     */
    protected function runRollbackTasks()
    {
        $this->runTaskListIgnoringFailures($this->rollbackStack);
        // Erase our rollback stack once we have finished rolling
        // everything back.  This will allow us to potentially use
        // a command collection more than once (e.g. to retry a
        // failed operation after doing some error recovery).
        $this->rollbackStack = [];
    }

    /**
     * @param \Robo\Contract\TaskInterface|\Robo\Collection\NestedCollectionInterface|\Robo\Contract\WrappedTaskInterface $task
     *
     * @return \Robo\Result
     */
    protected function runSubtask($task)
    {
        $original = ($task instanceof WrappedTaskInterface) ? $task->original() : $task;
        $this->setParentCollectionForTask($original, $this->getParentCollection());
        if ($original instanceof InflectionInterface) {
            $original->inflect($this);
        }
        if ($original instanceof StateAwareInterface) {
            $original->setState($this->getState());
        }
        $this->doDeferredInitialization($original);
        $taskResult = $task->run();
        $taskResult = Result::ensureResult($task, $taskResult);
        $this->doStateUpdates($original, $taskResult);
        return $taskResult;
    }

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param \Robo\State\Data $taskResult
     */
    protected function doStateUpdates($task, Data $taskResult)
    {
        $this->updateState($taskResult);
        $key = spl_object_hash($task);
        if (array_key_exists($key, $this->messageStoreKeys)) {
            $state = $this->getState();
            list($stateKey, $sourceKey) = $this->messageStoreKeys[$key];
            $value = empty($sourceKey) ? $taskResult->getMessage() : $taskResult[$sourceKey];
            $state[$stateKey] = $value;
        }
    }

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param string $key
     * @param string $source
     *
     * @return $this
     */
    public function storeState($task, $key, $source = '')
    {
        $this->messageStoreKeys[spl_object_hash($task)] = [$key, $source];

        return $this;
    }

    /**
     * @param \Robo\Contract\TaskInterface $task
     * @param string $functionName
     * @param string $stateKey
     *
     * @return $this
     */
    public function deferTaskConfiguration($task, $functionName, $stateKey)
    {
        return $this->defer(
            $task,
            function ($task, $state) use ($functionName, $stateKey) {
                $fn = [$task, $functionName];
                $value = $state[$stateKey];
                $fn($value);
            }
        );
    }

    /**
     * Defer execution of a callback function until just before a task
     * runs. Use this time to provide more settings for the task, e.g. from
     * the collection's shared state, which is populated with the results
     * of previous test runs.
     *
     * @param \Robo\Contract\TaskInterface $task
     * @param callable $callback
     *
     * @return $this
     */
    public function defer($task, $callback)
    {
        $this->deferredCallbacks[spl_object_hash($task)][] = $callback;

        return $this;
    }

    /**
     * @param \Robo\Contract\TaskInterface $task
     */
    protected function doDeferredInitialization($task)
    {
        // If the task is a state consumer, then call its receiveState method
        if ($task instanceof \Robo\State\Consumer) {
            $task->receiveState($this->getState());
        }

        // Check and see if there are any deferred callbacks for this task.
        $key = spl_object_hash($task);
        if (!array_key_exists($key, $this->deferredCallbacks)) {
            return;
        }

        // Call all of the deferred callbacks
        foreach ($this->deferredCallbacks[$key] as $fn) {
            $fn($task, $this->getState());
        }
    }

    /**
     * @param TaskInterface|NestedCollectionInterface|WrappedTaskInterface $task
     * @param \Robo\Collection\CollectionInterface $parentCollection
     */
    protected function setParentCollectionForTask($task, $parentCollection)
    {
        if ($task instanceof NestedCollectionInterface) {
            $task->setParentCollection($parentCollection);
        }
    }

    /**
     * Run all of the tasks in a provided list, ignoring failures.
     *
     * You may force a failure by throwing a ForcedException in your rollback or
     * completion task or callback.
     *
     * This is used to roll back or complete.
     *
     * @param \Robo\Contract\TaskInterface[] $taskList
     */
    protected function runTaskListIgnoringFailures(array $taskList)
    {
        foreach ($taskList as $task) {
            try {
                $this->runSubtask($task);
            } catch (AbortTasksException $abortTasksException) {
                // If there's a forced exception, end the loop of tasks.
                if ($message = $abortTasksException->getMessage()) {
                    $this->printTaskInfo($message, ['name' => 'Exception']);
                }
                break;
            } catch (\Exception $e) {
                // Ignore rollback failures.
            }
        }
    }

    /**
     * Give all of our tasks to the provided collection builder.
     *
     * @param \Robo\Collection\CollectionBuilder $builder
     */
    public function transferTasks($builder)
    {
        foreach ($this->taskList as $name => $taskGroup) {
            // TODO: We are abandoning all of our before and after tasks here.
            // At the moment, transferTasks is only called under conditions where
            // there will be none of these, but care should be taken if that changes.
            $task = $taskGroup->getTask();
            $builder->addTaskToCollection($task);
        }
        $this->reset();
    }
}
