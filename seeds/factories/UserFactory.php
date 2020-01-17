<?php

namespace SuiteCRM\Factories;

use \User;
use \SuiteCRM\BaseFactory;
use BeanFactory;

class UserFactory extends BaseFactory {
    /**
     * @return User
     */
    public function define() {
        $user = BeanFactory::newBean('User');
        $user->name = $this->faker->name();
        $user->email = $this->faker->unique()->safeEmail();
        $user->save();
        return $user;
    }
}
