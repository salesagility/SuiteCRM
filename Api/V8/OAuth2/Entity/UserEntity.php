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
     * UserEntity constructor.
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @inheritdoc
     * Returns the registered identifier (as a string).
     * @return string|string[]
     */
	public function getIdentifier()
	{
		return $this->id;
	}
}
