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
use Api\V8\Param\ModuleParams;
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
     * @param ModuleParams $params
     * @param UriInterface $uri
     *
     * @return DocumentResponse
     */
    public function getRecord(ModuleParams $params, UriInterface $uri)
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
     * @param ModuleParams $params
     * @param Request $request
     *
     * @return DocumentResponse
     */
    public function getRecords(ModuleParams $params, Request $request)
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
            $dataResponse = $this->getDataResponse($record, $params, $uriPath);
            $data[] = $dataResponse;
        }

        $response->setData($data);

        return $response;
    }

    /**
     * @param \SugarBean $bean
     * @param ModuleParams $params
     * @param string $path
     *
     * @return DataResponse
     */
    public function getDataResponse(\SugarBean $bean, ModuleParams $params, $path)
    {
        $dataResponse = new DataResponse($bean->getObjectName(), $bean->id);

        $attributes = $this->attributeHelper->getAttributes($bean, $params->getFields());
        $relationships = $this->relationshipHelper->getRelationships($bean, $path, $params->getId());

        if ($attributes) {
            $dataResponse->setAttributes(new AttributeResponse($attributes));
        }

        if ($relationships) {
            $dataResponse->setRelationships(new RelationshipResponse($relationships));
        }

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
