<?php

use Api\Core\OAuth2\Repository\AccessTokenRepository;
use Api\Core\OAuth2\Repository\ClientRepository;
use Api\Core\OAuth2\Repository\RefreshTokenRepository;
use Api\Core\OAuth2\Repository\ScopeRepository;
use Api\Core\OAuth2\Repository\UserRepository;
use Api\V8\BeanManager;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use Interop\Container\ContainerInterface as Container;
use League\OAuth2\Server\ResourceServer;

return [
    ClientRepository::class => function (Container $container) {
        return new ClientRepository(
            $container->get(BeanManager::class)
        );
    },
    AccessTokenRepository::class => function (Container $container) {
        return new AccessTokenRepository(
            $container->get(BeanManager::class)
        );
    },
    ScopeRepository::class => function () {
        return new ScopeRepository();
    },
    UserRepository::class => function (Container $container) {
        return new UserRepository(
            $container->get(\AuthenticationController::class),
            $container->get(BeanManager::class)
        );
    },
    RefreshTokenRepository::class => function (Container $container) {
        return new RefreshTokenRepository(
            $container->get(BeanManager::class)
        );
    },
    AuthorizationServer::class => function (Container $container) {
        $server = new AuthorizationServer(
            $container->get(ClientRepository::class),
            $container->get(AccessTokenRepository::class),
            $container->get(ScopeRepository::class),
            'file://' . __DIR__ . '/../../../Core/OAuth2/private.key',
            'file://' . __DIR__ . '/../../../Core/OAuth2/public.key'
        );

        $grant = new PasswordGrant(
            $container->get(UserRepository::class),
            $container->get(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(new \DateInterval('P1M'));

        $server->enableGrantType(
            $grant,
            new \DateInterval('PT1H')
        );

        return $server;
    },
    ResourceServer::class => function (Container $container) {
        return new ResourceServer(
            $container->get(AccessTokenRepository::class),
            'file://' . __DIR__ . '/../../../Core/OAuth2/public.key'
        );
    },
];
