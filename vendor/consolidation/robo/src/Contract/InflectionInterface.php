<?php

namespace Robo\Contract;

interface InflectionInterface
{
    /**
     * Based on league/container inflection: https://container.thephpleague.com/4.x/inflectors/
     *
     * This allows us to run:
     *
     *  (new SomeTask($args))
     *    ->inflect($this)
     *    ->initializer()
     *    ->...
     *
     * Instead of:
     *
     *  (new SomeTask($args))
     *    ->setLogger($this->logger)
     *    ->initializer()
     *    ->...
     *
     * The reason `inflect` is better than the more explicit alternative is
     * that subclasses of BaseTask that implement a new FooAwareInterface
     * can override injectDependencies() as explained below, and add more
     * dependencies that can be injected as needed.
     *
     * @param \Robo\Contract\InflectionInterface $parent
     */
    public function inflect($parent);

    /**
     * Take all dependencies availble to this task and inject any that are
     * needed into the provided task.  The general pattern is that, for every
     * FooAwareInterface that this class implements, it should test to see
     * if the child also implements the same interface, and if so, should call
     * $child->setFoo($this->foo).
     *
     * The benefits of this are pretty large. Any time an object that implements
     * InflectionInterface is created, just call `$child->inflect($this)`, and
     * any available optional dependencies will be hooked up via setter injection.
     *
     * The required dependencies of an object should be provided via constructor
     * injection, not inflection.
     *
     * @param mixed $child An object with one or more *AwareInterfaces implemented.
     *
     * @see https://mwop.net/blog/2016-04-26-on-locators.html
     */
    public function injectDependencies($child);
}
