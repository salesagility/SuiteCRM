<?php

use Api\Core\Config\ApiConfig;
use Api\V8\BeanDecorator\BeanManager;
use Api\V8\OAuth2\Entity\AccessTokenEntity;
use Api\V8\OAuth2\Entity\ClientEntity;
use Api\V8\OAuth2\Repository\AccessTokenRepository;
use Api\V8\OAuth2\Repository\ClientRepository;
use Api\V8\OAuth2\Repository\RefreshTokenRepository;
use Api\V8\OAuth2\Repository\ScopeRepository;
use Api\V8\OAuth2\Repository\UserRepository;
use Interop\Container\ContainerInterface as Container;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\ResourceServer;
use Api\Core\Loader\CustomLoader;

return CustomLoader::mergeCustomArray([
    AuthorizationServer::class => function (Container $container) {
        // base dir must exist in entryPoint.php
        $baseDir = $GLOBALS['BASE_DIR'];

        $server = new AuthorizationServer(
            new ClientRepository(
                new ClientEntity(),
                $container->get(BeanManager::class)
            ),
            new AccessTokenRepository(
                new AccessTokenEntity(),
                $container->get(BeanManager::class)
            ),
            new ScopeRepository(),
            sprintf('file://%s/%s', $baseDir, ApiConfig::OAUTH2_PRIVATE_KEY),
            sprintf('file://%s/%s', $baseDir, ApiConfig::OAUTH2_PUBLIC_KEY)
        );
        $server->setEncryptionKey(ApiConfig::OAUTH2_ENCRYPTION_KEY);

        // Client credentials grant
        $server->enableGrantType(
            new \League\OAuth2\Server\Grant\ClientCredentialsGrant(),
            new \DateInterval('PT1H')
        );

        // Password credentials grant
        $server->enableGrantType(
            new PasswordGrant(
                new UserRepository($container->get(BeanManager::class)),
                new RefreshTokenRepository($container->get(BeanManager::class))
            ),
            new \DateInterval('PT1H')
        );

        return $server;
    },
    ResourceServer::class => function (Container $container) {
        $baseDir = $GLOBALS['BASE_DIR'];

        return new ResourceServer(
            new AccessTokenRepository(
                new AccessTokenEntity(),
                $container->get(BeanManager::class)
            ),
            sprintf('file://%s/%s', $baseDir, ApiConfig::OAUTH2_PUBLIC_KEY)
        );
    },
], basename(__FILE__));
