<?php
namespace Api\Core\OAuth2\Repository;

use Api\Core\OAuth2\Entity\ClientEntity;
use Api\V8\BeanManager;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var BeanManager
     */
    private $beanManager;

    /**
     * @param BeanManager $beanManager
     */
    public function __construct(BeanManager $beanManager)
    {
        $this->beanManager = $beanManager;
    }

    /**
     * @inheritdoc
     */
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        /** @var \OAuth2Clients $client */
        $client = $this->beanManager->getBeanSafe('OAuth2Clients', $clientIdentifier);

        if ($mustValidateSecret === true
            && (bool)$client->is_confidential === true
            && password_verify($clientSecret, $client->secret) === false
        ) {
            return null;
        }

        $clientEntity = new ClientEntity();
        $clientEntity->setIdentifier($clientIdentifier);
        $clientEntity->setName($client->name);
        $clientEntity->setRedirectUri($client->redirect_uri ?? '');

        return $clientEntity;
    }
}