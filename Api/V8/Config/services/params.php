<?php

use Api\V8\Factory\ValidatorFactory;
use Api\V8\Param;
use Interop\Container\ContainerInterface as Container;

return [
    Param\GetModuleParams::class => function (Container $container) {
        return new Param\GetModuleParams($container->get(ValidatorFactory::class));
    },
    Param\GetModulesParams::class => function (Container $container) {
        return new Param\GetModulesParams($container->get(ValidatorFactory::class));
    },
];
