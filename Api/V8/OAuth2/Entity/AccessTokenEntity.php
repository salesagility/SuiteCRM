<?php
namespace Api\V8\OAuth2\Entity;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * Class AccessTokenEntity
 * @package Api\V8\OAuth2\Entity
 */
class AccessTokenEntity implements AccessTokenEntityInterface
{
    use AccessTokenTrait, TokenEntityTrait, EntityTrait;
}
