<?php
namespace Api\V8\JsonApi\Helper;

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\JsonApi\Response\AttributeResponse;

class AttributeObjectHelper
{
    /**
     * @var BeanManager
     */
    private $beanManager;

    /**
     * @param BeanManager $beanManager
     */
    public function __construct(BeanManager $beanManager)
    {
        $this->beanManager = $beanManager;
    }

    /**
     * @param \SugarBean $bean
     * @param array|null $fields
     *
     * @return AttributeResponse
     */
    public function getAttributes(\SugarBean $bean, $fields = null)
    {
        $bean->fixUpFormatting();
        $attributes = $bean->toArray();

        // using the ISO 8601 format for dates
        array_walk($attributes, function (&$value) {
            if (\DateTime::createFromFormat('Y-m-d H:i:s', $value)) {
                $value = date(\DateTime::ATOM, strtotime($value));
            }
        });

        if ($fields !== null) {
            $attributes = array_intersect_key($attributes, array_flip($fields));
        }

        unset($attributes['id']);

        return new AttributeResponse($attributes);
    }
}
