<?php

namespace Consolidation\AnnotatedCommand\Input;

/**
 * StdinAwareTrait provides the implementation for StdinAwareInterface.
 */
trait StdinAwareTrait
{
    protected $stdinHandler;

    /**
     * @inheritdoc
     */
    public function setStdinHandler(StdinHandler $stdin)
    {
        $this->stdinHandler = $stdin;
    }

    /**
     * @inheritdoc
     */
    public function stdin()
    {
        if (!$this->stdinHandler) {
            $this->stdinHandler = new StdinHandler();
        }
        return $this->stdinHandler;
    }
}
