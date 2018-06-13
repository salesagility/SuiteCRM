<?php
namespace Api\Core\Loader;

use Slim\App;

class RouteLoader
{
    /**
     * Load all app routes
     *
     * @param App $app
     */
    public static function configureRoutes(App $app)
    {
        require __DIR__ . '/../../V8/Config/routes.php';
    }
}
