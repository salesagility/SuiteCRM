<?php

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\Factory\ValidatorFactory;
use Api\V8\Param;
use Interop\Container\ContainerInterface as Container;

return [
    Param\BaseModuleParams::class => function (Container $container) {
        return new Param\BaseModuleParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\GetModuleParams::class => function (Container $container) {
        return new Param\GetModuleParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\GetModulesParams::class => function (Container $container) {
        return new Param\GetModulesParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\GetRelationshipParams::class => function (Container $container) {
        return new Param\GetRelationshipParams($container->get(ValidatorFactory::class));
    },
];
