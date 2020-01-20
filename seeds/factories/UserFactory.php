<?php

namespace SuiteCRM\Factories;

use \User;
use \SuiteCRM\BaseFactory;

class UserFactory extends BaseFactory {
    public function __construct() {
        parent::__construct();

        $this->defaultProps = [
            'user_name' => $this->faker->userName(),
            'email1' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'user_hash' => User::getPasswordHash($this->faker->password)
        ];
    }

    /**
     * @param mixed[] $propertiesArray An array of property names and their values.
     * @return User
     */
    public function define($propertiesArray = []) {
        $user = parent::createSeedBean('Users', $propertiesArray);
        $user->save();

        return $user;
    }
}
