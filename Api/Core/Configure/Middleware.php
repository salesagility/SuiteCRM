<?php
namespace Api\Core\Configure;

use Slim\App;

class Middleware
{
    /**
     * @param App $app
     * @param string $middlewareConfig
     */
    public static function configureMiddleware(App $app, string $middlewareConfig)
    {
        $middlewares = require $middlewareConfig;

        foreach ($middlewares as $middleware) {
            $app->add(call_user_func($middleware, $app));
        }
    }
}
