<?php

use Api\V8\Factory\ValidatorFactory;
use Interop\Container\ContainerInterface as Container;
use Symfony\Component\Validator\ValidatorBuilder;

return [
    'Validation' => function () {
        return (new ValidatorBuilder())->getValidator();
    },
    ValidatorFactory::class => function (Container $container) {
        return new ValidatorFactory($container->get('Validation'));
    },
];
