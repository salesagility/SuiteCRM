<?php
namespace Api\Core\OAuth2\Repository;

use Api\Core\OAuth2\Entity\UserEntity;
use Api\V8\BeanManager;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var \AuthenticationController
     */
    private $authentication;

    /**
     * @var BeanManager
     */
    private $beanManager;

    /**
     * @param \AuthenticationController $authentication
     * @param BeanManager $beanManager
     */
    public function __construct(\AuthenticationController $authentication, BeanManager $beanManager)
    {
        $this->authentication = $authentication;
        $this->beanManager = $beanManager;
    }

    /**
     * @inheritdoc
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $this->authentication->login($username, $password, ['passwordEncrypted' => false]);

        if (!$this->authentication->sessionAuthenticate()) {
            return null;
        }

        /** @var \User $user */
        $user = $this->beanManager->newBeanSafe('Users');
        $userEntity = new UserEntity();
        $userEntity->setIdentifier($user->retrieve_user_id($username));

        return $userEntity;
    }
}
