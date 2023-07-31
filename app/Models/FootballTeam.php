<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class FootballTeam extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leagueScores()
    {
        return $this->hasMany(FootballLeagueToTeam::class, 'team_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matchResults()
    {
        return $this->hasMany(FootballMatchToTeam::class, 'team_id', 'id');
    }

    public function refreshTeamScoreInALeague($leagueId)
    {
        /**
         * @var FootballMatch $match
         * @var FootballMatchToTeam $matchTeamResult
         */
        //this should be in a repository, but Model is good enough
        $goals = 0;
        $matchesPlayed = 0;
        $wins = 0;
        $loses = 0;
        $draws = 0;
        $missedGoals = 0;


        $matchesWithResults = FootballMatch::where('league_id', $leagueId)
            ->whereHas(
                'matchToTeams',
                function ($q) {
                    $q->where('team_id', $this->getKey());
                }
            )
            ->where('finished', true)
            ->with('matchToTeams')
            ->get();

        foreach ($matchesWithResults as $match) {
            $goalsMainTeam = 0;
            $goalsEnemyTeam = 0;
            foreach ($match->matchToTeams as $matchTeamResult) {
                if ($matchTeamResult->team_id == $this->getKey()) {
                    $goalsMainTeam = $matchTeamResult->goals;
                } else {
                    $goalsEnemyTeam = $matchTeamResult->goals;
                }
            }
            $goals += $goalsMainTeam;
            $missedGoals += $goalsEnemyTeam;

            $winner = $goalsEnemyTeam <=> $goalsMainTeam;
            if ($winner < 0) {
                $wins++;
            } elseif ($winner == 0) {
                $draws++;
            } else {
                $loses++;
            }
            $matchesPlayed++;
        }

        FootballLeagueToTeam::where('team_id', $this->getKey())
            ->where('league_id', $leagueId)
            ->update([
                'points' => $goals * FootballMatch::POINTS_PER_GOAL,
                'matches_played' => $matchesPlayed,
                'wins' => $wins,
                'loses' => $loses,
                'draws' => $draws,
                'goal_difference' => $goals - $missedGoals
            ]);
    }

}
