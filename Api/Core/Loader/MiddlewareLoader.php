<?php
namespace Api\Core\Loader;

use Slim\App;

class MiddlewareLoader
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
