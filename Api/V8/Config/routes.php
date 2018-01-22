<?php

$app->group('/V8', function () use ($app) {
    /**
     * Request an access token
     */
    $this->post('/access_token', 'Api\V8\Controller\UtilityController:accessToken');

    /**
     * Get server info
     */
    $this->get('/server_info', 'Api\V8\Controller\UtilityController:getServerInfo');
});
