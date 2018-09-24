<?php

use Api\V8\Factory;
use Interop\Container\ContainerInterface as Container;

return [
    Factory\ParamsMiddlewareFactory::class => function (Container $container) {
        return new Factory\ParamsMiddlewareFactory($container);
    },
    Factory\ValidatorFactory::class => function (Container $container) {
        return new Factory\ValidatorFactory($container->get('Validation'));
    },
];
