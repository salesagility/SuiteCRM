<?php
namespace Api\V8\Controller;

use Api\V8\Params\ModuleParams;
use Api\V8\Service\ModuleService;
use Slim\Http\Request;
use Slim\Http\Response;

class ModuleController extends AbstractApiController
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
     * @param ModuleParams $params
     *
     * @return Response
     */
    public function getModuleRecords(
        Request $request,
        Response $response,
        array $args,
        ModuleParams $params
    ) {
        try {
            $moduleRecords = $this->moduleService->getRecords($params);

            return $this->generateResponse($response, 200, $moduleRecords);
        } catch (\Exception $e) {
            return $this->generateResponse($response, 400, $e->getMessage());
        }
    }
}
