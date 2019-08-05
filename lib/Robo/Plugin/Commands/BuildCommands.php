<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

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
     * @param array $opts optional command line arguments
     * color_scheme - set which color scheme you wish to build
     * @throws \RuntimeException
     */
    public function buildSuiteP(array $opts = ['color_scheme' => ''])
    {
        $this->say('Compile SuiteP Theme (SASS)');
        if (empty($this->$opts['color_scheme'])) {
            /** Look for Subthemes in the SuiteP theme Dir **/
            $std = 'themes/SuiteP/css/';
            $this->locateSubTheme($std);
            /** Look for Subthemes in the custom/theme Dir **/
            // Good opportunity to refactor here.
            // Does the same as above just looks in the custom directory.
            $ctd = 'custom/themes/SuiteP/css/';
            $this->locateSubTheme($ctd);

            return;

        }

        if (is_array($this->$opts['color_scheme'])) {
            foreach ($this->$opts['color_scheme'] as $colorScheme) {
                $this->buildSuitePColorScheme($colorScheme);
            }

            return;
        }

        $this->buildSuitePColorScheme($this->$opts['color_scheme']);
        $this->say('Compile SuiteP Theme (SASS) Complete');
    }

    /**
     * @param string $colorScheme eg Dawn
     * @param string $location eg Directory to work from
     * @throws \RuntimeException
     */
    private function buildSuitePColorScheme($colorScheme, $location = 'themes/SuiteP/css/')
    {
        $os = new OperatingSystem();
        $command =
            $os->toOsPath('./vendor/bin/pscss')
            . ' -f compressed '
            . $os->toOsPath("{$location}{$colorScheme}/style.scss")
            . ' > '
            . $os->toOsPath("{$location}{$colorScheme}/style.css");
        $this->_exec($command);
    }

    /**
     * @param string $directory
     */
    private function locateSubTheme($directory)
    {
        if (is_dir($directory) && $dir = opendir($directory)) {
            while (false !== ($file = readdir($dir))) {
                if (filetype($directory . $file) === 'dir' && file_exists($directory . $file . '/style.scss')) {
                    if (file_exists($directory . $file . '/style.css')) {
                        $this->say("Found style.css for {$file}, Removing");
                        unlink($directory . $file . '/style.css');
                    }
                    $this->say("Found style.scss for {$file}, Compiling");
                    $this->buildSuitePColorScheme($file, $directory);
                }
            }
        }
    }
}
