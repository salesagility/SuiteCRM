<?php

use Api\V8\BeanManager;
use Interop\Container\ContainerInterface as Container;

return array_merge(
    [
        BeanManager::class => function (Container $container) {
            return new BeanManager(
                $container->get('beanAliases')
            );
        },
    ],
    require __DIR__ . '/Services/oauth.php',
    require __DIR__ . '/Services/controllers.php',
    require __DIR__ . '/Services/beanAliases.php'
);
