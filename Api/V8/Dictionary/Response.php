<?php
namespace Api\V8\Dictionary;

class Response
{
    const MESSAGE_SUCCESS = 'SUCCESS';
    const MESSAGE_ERROR = 'ERROR';

    const TYPE_NOT_FOUND_EXCEPTION = 'NOT_FOUND_EXCEPTION';
    const TYPE_NOT_ALLOWED_EXCEPTION = 'NOT_ALLOWED_EXCEPTION';
    const TYPE_DOMAIN_EXCEPTION = 'DOMAIN_EXCEPTION';
    const TYPE_FATAL_ERROR = 'FATAL_ERROR';

    /**
     * @param string $type
     * @param string $message
     * @return array
     */
    public static function errorData(string $type, string $message): array
    {
        return [
            'type' => $type,
            'message' => $message,
        ];
    }
}
