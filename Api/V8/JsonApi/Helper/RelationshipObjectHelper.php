<?php
namespace Api\V8\JsonApi\Helper;

use Api\V8\Helper\VarDefHelper;
use Api\V8\JsonApi\Response\LinksResponse;

class RelationshipObjectHelper
{
    /**
     * @var VarDefHelper
     */
    private $varDefHelper;

    /**
     * @param VarDefHelper $varDefHelper
     */
    public function __construct(VarDefHelper $varDefHelper)
    {
        $this->varDefHelper = $varDefHelper;
    }

    /**
     * @param \SugarBean $bean
     * @param string $uriPath
     * @param string $id
     *
     * @return array
     */
    public function getRelationships(\SugarBean $bean, $uriPath, $id)
    {
        // if we have module collection, we add id manually to relationship
        $path = $id === null ? $uriPath . '/' . $bean->id : $uriPath;
        $relationships = $this->varDefHelper->getAllRelationships($bean);
        asort($relationships);

        $relationshipsLinks = [];
        foreach (array_unique($relationships) as $module) {
            $linkResponse = new LinksResponse();
            $linkResponse->setRelated(
                sprintf('/%s/%s/%s', $path, 'relationships', strtolower($module))
            );

            $relationshipsLinks[$module] = ['links' => $linkResponse];
        }

        return $relationshipsLinks;
    }
}
