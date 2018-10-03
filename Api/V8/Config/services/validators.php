<?php

use Api\Core\Loader\CustomLoader;

include_once __DIR__ . '/../../../../vendor/symfony/validator/ValidatorBuilder.php';

return CustomLoader::mergeCustomArray([
    'Validation' => function () {
        return (new Symfony\Component\Validator\ValidatorBuilder())->getValidator();
    },
], basename(__FILE__));
