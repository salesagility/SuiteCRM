<?php
namespace Api\V8\OAuth2\Entity;

use League\OAuth2\Server\Entities\UserEntityInterface;

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
     * Returns the registered identifier (as a string).
     *
     * @return string|string[]
     */
	public function getIdentifier()
	{
		return $this->id;
	}
}
