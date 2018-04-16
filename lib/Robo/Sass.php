<?php
namespace SuiteCRM\Robo;

trait Sass
{
    use Path;
    /**
     * @param string $colorScheme eg Dawn
     */
    private function buildSuitePColorScheme($colorScheme)
    {
        $this->_exec(
            $this->toOsPath(
                "./vendor/bin/pscss -f compressed themes/SuiteP/css/{$colorScheme}/style.scss > themes/SuiteP/css/{$colorScheme}/style.css"
            )
        );
    }
}
