<?php

use Api\V8\BeanDecorator\BeanManager;
use Api\V8\Helper;
use Api\V8\JsonApi\Helper as ApiHelper;
use Interop\Container\ContainerInterface as Container;

use Api\Core\Loader\CustomLoader;

return CustomLoader::mergeCustomArray([
    Helper\VarDefHelper::class => function () {
        return new Helper\VarDefHelper();
    },
    ApiHelper\AttributeObjectHelper::class => function (Container $container) {
        return new ApiHelper\AttributeObjectHelper(
            $container->get(BeanManager::class)
        );
    },
    ApiHelper\RelationshipObjectHelper::class => function (Container $container) {
        return new ApiHelper\RelationshipObjectHelper(
            $container->get(Helper\VarDefHelper::class)
        );
    },
    ApiHelper\PaginationObjectHelper::class => function (Container $container) {
        return new ApiHelper\PaginationObjectHelper();
    },
    Helper\ModuleListProvider::class => function (Container $container) {
        return new Helper\ModuleListProvider();
    },
], basename(__FILE__));
