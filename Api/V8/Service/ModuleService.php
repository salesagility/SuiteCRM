<?php
namespace Api\V8\Service;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Helper\AttributeObjectHelper;
use Api\V8\JsonApi\Helper\PaginationObjectHelper;
use Api\V8\JsonApi\Helper\RelationshipObjectHelper;
use Api\V8\JsonApi\Response\DataResponse;
use Api\V8\JsonApi\Response\DocumentResponse;
use Api\V8\JsonApi\Response\MetaResponse;
use Api\V8\Param\CreateModuleParams;
use Api\V8\Param\DeleteModuleParams;
use Api\V8\Param\GetModuleParams;
use Api\V8\Param\GetModulesParams;
use Api\V8\Param\UpdateModuleParams;
use Slim\Http\Request;

class ModuleService
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
     * @var RelationshipObjectHelper
     */
    private $relationshipHelper;

    /**
     * @var PaginationObjectHelper
     */
    private $paginationHelper;

    /**
     * @param BeanManager $beanManager
     * @param AttributeObjectHelper $attributeHelper
     * @param RelationshipObjectHelper $relationshipHelper
     * @param PaginationObjectHelper $paginationHelper
     */
    public function __construct(
        BeanManager $beanManager,
        AttributeObjectHelper $attributeHelper,
        RelationshipObjectHelper $relationshipHelper,
        PaginationObjectHelper $paginationHelper
    ) {
        $this->beanManager = $beanManager;
        $this->attributeHelper = $attributeHelper;
        $this->relationshipHelper = $relationshipHelper;
        $this->paginationHelper = $paginationHelper;
    }

    /**
     * @param GetModuleParams $params
     * @param string $path
     *
     * @return DocumentResponse
     */
    public function getRecord(GetModuleParams $params, $path)
    {
        $fields = $params->getFields();
        $bean = $params->getBean();

        $dataResponse = $this->getDataResponse($bean, $fields, $path);

        $response = new DocumentResponse();
        $response->setData($dataResponse);

        return $response;
    }

    /**
     * @param GetModulesParams $params
     * @param Request $request
     *
     * @return DocumentResponse
     */
    public function getRecords(GetModulesParams $params, Request $request)
    {
        $module = $params->getModuleName();
        $fields = $params->getFields();
        $size = $params->getPage()->getSize();
        $number = $params->getPage()->getNumber();
        $offset = $number !== 0 ? ($number - 1) * $size : $number;
        $orderBy = $params->getSort();
        $where = $params->getFilter();

        $beanListResponse = $this->beanManager->getList($module)
            ->orderBy($orderBy)
            ->where($where)
            ->offset($offset)
            ->max($size)
            ->fetch();

        $data = [];
        foreach ($beanListResponse->getBeans() as $bean) {
            $dataResponse = $this->getDataResponse(
                $bean,
                $fields,
                $request->getUri()->getPath() . '/' . $bean->id
            );

            $data[] = $dataResponse;
        }

        $response = new DocumentResponse();
        $response->setData($data);

        // pagination
        if ($number !== BeanManager::DEFAULT_OFFSET) {
            // this will be split into separated classed later
            $totalPages = ceil($beanListResponse->getRowCount() / $size);

            $paginationMeta = $this->paginationHelper->getPaginationMeta($totalPages);
            $paginationLinks = $this->paginationHelper->getPaginationLinks($request, $totalPages, $number);

            $response->setMeta($paginationMeta);
            $response->setLinks($paginationLinks);
        }

        return $response;
    }

    /**
     * @param CreateModuleParams|UpdateModuleParams $params
     *
     * @return DocumentResponse
     */
    public function saveModuleRecord($params)
    {
        /** @var \SugarBean $bean */
        $bean = $params->getData()->getBean();
        $attributes = $params->getData()->getAttributes();

        foreach ($attributes as $property => $value) {
            $bean->$property = $value;
        }
        $bean->save();

        $dataResponse = new DataResponse($bean->getObjectName(), $bean->id);
        $dataResponse->setAttributes($this->attributeHelper->getAttributes($bean));

        $response = new DocumentResponse();
        $response->setData($dataResponse);

        return $response;
    }

    /**
     * @param DeleteModuleParams $params
     *
     * @return DocumentResponse
     */
    public function deleteRecord(DeleteModuleParams $params)
    {
        $bean = $params->getBean();
        $bean->mark_deleted($bean->id);

        $response = new DocumentResponse();
        $response->setMeta(
            new MetaResponse(['message' => sprintf('Record with id %s is deleted', $bean->id)])
        );

        return $response;
    }

    /**
     * @param \SugarBean $bean
     * @param array|null $fields
     * @param string $path
     *
     * @return DataResponse
     */
    public function getDataResponse(\SugarBean $bean, $fields, $path)
    {
        // this will be split into separated classed later
        $dataResponse = new DataResponse($bean->getObjectName(), $bean->id);
        $dataResponse->setAttributes($this->attributeHelper->getAttributes($bean, $fields));
        $dataResponse->setRelationships($this->relationshipHelper->getRelationships($bean, $path));

        return $dataResponse;
    }
}
