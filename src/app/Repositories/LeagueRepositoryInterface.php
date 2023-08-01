<?php

namespace App\Repositories;

use App\Models\League;

interface LeagueRepositoryInterface
{

    public function calculateTheOddsOfWinningForTheTeams(League $league): array;

    public function generateMatchesForTheLeague(League $league): void;
}
