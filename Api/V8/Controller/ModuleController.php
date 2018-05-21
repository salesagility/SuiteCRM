<?php
namespace Api\V8\Controller;

use Api\V8\Param\CreateModuleParams;
use Api\V8\Param\DeleteModuleParams;
use Api\V8\Param\GetModuleParams;
use Api\V8\Param\GetModulesParams;
use Api\V8\Param\UpdateModuleParams;
use Api\V8\Service\ModuleService;
use Slim\Http\Request;
use Slim\Http\Response;

class ModuleController extends BaseController
{
    /**
     * @var ModuleService
     */
    private $moduleService;

    /**
     * @param ModuleService $moduleService
     */
    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @param GetModuleParams $params
     *
     * @return Response
     */
    public function getModuleRecord(Request $request, Response $response, array $args, GetModuleParams $params)
    {
        try {
            $jsonResponse = $this->moduleService->getRecord($params, $request->getUri()->getPath());

            return $this->generateResponse($response, $jsonResponse, 200);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @param GetModulesParams $params
     *
     * @return Response
     */
    public function getModuleRecords(Request $request, Response $response, array $args, GetModulesParams $params)
    {
        try {
            $jsonResponse = $this->moduleService->getRecords($params, $request);

            return $this->generateResponse($response, $jsonResponse, 200);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @param CreateModuleParams|UpdateModuleParams $params
     *
     * @return Response
     */
    public function saveModuleRecord(Request $request, Response $response, array $args, $params)
    {
        try {
            $jsonResponse = $this->moduleService->saveModuleRecord($params);

            return $this->generateResponse($response, $jsonResponse, 201);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @param DeleteModuleParams $params
     *
     * @return Response
     */
    public function deleteModuleRecord(Request $request, Response $response, array $args, DeleteModuleParams $params)
    {
        try {
            $jsonResponse = $this->moduleService->deleteRecord($params);

            return $this->generateResponse($response, $jsonResponse, 200);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }
}
