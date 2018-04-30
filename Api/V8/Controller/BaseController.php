<?php
namespace Api\V8\Controller;

use Api\V8\JsonApi\Response\DocumentResponse;
use Api\V8\JsonApi\Response\ErrorResponse;
use Slim\Http\Response as HttpResponse;

abstract class BaseController
{
    const MEDIA_TYPE = 'application/vnd.api+json';

    /**
     * @param HttpResponse $httpResponse
     * @param DocumentResponse|ErrorResponse $response
     * @param int $status
     *
     * @return HttpResponse
     */
    public function generateResponse(
        HttpResponse $httpResponse,
        $response,
        $status
    ) {
        return $httpResponse
            ->withStatus($status)
            ->withHeader('Accept', static::MEDIA_TYPE)
            ->withHeader('Content-type', static::MEDIA_TYPE)
            ->write(
                json_encode(
                    $response,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                )
            );
    }

    /**
     * @param HttpResponse $httpResponse
     * @param \Exception $exception
     * @param int $status
     *
     * @return HttpResponse
     */
    public function generateErrorResponse(HttpResponse $httpResponse, $exception, $status)
    {
        $response = new ErrorResponse();
        $response->setStatus($status);
        $response->setDetail($exception->getMessage());

        return $this->generateResponse($httpResponse, $response, $status);
    }
}
