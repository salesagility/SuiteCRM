<?php
namespace Api\V8\Service;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Helper\AttributeObjectHelper;
use Api\V8\JsonApi\Helper\PaginationObjectHelper;
use Api\V8\JsonApi\Helper\RelationshipObjectHelper;
use Api\V8\JsonApi\Response\DataResponse;
use Api\V8\JsonApi\Response\DocumentResponse;
use Api\V8\JsonApi\Response\MetaResponse;
use Api\V8\Param\GetModuleParams;
use Api\V8\Param\GetModulesParams;
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
        $bean = $this->beanManager->getBeanSafe(
            $params->getModuleName(),
            $params->getId()
        );

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

        $beanListResponse = $this->beanManager->getList($module)
            ->orderBy($orderBy)
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
     * @param string $module
     * @param array|null $params
     *
     * @return DocumentResponse
     * @throws \InvalidArgumentException if data or bean's property are invalid
     */
    public function createRecord($module, $params)
    {
        $bean = $this->beanManager->newBeanSafe($module);

        // this is gonna be replaced with param
        if (!isset($params['data'])) {
            throw new \InvalidArgumentException('Data resource object must exist');
        }

        if (isset($params['data']['attributes'])) {
            foreach ($params['data']['attributes'] as $property => $value) {
                if (!property_exists($bean, $property)) {
                    throw new \InvalidArgumentException(
                        sprintf('Invalid property in %s module: %s', $bean->getObjectName(), $property)
                    );
                }

                $bean->$property = $value;
            }
        }

        $bean->save();

        $dataResponse = new DataResponse($bean->getObjectName(), $bean->id);
        $dataResponse->setAttributes($this->attributeHelper->getAttributes($bean));

        $response = new DocumentResponse();
        $response->setData($dataResponse);

        return $response;
    }

    /**
     * @param array $args
     * @param array|null $params
     *
     * @return DocumentResponse
     * @throws \InvalidArgumentException if data or bean's property are invalid
     */
    public function updateRecord(array $args, $params)
    {
        // we need to create a new class for preventing duplication
        $module = $args['moduleName'];
        $moduleId = $args['id'];

        $bean = $this->beanManager->getBeanSafe($module, $moduleId);

        if (!isset($params['data'])) {
            throw new \InvalidArgumentException('Data resource object must exist');
        }

        if (isset($params['data']['attributes'])) {
            foreach ($params['data']['attributes'] as $property => $value) {
                if (!property_exists($bean, $property)) {
                    throw new \InvalidArgumentException(
                        sprintf('Invalid property in %s module: %s', $bean->getObjectName(), $property)
                    );
                }

                $bean->$property = $value;
            }

            $bean->save();
        }

        $dataResponse = new DataResponse($bean->getObjectName(), $bean->id);
        $dataResponse->setAttributes($this->attributeHelper->getAttributes($bean));

        $response = new DocumentResponse();
        $response->setData($dataResponse);

        return $response;
    }

    /**
     * @param array $args
     *
     * @return DocumentResponse
     */
    public function deleteRecord(array $args)
    {
        // we need to create a new class for preventing duplication
        $module = $args['moduleName'];
        $moduleId = $args['id'];

        $bean = $this->beanManager->getBeanSafe($module, $moduleId);
        $bean->mark_deleted($moduleId);

        $response = new DocumentResponse();
        $response->setMeta(
            new MetaResponse(['message' => sprintf('Record with %s id is deleted', $moduleId)])
        );

        return $response;
    }

    /**
     * @param \SugarBean $bean
     * @param array $fields
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
