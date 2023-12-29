<?php
// Copyright 2004-present Facebook. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

namespace Facebook\WebDriver\Remote\Service;

use Exception;
use Facebook\WebDriver\Net\URLChecker;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Start local WebDriver service (when remote WebDriver server is not used).
 */
class DriverService
{
    /**
     * @var string
     */
    private $executable;

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $args;

    /**
     * @var array
     */
    private $environment;

    /**
     * @var Process|null
     */
    private $process;

    /**
     * @param string $executable
     * @param int $port The given port the service should use.
     * @param array $args
     * @param array|null $environment Use the system environment if it is null
     */
    public function __construct($executable, $port, $args = [], $environment = null)
    {
        $this->executable = self::checkExecutable($executable);
        $this->url = sprintf('http://localhost:%d', $port);
        $this->args = $args;
        $this->environment = $environment ?: $_ENV;
    }

    /**
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }

    /**
     * @return DriverService
     */
    public function start()
    {
        if ($this->process !== null) {
            return $this;
        }

        $this->process = $this->createProcess();
        $this->process->start();

        $checker = new URLChecker();
        $checker->waitUntilAvailable(20 * 1000, $this->url . '/status');

        return $this;
    }

    /**
     * @return DriverService
     */
    public function stop()
    {
        if ($this->process === null) {
            return $this;
        }

        $this->process->stop();
        $this->process = null;

        $checker = new URLChecker();
        $checker->waitUntilUnavailable(3 * 1000, $this->url . '/shutdown');

        return $this;
    }

    /**
     * @return bool
     */
    public function isRunning()
    {
        if ($this->process === null) {
            return false;
        }

        return $this->process->isRunning();
    }

    /**
     * Check if the executable is executable.
     *
     * @param string $executable
     * @throws Exception
     * @return string
     */
    protected static function checkExecutable($executable)
    {
        if (!is_file($executable)) {
            throw new Exception("'$executable' is not a file.");
        }

        if (!is_executable($executable)) {
            throw new Exception("'$executable' is not executable.");
        }

        return $executable;
    }

    /**
     * @return Process
     */
    private function createProcess()
    {
        // BC: ProcessBuilder deprecated since Symfony 3.4 and removed in Symfony 4.0.
        if (class_exists(ProcessBuilder::class)
            && false === mb_strpos('@deprecated', (new \ReflectionClass(ProcessBuilder::class))->getDocComment())
        ) {
            $processBuilder = (new ProcessBuilder())
                ->setPrefix($this->executable)
                ->setArguments($this->args)
                ->addEnvironmentVariables($this->environment);

            return $processBuilder->getProcess();
        }
        // Safe to use since Symfony 3.3
        $commandLine = array_merge([$this->executable], $this->args);

        return new Process($commandLine, null, $this->environment);
    }
}
