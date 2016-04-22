<?php
/**
 * Created by Adam Jakab.
 * Date: 07/10/15
 * Time: 14.21
 */

namespace SuiteCrm\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Application
 * @package SuiteCrm\Console
 */
class Application extends BaseApplication
{

    /**
     * @param string $name
     * @param string $version
     */
    public function __construct($name, $version)
    {
        parent::__construct($name, $version);
        $commands = $this->enumerateCommands();
        foreach ($commands as $command) {
            $this->add(new $command);
        }
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input An Input instance
     * @param OutputInterface $output An Output instance
     *
     * @return int 0 if everything went fine, or an error code
     *
     * @throws \Exception When doRun returns Exception
     */
    public function run(InputInterface $input = NULL, OutputInterface $output = NULL)
    {
        return parent::run($input, $output);
    }

    /**
     * Returns array of FQCN of classes found under src directory
     * 1) named: *Command.php
     * 2) implementing the \SuiteCrm\Console\Command\CommandInterface
     * @return array
     */
    protected function enumerateCommands()
    {
        $answer = [];
        $searchPath = realpath(PROJECT_ROOT . '/src');
        $iterator = new \RecursiveDirectoryIterator($searchPath);
        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            if (strpos($file, 'Command.php') !== FALSE) {
                if (is_file($file)) {
                    $cmdClassPath = str_replace($searchPath . '/', '', $file);
                    $cmdClassPath = str_replace('.php', '', $cmdClassPath);
                    $cmdClassPath = str_replace('/', '\\', $cmdClassPath);
                    if (in_array('SuiteCrm\Console\Command\CommandInterface', class_implements($cmdClassPath))) {
                        $answer[] = $cmdClassPath;
                    }
                }
            }
        }
        return $answer;
    }
}
