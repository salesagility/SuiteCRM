<?php

namespace Robo\Task\Testing;

use Robo\Contract\PrintedInterface;
use Robo\Exception\TaskException;
use Robo\Task\BaseTask;
use Robo\Contract\CommandInterface;
use Robo\Common\ExecOneCommand;

/**
 * Executes Codeception tests
 *
 * ``` php
 * <?php
 * // config
 * $this->taskCodecept()
 *      ->suite('acceptance')
 *      ->env('chrome')
 *      ->group('admin')
 *      ->xml()
 *      ->html()
 *      ->run();
 *
 * ?>
 * ```
 *
 */
class Codecept extends BaseTask implements CommandInterface, PrintedInterface
{
    use ExecOneCommand;

    /**
     * @var string
     */
    protected $command;
    protected $providedPathToCodeception;

    /**
     * @param string $pathToCodeception
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct($pathToCodeception = '')
    {
        $this->providedPathToCodeception = $pathToCodeception;
    }

    /**
     * @param string $suite
     *
     * @return $this
     */
    public function suite($suite)
    {
        $this->option(null, $suite);
        return $this;
    }

    /**
     * @param string $testName
     *
     * @return $this
     */
    public function test($testName)
    {
        $this->option(null, $testName);
        return $this;
    }

    /**
     * set group option. Can be called multiple times
     *
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
        $this->option("skip-group", $group);
        return $this;
    }

    /**
     * generate json report
     *
     * @param string $file
     *
     * @return $this
     */
    public function json($file = null)
    {
        $this->option("json", $file);
        return $this;
    }

    /**
     * generate xml JUnit report
     *
     * @param string $file
     *
     * @return $this
     */
    public function xml($file = null)
    {
        $this->option("xml", $file);
        return $this;
    }

    /**
     * Generate html report
     *
     * @param string $dir
     *
     * @return $this
     */
    public function html($dir = null)
    {
        $this->option("html", $dir);
        return $this;
    }

    /**
     * generate tap report
     *
     * @param string $file
     *
     * @return $this
     */
    public function tap($file = null)
    {
        $this->option("tap", $file);
        return $this;
    }

    /**
     * provides config file other then default `codeception.yml` with `-c` option
     *
     * @param string $file
     *
     * @return $this
     */
    public function configFile($file)
    {
        $this->option("-c", $file);
        return $this;
    }

    /**
     * collect codecoverage in raw format. You may pass name of cov file to save results
     *
     * @param null|string $cov
     *
     * @return $this
     */
    public function coverage($cov = null)
    {
        $this->option("coverage", $cov);
        return $this;
    }

    /**
     * execute in silent mode
     *
     * @return $this
     */
    public function silent()
    {
        $this->option("silent");
        return $this;
    }

    /**
     * collect code coverage in xml format. You may pass name of xml file to save results
     *
     * @param string $xml
     *
     * @return $this
     */
    public function coverageXml($xml = null)
    {
        $this->option("coverage-xml", $xml);
        return $this;
    }

    /**
     * collect code coverage and generate html report. You may pass
     *
     * @param string $html
     *
     * @return $this
     */
    public function coverageHtml($html = null)
    {
        $this->option("coverage-html", $html);
        return $this;
    }

    /**
     * @param string $env
     *
     * @return $this
     */
    public function env($env)
    {
        $this->option("env", $env);
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
     * @return $this
     */
    public function noRebuild()
    {
        $this->option("no-rebuild");
        return $this;
    }

    /**
     * @return $this
     */
    public function noExit()
    {
        $this->option("no-exit");
        return $this;
    }

    /**
     * @param string $failGroup
     * @return $this
     */
    public function failGroup($failGroup)
    {
        $this->option('override', "extensions: config: Codeception\\Extension\\RunFailed: fail-group: {$failGroup}");
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        if (!$this->command) {
            $this->command = $this->providedPathToCodeception;
            if (!$this->command) {
                $this->command = $this->findExecutable('codecept');
            }
            if (!$this->command) {
                debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
                throw new TaskException(__CLASS__, "Neither composer nor phar installation of Codeception found.");
            }
            $this->command .= ' run';
        }

        return $this->command . $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $command = $this->getCommand();
        $this->printTaskInfo('Executing {command}', ['command' => $command]);
        return $this->executeCommand($command);
    }
}
