<?php

$app->group('/V8', function () use ($app) {
    $app->get('/action/{module}/{action}', 'SuiteCRM\Api\V8\Controller\ActionController:performAction');
    $app->post('/action/{module}/{action}', 'SuiteCRM\Api\V8\Controller\ActionController:performAction');

});