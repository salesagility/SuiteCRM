<?php

namespace SuiteCRM\Api\Core;

class Api{

    public function generateResponse($response_object, $status, $data, $message){


        $response = array(
            'status' => $status,
            'data' => $data,
            'message' => $message,
        );

        return $response_object
            ->withStatus($status)
            ->withHeader('Content-type', 'application/json')
            ->write(json_encode($response, JSON_PRETTY_PRINT));


    }

}