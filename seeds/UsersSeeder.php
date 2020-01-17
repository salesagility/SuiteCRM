<?php

use SuiteCRM\Seeder;

class UsersSeeder extends Seeder
{
    public function run() {
        $this::factory(User::class);
    }
}
