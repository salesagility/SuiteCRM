<?php

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\Controller\InvocationStrategy\SuiteInvocationStrategy;
use Interop\Container\ContainerInterface as Container;
use Api\Core\Loader\CustomLoader;

return CustomLoader::mergeCustomArray([
        /** overwrite slim's foundHandler */
        'foundHandler' => function () {
            return new SuiteInvocationStrategy();
        },
        BeanManager::class => function (Container $container) {
            return new BeanManager(
                $container->get(DBManager::class),
                $container->get('beanAliases')
            );
        },
    ] +
    (require __DIR__ . '/services/beanAliases.php') +
    (require __DIR__ . '/services/controllers.php') +
    (require __DIR__ . '/services/factories.php') +
    (require __DIR__ . '/services/globals.php') +
    (require __DIR__ . '/services/helpers.php') +
    (require __DIR__ . '/services/middlewares.php') +
    (require __DIR__ . '/services/params.php') +
    (require __DIR__ . '/services/services.php') +
    (require __DIR__ . '/services/validators.php'), basename(__FILE__));
