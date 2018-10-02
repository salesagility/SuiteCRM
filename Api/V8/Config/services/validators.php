<?php

include_once __DIR__ . '/../../../../vendor/symfony/validator/ValidatorBuilder.php';

return [
    'Validation' => function () {
        return (new Symfony\Component\Validator\ValidatorBuilder())->getValidator();
    },
];
