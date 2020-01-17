<?php

namespace SuiteCRM\Seeders;

use SuiteCRM\Seeder;
use SuiteCRM\Factories\UserFactory;
use Faker\Generator as Faker;

class UsersSeeder extends Seeder
{
    /**
     * @return void
     */
    public static function run() {
        $factory = new UserFactory();
        $user = $factory->define();
        $user->save();
    }
}
