<?php
namespace Api\V8;

use Api\V8\Exception\NotAllowedException;
use Api\V8\Exception\NotFoundException;
use Slim\Http\Response as HttpResponse;
use Api\V8\Dictionary\Response;

abstract class AbstractApiController
{
    /**
     * @param HttpResponse $httpResponse
     * @param int $status
     * @param null $data
     * @param string|null $message
     * @return HttpResponse
     */
    public function generateResponse(
        HttpResponse $httpResponse,
        int $status,
        $data = null,
        string $message = null
    ): HttpResponse {
        $response = [
            'status' => $status,
            'data' => $data,
            'message' => $message ?? ($status > 320 ? Response::MESSAGE_ERROR : Response::MESSAGE_SUCCESS),
        ];

        return $httpResponse
            ->withStatus($status)
            ->withHeader('Content-type', 'application/vnd.api+json')
            ->write(
                json_encode(
                    $response,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                )
            );
    }

    /**
     * @param HttpResponse $response
     * @param \Throwable $error
     * @return HttpResponse
     */
    public function handleError(HttpResponse $response, \Throwable $error): HttpResponse
    {
        switch (true) {
            case $error instanceof NotAllowedException:
                $httpCode = 405;
                $data = Response::errorData(Response::TYPE_NOT_ALLOWED_EXCEPTION, $error->getMessage());
                break;
            case $error instanceof NotFoundException:
                $httpCode = 404;
                $data = Response::errorData(Response::TYPE_NOT_FOUND_EXCEPTION, $error->getMessage());
                break;
            case $error instanceof \LogicException:
            case $error instanceof \DomainException:
                $httpCode = 422;
                $data = Response::errorData(Response::TYPE_DOMAIN_EXCEPTION, $error->getMessage());
                break;
            default:
                $httpCode = 500;
                $data = Response::errorData(Response::TYPE_FATAL_ERROR, $error->getMessage());
                break;
        }

        return $this->generateResponse($response, $httpCode, $data, Response::MESSAGE_ERROR);
    }
}
