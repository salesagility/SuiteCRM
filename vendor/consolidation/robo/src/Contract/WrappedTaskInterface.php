<?php

namespace Robo\Contract;

interface WrappedTaskInterface extends TaskInterface
{
    /**
     * @return \Robo\Contract\TaskInterface
     */
    public function original();
}
