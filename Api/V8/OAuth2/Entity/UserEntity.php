<?php
namespace Api\V8\OAuth2\Entity;

use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * Class UserEntity
 * @package Api\V8\OAuth2\Entity
 */
class UserEntity implements UserEntityInterface
{
    /**
     * @var $userId
     */
    private $userId;

    /**
     * @param string $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @inheritdoc
     * Returns the registered identifier (as a string).
     * @return string|string[]
     */
	public function getIdentifier()
	{
	    return $this->userId;
	}
}
