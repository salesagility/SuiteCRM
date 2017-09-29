<?php

class TestLogger
{

    public $calls;

    public function __construct()
    {
        $this->calls = array();
    }

    public function __call($name, $arguments)
    {
        $this->calls[$name][] = $arguments;
    }

}