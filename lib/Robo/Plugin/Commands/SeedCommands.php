<?php

namespace SuiteCRM\Robo\Plugin\Commands;

use SuiteCRM\DatabaseSeeder;
use SuiteCRM\Robo\Traits\RoboTrait;
use Robo\Task\Base\loadTasks;

class SeedCommands extends \Robo\Tasks
{
    use loadTasks;
    use RoboTrait;

    /**
     * Seed the database with fake data.
     * 
     * @command db:seed
     */
    public function dbSeed() {
        $this->say('Seeding the database...');
        $seeder = new DatabaseSeeder();
        $seeder->run();
        $this->say('Seeding complete.');
    }
}
