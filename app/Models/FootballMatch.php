<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $league_id
 * @property boolean $finished
 *
 * @property Collection|FootballMatchToTeam $matchToTeams
 */
class FootballMatch extends Model
{
    use HasFactory;

    protected $fillable = ['finished'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function league()
    {
        return $this->belongsTo(League::class, 'league_id', 'id');
    }

    public function teams()
    {
        return $this->hasManyThrough(
            FootballTeam::class,
            FootballMatchToTeam::class,
            'match_id',
            'id',
            'id',
            'team_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matchToTeams()
    {
        return $this->hasMany(FootballMatchToTeam::class, 'match_id', 'id');
    }

    public function runTheMatch(): void
    {
        $this->load('matchToTeams');

        //https://www.bettingoffers.org.uk/football/what-is-the-average-number-of-goals-scored-per-game-in-football/
        //lets say, 3 goals per match is the average per match
        //then it means over 50% chance of a game having 3 goals
        //for simplicity having more or less is 25%
        //then we can break it down further
        $goals = 3; //default avg
        $firstTeamScoresGoals = 0;
        $secondTeamScoresGoals = 0;
        $rand = rand(0, 100);
        if ($rand < 25) {
            //less than 3
            $goals = rand(0, 2);
        }
        if ($rand > 75) {
            if ($rand > 90) {
                $goals = 6;
            } else {
                $goals = rand(4, 5);
            }
        }
        //bigger than 0
        if ($goals) {
            //it's easier to just decide what % of goals the first team(at home, so has advantage)
            //is going to score
            //rest is for the second team
            $firstTeamScoresPerc = rand(0, 100);
            $firstTeamScoresGoals = round($goals * (100 - $firstTeamScoresPerc) / 100);
            $secondTeamScoresGoals = $goals - $firstTeamScoresGoals;
        }
        $firstTeamMatchRes = $this->matchToTeams->first();
        $secondTeamMatchRes = $this->matchToTeams->last();
        $firstTeamMatchRes->update(['goals' => $firstTeamScoresGoals]);
        $secondTeamMatchRes->update(['goals' => $secondTeamScoresGoals]);
        $this->update(['finished' => true]);
    }

}
