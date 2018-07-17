<?php
/**
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

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 17/07/18
 * Time: 11:47
 */

namespace SuiteCRM\Robo\Traits;

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
    define('SUITE_CLI_RUNNER', true);
}

$root = __DIR__ . '/../../../';

require $root . 'config.php';
require $root . 'config_override.php';
require_once $root . 'vendor/autoload.php';
require_once $root . 'include/database/DBManagerFactory.php';
require_once $root . 'include/utils.php';
require_once $root . 'include/modules.php';
require_once $root . 'include/entryPoint.php';

/**
 * This Trait creates a fully working instance of SugarCRM.
 *
 * This is supposed to be used from command line.
 *
 * To make the instance work properly, bootstrap() must be invoked first.
 */
trait CliRunnerTrait
{
    /**
     * Sets up the missing global variables to make SugarCRM work from CLI.
     */
    protected function bootstrap()
    {
        //Oddly entry point loads app_strings but not app_list_strings, manually do this here.
        global $current_language;
        global $app_list_strings;
        global $sugar_config;

        $current_language = 'en_us';
        $app_list_strings = return_app_list_strings_language($current_language);
        $sugar_config['resource_management']['default_limit'] = 999999;
    }
}