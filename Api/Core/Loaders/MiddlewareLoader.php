<?php
namespace Api\Core\Loaders;

use Slim\App;

class MiddlewareLoader
{
    /**
     * Load all system default middleware
     *
     * @param App $app
     * @param string $middlewareConfig
     */
    public static function configureMiddleware(App $app, $middlewareConfig)
    {
        $middlewares = require $middlewareConfig;

        foreach ($middlewares as $middleware) {
            $app->add(call_user_func($middleware, $app));
        }
    }
}
