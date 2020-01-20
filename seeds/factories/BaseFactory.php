<?php

namespace SuiteCRM;

use Faker;

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
        $this->faker = Faker\Factory::create();
    }

    abstract function define();
}
