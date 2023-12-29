<?php

namespace Robo\State;

use Robo\State\Data;

interface StateAwareInterface
{
    /**
     * @return \Robo\State\Data
     */
    public function getState();

    /**
     * @param \Robo\State\Data $state
     */
    public function setState(Data $state);

    /**
     * @param int|string $key
     * @param mixed $value
     */
    public function setStateValue($key, $value);

    /**
     * @param \Robo\State\Data
     *   Update state takes precedence over current state.
     */
    public function updateState(Data $update);

    public function resetState();
}
