<?php

use Api\V8\BeanManager;
use Api\V8\JsonApi\Helper\AttributeObjectHelper;
use Api\V8\JsonApi\Helper\RelationshipObjectHelper;
use Api\V8\Service;
use Interop\Container\ContainerInterface as Container;

return [
    Service\ModuleService::class => function (Container $container) {
        return new Service\ModuleService(
            $container->get(BeanManager::class),
            $container->get(AttributeObjectHelper::class),
            $container->get(RelationshipObjectHelper::class)
        );
    },
    Service\LogoutService::class => function (Container $container) {
        return new Service\LogoutService(
            $container->get(BeanManager::class)
        );
    },
    Service\RelationshipService::class => function (Container $container) {
        return new Service\RelationshipService(
            $container->get(BeanManager::class)
        );
    },
];
