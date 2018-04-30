<?php

use Api\V8\Factory\ValidatorFactory;
use Api\V8\Param;
use Interop\Container\ContainerInterface as Container;

return [
    Param\ModuleParams::class => function (Container $container) {
        return new Param\ModuleParams($container->get(ValidatorFactory::class));
    }
];
