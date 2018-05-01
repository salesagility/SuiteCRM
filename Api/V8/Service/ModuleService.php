<?php
namespace Api\V8\Service;

use Api\V8\BeanManager;
use Api\V8\JsonApi\Helper\AttributeObjectHelper;
use Api\V8\JsonApi\Helper\RelationshipObjectHelper;
use Api\V8\JsonApi\Response\AttributeResponse;
use Api\V8\JsonApi\Response\DataResponse;
use Api\V8\JsonApi\Response\DocumentResponse;
use Api\V8\JsonApi\Response\MetaResponse;
use Api\V8\JsonApi\Response\PaginationResponse;
use Api\V8\JsonApi\Response\RelationshipResponse;
use Api\V8\Param\GetModuleParams;
use Api\V8\Param\GetModulesParams;
use Psr\Http\Message\UriInterface;
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
     * @param BeanManager $beanManager
     * @param AttributeObjectHelper $attributeHelper
     * @param RelationshipObjectHelper $relationshipHelper
     */
    public function __construct(
        BeanManager $beanManager,
        AttributeObjectHelper $attributeHelper,
        RelationshipObjectHelper $relationshipHelper
    ) {
        $this->beanManager = $beanManager;
        $this->attributeHelper = $attributeHelper;
        $this->relationshipHelper = $relationshipHelper;
    }

    /**
     * @param GetModuleParams $params
     * @param UriInterface $uri
     *
     * @return DocumentResponse
     */
    public function getRecord(GetModuleParams $params, UriInterface $uri)
    {
        $bean = $this->beanManager->getBeanSafe(
            $params->getModuleName(),
            $params->getId()
        );

        $dataResponse = $this->getDataResponse($bean, $params, $uri->getPath());
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
        $bean = $this->beanManager->findBean($params->getModuleName());
        $pageParams = $params->getPage();
        $response = new DocumentResponse();
        $uriPath = $request->getUri()->getPath();

        // we should really split this into classes asap
        if (isset($pageParams['size'])) {
            $pageSize = (int) $pageParams['size'];
            if ($pageSize > BeanManager::MAX_RECORDS_PER_PAGE) {
                throw new \InvalidArgumentException(
                    'Maximum allowed page size is ' . BeanManager::MAX_RECORDS_PER_PAGE
                );
            }

            $currentPage = (int) $pageParams['number'];
            $offset = $currentPage !== 0 ? ($currentPage - 1) * $pageSize : $currentPage;

            $beanList = $bean->get_list('', '', $offset, -1, $pageSize);

            if ($currentPage !== 0) {
                $totalPages = ceil((int) $beanList['row_count'] / $pageSize);
                if ($beanList['row_count'] <= $offset) {
                    throw new \InvalidArgumentException(
                        'Page not found. Total pages: ' . $totalPages
                    );
                }

                $response->setMeta(
                    new MetaResponse(['total-pages' => $totalPages])
                );

                $pagination = new PaginationResponse();
                $pagination->setFirst($this->createPaginationLink($request, 1));
                $pagination->setLast($this->createPaginationLink($request, $totalPages));

                if ($currentPage > 1) {
                    $pagination->setPrev($this->createPaginationLink($request, $currentPage - 1));
                }

                if ($currentPage + 1 <= $totalPages) {
                    $pagination->setNext($this->createPaginationLink($request, $currentPage + 1));
                }

                $response->setLinks($pagination);
            }
        } else {
            $beanList = $bean->get_list();
        }

        $data = [];
        foreach ($beanList['list'] as $record) {
            $dataResponse = $this->getDataResponse($record, $params, $uriPath . '/' . $record->id);
            $data[] = $dataResponse;
        }

        $response->setData($data);

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
        $bean = $this->beanManager->findBean($module);

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
        $attributes = $this->attributeHelper->getAttributes($bean);
        $dataResponse->setAttributes(new AttributeResponse($attributes));

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
        $attributes = $this->attributeHelper->getAttributes($bean);
        $dataResponse->setAttributes(new AttributeResponse($attributes));

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
     * @param GetModuleParams|GetModulesParams $params
     * @param string $path
     *
     * @return DataResponse
     */
    public function getDataResponse(\SugarBean $bean, $params, $path)
    {
        // this method might go to a separate class later
        $dataResponse = new DataResponse($bean->getObjectName(), $bean->id);

        $attributes = $this->attributeHelper->getAttributes($bean, $params->getFields());
        $relationships = $this->relationshipHelper->getRelationships($bean, $path);

        $dataResponse->setAttributes(new AttributeResponse($attributes));
        $dataResponse->setRelationships(new RelationshipResponse($relationships));

        return $dataResponse;
    }

    /**
     * @param Request $request
     * @param int $number
     *
     * @return string
     */
    private function createPaginationLink(Request $request, $number)
    {
        $queryParams = $request->getQueryParams();
        $queryParams['page']['number'] = $number;

        return sprintf('/%s?%s', $request->getUri()->getPath(), urldecode(http_build_query($queryParams)));
    }
}
