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
        // TODO: Implement revokeRefreshToken() method.
    }

    /**
     * @inheritdoc
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        // TODO: Implement isRefreshTokenRevoked() method.
    }
}
