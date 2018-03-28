<?php

use Api\V8\Repository\ConfigRepository;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return [
    'JWTMiddleware' => function (App $app) {
        $suiteConfig = $app->getContainer()->get('suiteConfig');

        return new \Slim\Middleware\JwtAuthentication([
            'secure' => isSSL(),
            'relaxed' => [parse_url($suiteConfig['site_url'], PHP_URL_HOST)],
            'cookie' => ConfigRepository::TOKEN_COOKIE,
            'secret' => $suiteConfig['unique_key'],
            'rules' => [
                new Slim\Middleware\JwtAuthentication\RequestMethodRule(),
                new Slim\Middleware\JwtAuthentication\RequestPathRule([
                    'passthrough' => ['/V8/login'],
                ]),
            ],
            'error' => function (Request $request, Response $response) {
                return $response->write('Authentication Error');
            },
        ]);
    },
];
