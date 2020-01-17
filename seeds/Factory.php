<?php

namespace SuiteCRM;

use Faker\Generator as Faker;

class Factory {
    /**
     * The model definitions in the container.
     *
     * @var array
     */
    protected $definitions = [];

    /**
     * The Faker instance for the builder.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new factory instance.
     *
     * @param  \Faker\Generator  $faker
     * @return void
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Define a class with a given set of attributes.
     *
     * @param  string  $class
     * @param  callable  $attributes
     * @param  string  $name
     * @return $this
     */
    public function define($class, callable $attributes, $name = 'default')
    {
        $this->definitions[$class][$name] = $attributes;

        return $this;
    }
}
