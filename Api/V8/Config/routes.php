<?php

use Api\V8\Factory\ParamObjectConverterFactory;
use Api\V8\Params\LoginParams;
use Api\V8\Params\ModuleParams;

$app->group('/V8', function () use ($app) {
    $paramsFactory = $app->getContainer()->get(ParamObjectConverterFactory::class);

    /**
     * Get the version of SuiteCRM
     *
     * @see \Api\V8\Controller\UtilityController::getVersion()
     */
    $this->get('/version', 'Api\V8\Controller\UtilityController:getVersion');

    /**
     * Login
     *
     * @see \Api\V8\Controller\LoginController::login()
     */
    $this
        ->post('/login', 'Api\V8\Controller\LoginController:login')
        ->add($paramsFactory->create(LoginParams::class));

    /**
     * Logout
     *
     * @see \Api\V8\Controller\LoginController::logout()
     */
    $this->post('/logout', 'Api\V8\Controller\LoginController:logout');

    /**
     * Get all records by ID
     *
     * @see \Api\V8\Controller\ModuleController::getModuleRecords()
     */
    $this
        ->get('/module/{module}/{recordId}', 'Api\V8\Controller\ModuleController:getModuleRecords')
        ->add($paramsFactory->create(ModuleParams::class));
});
