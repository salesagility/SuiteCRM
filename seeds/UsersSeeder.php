<?php

namespace SuiteCRM\Seeders;

use SuiteCRM\Seeder;
use SuiteCRM\Factories\UserFactory;

class UsersSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run() {
        $factory = new UserFactory();
        $factory->define();
    }
}
