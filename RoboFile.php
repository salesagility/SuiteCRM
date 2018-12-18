<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    // define public methods as commands

    /**
     * Clean 'cache/' directory

     * @throws \RuntimeException
     * @return nothing
     */
    public function cleanCache()
    {
        $this->taskCleanDir(['cache'])->run();
    }
}
