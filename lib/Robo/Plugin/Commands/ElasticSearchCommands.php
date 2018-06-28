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
 * Date: 25/06/18
 * Time: 16:47
 */

namespace SuiteCRM\Robo\Plugin\Commands;

use BeanFactory;
use Robo\Task\Base\loadTasks;
use SuiteCRM\Robo\Traits\RoboTrait;
use SuiteCRM\Search\ElasticSearch\ElasticSearchIndexer;
use SuiteCRM\Search\MasterSearch;
use SuiteCRM\Search\SearchQuery;
use SuiteCRM\Utility\BeanJsonSerializer;

class ElasticSearchCommands extends \Robo\Tasks
{
    use loadTasks;
    use RoboTrait;

    /**
     * ElasticSearchCommands constructor.
     */
    public function __construct()
    {
        $this->bootstrap();
    }

    //region necessaryEvil
    private function bootstrap()
    {
        if (!defined('sugarEntry')) {
            define('sugarEntry', true);
            define('SUITE_PHPUNIT_RUNNER', true);
        }

        require 'config.php';
        require 'config_override.php';

        require_once 'vendor/autoload.php';

        require_once 'include/database/DBManagerFactory.php';

        require_once 'include/utils.php';
        require_once 'include/modules.php';
        require_once 'include/entryPoint.php';

        //Oddly entry point loads app_strings but not app_list_strings, manually do this here.
        $GLOBALS['current_language'] = 'en_us';
        $GLOBALS['app_list_strings'] = return_app_list_strings_language($GLOBALS['current_language']);

        /* VERY BAD :-( - but for now at least tests are running */
        $GLOBALS['sugar_config']['resource_management']['default_limit'] = 999999;
    }

    //endregion

    public function esearch($query, $size = 50, $showJson = false)
    {
        $engine = new MasterSearch();

        $results = $engine->search('ElasticSearchEngine', SearchQuery::fromString($query, $size));

        foreach ($results as $key => $module) {
            $this->printModuleResults($showJson, $key, $module);
        }

        echo PHP_EOL;
    }

    /**
     * @param $showJson
     * @param $key
     * @param $module
     */
    private function printModuleResults($showJson, $key, $module)
    {
        echo "\n### $key ###\n";
        foreach ($module as $id) {
            $bean = BeanFactory::getBean($key, $id);
            echo "  * ", mb_convert_encoding($bean->name, "UTF-8", "HTML-ENTITIES"), PHP_EOL;

            if ($showJson) echo BeanJsonSerializer::serialize($bean, true, true);
        }
    }

    public function eindex()
    {
        ElasticSearchIndexer::_run(true, false);
    }

    public function ermindex()
    {
        $indexer = new ElasticSearchIndexer();
        $indexer->removeIndex();
    }
}