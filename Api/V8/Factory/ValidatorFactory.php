<?php
namespace Api\V8\Factory;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorFactory
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array|\Symfony\Component\Validator\Constraint[] $constraints
     *
     * @return callable
     */
    public function createClosure(array $constraints)
    {
        return function ($value) use ($constraints) {
            if ($value === null) {
                return true;
            }
            $violations = $this->validator->validate($value, $constraints);

            return !$violations->count();
        };
    }
}
