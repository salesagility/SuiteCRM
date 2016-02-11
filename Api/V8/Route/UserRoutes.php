<?php

$app->group('/V8',function() use ($app){
    $app->get('/upcoming_activities','SuiteCRM\Api\V8\Controller\UserController:getUpcomingActivities');
});