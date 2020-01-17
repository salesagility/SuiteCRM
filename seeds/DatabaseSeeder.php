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
    public static function run()
    {
        parent::call([
            UsersSeeder::class
        ]);
    }
}
