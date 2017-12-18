<?php
namespace Api\Core\Configure;

use Slim\App;

class Route
{
    /**
     * @param App $app
     */
    public static function configureRoutes(App $app)
    {
        require __DIR__ . '/../../V8/Config/routes.php';
    }
}
