<?php

return [
    'settings' => [
        /** Additional information about exceptions are displayed by the default error handler. */
        'displayErrorDetails' => true,
        /** Routes are accessible in middleware. */
        'determineRouteBeforeAppMiddleware' => true,
    ] + (require __DIR__ . '/../../../custom/Extension/Api/Config/slim.php')
];
