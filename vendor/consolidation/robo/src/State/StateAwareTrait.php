<?php

namespace Robo\State;

use Robo\State\Data;

/**
 * @see \Robo\State\StateAwareInterface
 */
trait StateAwareTrait
{
    /**
     * @var \Robo\State\Data
     */
    protected $state;

    /**
     * @return \Robo\State\Data
     */
    public function getState()
    {
        return $this->state;
    }

    public function setState(Data $state)
    {
        $this->state = $state;
    }

    /**
     * @param int|string $key
     * @param mixed $value
     */
    public function setStateValue($key, $value)
    {
        $this->state[$key] = $value;
    }

    public function updateState(Data $update)
    {
        $this->state->update($update);
    }

    public function resetState()
    {
        $this->state = new Data();
    }
}
