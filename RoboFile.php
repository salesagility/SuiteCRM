<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{

    /**
     * Clean 'cache/' directory

     * @throws \RuntimeException
     * @return nothing
     */
    public function cleanCache()
    {
        $toDelete = array();
        $doNotDelete = array('Emails', 'emails', '.', '..');
        $cacheToDelete = array('cache/Relationships',
                               'cache/csv',
                               'cache/dashlets',
                               'cache/diagnostics',
                               'cache/dynamic_fields',
                               'cache/feeds',
                               'cache/import',
                               'cache/include/javascript',
                               'cache/jsLanguage',
                               'cache/pdf',
                               'cache/themes',
                               'cache/xml',
        );

        foreach ($cacheToDelete as  $dir) {
            if ((file_exists($dir) && is_dir($dir))) {
                $toDelete[] = $dir;
            }
        }

        $cacheModules = 'cache/modules';
        $modules = scandir($cacheModules);

        foreach ($modules as $module) {
            if (file_exists($cacheModules.'/'.$module)
                && is_dir($cacheModules.'/'.$module)
                && !in_array($module, $doNotDelete)
            ) {
                $toDelete[] = $cacheModules.'/'.$module;
            }
        }
        $this->_cleanDir($toDelete);
    }
}
