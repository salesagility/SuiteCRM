<?php
namespace Flow\JSONPath\Filters;

use Flow\JSONPath\AccessHelper;

class IndexFilter extends AbstractFilter
{
    /**
     * @param array $collection
     * @return array
     */
    public function filter($collection)
    {
        if (AccessHelper::keyExists($collection, $this->token->value, $this->magicIsAllowed)) {
            return [
                AccessHelper::getValue($collection, $this->token->value, $this->magicIsAllowed)
            ];
        } else if ($this->token->value === "*") {
            return AccessHelper::arrayValues($collection);
        }

        return [];
    }

}
 