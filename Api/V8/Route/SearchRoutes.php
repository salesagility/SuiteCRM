<?php

$app->group('/V8', function () use ($app) {
    $app->get('/search', 'SuiteCRM\Api\V8\Controller\SearchController:getSearchResults');
});