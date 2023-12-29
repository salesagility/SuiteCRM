<?php

namespace Robo\Task\Docker;

class Result extends \Robo\Result
{

    /**
     * Do not print result, as it was already printed
     */
    protected function printResult()
    {
    }

    /**
     * @return null|string
     */
    public function getCid()
    {
        if (isset($this['cid'])) {
            return $this['cid'];
        }
        return null;
    }

    /**
     * @return null|string
     */
    public function getContainerName()
    {
        if (isset($this['name'])) {
            return $this['name'];
        }
        return null;
    }
}
