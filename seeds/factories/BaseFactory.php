<?php

namespace SuiteCRM;

use Faker\Generator as Faker;

abstract class BaseFactory {
    /** @var Faker */
    public $faker;

    /**
     * Create a new factory instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = new Faker();
    }

    abstract function define();
}
