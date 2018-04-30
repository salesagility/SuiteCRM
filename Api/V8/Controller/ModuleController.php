<?php
namespace Api\V8\Controller;

use Api\V8\Param\ModuleParams;
use Api\V8\Service\ModuleService;
use Slim\Http\Request;
use Slim\Http\Response;

class ModuleController extends BaseController
{
    const GET_MODULE_RECORD = self::class . ':getModuleRecord';
    const GET_MODULE_RECORDS = self::class . ':getModuleRecords';
    const CREATE_MODULE_RECORD = self::class . ':createModuleRecord';
    const UPDATE_MODULE_RECORD = self::class . ':updateModuleRecord';
    const DELETE_MODULE_RECORD = self::class . ':deleteModuleRecord';

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
     * @param ModuleParams $params
     *
     * @return Response
     */
    public function getModuleRecord(Request $request, Response $response, array $args, ModuleParams $params)
    {
        try {
            $jsonResponse = $this->moduleService->getRecord($params, $request->getUri());

            return $this->generateResponse($response, $jsonResponse, 200);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @param ModuleParams $params
     *
     * @return Response
     */
    public function getModuleRecords(Request $request, Response $response, array $args, ModuleParams $params)
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
     *
     * @return Response
     */
    public function createModuleRecord(Request $request, Response $response, array $args)
    {
        try {
            $moduleName = $args['moduleName'];
            $bodyParams = $request->getParsedBody();
            $jsonResponse = $this->moduleService->createRecord($moduleName, $bodyParams);

            return $this->generateResponse($response, $jsonResponse, 200);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return Response
     */
    public function updateModuleRecord(Request $request, Response $response, array $args)
    {
        try {
            // we should create a new middleware for fetching beans instead of passing args
            $bodyParams = $request->getParsedBody();
            $jsonResponse = $this->moduleService->updateRecord($args, $bodyParams);

            return $this->generateResponse($response, $jsonResponse, 200);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     *
     * @return Response
     */
    public function deleteModuleRecord(Request $request, Response $response, array $args)
    {
        try {
            // we should create a new middleware for fetching beans instead of passing args
            $jsonResponse = $this->moduleService->deleteRecord($args);

            return $this->generateResponse($response, $jsonResponse, 200);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }
}
