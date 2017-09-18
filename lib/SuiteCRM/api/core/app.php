<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

chdir(__DIR__.'/../../../../');
require_once __DIR__.'/../../../../include/entryPoint.php';

preg_match("/\/api\/(.*?)\//", $_SERVER['REQUEST_URI'], $matches);

$GLOBALS['app_list_strings'] = return_app_list_strings_language($GLOBALS['current_language']);

$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];

$version = $matches[1];

$app = new \Slim\App();

$routeFiles = (array) glob('lib/SuiteCRM/api/'.$version.'/route/*.php');

foreach ($routeFiles as $routeFile) {
    require $routeFile;
}

$services = require_once __DIR__ . '/serviceConfig.php';
$container = $app->getContainer();
foreach ($services as $service => $closure) {
    $container[$service] = $closure;
}

$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        return $response->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('There\'s been an error');
    };
};

if ($_SERVER['REQUEST_METHOD'] != 'OPTIONS') {
    $app->add(new \Slim\Middleware\JwtAuthentication([
        'secure' => isSSL(),
        "cookie" => "SUITECRM_REST_API_TOKEN",
        'secret' => $sugar_config['unique_key'],
        'environment' => 'REDIRECT_HTTP_AUTHORIZATION',
        'rules' => [
            new Slim\Middleware\JwtAuthentication\RequestPathRule([
                'path' => '/'.$version,
                'passthrough' => ['/'.$version.'/login', '/'.$version.'/token'],
            ]),
        ],
        'callback' => function ($request, $response, $arguments) use ($container) {
            global $current_user;
            $token = $arguments['decoded'];
            $current_user = new \user();
            $current_user->retrieve($token->userId);
            $container['jwt'] = $token;
        },
        'error' => function ($request, $response, $arguments) use ($app) {
            return $response->write('Authentication Error');
        },
    ]));
}

$app->run();
