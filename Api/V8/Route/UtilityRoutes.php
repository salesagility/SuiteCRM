<?php

$app->group('/V8',function() use ($app){
    $app->get('/server_info','SuiteCRM\Api\V8\Controller\UtilityController:getServerInfo');
});