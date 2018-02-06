<?php

use Api\V8\Factory\ValidatorFactory;
use Api\V8\Params\LoginParams;
use Api\V8\Params\ModuleParams;
use Interop\Container\ContainerInterface as Container;

return [
    LoginParams::class => function (Container $container) {
        return new LoginParams($container->get(ValidatorFactory::class));
    },
    ModuleParams::class => function (Container $container) {
        return new ModuleParams($container->get(ValidatorFactory::class));
    },
];
