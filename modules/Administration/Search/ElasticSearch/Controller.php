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

/** @noinspection PhpIllegalStringOffsetInspection */

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 18/07/18
 * Time: 15:04
 */

namespace SuiteCRM\Modules\Administration\Search\ElasticSearch;

use BeanFactory;
use Configurator;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use SuiteCRM\Modules\Administration\Search\MVC\Controller as AbstractController;
use SuiteCRM\Search\ElasticSearch\ElasticSearchIndexer;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once __DIR__ . '/../../../Configurator/Configurator.php';

class Controller extends AbstractController
{
    /**
     * ElasticSearchSettingsController constructor.
     */
    public function __construct()
    {
        parent::__construct(new View());
    }

    /**
     * Shows the view.
     */
    public function display()
    {
        $this->view->getSmarty()->assign('schedulers', $this->getElasticsearchIndexingSchedulers());
        parent::display();
    }

    /**
     * Saves the configuration getting data from POST.
     */
    public function doSaveConfig()
    {
        $enabled = filter_input(INPUT_POST, 'enabled', FILTER_VALIDATE_BOOLEAN);
        $host = filter_input(INPUT_POST, 'host', FILTER_SANITIZE_STRING);
        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
        $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

        $enabled = boolval(intval($enabled));

        $cfg = new Configurator();

        $cfg->config['search']['ElasticSearch']['enabled'] = $enabled;
        $cfg->config['search']['ElasticSearch']['host'] = $host;
        $cfg->config['search']['ElasticSearch']['user'] = $user;
        $cfg->config['search']['ElasticSearch']['pass'] = $pass;

        $cfg->saveConfig();

        /*
         * For some unknown and rather magic reason, after the configuration is saved, the file is not instantly changed.
         * In the moment when the configuration file is loaded, it still retains the old values, thus it would seem
         * that the changes are not applied, and you need to reload the page. This is probably the hidden reason behind
         * the fact that when hitting save in more or less every voice of the administration menu, they will take you
         * back to the admin page, rather then keeping you in page you were before.
         *
         * Long story short, I am redirecting to the admin panel too.
         */

        //header('Location: index.php?module=Administration&action=ElasticSearchSettings');
        header('Location: index.php?module=Administration&action=index');

        die;
    }

    public function doTestConnection()
    {
        ob_clean(); // deletes the rest of the html previous to this.

        header('Content-Type: application/json');

        $input = INPUT_POST;

        $host = filter_input($input, 'host', FILTER_SANITIZE_STRING);
        $user = filter_input($input, 'user', FILTER_SANITIZE_STRING);
        $pass = filter_input($input, 'pass', FILTER_SANITIZE_STRING);

        $config = [['host' => $host, 'user' => $user, 'pass' => $pass]];

        $client = ClientBuilder::create()->setHosts($config)->build();

        $i = new ElasticSearchIndexer($client);

        $return = ['status' => 'fail', 'request' => $config[0],];

        try {
            $info = $client->info();
            $time = $i->ping();

            $return['status'] = 'success';
            $return['ping'] = $time;
            $return['info'] = $info;

        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (BadRequest400Exception $e) {
            $error = json_decode($e->getMessage());
            $return['error'] = $error->error->reason;
            $return['errorDetails'] = $error;
        } catch (\Exception $e) {
            $return['error'] = $e->getMessage();
            $return['errorType'] = get_class($e);
        }

        echo json_encode($return);

        die;
    }

    public function getElasticsearchIndexingSchedulers()
    {
        $where = "schedulers.job='function::runElasticSearchIndexerScheduler'";
        $schedulers = BeanFactory::getBean('Schedulers')->get_full_list(null, $where);
        return $schedulers;
    }
}