<?php

use \User;
use \SuiteCRM\BaseFactory;
use Faker\Generator as Faker;

class UserFactory extends BaseFactory {
    public function define() {
        self::$factory->define(User::class, function (Faker $faker) {
            return [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail
            ];
        });
    }
}
