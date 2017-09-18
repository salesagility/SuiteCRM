<?php

$app->group('/v8', function () use ($app) {
    $app->post('/login', 'SuiteCRM\api\v8\controller\UtilityController:login');
    $app->post('/logout', 'SuiteCRM\api\v8\controller\UtilityController:logout');
});
