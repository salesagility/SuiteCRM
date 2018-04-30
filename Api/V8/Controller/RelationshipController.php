<?php
namespace Api\V8\Controller;

use Api\V8\Service\RelationshipService;

class RelationshipController extends BaseController
{
    const GET_RELATIONSHIP = self::class . ':getRelationship';

    /**
     * @var RelationshipService
     */
    private $relationshipService;

    public function __construct(RelationshipService $relationshipService)
    {
        $this->relationshipService = $relationshipService;
    }

    /**
     *
     */
    public function getRelationship()
    {

    }
}
