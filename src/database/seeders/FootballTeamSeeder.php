<?php

namespace Database\Seeders;

use App\Models\FootballTeam;
use App\Models\League;
use Illuminate\Database\Seeder;

class FootballTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = FootballTeam::factory(4)->create();

        $leagues = League::factory(1)
            ->create();
    }
}
