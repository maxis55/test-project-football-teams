<?php

namespace App\Listeners;

use App\Events\LeagueCreated;
use App\Models\FootballMatch;
use App\Models\FootballTeam;

class CreateLeagueMatchesListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LeagueCreated $event): void
    {
        $league = $event->league;

        $teams = FootballTeam::all();
        foreach ($teams as $team) {
            /**
             * @var FootballMatch $match
             */
            foreach ($teams as $opponentTeam) {
                if ($opponentTeam->getKey() == $team->getKey()) {
                    continue;
                }
                $match = $league->matches()->create();
                $match->matchToTeams()->create(['team_id' => $team->getKey(), 'is_team_stadium_owner' => true]);
                $match->matchToTeams()->create(['team_id' => $opponentTeam->getKey(), 'is_team_stadium_owner' => false]);
            }
        }
    }
}
