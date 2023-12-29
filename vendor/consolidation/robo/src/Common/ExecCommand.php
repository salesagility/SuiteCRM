<?php

namespace Robo\Common;

use Robo\Result;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * This task is supposed to be executed as shell command.
 * You can specify working directory and if output is printed.
 */
trait ExecCommand
{
    use ExecTrait;

    /**
     * @var \Robo\Common\TimeKeeper
     */
    protected $execTimer;

    /**
     * @return \Robo\Common\TimeKeeper
     */
    protected function getExecTimer()
    {
        if (!isset($this->execTimer)) {
            $this->execTimer = new TimeKeeper();
        }
        return $this->execTimer;
    }

    /**
     * Look for a "{$cmd}.phar" in the current working
     * directory; return a string to exec it if it is
     * found.  Otherwise, look for an executable command
     * of the same name via findExecutable.
     *
     * @param string $cmd
     *
     * @return bool|string
     */
    protected function findExecutablePhar($cmd)
    {
        if (file_exists("{$cmd}.phar")) {
            return "php {$cmd}.phar";
        }
        return $this->findExecutable($cmd);
    }

    /**
     * Return the best path to the executable program
     * with the provided name.  Favor vendor/bin in the
     * current project. If not found there, use
     * whatever is on the $PATH.
     *
     * @param string $cmd
     *
     * @return bool|string
     */
    protected function findExecutable($cmd)
    {
        $pathToCmd = $this->searchForExecutable($cmd);
        if ($pathToCmd) {
            return $this->useCallOnWindows($pathToCmd);
        }
        return false;
    }

    /**
     * @param string $cmd
     *
     * @return string
     */
    private function searchForExecutable($cmd)
    {
        $projectBin = $this->findProjectBin();

        $localComposerInstallation = $projectBin . DIRECTORY_SEPARATOR . $cmd;
        if (file_exists($localComposerInstallation)) {
            return $localComposerInstallation;
        }
        $finder = new ExecutableFinder();
        return $finder->find($cmd, null, []);
    }

    /**
     * @return bool|string
     */
    protected function findProjectBin()
    {
        $cwd = getcwd();
        $candidates = [ __DIR__ . '/../../vendor/bin', __DIR__ . '/../../bin', $cwd . '/vendor/bin' ];

        // If this project is inside a vendor directory, give highest priority
        // to that directory.
        $vendorDirContainingUs = realpath(__DIR__ . '/../../../..');
        if (is_dir($vendorDirContainingUs) && (basename($vendorDirContainingUs) == 'vendor')) {
            array_unshift($candidates, $vendorDirContainingUs . '/bin');
        }

        foreach ($candidates as $dir) {
            if (is_dir("$dir")) {
                return realpath($dir);
            }
        }
        return false;
    }

    /**
     * Wrap Windows executables in 'call' per 7a88757d
     *
     * @param string $cmd
     *
     * @return string
     */
    protected function useCallOnWindows($cmd)
    {
        if (defined('PHP_WINDOWS_VERSION_BUILD')) {
            if (file_exists("{$cmd}.bat")) {
                $cmd = "{$cmd}.bat";
            }
            return "call $cmd";
        }
        return $cmd;
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandDescription()
    {
        return $this->process->getCommandLine();
    }

    /**
     * @param string $command
     *
     * @return \Robo\Result
     */
    protected function executeCommand($command)
    {
        // TODO: Symfony 4 requires that we supply the working directory.
        $result_data = $this->execute(Process::fromShellCommandline($command, getcwd()));
        return new Result(
            $this,
            $result_data->getExitCode(),
            $result_data->getMessage(),
            $result_data->getData()
        );
    }
}
