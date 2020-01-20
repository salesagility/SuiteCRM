<?php

namespace SuiteCRM;

use SuiteCRM\Seeder;
use SuiteCRM\Seeders\UsersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class
        ]);
    }
}
