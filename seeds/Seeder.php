<?php

namespace SuiteCRM;

use \LoggerManager;

abstract class Seeder
{
    /**
     * Seed the given connection from the given path.
     *
     * @param array|string $class
     * @return $this
     */
    public static function call($class)
    {
        if (is_null($class)) {
            throw new \InvalidArgumentException('Class is null.');
        }

        $classes = is_array($class) ? $class : [$class];
        
        $logger = LoggerManager::getLogger();

        foreach ($classes as $class) {
            $seeder = self::resolve($class);

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
    protected static function resolve($class)
    {
        return new $class;
    }

    /**
     * Run the database seeds.
     *
     * @return mixed
     */
    public function __invoke()
    {
        if (! method_exists($this, 'run')) {
            throw new \InvalidArgumentException('Method [run] missing from ' . get_class($this));
        }

        return $this->run();
    }

    abstract public static function run();
}
