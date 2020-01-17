<?php

namespace SuiteCRM;

abstract class BaseFactory {
    /** @var Faker\Generator */
    public $faker;

    /**
     * Create a new factory instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    abstract function define();
}
