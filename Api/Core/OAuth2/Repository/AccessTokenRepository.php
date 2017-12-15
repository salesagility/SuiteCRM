<?php
namespace Api\Core\OAuth2\Repository;

use Api\Core\OAuth2\Entity\AccessTokenEntity;
use Api\V8\BeanManager;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
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
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);

        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }

        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }

    /**
     * @inheritdoc
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $token = $this->beanManager->newBeanSafe('OAuth2Tokens');
        $token->access_token = $accessTokenEntity->getIdentifier();
        $token->access_token_expires = $accessTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s');
        $token->client = $accessTokenEntity->getClient()->getIdentifier();
        $token->save();
    }

    /**
     * @inheritdoc
     */
    public function revokeAccessToken($tokenId)
    {
        // TODO: Implement revokeAccessToken() method.
    }

    /**
     * @inheritdoc
     */
    public function isAccessTokenRevoked($tokenId)
    {
        /** @var \OAuth2Tokens $token */
        $token = $this->beanManager->newBeanSafe('OAuth2Tokens');
        $token->retrieve_by_string_fields(
            ['access_token' => $tokenId]
        );

        if ($token->id === null) {
            throw new \DomainException('Access token not found');
        }

        if (new \DateTime() > new \DateTime($token->access_token_expires)) {
            return true;
        }

        return false;
    }
}
