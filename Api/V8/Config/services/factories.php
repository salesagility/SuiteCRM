<?php

use Api\Core\Loader\CustomLoader;
use Api\V8\Factory;
use Psr\Container\ContainerInterface as Container;

return CustomLoader::mergeCustomArray([
    Factory\ParamsMiddlewareFactory::class => function (Container $container) {
        return new Factory\ParamsMiddlewareFactory($container);
    },
    Factory\ValidatorFactory::class => function (Container $container) {
        return new Factory\ValidatorFactory($container->get('Validation'));
    },
], basename(__FILE__));
