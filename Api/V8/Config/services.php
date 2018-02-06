<?php

use Api\V8\BeanManager;
use Api\V8\Controller\InvocationStrategy\ParamsInvocationStrategy;
use Firebase\JWT\JWT;
use Interop\Container\ContainerInterface as Container;

return
    [
        'foundHandler' => function () {
            return new ParamsInvocationStrategy();
        },
        'cookie' => function (Container $container) {
            $request = $container->get('request');
            return new \Slim\Http\Cookies($request->getCookieParams());
        },
        JWT::class => function () {
            return new JWT();
        },
        BeanManager::class => function (Container $container) {
            return new BeanManager(
                $container->get('beanAliases')
            );
        },
    ] +
    (require __DIR__ . '/Services/beanAliases.php') +
    (require __DIR__ . '/Services/controllers.php') +
    (require __DIR__ . '/Services/factories.php') +
    (require __DIR__ . '/Services/globals.php') +
    (require __DIR__ . '/Services/params.php') +
    (require __DIR__ . '/Services/services.php') +
    (require __DIR__ . '/Services/validators.php');
