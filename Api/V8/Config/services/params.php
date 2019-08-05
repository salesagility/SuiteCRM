<?php

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\Factory\ValidatorFactory;
use Api\V8\Param;
use Interop\Container\ContainerInterface as Container;
use Api\Core\Loader\CustomLoader;

return CustomLoader::mergeCustomArray([
    Param\ListViewSearchParams::class => function (Container $container) {
        return new Param\ListViewSearchParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\GetUserPreferencesParams::class => function (Container $container) {
        return new Param\GetUserPreferencesParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\ListViewColumnsParams::class => function (Container $container) {
        return new Param\ListViewColumnsParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\GetModuleParams::class => function (Container $container) {
        return new Param\GetModuleParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\GetModulesParams::class => function (Container $container) {
        return new Param\GetModulesParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\CreateModuleParams::class => function (Container $container) {
        return new Param\CreateModuleParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\UpdateModuleParams::class => function (Container $container) {
        return new Param\UpdateModuleParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\DeleteModuleParams::class => function (Container $container) {
        return new Param\DeleteModuleParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\GetRelationshipParams::class => function (Container $container) {
        return new Param\GetRelationshipParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\CreateRelationshipParams::class => function (Container $container) {
        return new Param\CreateRelationshipParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\DeleteRelationshipParams::class => function (Container $container) {
        return new Param\DeleteRelationshipParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
    Param\GetFieldListParams::class => function (Container $container) {
        return new Param\GetFieldListParams(
            $container->get(ValidatorFactory::class),
            $container->get(BeanManager::class)
        );
    },
], basename(__FILE__));
