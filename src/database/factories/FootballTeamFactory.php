<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FootballTeam>
 */
class FootballTeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //list is from https://www.premierleague.com/clubs
            'name' => fake()->unique()->randomElement([
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
            ]),

        ];
    }
}
