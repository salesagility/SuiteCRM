<?php

namespace SuiteCRM\Factories;

use \User;
use \SuiteCRM\BaseFactory;

class UserFactory extends BaseFactory {
    public function __construct() {
        parent::__construct();

        $this->defaultProps = function() {
            return [
                'user_name' => $this->faker->unique()->userName(),
                'email1' => $this->faker->unique()->safeEmail(),
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'user_hash' => User::getPasswordHash($this->faker->password())
            ];
        };
    }

    /**
     * @param integer $numberOfInstances The number of instances of this bean to create.
     * @param mixed[] $propertiesArray An array of property names and their values.
     * @return User[] An array of user beans.
     */
    public function create($numberOfInstances = 1, $propertiesArray = []) {
        return parent::createSeedBeans('Users', $numberOfInstances, $propertiesArray);
    }
}
