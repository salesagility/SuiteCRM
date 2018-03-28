<?php

use Api\V8\BeanManager;
use Api\V8\Service\ModuleService;
use Interop\Container\ContainerInterface as Container;

return [
    ModuleService::class => function (Container $container) {
        return new ModuleService(
            $container->get(BeanManager::class)
        );
    },
];
