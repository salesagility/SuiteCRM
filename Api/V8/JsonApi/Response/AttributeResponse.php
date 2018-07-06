<?php
namespace Api\V8\JsonApi\Response;

class AttributeResponse extends MetaResponse
{
    /**
     * @var array
     *
     * @see http://jsonapi.org/format/#document-resource-object-attributes
     */
    private static $forbiddenKeys = ['relationships', 'links'];

    /**
     * @param array|\stdClass $properties
     *
     * @throws \InvalidArgumentException When attribute object includes forbidden keys.
     */
    public function __construct($properties = [])
    {
        parent::__construct($properties);

        $invalidKeys = array_intersect_key($properties, array_flip(self::$forbiddenKeys));
        if ($invalidKeys) {
            throw new \InvalidArgumentException(
                'Attribute object must not contain these keys: ' . implode(', ', array_keys($invalidKeys))
            );
        }
    }
}
