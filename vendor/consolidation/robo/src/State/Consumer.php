<?php

namespace Robo\State;

use Robo\State\Data;

interface Consumer
{
    /**
     * @return \Robo\State\Data
     */
    public function receiveState(Data $state);
}
