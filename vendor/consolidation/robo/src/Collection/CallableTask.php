<?php

namespace Robo\Collection;

use Robo\Result;
use Robo\Contract\TaskInterface;
use Robo\State\StateAwareInterface;
use Robo\State\Data;

/**
 * Creates a task wrapper that converts any Callable into an
 * object that can be used directly with a task collection.
 *
 * It is not necessary to use this class directly; Collection will
 * automatically wrap Callables when they are added.
 */
class CallableTask implements TaskInterface
{
    /**
     * @var callable
     */
    protected $fn;

    /**
     * @var \Robo\Contract\TaskInterface
     */
    protected $reference;

    public function __construct(callable $fn, TaskInterface $reference)
    {
        $this->fn = $fn;
        $this->reference = $reference;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $result = call_user_func($this->fn, $this->getState());
        // If the function returns no result, then count it
        // as a success.
        if (!isset($result)) {
            $result = Result::success($this->reference);
        }
        // If the function returns a result, it must either return
        // a \Robo\Result or an exit code.  In the later case, we
        // convert it to a \Robo\Result.
        if (!$result instanceof Result) {
            $result = new Result($this->reference, $result);
        }

        return $result;
    }

    /**
     * @return \Robo\State\Data
     */
    public function getState()
    {
        if ($this->reference instanceof StateAwareInterface) {
            return $this->reference->getState();
        }
        return new Data();
    }
}
