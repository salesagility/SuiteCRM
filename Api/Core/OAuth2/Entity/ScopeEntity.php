<?php
namespace Api\Core\OAuth2\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

class ScopeEntity implements ScopeEntityInterface
{
    use EntityTrait;

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return $this->getIdentifier();
    }
}
