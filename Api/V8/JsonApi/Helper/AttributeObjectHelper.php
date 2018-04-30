<?php
namespace Api\V8\JsonApi\Helper;

use Api\V8\BeanManager;

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
     * @param array|null $fieldParams
     *
     * @return array
     */
    public function getAttributes(\SugarBean $bean, $fieldParams = null)
    {
        $bean->fixUpFormatting();
        $attributes = $bean->toArray();

        // using the ISO 8601 format for dates
        array_walk($attributes, function (&$value) {
            if (\DateTime::createFromFormat('Y-m-d H:i:s', $value)) {
                $value = date(\DateTime::ATOM, strtotime($value));
            }
        });

        if ($fieldParams !== null) {
            $attributes = $this->getFilteredAttributes($fieldParams, $attributes);
        }

        unset($attributes['id']);

        return $attributes;
    }

    /**
     * @param array $fieldParams
     * @param array $attributes
     *
     * @return array
     * @throws \InvalidArgumentException If field(s) is/are not found.
     */
    private function getFilteredAttributes(array $fieldParams, array $attributes)
    {
        $module = $this->beanManager->findBean(key($fieldParams));

        // spaces between params are validated in the endpoint's Param class
        $fields = explode(',', array_shift($fieldParams));
        $invalidFields = array_filter($fields, function ($field) use ($attributes) {
            return !array_key_exists($field, $attributes);
        });

        if ($invalidFields) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The following field%s in %s module %s not found: %s',
                    count($invalidFields) > 1 ? 's' : '',
                    $module->getObjectName(),
                    count($invalidFields) > 1 ? 'are' : 'is',
                    implode(', ', $invalidFields)
                )
            );
        }

        $attributes = array_intersect_key($attributes, array_flip($fields));

        return $attributes;
    }
}
