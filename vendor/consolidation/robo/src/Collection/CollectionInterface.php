<?php

namespace Robo\Collection;

use Psr\Log\LogLevel;
use Robo\Contract\TaskInterface;

interface CollectionInterface extends NestedCollectionInterface
{
    /**
     * Unnamed tasks are assigned an arbitrary numeric index
     * in the task list. Any numeric value may be used, but the
     * UNNAMEDTASK constant is recommended for clarity.
     *
     * @var int
     */
    const UNNAMEDTASK = 0;

    /**
     * Add a task or a list of tasks to our task collection.  Each task
     * will run via its 'run()' method once (and if) all of the tasks
     * added before it complete successfully.  If the task also implements
     * RollbackInterface, then it will be rolled back via its 'rollback()'
     * method ONLY if its 'run()' method completes successfully, and some
     * task added after it fails.
     *
     * @param \Robo\Contract\TaskInterface $task
     *   The task to add to our collection.
     * @param int|string $name
     *   An optional name for the task -- missing or UNNAMEDTASK for unnamed tasks.
     *   Names are used for positioning before and after tasks.
     *
     * @return $this
     */
    public function add(TaskInterface $task, $name = self::UNNAMEDTASK);

    /**
     * Add arbitrary code to execute as a task.
     *
     * @param callable $code
     *   Code to execute as a task
     * @param int|string $name
     *   An optional name for the task -- missing or UNNAMEDTASK for unnamed tasks.
     *   Names are used for positioning before and after tasks.
     *
     * @return $this
     */
    public function addCode(callable $code, $name = self::UNNAMEDTASK);

    /**
     * Add arbitrary code that will be called once for every item in the
     * provided array or iterable object.  If the function result of the
     * provided callback is a TaskInterface or Collection, then it will be
     * executed.
     *
     * @param static|array $iterable
     *   A collection of things to iterate.
     * @param callable $code
     *   A callback function to call for each item in the collection.
     *
     * @return $this
     */
    public function addIterable($iterable, callable $code);

    /**
     * Add a rollback task to our task collection.  A rollback task
     * will execute ONLY if all of the tasks added before it complete
     * successfully, AND some task added after it fails.
     *
     * @param \Robo\Contract\TaskInterface $rollbackTask
     *   The rollback task to add.  Note that the 'run()' method of the
     *   task executes, not its 'rollback()' method.  To use the 'rollback()'
     *   method, add the task via 'Collection::add()' instead.
     *
     * @return $this
     */
    public function rollback(TaskInterface $rollbackTask);

    /**
     * Add arbitrary code to execute as a rollback.
     *
     * @param callable $rollbackTask
     *   Code to execute during rollback processing.
     *
     * @return $this
     */
    public function rollbackCode(callable $rollbackTask);

    /**
     * Add a completion task to our task collection.  A completion task
     * will execute EITHER after all tasks succeed, OR immediatley after
     * any task fails.  Completion tasks never cause errors to be returned
     * from Collection::run(), even if they fail.
     *
     * @param \Robo\Contract\TaskInterface $completionTask
     *   The completion task to add.  Note that the 'run()' method of the
     *   task executes, just as if the task was added normally.
     *
     * @return $this
     */
    public function completion(TaskInterface $completionTask);

    /**
     * Add arbitrary code to execute as a completion.
     *
     * @param callable $completionTask
     *   Code to execute after collection completes
     *
     * @return $this
     */
    public function completionCode(callable $completionTask);

    /**
     * Add a task before an existing named task.
     *
     * @param string $name
     *   The name of the task to insert before.  The named task MUST exist.
     * @param callable|\Robo\Contract\TaskInterface $task
     *   The task to add.
     * @param int|string $nameOfTaskToAdd
     *   The name of the task to add. If not provided, will be associated
     *   with the named task it was added before.
     *
     * @return $this
     */
    public function before($name, $task, $nameOfTaskToAdd = self::UNNAMEDTASK);

    /**
     * Add a task after an existing named task.
     *
     * @param string $name
     *   The name of the task to insert before.  The named task MUST exist.
     * @param callable|\Robo\Contract\TaskInterface $task
     *   The task to add.
     * @param int|string $nameOfTaskToAdd
     *   The name of the task to add. If not provided, will be associated
     *   with the named task it was added after.
     *
     * @return $this
     */
    public function after($name, $task, $nameOfTaskToAdd = self::UNNAMEDTASK);

    /**
     * Print a progress message after Collection::run() has executed
     * all of the tasks that were added prior to the point when this
     * method was called. If one of the previous tasks fail, then this
     * message will not be printed.
     *
     * @param string $text
     *   Message to print.
     * @param array $context
     *   Extra context data for use by the logger. Note
     *   that the data from the collection state is merged with the provided context.
     * @param \Psr\Log\LogLevel|string $level
     *   The log level to print the information at. Default is NOTICE.
     *
     * @return $this
     */
    public function progressMessage($text, $context = [], $level = LogLevel::NOTICE);
}
