<?php

namespace SuiteCRM\api\core;

use Slim\Http\Response as Response;

class Api
{
    /**
     * @param Response $responseObject
     * @param int      $status
     * @param mixed    $data
     * @param string   $message
     *
     * @return Response
     */
    public function generateResponse(Response $responseObject, $status, $data, $message)
    {
        $response = array(
            'status' => $status,
            'data' => $data,
            'message' => $message,
        );

        return $responseObject
            ->withStatus($status)
            ->withHeader('Content-type', 'application/json')
            ->write(json_encode($response, JSON_PRETTY_PRINT));
    }
}
