<?php
namespace Api\V8\JsonApi\Repository;

class Sort
{
    const ORDER_BY_ASC = 'ASC';
    const ORDER_BY_DESC = 'DESC';

    /**
     * We don't support multiple sorting. for now.
     *
     * @param \SugarBean $bean
     * @param string $value
     *
     * @return string
     * @throws \InvalidArgumentException When sort field is not found in the bean.
     */
    public function parseOrderBy(\SugarBean $bean, $value)
    {
        $orderBy = self::ORDER_BY_ASC;
        if ($value[0] === '-') {
            $orderBy = self::ORDER_BY_DESC;
            $value = ltrim($value, '-');
        }

        if (!property_exists($bean, $value)) {
            throw new \InvalidArgumentException(sprintf(
                'Sort field %s in %s module is not found',
                $value,
                $bean->getObjectName()
            ));
        }

        return sprintf('%s %s', $value, $orderBy);
    }
}
