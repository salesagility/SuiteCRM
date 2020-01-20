<?php

namespace SuiteCRM\Factories;

use \User;
use \SuiteCRM\BaseFactory;
use BeanFactory;

class UserFactory extends BaseFactory {
    public $defaultProps;

    public function __construct() {
        parent::__construct();

        $this->defaultProps = [
            'user_name' => $this->faker->name(),
        ];
    }

    /**
     * @param mixed[] $propertiesArray
     * @return User
     */
    public function define($propertiesArray = []) {
        $user = BeanFactory::newBean('User');
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
