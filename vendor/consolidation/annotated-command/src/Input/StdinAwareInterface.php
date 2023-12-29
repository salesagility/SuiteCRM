<?php

namespace Consolidation\AnnotatedCommand\Input;

/**
 * StdinAwareInterface should be implemented by classes that read from
 * standard input. This class contains facilities to redirect stdin to
 * instead read from a file, e.g. in response to an option or argument
 * value.
 *
 * Using StdinAwareInterface is preferable to reading from php://stdin
 * directly, as it provides a mechanism to instead inject an instance
 * of StdinHandler that reads from a file, e.g. in tests.
 *
 * n.b. If the standard input handler is fetched prior to any code
 * injecting an stdin handler, you will get an object that is configured
 * to read from php://stdin.
 */
interface StdinAwareInterface
{
    /**
     * Sets the standard input handler.
     *
     * @param StdinHandler
     */
    public function setStdinHandler(StdinHandler $stdin);

    /**
     * Returns the standard input handler.
     *
     * @return StdinHandler
     */
    public function stdin();
}
