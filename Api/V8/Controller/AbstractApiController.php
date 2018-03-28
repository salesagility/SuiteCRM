<?php
namespace Api\V8\Controller;

use Slim\Http\Response as HttpResponse;
use Api\V8\Dictionary\Response;

abstract class AbstractApiController
{
    /**
     * @param HttpResponse $httpResponse
     * @param int $status
     * @param null $data
     * @param string|null $message
     *
     * @return HttpResponse
     */
    public function generateResponse(
        HttpResponse $httpResponse,
        $status,
        $data = null,
        $message = null
    ) {
        $response = [
            'status' => $status,
            'data' => $data,
            'message' => isset($message)
                ? $message
                : ($status > 320 ? Response::MESSAGE_ERROR : Response::MESSAGE_SUCCESS)
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
}
