<?php

namespace SuiteCRM;

use Error;
use \LoggerManager;

abstract class Seeder
{
    /**
     * Seed the given connection from the given path.
     *
     * @param array|string $class
     * @return $this
     */
    public function call($class)
    {
        if (is_null($class)) {
            throw new \InvalidArgumentException('Class is null.');
        }

        $classes = is_array($class) ? $class : [$class];
        
        $logger = LoggerManager::getLogger();

        foreach ($classes as $class) {
            $seeder = $this->resolve($class);

            $name = get_class($seeder);

            $startTime = microtime(true);

            $seeder->__invoke();

            $runTime = round(microtime(true) - $startTime, 2);

            $logger->fatal("Seeded: {$name} ({$runTime} seconds)");
        }

        return $this;
    }

    /**
     * Resolve an instance of the given seeder class.
     *
     * @param string $class
     * @return \SuiteCRM\Seeder
     */
    protected function resolve($class)
    {
        return new $class;
    }

    public function run() {
        throw new Error("run() not implemented.");
        return false;
    }

    /**
     * Run the database seeds.
     *
     * @return mixed
     */
    public function __invoke()
    {
        if (! method_exists($this, 'run')) {
            throw new \InvalidArgumentException('Method [run] missing from '.get_class($this));
        }

        return $this->run();
    }

    /**
     * Get a closure to resolve the given type from the container.
     *
     * @param  string  $abstract
     * @return \Closure
     */
    public function factory($abstract)
    {
        return function () use ($abstract) {
            return $this->make($abstract);
        };
    }

    /**
     * Resolve the given type from the container.
     *
     * @param  string  $abstract
     * @return mixed
     */
    public function make($abstract)
    {
        return $this->resolve($abstract);
    }
}
