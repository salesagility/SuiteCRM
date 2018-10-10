<?php
namespace Api\V8\OAuth2\Entity;

use League\OAuth2\Server\Entities\UserEntityInterface;

class UserEntity implements UserEntityInterface
{
    /**
     * @inheritdoc
     */
    public function getIdentifier()
    {
        // we skip this right now, since we are not using scopes atm
        return true;
    }
}
