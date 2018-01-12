<?php
namespace Api\Core\OAuth2\Repository;

use Api\Core\OAuth2\Entity\ScopeEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        // we would move scopes into config
        $scopes = [
            'administrator' => [
                'description' => 'access to the administrative operations',
            ],
        ];

        if (!array_key_exists($identifier, $scopes)) {
            return null;
        }

        $scope = new ScopeEntity();
        $scope->setIdentifier($identifier);

        return $scope;
    }

    /**
     * @inheritdoc
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        // we just return scopes for now
        return $scopes;
    }
}
