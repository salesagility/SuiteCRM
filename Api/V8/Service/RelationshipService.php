<?php
namespace Api\V8\Service;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Helper\AttributeObjectHelper;
use Api\V8\JsonApi\Response\DataResponse;
use Api\V8\JsonApi\Response\DocumentResponse;
use Api\V8\JsonApi\Response\LinksResponse;
use Api\V8\JsonApi\Response\MetaResponse;
use Api\V8\Param\CreateRelationshipParams;
use Api\V8\Param\DeleteRelationshipParams;
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
        $sourceBean = $params->getSourceBean();
        $relationship = $params->getRelationshipName();
        $relatedBeans = $this->beanManager->getRelatedBeans($sourceBean, $relationship);

        $response = new DocumentResponse();

        if (!$relatedBeans) {
            $response->setMeta(new MetaResponse(
                [
                    'message' => sprintf(
                        'Relationship %s of module %s is empty',
                        $relationship,
                        $sourceBean->getObjectName()
                    )
                ]
            ));
        } else {
            $data = [];
            /** @var \SugarBean $relatedBean */
            foreach ($relatedBeans as $relatedBean) {
                $linkResponse = new LinksResponse();
                $linkResponse->setSelf(sprintf('/V8/module/%s/%s', $relatedBean->getObjectName(), $relatedBean->id));

                $dataResponse = new DataResponse($relatedBean->getObjectName(), $relatedBean->id);
                $dataResponse->setLinks($linkResponse);
                $data[] = $dataResponse;
            }

            $response->setMeta(new MetaResponse(
                ['message' => sprintf('%s relationship of %s module', $relationship, $sourceBean->getObjectName())]
            ));
            $response->setData($data);
        }

        return $response;
    }

    /**
     * @param CreateRelationshipParams $params
     *
     * @return DocumentResponse
     */
    public function createRelationship(CreateRelationshipParams $params)
    {
        $sourceBean = $params->getSourceBean();
        $relatedBean = $params->getData()->getRelatedBean();
        $relationship = $params->getData()->getType();

        $this->beanManager->createRelationshipSafe($sourceBean, $relatedBean, $relationship);

        $dataResponse = new DataResponse($relatedBean->getObjectName(), $relatedBean->id);
        $dataResponse->setAttributes($this->attributeHelper->getAttributes($relatedBean));

        $response = new DocumentResponse();
        $response->setMeta(new MetaResponse(
            [
                'message' => sprintf(
                    '%s module has been added as relationship into %s module',
                    $relatedBean->getObjectName(),
                    $sourceBean->getObjectName()
                )
            ]
        ));
        $response->setData($dataResponse);

        return $response;
    }

    /**
     * @param DeleteRelationshipParams $params
     *
     * @return DocumentResponse
     */
    public function deleteRelationship(DeleteRelationshipParams $params)
    {
        $sourceBean = $params->getSourceBean();
        $relatedBean = $params->getData()->getRelatedBean();
        $relationship = $params->getData()->getType();

        $this->beanManager->deleteRelationshipSafe($sourceBean, $relatedBean, $relationship);

        $response = new DocumentResponse();
        $response->setMeta(new MetaResponse(
            [
                'message' => sprintf(
                    '%s relationship has been deleted between %s and %s module',
                    $relationship,
                    $relatedBean->getObjectName(),
                    $sourceBean->getObjectName()
                )
            ]
        ));

        return $response;
    }
}
