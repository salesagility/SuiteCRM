<?php

/**
 * Class TestLogger
 */
class TestLogger
{

    /**
     * @var array
     */
    public $calls;

    /**
     * TestLogger constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        $this->calls[$name][] = $arguments;
    }

    /**
     *
     */
    public function reset()
    {
        $this->calls = array();
    }

}