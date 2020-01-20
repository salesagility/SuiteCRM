<?php

namespace SuiteCRM\Factories;

use \User;
use \SuiteCRM\BaseFactory;
use \BeanFactory;

class UserFactory extends BaseFactory {
    public $defaultProps;

    public function __construct() {
        parent::__construct();

        $this->defaultProps = [
            'user_name' => $this->faker->userName(),
            'email1' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName()
        ];
    }

    /**
     * @param mixed[] $propertiesArray An array of property names and their values.
     * @return User
     */
    public function define($propertiesArray = []) {
        $user = BeanFactory::newBean('Users');
        // Merge the default properties and the properties passed when defining
        // the user. Properties passed into the function should always override
        // the defaults.
        $properties = array_merge($propertiesArray, $this->defaultProps);
        // Assign each property in the array to the user bean.
        foreach ($properties as $name => $value) {
            $user->$name = $value;
        }
        $user->save();
        return $user;
    }
}
