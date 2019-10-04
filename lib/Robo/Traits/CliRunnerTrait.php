<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2019 SalesAgility Ltd.
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

namespace SuiteCRM\Robo\Traits;

/**
 * This Trait creates a fully working instance of SuiteCRM.
 *
 * The main advantage of this class is that it establish a working database connection to be used from your CLIs.
 *
 * To make the instance work properly, bootstrap() must be invoked first.
 */
trait CliRunnerTrait
{
    /**
     * Sets up the missing global variables to make SugarCRM works from CLI.
     */
    protected function bootstrap()
    {
        global $current_language, $app_list_strings, $sugar_config;

        if (!defined('sugarEntry')) {
            define('sugarEntry', true);
            define('SUITE_CLI_RUNNER', true);
        }

        /*
         * The following file inclusions have been moved here
         * since they have side effects and can make other
         * Robo Tasks fail (i.e. failed database connection).
         */
        $root = __DIR__ . '/../../../';

        require $root . 'config.php';
        require $root . 'config_override.php';
        require_once $root . 'include/entryPoint.php';

        // Load up the config.test.php file. This is used to define configuration values for the test environment.
        $testConfig = [];

        if (is_file($root . 'tests/config.test.php')) {
            require_once $root . 'tests/config.test.php';
        }

        foreach (array_keys($testConfig) as $key) {
            if (isset($sugar_config[$key])) {
                $sugar_config[$key] = $testConfig[$key];
            } else {
                $sugar_config[] = $testConfig[$key];
            }
        }

        $current_language = 'en_us';
        $app_list_strings = return_app_list_strings_language($current_language);
        $sugar_config['resource_management']['default_limit'] = 999999;
    }
}
