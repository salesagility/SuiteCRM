<?php

namespace Robo;

use Robo\Common\IO;
use Robo\Contract\IOAwareInterface;
use Robo\Contract\BuilderAwareInterface;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;

class Tasks implements BuilderAwareInterface, IOAwareInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    use LoadAllTasks; // uses TaskAccessor, which uses BuilderAwareTrait
    use IO;

    /**
     * @param bool $stopOnFail
     */
    protected function stopOnFail($stopOnFail = true)
    {
        Result::$stopOnFail = $stopOnFail;
    }
}
