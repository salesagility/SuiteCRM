<?php

namespace SuiteCRM;

use SuiteCRM\Seeder;
use SuiteCRM\Seeders\UsersSeeder;
use SuiteCRM\Seeders\AccountsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: Provide a way for custom seeders to be added to this array
        // by end-users.
        $seeders = [
            UsersSeeder::class,
            AccountsSeeder::class
        ];
        $this->call($seeders);
    }
}
