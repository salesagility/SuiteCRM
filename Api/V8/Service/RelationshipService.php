<?php
namespace Api\V8\Service;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Helper\AttributeObjectHelper;
use Api\V8\JsonApi\Response\DataResponse;
use Api\V8\JsonApi\Response\DocumentResponse;
use Api\V8\JsonApi\Response\MetaResponse;
use Api\V8\Param\GetRelationshipParams;

class RelationshipService
{
    /**
     * @var BeanManager
     */
    private $beanManager;

    /**
     * @var AttributeObjectHelper
     */
    private $attributeHelper;

    /**
     * @param BeanManager $beanManager
     * @param AttributeObjectHelper $attributeHelper
     */
    public function __construct(BeanManager $beanManager, AttributeObjectHelper $attributeHelper)
    {
        $this->beanManager = $beanManager;
        $this->attributeHelper = $attributeHelper;
    }

    /**
     * @param GetRelationshipParams $params
     *
     * @return DocumentResponse
     */

    public function getRelationship(GetRelationshipParams $params)
    {
        $bean = $this->beanManager->getBeanSafe(
            $params->getModuleName(),
            $params->getId()
        );

        $relationship = $params->getRelationshipName();
        $relatedBeans = $bean->get_linked_beans($relationship);

        $response = new DocumentResponse();

        if (!$relatedBeans) {
            $response->setMeta(
                new MetaResponse(['message' => 'Relationship is empty'])
            );
        } else {
            $data = [];
            foreach ($relatedBeans as $relatedBean) {
                $dataResponse = new DataResponse($relatedBean->getObjectName(), $relatedBean->id);
                $attributes = $this->attributeHelper->getAttributes($relatedBean, $params->getFields());
                $dataResponse->setAttributes($attributes);

                $data[] = $dataResponse;
            }

            $response->setData($data);
        }

        return $response;
    }
}
