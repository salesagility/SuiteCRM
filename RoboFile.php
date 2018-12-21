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
        $toDelete = array('cache/xml',
                          'cache/import',
                          'cache/dashlets',
                          'cache/modules',
                          'cache/smarty',
                          'cache/jsLanguage',
                          'cache/themes',
                          'cache/Relationships',
                          'cache/include/javascript',);

        foreach ($toDelete as  $dir) {
            if ((file_exists($dir) && is_dir($dir))) {
                $this->_cleanDir([$dir]);
            }
        }
    }
}
