<?php

use Symfony\Component\Validator\ValidatorBuilder;

return [
    'Validation' => function () {
        return (new ValidatorBuilder())->getValidator();
    },
];
