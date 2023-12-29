<?php
namespace Flow\JSONPath\Filters;

use Flow\JSONPath\AccessHelper;
use Flow\JSONPath\JSONPathException;

class QueryResultFilter extends AbstractFilter
{

    /**
     * @param array $collection
     * @return array
     */
    public function filter($collection)
    {
        $result = [];

        preg_match('/@\.(?<key>\w+)\s*(?<operator>-|\+|\*|\/)\s*(?<numeric>\d+)/', $this->token->value, $matches);

        $matchKey = $matches['key'];

        if (AccessHelper::keyExists($collection, $matchKey, $this->magicIsAllowed)) {
            $value = AccessHelper::getValue($collection, $matchKey, $this->magicIsAllowed);
        } else {
            if ($matches['key'] === 'length') {
                $value = count($collection);
            } else {
                return;
            }
        }

        switch ($matches['operator']) {
            case '+':
                $resultKey = $value + $matches['numeric'];
                break;
            case '*':
                $resultKey = $value * $matches['numeric'];
                break;
            case '-':
                $resultKey = $value - $matches['numeric'];
                break;
            case '/':
                $resultKey = $value / $matches['numeric'];
                break;
            default:
                throw new JSONPathException("Unsupported operator in expression");
                break;
        }

        if (AccessHelper::keyExists($collection, $resultKey, $this->magicIsAllowed)) {
            $result[] = AccessHelper::getValue($collection, $resultKey, $this->magicIsAllowed);
        }

        return $result;
    }
}
 