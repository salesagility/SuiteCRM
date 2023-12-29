<?php

namespace Robo\Task\Testing;

use Robo\Contract\CommandInterface;
use Robo\Contract\PrintedInterface;
use Robo\Task\BaseTask;
use Robo\Common\ExecOneCommand;

/**
 * Runs PHPUnit tests
 *
 * ``` php
 * <?php
 * $this->taskPHPUnit()
 *  ->group('core')
 *  ->bootstrap('test/bootstrap.php')
 *  ->run()
 *
 * ?>
 * ```
 */
class PHPUnit extends BaseTask implements CommandInterface, PrintedInterface
{
    use ExecOneCommand;

    /**
     * @var string
     */
    protected $command;

    /**
     * Directory of test files or single test file to run. Appended to
     * the command and arguments.
     *
     * @var string
     */
    protected $files = '';

    /**
     * PHPUnit constructor.
     *
     * @param null|string $pathToPhpUnit
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct($pathToPhpUnit = null)
    {
        $this->command = $pathToPhpUnit;
        if (!$this->command) {
            $this->command = $this->findExecutablePhar('phpunit');
        }
        if (!$this->command) {
            throw new \Robo\Exception\TaskException(__CLASS__, "Neither local phpunit nor global composer installation not found");
        }
    }

    /**
     * @param string $filter
     *
     * @return $this
     */
    public function filter($filter)
    {
        $this->option('filter', $filter);
        return $this;
    }

    /**
     * @param string $group
     *
     * @return $this
     */
    public function group($group)
    {
        $this->option("group", $group);
        return $this;
    }

    /**
     * @param string $group
     *
     * @return $this
     */
    public function excludeGroup($group)
    {
        $this->option("exclude-group", $group);
        return $this;
    }

    /**
     * adds `log-json` option to runner
     *
     * @param string $file
     *
     * @return $this
     */
    public function json($file = null)
    {
        $this->option("log-json", $file);
        return $this;
    }

    /**
     * adds `log-junit` option
     *
     * @param string $file
     *
     * @return $this
     */
    public function xml($file = null)
    {
        $this->option("log-junit", $file);
        return $this;
    }

    /**
     * @param string $file
     *
     * @return $this
     */
    public function tap($file = "")
    {
        $this->option("log-tap", $file);
        return $this;
    }

    /**
     * @param string $file
     *
     * @return $this
     */
    public function bootstrap($file)
    {
        $this->option("bootstrap", $file);
        return $this;
    }

    /**
     * @param string $file
     *
     * @return $this
     */
    public function configFile($file)
    {
        $this->option('-c', $file);
        return $this;
    }

    /**
     * @return $this
     */
    public function debug()
    {
        $this->option("debug");
        return $this;
    }

    /**
     * Directory of test files or single test file to run.
     *
     * @param string $files
     *   A single test file or a directory containing test files.
     *
     * @return $this
     *
     * @throws \Robo\Exception\TaskException
     *
     * @deprecated Use file() or dir() method instead
     */
    public function files($files)
    {
        if (!empty($this->files) || is_array($files)) {
            throw new \Robo\Exception\TaskException(__CLASS__, "Only one file or directory may be provided.");
        }
        $this->files = ' ' . $files;

        return $this;
    }

    /**
     * Test the provided file.
     *
     * @param string $file
     *   Path to file to test.
     *
     * @return $this
     */
    public function file($file)
    {
        return $this->files($file);
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        return $this->command . $this->arguments . $this->files;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo('Running PHPUnit {arguments}', ['arguments' => $this->arguments]);
        return $this->executeCommand($this->getCommand());
    }
}
