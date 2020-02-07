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

// file has been separated out for testing and mocking purposes
$version = 8;

$container = new \Slim\Container;
// Load Containers
$paths = new \SuiteCRM\Utility\Paths();
$containerFiles = (array)glob($paths->getLibraryPath() . '/API/v8/container/*.php');
$customContainerFiles = (array)glob($paths->getCustomLibraryPath() . '/API/v8/container/*.php');

// load core files
foreach ($containerFiles as $containerFile) {
    require $containerFile;
}

// load custom files
foreach ($customContainerFiles as $containerFile) {
    require $containerFile;
}

/**
 * @param \Psr\Container\ContainerInterface $container
 * @return Closure
 */
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        /**
         * @var \SuiteCRM\API\v8\Controller\ApiController $ApiController
         */
        $ApiController = $container->get('ApiController');
        $exception = new \SuiteCRM\API\v8\Exception\NotAllowedException();

        return $ApiController->generateJsonApiErrorResponse($request, $response, $exception);
    };
};

/**
 * @param \Psr\Container\ContainerInterface $container
 * @return Closure
 */
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        /**
         * @var \SuiteCRM\API\v8\Controller\ApiController $ApiController
         */
        $exception = new \SuiteCRM\API\v8\Exception\NotFoundException('[Resource]');
        $ApiController = $container->get('ApiController');

        return $ApiController->generateJsonApiErrorResponse($request, $response, $exception);
    };
};

/**
 * @param \Psr\Container\ContainerInterface $container
 * @return Closure
 */
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        /**
         * @var \SuiteCRM\API\v8\Controller\ApiController $ApiController
         */
        $ApiController = $container->get('ApiController');

        return $ApiController->generateJsonApiErrorResponse($request, $response, $exception);
    };
};


/**
 * @param \Psr\Container\ContainerInterface $container
 * @return Closure
 */
$container['phpErrorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {
        /**
         * @var \SuiteCRM\API\v8\Controller\ApiController $ApiController
         */
        $ApiController = $container->get('ApiController');

        return $ApiController->generateJsonApiErrorResponse($request, $response, $exception);
    };
};

if (isset($GLOBALS['container']) === false) {
    $GLOBALS['container'] = $container;
}
