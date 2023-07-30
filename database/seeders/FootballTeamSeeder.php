<?php

namespace Database\Seeders;

use App\Models\FootballTeam;
use Illuminate\Database\Seeder;

class FootballTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //list is from https://www.premierleague.com/clubs
        $teams = [
            'Arsenal',
            'Aston Villa',
            'Barnsley',
            'Birmingham City',
            'Blackburn Rovers',
            'Blackpool',
            'Bolton Wanderers',
            'Bournemouth',
            'Bradford City',
            'Brentford',
            'Brighton & Hove Albion',
            'Burnley',
            'Cardiff City',
            'Charlton Athletic',
            'Chelsea',
            'Coventry City',
            'Crystal Palace',
            'Derby County',
            'Everton',
            'Fulham',
            'Huddersfield Town',
            'Hull City',
            'Ipswich Town',
            'Leeds United',
            'Leicester City',
            'Liverpool',
            'Luton Town',
            'Manchester City',
            'Manchester United',
            'Middlesbrough',
            'Newcastle United',
            'Norwich City',
            'Nottingham Forest',
            'Oldham Athletic',
            'Portsmouth',
            'Queens Park Rangers',
            'Reading',
            'Sheffield United',
            'Sheffield Wednesday',
            'Southampton',
            'Stoke City',
            'Sunderland',
            'Swansea City',
            'Swindon Town',
            'Tottenham Hotspur',
            'Watford',
            'West Bromwich Albion',
            'West Ham United',
            'Wigan Athletic',
            'Wimbledon',
            'Wolverhampton Wanderers'
        ];
        $randomTeams = array_rand($teams, 4);
        foreach ($randomTeams as $teamNameKey) {
            FootballTeam::create(['name' => $teams[$teamNameKey]]);
        }
    }
}
