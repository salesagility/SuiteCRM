<?php

namespace SuiteCRM\Seeders;

use SuiteCRM\Seeder;
use SuiteCRM\Factories\AccountFactory;

class AccountsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run() {
        $factory = new AccountFactory();
        $factory->define();
    }
}
