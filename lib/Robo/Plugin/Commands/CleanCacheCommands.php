<?php

namespace SuiteCRM\Robo\Plugin\Commands;

use SuiteCRM\Robo\Traits\CliRunnerTrait;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class CleanCacheCommands
 *
 * @category RoboTasks
 * @package  SuiteCRM\Robo\Plugin\Commands
 * @author   Jose C. Massón <jose@gcoop.coop>
 * @license  GNU GPLv3
 * @link     CleanCacheCommands
 */

class CleanCacheCommands extends \Robo\Tasks
{
    use CliRunnerTrait;

    /**
     * Clean 'cache/' directory

     * @param array $opts
     * @throws \RuntimeException
     * @return void
     *
     * @command cache:clean
     * @aliases clean:cache
     * @option  force Force clean directories without confirmation
     */
    public function cleanCache($opts = ['force' => false])
    {
        global $sugar_config;
        $this->bootstrap();
        $cacheDir = isset($sugar_config) && isset($sugar_config['cache_dir']) ? $sugar_config['cache_dir'] : 'cache';

        $toDelete = array();
        $doNotDelete = array('Emails', 'emails', '.', '..');
        $cachesToDelete = array('Relationships',
                               'csv',
                               'dashlets',
                               'diagnostics',
                               'dynamic_fields',
                               'feeds',
                               'import',
                               'include/javascript',
                               'jsLanguage',
                               'pdf',
                               'themes',
                               'xml',
        );

        // Calculate sub-caches to clear
        $subCachesToDelete = new Finder();
        $subCachesToDelete
            ->directories()
            ->in($cacheDir)
            ->filter(function(SplFileInfo $directory) use ($cachesToDelete) {
                return in_array($directory->getRelativePathname(), $cachesToDelete);
            });

        $this->say("Found Sub-Cache Directories to Clean: ");
        $this->io()->listing(iterator_to_array($subCachesToDelete));
        $toDelete = array_merge($toDelete, iterator_to_array($subCachesToDelete));

        // Calculate cached modules to clear
        $moduleCachesToDelete = new Finder();
        $moduleCachesToDelete
            ->directories()
            ->depth(' == 0')
            ->in($cacheDir . 'modules')
            ->exclude($doNotDelete);

        $this->say("Found Module-Cache Directories to Clean: ");
        $this->io()->listing(iterator_to_array($moduleCachesToDelete));
        $toDelete = array_merge($toDelete, iterator_to_array($moduleCachesToDelete));

        // Confirm and clean cache directories
        $confirm = $opts['force'] || $this->confirm('Would you like to clean the above caches?');
        if ($confirm) {
            $this->_cleanDir($toDelete);
        }
    }
}
