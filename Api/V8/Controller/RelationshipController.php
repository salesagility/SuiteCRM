<?php
namespace Api\V8\Controller;

use Api\V8\Param\GetRelationshipParams;
use Api\V8\Service\RelationshipService;
use Slim\Http\Request;
use Slim\Http\Response;

class RelationshipController extends BaseController
{
    /**
     * @var RelationshipService
     */
    private $relationshipService;

    /**
     * @param RelationshipService $relationshipService
     */
    public function __construct(RelationshipService $relationshipService)
    {
        $this->relationshipService = $relationshipService;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @param GetRelationshipParams $params
     *
     * @return Response
     */
    public function getRelationship(Request $request, Response $response, array $args, GetRelationshipParams $params)
    {
        try {
            $jsonResponse = $this->relationshipService->getRelationship($params);

            return $this->generateResponse($response, $jsonResponse, 200);
        } catch (\Exception $exception) {
            return $this->generateErrorResponse($response, $exception, 400);
        }
    }}
