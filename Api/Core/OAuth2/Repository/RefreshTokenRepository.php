<?php
namespace Api\Core\OAuth2\Repository;

use Api\Core\OAuth2\Entity\RefreshTokenEntity;
use Api\V8\BeanManager;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
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
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }

    /**
     * @inheritdoc
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        $token = $this->beanManager->newBeanSafe('OAuth2Tokens');
        $token->retrieve_by_string_fields(
            ['access_token' => $refreshTokenEntity->getAccessToken()->getIdentifier()]
        );

        if ($token->id === null) {
            throw new \DomainException('Access token not found');
        }

        $token->refresh_token = $refreshTokenEntity->getIdentifier();
        $token->refresh_token_expires = $refreshTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s');
        $token->save();
    }

    /**
     * @inheritdoc
     */
    public function revokeRefreshToken($tokenId)
    {
        $token = $this->beanManager->newBeanSafe('OAuth2Tokens');
        $token->retrieve_by_string_fields(
            ['refresh_token' => $tokenId]
        );

        if ($token->id === null) {
            throw new \DomainException('Refresh token not found');
        }

        $token->mark_deleted($token->id);
    }

    /**
     * @inheritdoc
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        /** @var \OAuth2Tokens $token */
        $token = $this->beanManager->newBeanSafe('OAuth2Tokens');
        $token->retrieve_by_string_fields(
            ['refresh_token' => $tokenId]
        );

        if ($token->id === null) {
            throw new \DomainException('Refresh token not found');
        }

        if (new \DateTime() > new \DateTime($token->refresh_token_expires)) {
            return true;
        }

        return false;
    }
}
