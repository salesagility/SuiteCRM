<?php
/**
 * Created by Adam Jakab.
 * Date: 08/03/16
 * Time: 9.03
 */

namespace SuiteCrm\Install;

use SuiteCrm\Console\Command\Command;
use SuiteCrm\Console\Command\CommandInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser;

/**
 * Class InstallCommand
 * @package SuiteCrm\Install
 */
class InstallCommand extends Command implements CommandInterface
{
    const COMMAND_NAME = 'app:install';
    const COMMAND_DESCRIPTION = 'Install the SuiteCrm application';

    /** @var  LoggerManager */
    protected $loggerManager;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(NULL);
    }

    /**
     * Configure command
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::COMMAND_DESCRIPTION);

        $commandConfig = InstallUtils::getYamlData('command_config.yml');
        $sections = array_keys($commandConfig);

        $commandModeMap = [
            'none' => InputOption::VALUE_NONE,
            'required' => InputOption::VALUE_REQUIRED,
            'optional' => InputOption::VALUE_OPTIONAL,
        ];

        //SETUP OPTIONS FROM CONFIGURATION
        foreach ($sections as $section) {
            foreach ($commandConfig[$section] as $name => $data) {
                $commandName = $section . '-' . $name;
                $commandShortcut = NULL;
                $commandMode = InputOption::VALUE_OPTIONAL;
                $commandDescription = NULL;
                $commandDefaultValue = NULL;
                if (is_array($data)) {
                    $commandDefaultValue = isset($data["default"]) ? $data["default"] : $commandDefaultValue;
                    $commandMode = isset($data["mode"])
                                   && array_key_exists(
                                       $data["mode"], $commandModeMap
                                   ) ? $commandModeMap[$data["mode"]] : $commandMode;
                    $commandDescription = isset($data["description"]) ? $data["description"] : $commandDescription;
                    $commandShortcut = isset($data["shortcut"]) ? $data["shortcut"] : $commandShortcut;
                }
                else {
                    $commandDefaultValue = !empty($data) ? $data : $commandDefaultValue;
                }
                $this->addOption(
                    $commandName, $commandShortcut, $commandMode, $commandDescription, $commandDefaultValue
                );
            }
        }

        //ADDITIONAL OPTIONS
        $this->addOption(
            'force', 'f', InputOption::VALUE_NONE,
            "Force the installation to run even if 'installer_locked' is set to true in config.php"
        );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::_execute($input, $output);
        $this->loggerManager = new LoggerManager($this->cmdOutput);
        $this->log("Starting command " . static::COMMAND_NAME . "...");
        $this->log(str_repeat("-", 80));
        $installer = new Installer($this->cmdInput->getOptions(), $this->loggerManager);
        $installer->install();
        $this->log(str_repeat("-", 80));
        $this->log("Command " . static::COMMAND_NAME . " done.");
        return true;
    }

    /**
     * @param string $msg
     * @param string $level - available: debug|info|warn|deprecated|error|fatal|security|off
     */
    protected function log($msg, $level = 'warn')
    {
        $this->loggerManager->log($msg, $level);
    }
}