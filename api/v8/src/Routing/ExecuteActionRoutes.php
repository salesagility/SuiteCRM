<?php

$app->get('/action/{module}/{action}', 'SuiteCRM\Controller\ExecuteActionController:performAction');
$app->post('/action/{module}/{action}', 'SuiteCRM\Controller\ExecuteActionController:performAction');

