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
use SuiteCRM\Utility\Paths;
use Symfony\Component\Yaml\Yaml;

class CodeCoverageCommands extends \Robo\Tasks
{
    use loadTasks;
    use RoboTrait;

    /**
     * Runs code coverage for travis ci
     * @throws RuntimeException
     */
    public function codeCoverage()
    {
        $this->say('Code Coverage');

        // Get environment
        if ($this->isEnvironmentTravisCI()) {
            $range = $this->getCommitRangeForTravisCi();
        } else {
            throw new \RuntimeException('unable to detect continuous integration environment');
        }

        $this->disableStateChecker();
        $this->generateCodeCoverageFile();

        $this->say('Code Coverage Completed');
    }

    /**
     * @return bool
     */
    private function isEnvironmentTravisCI()
    {
        return !empty(getenv('TRAVIS'));
    }

    /**
     * @return array|false|string git commit range from travis ci
     * e.g. 3b762531a80e768c2b303f4cce0189386a9f71d4...921bd12b282b0a984a83cc3d7e2a43bc21f2694f
     */
    private function getCommitRangeForTravisCi()
    {
        return getenv('TRAVIS_COMMIT_RANGE');
    }

    /**
     * Run code coverage command
     */
    private function generateCodeCoverageFile()
    {
        $this->_exec($this->getCodeCoverageCommand());
    }

    /**
     * Disables the state checker
     */
    private function disableStateChecker()
    {
        global $sugar_config;
        require_once 'include/utils/file_utils.php';

        $sugar_config['state_checker']['test_state_check_mode'] = 0;

        return write_array_to_file(
            'sugar_config',
            $sugar_config,
            'config_override.php'
        );
    }

    private function getCodeCoverageCommand()
    {
        $os = new OperatingSystem();
        $command =
            $os->toOsPath('./vendor/bin/phpunit')
            . ' --configuration ./tests/phpunit.xml.dist --coverage-clover ./tests/_output/coverage.xml ./tests/unit/phpunit';
        return $command;
    }
}
