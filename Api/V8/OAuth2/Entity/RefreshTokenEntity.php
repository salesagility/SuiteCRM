<?php
namespace Api\V8\OAuth2\Entity;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

/**
 * Class RefreshTokenEntity
 * @package Api\V8\OAuth2\Entity
 */
class RefreshTokenEntity implements RefreshTokenEntityInterface
{
    use RefreshTokenTrait, EntityTrait;
}
