<?php
namespace SuiteCRM\Robo\Plugin\Commands;

use SuiteCRM\Utility\OperatingSystem;
use SuiteCRM\Robo\Traits\RoboTrait;
use Robo\Task\Base\loadTasks;

class BuildCommands extends \Robo\Tasks
{
    use loadTasks;
    use RoboTrait;
    // define public methods as commands

    /**
     * Build SuiteP theme
     * @params array $opts optional command line arguments
     * color_scheme - set which color scheme you wish to build
     * @throws \RuntimeException
     */
    public function buildSuitep(array $opts = ['color_scheme' => ''])
    {
        $this->say('Compile SuiteP Theme (SASS)');
        if (empty($this->opts['color_scheme'])) {
            $this->buildSuitePColorScheme('Dawn');
            $this->buildSuitePColorScheme('Day');
            $this->buildSuitePColorScheme('Dusk');
            $this->buildSuitePColorScheme('Night');
        } elseif (is_array($this->opts['color_scheme'])) {
            foreach ($this->opts['color_scheme'] as $colorScheme) {
                $this->buildSuitePColorScheme($colorScheme);
            }
        } else {
            $this->buildSuitePColorScheme($this->opts['color_scheme']);
        }
        $this->say('Compile SuiteP Theme (SASS) Complete');
    }

    /**
     * @param string $colorScheme eg Dawn
     * @throws \RuntimeException
     */
    private function buildSuitePColorScheme($colorScheme)
    {
        $os = new OperatingSystem();
        $command = $os->toOsPath(
            "./vendor/bin/pscss -f compressed themes/SuiteP/css/{$colorScheme}/style.scss > themes/SuiteP/css/{$colorScheme}/style.css"
        );
        $this->_exec($command);
    }
}
