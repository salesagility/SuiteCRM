<?php

use Api\V8\Factory\ParamObjectConverterFactory;
use Interop\Container\ContainerInterface as Container;

return [
    ParamObjectConverterFactory::class => function (Container $container) {
        return new ParamObjectConverterFactory($container);
    },
];
