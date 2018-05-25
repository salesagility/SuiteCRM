<?php

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\Builder;
use Api\V8\Factory\ValidatorFactory;
use Interop\Container\ContainerInterface as Container;

return [
    Builder\OptionsBuilder::class => function (Container $container) {
        return new Builder\OptionsBuilder(
            $container->get(BeanManager::class),
            $container->get(ValidatorFactory::class)
        );
    },
];
