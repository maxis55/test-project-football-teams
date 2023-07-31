<?php

namespace App\Repositories;

use App\DTO\TeamOddsDTO;
use App\Models\FootballMatch;
use App\Models\FootballTeam;
use App\Models\League;

class LeagueRepository implements LeagueRepositoryInterface
{

    public function calculateTheOddsOfWinningForTheTeams(League $league): array
    {
        if (!$league->relationLoaded('teamResultsInALeague.team')) {
            $league
                ->load('teamResultsInALeague.team');
        }

        $teamsAndOdds = [];

        if ($league->teamResultsInALeague) {
            $amountOfTeams = $league->teamResultsInALeague->count();
            //each team plays each opponent team twice, so its (n-1)*2
            $maxMatchesPerTeam = 2 * ($amountOfTeams - 1);
            $currLeader = $league->teamResultsInALeague->sortByDesc('points')->first();

            //on average there are 3 goals per match, but we coded MAX possible is 6, so lets go with that
            $theoreticalMaximumPointsPerMatch = FootballMatch::THEOR_MAX_GOALS_PER_MATCH * FootballMatch::POINTS_PER_GOAL;

            $teamWithAChance = [];
            $totalBetweenTeamsWithAChance = 0;
            foreach ($league->teamResultsInALeague as $teamResult) {
                $matchesLeft = $maxMatchesPerTeam - $teamResult->matches_played;
                // >= because curr team could be the leader, or it could be a draw
                $possibleToCatchUpToTheLeader = ($matchesLeft * $theoreticalMaximumPointsPerMatch >= $currLeader->points) || $teamResult->team_id == $currLeader->team_id;
                if ($possibleToCatchUpToTheLeader) {
                    $totalBetweenTeamsWithAChance += $teamResult->points;
                    $teamWithAChance[] = $teamResult;
                } else {
                    $teamsAndOdds[] = new TeamOddsDTO($teamResult->team->name, 0);
                }
            }

            foreach ($teamWithAChance as $teamResult) {
                $odds = $totalBetweenTeamsWithAChance ? round($teamResult->points * 100 / $totalBetweenTeamsWithAChance,
                    2) : '?';
                $teamsAndOdds[] = new TeamOddsDTO($teamResult->team->name, $odds);
            }
        }

        return $teamsAndOdds;
    }


    public function generateMatchesForTheLeague(League $league): void
    {
        $teams = FootballTeam::all();
        $week = 1;
        foreach ($teams as $team) {
            /**
             * @var FootballMatch $match
             */
            foreach ($teams as $opponentTeam) {
                if ($opponentTeam->getKey() == $team->getKey()) {
                    continue;
                }
                $match = $league->matches()->create(['name' => 'Week '.$week++.' of League '.$league->getKey()]);
                $match->matchToTeams()->create(['team_id' => $team->getKey(), 'is_team_stadium_owner' => true]);
                $match->matchToTeams()->create([
                    'team_id' => $opponentTeam->getKey(),
                    'is_team_stadium_owner' => false
                ]);
            }

            $league->teamResultsInALeague()
                ->create(['team_id' => $team->getKey()]);
        }
    }
}
